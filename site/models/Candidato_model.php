<?php
/***********************************************************************
 * Module:  /models/Candidato_model.PHP
 * Author:  Host-up
 * Date:	10/06/2020 20:09:11
 * Purpose: Definição da Classe Candidato_model
 * Instancias: $this->load->model('Candidato_model', 'candidato');
 * Objeto: $candidato = $this->candidato->GetInstancia($dados);
 ***********************************************************************/
if (!class_exists('Candidato_model'))
{
	class Candidato_model extends MY_Model
	{
		################################################################################################################
		public function __construct( $dados = false)
		{
			try
			{
				$this->Tabela = "candidato";
				$this->PrimaryKey = "idcandidato";
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
		public function GerarOpcoesIdempresa($value = "0", $texto = "", $default = "0")
		{
			if(empty($texto))
				$texto = __("-- Selecione --");
			$primeiro = array("valor"=>$default,"texto"=>$texto);
			$sql = "SELECT idempresa AS 'id', empresa AS 'texto' FROM empresa ORDER BY texto ASC";
			return $this->GeraOpcoesSql($value, $sql, "id", "texto", $primeiro);
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
		public function GerarOpcoesIdarea($value = "0", $texto = "", $default = "0")
		{
			if(empty($texto))
				$texto = __("-- Selecione --");
			$primeiro = array("valor"=>$default,"texto"=>$texto);
			$sql = "SELECT idarea AS 'id', area AS 'texto' FROM area ORDER BY texto ASC";
			return $this->GeraOpcoesSql($value, $sql, "id", "texto", $primeiro);
		}
		################################################################################################################
		public function GerarOpcoesIdnivel($value = "0", $texto = "", $default = "0")
		{
			if(empty($texto))
				$texto = __("-- Selecione --");
			$primeiro = array("valor"=>$default,"texto"=>$texto);
			$sql = "SELECT idnivel AS 'id', nivel AS 'texto' FROM nivel ORDER BY texto ASC";
			return $this->GeraOpcoesSql($value, $sql, "id", "texto", $primeiro);
		}
		################################################################################################################
		public function GerarOpcoesIdcidade($value = "0", $texto = "", $default = "0")
		{
			if(empty($texto))
				$texto = __("-- Selecione --");
			$primeiro = array("valor"=>$default,"texto"=>$texto);
			$sql = "SELECT idcidade AS 'id', cidade AS 'texto' FROM cidade ORDER BY texto ASC";
			return $this->GeraOpcoesSql($value, $sql, "id", "texto", $primeiro);
		}
		################################################################################################################
		public function GerarOpcoesIdestado($value = "0", $texto = "", $default = "0")
		{
			if(empty($texto))
				$texto = __("-- Selecione --");
			$primeiro = array("valor"=>$default,"texto"=>$texto);
			$sql = "SELECT idestado AS 'id', estado AS 'texto' FROM estado ORDER BY texto ASC";
			return $this->GeraOpcoesSql($value, $sql, "id", "texto", $primeiro);
		}
		################################################################################################################
		public function GerarOpcoesCampo($value = "", $texto = "", $default = "")
		{
			if(empty($texto))
				$texto = __("-- Selecione --");
			$primeiro = array("valor"=>$default,"texto"=>$texto);
			return $this->GeraOpcoesEnum($value, $this->Tabela, "campo", $primeiro);
		}
		################################################################################################################
		public function GetSqlLista()
		{
			$retorno = "";
			try
			{
				return "SELECT * FROM candidato ";
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
				return "SELECT COUNT(*) AS CONT FROM candidato ";
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
			
			$idcandidato = GetFiltro("idcandidato");
			if(!empty($idcandidato))
			{
				$filtro .= " AND idcandidato = '{$idcandidato}'";
			}
			$idvaga = GetFiltro("idvaga");
			if(!empty($idvaga))
			{
				$filtro .= " AND idvaga = '{$idvaga}'";
			}
			$idcurriculo = GetFiltro("idcurriculo");
			if(!empty($idcurriculo))
			{
				$filtro .= " AND idcurriculo = '{$idcurriculo}'";
			}
			$idempresa = GetFiltro("idempresa");
			if(!empty($idempresa))
			{
				$filtro .= " AND idempresa = '{$idempresa}'";
			}
			$idcargo = GetFiltro("idcargo");
			if(!empty($idcargo))
			{
				$filtro .= " AND idcargo = '{$idcargo}'";
			}
			$idarea = GetFiltro("idarea");
			if(!empty($idarea))
			{
				$filtro .= " AND idarea = '{$idarea}'";
			}
			$idnivel = GetFiltro("idnivel");
			if(!empty($idnivel))
			{
				$filtro .= " AND idnivel = '{$idnivel}'";
			}
			$idcidade = GetFiltro("idcidade");
			if(!empty($idcidade))
			{
				$filtro .= " AND idcidade = '{$idcidade}'";
			}
			$idestado = GetFiltro("idestado");
			if(!empty($idestado))
			{
				$filtro .= " AND idestado = '{$idestado}'";
			}
			$campo = GetFiltro("campo");
			if(!empty($campo))
			{
				$filtro .= " AND campo = '{$campo}'";
			}
			if(!empty($filtro))
			{
				$filtro  = substr($filtro, 4);
			}
			if($semOrder)
			{
				return $filtro;
			}
			$ordem = array('idcandidato', 'idvaga', 'idcurriculo', 'idempresa', 'idcargo', 'idarea', 'idnivel', 'idcidade', 'idestado', 'campo', 'idcandidato');
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
			$obj = GetModelo("candidato");
			if(empty($obj))
				return $retorno;
			foreach ($lista as $key=>$linha)
			{
				$obj->SalvarListaCandidato($linha);
			}
			return true;
		}
		################################################################################################################
		public function SalvarListaCandidato($dados = false)
		{
			if(empty($dados))
				return;
			$candidato = self::GetDadosChave($dados, array('candidato','candidato'));
			if(empty($candidato))
				return;
			$filtro = "candidato = '{$candidato}'";
			$obj = $this->FiltroObjeto($filtro);
			if(empty($obj))
			{
				$obj = $this->GetInstancia();
				$obj->candidato = $candidato;
			}
			$obj->Ajustar(true);
			$obj->Salvar();
			return;
		}
		################################################################################################################
		public function ExportarCandidato()
		{
			$posicao = Get("posicao", 0);
			$total = Get("total", 0);
			$file = Get("file");
			$limite = 500;
			$obj = GetModelo('candidato');
			
			if(empty($total))
			{
				$sqlTotal = $obj->GetSqlTotalLista();
				$filtro = $obj->Filtro(true);
				$total = $obj->TotalRegistro($filtro, $sqlTotal, false);
				if(empty($total))
				{
					$dados['sucesso'] = false;
					$dados['erro'] = __("Nenhum candidato foi encontrado no momento.");
				}
				else
				{
					$dados['sucesso'] = true;
					$dados['titulo'] = __("Processando Exportação");
					$dados['mensagem'] = __("Exportação de candidato está processando.");
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
			$filtro .= " ORDER BY candidato ASC";
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
					$dados['titulo'] = __("Exportação de candidato");
					$dados['mensagem'] = __("Exportação de candidato foi finalizada.<br/>O download se iniciará em instantes");
					$dados['url'] = site_url("candidato/baixarcandidato/{$file}");
					$dados['finalizado'] = true;
					$dados['file'] = $file;
					$dados['posicao'] = $posicao;
					$dados['total'] = $total;
				}
				else
				{
					$dados['titulo'] = __("Exportação de candidato");
					$dados['mensagem'] = __("Exportação de candidato está processando.");
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
				$dados['erro'] = __("Nenhum candidato foi encontrado.");
			}
			//XDebug($dados, $this);
			return $dados;
		}
		################################################################################################################
		public function GetNomeFile()
		{
			$retorno = "exportacaocandidato_".date("Y-m-d_H-i-s").".xls";
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
			$campos = array("ID"=>"idcandidato","candidato"=>"candidato");
			return $campos;
		}
		################################################################################################################
		public function GetCaminho($file = "")
		{
			return $this->SetDominio($file);
		}
		################################################################################################################
		public function GetLinkedin()
		{
			$aux = str_replace(array("https://","http://","www."),"", $this->linkedin);
			return "https://".$aux;
		}
		################################################################################################################
		public function __destruct()
		{
			unset($this->dados, $this->Tabela, $this->PrimaryKey);
		}
	}
}
?>