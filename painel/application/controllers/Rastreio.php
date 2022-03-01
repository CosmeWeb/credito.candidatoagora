<?php
/***********************************************************************
 * Module:  /controllers/Rastreio.PHP
 * Author:  Host-up
 * Date:	03/09/2020 00:23:32
 * Purpose: Definição da Classe Rastreio
 ***********************************************************************/

defined('BASEPATH') OR exit(__("Nenhum acesso de script direto permitido"));

class Rastreio extends CI_Controller {
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
		$rastreio = GetModelo('rastreio');
		$linkRetorno = GetReferencia('rastreio/listar');
		if( !empty($id))
		{
			$rastreio->idrastreio = $id;
			if(!$rastreio->Load())
			{
				$data = array('act'=>__("Erro"),'titulo'=>__("Rastreio não foi localizado."));
				$this->load->library('layout/erro', $data );
				return;
			}
			$this->gestao->SetBreadcrumbs("Editar",site_url('rastreio/listar'), 'Rastreio');
			$data['obj'] = $rastreio;
		}
		else
		{
			$this->gestao->SetBreadcrumbs("Novo cadastro",site_url('rastreio/listar'), 'Rastreio');
			$data['obj'] = $rastreio;
		}
		$this->load->library('form_validation');
		
		$this->form_validation->set_rules( 'idrastreio', __("idrastreio"), 'required' );
		$this->form_validation->set_rules( 'idcliente', __("idcliente"), 'required' );
		$this->form_validation->set_rules( 'codigo', __("codigo"), 'required' );
		$this->form_validation->set_rules( 'descricao', __("descricao"), 'required' );
		$this->form_validation->set_rules( 'ip', __("ip"), 'required' );
		$this->form_validation->set_rules( 'cadastradoem', __("cadastradoem"), 'required' );

