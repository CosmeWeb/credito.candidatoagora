<?php
/***********************************************************************
 * Module:  /controllers/Pais.PHP
 * Author:  Host-up
 * Date:	24/03/2020 00:23:20
 * Purpose: Definição da Classe Pais
 ***********************************************************************/

defined('BASEPATH') OR exit(__("Nenhum acesso de script direto permitido"));

class Pais extends CI_Controller {
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
		$pais = GetModelo('pais');
		$linkRetorno = GetReferencia('pais/listar');
		if( !empty($id))
		{
			$pais->idpais = $id;
			if(!$pais->Load())
			{
				$data = array('act'=>__("Erro"),'titulo'=>__("País não foi localizado."));
				call_view( 'layout/erro', $data );
				return;
			}
			$this->gestao->SetBreadcrumbs("Editar",site_url('pais/listar'), 'País');
			$data['obj'] = $pais;
		}
		else
		{
			$this->gestao->SetBreadcrumbs("Novo cadastro",site_url('pais/listar'), 'País');
			$data['obj'] = $pais;
		}
		$this->load->library('form_validation');
		$this->form_validation->set_rules( 'pais', __("país"), 'required' );
		$this->form_validation->set_rules( 'sigla', __("sigla"), 'required' );

		if( $this->form_validation->run() === FALSE )
		{
			$this->gestao->GetView('pais/editar', $data);
		}
		else
		{
			$post = $this->gestao->Request($pais->GetDefault());
			$pais->Carregar($post);
			if(!$pais->Salvar())
			{
				$data = array('act'=>"Erro",'titulo'=>__("Não foi possível salvar os dados do país."));
				$this->gestao->GetView('layout/erro', $data);
				return;
			}
			if(!empty($id))
			{
				message( 'success', 'msg_flash', __("País foi editado com sucesso!") );
			}
			else
			{
				message( 'success', 'msg_flash', __("País foi adicionado com sucesso!") );
			}
			redirect($linkRetorno);
		}
	}
	#######################################################################################################
	public function excluir($id = 0)
	{
		$pais = GetModelo('pais');
		if(!empty($id))
		{
			$pais->idpais = $id;
			if($pais->Apagar())
			{
				message( 'success', 'msg_flash', __("País foi excluido com sucesso!") );
			}
			else
			{
				message( 'warning', 'msg_flash', __("Não foi possível excluir o país.") );
			}
		}
		else
		{
			message( 'warning', 'msg_flash', __("Não foi possível localizar o país.") );
		}
		redirect( 'pais/listar' );
	}
	#######################################################################################################
	public function listar()
	{
		$this->gestao->SetBreadcrumbs("Lista de País");
		self::LimparPais();
		$data['obj'] = GetModelo('pais');
		$this->gestao->GetView('pais/listar', $data);
	}
	#######################################################################################################
	public function listatabela()
	{
		$obj = GetModelo('Pais');
		$filtro = $obj->Filtro();
		$sql = $obj->GetSqlLista();
		$sqlTotal = $obj->GetSqlTotalLista();
		$dados = $obj->listatabela($filtro, $sql, $sqlTotal);
		echo json_encode($dados);
	}
	#######################################################################################################
	public static function LimparPais()
	{
		$obj = GetModelo('Pais');
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
	public function exportarpais()
	{
		$obj = GetModelo('pais');
		if($obj)
		{
			$dados = $obj->ExportarPais();
		}
		else
		{
			$dados['sucesso'] = false;
			$dados['erro'] = __("Erro ao carregar a classe do país.");
		}
		RetornaJSON($dados);
	}
	#######################################################################################################
	public function baixarpais($file = "")
	{
		if(empty($file))
		{
			$data = array('act'=>__("Erro"),'titulo'=>__("Nome do arquivo não foi enviado ao sistema."));
			$this->gestao->GetView('layout/erro', $data );
			return;
		}
		
		$obj = GetModelo('pais');
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
			$name = "importacao_pais_";
			$name .= date("Y-m-d_H-i-s_");
			$name .= rand(100,999).'.'.$extension;
			$obj = GetModelo("pais");
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
		$obj = GetModelo('pais');
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
				$dados['mensagem'] = __("Importação de país está sendo processada.");
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
				$dados['mensagem'] = __("Importação de país finalizada com sucesso.");
				$dados['posicao'] = $posicao + $limite;
				$dados['total'] = $total;
			}
		}
		else
		{
			$dados['sucesso'] = false;
			$dados['erro'] = __("Erro ao localizar o registro de importação de país.");
		}
		RetornaJSON($dados);
	}
}
?>