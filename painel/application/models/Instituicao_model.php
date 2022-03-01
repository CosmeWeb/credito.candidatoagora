<?php
/***********************************************************************
 * Module:  /models/Instituicao_model.PHP
 * Author:  Host-up
 * Date:	01/07/2020 23:05:13
 * Purpose: Definição da Classe Instituicao_model
 * Instancias: $this->load->model('Instituicao_model', 'instituicao');
 * Objeto: $instituicao = $this->instituicao->GetInstancia($dados);
 ***********************************************************************/
if (!class_exists('Instituicao_model'))
{
	class Instituicao_model extends MY_Model
	{
		################################################################################################################
		public function __construct( $dados = false)
		{
			try
			{
				$this->Tabela = "instituicao";
				$this->PrimaryKey = "idinstituicao";
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
				return "SELECT * FROM instituicao ";
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
				return "SELECT COUNT(*) AS CONT FROM instituicao ";
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
			
			$idinstituicao = GetFiltro("idinstituicao");
			if(!empty($idinstituicao))
			{
				$filtro .= " AND idinstituicao = '{$idinstituicao}'";
			}
			$instituicao = GetFiltro("instituicao");
			if(!empty($instituicao))
			{
				$filtro .= " AND instituicao = '{$instituicao}'";
			}
			if(!empty($filtro))
			{
				$filtro  = substr($filtro, 4);
			}
			if($semOrder)
			{
				return $filtro;
			}
			$ordem = array('idinstituicao', 'instituicao', 'idinstituicao');
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
			$obj = GetModelo("instituicao");
			if(empty($obj))
				return $retorno;
			foreach ($lista as $key=>$linha)
			{
				$obj->SalvarListaInstituicao($linha);
			}
			return true;
		}
		################################################################################################################
		public function SalvarListaInstituicao($dados = false)
		{
			if(empty($dados))
				return;
			$instituicao = self::GetDadosChave($dados, array('instituicao','instituicao'));
			if(empty($instituicao))
				return;
			$filtro = "instituicao = '{$instituicao}'";
			$obj = $this->FiltroObjeto($filtro);
			if(empty($obj))
			{
				$obj = $this->GetInstancia();
				$obj->instituicao = $instituicao;
			}
			$obj->Ajustar(true);
			$obj->Salvar();
			return;
		}
		################################################################################################################
		public function ExportarInstituicao()
		{
			$posicao = Get("posicao", 0);
			$total = Get("total", 0);
			$file = Get("file");
			$limite = 500;
			$obj = GetModelo('instituicao');
			
			if(empty($total))
			{
				$sqlTotal = $obj->GetSqlTotalLista();
				$filtro = $obj->Filtro(true);
				$total = $obj->TotalRegistro($filtro, $sqlTotal, false);
				if(empty($total))
				{
					$dados['sucesso'] = false;
					$dados['erro'] = __("Nenhum instituicao foi encontrado no momento.");
				}
				else
				{
					$dados['sucesso'] = true;
					$dados['titulo'] = __("Processando Exportação");
					$dados['mensagem'] = __("Exportação de instituicao está processando.");
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
			$filtro .= " ORDER BY instituicao ASC";
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
					$dados['titulo'] = __("Exportação de instituicao");
					$dados['mensagem'] = __("Exportação de instituicao foi finalizada.<br/>O download se iniciará em instantes");
					$dados['url'] = site_url("instituicao/baixarinstituicao/{$file}");
					$dados['finalizado'] = true;
					$dados['file'] = $file;
					$dados['posicao'] = $posicao;
					$dados['total'] = $total;
				}
				else
				{
					$dados['titulo'] = __("Exportação de instituicao");
					$dados['mensagem'] = __("Exportação de instituicao está processando.");
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
				$dados['erro'] = __("Nenhum instituicao foi encontrado.");
			}
			//XDebug($dados, $this);
			return $dados;
		}
		################################################################################################################
		public function GetNomeFile()
		{
			$retorno = "exportacaoinstituicao_".date("Y-m-d_H-i-s").".xls";
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
			$campos = array("ID"=>"idinstituicao","instituicao"=>"instituicao");
			return $campos;
		}
		################################################################################################################
		public function GetCaminho($file = "")
		{
			return $this->SetDominio($file);
		}
		################################################################################################################
		public function LerIdInstituicao($palavraschaves = false)
		{
			if(empty($palavraschaves))
			{
				return 0;
			}
			$palavraschaves = trim($palavraschaves," \n\t\r");
			$aux = Escape($palavraschaves);
			$sql = "SELECT idinstituicao AS id FROM {$this->Tabela} WHERE instituicao = '{$aux}' LIMIT 1";
			$id = $this->GetSqlCampo($sql,"id", 0);
			if(empty($id))
			{
				$this->idinstituicao = 0;
				$this->instituicao = $palavraschaves;
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