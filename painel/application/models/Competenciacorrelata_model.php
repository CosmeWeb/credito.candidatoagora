<?php
/***********************************************************************
 * Module:  /models/Competenciacorrelata_model.PHP
 * Author:  Host-up
 * Date:	24/08/2020 20:38:09
 * Purpose: Definição da Classe Competenciacorrelata_model
 * Instancias: $this->load->model('Competenciacorrelata_model', 'competenciacorrelata');
 * Objeto: $competenciacorrelata = $this->competenciacorrelata->GetInstancia($dados);
 ***********************************************************************/
if (!class_exists('Competenciacorrelata_model'))
{
	class Competenciacorrelata_model extends MY_Model
	{
		################################################################################################################
		public function __construct( $dados = false)
		{
			try
			{
				$this->Tabela = "competenciacorrelata";
				$this->PrimaryKey = "idcompetenciacorrelata";
				parent::__construct($dados);
			}
			catch( Exception $e )
			{
				throw new Exception( $e );
			}
		}
		################################################################################################################
		public function Ajustar($salvar = false)
		{
			if($salvar)
			{

			}
			else
			{

			}
		}
		################################################################################################################
		public function GerarOpcoesIdvaga($value = "0", $texto = "", $default = "0")
		{
			if(empty($texto))
				$texto = __("-- Selecione --");
			$primeiro = array("valor"=>$default,"texto"=>$texto);
			$sql = "SELECT idvaga AS 'id', vaga AS 'texto' FROM vaga ORDER BY texto ASC";
			return $this->GeraOpcoesSql($value, $sql, "id", "texto", $primeiro);
		}
		################################################################################################################
		public function GerarOpcoesIdcompetencia($value = "0", $texto = "", $default = "0")
		{
			if(empty($texto))
				$texto = __("-- Selecione --");
			$primeiro = array("valor"=>$default,"texto"=>$texto);
			$sql = "SELECT idcompetencia AS 'id', competencia AS 'texto' FROM competencia ORDER BY texto ASC";
			return $this->GeraOpcoesSql($value, $sql, "id", "texto", $primeiro);
		}
		################################################################################################################
		public function GetSqlLista()
		{
			$retorno = "";
			try
			{
				return "SELECT * FROM competenciacorrelata ";
			}
			catch( Exception $e )
			{
				throw new Exception( $e );
				return $retorno;
			}
		}
		################################################################################################################
		public function GetSqlTotalLista()
		{
			$retorno = "";
			try
			{
				return "SELECT COUNT(*) AS CONT FROM competenciacorrelata ";
			}
			catch( Exception $e )
			{
				throw new Exception( $e );
				return $retorno;
			}
		}
		#######################################################################################################
		public function Filtro($semOrder = false)
		{
			$filtro = "";
			$buscar = GetFiltro("buscar");
			if(!empty($buscar))
			{
				$filtro .= " AND buscar LIKE '%{$buscar}%'";
			}
			
			$idcompetenciacorrelata = GetFiltro("idcompetenciacorrelata");
			if(!empty($idcompetenciacorrelata))
			{
				$filtro .= " AND idcompetenciacorrelata = '{$idcompetenciacorrelata}'";
			}
			$idvaga = GetFiltro("idvaga");
			if(!empty($idvaga))
			{
				$filtro .= " AND idvaga = '{$idvaga}'";
			}
			$idcompetencia = GetFiltro("idcompetencia");
			if(!empty($idcompetencia))
			{
				$filtro .= " AND idcompetencia = '{$idcompetencia}'";
			}
			if(!empty($filtro))
			{
				$filtro  = substr($filtro, 4);
			}
			if($semOrder)
			{
				return $filtro;
			}
			$ordem = array('idcompetenciacorrelata', 'idvaga', 'idcompetencia', 'idcompetenciacorrelata');
			$start = Get("start", 0);
			$length = Get("length", 10);
			$order = Get("order", 0,0);
			if(!empty($order['column']))
				$coluna = $order['column'];
			else
				$coluna = 0;
			if(!empty($order['dir']))
				$dir = $order['dir'];
			else
				$dir = 'asc';
			if(!empty($ordem[$coluna]))
			{
				$order = $ordem[$coluna];
				$filtro .= " ORDER BY {$order} {$dir}";
			}
			if($length >= 0)
			{
				$filtro .= " LIMIT {$start}, {$length}";
			}
			return $filtro;
		}
		################################################################################################################
		public function Importar($posicao = 0, $limite = 0, $file = "")
		{
			$retorno = false;
			
			if(empty($file))
				return $retorno;
			
			$lista = $this->LerRows($posicao, $limite, $file);
			if(empty($lista))
				return $retorno;
			$obj = GetModelo("competenciacorrelata");
			if(empty($obj))
				return $retorno;
			foreach ($lista as $key=>$linha)
			{
				$obj->SalvarListaCompetenciacorrelata($linha);
			}
			return true;
		}
		################################################################################################################
		public function SalvarListaCompetenciacorrelata($dados = false)
		{
			if(empty($dados))
				return;
			$competenciacorrelata = self::GetDadosChave($dados, array('competenciacorrelata','competenciacorrelata'));
			if(empty($competenciacorrelata))
				return;
			$filtro = "competenciacorrelata = '{$competenciacorrelata}'";
			$obj = $this->FiltroObjeto($filtro);
			if(empty($obj))
			{
				$obj = $this->GetInstancia();
				$obj->competenciacorrelata = $competenciacorrelata;
			}
			$obj->Ajustar(true);
			$obj->Salvar();
			return;
		}
		################################################################################################################
		public function ExportarCompetenciacorrelata()
		{
			$posicao = Get("posicao", 0);
			$total = Get("total", 0);
			$file = Get("file");
			$limite = 500;
			$obj = GetModelo('competenciacorrelata');
			
			if(empty($total))
			{
				$sqlTotal = $obj->GetSqlTotalLista();
				$filtro = $obj->Filtro(true);
				$total = $obj->TotalRegistro($filtro, $sqlTotal, false);
				if(empty($total))
				{
					$dados['sucesso'] = false;
					$dados['erro'] = __("Nenhum competenciacorrelata foi encontrado no momento.");
				}
				else
				{
					$dados['sucesso'] = true;
					$dados['titulo'] = __("Processando Exportação");
					$dados['mensagem'] = __("Exportação de competenciacorrelata está processando.");
					$dados['url'] = "";
					$dados['finalizado'] = false;
					$dados['file'] = $file;
					$dados['posicao'] = $posicao;
					$dados['total'] = $total;
				}
				return $dados;
			}
			$sql = $obj->GetSqlLista();
			$filtro = $obj->Filtro(true);
			$filtro .= " ORDER BY competenciacorrelata ASC";
			$filtro .= " LIMIT {$posicao},{$limite}";
			$objs = $obj->FiltroObjetos($filtro, $sql);
			if($objs)
			{
				if(empty($file))
					$file = $obj->GetNomeFile();
				$data = array(
					"file"=> $file,
					"lista"=>$objs,
					"posicao"=>$posicao,
					"total"=>$total,
					"html"=>false,
					"campos"=>$obj->GetNomesCampos(),
					"download"=>false,
					"maiusculo"=>false,
					"pasta"=>$obj->GetCaminho()
				);
				Excel($data);
				$posicao += $limite;
				$dados['sucesso'] = true;
				if($posicao >= $total)
				{
					$dados['titulo'] = __("Exportação de competenciacorrelata");
					$dados['mensagem'] = __("Exportação de competenciacorrelata foi finalizada.<br/>O download se iniciará em instantes");
					$dados['url'] = site_url("competenciacorrelata/baixarcompetenciacorrelata/{$file}");
					$dados['finalizado'] = true;
					$dados['file'] = $file;
					$dados['posicao'] = $posicao;
					$dados['total'] = $total;
				}
				else
				{
					$dados['titulo'] = __("Exportação de competenciacorrelata");
					$dados['mensagem'] = __("Exportação de competenciacorrelata está processando.");
					$dados['url'] = "";
					$dados['finalizado'] = false;
					$dados['file'] = $file;
					$dados['posicao'] = $posicao;
					$dados['total'] = $total;
				}
			}
			else
			{
				$dados['sucesso'] = false;
				$dados['erro'] = __("Nenhum competenciacorrelata foi encontrado.");
			}
			//XDebug($dados, $this);
			return $dados;
		}
		################################################################################################################
		public function GetNomeFile()
		{
			$retorno = "exportacaocompetenciacorrelata_".date("Y-m-d_H-i-s").".xls";
			try
			{
				return $retorno;
			}
			catch( Exception $e )
			{
				throw new Exception( $e );
				return $retorno;
			}
		}
		################################################################################################################
		public function GetNomesCampos()
		{
			$campos = array("ID"=>"idcompetenciacorrelata","competenciacorrelata"=>"competenciacorrelata");
			return $campos;
		}
		################################################################################################################
		public function GetCaminho($file = "")
		{
			return $this->SetDominio($file);
		}
		################################################################################################################
		public function CarregarMaisCompetencias()
		{
			$posicao = Get("posicao", 0);
			$total = Get("total", 0);
			$idvaga = Get("idvaga", 0);
			$idarea = Get("idarea", 0);
			$somarcado = Get("somarcado", 0);
			if(empty($total))
			{
				$filtro = "";
				if(empty($somarcado))
				{
					if(!empty($idarea))
						$filtro = " WHERE CT.idarea = '{$idarea}'";
					$sql = "SELECT COUNT(DISTINCT CT.idcompetencia) AS CONT FROM competencia CT {$filtro}";
				}
				else
				{
					if(!empty($idarea))
						$filtro = " AND CT.idarea = '{$idarea}'";
					$sql = "SELECT COUNT(DISTINCT CT.idcompetencia) AS CONT FROM competencia CT INNER JOIN competenciacorrelata CC ON(CC.idcompetencia = CT.idcompetencia) WHERE CC.idvaga = '{$idvaga}'{$filtro}";
				}
				$total = $this->TotalRegistro(false, $sql);
				if(empty($total))
				{
					$dados['sucesso'] = false;
					if(empty($somarcado))
						$dados['erro'] = __("Nenhuma competência está disponível no momento.");
					else
						$dados['erro'] = __("Nenhuma competência selecionada está disponível no momento.");
					$dados['titulo'] = __("Erro");
					return $dados;
				}
			}
			$limiterows = 100;
			$limite = $total - $posicao;
			$filtro = "";
			if(empty($somarcado))
			{
				if(!empty($idarea))
					$filtro = " WHERE CT.idarea = '{$idarea}'";
				$sql = "SELECT DISTINCT IF(ISNULL(CC.idcompetenciacorrelata), 0, CC.idcompetenciacorrelata) AS idcompetenciacorrelata, CT.idcompetencia, CT.idarea, CT.competencia, IF(ISNULL(CC.idcompetenciacorrelata),'', 'checked') AS 'checked' FROM competencia CT LEFT JOIN competenciacorrelata CC ON(CC.idcompetencia = CT.idcompetencia AND  CC.idvaga = '{$idvaga}'){$filtro} ORDER BY CT.competencia ASC LIMIT {$posicao}, {$limiterows}";
			}
			else
			{
				if(!empty($idarea))
					$filtro = " AND CT.idarea = '{$idarea}'";
				$sql = "SELECT DISTINCT CC.idcompetenciacorrelata, CT.idcompetencia, CT.idarea, CT.competencia FROM competencia CT INNER JOIN competenciacorrelata CC ON(CC.idcompetencia = CT.idcompetencia) WHERE CC.idvaga = '{$idvaga}'{$filtro} ORDER BY CT.competencia ASC LIMIT {$posicao}, {$limiterows}";
			}
			$rows = $this->GetRows(false, $sql);
			if(empty($rows))
			{
				$dados['sucesso'] = true;
				$dados['lista'] = false;
				$dados['mensagem'] = __("Lista de competências foi encontrada com sucesso.");
				$dados['titulo'] = __("Sucesso");				
				$dados['finalizar'] = true;
				$dados['total'] = $total;
				$dados['posicao'] = $posicao + $limiterows;
				return $dados;
			}
			if($limite <= $limiterows)
			{
				$dados[ 'sucesso' ] = true;
				$dados['lista'] = $rows;
				$dados['mensagem'] = __("Lista de competências foi encontrada com sucesso.");
				$dados['titulo'] = __("Sucesso");
				$dados['finalizar'] = true;
				$dados['total'] = $total;
				$dados['posicao'] = $posicao + $limite;
			}
			else
			{
				$dados[ 'sucesso' ] = true;
				$dados['lista'] = $rows;
				$dados['mensagem'] = __("Lista de competências foi encontrada com sucesso.");
				$dados['titulo'] = __("Sucesso");
				$dados['finalizar'] = false;
				$dados['total'] = $total;
				$dados['posicao'] = $posicao + $limiterows;
			}
			return $dados;
		}
		################################################################################################################
		public function SalvarCompetencia( $idcompetenciacorrelata = 0, $idcompetencia = 0, $idvaga = 0)
		{
			try
			{
				if(empty($idcompetencia))
					return;
				if(empty($idvaga))
					return;
				$filtro = "idcompetencia = '{$idcompetencia}' AND idvaga = '{$idvaga}'";
				if($this->Existe($filtro))
				{
					return;
				}
				$this->idcompetenciacorrelata = $idcompetenciacorrelata;
				$this->idcompetencia = $idcompetencia;
				$this->idvaga = $idvaga;
				$this->Ajustar(true);
				$this->Salvar();
			}
			catch( Exception $e )
			{
				throw new Exception( $e );
			}
		}
		################################################################################################################
		public function __destruct()
		{
			unset($this->dados, $this->Tabela, $this->PrimaryKey);
		}
	}
}
?>