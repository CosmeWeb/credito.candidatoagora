<?php
/***********************************************************************
 * Module:  /models/Termocargo_model.PHP
 * Author:  Host-up
 * Date:	04/04/2020 11:04:57
 * Purpose: Definição da Classe Termocargo_model
 * Instancias: $this->load->model('Termocargo_model', 'termocargo');
 * Objeto: $termocargo = $this->termocargo->GetInstancia($dados);
 ***********************************************************************/
if (!class_exists('Termocargo_model'))
{
	class Termocargo_model extends MY_Model
	{
		################################################################################################################
		public function __construct( $dados = false)
		{
			try
			{
				$this->Tabela = "termocargo";
				$this->PrimaryKey = "idtermocargo";
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
		public function GerarOpcoesIdcargo($value = "0", $texto = "", $default = "0")
		{
			if(empty($texto))
				$texto = __("-- Selecione --");
			$primeiro = array("valor"=>$default,"texto"=>$texto);
			$sql = "SELECT idcargo AS 'id', cargo AS 'texto' FROM cargo ORDER BY texto ASC";
			return $this->GeraOpcoesSql($value, $sql, "id", "texto", $primeiro);
		}
		################################################################################################################
		public function GetSqlLista()
		{
			$retorno = "";
			try
			{
				return "SELECT * FROM termocargo ";
			}
			catch( Exception $e )
			{
				throw new Exception( $e );
				return $retorno;
			}
		}
		################################################################################################################
		public function &GetListaTermo($idcargo = 0)
		{
			$retorno = false;
			try
			{
				if(empty($idcargo))
				{
					$idcargo = $this->Get("idcargo", 0);
				}
				if(empty($idcargo))
				{
					return $retorno;
				}
				$sql = "SELECT * FROM termocargo WHERE idcargo = '{$idcargo}' ORDER BY termo ASC";
				return $this->FiltroJson(false, $sql, false);
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
				return "SELECT COUNT(*) AS CONT FROM termocargo ";
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
				$filtro .= " AND termo LIKE '%{$buscar}%'";
			}
			$idcargo = GetFiltro("idcargo");
			if(!empty($idcargo))
			{
				$filtro .= " AND idcargo = '{$idcargo}'";
			}
			if(!empty($filtro))
			{
				$filtro  = substr($filtro, 4);
			}
			if($semOrder)
			{
				return $filtro;
			}
			$ordem = array('idtermocargo', 'idcargo', 'termo', 'idtermocargo');
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
			$obj = GetModelo("termocargo");
			if(empty($obj))
				return $retorno;
			foreach ($lista as $key=>$linha)
			{
				$obj->SalvarListaTermocargo($linha);
			}
			return true;
		}
		################################################################################################################
		public function SalvarListaTermocargo($lista = false, $idcargo = 0)
		{
			if(empty($lista))
				return;
			if(empty($idcargo))
				return;
			if(stripos($lista, ";"))
			{
				$lista = explode(";", $lista);
			}
			elseif(stripos($lista, ","))
			{
				$lista = explode(",", $lista);
			}
			else
			{
				$lista = array($lista);
			}	
			if(empty($lista))
				return;
			foreach($lista as $key=>$termo)
			{
				$termo = Escape(trim($termo));
				$filtro = "termo = '{$termo}'";
				$obj = $this->FiltroObjeto($filtro);
				if(empty($obj))
				{
					$obj = $this->GetInstancia();
					$obj->termo = $termo;
					$obj->idcargo = $idcargo;
					$obj->Ajustar(true);
					$obj->Salvar();
				}
			}
			return;
		}
		################################################################################################################
		public function ExportarTermocargo()
		{
			$filtro = $this->Filtro(true);
			$filtro .= " ORDER BY termocargo ASC";
			$obj = GetModelo('termocargo');
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
				$dados['mensagem'] = __("Verificação de termocargo foi finalizado.<br/>O download se iniciará em instantes");
				$dados['url'] = site_url("termocargo/baixartermocargo/{$file}");
				$dados['titulo'] = __("Exportação de termocargo");
			}
			else
			{
				$dados['sucesso'] = false;
				$dados['erro'] = __("Nenhum termocargo foi encontrado.");
			}
			return $dados;
		}
		################################################################################################################
		public function GetNomeFile()
		{
			$retorno = "exportacaotermocargo_".date("Y-m-d_H-i-s").".xls";
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
			$campos = array("ID"=>"idtermocargo","termocargo"=>"termocargo");
			return $campos;
		}
		################################################################################################################
		public function GetCaminho($file = "")
		{
			return $this->SetDominio($file);
		}
		################################################################################################################
		public function __destruct()
		{
			unset($this->dados, $this->Tabela, $this->PrimaryKey);
		}
	}
}
?>