<?php
/***********************************************************************
 * Module:  /models/Candidatorecomendado_model.PHP
 * Author:  Host-up
 * Date:	07/07/2020 19:41:22
 * Purpose: Definição da Classe Candidatorecomendado_model
 * Instancias: $this->load->model('Candidatorecomendado_model', 'candidatorecomendado');
 * Objeto: $candidatorecomendado = $this->candidatorecomendado->GetInstancia($dados);
 ***********************************************************************/
if (!class_exists('Candidatorecomendado_model'))
{
	class Candidatorecomendado_model extends MY_Model
	{
		################################################################################################################
		public function __construct( $dados = false)
		{
			try
			{
				$this->Tabela = "candidatorecomendado";
				$this->PrimaryKey = "idcandidatorecomendado";
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
		public function __destruct()
		{
			unset($this->dados, $this->Tabela, $this->PrimaryKey);
		}
	}
}
?>