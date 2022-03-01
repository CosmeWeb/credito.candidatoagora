<?php
/***********************************************************************
 * Module:  /controllers/Cidade.PHP
 * Author:  Host-up
 * Date:	01/04/2020 21:31:19
 * Purpose: Definição da Classe Cidade
 ***********************************************************************/

defined('BASEPATH') OR exit(__("Nenhum acesso de script direto permitido"));

class Cidade extends CI_Controller {
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
		$cidade = GetModelo('cidade');
		$linkRetorno = GetReferencia('cidade/listar');
		if( !empty($id))
		{
			$cidade->idcidade = $id;
			if(!$cidade->Load())
			{
				$data = array('act'=>__("Erro"),'titulo'=>__("Cidade não foi localizada."));
				$this->gestao->GetView('layout/erro', $data );
				return;
			}
			$this->gestao->SetBreadcrumbs("Editar",site_url('cidade/listar'), 'Cidade');
			$cidade->idpais = $cidade->GetIdPais();
			$data['obj'] = $cidade;
		}
		else
		{
			$this->gestao->SetBreadcrumbs("Novo cadastro",site_url('cidade/listar'), 'Cidade');
			$data['obj'] = $cidade;
		}
		$this->load->library('form_validation');
		
		$this->form_validation->set_rules( 'idestado', __("idestado"), 'required' );
		$this->form_validation->set_rules( 'cidade', __("cidade"), 'required' );

