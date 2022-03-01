<?php
/***********************************************************************
 * Module:  /models/Tamanho_model.PHP
 * Author:  Host-up
 * Date:	06/04/2020 20:12:17
 * Purpose: Definição da Classe Tamanho_model
 * Instancias: $this->load->model('Tamanho_model', 'tamanho');
 * Objeto: $tamanho = $this->tamanho->GetInstancia($dados);
 ***********************************************************************/
if (!class_exists('Tamanho_model'))
{
	class Tamanho_model extends MY_Model
	{
		################################################################################################################
		public function __construct( $dados = false)
		{
			try
			{
				$this->Tabela = "tamanho";
				$this->PrimaryKey = "idtamanho";
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
		public function GetSqlLista()
		{
			$retorno = "";
			try
			{
				return "SELECT * FROM tamanho ";
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
				return "SELECT COUNT(*) AS CONT FROM tamanho ";
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
				$filtro .= " AND tamanho LIKE '%{$buscar}%'";
			}
			if(!empty($filtro))
			{
				$filtro  = substr($filtro, 4);
			}
			if($semOrder)
			{
				return $filtro;
			}
			$ordem = array('idtamanho', 'tamanho', 'ordem', 'idtamanho');
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
			$obj = GetModelo("tamanho");
			if(empty($obj))
				return $retorno;
			foreach ($lista as $key=>$linha)
			{
				$obj->SalvarListaTamanho($linha);
			}
			return true;
		}
		################################################################################################################
		public function SalvarListaTamanho($dados = false)
		{
			if(empty($dados))
				return;
			$tamanho = self::GetDadosChave($dados, array('tamanho','Tamanho','TAMANHO'));
			if(empty($tamanho))
				return;
			$ordem = self::GetDadosChave($dados, array('ordem','Ordem','ORDEM'));
			$aux = Escape($tamanho);
			$filtro = "tamanho = '{$aux}'";
			$obj = $this->FiltroObjeto($filtro);
			if(empty($obj))
			{
				$obj = $this->GetInstancia();
				$obj->tamanho = $tamanho;
			}
			$obj->ordem = $ordem;
			$obj->Ajustar(true);
			$obj->Salvar();
			return;
		}
		################################################################################################################
		public function ExportarTamanho()
		{
			$filtro = $this->Filtro(true);
			$filtro .= " ORDER BY tamanho ASC";
			$obj = GetModelo('tamanho');
			$sql = $this->GetSqlLista();
			$objs = $obj->FiltroObjetos($filtro, $sql);
			if($objs)
			{
				$file = $obj->GetNomeFile();
				$data = array(
					"file"=> $file,
					"lista"=>$objs,
					"html"=>true,
					"campos"=>$obj->GetNomesCampos(),
					"download"=>false,
					"pasta"=>$obj->GetCaminho()
				);
				Excel($data);
				$dados['sucesso'] = true;
				$dados['mensagem'] = __("Verificação de tamanho foi finalizado.<br/>O download se iniciará em instantes");
				$dados['url'] = site_url("tamanho/baixartamanho/{$file}");
				$dados['titulo'] = __("Exportação de tamanho");
			}
			else
			{
				$dados['sucesso'] = false;
				$dados['erro'] = __("Nenhum tamanho foi encontrado.");
			}
			return $dados;
		}
		################################################################################################################
		public function GetNomeFile()
		{
			$retorno = "exportacaotamanho_".date("Y-m-d_H-i-s").".xls";
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
			$campos = array("ID"=>"idtamanho","tamanho"=>"tamanho");
			return $campos;
		}
		################################################################################################################
		public function GetCaminho($file = "")
		{
			return $this->SetDominio($file);
		}
		################################################################################################################
		public function LerIdTamanho($palavraschaves = false)
		{
			if(empty($palavraschaves))
			{
				return 0;
			}
			$aux = Escape($palavraschaves);
			$sql = "SELECT idtamanho FROM {$this->Tabela} WHERE tamanho = '{$aux}' LIMIT 1";
			$id = $this->GetSqlCampo($sql,"idtamanho", 0);
			if(empty($id))
			{
				$this->idtamanho = 0;
				$this->tamanho = $palavraschaves;
				$id = $this->Salvar();
				if(empty($id))
				{
					return 0;
				}
			}
			return $id;
		}
		################################################################################################################
		public function lerfiltroTamanhoEmpresas()
		{
			$idcliente = Get("idcliente", 0);
			$idvaga = Get("idvaga", 0);
			$calcular = Get("calcular", 0);
			$posicao = Get("posicao", 0);
			$limite = Get("limite", 10);
			$total = Get("total", 0);

			$rows = false;
			$titulo = __("Erro");
			$mensagem = __("Nenhum tamanho de empresa foi encontrado.");
			
			$filtro = "";
			if(!empty($idcliente))
			{
				if(!E_Cliente($idcliente))
				{
					$dados['sucesso'] = false;
					$dados['erro'] = __("ID do cliente não foi enviado.");
					return $dados;
				}
				$filtro .= " 1 ";
				//$filtro .= " V.idcliente = '{$idcliente}' ";
			}
			else
			{
				$dados['sucesso'] = false;
				$dados['erro'] = __("ID do cliente não foi enviado.");
				return $dados;
			}
			if(!empty($idvaga))
			{
				if(!is_array($idvaga))
					$idvaga = array($idvaga);
				$filtro .= " AND (F.idfavorito IS NULL OR F.tipo = 'Favorito') AND CV.idvaga ".GerarIN($idvaga);
			}
			$filtro .= " AND CG.historico = 'Cargo 1'";
			if(empty($total))
			{
				$sql = "SELECT COUNT(DISTINCT T.idtamanho) AS CONT FROM tamanho T INNER JOIN candidatocargo CG ON(T.idtamanho = CG.idtamanho) INNER JOIN candidatovaga CV ON(CG.idcandidato = CV.idcandidato) INNER JOIN vaga V ON(CV.idvaga = V.idvaga) LEFT JOIN favorito F FORCE INDEX(idxcandidato) ON(CV.idcandidato = F.idcandidato AND F.idvaga = V.idvaga) WHERE {$filtro}";
				$total = $this->TotalRegistro(false, $sql);				
			}
			if(!empty($total))
			{
				if($limite < 0)
					$limite = $total;
				if(empty($calcular))
				{
					$filtro .= " ORDER BY T.ordem ASC, T.tamanho ASC LIMIT {$posicao}, {$limite}";
					$sql = "SELECT DISTINCT T.idtamanho, T.tamanho, '0' AS 'total' FROM tamanho T INNER JOIN candidatocargo CG ON(T.idtamanho = CG.idtamanho) INNER JOIN candidatovaga CV ON(CG.idcandidato = CV.idcandidato) INNER JOIN vaga V ON(CV.idvaga = V.idvaga) LEFT JOIN favorito F FORCE INDEX(idxcandidato) ON(CV.idcandidato = F.idcandidato AND F.idvaga = V.idvaga) WHERE {$filtro}";
				}
				else
				{
					$filtro .= " GROUP BY T.idtamanho, T.tamanho ORDER BY T.ordem ASC, T.tamanho ASC LIMIT {$posicao}, {$limite}";
					$sql = "SELECT T.idtamanho, T.tamanho, COUNT(DISTINCT CV.idcandidato) AS 'total' FROM tamanho T INNER JOIN candidatocargo CG ON(T.idtamanho = CG.idtamanho) INNER JOIN candidatovaga CV ON(CG.idcandidato = CV.idcandidato) INNER JOIN vaga V ON(CV.idvaga = V.idvaga) LEFT JOIN favorito F FORCE INDEX(idxcandidato) ON(CV.idcandidato = F.idcandidato AND F.idvaga = V.idvaga) WHERE {$filtro}";
				}
				$rows = $this->GetRows(false, $sql);
				if(!empty($rows))
				{
					$rows = array_map(array($this,'Map'), $rows);
					$titulo = __("Sucesso");
					$mensagem = __("Lista de nacionalidade foi encontrada com sucesso.");
				}
			}
			$novaposicao = $posicao + $limite;
			if($novaposicao >= $total)
				$finalizado = true;
			else
				$finalizado = false;
			$dados['sucesso'] = true;
			$dados['lista'] = $rows;
			$dados['mensagem'] = $mensagem;
			$dados['titulo'] = $titulo;
			$dados['idcliente'] = intval($idcliente);
			if(empty($idvaga))
				$dados['idvaga'] = null;
			else
				$dados['idvaga'] = $idvaga;
			$dados['posicao'] = $novaposicao;
			$dados['limite'] = intval($limite);
			$dados['total'] = intval($total);
			$dados['finalizado'] = $finalizado;
			return $dados;
		}
		################################################################################################################
		public static function Map($row = false)
		{
			$row['idtamanho'] = intval($row['idtamanho']);
			$row['total'] = intval($row['total']);
			return $row;
		}			
		################################################################################################################
		public function __destruct()
		{
			unset($this->dados, $this->Tabela, $this->PrimaryKey);
		}
	}
}
?>