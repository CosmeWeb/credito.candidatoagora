<?php
/***********************************************************************
 * Module:  /models/Projeto_model.PHP
 * Author:  Host-up
 * Date:	01/03/2022 21:56:32
 * Purpose: Definição da Classe Projeto_model
 * Instancias: $this->load->model('Projeto_model', 'projeto');
 * Objeto: $projeto = $this->projeto->GetInstancia($dados);
 ***********************************************************************/
if (!class_exists('Projeto_model'))
{
	class Projeto_model extends MY_Model
	{
		################################################################################################################
		public function __construct( $dados = false)
		{
			try
			{
				$this->Tabela = "projeto";
				$this->PrimaryKey = "idprojeto";
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
		public function GerarOpcoesIdgestor($value = "0", $texto = "", $default = "0")
		{
			if(empty($texto))
				$texto = __("-- Selecione --");
			$primeiro = array("valor"=>$default,"texto"=>$texto);
			$sql = "SELECT idgestor AS 'id', gestor AS 'texto' FROM gestor ORDER BY texto ASC";
			return $this->GeraOpcoesSql($value, $sql, "id", "texto", $primeiro);
		}		################################################################################################################
		public function GerarOpcoesIdarea($value = "0", $texto = "", $default = "0")
		{
			if(empty($texto))
				$texto = __("-- Selecione --");
			$primeiro = array("valor"=>$default,"texto"=>$texto);
			$sql = "SELECT idarea AS 'id', area AS 'texto' FROM area ORDER BY texto ASC";
			return $this->GeraOpcoesSql($value, $sql, "id", "texto", $primeiro);
		}		################################################################################################################
		public function GerarOpcoesIdcliente($value = "0", $texto = "", $default = "0")
		{
			if(empty($texto))
				$texto = __("-- Selecione --");
			$primeiro = array("valor"=>$default,"texto"=>$texto);
			$sql = "SELECT idcliente AS 'id', cliente AS 'texto' FROM cliente ORDER BY texto ASC";
			return $this->GeraOpcoesSql($value, $sql, "id", "texto", $primeiro);
		}




		################################################################################################################
		public function GetSqlLista()
		{
			$retorno = "";
			try
			{
				return "SELECT * FROM projeto ";
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
				return "SELECT COUNT(*) AS CONT FROM projeto ";
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
				$buscar = explode(";", $buscar);
				$filtrobuscar = " AND (";
				$first = true;
				foreach($buscar as $busca)
				{
					$busca = trim($busca);
					if(empty($busca))
						continue;
					$busca = Escape(trim($busca));
					if(!$first)
					{
						$filtrobuscar .= " OR ";
					}
					else
					{
						$first = false;
					}
					$filtrobuscar .= " buscar LIKE '%{$busca}%'";
				}
				$filtrobuscar .= ")";
				$filtro .= $filtrobuscar;
			}
			
			$idprojeto = GetFiltro("idprojeto");
			if(!empty($idprojeto))
			{
				$filtro .= " AND idprojeto = '{$idprojeto}'";
			}
			$idgestor = GetFiltro("idgestor");
			if(!empty($idgestor))
			{
				$filtro .= " AND idgestor = '{$idgestor}'";
			}
			$idarea = GetFiltro("idarea");
			if(!empty($idarea))
			{
				$filtro .= " AND idarea = '{$idarea}'";
			}
			$nome = GetFiltro("nome");
			if(!empty($nome))
			{
				$filtro .= " AND nome = '{$nome}'";
			}
			$idcliente = GetFiltro("idcliente");
			if(!empty($idcliente))
			{
				$filtro .= " AND idcliente = '{$idcliente}'";
			}
			$ip = GetFiltro("ip");
			if(!empty($ip))
			{
				$filtro .= " AND ip = '{$ip}'";
			}
			$cadastradoem = GetFiltro("cadastradoem");
			if(!empty($cadastradoem))
			{
				$filtro .= " AND cadastradoem = '{$cadastradoem}'";
			}
			if(!empty($filtro))
			{
				$filtro  = substr($filtro, 4);
			}
			if($semOrder)
			{
				return $filtro;
			}
			$ordem = array('idprojeto', 'idgestor', 'idarea', 'nome', 'idcliente', 'ip', 'cadastradoem', 'idprojeto');
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
			$obj = GetModelo("projeto");
			if(empty($obj))
				return $retorno;
			foreach ($lista as $key=>$linha)
			{
				$obj->SalvarListaProjeto($linha);
			}
			return true;
		}
		################################################################################################################
		public function SalvarListaProjeto($dados = false)
		{
			if(empty($dados))
				return;
			$projeto = self::GetDadosChave($dados, array('projeto','projeto'));
			if(empty($projeto))
				return;
			$filtro = "projeto = '{$projeto}'";
			$obj = $this->FiltroObjeto($filtro);
			if(empty($obj))
			{
				$obj = $this->GetInstancia();
				$obj->projeto = $projeto;
			}
			$obj->Ajustar(true);
			$obj->Salvar();
			return;
		}
		################################################################################################################
		public function ExportarProjeto()
		{
			$posicao = Get("posicao", 0);
			$total = Get("total", 0);
			$file = Get("file");
			$limite = 500;
			$obj = GetModelo('projeto');
			
			if(empty($total))
			{
				$sqlTotal = $obj->GetSqlTotalLista();
				$filtro = $obj->Filtro(true);
				$total = $obj->TotalRegistro($filtro, $sqlTotal, false);
				if(empty($total))
				{
					$dados['sucesso'] = false;
					$dados['erro'] = __("Nenhum projeto foi encontrado no momento.");
				}
				else
				{
					$dados['sucesso'] = true;
					$dados['titulo'] = __("Processando Exportação");
					$dados['mensagem'] = __("Exportação de projeto está processando.");
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
			$filtro .= " ORDER BY projeto ASC";
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
					$dados['titulo'] = __("Exportação de projeto");
					$dados['mensagem'] = __("Exportação de projeto foi finalizada.<br/>O download se iniciará em instantes");
					$dados['url'] = site_url("projeto/baixarprojeto/{$file}");
					$dados['finalizado'] = true;
					$dados['file'] = $file;
					$dados['posicao'] = $posicao;
					$dados['total'] = $total;
				}
				else
				{
					$dados['titulo'] = __("Exportação de projeto");
					$dados['mensagem'] = __("Exportação de projeto está processando.");
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
				$dados['erro'] = __("Nenhum projeto foi encontrado.");
			}
			//XDebug($dados, $this);
			return $dados;
		}
		################################################################################################################
		public function GetNomeFile()
		{
			$retorno = "exportacaoprojeto_".date("Y-m-d_H-i-s").".xls";
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
			$campos = array("ID"=>"idprojeto","projeto"=>"projeto");
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