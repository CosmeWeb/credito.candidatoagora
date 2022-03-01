<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Painel extends CI_Controller {
	
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
	public function index()
	{
		$this->home();
	}
	#######################################################################################################
	public function home()
	{
		$JS = array("vendors/flot-chart/jquery.flot.js",
			"vendors/flot-chart/jquery.flot.categories.js",
			"vendors/flot-chart/jquery.flot.pie.js",
			"vendors/flot-chart/jquery.flot.tooltip.js",
			"vendors/flot-chart/jquery.flot.resize.js",
			"vendors/flot-chart/jquery.flot.fillbetween.js",
			"vendors/flot-chart/jquery.flot.stack.js",
			"vendors/flot-chart/jquery.flot.spline.js");
		$this->gestao->AddJS($JS);
		$titulo = __("Dashboard – Dados de Avaliados");
		$this->gestao->AddDashboard($titulo);
		$this->gestao->GetView('painel/dashboard');
	}
	#######################################################################################################
	public function login()
	{
		$colaborador = GetModelo("colaborador");
		$data['obj'] = $colaborador;
		
		$this->load->library( 'form_validation' );
		
		$this->form_validation->set_rules( 'email', __("e-mail"), 'required|valid_email' );
		$this->form_validation->set_rules( 'senha', __("senha"), 'required|min_length[8]|callback__checkLogin' );
		
		if( $this->form_validation->run() === FALSE )
		{
			$this->load->view('painel/login', $data );
		}
		else
		{
			$colaborador->email = $this->input->post('email');
			$colaborador->senha = $this->input->post('senha');
			
			if(!$colaborador->Login())
			{
				message( 'error', 'msg_flash', __("Erro ao carrega os dados do colaborador!") );
				$linkRetorno = GetReferencia('painel/login');
				redirect($linkRetorno);
			}
			else
			{
				$this->session->set_userdata($colaborador->GetDados());
				message( 'success', 'msg_flash', __("Login realizado com sucesso!") );
				$linkRetorno = GetReferencia('painel/home');
				redirect($linkRetorno);
			}
		}
	}
	#######################################################################################################
	public function recuperarsenha()
	{
		$colaborador = GetModelo("colaborador");
		$data['obj'] = $colaborador;
		
		$this->load->library( 'form_validation' );
		
		$this->form_validation->set_rules( 'email', __("e-mail"), 'required|valid_email|callback__checkEmail' );
		
		if( $this->form_validation->run() === FALSE )
		{
			$this->load->view('painel/recuperarsenha', $data );
		}
		else
		{
			message( 'info', 'msg_flash', __("Sua senha foi enviada para o e-amil informado com sucesso!") );
			$linkRetorno = GetReferencia('painel/login');
			redirect($linkRetorno);
		}
	}
	#######################################################################################################
	public function logout()
	{
		$this->session->sess_destroy();
		redirect( 'painel/login' );
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
	/*
	#######################################################################################################
	public function teste($id = 0)
	{
		$obj = GetModelo("candidatoperfil");
		$filtro = false;
		$sql = "SELECT DISTINCT CV.* FROM candidatovaga CV INNER JOIN vaga V ON(CV.idvaga = V.idvaga) WHERE V.idvaga = '3' AND CV.idcandidato > '{$id}' ORDER BY CV.idcandidato ASC LIMIT 50";
		$objs = $obj->FiltroObjetos($filtro, $sql);
		if($objs)
		{
			$obj = GetModelo("candidatoidioma");
			foreach($objs as $key=>$candidato)
			{
				$filtro = "idcandidato = '{$candidato->idcandidato}'";
				$d = (rand(1,300)%6) + 1;
				if($obj->Load($filtro))
				{
					if($obj->ididioma == $d)
						$d = (rand(1,300)%6) + 1;
				}
				$obj->idcandidatoidioma = 0;
				$obj->idcandidato = $candidato->idcandidato;
				$obj->ididioma = $d;
				$obj->Salvar();
				$id = $candidato->idcandidato;
				P($obj);				
			}
			$url = site_url("painel/teste/{$id}");
			echo '<html><head><meta http-equiv="refresh" content="3,'.$url.'"></head><body></body></html>';
		}
		else
			P("Finalizado.");
	}
	#######################################################################################################
	public function teste($id = 0)
	{
		$obj = GetModelo("candidato");
		$filtro = "idcandidato > '{$id}' ORDER BY idcandidato ASC LIMIT 500";
		$objs = $obj->FiltroObjetos($filtro);
		if($objs)
		{
			foreach($objs as $key=>$obj)
			{
				$nome = gerarSenha($tam = 10,"Normal");
				$obj->email = $nome."@candidatoagora.com.br";
				$obj->telefone = gerarSenha(2,"Numerico")."-98".gerarSenha(3,"Numerico")."-".gerarSenha(4,"Numerico");
				$obj->linkedin = "linkedin.com/in/".$nome;
				$obj->twitter = "https://twitter.com/".$nome;
				$obj->Salvar();
				P($obj);
				$id = $obj->idcandidato;
			}
			$url = site_url("painel/teste/{$id}");
			echo '<html><head><meta http-equiv="refresh" content="3,'.$url.'"></head><body></body></html>';
		}
		else
			P("Finalizado.");
	}
	#######################################################################################################
	public function teste($id = 0)
	{
		$obj = GetModelo('Rastreio');
		$idcliente = "10";
		$dia = "2020-11-27";
		$obj->GetFaixadeTempo($idcliente, $dia);
	}
	*/
	#######################################################################################################
	public function teste($id = 0)
	{		
		$obj = GetModelo('candidato');
		$obj->LerListaCandidatos();
		P($this->db->queries);
	}
}
