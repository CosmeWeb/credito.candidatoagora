<?php
/***********************************************************************
 * Module:  /controllers/Candidato.PHP
 * Author:  Host-up
 * Date:	25/06/2020 15:28:56
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
	public function editar($id = 0)
	{
		$candidato = GetModelo('candidato');
		$linkRetorno = GetReferencia('candidato/listar');
		if( !empty($id))
		{
			$candidato->idcandidato = $id;
			if(!$candidato->Load())
			{
				$data = array('act'=>__("Erro"),'titulo'=>__("Candidato não foi localizado."));
				$this->load->library('layout/erro', $data );
				return;
			}
			$this->gestao->SetBreadcrumbs("Editar",site_url('candidato/listar'), 'Candidato');
			$candidato->Ajustar();
			$data['obj'] = $candidato;
		}
		else
		{
			$this->gestao->SetBreadcrumbs("Novo cadastro",site_url('candidato/listar'), 'Candidato');
			$data['obj'] = $candidato;
		}
		$this->load->library('form_validation');
		
		$this->form_validation->set_rules( 'nome', __("nome"), 'required' );
		$this->form_validation->set_rules( 'email', __("e-mail"), 'required' );

		if( $this->form_validation->run() === FALSE )
		{
			$this->gestao->GetView('candidato/editar', $data);
		}
		else
		{
			$post = $this->gestao->Request($candidato->GetDefault());
			$candidato->Carregar($post);
			$candidato->retornoinvitelkd = trim(strip_tags($candidato->retornoinvitelkd));
			$candidato->Ajustar(true);
			if(!$candidato->Salvar())
			{
				$data = array('act'=>"Erro",'titulo'=>__("Não foi possível salvar os dados do candidato."));
				$this->gestao->GetView('layout/erro', $data);
				return;
			}
			if(!empty($id))
			{
				message( 'success', 'msg_flash', __("Candidato foi editado com sucesso!") );
			}
			else
			{
				message( 'success', 'msg_flash', __("Candidato foi adicionado com sucesso!") );
			}
			redirect($linkRetorno);
		}
	}
	#######################################################################################################
	public function excluir($id = 0)
	{
		$candidato = GetModelo('candidato');
		if(!empty($id))
		{
			$candidato->idcandidato = $id;
			if($candidato->Apagar())
			{
				message( 'success', 'msg_flash', __("Candidato foi excluido com sucesso!") );
			}
			else
			{
				message( 'warning', 'msg_flash', __("Não foi possível excluir o candidato.") );
			}
		}
		else
		{
			message( 'warning', 'msg_flash', __("Não foi possível localizar o candidato.") );
		}
		redirect( 'candidato/listar' );
	}
	#######################################################################################################
	public function listar()
	{
		$this->gestao->SetBreadcrumbs("Lista de Candidato");
		self::LimparCandidato();
		$data['obj'] = GetModelo('candidato');
		$this->gestao->GetView('candidato/listar', $data);
	}
	#######################################################################################################
	public function listatabela()
	{
		$obj = GetModelo('Candidato');
		$filtro = $obj->Filtro();
		$sql = $obj->GetSqlLista();
		$sqlTotal = $obj->GetSqlTotalLista();
		$dados = $obj->listatabela($filtro, $sql, $sqlTotal);XDebug($dados, $this);
		RetornaJSON($dados);
	}
	#######################################################################################################
	public static function LimparCandidato()
	{
		$obj = GetModelo('Candidato');
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
	public function exportarcandidato()
	{
		$obj = GetModelo('candidato');
		if($obj)
		{
			$dados = $obj->ExportarCandidato();
		}
		else
		{
			$dados['sucesso'] = false;
			$dados['erro'] = __("Erro ao carregar a classe do candidato.");
		}
		RetornaJSON($dados);
	}
	#######################################################################################################
	public function baixarcandidato($file = "")
	{
		if(empty($file))
		{
			$data = array('act'=>__("Erro"),'titulo'=>__("Nome do arquivo não foi enviado ao sistema."));
			$this->gestao->GetView('layout/erro', $data );
			return;
		}
		
		$obj = GetModelo('candidato');
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
			$name = "importacao_candidato_";
			$name .= date("Y-m-d_H-i-s_");
			$name .= rand(100,999).'.'.$extension;
			$obj = GetModelo("candidato");
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
		$idvaga = Get('idvaga', 0);
		$novo = Get('novo', "Não");
		$importarnovos = Get('importarnovos', "Não");
		$posicao = Get('posicao');
		$total = Get('total');
		$obj = GetModelo('candidato');
		$arquivo = $obj->SetDominio($file);
		if((empty($posicao))&&($novo == "Sim"))
		{
			$obj->LimparNovos($idvaga, $novo);
		}
		if($obj->FileExiste($arquivo))
		{
			$limite = $total - $posicao;
			if($limite > self::$limiteimportacao)
			{
				if(!$obj->Importar($posicao, self::$limiteimportacao, $file, $idvaga, $novo, $importarnovos))
				{
					$dados['sucesso'] = false;
					$dados['erro'] = __("Erro no processo de importação do excel para o banco.");
					RetornaJSON($dados);
					return;
				}
				$dados['sucesso'] = true;
				$dados['status'] = "Processando";
				$dados['file'] = $file;
				$dados['mensagem'] = __("Importação de candidato está sendo processada.");
				$dados['posicao'] = $posicao + self::$limiteimportacao;
				$dados['total'] = $total;
			}
			else
			{
				if(!$obj->Importar($posicao, $limite, $file, $idvaga, $novo))
				{
					$dados['sucesso'] = false;
					$dados['erro'] = __("Erro no processo de importação do excel para o banco.");
					RetornaJSON($dados);
					return;
				}
				$dados['sucesso'] = true;
				$dados['status'] = "Finalizado";
				$dados['file'] = $file;
				$dados['mensagem'] = __("Importação de candidato finalizada com sucesso.");
				$dados['posicao'] = $posicao + $limite;
				$dados['total'] = $total;
			}
		}
		else
		{
			$dados['sucesso'] = false;
			$dados['erro'] = __("Erro ao localizar o registro de importação de candidato.");
		}XDebug($dados, $this);
		RetornaJSON($dados);
	}
}
?>