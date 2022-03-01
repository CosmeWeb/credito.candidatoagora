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
			$colaborador->idcolaborador = $id;
			if(!$colaborador->Load())
			{
				$data = array('act'=>__("Erro"),'titulo'=>__("Colaborador não foi localizado."));
				$this->gestao->GetView('layout/erro', $data );
				return;
			}
			$this->gestao->SetBreadcrumbs("Editar",site_url('colaborador/listar'), 'Colaboradores');
			$data['obj'] = $colaborador;
		}
		else
		{
			$this->gestao->SetBreadcrumbs("Novo cadastro",site_url('colaborador/listar'), 'Colaboradores');
			$data['obj'] = $colaborador;
		}
		$this->load->library( 'form_validation' );
		
		$this->form_validation->set_rules( 'nome', __("nome"), 'required' );
		$this->form_validation->set_rules( 'email', __("email"), 'required|valid_email|callback__checkEmail' );
		$this->form_validation->set_rules( 'senha', __("senha"), 'required|min_length[8]' );
		$this->form_validation->set_rules( 'confirma', __("Confirmar Senha"), 'required|min_length[8]|matches[senha]' );

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