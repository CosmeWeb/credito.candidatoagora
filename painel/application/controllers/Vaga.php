<?php
/***********************************************************************
 * Module:  /controllers/Vaga.PHP
 * Author:  Host-up
 * Date:	18/05/2020 23:53:53
 * Purpose: Definição da Classe Vaga
 ***********************************************************************/

defined('BASEPATH') OR exit(__("Nenhum acesso de script direto permitido"));

class Vaga extends CI_Controller {
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
		$vaga = GetModelo('vaga');
		$linkRetorno = GetReferencia('vaga/listar');
		if( !empty($id))
		{
			$vaga->idvaga = $id;
			if(!$vaga->Load())
			{
				$data = array('act'=>__("Erro"),'titulo'=>__("Vaga não foi localizada."));
				$this->gestao->GetView('layout/erro', $data );
				return;
			}
			$this->gestao->SetBreadcrumbs("Editar",site_url('vaga/listar'), 'Vaga');
			$data['obj'] = $vaga;
		}
		else
		{
			$this->gestao->SetBreadcrumbs("Novo cadastro",site_url('vaga/listar'), 'Vaga');
			$data['obj'] = $vaga;
		}
		$this->load->library('form_validation');
		
		$this->form_validation->set_rules( 'idcliente', __("idcliente"), 'required' );
		$this->form_validation->set_rules( 'titulodavaga', __("título da vaga"), 'required' );
		$this->form_validation->set_rules( 'empresacontratante', __("empresa contratante"), 'required' );

