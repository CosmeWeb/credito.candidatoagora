<?php
/***********************************************************************
 * Module:  /controllers/Candidato.PHP
 * Author:  Host-up
 * Date:	10/06/2020 20:09:11
 * Purpose: Definição da Classe Candidato
 ***********************************************************************/

defined('BASEPATH') OR exit(__("Nenhum acesso de script direto permitido"));

class Candidato extends CI_Controller {
	private static $limiteimportacao = 50;
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
	public function candidatos($idvaga = 0)
	{
		$data['obj'] = GetModelo('candidato');
		$data['idCliente'] = GetAcesso("idcliente");
		$data['Acesso'] = GetAcesso("acesso");
		$data['idvaga'] = $idvaga;
		$data['titulovaga'] = "";
		if(!empty($idvaga))
		{
			$vaga = GetModelo('vaga');
			$vaga->idvaga = $idvaga;
			if($vaga->Load())
			{ 
				$data['titulovaga'] = $vaga->titulodavaga;
			}
		}
		else
		{
			$data = array('act'=>__("Erro"),'titulo'=>__("Vaga não foi localizada."));
			$this->gestao->GetView('layout/erro', $data );
			return;
		}
		$this->gestao->AddCSS("assets/css/candidato.css?versao={$this->gestao->versao}");
		$this->gestao->GetView('candidato/candidatos', $data);
	}
	#######################################################################################################
	public function avaliacao($idcandidato = 0)
	{
		$obj = GetModelo('avaliacao');
		$filtro = "idcandidato = '{$idcandidato}'";
		if(!$obj->Load($filtro))
		{
			$obj->idcandidato = $idcandidato;
		}
		if(!$candidato = $obj->GetCandidato())
		{
			$data = array('act'=>__("Erro"),'titulo'=>__("Avaliação não foi localizado."));
			$this->gestao->GetView('layout/erro', $data );
			return;
		}
		if(!emptyData($obj->cadastradoem))
			$obj->cadastradoem = date("d/m/Y H:i:s", TimeData($obj->cadastradoem));
		else
			$obj->cadastradoem = "";
		$obj->cliente = $obj->GetCliente($obj->idcliente);
		if(empty($obj->idavaliacao))
		{
			$obj->finalista = "";
			$obj->placement = "";
			$obj->perfiltecnicocomportamental = "";
		}
		$data['obj'] = $obj;
		$data['candidato'] = $candidato;
		$data['lista'] = $obj->GetCompetencia();
		$this->gestao->GetView('candidato/avaliacao', $data);//P($data, $this->db->queries);
	}
}
?>