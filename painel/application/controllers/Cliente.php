<?php
/***********************************************************************
 * Module:  /controllers/Cliente.PHP
 * Author:  Host-up
 * Date:	13/05/2020 21:03:18
 * Purpose: Definição da Classe Cliente
 ***********************************************************************/

defined('BASEPATH') OR exit(__("Nenhum acesso de script direto permitido"));

class Cliente extends CI_Controller {
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
	public function editar($id = 0)
	{
		$cliente = GetModelo('cliente');
		$linkRetorno = GetReferencia('cliente/listar');
		if( !empty($id))
		{
			$cliente->idcliente = $id;
			if(!$cliente->Load())
			{
				$data = array('act'=>__("Erro"),'titulo'=>__("Cliente não foi localizado."));
				$this->gestao->GetView('layout/erro', $data );
				return;
			}
			$this->gestao->SetBreadcrumbs("Editar",site_url('cliente/listar'), 'Cliente');
			$data['obj'] = $cliente;
		}
		else
		{
			$this->gestao->SetBreadcrumbs("Novo cadastro",site_url('cliente/listar'), 'Cliente');
			$data['obj'] = $cliente;
		}
		$this->load->library('form_validation');
		
		$this->form_validation->set_rules( 'nome', __("nome"), 'required' );
		$this->form_validation->set_rules( 'email', __("email"), 'required|valid_email|callback__checkEmail' );
		$this->form_validation->set_rules( 'senha', __("senha"), 'required|min_length[8]' );
		$this->form_validation->set_rules( 'confirma', __("Confirmar Senha"), 'required|min_length[8]|matches[senha]' );
		$this->form_validation->set_rules( 'status', __("status"), 'required' );

		if( $this->form_validation->run() === FALSE )
		{
			$this->gestao->GetView('cliente/editar', $data);
		}
		else
		{
			$post = $this->gestao->Request($cliente->GetDefault());
			$cliente->Carregar($post);
			$cliente->Ajustar(true);
			if(!$cliente->Salvar())
			{
				$data = array('act'=>"Erro",'titulo'=>__("Não foi possível salvar os dados do cliente."));
				$this->gestao->GetView('layout/erro', $data);
				return;
			}
			if(!empty($id))
			{
				message( 'success', 'msg_flash', __("Cliente foi editado com sucesso!") );
			}
			else
			{
				message( 'success', 'msg_flash', __("Cliente foi adicionado com sucesso!") );
			}
			redirect($linkRetorno);
		}
	}
	#######################################################################################################
	public function alterarsenhacliente()
	{
		$data['obj'] = GetModelo('cliente');
		$this->gestao->GetView('cliente/alterarsenhacliente', $data);		
	}
	#######################################################################################################
	public function alterarsenha()
	{
		$obj = GetModelo('cliente');
		if($obj)
		{
			$dados = $obj->AlterarSenha();
		}
		else
		{
			$dados['sucesso'] = false;
			$dados['erro'] = __("Erro ao carregar a classe do cliente.");
		}
		RetornaJSON($dados);
	}
	#######################################################################################################
	public function excluir($id = 0)
	{
		$cliente = GetModelo('cliente');
		if(!empty($id))
		{
			$cliente->idcliente = $id;
			if($cliente->Apagar())
			{
				message( 'success', 'msg_flash', __("Cliente foi excluido com sucesso!") );
			}
			else
			{
				message( 'warning', 'msg_flash', __("Não foi possível excluir o cliente.") );
			}
		}
		else
		{
			message( 'warning', 'msg_flash', __("Não foi possível localizar o cliente.") );
		}
		redirect( 'cliente/listar' );
	}
	#######################################################################################################
	public function listar()
	{
		$this->gestao->SetBreadcrumbs("Lista de Cliente");
		self::LimparCliente();
		$data['obj'] = GetModelo('cliente');
		$this->gestao->GetView('cliente/listar', $data);
	}
	#######################################################################################################
	public function listatabela()
	{
		$obj = GetModelo('Cliente');
		$filtro = $obj->Filtro();
		$sql = $obj->GetSqlLista();
		$sqlTotal = $obj->GetSqlTotalLista();
		$dados = $obj->listatabela($filtro, $sql, $sqlTotal);
		echo json_encode($dados);
	}
	#######################################################################################################
	public static function LimparCliente()
	{
		$obj = GetModelo('Cliente');
		$path = $obj->SetDominio();
		if(!is_dir($path))
		{
			return;
		}
		$diretorio = dir($path);
		if(empty($diretorio))
		{
			return;
		}
		$datalimpeza = date("d/m/Y H:i:s",DiaAdd(false, -2));
		while (($e = $diretorio->read()) !== false)
		{
			if (($e==".")||($e==".."))
			{
				continue;
			}
			if (is_dir($path.$e))
			{
				continue;
			}
			$arquivo = $path.$e;
			$datafile = date("d/m/Y H:i:s",filemtime($arquivo));
			if(ComparaData($datafile, $datalimpeza) <= 0)
				unlink($arquivo);
		}
		return;
	}
	#######################################################################################################
	public function exportarcliente()
	{
		$obj = GetModelo('cliente');
		if($obj)
		{
			$dados = $obj->ExportarCliente();
		}
		else
		{
			$dados['sucesso'] = false;
			$dados['erro'] = __("Erro ao carregar a classe do cliente.");
		}
		RetornaJSON($dados);
	}
	#######################################################################################################
	public function baixarcliente($file = "")
	{
		if(empty($file))
		{
			$data = array('act'=>__("Erro"),'titulo'=>__("Nome do arquivo não foi enviado ao sistema."));
			$this->gestao->GetView('layout/erro', $data );
			return;
		}
		
		$obj = GetModelo('cliente');
		$file = $obj->GetCaminho($file);
		if(!$obj->FileExiste($file))
		{
			$data = array('act'=>__("Erro"),'titulo'=>__("Arquivo não foi localizado em nosso sistema."));
			$this->gestao->GetView('layout/erro', $data );
			return;
		}
		header('Content-Description: File Transfer');
		header('Content-Type: application/octet-stream');
		header('Content-Disposition: attachment; filename='.basename($file));
		header('Content-Transfer-Encoding: binary');
		header('Expires: 0');
		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		header('Pragma: public');
		header('Content-Length: ' . filesize($file));
		ob_clean();
		flush();
		readfile($file);
		exit();
	}
	#######################################################################################################
	public function enviarexcel()
	{
		if(!empty($_FILES['file']['name']))
		{
			$test = explode('.', $_FILES['file']['name']);
			$extension = end($test);
			$name = "importacao_cliente_";
			$name .= date("Y-m-d_H-i-s_");
			$name .= rand(100,999).'.'.$extension;
			$obj = GetModelo("cliente");
			$caminho = $obj->SetDominio();
			if(!is_dir($caminho))
			{
				CriarPastas($caminho);
			}
			$location = $caminho.$name;
			if(!move_uploaded_file($_FILES['file']['tmp_name'], $location))
			{
				$dados['sucesso'] = false;
				$dados['erro'] = __("Erro ao localizar o arquivo.");
			}
			else
			{
				$erro = $obj->VerificarArquivo($name);
				if(empty($erro))
				{
					$dados['sucesso'] = true;
					$dados['arquivo'] = $location;
					$dados['caminho'] = $obj->SetDominio();
					$dados['file'] = $name;
					$dados['total'] = $obj->LerTotalRows($name);
				}
				else
				{
					$dados['sucesso'] = false;
					$dados['erro'] = $erro;
					unlink($location);
				}
			}
		}
		else
		{
			$dados['sucesso'] = false;
			$dados['erro'] = __("Erro ao localizar o arquivo.");
		}
		RetornaJSON($dados);
	}
	#######################################################################################################
	public function importacaoexcel()
	{
		$file = Get('file');
		$posicao = Get('posicao');
		$total = Get('total');
		$obj = GetModelo('cliente');
		$arquivo = $obj->SetDominio($file);
		if($obj->FileExiste($arquivo))
		{
			$limite = $total - $posicao;
			if($limite > self::$limiteimportacao)
			{
				if(!$obj->Importar($posicao, self::$limiteimportacao, $file))
				{
					$dados['sucesso'] = false;
					$dados['erro'] = __("Erro no processo de importação do excel para o banco.");
					RetornaJSON($dados);
					return;
				}
				$dados['sucesso'] = true;
				$dados['status'] = "Processando";
				$dados['file'] = $file;
				$dados['mensagem'] = __("Importação de cliente está sendo processada.");
				$dados['posicao'] = $posicao + self::$limiteimportacao;
				$dados['total'] = $total;
			}
			else
			{
				if(!$obj->Importar($posicao, $limite, $file))
				{
					$dados['sucesso'] = false;
					$dados['erro'] = __("Erro no processo de importação do excel para o banco.");
					RetornaJSON($dados);
					return;
				}
				$dados['sucesso'] = true;
				$dados['status'] = "Finalizado";
				$dados['file'] = $file;
				$dados['mensagem'] = __("Importação de cliente finalizada com sucesso.");
				$dados['posicao'] = $posicao + $limite;
				$dados['total'] = $total;
			}
		}
		else
		{
			$dados['sucesso'] = false;
			$dados['erro'] = __("Erro ao localizar o registro de importação de cliente.");
		}
		RetornaJSON($dados);
	}
	#######################################################################################################
	public function buscarfiltrosdeclientes()
	{
		$obj = GetModelo('cliente');
		$dados = $obj->BuscarFiltrosDeClientes();
		RetornaJSON($dados);
		return;
	}
	#######################################################################################################
	public function _checkEmail($email = "")
	{
		$obj = GetModelo("cliente");
		$obj->email = $email;
		if(!filter_var($obj->email, FILTER_VALIDATE_EMAIL))
		{
			$this->form_validation->set_message( '_checkEmail', __("O e-mail informado é invalido."));
			return FALSE;
		}
		$obj->idcliente = Get("idcliente",0);
		if($obj->EmailExiste()):
			$this->form_validation->set_message( '_checkEmail', __("Este e-mail já existe em nossa base de dados."));
			return FALSE;
		else:
			return TRUE;
		endif;
	}
}
?>