		if( $this->form_validation->run() === FALSE )
		{
			$this->gestao->GetView('vaga/editar', $data);
		}
		else
		{
			$post = $this->gestao->Request($vaga->GetDefault());
			$vaga->Carregar($post);
			$vaga->Ajustar(true);
			$idvaga = $vaga->Salvar();
			if(!$idvaga)
			{
				$data = array('act'=>"Erro",'titulo'=>__("Não foi possível salvar os dados do vaga."));
				$this->gestao->GetView('layout/erro', $data);
				return;
			}
			if(empty($id))
			{
				$vaga->idvaga = $idvaga;
			}
			$idsubareavagas = Get("idsubareavaga", 0);
			$idsubarea = Get("idsubarea", 0);
			if(is_array($idsubareavagas))
			{
				$subarea = GetModelo('subareavaga');
				foreach($idsubareavagas as $key=>$idsubareavaga)
				{
					$subarea->SalvarSubareavaga( $idsubareavaga, $idsubarea[$key], $vaga->idvaga);
				}
			}
			$idcargocorrelatos = Get("idcargocorrelato", 0);
			$cargos = Get("cargo", 0);
			if(is_array($idcargocorrelatos))
			{
				$cargo = GetModelo('cargocorrelato');
				foreach($idcargocorrelatos as $key=>$idcargocorrelato)
				{
					$cargo->SalvarCargo( $idcargocorrelato, $cargos[$key], $vaga->idvaga);
				}
			}
			$idsetortargets = Get("idsetortarget", 0);
			$idsetor = Get("idsetortemp", 0);
			if(is_array($idsetortargets))
			{
				$setor = GetModelo('setortarget');
				foreach($idsetortargets as $key=>$idsetortarget)
				{
					$setor->SalvarSetor( $idsetortarget, $idsetor[$key], $vaga->idvaga);
				}
			}
			$idempresatargets = Get("idempresatarget", 0);
			$idempresa = Get("idempresa", 0);
			if(is_array($idempresatargets))
			{
				$empresa = GetModelo('empresatarget');
				foreach($idempresatargets as $key=>$idempresatarget)
				{
					$empresa->SalvarEmpresa( $idempresatarget, $idempresa[$key], $vaga->idvaga);
				}
			}
			$idempresatargetexcluirs = Get("idempresatargetexcluir", 0);
			$idempresa = Get("idempresaexcluir", 0);
			if(is_array($idempresatargetexcluirs))
			{
				$empresa = GetModelo('empresatargetexcluir');
				foreach($idempresatargetexcluirs as $key=>$idempresatargetexcluir)
				{
					$empresa->SalvarEmpresa( $idempresatargetexcluir, $idempresa[$key], $vaga->idvaga);
				}
			}
			if(!empty($id))
			{
				message( 'success', 'msg_flash', __("Vaga foi editada com sucesso!") );
			}
			else
			{
				message( 'success', 'msg_flash', __("Vaga foi adicionada com sucesso!") );
			}
			redirect($linkRetorno);
		}
	}
	#######################################################################################################
	public function excluir($id = 0)
	{
		$vaga = GetModelo('vaga');
		if(!empty($id))
		{
			$vaga->idvaga = $id;
			if($vaga->Apagar())
			{
				message( 'success', 'msg_flash', __("Vaga foi excluida com sucesso!") );
			}
			else
			{
				message( 'warning', 'msg_flash', __("Não foi possível excluir a vaga.") );
			}
		}
		else
		{
			message( 'warning', 'msg_flash', __("Não foi possível localizar a vaga.") );
		}
		redirect( 'vaga/listar' );
	}
	#######################################################################################################
	public function listar()
	{
		$this->gestao->SetBreadcrumbs("Lista de Vaga");
		self::LimparVaga();
		$data['obj'] = GetModelo('vaga');
		$this->gestao->GetView('vaga/listar', $data);
	}
	#######################################################################################################
	public function listatabela()
	{
		$obj = GetModelo('Vaga');
		$filtro = $obj->Filtro();
		$sql = $obj->GetSqlLista();
		$sqlTotal = $obj->GetSqlTotalLista();
		$dados = $obj->listatabela($filtro, $sql, $sqlTotal);
		RetornaJSON($dados);
	}
	#######################################################################################################
	public static function LimparVaga()
	{
		$obj = GetModelo('Vaga');
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
			if (($e == ".")||($e == ".."))
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
	public function exportarvaga()
	{
		$obj = GetModelo('vaga');
		if($obj)
		{
			$dados = $obj->ExportarVaga();
		}
		else
		{
			$dados['sucesso'] = false;
			$dados['erro'] = __("Erro ao carregar a classe do vaga.");
		}XDebug($dados, $this);
		RetornaJSON($dados);
	}
	#######################################################################################################
	public function baixarvaga($file = "")
	{
		if(empty($file))
		{
			$data = array('act'=>__("Erro"),'titulo'=>__("Nome do arquivo não foi enviado ao sistema."));
			$this->gestao->GetView('layout/erro', $data );
			return;
		}
		
		$obj = GetModelo('vaga');
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
			$name = "importacao_vaga_";
			$name .= date("Y-m-d_H-i-s_");
			$name .= rand(100,999).'.'.$extension;
			$obj = GetModelo("vaga");
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
		$obj = GetModelo('vaga');
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
				$dados['mensagem'] = __("Importação de vaga está sendo processada.");
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
				$dados['mensagem'] = __("Importação de vaga finalizada com sucesso.");
				$dados['posicao'] = $posicao + $limite;
				$dados['total'] = $total;
			}
		}
		else
		{
			$dados['sucesso'] = false;
			$dados['erro'] = __("Erro ao localizar o registro de importação de vaga.");
		}
		RetornaJSON($dados);
	}
	#######################################################################################################
	public function carregarsubarea()
	{
		$obj = GetModelo('subareavaga');
		if($obj)
		{
			$idvaga = Get("idvaga");
			$posicao = Get('posicao');
			$total = Get('total');
			$limiterows = 50;
			if(empty($total))
			{
				$total = $obj->GetListaSubareaTotal($idvaga);
				if(empty($total))
				{
					$dados['sucesso'] = false;
					$dados['erro'] =__("Nenhuma subárea foi relacionado a esta vaga.");
					$dados['titulo'] = __("Erro");
					return $dados;
				}
			}
			$limite = $total - $posicao;
			$objs = $obj->GetListaSubarea($idvaga, $posicao, $limiterows);
			if(empty($objs))
			{
				$dados['sucesso'] = false;
				$dados['erro'] = __("Nenhuma subárea foi relacionado a esta vaga.");
			}
			else
			{
				if($limite <= $limiterows)
				{
					$finalizar = true;
					$posicao = $posicao + $limite;
				}
				else
				{
					$finalizar = false;
					$posicao = $posicao + $limiterows;
				}
				$dados['sucesso'] = true;
				$dados['lista'] = $objs;
				$dados['finalizar'] = $finalizar;
				$dados['total'] = $total;
				$dados['posicao'] = $posicao;
			}
		}
		else
		{
			$dados['sucesso'] = false;
			$dados['erro'] = __("Erro ao carregar a classe do subárea.");
		}
		RetornaJSON($dados);
	}
	#######################################################################################################
	public function carregarcargo()
	{
		$obj = GetModelo('cargocorrelato');
		if($obj)
		{
			$idvaga = Get("idvaga");			
			$posicao = Get('posicao');
			$total = Get('total');
			$limiterows =50;
			if(empty($total))
			{
				$total = $obj->GetListaCargoTotal($idvaga);
				if(empty($total))
				{
					$dados['sucesso'] = false;
					$dados['erro'] =__("Nenhum cargo correlato foi relacionado a esta vaga.");
					$dados['titulo'] = __("Erro");
					return $dados;
				}
			}
			$limite = $total - $posicao;
			$idvaga = Get("idvaga");
			$objs = $obj->GetListaCargo($idvaga, $posicao, $limiterows);
			if(empty($objs))
			{
				$dados['sucesso'] = false;
				$dados['erro'] = __("Nenhum cargo correlato foi relacionado a esta vaga.");
			}
			else
			{
				if($limite <= $limiterows)
				{
					$finalizar = true;
					$posicao = $posicao + $limite;
				}
				else
				{
					$finalizar = false;
					$posicao = $posicao + $limiterows;
				}
				$dados['sucesso'] = true;
				$dados['lista'] = $objs;
				$dados['finalizar'] = $finalizar;
				$dados['total'] = $total;
				$dados['posicao'] = $posicao;
			}
		}
		else
		{
			$dados['sucesso'] = false;
			$dados['erro'] = __("Erro ao carregar a classe do cargo correlato.");
		}
		RetornaJSON($dados);
	}
	#######################################################################################################
	public function carregarsetor()
	{
		$obj = GetModelo('setortarget');
		if($obj)
		{
			$idvaga = Get("idvaga");
			$posicao = Get('posicao');
			$total = Get('total');
			$limiterows = 50;
			if(empty($total))
			{
				$total = $obj->GetListaSetorTotal($idvaga);
				if(empty($total))
				{
					$dados['sucesso'] = false;
					$dados['erro'] =__("Nenhuma setor foi relacionado a esta vaga.");
					$dados['titulo'] = __("Erro");
					return $dados;
				}
			}
			$limite = $total - $posicao;
			$objs = $obj->GetListaSetor($idvaga, $posicao, $limiterows);
			if(empty($objs))
			{
				$dados['sucesso'] = false;
				$dados['erro'] = __("Nenhuma setor foi relacionado a esta vaga.");
			}
			else
			{
				if($limite <= $limiterows)
				{
					$finalizar = true;
					$posicao = $posicao + $limite;
				}
				else
				{
					$finalizar = false;
					$posicao = $posicao + $limiterows;
				}
				$dados['sucesso'] = true;
				$dados['lista'] = $objs;
				$dados['finalizar'] = $finalizar;
				$dados['total'] = $total;
				$dados['posicao'] = $posicao;
			}
		}
		else
		{
			$dados['sucesso'] = false;
			$dados['erro'] = __("Erro ao carregar a classe do vaga.");
		}
		RetornaJSON($dados);
	}
	#######################################################################################################
	public function carregarempresa()
	{
		$obj = GetModelo('empresatarget');
		if($obj)
		{
			$idvaga = Get("idvaga");
			$posicao = Get('posicao');
			$total = Get('total');
			$limiterows = 50;
			if(empty($total))
			{
				$total = $obj->GetListaEmpresaTotal($idvaga);
				if(empty($total))
				{
					$dados['sucesso'] = false;
					$dados['erro'] =__("Nenhuma empresa target foi relacionada a esta vaga.");
					$dados['titulo'] = __("Erro");
					return $dados;
				}
			}
			$limite = $total - $posicao;
			$objs = $obj->GetListaEmpresa($idvaga, $posicao, $limiterows);
			if(empty($objs))
			{
				$dados['sucesso'] = false;
				$dados['erro'] = __("Nenhuma empresa target foi relacionada a esta vaga.");
			}
			else
			{
				if($limite <= $limiterows)
				{
					$finalizar = true;
					$posicao = $posicao + $limite;
				}
				else
				{
					$finalizar = false;
					$posicao = $posicao + $limiterows;
				}
				$dados['sucesso'] = true;
				$dados['lista'] = $objs;
				$dados['finalizar'] = $finalizar;
				$dados['total'] = $total;
				$dados['posicao'] = $posicao;
			}
		}
		else
		{
			$dados['sucesso'] = false;
			$dados['erro'] = __("Erro ao carregar a classe do vaga.");
		}
		RetornaJSON($dados);
	}
	#######################################################################################################
	public function carregarempresaexcluir()
	{
		$obj = GetModelo('empresatargetexcluir');
		if($obj)
		{
			$idvaga = Get("idvaga");
			$posicao = Get('posicao');
			$total = Get('total');
			$limiterows = 50;
			if(empty($total))
			{
				$total = $obj->GetListaEmpresaTotal($idvaga);
				if(empty($total))
				{
					$dados['sucesso'] = false;
					$dados['erro'] =__("Nenhuma empresa foi relacionada a esta vaga.");
					$dados['titulo'] = __("Erro");
					return $dados;
				}
			}
			$limite = $total - $posicao;
			$objs = $obj->GetListaEmpresa($idvaga, $posicao, $limiterows);
			if(empty($objs))
			{
				$dados['sucesso'] = false;
				$dados['erro'] = __("Nenhuma empresa foi relacionada a esta vaga.");
			}
			else
			{
				if($limite <= $limiterows)
				{
					$finalizar = true;
					$posicao = $posicao + $limite;
				}
				else
				{
					$finalizar = false;
					$posicao = $posicao + $limiterows;
				}
				$dados['sucesso'] = true;
				$dados['lista'] = $objs;
				$dados['finalizar'] = $finalizar;
				$dados['total'] = $total;
				$dados['posicao'] = $posicao;
			}
		}
		else
		{
			$dados['sucesso'] = false;
			$dados['erro'] = __("Erro ao carregar a classe do vaga.");
		}
		RetornaJSON($dados);
	}
	#######################################################################################################
	public function carregarempresacorrelata()
	{
		$obj = GetModelo('empresacorrelata');
		if($obj)
		{
			$idvaga = Get("idvaga");
			$posicao = Get('posicao');
			$total = Get('total');
			$limiterows = 50;
			if(empty($total))
			{
				$total = $obj->GetListaEmpresaTotal($idvaga);
				if(empty($total))
				{
					$dados['sucesso'] = false;
					$dados['erro'] =__("Nenhuma empresa foi relacionada a esta vaga.");
					$dados['titulo'] = __("Erro");
					return $dados;
				}
			}
			$limite = $total - $posicao;
			$objs = $obj->GetListaEmpresa($idvaga, $posicao, $limiterows);
			if(empty($objs))
			{
				$dados['sucesso'] = false;
				$dados['erro'] = __("Nenhuma vaga foi relacionada a esta vaga.");
			}
			else
			{
				if($limite <= $limiterows)
				{
					$finalizar = true;
					$posicao = $posicao + $limite;
				}
				else
				{
					$finalizar = false;
					$posicao = $posicao + $limiterows;
				}
				$dados['sucesso'] = true;
				$dados['lista'] = $objs;
				$dados['finalizar'] = $finalizar;
				$dados['total'] = $total;
				$dados['posicao'] = $posicao;
			}
		}
		else
		{
			$dados['sucesso'] = false;
			$dados['erro'] = __("Erro ao carregar a classe do vaga.");
		}
		RetornaJSON($dados);
	}
	#######################################################################################################
	public function deletarsubarea()
	{
		$obj = GetModelo('subareavaga');
		if($obj)
		{
			$obj->idsubareavaga = Get("idsubareavaga");
			if(!$obj->Apagar())
			{
				$dados['sucesso'] = false;
				$dados['erro'] = __("Não foi possível apagar esta subárea relacionado a vaga.");
			}
			else
			{
				$dados['sucesso'] = true;
				$dados['mensagem'] = __("Relacionamento entre a subárea e a vaga foi deletado com sucesso.");
				$dados['titulo'] = __("Sucesso.");
			}
		}
		else
		{
			$dados['sucesso'] = false;
			$dados['erro'] = __("Erro ao carregar a classe da subárea.");
		}
		RetornaJSON($dados);
	}
	#######################################################################################################
	public function deletarsetor()
	{
		$obj = GetModelo('setortarget');
		if($obj)
		{
			$obj->idsetortarget = Get("idsetortarget");
			if(!$obj->Apagar())
			{
				$dados['sucesso'] = false;
				$dados['erro'] = __("Não foi possível apagar este setor relacionado a vaga.");
			}
			else
			{
				$dados['sucesso'] = true;
				$dados['mensagem'] = __("Relacionamento entre o setor e a vaga foi deletado com sucesso.");
				$dados['titulo'] = __("Sucesso.");
			}
		}
		else
		{
			$dados['sucesso'] = false;
			$dados['erro'] = __("Erro ao carregar a classe do setor.");
		}
		RetornaJSON($dados);
	}
	#######################################################################################################
	public function deletarempresa()
	{
		$obj = GetModelo('empresatarget');
		if($obj)
		{
			$obj->idempresatarget = Get("idempresatarget");
			if(!$obj->Apagar())
			{
				$dados['sucesso'] = false;
				$dados['erro'] = __("Não foi possível apagar este empresa relacionado a vaga.");
			}
			else
			{
				$dados['sucesso'] = true;
				$dados['mensagem'] = __("Relacionamento entre a empresa e a vaga foi deletado com sucesso.");
				$dados['titulo'] = __("Sucesso.");
			}
		}
		else
		{
			$dados['sucesso'] = false;
			$dados['erro'] = __("Erro ao carregar a classe do empresa.");
		}
		RetornaJSON($dados);
	}
	#######################################################################################################
	public function deletarempresaexcluir()
	{
		$obj = GetModelo('empresatargetexcluir');
		if($obj)
		{
			$obj->idempresatargetexcluir = Get("idempresatargetexcluir");
			if(!$obj->Apagar())
			{
				$dados['sucesso'] = false;
				$dados['erro'] = __("Não foi possível apagar este empresa relacionado a vaga.");
			}
			else
			{
				$dados['sucesso'] = true;
				$dados['mensagem'] = __("Relacionamento entre a empresa e a vaga foi deletado com sucesso.");
				$dados['titulo'] = __("Sucesso.");
			}
		}
		else
		{
			$dados['sucesso'] = false;
			$dados['erro'] = __("Erro ao carregar a classe do empresa.");
		}
		RetornaJSON($dados);
	}
	#######################################################################################################
	public function deletarcargo()
	{
		$obj = GetModelo('cargocorrelato');
		if($obj)
		{
			$obj->idcargocorrelato= Get("idcargocorrelato");
			if(!$obj->Apagar())
			{
				$dados['sucesso'] = false;
				$dados['erro'] = __("Não foi possível apagar este cargo correlato relacionado a vaga.");
			}
			else
			{
				$dados['sucesso'] = true;
				$dados['mensagem'] = __("Relacionamento entre o cargo correlato e a vaga foi deletado com sucesso.");
				$dados['titulo'] = __("Sucesso.");
			}
		}
		else
		{
			$dados['sucesso'] = false;
			$dados['erro'] = __("Erro ao carregar a classe do cargo correlato.");
		}
		RetornaJSON($dados);
	}
	#######################################################################################################
	public function deletarempresacorrelata()
	{
		$obj = GetModelo('empresacorrelata');
		if($obj)
		{
			$obj->idempresacorrelata = Get("idempresacorrelata");
			if(!$obj->Apagar())
			{
				$dados['sucesso'] = false;
				$dados['erro'] = __("Não foi possível apagar este empresa correlata relacionado a vaga.");
			}
			else
			{
				$dados['sucesso'] = true;
				$dados['mensagem'] = __("Relacionamento entre a empresa correlata e a vaga foi deletado com sucesso.");
				$dados['titulo'] = __("Sucesso.");
			}
		}
		else
		{
			$dados['sucesso'] = false;
			$dados['erro'] = __("Erro ao carregar a classe do empresa correlata.");
		}
		RetornaJSON($dados);
	}	
	#######################################################################################################
	public function deletecandidatosvaga()
	{
		$idvaga = Get('idvaga', 0);
		$posicao = Get('posicao', 0);
		$total = Get('total', 0);
		$obj = GetModelo('candidato');
		$limite = 100;
		if(empty($total))
		{
			$sqlTotal = "SELECT COUNT(DISTINCT C.idcandidato) AS CONT FROM candidato C INNER JOIN candidatovaga CV FORCE INDEX(idxcandidato, idxvaga) ON(C.idcandidato = CV.idcandidato) INNER JOIN vaga V ON(CV.idvaga = V.idvaga) WHERE V.idvaga = '{$idvaga}'";
			$filtro = false;
			$total = $obj->TotalRegistro($filtro, $sqlTotal, false);
			if(empty($total))
			{
				$dados['sucesso'] = false;
				$dados['erro'] = __("Nenhum candidato foi encontrado no momento.");
			}
			else
			{
				$dados['sucesso'] = true;
				$dados['titulo'] = __("Apagando Candidato");
				$dados['mensagem'] = __("Deletando aos candidatos da vaga...");
				$dados['finalizado'] = false;
				$dados['posicao'] = $posicao;
				$dados['total'] = $total;
				$dados['idvaga'] = $idvaga;
			}
			RetornaJSON($dados);
			return;
		}
		$sql = "SELECT DISTINCT C.* FROM candidato C INNER JOIN candidatovaga CV FORCE INDEX(idxcandidato, idxvaga) ON(C.idcandidato = CV.idcandidato) INNER JOIN vaga V ON(CV.idvaga = V.idvaga) WHERE V.idvaga = '{$idvaga}' ORDER BY C.idcandidato ASC LIMIT 0, {$limite}";
		$filtro = false;
		$objs = $obj->FiltroObjetos($filtro, $sql);
		if($objs)
		{
			foreach($objs as $key=>$obj)
			{
				$total = $obj->TemMaisdeVaga($idvaga);
				if($total > 0)
				{
					$obj->DeletarCandidatoDaVaga($idvaga, $obj->idcandidato);
				}
				else
				{
					$obj->Apagar();
				}
			}
			$posicao += $limite;
			$dados['sucesso'] = true;
			$dados['titulo'] = __("Apagando Candidato");
			$dados['mensagem'] = __("Deletando aos candidatos da vaga...");
			$dados['finalizado'] = false;
			$dados['posicao'] = $posicao;
			$dados['total'] = $total;
			$dados['idvaga'] = $idvaga;
		}
		else
		{
			$posicao += $limite;
			$dados['sucesso'] = true;
			$dados['titulo'] = __("Apagando Candidato");
			$dados['mensagem'] = __("Candidatos da vaga foram deletados com sucesso.");
			$dados['finalizado'] = true;
			$dados['posicao'] = $posicao;
			$dados['total'] = $total;
			$dados['idvaga'] = $idvaga;
		}
		RetornaJSON($dados);
	}
}
?>