		if( $this->form_validation->run() === FALSE )
		{
			$this->gestao->GetView('rastreio/editar', $data);
		}
		else
		{
			$post = $this->gestao->Request($rastreio->GetDefault());
			$rastreio->Carregar($post);
			$rastreio->Ajustar(true);
			if(!$rastreio->Salvar())
			{
				$data = array('act'=>"Erro",'titulo'=>__("Não foi possível salvar os dados do rastreio."));
				$this->gestao->GetView('layout/erro', $data);
				return;
			}
			if(!empty($id))
			{
				message( 'success', 'msg_flash', __("Rastreio foi editado com sucesso!") );
			}
			else
			{
				message( 'success', 'msg_flash', __("Rastreio foi adicionado com sucesso!") );
			}
			redirect($linkRetorno);
		}
	}
	#######################################################################################################
	public function excluir($id = 0)
	{
		$rastreio = GetModelo('rastreio');
		if(!empty($id))
		{
			$rastreio->idrastreio = $id;
			if($rastreio->Apagar())
			{
				message( 'success', 'msg_flash', __("Rastreio foi excluido com sucesso!") );
			}
			else
			{
				message( 'warning', 'msg_flash', __("Não foi possível excluir o rastreio.") );
			}
		}
		else
		{
			message( 'warning', 'msg_flash', __("Não foi possível localizar o rastreio.") );
		}
		redirect( 'rastreio/listar' );
	}
	#######################################################################################################
	public function listar()
	{
		$this->gestao->SetBreadcrumbs("Lista de Rastreio");
		self::LimparRastreio();
		$data['obj'] = GetModelo('rastreio');
		$this->gestao->GetView('rastreio/listar', $data);
	}
	#######################################################################################################
	public function listatabela()
	{
		$obj = GetModelo('Rastreio');
		$filtro = $obj->Filtro();
		$sql = $obj->GetSqlLista();
		$sqlTotal = $obj->GetSqlTotalLista();
		$dados = $obj->listatabela($filtro, $sql, $sqlTotal);
		RetornaJSON($dados);
	}
	#######################################################################################################
	public static function LimparRastreio()
	{
		$obj = GetModelo('Rastreio');
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
	public function exportarrastreio()
	{
		$obj = GetModelo('rastreio');
		if($obj)
		{
			$dados = $obj->ExportarRastreio();
		}
		else
		{
			$dados['sucesso'] = false;
			$dados['erro'] = __("Erro ao carregar a classe do rastreio.");
		}XDebug($dados, $this);
		RetornaJSON($dados);
	}
	#######################################################################################################
	public function baixarrastreio($file = "")
	{
		if(empty($file))
		{
			$data = array('act'=>__("Erro"),'titulo'=>__("Nome do arquivo não foi enviado ao sistema."));
			$this->gestao->GetView('layout/erro', $data );
			return;
		}
		
		$obj = GetModelo('rastreio');
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
			$name = "importacao_rastreio_";
			$name .= date("Y-m-d_H-i-s_");
			$name .= rand(100,999).'.'.$extension;
			$obj = GetModelo("rastreio");
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
		$obj = GetModelo('rastreio');
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
				$dados['mensagem'] = __("Importação de rastreio está sendo processada.");
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
				$dados['mensagem'] = __("Importação de rastreio finalizada com sucesso.");
				$dados['posicao'] = $posicao + $limite;
				$dados['total'] = $total;
			}
		}
		else
		{
			$dados['sucesso'] = false;
			$dados['erro'] = __("Erro ao localizar o registro de importação de rastreio.");
		}
		RetornaJSON($dados);
	}
	#######################################################################################################
	public function cockpit()
	{
		$rastreio = GetModelo('rastreio');
		$data['obj'] = $rastreio;
		$this->gestao->GetView('rastreio/cockpit', $data);		
	}
	#######################################################################################################
	public function cockpitrastreio()
	{
		$rastreio = GetModelo('rastreio');
		$data['obj'] = $rastreio;
		$data['links'] = base_url();
		$this->load->view('rastreio/cockpitrastreio', $data);
	}
	#######################################################################################################
	public function gettabelarestreio()
	{
		$obj = GetModelo('rastreio');
		if($obj)
		{
			$dados = $obj->GetTabelaRestreio();
		}
		else
		{
			$dados['sucesso'] = false;
			$dados['erro'] = __("Erro ao carregar a classe do rastreio.");
		}//XDebug($dados, $this);
		RetornaJSON($dados);
	}
	#######################################################################################################
	public function listatabelacockpitcandidato()
	{
		$obj = GetModelo('Rastreio');
		$filtro = $obj->Filtro();
		$sql = $obj->GetSqlListaCockpitCandidato();
		$sqlTotal = $obj->GetSqlTotalListaCockpit();
		$dados = $obj->listatabelaCockpitCandidato($filtro, $sql, $sqlTotal);//XDebug($dados, $this);
		RetornaJSON($dados);
	}
	#######################################################################################################
	public function listatabelacandidatocockpit()
	{
		$obj = GetModelo('Rastreio');
		$filtro = $obj->Filtro();
		$sql = $obj->GetSqlListaCandidatoCockpit();
		$sqlTotal = $obj->GetSqlTotalListaCandidatoCockpit();
		$dados = $obj->listatabelaCandidatoCockpit($filtro, $sql, $sqlTotal);
		RetornaJSON($dados);
	}
	#######################################################################################################
	public function listacliente()
	{
		$obj = GetModelo('Rastreio');
		$dados = $obj->ListaClientes();
		RetornaJSON($dados);
	}	
	#######################################################################################################
	public function rastreiopdf()
	{
		$obj = GetModelo('rastreio');
		$idcliente = Get("idcliente", 0);
		if(empty($idcliente))
		{
			$data = array('act'=>__("Erro"),'titulo'=>__("PDF não foi localizado."));
			$this->load->library('layout/erro', $data );
			return;
		}
		$data['rastreio'] = $obj;
		$data['lista'] = $obj->GetListaPDF();
		$cliente = GetModelo('cliente');
		$cliente->idcliente = $idcliente;
		if($cliente->Load())
		{
			$data['empresa'] = $cliente->empresa;
			$data['cliente'] = $cliente->nome;
		}
		else
		{
			$data['cliente'] = "Não identificado";
		}

		$cadastradoeminicio = Get("cadastradoeminicio");
		if(!emptyData($cadastradoeminicio))
		{
			$cadastradoeminicio = date("d/m/Y", TimeData($cadastradoeminicio));
		}
		$cadastradoemfim = Get("cadastradoemfim");
		if(!emptyData($cadastradoemfim))
		{
			$cadastradoemfim = date("d/m/Y", TimeData($cadastradoemfim));
		}
		if((!emptyData($cadastradoeminicio))&&(!emptyData($cadastradoemfim)))
		{
			$data['periodo'] = "{$cadastradoeminicio} até {$cadastradoemfim}";
		}
		elseif(!emptyData($cadastradoeminicio))
		{
			$data['periodo'] = "{$cadastradoeminicio} até ".date("d/m/Y");
		}
		elseif(!emptyData($cadastradoemfim))
		{
			$data['periodo'] = "Do primeiro acesso até {$cadastradoemfim}";
		}
		else
		{
			$data['periodo'] = " Todo periodo registrado";
		}
		$file = $obj->GetFileNomePDF($idcliente = 0);
		/*$this->load->view("rastreio/pdf", $data);*/
		$this->load->library('Pdf');
		$this->pdf->load_view('rastreio/pdf', $data);
		$this->pdf->set_option('isRemoteEnabled', TRUE); 
		$this->pdf->set_option('isPhpEnabled', true);      
		$this->pdf->setPaper('A4', 'portrait');
		$this->pdf->render();
		$canvas = $this->pdf->get_canvas(); 
  		$font = $this->pdf->getFontMetrics();
		$font = $font->get_font("helvetica", "bold");
  		$canvas->page_text(530, 18, "Pág. {PAGE_NUM}/{PAGE_COUNT}", $font, 6, array(0,0,0)); //header
		$rodape = "Copyright © ".date("Y")." - candidatoagora.com.br";
  		$canvas->page_text(230, 820, $rodape, $font, 6, array(0,0,0)); //footer
		$this->pdf->stream($file, ["Attachment"=>false]);
	}
	#######################################################################################################
	public function listacockpitrastreio()
	{
		$obj = GetModelo('rastreio');
		if($obj)
		{
			$dados = $obj->ListaCockpitRastreio();
		}
		else
		{
			$dados['sucesso'] = false;
			$dados['erro'] = __("Erro ao carregar a classe do rastreio.");
		}XDebug($dados, $this);
		RetornaJSON($dados);
	}
}
?>