		if( $this->form_validation->run() === FALSE )
		{
			$this->gestao->GetView('cidade/editar', $data);
		}
		else
		{
			$post = $this->gestao->Request($cidade->GetDefault());
			$cidade->Carregar($post);
			$cidade->Ajustar(true);
			if(!$cidade->Salvar())
			{
				$data = array('act'=>"Erro",'titulo'=>__("Não foi possível salvar os dados da cidade."));
				$this->gestao->GetView('layout/erro', $data);
				return;
			}
			if(!empty($id))
			{
				message( 'success', 'msg_flash', __("Cidade foi editada com sucesso!") );
			}
			else
			{
				message( 'success', 'msg_flash', __("Cidade foi adicionada com sucesso!") );
			}
			redirect($linkRetorno);
		}
	}
	#######################################################################################################
	public function excluir($id = 0)
	{
		$cidade = GetModelo('cidade');
		if(!empty($id))
		{
			$cidade->idcidade = $id;
			if($cidade->Apagar())
			{
				message( 'success', 'msg_flash', __("Cidade foi excluida com sucesso!") );
			}
			else
			{
				message( 'warning', 'msg_flash', __("Não foi possível excluir a cidade.") );
			}
		}
		else
		{
			message( 'warning', 'msg_flash', __("Não foi possível localizar a cidade.") );
		}
		redirect( 'cidade/listar' );
	}
	#######################################################################################################
	public function listar()
	{
		$this->gestao->SetBreadcrumbs("Lista de Cidade");
		self::LimparCidade();
		$data['obj'] = GetModelo('cidade');
		$this->gestao->GetView('cidade/listar', $data);
	}
	#######################################################################################################
	public function listatabela()
	{
		$obj = GetModelo('Cidade');
		$filtro = $obj->Filtro();
		$sql = $obj->GetSqlLista();
		$sqlTotal = $obj->GetSqlTotalLista();
		$dados = $obj->listatabela($filtro, $sql, $sqlTotal);
		echo json_encode($dados);
	}
	#######################################################################################################
	public static function LimparCidade()
	{
		$obj = GetModelo('Cidade');
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
	public function exportarcidade()
	{
		$obj = GetModelo('cidade');
		if($obj)
		{
			$dados = $obj->ExportarCidade();
		}
		else
		{
			$dados['sucesso'] = false;
			$dados['erro'] = __("Erro ao carregar a classe da cidade.");
		}
		RetornaJSON($dados);
	}
	#######################################################################################################
	public function baixarcidade($file = "")
	{
		if(empty($file))
		{
			$data = array('act'=>__("Erro"),'titulo'=>__("Nome do arquivo não foi enviado ao sistema."));
			$this->gestao->GetView('layout/erro', $data );
			return;
		}
		
		$obj = GetModelo('cidade');
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
			$name = "importacao_cidade_";
			$name .= date("Y-m-d_H-i-s_");
			$name .= rand(100,999).'.'.$extension;
			$obj = GetModelo("cidade");
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
		$obj = GetModelo('cidade');
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
				$dados['mensagem'] = __("Importação de cidade está sendo processada.");
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
				$dados['mensagem'] = __("Importação de cidade finalizada com sucesso.");
				$dados['posicao'] = $posicao + $limite;
				$dados['total'] = $total;
			}
		}
		else
		{
			$dados['sucesso'] = false;
			$dados['erro'] = __("Erro ao localizar o registro de importação de cidade.");
		}
		RetornaJSON($dados);
	}
	#######################################################################################################
	public function verificarcoordenadas()
	{
		$JS = array("vendors/jquery-toastr/toastr.min.js");
		$CSS = array("vendors/jquery-toastr/toastr.min.css");
		$this->gestao->AddJS($JS);
		$this->gestao->AddCSS($CSS);
		$this->gestao->SetBreadcrumbs("Verificar Coordenadas", site_url('cidade/listar'), 'Cidade');
		$this->gestao->GetView('cidade/verificarcoordenadas');
	}
	#######################################################################################################
	public function totalcoordenadascidades()
	{
		$processando = Get("processando","parcial");
		$obj = GetModelo('cidade');
		if(empty($obj))
		{
			$dados['sucesso'] = false;
			$dados['total'] = 0;
			$dados['erro'] = __("<b>Atenção</b> Nenhum classe de gestão de cidade não foi localizadas.");
			$dados['class'] = "alert alert-danger";
		}
		else
		{
			$total = $obj->GetTotalCoordenadas($processando);
			if(!empty($total))
			{
				$dados['sucesso'] = true;
				$dados['total'] = $total;
				$dados['mensagem'] = sprintf(__("<b>Atenção</b> Existe %d cidades a serem processadas."), $total);
				$dados[ 'class' ] = "alert alert-info";
			}
			else
			{
				$dados[ 'sucesso' ] = true;
				$dados[ 'total' ] = 0;
				$dados['mensagem'] = __("<b>Atenção</b> Nenhum cidade a ser processada.");
				$dados['class'] = "alert alert-danger";
			}
			
		}
		RetornaJSON($dados);
	}
	#######################################################################################################
	public function associarcoordenadas()
	{
		$processando = Get("processando","parcial");
		$posicao = Get("posicao",0);
		$total = Get("total",0);
		$cidades = Get("cidades", false);
		$obj = GetModelo('cidade');
		$limitecidade = 50;
		if(empty($total))
		{
			$total = $obj->GetTotalCoordenadas($processando);
			if(!empty($total))
			{
				$dados['sucesso'] = true;
				$dados['total'] = $total;
				$dados['posicao'] = $posicao;
				$dados['finalizado'] = false;
				$dados['titulo'] = __("Processando.");
				$dados['mensagem'] = sprintf(__("<b>Atenção</b> Existe %d cidades a serem processadas."), $total);
				$dados['cidades'] = false;
			}
			else
			{
				$dados['sucesso'] = true;
				$dados['total'] = $total;
				$dados['posicao'] = $posicao;
				$dados['finalizado'] = true;
				$dados['titulo'] = __("Atenção");
				$dados['mensagem'] = __("Nenhum cidade a ser processada.");
				$dados['cidades'] = false;
			}
			RetornaJSON($dados);
			return;
		}
		if(!empty($cidades))
		{
			$idcidade = $obj->SalvarLista($cidades);
		}
		else
		{
			$idcidade = 0;
		}
		$lista = $obj->BuscarListadeCidades($idcidade, $limitecidade, $processando);
		if(!empty($lista))
		{
			$dados['sucesso'] = true;
			$dados['total'] = $total;
			$dados['posicao'] = $posicao + $limitecidade;
			$dados['finalizado'] = false;
			$dados['titulo'] = __("Processando.");
			$dados['mensagem'] = __("Processando lista de cidades da base de sistema.");
			$dados['cidades'] = $lista;
		}
		else
		{
			$dados['sucesso'] = true;
			$dados['total'] = $total;
			$dados['posicao'] = $posicao + $limitecidade;
			$dados['finalizado'] = true;
			$dados['titulo'] = __("Processando.");
			$dados['mensagem'] = __("Cidades foram processada com sucesso.");
			$dados['cidades'] = false;
		}		
		RetornaJSON($dados);
	}
	#######################################################################################################
	public function emulador()
	{
		$key = Get("key","");
		$query = Get("query",0);
		$cidade = Get("cidade","");
		$limitecidade = 50;
		if(empty($key))
		{
			P(" sem key");
		}
		if($key != "AIzaSyAniOxGrlXfMDh6Lp6BCTW9xPwQZDEnTH4")
		{
			P($key);
		}
		if(empty($query))
		{
			P(" sem query");
		}
		$JSON = '{
			"html_attributions" : [],
			"results" : [
			   {
				  "formatted_address" : "São Paulo, SP, Brasil",
				  "geometry" : {
					 "location" : {
						"lat" : -23.5505199,
						"lng" : -46.63330939999999
					 },
					 "viewport" : {
						"northeast" : {
						   "lat" : -23.3566039,
						   "lng" : -46.3650844
						},
						"southwest" : {
						   "lat" : -24.0082209,
						   "lng" : -46.825514
						}
					 }
				  },
				  "icon" : "https://maps.gstatic.com/mapfiles/place_api/icons/geocode-71.png",
				  "id" : "fedb05012f42e79f038a58eac44e1bbc61b7c7aa",
				  "name" : "São Paulo",
				  "photos" : [
					 {
						"height" : 894,
						"html_attributions" : [
						   "\u003ca href=\"https://maps.google.com/maps/contrib/113482343908983147932\"\u003eRandolfo Santos\u003c/a\u003e"
						],
						"photo_reference" : "CmRaAAAAkiLOkMWmLtNQQE9IJlWSgcKN2GvYD57gDwj2ZK1QZpaizaQvhzE7Rq21FKw9lkUiLKH1x5tdrlMCf87HBsYuxiXDal1SCtyiUI0Wd84L2zP6xs7jtk45YFA-dl7dYpnoEhBS0ShdxxBme8PddLU845w6GhQ4M8kOIWfN1nPXRIRWifQN3jsl2g",
						"width" : 736
					 }
				  ],
				  "place_id" : "ChIJ0WGkg4FEzpQRrlsz_whLqZs",
				  "reference" : "ChIJ0WGkg4FEzpQRrlsz_whLqZs",
				  "types" : [ "locality", "political" ]
			   }
			],
			"status" : "OK"
		 }';
		$dados = json_decode($JSON, true);
		$dados["results"][0]["geometry"]["location"]["lat"] = "teste ".rand(-20,41);
		$dados["results"][0]["geometry"]["location"]["lng"] = "teste ".rand(-20,41);

		$dados["results"][0]["geometry"]["viewport"]["northeast"]["lat"] = "nort ".rand(-20,41);
		$dados["results"][0]["geometry"]["viewport"]["northeast"]["lng"] = "nort ".rand(-20,41);

		$dados["results"][0]["geometry"]["viewport"]["southwest"]["lat"] = "sout ".rand(-20,41);
		$dados["results"][0]["geometry"]["viewport"]["southwest"]["lng"] = "sout ".rand(-20,41);

		$dados["results"][0]["name"] = $cidade;
		RetornaJSON($dados);
	}
}
?>