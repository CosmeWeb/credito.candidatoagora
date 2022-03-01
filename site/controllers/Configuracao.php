<?php
/***********************************************************************
 * Module:  /controllers/Configuracao.PHP
 * Author:  Host-up
 * Date:	25/11/2018 11:15:41
 * Purpose: Definição da Classe Configuracao
 ***********************************************************************/

defined('BASEPATH') OR exit(__("Nenhum acesso de script direto permitido"));

class Configuracao extends CI_Controller {
	#######################################################################################################
	function __construct()
	{
		try
		{
			parent::__construct();
			Acesso();
		}
		catch( Exception $e )
		{
			throw new Exception( $e );
		}
	}
	#######################################################################################################
	public function candidatos()
	{
		$data['obj'] = GetModelo('vaga');
		$this->gestao->GetView('errors/emconstrucao', $data);
	}
	#######################################################################################################
	public function minhaconta()
	{
		$data['obj'] = GetModelo('vaga');
		$this->gestao->GetView('errors/emconstrucao', $data);
	}
	#######################################################################################################
	public function addcreditos()
	{
		$data['obj'] = GetModelo('vaga');
		$this->gestao->GetView('errors/emconstrucao', $data);
	}
}
?>