<?php
/***********************************************************************
 * Module:  /models/Cargo_model.PHP
 * Author:  Host-up
 * Date:	03/04/2020 21:17:58
 * Purpose: Definição da Classe Cargo_model
 * Instancias: $this->load->model('Cargo_model', 'cargo');
 * Objeto: $cargo = $this->cargo->GetInstancia($dados);
 ***********************************************************************/
if (!class_exists('Cargo_model'))
{
	class Cargo_model extends MY_Model
	{
		private static $_termocargo = null;
		################################################################################################################
		public function __construct( $dados = false)
		{
			try
			{
				$this->Tabela = "cargo";
				$this->PrimaryKey = "idcargo";
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
				$this->cargo = ucwords(strtolower($this->cargo));
			}
			else
			{

			}
		}		
		################################################################################################################
		public static function &NewTermoCargo() {
			if (self::$_termocargo == null)
				self::$_termocargo = GetModelo("termocargo");
			return self::$_termocargo;
		}
		################################################################################################################
		public function GetSqlLista()
		{
			$retorno = "";
			try
			{
				return "SELECT DISTINCT C.* FROM cargo C LEFT JOIN termocargo T ON(C.idcargo = T.idcargo)";
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
				return "SELECT COUNT(DISTINCT C.idcargo) AS CONT FROM cargo C LEFT JOIN termocargo T ON(C.idcargo = T.idcargo)";
			}
			catch( Exception $e )
			{
				throw new Exception( $e );
				return $retorno;
			}
		}
		################################################################################################################
		public function GetIdCargoTermo()
		{
			$retorno = 0;
			try
			{
				if(empty($cargo))
					return 0;
				$aux = Escape($cargo);
				$sql = "SELECT T.idcargo AS ID FROM termocargo T WHERE T.termo = '{$aux}'";
				return $this->GetSqlCampo($sql, 'ID', 0);
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
				$filtro .= " AND (C.cargo LIKE '%{$buscar}%' OR T.termo LIKE '%{$buscar}%')";
			}
			
			if(!empty($filtro))
			{
				$filtro  = substr($filtro, 4);
			}
			if($semOrder)
			{
				return $filtro;
			}
			$ordem = array('C.idcargo', 'C.cargo', 'T.termo', 'C.idcargo');
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
			$obj = GetModelo("cargo");
			if(empty($obj))
				return $retorno;
			foreach ($lista as $key=>$linha)
			{
				$obj->SalvarListaCargo($linha);
			}
			return true;
		}
		################################################################################################################
		public function SalvarListaCargo($dados = false)
		{
			if(empty($dados))
				return 0;
			$cargo = self::GetDadosChave($dados, array('cargo','cargos','Cargo','Cargos','CARGO','CARGOS'));
			if(empty($cargo))
				return 0;
			$aux = Escape($cargo);
			$filtro = "cargo = '{$aux}'";
			$obj = $this->FiltroObjeto($filtro);
			if(empty($obj))
			{
				$id = $this->GetIdCargoTermo($cargo);
				if(empty($id))
				{
					$obj = $this->GetInstancia();
					$obj->cargo = $cargo;
					$obj->Ajustar(true);
					$id = $obj->Salvar();
				}
			}
			else
			{
				$id = $obj->idcargo;
			}
			if(!empty($id))
			{
				$listatermos = self::GetDadosChave($dados, array('termo','termos','Termo','Termos','TERMO','TERMOS'));
				if(!empty($listatermos))
				{
					$termo = self::NewTermoCargo();
					$termo->SalvarListaTermocargo($listatermos, $id);
				}
				
			}
			return $id;
		}
		################################################################################################################
		public function ExportarCargo()
		{
			$filtro = $this->Filtro(true);
			$filtro .= " ORDER BY cargo ASC";
			$obj = GetModelo('cargo');
			$sql = $this->GetSqlLista();
			$objs = $obj->FiltroObjetos($filtro, $sql);
			if($objs)
			{
				$file = $obj->GetNomeFile();
				$data = array(
					"file"=> $file,
					"lista"=>$objs,
					"html"=>false,
					"campos"=>$obj->GetNomesCampos(),
					"download"=>false,
					"pasta"=>$obj->GetCaminho()
				);
				Excel($data);
				$dados['sucesso'] = true;
				$dados['mensagem'] = __("Verificação de cargo foi finalizado.<br/>O download se iniciará em instantes");
				$dados['url'] = site_url("cargo/baixarcargo/{$file}");
				$dados['titulo'] = __("Exportação de cargo");
			}
			else
			{
				$dados['sucesso'] = false;
				$dados['erro'] = __("Nenhum cargo foi encontrado.");
			}
			return $dados;
		}
		################################################################################################################
		public function GetNomeFile()
		{
			$retorno = "exportacaocargo_".date("Y-m-d_H-i-s").".xls";
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
			$campos = array("ID"=>"idcargo","cargo"=>"cargo","termos"=>"termos");
			return $campos;
		}
		################################################################################################################
		public function GetCaminho($file = "")
		{
			return $this->SetDominio($file);
		}
		################################################################################################################
		public function &GetJson(&$dados = false)
		{
			$retorno = false;
			try
			{
				if(empty($dados))
				{
					$dados = $this->GetDados();
				}
				$termo = self::NewTermoCargo();
				$dados['termos'] = $termo->GetListaTermo($dados['idcargo']);
				return $dados;
			}
			catch( Exception $e )
			{
				throw new Exception( $e );
				return $retorno;
			}
		}
		################################################################################################################
		public function &GetDadosExcel(&$dados = false)
		{
			$retorno = false;
			try
			{
				if(empty($dados))
				{
					$dados = $this->GetDados();
				}
				$termo = self::NewTermoCargo();
				$dados['termos'] = "";
				$termos = $termo->GetListaTermo($dados['idcargo']);
				if(!empty($termos))
				{
					foreach($termos as $key=>$termo)
					{
						if($key == 0)
							$dados['termos'] .= $termo['termo'];
						else
							$dados['termos'] .= ";".$termo['termo'];
					}
				}
				return $dados;
			}
			catch( Exception $e )
			{
				throw new Exception( $e );
				return $retorno;
			}
		}
		#######################################################################################################################
		function Apagar() {
			$id = $this->GetID();
			$termo = self::NewTermoCargo();
			$termo->ApagarLista("idcargo = '{$id}'");
			return $this->Excluir($id);
		}
		################################################################################################################
		public function &BuscarFiltrosDeCargos()
		{
			$filtro = "";
			$search =  Get("search","");
			if(!empty($search))
			{
				$filtro .= " WHERE cargo != '' AND cargo LIKE '%{$search}%'";
			}
			$sql = "SELECT idcargo AS 'id', cargo AS 'text' FROM cargo {$filtro}";
			$lista = $this->GetRows(false, $sql);
			return $lista;
		}
		################################################################################################################
		public function LerIdCargo($palavraschaves = false)
		{
			if(empty($palavraschaves))
			{
				return 0;
			}
			$palavraschaves = trim($palavraschaves," \n\t\r");
			$aux = Escape($palavraschaves);
			$sql = "SELECT idcargo FROM {$this->Tabela} WHERE cargo = '{$aux}' LIMIT 1";
			$id = $this->GetSqlCampo($sql,"idcargo", 0);
			if(empty($id))
			{
				$this->idcargo = 0;
				$this->cargo = $palavraschaves;
				$this->Ajustar(true);
				$id = $this->Salvar();
				if(empty($id))
				{
					return 0;
				}
			}
			return $id;
		}
		################################################################################################################
		public function __destruct()
		{
			unset($this->dados, $this->Tabela, $this->PrimaryKey);
		}
	}
}
?>