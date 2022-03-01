<?php
/***********************************************************************
 * Module:  /models/Candidatonovo_model.PHP
 * Author:  Host-up
 * Date:	03/02/2021 22:16:04
 * Purpose: Definição da Classe Candidatonovo_model
 * Instancias: $this->load->model('Candidatonovo_model', 'candidatonovo');
 * Objeto: $candidatonovo = $this->candidatonovo->GetInstancia($dados);
 ***********************************************************************/
if (!class_exists('Candidatonovo_model'))
{
	class Candidatonovo_model extends MY_Model
	{
		################################################################################################################
		public function __construct( $dados = false)
		{
			try
			{
				$this->Tabela = "candidatonovo";
				$this->PrimaryKey = "idcandidatonovo";
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
				if(empty($this->ip))
					$this->ip = GetIP();
				if(emptyData($this->cadastradoem))
					$this->cadastradoem = date("Y-m-d H:i:s");
				else
					$this->cadastradoem = date("Y-m-d H:i:s", TimeData($this->cadastradoem));
			}
			else
			{
				$this->cadastradoem = date("d/m/Y H:i:s", TimeData($this->cadastradoem));
			}
		}
		################################################################################################################
		public function SalvarCandidatoNovo($idvaga = 0, $idcandidato = 0)
		{
			if(empty($idvaga))
				return;
			if(empty($idcandidato))
				return;
				
			$filtro = " idvaga = '{$idvaga}' AND idcandidato = '{$idcandidato}'";
			if($this->Load($filtro))
			{
				return;
			}
			$this->idcandidatonovo = 0;
			$this->idcandidato = $idcandidato;
			$this->idvaga = $idvaga;
			$this->ip = "";
			$this->cadastradoem = "";
			$this->Ajustar(true);
			$this->Salvar();
			return;
		}
		################################################################################################################
		public function DeletarCandidatos($idvaga = 0)
		{
			try
			{
				if(empty($idvaga))
					return;
				$sql = "DELETE FROM candidatonovo WHERE idvaga = '{$idvaga}'";
				self::Query($sql);
			}
			catch( Exception $e )
			{
				throw new Exception( $e );
			}
		}
		################################################################################################################
		public function GetCandidatoNovo($idcandidato = 0, $idvaga = 0)
		{
			$retorno = "";
			try
			{
				if(empty($idvaga))
					return $retorno;
				if(empty($idcandidato))
					return $retorno;
				
				$filtro = "idvaga = '{$idvaga}' AND idcandidato = '{$idcandidato}'";
				$total = $this->TotalRegistro($filtro);
				if($total > 0)
				{					
					return "Sim";
				}
				return $retorno;
			}
			catch( Exception $e )
			{
				throw new Exception( $e );
				return $retorno;
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