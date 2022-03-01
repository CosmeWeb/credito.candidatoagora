<?php
/***********************************************************************
 * Module:  /controllers/Nacionalidade.PHP
 * Author:  Host-up
 * Date:	06/04/2020 16:18:08
 * Purpose: Definição da Classe Nacionalidade
 ***********************************************************************/

defined('BASEPATH') OR exit(__("Nenhum acesso de script direto permitido"));

class Nacionalidade extends CI_Controller {
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
		$nacionalidade = GetModelo('nacionalidade');
		$linkRetorno = GetReferencia('nacionalidade/listar');
		if( !empty($id))
		{
			$nacionalidade->idnacionalidade = $id;
			if(!$nacionalidade->Load())
			{
				$data = array('act'=>__("Erro"),'titulo'=>__("Nacionalidade não foi localizada."));
				call_view( 'layout/erro', $data );
				return;
			}
			$this->gestao->SetBreadcrumbs("Editar",site_url('nacionalidade/listar'), 'Nacionalidade');
			$data['obj'] = $nacionalidade;
		}
		else
		{
			$this->gestao->SetBreadcrumbs("Novo cadastro",site_url('nacionalidade/listar'), 'Nacionalidade');
			$data['obj'] = $nacionalidade;
		}
		$this->load->library('form_validation');
		
		$this->form_validation->set_rules( 'nacionalidade', __("nacionalidade"), 'required' );

		if( $this->form_validation->run() === FALSE )
		{
			$this->gestao->GetView('nacionalidade/editar', $data);
		}
		else
		{
			$post = $this->gestao->Request($nacionalidade->GetDefault());
			$nacionalidade->Carregar($post);
			$nacionalidade->Ajustar(true);
			if(!$nacionalidade->Salvar())
			{
				$data = array('act'=>"Erro",'titulo'=>__("Não foi possível salvar os dados da nacionalidade."));
				$this->gestao->GetView('layout/erro', $data);
				return;
			}
			if(!empty($id))
			{
				message( 'success', 'msg_flash', __("Nacionalidade foi editada com sucesso!") );
			}
			else
			{
				message( 'success', 'msg_flash', __("Nacionalidade foi adicionada com sucesso!") );
			}
			redirect($linkRetorno);
		}
	}
	#######################################################################################################
	public function excluir($id = 0)
	{
		$nacionalidade = GetModelo('nacionalidade');
		if(!empty($id))
		{
			$nacionalidade->idnacionalidade = $id;
			if($nacionalidade->Apagar())
			{
				message( 'success', 'msg_flash', __("Nacionalidade foi excluida com sucesso!") );
			}
			else
			{
				message( 'warning', 'msg_flash', __("Não foi possível excluir a nacionalidade.") );
			}
		}
		else
		{
			message( 'warning', 'msg_flash', __("Não foi possível localizar a nacionalidade.") );
		}
		redirect( 'nacionalidade/listar' );
	}
	#######################################################################################################
	public function listar()
	{
		$this->gestao->SetBreadcrumbs("Lista de Nacionalidade");
		self::LimparNacionalidade();
		$data['obj'] = GetModelo('nacionalidade');
		$this->gestao->GetView('nacionalidade/listar', $data);
	}
	#######################################################################################################
	public function listatabela()
	{
		$obj = GetModelo('Nacionalidade');
		$filtro = $obj->Filtro();
		$sql = $obj->GetSqlLista();
		$sqlTotal = $obj->GetSqlTotalLista();
		$dados = $obj->listatabela($filtro, $sql, $sqlTotal);
		echo json_encode($dados);
	}
	#######################################################################################################
	public static function LimparNacionalidade()
	{
		$obj = GetModelo('Nacionalidade');
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
	public function exportarnacionalidade()
	{
		$obj = GetModelo('nacionalidade');
		if($obj)
		{
			$dados = $obj->ExportarNacionalidade();
		}
		else
		{
			$dados['sucesso'] = false;
			$dados['erro'] = __("Erro ao carregar a classe da nacionalidade.");
		}
		RetornaJSON($dados);
	}
	#######################################################################################################
	public function baixarnacionalidade($file = "")
	{
		if(empty($file))
		{
			$data = array('act'=>__("Erro"),'titulo'=>__("Nome do arquivo não foi enviado ao sistema."));
			$this->gestao->GetView('layout/erro', $data );
			return;
		}
		
		$obj = GetModelo('nacionalidade');
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
			$name = "importacao_nacionalidade_";
			$name .= date("Y-m-d_H-i-s_");
			$name .= rand(100,999).'.'.$extension;
			$obj = GetModelo("nacionalidade");
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
		$obj = GetModelo('nacionalidade');
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
				$dados['mensagem'] = __("Importação de nacionalidade está sendo processada.");
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
				$dados['mensagem'] = __("Importação de nacionalidade finalizada com sucesso.");
				$dados['posicao'] = $posicao + $limite;
				$dados['total'] = $total;
			}
		}
		else
		{
			$dados['sucesso'] = false;
			$dados['erro'] = __("Erro ao localizar o registro de importação de nacionalidade.");
		}
		RetornaJSON($dados);
	}
}
?>