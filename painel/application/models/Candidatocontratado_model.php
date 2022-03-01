<?php
/***********************************************************************
 * Module:  /models/Candidatocontratado_model.PHP
 * Author:  Host-up
 * Date:	07/07/2020 19:41:05
 * Purpose: Definição da Classe Candidatocontratado_model
 * Instancias: $this->load->model('Candidatocontratado_model', 'candidatocontratado');
 * Objeto: $candidatocontratado = $this->candidatocontratado->GetInstancia($dados);
 ***********************************************************************/
if (!class_exists('Candidatocontratado_model'))
{
	class Candidatocontratado_model extends MY_Model
	{
		################################################################################################################
		public function __construct( $dados = false)
		{
			try
			{
				$this->Tabela = "candidatocontratado";
				$this->PrimaryKey = "idcandidatocontratado";
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