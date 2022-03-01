<?php
/***********************************************************************
 * Module:  /controllers/Cargo.PHP
 * Author:  Host-up
 * Date:	03/04/2020 21:17:58
 * Purpose: Definição da Classe Cargo
 ***********************************************************************/

defined('BASEPATH') OR exit(__("Nenhum acesso de script direto permitido"));

class Cargo extends CI_Controller {
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
		$cargo = GetModelo('cargo');
		$linkRetorno = GetReferencia('cargo/listar');
		if( !empty($id))
		{
			$cargo->idcargo = $id;
			if(!$cargo->Load())
			{
				$data = array('act'=>__("Erro"),'titulo'=>__("Cargo não foi localizado."));
				$this->gestao->GetView('layout/erro', $data );
				return;
			}
			$this->gestao->SetBreadcrumbs("Editar",site_url('cargo/listar'), 'Cargo');
			$data['obj'] = $cargo;
		}
		else
		{
			$this->gestao->SetBreadcrumbs("Novo cadastro",site_url('cargo/listar'), 'Cargo');
			$data['obj'] = $cargo;
		}
		$this->load->library('form_validation');
		
		$this->form_validation->set_rules( 'cargo', __("cargo"), 'required' );

		if( $this->form_validation->run() === FALSE )
		{
			$this->gestao->GetView('cargo/editar', $data);
		}
		else
		{
			$post = $this->gestao->Request($cargo->GetDefault());
			$cargo->Carregar($post);
			$cargo->Ajustar(true);
			$idcargo = $cargo->Salvar();
			if(empty($idcargo))
			{
				$data = array('act'=>"Erro",'titulo'=>__("Não foi possível salvar os dados do cargo."));
				$this->gestao->GetView('layout/erro', $data);
				return;
			}
			if(empty($id))
			{
				$cargo->idcargo = $idcargo;
			}
			$termos = Get("termos");
			$idtermocargos = Get("idtermocargos");
			$termocargo = GetModelo("termocargo");
			if(!empty($termos))
			{
				foreach($termos as $key=>$termo)
				{
					$termocargo->idtermocargo = $idtermocargos[$key];
					$termocargo->idcargo = $cargo->idcargo;
					$termocargo->termo = Escape($termos[$key]);
					$termocargo->Ajustar(true);
					$termocargo->Salvar();
				}
			}
			if(!empty($id))
			{
				message( 'success', 'msg_flash', __("Cargo foi editado com sucesso!") );
			}
			else
			{
				message( 'success', 'msg_flash', __("Cargo foi adicionado com sucesso!") );
			}
			redirect($linkRetorno);
		}
	}
	#######################################################################################################
	public function excluir($id = 0)
	{
		$cargo = GetModelo('cargo');
		if(!empty($id))
		{
			$cargo->idcargo = $id;
			if($cargo->Apagar())
			{
				message( 'success', 'msg_flash', __("Cargo foi excluido com sucesso!") );
			}
			else
			{
				message( 'warning', 'msg_flash', __("Não foi possível excluir o cargo.") );
			}
		}
		else
		{
			message( 'warning', 'msg_flash', __("Não foi possível localizar o cargo.") );
		}
		redirect( 'cargo/listar' );
	}
	#######################################################################################################
	public function listar()
	{
		$this->gestao->SetBreadcrumbs("Lista de Cargo");
		self::LimparCargo();
		$data['obj'] = GetModelo('cargo');
		$this->gestao->GetView('cargo/listar', $data);
	}
	#######################################################################################################
	public function listatabela()
	{
		$obj = GetModelo('Cargo');
		$filtro = $obj->Filtro();
		$sql = $obj->GetSqlLista();
		$sqlTotal = $obj->GetSqlTotalLista();
		$dados = $obj->listatabela($filtro, $sql, $sqlTotal);
		echo json_encode($dados);
	}
	#######################################################################################################
	public static function LimparCargo()
	{
		$obj = GetModelo('Cargo');
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
	public function exportarcargo()
	{
		$obj = GetModelo('cargo');
		if($obj)
		{
			$dados = $obj->ExportarCargo();
		}
		else
		{
			$dados['sucesso'] = false;
			$dados['erro'] = __("Erro ao carregar a classe do cargo.");
		}
		RetornaJSON($dados);
	}
	#######################################################################################################
	public function baixarcargo($file = "")
	{
		if(empty($file))
		{
			$data = array('act'=>__("Erro"),'titulo'=>__("Nome do arquivo não foi enviado ao sistema."));
			$this->gestao->GetView('layout/erro', $data );
			return;
		}
		
		$obj = GetModelo('cargo');
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
			$name = "importacao_cargo_";
			$name .= date("Y-m-d_H-i-s_");
			$name .= rand(100,999).'.'.$extension;
			$obj = GetModelo("cargo");
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
		$obj = GetModelo('cargo');
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
				$dados['mensagem'] = __("Importação de cargo está sendo processada.");
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
				$dados['mensagem'] = __("Importação de cargo finalizada com sucesso.");
				$dados['posicao'] = $posicao + $limite;
				$dados['total'] = $total;
			}
		}
		else
		{
			$dados['sucesso'] = false;
			$dados['erro'] = __("Erro ao localizar o registro de importação de cargo.");
		}
		RetornaJSON($dados);
	}
	#######################################################################################################
	public function getlistatermo()
	{
		$obj = GetModelo('termocargo');
		if($obj)
		{
			$idcargo = Get("idcargo", 0);
			$dados['sucesso'] = true;
			$dados['mensagem'] = __("Termo listado com sucesso.");
			$dados['lista'] = $obj->GetListaTermo($idcargo);
		}
		else
		{
			$dados['sucesso'] = false;
			$dados['erro'] = __("Erro ao carregar a classe do cargo.");
		}
		RetornaJSON($dados);
	}
	#######################################################################################################
	public function deletartermocargo()
	{
		$termo = GetModelo('termocargo');
		$id = Get("idtermocargo", 0);
		if(!empty($id))
		{
			$termo->idtermocargo = $id;
			if($termo->Apagar())
			{
				$dados['sucesso'] = true;				
				$dados['titulo'] = __("Erro ao deletar");
				$dados['mensagem'] = __("Termo da cargo foi excluido com sucesso!");
			}
			else
			{
				$dados['sucesso'] = false;
				$dados['titulo'] = __("Erro ao deletar");
				$dados['erro'] = __("Não foi possível localizar o termo do cargo.");
			}
		}
		else
		{
			$dados['sucesso'] = false;
			$dados['titulo'] = __("Erro ao deletar");
			$dados['erro'] = __("Não foi possível localizar o termo do cargo.");
		}
		RetornaJSON($dados);
	}
}
?>