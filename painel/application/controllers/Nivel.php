<?php
/***********************************************************************
 * Module:  /controllers/Nivel.PHP
 * Author:  Host-up
 * Date:	03/04/2020 19:52:38
 * Purpose: Definição da Classe Nivel
 ***********************************************************************/

defined('BASEPATH') OR exit(__("Nenhum acesso de script direto permitido"));

class Nivel extends CI_Controller {
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
		$nivel = GetModelo('nivel');
		$linkRetorno = GetReferencia('nivel/listar');
		if( !empty($id))
		{
			$nivel->idnivel = $id;
			if(!$nivel->Load())
			{
				$data = array('act'=>__("Erro"),'titulo'=>__("Nível não foi localizado."));
				$this->gestao->GetView('layout/erro', $data );
				return;
			}
			$this->gestao->SetBreadcrumbs("Editar",site_url('nivel/listar'), 'Nível');
			$data['obj'] = $nivel;
		}
		else
		{
			$this->gestao->SetBreadcrumbs("Novo cadastro",site_url('nivel/listar'), 'Nível');
			$data['obj'] = $nivel;
		}
		$this->load->library('form_validation');
		
		$this->form_validation->set_rules( 'nivel', __("nível"), 'required' );
		$this->form_validation->set_rules( 'ordem', __("ordem do nível"), 'required' );

		if( $this->form_validation->run() === FALSE )
		{
			$this->gestao->GetView('nivel/editar', $data);
		}
		else
		{
			$post = $this->gestao->Request($nivel->GetDefault());
			$nivel->Carregar($post);
			$nivel->Ajustar(true);
			if(!$nivel->Salvar())
			{
				$data = array('act'=>"Erro",'titulo'=>__("Não foi possível salvar os dados do nível."));
				$this->gestao->GetView('layout/erro', $data);
				return;
			}
			if(!empty($id))
			{
				message( 'success', 'msg_flash', __("Nível foi editado com sucesso!") );
			}
			else
			{
				message( 'success', 'msg_flash', __("Nível foi adicionado com sucesso!") );
			}
			redirect($linkRetorno);
		}
	}
	#######################################################################################################
	public function excluir($id = 0)
	{
		$nivel = GetModelo('nivel');
		if(!empty($id))
		{
			$nivel->idnivel = $id;
			if($nivel->Apagar())
			{
				message( 'success', 'msg_flash', __("Nível foi excluido com sucesso!") );
			}
			else
			{
				message( 'warning', 'msg_flash', __("Não foi possível excluir o nível.") );
			}
		}
		else
		{
			message( 'warning', 'msg_flash', __("Não foi possível localizar o nível.") );
		}
		redirect( 'nivel/listar' );
	}
	#######################################################################################################
	public function listar()
	{
		$this->gestao->SetBreadcrumbs("Lista de Nível");
		self::LimparNivel();
		$data['obj'] = GetModelo('nivel');
		$this->gestao->GetView('nivel/listar', $data);
	}
	#######################################################################################################
	public function listatabela()
	{
		$obj = GetModelo('Nivel');
		$filtro = $obj->Filtro();
		$sql = $obj->GetSqlLista();
		$sqlTotal = $obj->GetSqlTotalLista();
		$dados = $obj->listatabela($filtro, $sql, $sqlTotal);
		echo json_encode($dados);
	}
	#######################################################################################################
	public static function LimparNivel()
	{
		$obj = GetModelo('Nivel');
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
	public function exportarnivel()
	{
		$obj = GetModelo('nivel');
		if($obj)
		{
			$dados = $obj->ExportarNivel();
		}
		else
		{
			$dados['sucesso'] = false;
			$dados['erro'] = __("Erro ao carregar a classe do nível.");
		}
		RetornaJSON($dados);
	}
	#######################################################################################################
	public function baixarnivel($file = "")
	{
		if(empty($file))
		{
			$data = array('act'=>__("Erro"),'titulo'=>__("Nome do arquivo não foi enviado ao sistema."));
			$this->gestao->GetView('layout/erro', $data );
			return;
		}
		
		$obj = GetModelo('nivel');
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
			$name = "importacao_nivel_";
			$name .= date("Y-m-d_H-i-s_");
			$name .= rand(100,999).'.'.$extension;
			$obj = GetModelo("nivel");
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
		$obj = GetModelo('nivel');
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
				$dados['mensagem'] = __("Importação de nível está sendo processada.");
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
				$dados['mensagem'] = __("Importação de nível finalizada com sucesso.");
				$dados['posicao'] = $posicao + $limite;
				$dados['total'] = $total;
			}
		}
		else
		{
			$dados['sucesso'] = false;
			$dados['erro'] = __("Erro ao localizar o registro de importação de nível.");
		}
		RetornaJSON($dados);
	}
}
?>