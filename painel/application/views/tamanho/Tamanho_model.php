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
			$aux = Escape($area);
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
		public function __destruct()
		{
			unset($this->dados, $this->Tabela, $this->PrimaryKey);
		}
	}
}
?>