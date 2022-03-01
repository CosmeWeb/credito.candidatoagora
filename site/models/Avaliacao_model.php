<?php
/***********************************************************************
 * Module:  /models/Avaliacao_model.PHP
 * Author:  Host-up
 * Date:	12/02/2021 00:48:57
 * Purpose: Definição da Classe Avaliacao_model
 * Instancias: $this->load->model('Avaliacao_model', 'avaliacao');
 * Objeto: $avaliacao = $this->avaliacao->GetInstancia($dados);
 ***********************************************************************/
if (!class_exists('Avaliacao_model'))
{
	class Avaliacao_model extends MY_Model
	{
		################################################################################################################
		public function __construct( $dados = false)
		{
			try
			{
				$this->Tabela = "avaliacao";
				$this->PrimaryKey = "idavaliacao";
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
		public function GerarOpcoesInteresseMercado($value = "", $texto = "", $default = "")
		{
			if(empty($texto))
				$texto = __("-- Selecione --");
			$primeiro = array("valor"=>$default,"texto"=>$texto);
			return $this->GeraOpcoesEnum($value, $this->Tabela, "interessemercado", $primeiro);
		}
		################################################################################################################
		public function GerarOpcoesTipodecontratacao($value = "", $texto = "", $default = "")
		{
			if(empty($texto))
				$texto = __("-- Selecione --");
			$primeiro = array("valor"=>$default,"texto"=>$texto);
			return $this->GeraOpcoesEnum($value, $this->Tabela, "tipodecontratacao", $primeiro);
		}
		################################################################################################################
		public function &GetCandidato($idcandidato = 0)
		{
			$retorno = false;
			try
			{
				if(empty($idcandidato))
					$idcandidato = $this->Get("idcandidato", 0);
				if(empty($idcandidato))
					return $retorno;
				$obj = GetModelo("candidato");
				$obj->idcandidato = $idcandidato;
				if(!$obj->Load())
					return $retorno;
				return $obj;
			}
			catch( Exception $e )
			{
				throw new Exception( $e );
				return $retorno;
			}
		}
		################################################################################################################
		public function &GetCompetencia($idavaliacao = 0)
		{
			$retorno = false;
			try
			{
				if(empty($idavaliacaoo))
					$idavaliacao = $this->Get("idavaliacao", 0);				
					
				$obj = GetModelo("avaliacaocompetencia");
				$objs = $obj->GetAvaliacaoCompetencia($idavaliacao);
				return $objs;
			}
			catch( Exception $e )
			{
				throw new Exception( $e );
				return $retorno;
			}
		}
		################################################################################################################
		public function GetCliente($idcliente = 0)
		{
			if(empty($idcliente))
				return "";

			$sql = "SELECT IF(empresa = '', nome, CONCAT(nome,' (',empresa,')')) AS 'nome' FROM cliente WHERE idcliente = '{$idcliente}' ORDER BY nome ASC";
			$defult = "Não identificado";
			$campo = "avaliacao_cliente_".$idcliente;
			$cliente = $this->LerCacheSQlCampo($campo, $sql, "nome", 500, $defult);
			return $cliente;
		}
		################################################################################################################
		public function __destruct()
		{
			unset($this->dados, $this->Tabela, $this->PrimaryKey);
		}
	}
}
?>