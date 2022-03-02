<?php
/***********************************************************************
 * Module:  /controllers/Projeto.PHP
 * Author:  Host-up
 * Date:	01/03/2022 21:56:32
 * Purpose: Definição da Classe Projeto
 ***********************************************************************/

defined('BASEPATH') OR exit(__("Nenhum acesso de script direto permitido"));

class Projeto extends CI_Controller {
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
		$projeto = GetModelo('projeto');
		$linkRetorno = GetReferencia('projeto/listar');
		if( !empty($id))
		{
			$projeto->idprojeto = $id;
			if(!$projeto->Load())
			{
				$data = array('act'=>__("Erro"),'titulo'=>__("Projeto não foi localizado."));
				$this->load->library('layout/erro', $data );
				return;
			}
			$this->gestao->SetBreadcrumbs("Editar",site_url('projeto/listar'), 'Projeto');
			$projeto->Ajustar();
			$data['obj'] = $projeto;
		}
		else
		{
			$this->gestao->SetBreadcrumbs("Novo cadastro",site_url('projeto/listar'), 'Projeto');
			$projeto->Ajustar();
			$data['obj'] = $projeto;
		}
		$this->load->library('form_validation');
		
		$this->form_validation->set_rules( 'idprojeto', __("idprojeto"), 'required' );
		$this->form_validation->set_rules( 'idgestor', __("idgestor"), 'required' );
		$this->form_validation->set_rules( 'idarea', __("idarea"), 'required' );
		$this->form_validation->set_rules( 'nome', __("nome"), 'required' );
		$this->form_validation->set_rules( 'idcliente', __("idcliente"), 'required' );
		$this->form_validation->set_rules( 'ip', __("ip"), 'required' );
		$this->form_validation->set_rules( 'cadastradoem', __("cadastradoem"), 'required' );

		if( $this->form_validation->run() === FALSE )
		{
			$this->gestao->GetView('projeto/editar', $data);
		}
		else
		{
			$post = $this->gestao->Request($projeto->GetDefault());
			$projeto->Carregar($post);
			$projeto->Ajustar(true);
			if(!$projeto->Salvar())
			{
				$data = array('act'=>"Erro",'titulo'=>__("Não foi possível salvar os dados do projeto."));
				$this->gestao->GetView('layout/erro', $data);
				return;
			}
			if(!empty($id))
			{
				message( 'success', 'msg_flash', __("Projeto foi editado com sucesso!") );
			}
			else
			{
				message( 'success', 'msg_flash', __("Projeto foi adicionado com sucesso!") );
			}
			redirect($linkRetorno);
		}
	}
	#######################################################################################################
	public function excluir($id = 0)
	{
		$projeto = GetModelo('projeto');
		if(!empty($id))
		{
			$projeto->idprojeto = $id;
			if($projeto->Apagar())
			{
				message( 'success', 'msg_flash', __("Projeto foi excluido com sucesso!") );
			}
			else
			{
				message( 'warning', 'msg_flash', __("Não foi possível excluir o projeto.") );
			}
		}
		else
		{
			message( 'warning', 'msg_flash', __("Não foi possível localizar o projeto.") );
		}
		redirect( 'projeto/listar' );
	}
	#######################################################################################################
	public function listar()
	{
		$this->gestao->SetBreadcrumbs("Lista de Projeto");
		self::LimparProjeto();
		$data['obj'] = GetModelo('projeto');
		$this->gestao->GetView('projeto/listar', $data);
	}
	#######################################################################################################
	public function listatabela()
	{
		$obj = GetModelo('Projeto');
		$filtro = $obj->Filtro();
		$sql = $obj->GetSqlLista();
		$sqlTotal = $obj->GetSqlTotalLista();
		$dados = $obj->listatabela($filtro, $sql, $sqlTotal);
		RetornaJSON($dados);
	}
	#######################################################################################################
	public static function LimparProjeto()
	{
		$obj = GetModelo('Projeto');
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
			$test = explode('.', strtolower($e));
			$extension = end($test);
			if(($extension != "xlsx")&&($extension != "xls")&&($extension != "csv"))
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
	public function exportarprojeto()
	{
		$obj = GetModelo('projeto');
		if($obj)
		{
			$dados = $obj->ExportarProjeto();
		}
		else
		{
			$dados['sucesso'] = false;
			$dados['erro'] = __("Erro ao carregar a classe do projeto.");
		}
		RetornaJSON($dados);
	}
	#######################################################################################################
	public function baixarprojeto($file = "")
	{
		if(empty($file))
		{
			$data = array('act'=>__("Erro"),'titulo'=>__("Nome do arquivo não foi enviado ao sistema."));
			$this->gestao->GetView('layout/erro', $data );
			return;
		}
		
		$obj = GetModelo('projeto');
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
			$name = "importacao_projeto_";
			$name .= date("Y-m-d_H-i-s_");
			$name .= rand(100,999).'.'.$extension;
			$obj = GetModelo("projeto");
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
		$obj = GetModelo('projeto');
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
				$dados['mensagem'] = __("Importação de projeto está sendo processada.");
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
				$dados['mensagem'] = __("Importação de projeto finalizada com sucesso.");
				$dados['posicao'] = $posicao + $limite;
				$dados['total'] = $total;
			}
		}
		else
		{
			$dados['sucesso'] = false;
			$dados['erro'] = __("Erro ao localizar o registro de importação de projeto.");
		}
		RetornaJSON($dados);
	}
}
?>