<?php
/***********************************************************************
 * Module:  /controllers/Vaga.PHP
 * Author:  Host-up
 * Date:	17/03/2020 21:01:48
 * Purpose: Definição da Classe Vaga
 ***********************************************************************/

defined('BASEPATH') OR exit(__("Nenhum acesso de script direto permitido"));

class Vaga extends CI_Controller {
	private static $limiteimportacao = 50;
	#######################################################################################################
	function __construct()
	{
		try
		{
			parent::__construct();
			Acesso(["vaga"], ["pdf_vaga"]);
		}
		catch( Exception $e )
		{
			throw new Exception( $e );
		}
	}
	#######################################################################################################
	public function dashboard()
	{
		$data['obj'] = GetModelo('vaga');
		$data['idCliente'] = GetAcesso("idcliente");
		$this->gestao->GetView('vaga/dashboard', $data);
	}
	#######################################################################################################
	public function novavaga()
	{
		$this->dashboard();
		/*$data['obj'] = GetModelo('vaga');
		$this->gestao->GetView('vaga/novavaga', $data);*/
	}
	#######################################################################################################
	public function dadosdavagaexpectativa($idvaga = 0)
	{
		$obj = GetModelo('vaga');
		if(!empty($idvaga))
		{
			$obj->idvaga = $idvaga;
			if(!$obj->Load())
			{
				$linkRetorno = site_url('vaga/dadosdacontratante');
				redirect($linkRetorno);
			}
		}
		else
		{
			$obj->declarado = Get('declarado',"Não");
			$obj->autorizado = Get('autorizado',"Não");
			$obj->fasecadastro = 1;
			$obj->idcliente = GetAcesso("idcliente");
		}
		$data['obj'] = $obj;
		$this->gestao->GetView('vaga/dadosdavagaexpectativa', $data);
	}
	#######################################################################################################
	public function dadosdashboard($idvaga = 0)
	{
		$obj = GetModelo('vaga');
		$obj->idvaga = $idvaga;
		if(!$obj->Load())
		{
			$linkRetorno = site_url('vaga/dadosdacontratante');
			redirect($linkRetorno);
		}
		$data['obj'] = $obj;
		$this->gestao->GetView('vaga/dadosdashboard', $data);
	}
	#######################################################################################################
	public function dadosdacontratante($idvaga = 0)
	{
		$obj = GetModelo('vaga');
		if(!empty($idvaga))
		{
			$obj->idvaga = $idvaga;
			if(!$obj->Load())
			{
				$linkRetorno = site_url('vaga/dadosdashboard/'.$idvaga);
				redirect($linkRetorno);
			}
		}
		$obj->InitFase(1);
		$data['obj'] = $obj;
		$this->gestao->GetView('vaga/dadosdacontratante', $data);
	}
	#######################################################################################################
	public function dadosdavaga($idvaga = 0)
	{
		$obj = GetModelo('vaga');
		$obj->idvaga = $idvaga;
		if(!$obj->Load())
		{
			$linkRetorno = site_url('vaga/dadosdashboard/'.$idvaga);
			redirect($linkRetorno);
		}
		$obj->InitFase(2);
		$data['obj'] = $obj;
		$this->gestao->GetView('vaga/dadosdavaga', $data);
	}
	#######################################################################################################
	public function dadosdacandidato($idvaga = 0)
	{
		$obj = GetModelo('vaga');
		$obj->idvaga = $idvaga;
		if(!$obj->Load())
		{
			$linkRetorno = site_url('vaga/dadosdashboard/'.$idvaga);
			redirect($linkRetorno);
		}
		if(($obj->fase3 == "Não iniciado")||(empty($obj->fase3)))
		{
			$obj->nacionalidadeempresasprofissionaltrabalhou = "";
			$obj->melhores1000empresa = "";
			$obj->listadaembolsa = "";
			$obj->gptw = "";
			$obj->perfilinovacao = "";
			$obj->startup = "";
		}
		$obj->InitFase(3);
		$data['obj'] = $obj;
		$this->gestao->GetView('vaga/dadosdacandidato', $data);
	}
	#######################################################################################################
	public function dadosdavagasetor($idvaga = 0)
	{
		$obj = GetModelo('vaga');
		$obj->idvaga = $idvaga;
		if(!$obj->Load())
		{
			$linkRetorno = site_url('vaga/dadosdashboard/'.$idvaga);
			redirect($linkRetorno);
		}
		$obj->InitFase(4);
		$data['obj'] = $obj;
		$this->gestao->GetView('vaga/dadosdavagasetor', $data);
	}
	#######################################################################################################
	public function dadosdavagaempresa($idvaga = 0)
	{
		$obj = GetModelo('vaga');
		$obj->idvaga = $idvaga;
		if(!$obj->Load())
		{
			$linkRetorno = site_url('vaga/dadosdashboard/'.$idvaga);
			redirect($linkRetorno);
		}
		$data['obj'] = $obj;
		$this->gestao->GetView('vaga/dadosdavagaempresa', $data);
	}
	#######################################################################################################
	public function dadosdavagaselectempresa($idvaga = 0)
	{
		$obj = GetModelo('vaga');
		$obj->idvaga = $idvaga;
		if(!$obj->Load())
		{
			$linkRetorno = site_url('vaga/dadosdashboard/'.$idvaga);
			redirect($linkRetorno);
		}
		$obj->InitFase(5);
		$data['obj'] = $obj;
		$this->gestao->GetView('vaga/dadosdavagaselectempresa', $data);
	}
	#######################################################################################################
	public function dadosdavagaautoempresa($idvaga = 0)
	{
		$obj = GetModelo('vaga');
		$obj->idvaga = $idvaga;
		if(!$obj->Load())
		{
			$linkRetorno = site_url('vaga/dadosdashboard/'.$idvaga);
			redirect($linkRetorno);
		}
		$obj->InitFase(5);
		$data['obj'] = $obj;
		$this->gestao->GetView('vaga/dadosdavagaautoempresa', $data);
	}
	#######################################################################################################
	public function dadosdavagaempresaexcluir($idvaga = 0)
	{
		$obj = GetModelo('vaga');
		$obj->idvaga = $idvaga;
		if(!$obj->Load())
		{
			$linkRetorno = site_url('vaga/dadosdacontratante');
			redirect($linkRetorno);
		}
		$obj->InitFase(6);
		$data['obj'] = $obj;
		$this->gestao->GetView('vaga/dadosdavagaempresaexcluir', $data);
	}
	#######################################################################################################
	public function dadosdavagaresumo($idvaga = 0)
	{
		$obj = GetModelo('vaga');
		$obj->idvaga = $idvaga;
		if(!$obj->Load())
		{
			$linkRetorno = site_url('vaga/dadosdacontratante');
			redirect($linkRetorno);
		}
		$data['obj'] = $obj;
		$this->gestao->GetView('vaga/dadosdavagaresumo', $data);
	}
	#######################################################################################################
	public function dadosdavagafinal($idvaga = 0)
	{
		$obj = GetModelo('vaga');
		$obj->idvaga = $idvaga;
		if(!$obj->Load())
		{
			$linkRetorno = site_url('vaga/dadosdacontratante');
			redirect($linkRetorno);
		}
		$data['obj'] = $obj;
		$this->gestao->GetView('vaga/dadosdavagafinal', $data);
	}
	#######################################################################################################
	public function candidatos()
	{
		$data['obj'] = GetModelo('vaga');
		$this->gestao->GetView('errors/emconstrucao', $data);
	}
	#######################################################################################################
	public function pdf_vaga($idvaga = 0)
	{
		$obj = GetModelo('vaga');
		$obj->idvaga = $idvaga;
		if(!$obj->Load())
		{
			$linkRetorno = site_url('vaga/dadosdacontratante');
			redirect($linkRetorno);
		}
		$data['obj'] = $obj;
		$codigo = $obj->LerCodigoVaga();
		$file = AcertaNomeArquivo("{$obj->titulodavaga} {$obj->empresacontratante} {$codigo}").".pdf";
		/*$this->load->view("vaga/pdf", $data);*/
		$this->load->library('Pdf');
		$this->pdf->load_view('vaga/pdf', $data);
		$this->pdf->set_option('isRemoteEnabled', TRUE); 
		$this->pdf->setPaper('A4', 'portrait');
		$this->pdf->render();
		$this->pdf->stream($file, ["Attachment"=>false]);
	}
}
?>