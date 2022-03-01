<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Painel extends CI_Controller {
	
	#######################################################################################################
	function __construct()
	{
		try
		{
			parent::__construct();
		}
		catch( Exception $e )
		{
			throw new Exception( $e );
		}
	}
	#######################################################################################################
	public function index()
	{
		$this->login();
	}
	#######################################################################################################
	public function home()
	{	
		$data['obj'] = GetModelo('vaga');
		$this->gestao->GetViewSite('home', $data);
	}
	#######################################################################################################
	public function login()
	{
		if(GetAcesso())
		{
			$cliente = GetModelo('cliente');
			$linkRetorno = $cliente->GetLinkAbertura();
			redirect($linkRetorno);
		}
		$data['email'] = Get("email", "");
		$data['senha'] = Get("senha", "");		
		$this->gestao->GetViewSign('painel/login', $data );
	}
	#######################################################################################################
	public function cadastro()
	{
		if(GetAcesso())
		{ 
			$linkRetorno = site_url("vaga/dashboard");
			//redirect($linkRetorno);
		}
		$data['email'] = Get("email", "");
		$data['nome'] = "";
		$data['empresa'] = "";
		$data['senha'] = "";
		$data['acesso'] = "";
		$this->gestao->GetViewSign('painel/cadastro', $data );
	}
	#######################################################################################################
	public function recuperarsenha()
	{
		if(GetAcesso())
		{ 
			$linkRetorno = site_url("vaga/dashboard");
			redirect($linkRetorno);
		}
		$data['email'] = Get("email", "");
		$this->gestao->GetViewSign('painel/recuperarsenha', $data );
	}
	#######################################################################################################
	public function logout()
	{
		$this->session->sess_destroy();
		redirect( 'painel/login' );
	}	
	#######################################################################################################
	public function ajuda()
	{
		$data['obj'] = GetModelo('vaga');
		$this->gestao->GetView('errors/emconstrucao', $data);
	}		
	#######################################################################################################
	public function politicadeprivacidade()
	{
		$file = dirname(dirname(BASEPATH)) ."/painel/arquivos/politicadeprivacidade/candidatoagora_politica_de_privacidade.pdf";
		header('Content-type: application/pdf');
		header('Content-Disposition: inline; filename='.basename($file));
		header('Content-Transfer-Encoding: binary');
		header('Pragma: public');
		header('Content-Length: ' . filesize($file));
		ob_clean();
		flush();
		readfile($file);
		exit();
	}
	
	#######################################################################################################
	public function erro()
	{
		$msgFlash = $this->session->flashdata('msg_flash');
		if(!empty($msgFlash))
			$data = array('act'=>__("Erro"),'titulo'=>$msgFlash);
		else
			$data = array('act'=>__("Erro"),'titulo'=>__("Ocorreu um erro desconhecido."));
		$this->gestao->GetView( 'layout/erro', $data );
		return;
	}
	#######################################################################################################
	public function _checkLogin($senha)
	{
		$obj = GetModelo("colaborador");
		$obj->email = $this->input->post('email');
		$obj->senha = $senha;
		if(!filter_var($obj->email, FILTER_VALIDATE_EMAIL))
		{
			$this->form_validation->set_message( '_checkLogin', __("O e-mail informado é invalido."));
			return FALSE;
		}
		
		if(!$obj->Login()):
			$this->form_validation->set_message( '_checkLogin', __("E-mail ou senha incorretos."));
			return FALSE;
		else:
			return TRUE;
		endif;
	}
	#######################################################################################################
	public function _checkEmail($email = "")
	{
		$obj = GetModelo("colaborador");
		$obj->email = $email;
		if(!filter_var($obj->email, FILTER_VALIDATE_EMAIL))
		{
			$this->form_validation->set_message( '_checkEmail', __("O e-mail informado é invalido."));
			return FALSE;
		}
		
		if(!$obj->EmailExiste()):
			$this->form_validation->set_message( '_checkEmail', __("Este e-mail não existe em nossa base de dados."));
			return FALSE;
		else:
			return TRUE;
		endif;
	}
	#######################################################################################################
	public function teste($id = 0)
	{
		$dados = FormataData("09/1967 11:32:43","d/m/Y H:i:s");
		P($dados);
	}
}
