<?php
/***********************************************************************
 * Module:  /models/Pais_model.PHP
 * Author:  Host-up
 * Date:	24/03/2020 00:23:20
 * Purpose: Definição da Classe Pais_model
 * Instancias: $this->load->model('Pais_model', 'pais');
 * Objeto: $pais = $this->pais->GetInstancia($dados);
 ***********************************************************************/
if (!class_exists('Pais_model'))
{
	class Pais_model extends MY_Model
	{
		################################################################################################################
		public function __construct( $dados = false)
		{
			try
			{
				$this->Tabela = "pais";
				$this->PrimaryKey = "idpais";
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
				$this->pais = ucwords(strtolower($this->pais));
				$this->sigla = strtoupper($this->sigla);
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
				return "SELECT * FROM pais ";
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
				return "SELECT COUNT(*) AS CONT FROM pais ";
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
				$filtro .= " AND (pais LIKE '%{$buscar}%' OR sigla LIKE '%{$buscar}%')";
			}
			if(!empty($filtro))
			{
				$filtro  = substr($filtro, 4);
			}
			if($semOrder)
			{
				return $filtro;
			}
			$ordem = array('idpais', 'pais', 'sigla', 'idpais');
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
			$obj = GetModelo("pais");
			if(empty($obj))
				return $retorno;
			foreach ($lista as $key=>$linha)
			{
				$obj->SalvarListaPais($linha);
			}
			return true;
		}
		################################################################################################################
		public function SalvarListaPais($dados = false)
		{
			if(empty($dados))
				return;
			$pais = self::GetDadosChave($dados, array('pais','Pais','PAIS','país','País','PAÍS'));
			if(empty($pais))
				return;
			$aux = Escape($pais);
			$filtro = "pais = '{$aux}'";
			$obj = $this->FiltroObjeto($filtro);
			if(empty($obj))
			{
				$obj = $this->GetInstancia();
				$obj->pais = $pais;
			}
			$sigla = self::GetDadosChave($dados, array('sigla','Sigla','SIGLA','siglas','Siglas','SIGLAS'));
			$obj->sigla = $sigla;
			$obj->Ajustar(true);
			$obj->Salvar();
			return;
		}
		################################################################################################################
		public function ExportarPais()
		{
			$filtro = $this->Filtro(true);
			$filtro .= " ORDER BY pais ASC";
			$obj = GetModelo('pais');
			$sql = "SELECT * FROM pais";
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
				$dados['mensagem'] = __("Verificação de país foi finalizada.<br/>O download se iniciará em instantes");
				$dados['url'] = site_url("pais/baixarpais/{$file}");
				$dados['titulo'] = __("Exportação de país");
			}
			else
			{
				$dados['sucesso'] = false;
				$dados['erro'] = __("Nenhum e-mail deste arquivo enviado foi encontrado.");
			}
			return $dados;
		}
		################################################################################################################
		public function GetNomeFile()
		{
			$retorno = "exportacaopais_".date("Y-m-d_H-i-s").".xls";
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
			$campos = array("ID"=>"idpais", "país"=>"pais", "sigla"=>"sigla");
			return $campos;
		}
		################################################################################################################
		public function GetCaminho($file = "")
		{
			return $this->SetDominio($file);
		}
		################################################################################################################
		public function LerIdPais($palavraschaves = false, $sigla = "")
		{
			if(empty($palavraschaves))
			{
				return 0;
			}
			$palavraschaves = trim($palavraschaves," \n\t\r");
			$aux = Escape($palavraschaves);
			$sql = "SELECT idpais AS id FROM {$this->Tabela} WHERE pais = '{$aux}' LIMIT 1";
			$id = $this->GetSqlCampo($sql,"id", 0);
			if(empty($id))
			{
				$this->idpais = 0;
				$this->pais = $palavraschaves;
				$this->sigla = $sigla;
				$id = $this->Salvar();
				if(empty($id))
				{
					return 0;
				}
			}
			return $id;
		}
		################################################################################################################
		public function LerListaPaises()
		{
			$idcliente = Get("idcliente", 0);
			$idvaga = Get("idvaga", 0);
			$posicao = Get("posicao", 0);
			$limite = Get("limite", 10);
			$total = Get("total", 0);

			$rows = false;
			$titulo = __("Erro");
			$mensagem = __("Nenhum país foi encontrado.");
			
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
				$filtro .= " AND CV.idvaga ".GerarIN($idvaga);
			}
			if(empty($total))
			{
				$sql = "SELECT COUNT(DISTINCT P.idpais) AS CONT FROM pais P INNER JOIN candidato CO ON(P.idpais = CO.idpais) INNER JOIN candidatovaga CV ON(CO.idcandidato = CV.idcandidato) INNER JOIN vaga V ON(CV.idvaga = V.idvaga) WHERE {$filtro}";
				$total = $this->TotalRegistro(false, $sql);
			}
			if(!empty($total))
			{
				if($limite < 0)
					$limite = $total;
				$filtro .= " GROUP BY P.idpais, P.pais, P.sigla ORDER BY total DESC LIMIT {$posicao}, {$limite}";
				$sql = "SELECT P.idpais, P.pais, P.sigla, COUNT(DISTINCT CV.idcandidato) AS total FROM pais P INNER JOIN candidato CO ON(P.idpais = CO.idpais) INNER JOIN candidatovaga CV ON(CO.idcandidato = CV.idcandidato) INNER JOIN vaga V ON(CV.idvaga = V.idvaga) WHERE {$filtro}";
				$rows = $this->GetRows(false, $sql);
				if(!empty($rows))
				{
					$rows = array_map(array($this,'Map'), $rows);
					$titulo = __("Sucesso");
					$mensagem = __("Lista de país foi encontrado com sucesso.");
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
			$row['idpais'] = intval($row['idpais']);
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