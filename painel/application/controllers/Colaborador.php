<?php 
/***********************************************************************
 * Module:  /controllers/Colaborador.PHP
 * Author:  Host-up
 * Date:	23/11/2018 02:55:44
 * Purpose: Definição da Classe Colaborador
 ***********************************************************************/

defined('BASEPATH') OR exit(__("Nenhum acesso de script direto permitido"));

class Colaborador extends CI_Controller {
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
	public function editar($id = 0)
	{
		$colaborador = GetModelo('colaborador');
		$linkRetorno = GetReferencia('colaborador/listar');
		if( !empty($id))
		{
			if(TemAcesso(array('Colaborador')))
			{
				$idcolaborador = GetAcesso("idcolaborador", 0);
				if($idcolaborador != $id)
				{
					$data = array('act'=>__("Erro"),'titulo'=>__("Você não possui permissão para acessar este colaborador."));
					$this->gestao->GetView('layout/erro', $data );
					return;
				}	
			}
			$colaborador->idcolaborador = $id;
			if(!$colaborador->Load())
			{
				$data = array('act'=>__("Erro"),'titulo'=>__("Colaborador não foi localizado."));
				$this->gestao->GetView('layout/erro', $data );
				return;
			}
			$this->gestao->SetBreadcrumbs("Editar",site_url('colaborador/listar'), 'Colaboradores');
			$data['obj'] = $colaborador;
			$senha = $colaborador->senha;
			$salt = $colaborador->salt;
		}
		else
		{
			$this->gestao->SetBreadcrumbs("Novo cadastro",site_url('colaborador/listar'), 'Colaboradores');
			$data['obj'] = $colaborador;
			$senha = "";
			$salt = "";
		}
		$this->load->library( 'form_validation' );
		
		$this->form_validation->set_rules( 'nome', __("nome"), 'required' );
		$this->form_validation->set_rules( 'email', __("email"), 'required|valid_email|callback__checkEmail' );
		if(empty($id))
		{
			$this->form_validation->set_rules( 'senha', __("senha"), 'required|min_length[8]' );
			$this->form_validation->set_rules( 'confirma', __("Confirmar Senha"), 'required|min_length[8]|matches[senha]' );
		}

		if( $this->form_validation->run() === FALSE )
		{
			$this->gestao->AddDashboard(__("Colaboradores"));
			$this->gestao->SetHardUpload();
			$this->gestao->GetView('colaborador/editar', $data);
		}
		else
		{
			$post = $this->gestao->Request($colaborador->GetDefault());
			$colaborador->Carregar($post);
			if((!empty($post['senha']))||(empty($senha)))
			{
				$colaborador->GerarSenha($post['senha']);
			}
			else
			{
				$colaborador->salt = $salt;
				$colaborador->senha = $senha;
			}
			$colaborador->Ajustar(true);
			if(!$colaborador->Salvar())
			{
				$data = array('act'=>"Erro",'titulo'=>__("Não foi possível salvar os dados do Colaborador."));
				$this->gestao->GetView('layout/erro', $data);
				return;
			}
			if(!empty($id))
			{				
				message( 'success', 'msg_flash', __("Colaborador editado com sucesso!") );
			}
			else
			{
				message( 'success', 'msg_flash', __("Colaborador adicionado com sucesso!") );
			}
			redirect($linkRetorno);
		}		
	}
	#######################################################################################################
	public function alterarsenha($id = 0)
	{
		$colaborador = GetModelo('colaborador');
		if(!empty($id))
		{
			$idcolaborador = GetAcesso("idcolaborador", 0);
			if(TemAcesso(array('Colaborador')))
			{
				if($idcolaborador != $id)
				{
					$data = array('act'=>__("Erro"),'titulo'=>__("Você não possui permissão para acessar este colaborador."));
					$this->gestao->GetView('layout/erro', $data );
					return;
				}	
			}
			
			$colaborador->idcolaborador = $id;
			if(!$colaborador->Load())
			{
				$data = array('act'=>__("Erro"),'titulo'=>__("Colaborador não foi localizado.4"));
				$this->gestao->GetView('layout/erro', $data );
				return;
			}
			$this->gestao->SetBreadcrumbs("Alterar senha");
			$colaborador->senha = "";
			$data['obj'] = $colaborador;
		}
		else
		{
			$data = array('act'=>__("Erro"),'titulo'=>__("Você não possui permissão para acessar este colaborador."));
			$this->gestao->GetView('layout/erro', $data );
			return;
		}
		$this->load->library( 'form_validation' );
		
		$this->form_validation->set_rules( 'senha', __("senha"), 'required|min_length[8]' );
		$this->form_validation->set_rules( 'confirma', __("Confirmar Senha"), 'required|min_length[8]|matches[senha]' );

		if( $this->form_validation->run() === FALSE )
		{
			$this->gestao->AddDashboard(__("Colaboradores"));
			$this->gestao->SetHardUpload();
			$this->gestao->GetView('colaborador/alterarsenha', $data);
		}
		else
		{
			$post = $this->gestao->Request($colaborador->GetDefault());
			if(!empty($post['senha']))
			{
				$colaborador->GerarSenha($post['senha']);
			}
			else
			{
				$data = array('act'=>"Erro",'titulo'=>__("Não foi possível alterar sua senha.7"));
				$this->gestao->GetView('layout/erro', $data);
				return;
			}
			$dados = ["senha"=>$colaborador->senha, "salt"=>$colaborador->salt];
			if(!$colaborador->Atualizar($colaborador->GetID(), $dados))
			{
				$data = array('act'=>"Erro",'titulo'=>__("Não foi possível alterar sua senha.8"));
				$this->gestao->GetView('layout/erro', $data);
				return;
			}
			message( 'success', 'msg_flash', __("Senha foi alterada com sucesso!") );
			redirect(site_url(''));
		}		
	}
	#######################################################################################################
	public function salvarnovasenha()
	{
		$idcolaborador = Get("idcolaborador", 0);
		$senha = Get("senha", "");
		$obj = GetModelo("colaborador");
		if(empty($senha))
		{			
			$data['sucesso'] = false;
			$data['erro'] = __("Você deve informar a nova senha.");
			RetornaJSON($data);
			return;
		}
		if(strlen($senha) < 8)
		{			
			$data['sucesso'] = false;
			$data['erro'] = __("A senha deve conter mais de 8 Caracteres.");
			RetornaJSON($data);
			return;
		}
		if(empty($idcolaborador))
		{
			$data['sucesso'] = false;
			$data['erro'] = __("O colaborador não foi possível ser localizado.");
			RetornaJSON($data);
			return;
		}
		
		$obj->idcolaborador = $idcolaborador;
		if(!$obj->Load())
		{
			$data['sucesso'] = false;
			$data['erro'] = __("O colaborador não foi localizado.");
			RetornaJSON($data);
			return;
		}
		$obj->GerarSenha($senha);
		$dados = ["senha"=>$obj->senha, "salt"=>$obj->salt];
		$sucesso = $obj->Atualizar($obj->GetID(), $dados);
		if($sucesso)
		{
			$data['sucesso'] = true;
			$data['mensagem'] = __("Senha do colaborador foi alterada com sucesso.");
			$data['titulo'] = __("Sucesso");
		}
		else
		{
			$data['sucesso'] = true;
			$data['erro'] = __("Não foi possível alterar a senha do colaborador.");
		}
		RetornaJSON($data);
		return;
	}
	#######################################################################################################
	public function excluir($id = 0)
	{
		$this->load->model('Colaborador_model', 'colaborador');
		$colaborador = $this->colaborador->GetInstancia();
		if( !empty($id))
		{
			$colaborador->idcolaborador = $id;
			if($colaborador->Apagar())
			{
				message( 'success', 'msg_flash', __("Colaborador foi excluido com sucesso!") );
			}
			else
			{
				message( 'warning', 'msg_flash', __("Não foi possível excluir o Colaborador.") );
			}	
		}
		else
		{
			message( 'warning', 'msg_flash', __("Não foi possível localizar o Colaborador.") );
		}
		redirect( 'colaborador/listar' );
	}
	#######################################################################################################
	public function listar()
	{
		$this->gestao->AddDashboard(__("Colaboradores"));
		$this->gestao->SetBreadcrumbs("Lista de Colaboradores");
		$data['obj'] = GetModelo('colaborador');
		$this->gestao->GetView('colaborador/listar', $data);
	}
	#######################################################################################################
	public function listatabela()
	{
		$obj = GetModelo('colaborador');
		$filtro = self::Filtro();
		$sql = "";
		$dados = $obj->listatabela($filtro, $sql);
		echo json_encode($dados);
	}
	#######################################################################################################
	public static function Filtro()
	{
		$filtro = "";
		$buscar = GetFiltro("buscar");
		if(!empty($buscar))
		{
			$filtro .= " AND (nome LIKE '%{$buscar}%' OR email LIKE '%{$buscar}%' OR telefone LIKE '%{$buscar}%')";
		}
		if(!empty($filtro))
		{
			$filtro  = substr($filtro, 4);
		}
		$ordem = array('idcolaborador','foto','nome','telefone','email');
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
		$obj->idcolaborador = Get("idcolaborador",0);
		if($obj->EmailExiste()):
			$this->form_validation->set_message( '_checkEmail', __("Este e-mail já existe em nossa base de dados."));
			return FALSE;
		else:
			return TRUE;
		endif;
	}
	
}
?>