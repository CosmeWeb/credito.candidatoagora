<?php
defined('BASEPATH') OR exit('Nenhum acesso de script direto permitido');

class Api extends CI_Controller {

	#######################################################################################################
	public function index()
	{
		$data = Get("Cidade", 0);
		$data = array("dados"=>$data);
		$this->gestao->GetView( 'painel/teste', $data );
	}	
	#######################################################################################################
	public function loginsistema()
	{
		$email = Get("email");
		if(empty($email))
		{
			$msn = __("Você deve informar seu e-mail para efetuar o seu cadastro.");
			RetornaJSONerro($msn);
			return;
		}
		if(!filter_var($email, FILTER_VALIDATE_EMAIL))
		{
			$msn = __("E-mail \"{$email}\" é inválido");
			RetornaJSONerro($msn);
			return;
		}
		$senha = Get("senha");
		if(empty($senha))
		{
			$msn = __("Você deve informar sua senha para efetuar o login.");
			RetornaJSONerro($msn);
			return;
		}
		if(strlen($senha) < 8)
		{
			$msn = __("A sua senha deve ter pelo menos 8 caracteres, contendo letras maiúsculas, letras minúsculas ou dígitos.");
			RetornaJSONerro($msn);
			return;
		}
		$obj = GetModelo("cliente");
		$cliente = $obj->Login($email, $senha);
		if($cliente)
		{
			$this->session->set_userdata($cliente->GetDados());
			$cliente->SetManterConectado(Get("manterconectado","Não"));
			$data['sucesso'] = true;
			$data['mensagem'] = __("Login foi realizado com sucesso.");
			$data['link'] = $cliente->GetLinkAbertura();
			$registro = GetModelo("rastreio");
			$registro->Registrar($cliente->idcliente, "Login");
			$pos = strpos($data['link'],"novavaga");
			if($pos === false)
				$registro->Registrar($cliente->idcliente, "VisualVaga");
			else
				$registro->Registrar($cliente->idcliente, "CadVaga");
			RetornaJSON($data);
		}
		else
		{
			$msn = __("Email ou senha incorreto.<br/>Tente novamente ou peça para recuperar sua senha.");
			RetornaJSONerro($msn);
		}
		return;
	}
	#######################################################################################################
	public function logout()
	{
		$idcliente = GetAcesso("idcliente");
		$registro = GetModelo("rastreio");
		$registro->Registrar($idcliente, "Sair");
		$this->session->sess_destroy();
		$data['sucesso'] = true;
		$data['mensagem'] = __("Logout foi realizado com sucesso.");
		$data['link'] = GetDomino('index.php');
		RetornaJSON($data);
	}
	#######################################################################################################
	public function salvarvaga()
	{
		$idvaga = Get("idvaga",0);
		$obj = GetModelo("vaga");
		if(!empty($idvaga))
		{
			$obj->idvaga = $idvaga;
			if(!$obj->Load())
			{
				$obj->idvaga = 0;
			}
		}
		$obj->fasecadastro = Get("fasecadastro",1);
		switch($obj->fasecadastro)
		{
			case 0:
			case 1:
				$obj->idcliente = Get("idcliente", 0);
				$obj->declarado = Get("declarado", "Não");
				$obj->autorizado = Get("autorizado", "Não");
				$obj->tempocontratacao = Get("tempocontratacao", "");
				$obj->titulodavaga = Get("titulodavaga", "");
				$obj->fasecadastro ++;
				$obj->Ajustar(true);
				$retorno = $obj->Salvar();
				if(empty($retorno))
				{
					$data['sucesso'] = false;
					$data['mensagem'] = __("falha ao salvar os dados da vaga.");
					$data['titulo'] = __("ERRO");
				}
				else
				{
					if(empty($idvaga))
					{
						$obj->idvaga = $retorno;
						$obj->AlertaEmail();
					}
					$data['sucesso'] = true;
					$data['mensagem'] = __("Dados do contratante salvos com sucesso.");
					$data['link'] = GetDomino('index.php/vaga/dadosdashboard/'.$obj->idvaga);
					$data['titulo'] = __("Sucesso");
				}
				break;
			case 2:
				$obj->empresacontratante = Get("empresacontratante", "");
				$obj->idsetor = Get("idsetor", 0);
				$obj->idtamanho = Get("idtamanho", 0);
				$obj->idfaturamento = Get("idfaturamento", 0);
				$obj->momentoatualempresa = Get("momentoatualempresa", "");
				$obj->fase1 = "Concluído";
				$obj->fasecadastro ++;
				$obj->Ajustar(true);
				$retorno = $obj->Salvar();
				if(empty($retorno))
				{
					$data['sucesso'] = false;
					$data['mensagem'] = __("falha ao salvar os dados da vaga.");
					$data['titulo'] = __("ERRO");
				}
				else
				{
					if(empty($idvaga))
					{
						$obj->idvaga = $retorno;
					}
					$data['sucesso'] = true;
					$data['mensagem'] = __("Dados salvos com sucesso.");
					$data['link'] = GetDomino('index.php/vaga/dadosdavaga/'.$obj->idvaga);
					$data['titulo'] = __("Sucesso");
				}
				break;
			case 3:
				$obj->idarea = Get("idarea", 0);
				$obj->idnivel = Get("idnivel", 0);

				$idsubareas = Get("idsubarea", false);
				$idsubareavagas = Get("idsubareavaga", false);

				$cargos = Get("cargo", false);
				$idcargocorrelatos = Get("idcargocorrelato", false);

				$obj->linhadereporte = Get("linhadereporte", "");
				$obj->descricaodavaga = Get("descricaodavaga", "");
				$obj->faixaderemuneracaoinicial = Get("faixaderemuneracaoinicial", 0);
				$obj->faixaderemuneracaofim = Get("faixaderemuneracaofim", 0);

				$idcompetenciacorrelatas = Get("idcompetenciacorrelata", false);
				$idcompetencias = Get("idcompetencia", false);

				$obj->remoto = Get("remoto", "Não");
				$obj->idestado = Get("idestado", 0);
				$obj->idcidade = Get("idcidade", 0);
				$obj->raiodepesquisa = Get("raiodepesquisa", 0);
				$obj->mobilidade = Get("mobilidade", "");
				$obj->fase2 = "Concluído";
				$obj->fasecadastro ++;
				$obj->Ajustar(true);
				$retorno = $obj->Salvar();
				if(empty($retorno))
				{
					$data['sucesso'] = false;
					$data['mensagem'] = __("falha ao salvar os dados da vaga.");
					$data['titulo'] = __("ERRO");
				}
				else
				{
					if(empty($idvaga))
					{
						$obj->idvaga = $retorno;
					}
					$subareavaga = GetModelo("subareavaga");
					if(!empty($idsubareas))
					{
						foreach($idsubareas as $key=>$idsubarea)
						{
							$idsubareavaga = $idsubareavagas[$idsubarea];
							$subareavaga->SalvarSubareavaga( $idsubareavaga, $idsubarea, $obj->idvaga);
						}
					}
					$cargo = GetModelo("cargocorrelato");
					if(!empty($cargos))
					{
						foreach($cargos as $key=>$nomecargo)
						{
							$cargo->SalvarCargo( $idcargocorrelatos[$key], $nomecargo, $obj->idvaga);
						}
					}
					$competencia = GetModelo("competenciacorrelata");
					if(!empty($idcompetenciacorrelatas))
					{
						foreach($idcompetenciacorrelatas as $key=>$idcompetenciacorrelata)
						{
							$competencia->SalvarCompetencia( $idcompetenciacorrelata, $idcompetencias[$key], $obj->idvaga);
						}
					}
					$data['sucesso'] = true;
					$data['mensagem'] = __("Dados salvos com sucesso.");
					$data['link'] = GetDomino('index.php/vaga/dadosdacandidato/'.$obj->idvaga);
					$data['titulo'] = __("Sucesso");
				}
				break;
			case 4:
				$obj->nacionalidadeempresasprofissionaltrabalhou = Get("nacionalidadeempresasprofissionaltrabalhou", "");
				$obj->melhores1000empresa = Get("melhores1000empresa", "Indiferente");
				$obj->listadaembolsa = Get("listadaembolsa", "Indiferente");
				$obj->gptw = Get("gptw", "Indiferente");
				$obj->perfilinovacao = Get("perfilinovacao", "Indiferente");
				$obj->startup = Get("startup", "Indiferente");
				$obj->fase3 = "Concluído";
				$obj->fasecadastro ++;
				$obj->Ajustar(true);
				$retorno = $obj->Salvar();
				$obj->AlertaEmail();
				if(empty($retorno))
				{
					$data['sucesso'] = false;
					$data['mensagem'] = __("falha ao salvar os dados da vaga.");
					$data['titulo'] = __("ERRO");
				}
				else
				{
					if(empty($idvaga))
					{
						$obj->idvaga = $retorno;
					}
					$data['sucesso'] = true;
					$data['mensagem'] = __("Dados salvos com sucesso.");
					$data['link'] = GetDomino('index.php/vaga/dadosdavagasetor/'.$obj->idvaga);
					$data['titulo'] = __("Sucesso");
				}
				break;
			case 5:
				$setores = Get("idsetor", false);
				$idsetortargets = Get("idsetortarget", false);
				$obj->fase4 = "Concluído";
				$obj->fasecadastro ++;
				$obj->Ajustar(true);
				$retorno = $obj->Salvar();
				if(empty($retorno))
				{
					$data['sucesso'] = false;
					$data['mensagem'] = __("falha ao salvar os dados da vaga.");
					$data['titulo'] = __("ERRO");
				}
				else
				{
					if(empty($idvaga))
					{
						$obj->idvaga = $retorno;
					}
					$setor = GetModelo("setortarget");
					if(!empty($setores))
					{
						foreach($setores as $key=>$idsetor)
						{
							$idsetortarget = $idsetortargets[$idsetor];
							$setor->SalvarSetor( $idsetortarget, $idsetor, $obj->idvaga);
						}
					}
					$data['sucesso'] = true;
					$data['mensagem'] = __("Dados salvos com sucesso.");
					$data['link'] = GetDomino('index.php/vaga/dadosdavagaempresa/'.$obj->idvaga);
					$data['titulo'] = __("Sucesso");
				}
				break;
			case 6:
				$selecionarempresas = Get("selecionarempresas", "Não");
				$obj->idcliente = Get("idcliente", 0);
				$obj->selecionarempresas = $selecionarempresas;
				$obj->fasecadastro ++;
				$obj->Ajustar(true);
				$retorno = $obj->Salvar();
				if(empty($retorno))
				{
					$data['sucesso'] = false;
					$data['mensagem'] = __("falha ao salvar os dados da vaga.");
					$data['titulo'] = __("ERRO");
				}
				else
				{
					if(empty($idvaga))
					{
						$obj->idvaga = $retorno;
					}
					$data['sucesso'] = true;
					$data['mensagem'] = __("Dados salvos com sucesso.");
					if($selecionarempresas == "Sim")
						$data['link'] = GetDomino('index.php/vaga/dadosdavagaautoempresa/'.$obj->idvaga);
					else
						$data['link'] = GetDomino('index.php/vaga/dadosdavagaselectempresa/'.$obj->idvaga);

					$data['titulo'] = __("Sucesso");
				}
				break;
			case 7:
				$empresas = Get("idempresa", false);
				$idempresatargets = Get("idempresatarget", false);
				$empresascorrelatas = Get("empresa", false);
				$idempresascorrelatas = Get("idempresacorrelata", false);
				$obj->incluirempresasforatarget = Get("incluirempresasforatarget", "Não");
				$obj->excluirprofissionaisjatrabalhouempresa = Get("excluirprofissionaisjatrabalhouempresa", "Não");
				$obj->fase5 = "Concluído";
				$obj->fasecadastro ++;
				$obj->Ajustar(true);
				$retorno = $obj->Salvar();
				if(empty($retorno))
				{
					$data['sucesso'] = false;
					$data['mensagem'] = __("falha ao salvar os dados da vaga.");
					$data['titulo'] = __("ERRO");
				}
				else
				{
					if(empty($idvaga))
					{
						$obj->idvaga = $retorno;
					}
					$empresa = GetModelo("empresatarget");
					if(!empty($empresas))
					{
						foreach($empresas as $key=>$idempresa)
						{
							$idempresatarget = $idempresatargets[$idempresa];
							$empresa->SalvarEmpresa( $idempresatarget, $idempresa, $obj->idvaga);
						}
					}
					$empresa = GetModelo("empresacorrelata");
					if(!empty($empresascorrelatas))
					{
						foreach($empresascorrelatas as $key=>$nomeempresa)
						{
							$idempresacorrelata = $idempresascorrelatas[$key];
							$empresa->SalvarEmpresa( $idempresacorrelata, $nomeempresa, $obj->idvaga);
						}
					}
					$data['sucesso'] = true;
					$data['mensagem'] = __("Dados salvos com sucesso.");
					$data['link'] = GetDomino('index.php/vaga/dadosdavagaempresaexcluir/'.$obj->idvaga);
					$data['titulo'] = __("Sucesso");
				}
				break;
			case 8:				
				$obj->incluirempresasforatarget = Get("incluirempresasforatarget", "Não");
				$obj->excluirprofissionaisjatrabalhouempresa = Get("excluirprofissionaisjatrabalhouempresa", "Não");
				$obj->fase5 = "Concluído";
				$obj->fasecadastro ++;
				$obj->Ajustar(true);
				$retorno = $obj->Salvar();
				if(empty($retorno))
				{
					$data['sucesso'] = false;
					$data['mensagem'] = __("falha ao salvar os dados da vaga.");
					$data['titulo'] = __("ERRO");
				}
				else
				{
					if(empty($idvaga))
					{
						$obj->idvaga = $retorno;
					}
					$data['sucesso'] = true;
					$data['mensagem'] = __("Dados salvos com sucesso.");
					$data['link'] = GetDomino('index.php/vaga/dadosdavagaempresaexcluir/'.$obj->idvaga);
					$data['titulo'] = __("Sucesso");
				}
				break;
			case 9:
				$idempresas = Get("idempresa", false);
				$idempresatargetexcluirs = Get("idempresatargetexcluir", false);
				$obj->fase6 = "Concluído";
				$obj->fasecadastro ++;
				$obj->Ajustar(true);
				$retorno = $obj->Salvar();
				if(empty($retorno))
				{
					$data['sucesso'] = false;
					$data['mensagem'] = __("falha ao salvar os dados da vaga.");
					$data['titulo'] = __("ERRO");
				}
				else
				{
					if(empty($idvaga))
					{
						$obj->idvaga = $retorno;
					}
					$empresa = GetModelo("empresatargetexcluir");
					if(!empty($idempresas))
					{
						foreach($idempresas as $key=>$idempresa)
						{
							$idempresatargetexcluir = $idempresatargetexcluirs[$key];
							$empresa->SalvarEmpresa( $idempresatargetexcluir, $idempresa, $obj->idvaga);
						}
					}
					$data['sucesso'] = true;
					$data['mensagem'] = __("Dados salvos com sucesso.");
					$data['link'] = GetDomino('index.php/vaga/dadosdavagaresumo/'.$obj->idvaga);
					$data['titulo'] = __("Sucesso");
				}
				break;
			case 10:
				$obj->fasecadastro ++;
				$obj->Ajustar(true);
				$retorno = $obj->Salvar();
				if(empty($retorno))
				{
					$data['sucesso'] = false;
					$data['mensagem'] = __("falha ao salvar os dados da vaga.");
					$data['titulo'] = __("ERRO");
				}
				else
				{
					$data['sucesso'] = true;
					$data['mensagem'] = __("Cadastro da vaga foi realizado com sucesso.");
					$data['link'] = GetDomino('index.php/vaga/dadosdavagafinal/'.$obj->idvaga);
					$data['titulo'] = __("Sucesso");
				}
				break;
		}
		RetornaJSON($data);
	}
	#######################################################################################################
	public function salvaravaliacao()
	{
		$idavaliacao = Get("idavaliacao", 0);
		$idcandidato = Get("idcandidato", 0);
		$obj = GetModelo("avaliacao");
		$novo = true;
		if(!empty($idavaliacao))
		{
			$obj->idavaliacao = $idavaliacao;
			$novo = false;
			if(!$obj->Load())
			{
				$obj->idavaliacao = 0;
				$novo = true;
			}
		}
		$obj->idcliente = GetAcesso("idcliente");
		$obj->idcandidato = $idcandidato;
		$obj->interessemercado = Get("interessemercado");
		$obj->tipodecontratacao = Get("tipodecontratacao");
		$obj->linkedindesatualizado = Get("linkedindesatualizado");
		$obj->inglesdeclarado = Get("inglesdeclarado");
		$obj->finalista = Get("finalista","Não");
		$obj->placement = Get("placement", "Não");
		$obj->perfiltecnicocomportamental = Get("perfiltecnicocomportamental","Não");
		$obj->salariofixomensal = Getfloat(Get("salariofixomensal"));
		$obj->bonusrealizadoanual = Getfloat(Get("bonusrealizadoanual"));
		$obj->situacaotelefone = Get("situacaotelefone");
		$obj->preferenciamobilidade = Get("preferenciamobilidade");
		$obj->motivacaoparamudanca = strip_tags(Get("motivacaoparamudanca"));
		$obj->observacao = strip_tags(Get("observacao"));

		$obj->ip = GetIP();
		$obj->cadastradoem = date("Y-m-d H:i:s");
		$id = $obj->Salvar();
		if($novo)
			$obj->idavaliacao = $id;

		if(empty($obj->linkedindesatualizado))
			$obj->linkedindesatualizado = "Não";
		$marcado = GetModelo("avaliacaomarcado");
		$marcado->SalvarMarcados($obj->idavaliacao, $idcandidato);
		if($novo)
		{
			$data['sucesso'] = true;
			$data['mensagem'] = __("Dados da avaliação do candidato salvos com sucesso.");
			$data['titulo'] = __("Sucesso");
		}
		else
		{
			$data['sucesso'] = true;
			$data['mensagem'] = __("Dados da avaliação do candidato salvos com sucesso.");
			$data['titulo'] = __("Sucesso");
		}
		RetornaJSON($data);
	}
	#######################################################################################################
	public function salvardadoscliente()
	{
		$empresa = Get("empresa");
		if(empty($empresa))
		{
			$msn = __("Você deve informar o nome da sua empresa para efetuar o seu cadastro.");
			RetornaJSONerro($msn);
			return;
		}
		$nome = Get("nome");
		if(empty($nome))
		{
			$msn = __("Você deve informar o seu nome para efetuar o seu cadastro.");
			RetornaJSONerro($msn);
			return;
		}
		$concordo = Get('concordo','Não');
		if((empty($concordo))||($concordo != "Sim"))
		{
			$msn = __("Você deve concordar com os termos e condições.");
			RetornaJSONerro($msn);
			return;
		}
		$email = Get("email");
		if(empty($email))
		{
			$msn = __("Você deve informar seu e-mail para efetuar o seu cadastro.");
			RetornaJSONerro($msn);
			return;
		}
		if(!filter_var($email, FILTER_VALIDATE_EMAIL))
		{
			$msn = __("E-mail \"{$email}\" é inválido");
			RetornaJSONerro($msn);
			return;
		}
		$senha = Get("senha");
		if(empty($senha))
		{
			$msn = __("Você deve informar sua senha para efetuar o login.");
			RetornaJSONerro($msn);
			return;
		}
		if(strlen($senha) < 8)
		{
			$msn = __("A sua senha deve ter pelo menos 8 caracteres, contendo letras maiúsculas, letras minúsculas ou dígitos.");
			RetornaJSONerro($msn);
			return;
		}
		$confirmarsenha = Get("confirmarsenha");
		if($confirmarsenha != $senha)
		{
			$msn = __("Os campos Senha e Confirmação de Senha não conferem.");
			RetornaJSONerro($msn);
			return;
		}
		$acesso = Get("acesso");
		$obj = GetModelo("cliente");
		$obj->email = $email;
		if($obj->EmailExiste())
		{
			$msn = __("O {$email} já existe em nosso cadastro.<br/>Você deve realizar o login ou solicitar a recuperação de sua senha.");
			RetornaJSONerro($msn);
			return;
		}
		$obj->nome = $nome;
		$obj->senha = $senha;
		$obj->concordo = $concordo;
		$obj->status = 'Ativo';
		$obj->manterconectado = 'Não';
		$obj->acesso = $acesso;
		$obj->Ajustar(true);
		$id = $obj->Salvar();
		if($id)
		{
			$data['sucesso'] = true;
			$data['mensagem'] = __("Sua conta foi criada com sucesso.<br/>Você deve realizar o login em nosso site");
			$data['link'] = GetDomino('index.php/painel/login');
			RetornaJSON($data);
		}
		else
		{
			$msn = __("Não foi possível criar sua conta em nosso site<br/>Tente novamente mais tarde.");
			RetornaJSONerro($msn);
		}
		return;
	}
	#######################################################################################################
	public function buscarfiltrosdecargos()
	{
		$obj = GetModelo('cargo');
		$dados = $obj->BuscarFiltrosDeCargos();
		RetornaJSON($dados);
		return;
	}
	#######################################################################################################
	public function buscarfiltrosdeempresas()
	{
		$obj = GetModelo('empresa');
		$dados = $obj->BuscarFiltrosDeEmpresas();
		RetornaJSON($dados);
		return;
	}
	#######################################################################################################
	public function buscarfiltrosdenomeempresas()
	{
		$obj = GetModelo('vaga');
		$dados = $obj->BuscarFiltrosDeNomeEmpresas();
		RetornaJSON($dados);
		return;
	}
	#######################################################################################################
	public function buscarfiltrosdevagas()
	{
		$obj = GetModelo('vaga');
		$dados = $obj->BuscarFiltrosDeVagas();
		RetornaJSON($dados);
		return;
	}
	#######################################################################################################
	public function candidatosmarcados()
	{
		$obj = GetModelo('candidato');
		$dados = $obj->CandidatosMarcados();
		RetornaJSON($dados);
		return;
	}
	#######################################################################################################
	public function candidatosavaliados()
	{
		$obj = GetModelo('candidato');
		$dados = $obj->CandidatosAvaliados();
		//XDebug($dados, $this);
		RetornaJSON($dados);
		return;
	}
	#######################################################################################################
	public function listatabela()
	{
		$obj = GetModelo('painel');
		$filtro = $obj->Filtro();
		$sql = $obj->GetSqlLista();
		$sqlTotal = $obj->GetSqlTotalLista();
		$dados = $obj->listatabela($filtro, $sql, $sqlTotal);
		//XDebug($dados, $this);
		RetornaJSON($dados);
	}
	#######################################################################################################
	public function exportarcandidatoscontatos()
	{
		$obj = GetModelo('painel');
		if($obj)
		{
			$dados = $obj->ExportarCandidatosContatos();
		}
		else
		{
			$dados['sucesso'] = false;
			$dados['erro'] = __("Erro ao exportar candidatos que foram contactados.");
		}
		RetornaJSON($dados);
	}
	#######################################################################################################
	public function exportarcandidatosmarcados()
	{
		$obj = GetModelo('painel');
		if($obj)
		{
			$dados = $obj->ExportarCandidatosMarcados();
		}
		else
		{
			$dados['sucesso'] = false;
			$dados['erro'] = __("Erro ao exportar candidatos que foram contactados.");
		}
		RetornaJSON($dados);
	}
	#######################################################################################################
	public function exportarcandidatosavaliados()
	{
		$obj = GetModelo('painel');
		if($obj)
		{
			$dados = $obj->ExportarCandidatosAvaliados();
		}
		else
		{
			$dados['sucesso'] = false;
			$dados['erro'] = __("Erro ao exportar candidatos que foram contactados.");
		}
		RetornaJSON($dados);
	}
	#######################################################################################################
	public function baixarcandidatoscontatos($file = "")
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
	public function listacidades()
	{
		$obj = GetModelo('cidade');
		$dados = $obj->ListaCidades();
		RetornaJSON($dados);
		return;
	}
	#######################################################################################################
	public function carregarmaissetores()
	{
		$obj = GetModelo('setortarget');
		$dados = $obj->CarregarMaisSetores();
		RetornaJSON($dados);
		return;
	}
	#######################################################################################################
	public function carregarmaisempresas()
	{
		$obj = GetModelo('empresatarget');
		$dados = $obj->CarregarMaisEmpresas();
		RetornaJSON($dados);
		return;
	}
	#######################################################################################################
	public function carregarmaisempresascorrelata()
	{
		$obj = GetModelo('empresacorrelata');
		$dados = $obj->CarregarMaisEmpresas();
		RetornaJSON($dados);
		return;
	}
	#######################################################################################################
	public function carregarmaisempresasexcluir()
	{
		$obj = GetModelo('empresatargetexcluir');
		$dados = $obj->CarregarMaisEmpresas();//XDebug($dados, $this);
		RetornaJSON($dados);
		return;
	}
	#######################################################################################################
	public function carregarmaissubareavaga()
	{
		$obj = GetModelo('subareavaga');
		$dados = $obj->CarregarMaisSubareaVaga();
		RetornaJSON($dados);
		return;
	}
	#######################################################################################################
	public function carregarmaiscargoscorrelato()
	{
		$obj = GetModelo('cargocorrelato');
		$dados = $obj->CarregarMaisCargos();
		RetornaJSON($dados);
		return;
	}
	#######################################################################################################
	public function carregarmaiscompetenciacorrelata()
	{
		$obj = GetModelo('competenciacorrelata');
		$dados = $obj->CarregarMaisCompetencias();
		RetornaJSON($dados);
		return;
	}
	#######################################################################################################
	public function deletecandidato()
	{
		$obj = GetModelo("candidato");
		if(!empty($obj))
		{
			$obj->idcandidato = Get("idcandidato", 0);
			if(!$obj->Load())
			{
				$dados['sucesso'] = false;
				$dados['erro'] = __("Não foi possível excluir este candidato da vaga.");
				$dados['titulo'] = __("Erro");
			}
			else
			{
				$idvaga = Get("idvaga", 0);
				$total = $obj->TemMaisdeVaga($idvaga);
				if($total > 0)
				{
					if($obj->DeletarCandidatoDaVaga($idvaga, $obj->idcandidato))
					{
						$dados['sucesso'] = true;
						$dados['mensagem'] = __("Candidato da vaga foi excluido desta vaga com sucesso.");
						$dados['titulo'] = __("Sucesso");
					}
					else
					{
						$dados['sucesso'] = false;
						$dados['erro'] = __("Não foi possível excluir este candidato da vaga.");
						$dados['titulo'] = __("Erro");
					}
				}
				else
				{
					if($obj->Apagar())
					{
						$dados['sucesso'] = true;
						$dados['mensagem'] = __("Candidato da vaga foi excluido desta vaga com sucesso.");
						$dados['titulo'] = __("Sucesso");
					}
					else
					{
						$dados['sucesso'] = false;
						$dados['erro'] = __("Não foi possível excluir este candidato da vaga.");
						$dados['titulo'] = __("Erro");
					}
				}
				$idcliente = GetAcesso("idcliente");
				$registro = GetModelo("rastreio");
				$registro->Registrar($idcliente, "DeleteCandidato", $idvaga, $obj->idcandidato);
			}
		}
		else
		{
			$dados['sucesso'] = false;
			$dados['erro'] = __("Erro ao localizar o candidato da vaga.");
		}//XDebug($dados, $this);
		RetornaJSON($dados);
	}
	#######################################################################################################
	public function deletesetortarget()
	{
		$obj = GetModelo("setortarget");
		if(!empty($obj))
		{
			$obj->idsetortarget = Get("idsetortarget", 0);
			if(!$obj->Load())
			{
				$dados['sucesso'] = false;
				$dados['erro'] = __("Não foi possível excluir este setor da vaga.");
				$dados['titulo'] = __("Erro");
			}
			else
			{
				
				$obj->DeletarEmpresaVaga();
				if($obj->Apagar())
				{
					$dados['sucesso'] = true;
					$dados['mensagem'] = __("Setor foi excluido desta vaga com sucesso.");
					$dados['titulo'] = __("Sucesso");
				}
				else
				{
					$dados['sucesso'] = false;
					$dados['erro'] = __("Não foi possível excluir este setor da vaga.");
					$dados['titulo'] = __("Erro");
				}
			}
		}
		else
		{
			$dados['sucesso'] = false;
			$dados['erro'] = __("Erro ao localizar o setor na base de dados.");
		}
		RetornaJSON($dados);
	}
	#######################################################################################################
	public function deleteempresatarget()
	{
		$obj = GetModelo("empresatarget");
		if(!empty($obj))
		{
			$obj->idempresatarget = Get("idempresatarget", 0);
			if(!$obj->Load())
			{
				$dados['sucesso'] = false;
				$dados['erro'] = __("Não foi possível excluir esta empresa da vaga.");
				$dados['titulo'] = __("Erro");
			}
			else
			{
				if($obj->Apagar())
				{
					$dados['sucesso'] = true;
					$dados['mensagem'] = __("Empresa foi excluida desta vaga com sucesso.");
					$dados['titulo'] = __("Sucesso");
				}
				else
				{
					$dados['sucesso'] = false;
					$dados['erro'] = __("Não foi possível excluir esta empresa da vaga.");
					$dados['titulo'] = __("Erro");
				}
			}
		}
		else
		{
			$dados['sucesso'] = false;
			$dados['erro'] = __("Erro ao localizar a empresa na base de dados.");
		}
		RetornaJSON($dados);
	}
	#######################################################################################################
	public function deleteempresacorrelata()
	{
		$obj = GetModelo("empresacorrelata");
		if(!empty($obj))
		{
			$obj->idempresacorrelata = Get("idempresacorrelata", 0);
			if(!$obj->Load())
			{
				$dados['sucesso'] = false;
				$dados['erro'] = __("Não foi possível excluir esta empresa da vaga.");
				$dados['titulo'] = __("Erro");
			}
			else
			{
				if($obj->Apagar())
				{
					$dados['sucesso'] = true;
					$dados['mensagem'] = __("Empresa foi excluida desta vaga com sucesso.");
					$dados['titulo'] = __("Sucesso");
				}
				else
				{
					$dados['sucesso'] = false;
					$dados['erro'] = __("Não foi possível excluir esta empresa da vaga.");
					$dados['titulo'] = __("Erro");
				}
			}
		}
		else
		{
			$dados['sucesso'] = false;
			$dados['erro'] = __("Erro ao localizar a empresa na base de dados.");
		}
		RetornaJSON($dados);
	}
	#######################################################################################################
	public function deleteempresatargetexcluir()
	{
		$obj = GetModelo("empresatargetexcluir");
		if(!empty($obj))
		{
			$obj->idempresatargetexcluir = Get("idempresatargetexcluir", 0);
			if(!$obj->Load())
			{
				$dados['sucesso'] = false;
				$dados['erro'] = __("Não foi possível excluir esta empresa da vaga.");
				$dados['titulo'] = __("Erro");
			}
			else
			{
				if($obj->Apagar())
				{
					$dados['sucesso'] = true;
					$dados['mensagem'] = __("Empresa foi excluida desta vaga com sucesso.");
					$dados['titulo'] = __("Sucesso");
				}
				else
				{
					$dados['sucesso'] = false;
					$dados['erro'] = __("Não foi possível excluir esta empresa da vaga.");
					$dados['titulo'] = __("Erro");
				}
			}
		}
		else
		{
			$dados['sucesso'] = false;
			$dados['erro'] = __("Erro ao localizar a empresa na base de dados.");
		}
		RetornaJSON($dados);
	}	
	#######################################################################################################
	public function deletecargocorrelato()
	{
		$obj = GetModelo("cargocorrelato");
		if(!empty($obj))
		{
			$obj->idcargocorrelato = Get("idcargocorrelato", 0);
			if(!$obj->Load())
			{
				$dados['sucesso'] = false;
				$dados['erro'] = __("Não foi possível excluir este cargo da vaga.");
				$dados['titulo'] = __("Erro");
			}
			else
			{
				if($obj->Apagar())
				{
					$dados['sucesso'] = true;
					$dados['mensagem'] = __("Cargo foi excluido desta vaga com sucesso.");
					$dados['titulo'] = __("Sucesso");
				}
				else
				{
					$dados['sucesso'] = false;
					$dados['erro'] = __("Não foi possível excluir este cargo da vaga.");
					$dados['titulo'] = __("Erro");
				}
			}
		}
		else
		{
			$dados['sucesso'] = false;
			$dados['erro'] = __("Erro ao localizar o cargo na base de dados.");
		}
		RetornaJSON($dados);
	}
	#######################################################################################################
	public function deletecompetenciacorrelata()
	{
		$obj = GetModelo("competenciacorrelata");
		if(!empty($obj))
		{
			$obj->idcompetenciacorrelata = Get("idcompetenciacorrelata", 0);
			if(!$obj->Load())
			{
				$dados['sucesso'] = false;
				$dados['erro'] = __("Não foi possível excluir esta competência da vaga.");
				$dados['titulo'] = __("Erro");
			}
			else
			{
				if($obj->Apagar())
				{
					$dados['sucesso'] = true;
					$dados['mensagem'] = __("Competência foi excluida desta vaga com sucesso.");
					$dados['titulo'] = __("Sucesso");
				}
				else
				{
					$dados['sucesso'] = false;
					$dados['erro'] = __("Não foi possível excluir esta competência da vaga.");
					$dados['titulo'] = __("Erro");
				}
			}
		}
		else
		{
			$dados['sucesso'] = false;
			$dados['erro'] = __("Erro ao localizar a competência na base de dados.");
		}
		RetornaJSON($dados);
	}
	#######################################################################################################
	public function deletesubareavaga()
	{
		$obj = GetModelo("subareavaga");
		if(!empty($obj))
		{
			$obj->idsubareavaga = Get("idsubareavaga", 0);
			if(!$obj->Load())
			{
				$dados['sucesso'] = false;
				$dados['erro'] = __("Não foi possível excluir esta subarea da vaga.");
				$dados['titulo'] = __("Erro");
			}
			else
			{
				if($obj->Apagar())
				{
					$dados['sucesso'] = true;
					$dados['mensagem'] = __("Subarea foi excluida desta vaga com sucesso.");
					$dados['titulo'] = __("Sucesso");
				}
				else
				{
					$dados['sucesso'] = false;
					$dados['erro'] = __("Não foi possível excluir esta subarea da vaga.");
					$dados['titulo'] = __("Erro");
				}
			}
		}
		else
		{
			$dados['sucesso'] = false;
			$dados['erro'] = __("Erro ao localizar a subarea na base de dados.");
		}
		RetornaJSON($dados);
	}
	#######################################################################################################
	public function deletaravaliacao()
	{
		$obj = GetModelo("avaliacao");
		if(!empty($obj))
		{
			$obj->idavaliacao = Get("idavaliacao", 0);
			$idcandidato = Get("idcandidato", 0);
			$idvaga = Get("idvaga", 0);
			if(!$obj->Load())
			{
				$dados['sucesso'] = false;
				$dados['erro'] = __("Não foi possível excluir esta avaliação do candidato.");
				$dados['titulo'] = __("Erro");
			}
			else
			{
				if($obj->Apagar())
				{
					$dados['sucesso'] = true;
					$dados['mensagem'] = __("Avaliação do candidato foi excluida com sucesso.");
					$dados['titulo'] = __("Sucesso");
				}
				else
				{
					$dados['sucesso'] = false;
					$dados['erro'] = __("Não foi possível excluir esta avaliação do candidato.");
					$dados['titulo'] = __("Erro");
				}
			}
		}
		else
		{
			$dados['sucesso'] = false;
			$dados['erro'] = __("Erro ao localizar o candidato da vaga.");
		}//XDebug($dados, $this);
		RetornaJSON($dados);
	}
	#######################################################################################################
	public function listasubareas()
	{
		if(TemAcesso("Cliente"))
		{
			$dados['sucesso'] = true;
			$dados['lista'] = false;
			$dados['mensagem'] = "";
			$dados['titulo'] = "";
			$dados['idcliente'] = 0;		
			$dados['idvaga'] = 0;
			$dados['posicao'] = 0;
			$dados['limite'] = 0;
			$dados['total'] = 0;
			$dados['finalizado'] = true;
			RetornaJSONcode($dados);
			return;
		}
		else
		{
			$obj = GetModelo('subarea');
			$dados = $obj->ListaSubareas();
			RetornaJSON($dados);
			return;
		}
	}	
	#######################################################################################################
	public function lerlistacidades()
	{
		$obj = GetModelo('cidade');
		$dados = $obj->LerListaCidades();
		//XDebug($dados, $this);
		RetornaJSONcode($dados);
		return;
	}
	#######################################################################################################
	public function lerlistaestados()
	{
		$obj = GetModelo('estado');
		$dados = $obj->LerListaEstados();//XDebug($dados, $this);
		RetornaJSONcode($dados);
		return;
	}
	#######################################################################################################
	public function lerlistapais()
	{
		$obj = GetModelo('pais');
		$dados = $obj->LerListaPaises();
		RetornaJSONcode($dados);
		return;
	}
	#######################################################################################################
	public function lerlistacompetencias()
	{
		if(TemAcesso("Cliente"))
		{
			$dados['sucesso'] = true;
			$dados['lista'] = false;
			$dados['mensagem'] = "";
			$dados['titulo'] = "";
			$dados['idcliente'] = 0;		
			$dados['idvaga'] = 0;
			$dados['posicao'] = 0;
			$dados['limite'] = 0;
			$dados['total'] = 0;
			$dados['finalizado'] = true;
			RetornaJSONcode($dados);
			return;
		}
		else
		{
			$obj = GetModelo('competencia');
			$dados = $obj->LerListaCompetencias();
			RetornaJSONcode($dados);
			return;
		}
	}
	#######################################################################################################
	public function lerlistaniveis()
	{
		if(TemAcesso("Cliente"))
		{
			$dados['sucesso'] = true;
			$dados['lista'] = false;
			$dados['mensagem'] = "";
			$dados['titulo'] = "";
			$dados['idcliente'] = 0;		
			$dados['idvaga'] = 0;
			$dados['posicao'] = 0;
			$dados['limite'] = 0;
			$dados['total'] = 0;
			$dados['finalizado'] = true;
			RetornaJSONcode($dados);
			return;
		}
		else
		{
			$obj = GetModelo('nivel');
			$dados = $obj->LerListaNiveis();
			RetornaJSONcode($dados);
			return;
		}
	}
	#######################################################################################################
	public function lerlistasetores()
	{
		if(TemAcesso("Cliente"))
		{
			$dados['sucesso'] = true;
			$dados['lista'] = false;
			$dados['mensagem'] = "";
			$dados['titulo'] = "";
			$dados['idcliente'] = 0;		
			$dados['idvaga'] = 0;
			$dados['posicao'] = 0;
			$dados['limite'] = 0;
			$dados['total'] = 0;
			$dados['finalizado'] = true;
			RetornaJSONcode($dados);
			return;
		}
		else
		{
			$obj = GetModelo('setor');
			$dados = $obj->LerListaSetores();
			//XDebug($dados, $this);
			RetornaJSONcode($dados);
			return;
		}
	}
	#######################################################################################################
	public function lerlistaareas()
	{
		if(TemAcesso("Cliente"))
		{
			$dados['sucesso'] = true;
			$dados['lista'] = false;
			$dados['mensagem'] = "";
			$dados['titulo'] = "";
			$dados['idcliente'] = 0;		
			$dados['idvaga'] = 0;
			$dados['posicao'] = 0;
			$dados['limite'] = 0;
			$dados['total'] = 0;
			$dados['finalizado'] = true;
			RetornaJSONcode($dados);
			return;
		}
		else
		{
			$obj = GetModelo('area');
			$dados = $obj->LerListaAreas();
			RetornaJSONcode($dados);
			return;
		}
	}
	#######################################################################################################
	public function lerlistasubareas()
	{
		if(TemAcesso("Cliente"))
		{
			$dados['sucesso'] = true;
			$dados['lista'] = false;
			$dados['mensagem'] = "";
			$dados['titulo'] = "";
			$dados['idcliente'] = 0;		
			$dados['idvaga'] = 0;
			$dados['posicao'] = 0;
			$dados['limite'] = 0;
			$dados['total'] = 0;
			$dados['finalizado'] = true;
			RetornaJSONcode($dados);
			return;
		}
		else
		{
			$obj = GetModelo('subarea');
			$dados = $obj->LerListaSubareas();
			RetornaJSONcode($dados);
			return;
		}
	}
	#######################################################################################################
	public function lerlistaempresas()
	{
		$obj = GetModelo('empresacargo');
		$dados = $obj->LerListaEmpresas();
		//XDebug($dados, $this);
		RetornaJSONcode($dados);
		return;
	}
	#######################################################################################################
	public function lerlistavagas()
	{
		$obj = GetModelo('vaga');
		$dados = $obj->LerListaVagas();
		RetornaJSONcode($dados);
		return;
	}
	#######################################################################################################
	public function lerlistacandidatos()
	{
		$obj = GetModelo('candidato');
		$dados = $obj->LerListaCandidatos();
		//XDebug($dados, $this);
		RetornaJSONcode($dados);
		return;
	}
	#######################################################################################################
	public function lerlistabots()
	{
		if(TemAcesso("Cliente"))
		{
			$dados['sucesso'] = true;
			$dados['lista'] = false;
			$dados['mensagem'] = "";
			$dados['titulo'] = "";
			$dados['idcliente'] = 0;		
			$dados['idvaga'] = 0;
			$dados['posicao'] = 0;
			$dados['limite'] = 0;
			$dados['total'] = 0;
			$dados['finalizado'] = true;
			RetornaJSONcode($dados);
			return;
		}
		else
		{
			$obj = GetModelo('candidatobot');
			$dados = $obj->LerListaBots();
			RetornaJSONcode($dados);
			return;
		}
	}
	#######################################################################################################
	public function lerlistafavoritos()
	{
		if(TemAcesso("Cliente"))
		{
			$dados['sucesso'] = true;
			$dados['lista'] = false;
			$dados['mensagem'] = "";
			$dados['titulo'] = "";
			$dados['idcliente'] = 0;		
			$dados['idvaga'] = 0;
			$dados['posicao'] = 0;
			$dados['limite'] = 0;
			$dados['total'] = 0;
			$dados['finalizado'] = true;
			RetornaJSONcode($dados);
			return;
		}
		else
		{
			$obj = GetModelo('favorito');
			$dados = $obj->LerListaFavoritos();//XDebug($dados, $this);
			RetornaJSONcode($dados);
			return;
		}
	}
	#######################################################################################################
	public function lerlistafavoritosgrupo()
	{
		if(TemAcesso("Cliente"))
		{
			$dados['sucesso'] = true;
			$dados['lista'] = false;
			$dados['mensagem'] = "";
			$dados['titulo'] = "";
			$dados['idcliente'] = 0;		
			$dados['idvaga'] = 0;
			$dados['posicao'] = 0;
			$dados['limite'] = 0;
			$dados['total'] = 0;
			$dados['finalizado'] = true;
			RetornaJSONcode($dados);
			return;
		}
		else
		{
			$obj = GetModelo('favoritogrupo');
			$dados = $obj->LerListaFavoritos();
			//XDebug($dados, $this);
			RetornaJSONcode($dados);
			return;
		}
	}
	#######################################################################################################
	public function lerlistaabordagem()
	{
		if(TemAcesso("Cliente"))
		{
			$dados['sucesso'] = true;
			$dados['lista'] = false;
			$dados['mensagem'] = "";
			$dados['titulo'] = "";
			$dados['idcliente'] = 0;		
			$dados['idvaga'] = 0;
			$dados['posicao'] = 0;
			$dados['limite'] = 0;
			$dados['total'] = 0;
			$dados['finalizado'] = true;
			RetornaJSONcode($dados);
			return;
		}
		else
		{
			$obj = GetModelo('abordagem');
			$dados = $obj->LerListaAbordagens();
			XDebug($dados, $this);
			RetornaJSONcode($dados);
			return;
		}
	}
	#######################################################################################################
	public function lerlistainteresses()
	{
		if(TemAcesso("Cliente"))
		{
			$dados['sucesso'] = true;
			$dados['lista'] = false;
			$dados['mensagem'] = "";
			$dados['titulo'] = "";
			$dados['idcliente'] = 0;		
			$dados['idvaga'] = 0;
			$dados['posicao'] = 0;
			$dados['limite'] = 0;
			$dados['total'] = 0;
			$dados['finalizado'] = true;
			RetornaJSONcode($dados);
			return;
		}
		else
		{
			$obj = GetModelo('candidatointeresse');
			$dados = $obj->LerListaInteresses();//XDebug($dados, $this);
			RetornaJSONcode($dados);
			return;
		}
	}
	#######################################################################################################
	public function lerfiltrocontatos()
	{
		if(TemAcesso("Cliente"))
		{
			$dados['sucesso'] = true;
			$dados['lista'] = false;
			$dados['mensagem'] = "";
			$dados['titulo'] = "";
			$dados['idcliente'] = 0;		
			$dados['idvaga'] = 0;
			$dados['posicao'] = 0;
			$dados['limite'] = 0;
			$dados['total'] = 0;
			$dados['finalizado'] = true;
			RetornaJSONcode($dados);
			return;
		}
		else
		{
			$obj = GetModelo('candidato');
			$dados = $obj->LerFiltroContatos();
			//XDebug($dados, $this);
			RetornaJSONcode($dados);
			return;
		}
	}
	#######################################################################################################
	public function lerfiltrodatadaaplicacao()
	{
		$obj = GetModelo('candidato');
		$dados = $obj->LerFiltroDatadaAplicacao();
		RetornaJSONcode($dados);
		return;
	}
	#######################################################################################################
	public function lerfiltrotoptalent()
	{
		$obj = GetModelo('toptalent');
		$dados = $obj->LerFiltroToptalent();//XDebug($dados, $this);
		RetornaJSONcode($dados);
		return;
	}
	#######################################################################################################
	public function lerfiltrotamanhoempresas()
	{
		if(TemAcesso("Cliente"))
		{
			$dados['sucesso'] = true;
			$dados['lista'] = false;
			$dados['mensagem'] = "";
			$dados['titulo'] = "";
			$dados['idcliente'] = 0;		
			$dados['idvaga'] = 0;
			$dados['posicao'] = 0;
			$dados['limite'] = 0;
			$dados['total'] = 0;
			$dados['finalizado'] = true;
			RetornaJSONcode($dados);
			return;
		}
		else
		{
			$obj = GetModelo('tamanho');
			$dados = $obj->lerfiltroTamanhoEmpresas();
			RetornaJSONcode($dados);
			return;
		}
	}
	#######################################################################################################
	public function lerlistaperfis()
	{
		if(TemAcesso("Cliente"))
		{
			$dados['sucesso'] = true;
			$dados['lista'] = false;
			$dados['mensagem'] = "";
			$dados['titulo'] = "";
			$dados['idcliente'] = 0;		
			$dados['idvaga'] = 0;
			$dados['posicao'] = 0;
			$dados['limite'] = 0;
			$dados['total'] = 0;
			$dados['finalizado'] = true;
			RetornaJSONcode($dados);
			return;
		}
		else
		{
			$obj = GetModelo('candidatoperfil');
			$dados = $obj->LerListaPerfis();//XDebug($dados, $this);
			RetornaJSONcode($dados);
			return;
		}
	}
	#######################################################################################################
	public function leropcaoclassificacaocandidatos()
	{
		$obj = GetModelo('candidato');
		$dados = $obj->LerOpcaoClassificacaoCandidatos();
		RetornaJSONcode($dados);
		return;
	}
	#######################################################################################################
	public function leropcaoclassificacaovagas()
	{
		$obj = GetModelo('vaga');
		$dados = $obj->LerOpcaoClassificacaoVagas();
		RetornaJSONcode($dados);
		return;
	}
	#######################################################################################################
	public function leropcaoativovagas()
	{
		$obj = GetModelo('vaga');
		$dados = $obj->LerOpcaoAtivoVagas();
		RetornaJSONcode($dados);
		return;
	}
	#######################################################################################################
	public function marcarcandidato()
	{
		$obj = GetModelo('favorito');
		$dados = $obj->MarcarCandidato();//XDebug($dados, $this);

		$idcandidato = Get("idcandidato", "");
		$idvaga = Get("idvaga", 0);
		$desmarcar = Get("desmarcar", 0);
		$idcliente = GetAcesso("idcliente");
		$registro = GetModelo("rastreio");
		if(empty($desmarcar))
			$codigo = "MarcarFavorito";
		else
			$codigo = "DesmarcarFavorito";
		$registro->Registrar($idcliente, $codigo, $idvaga, $idcandidato);

		RetornaJSON($dados);
		return;
	}
	#######################################################################################################
	public function marcarcandidatofavoritogrupo()
	{
		$obj = GetModelo('favoritogrupo');
		$dados = $obj->MarcarCandidato();//XDebug($dados, $this);

		$idcandidato = Get("idcandidato", "");
		$idvaga = Get("idvaga", 0);
		$desmarcar = Get("desmarcar", 0);
		$idcliente = GetAcesso("idcliente");
		$registro = GetModelo("rastreio");
		if(empty($desmarcar))
			$codigo = "MarcarFavoritoGrupo";
		else
			$codigo = "DesmarcarFavoritoGrupo";
		$registro->Registrar($idcliente, $codigo, $idvaga, $idcandidato);

		RetornaJSON($dados);
		return;
	}
	#######################################################################################################
	public function marcartoptalent()
	{
		$obj = GetModelo('toptalent');
		$dados = $obj->MarcarToptalent();//XDebug($dados, $this);

		$idcandidato = Get("idcandidato", "");
		$idvaga = Get("idvaga", 0);
		$desmarcar = Get("desmarcar", 0);
		$idcliente = GetAcesso("idcliente");
		$registro = GetModelo("rastreio");
		if(empty($desmarcar))
			$codigo = "MarcarToptalent";
		else
			$codigo = "DesmarcarToptalent";
		$registro->Registrar($idcliente, $codigo, $idvaga, $idcandidato);

		RetornaJSON($dados);
		return;
	}
	#######################################################################################################
	public function marcardesconsiderado()
	{
		$obj = GetModelo('favorito');
		$dados = $obj->MarcarDesconsiderado();//XDebug($dados, $this);

		$idcandidato = Get("idcandidato", "");
		$idvaga = Get("idvaga", 0);
		$desmarcar = Get("desmarcar", 0);
		$idcliente = GetAcesso("idcliente");
		$registro = GetModelo("rastreio");
		if(empty($desmarcar))
			$codigo = "MarcarDesconsiderado";
		else
			$codigo = "DesmarcarDesconsiderado";
		$registro->Registrar($idcliente, $codigo, $idvaga, $idcandidato);

		RetornaJSON($dados);
		return;
	}
	#######################################################################################################
	public function registraracesso()
	{
		$idcliente = GetAcesso("idcliente");
		$codigo = Get("codigo","");
		$idvaga = Get("idvaga", 0);
		$idcandidato = Get("idcandidato", 0);
		$registro = GetModelo("rastreio");
		if($registro->Registrar($idcliente, $codigo, $idvaga, $idcandidato))
		{
			$data['sucesso'] = true;
			$data['mensagem'] = __("Tipo de acesso foi registrado com sucesso.");
		}
		else
		{
			$data['sucesso'] = false;
			$data['erro'] = __("Não foi possivel registrar o tipo de acesso.");
		}
		RetornaJSON($data);
	}
	#######################################################################################################
	public function lerfiltronacionalidade()
	{
		if(TemAcesso("Cliente"))
		{
			$dados['sucesso'] = true;
			$dados['lista'] = false;
			$dados['mensagem'] = "";
			$dados['titulo'] = "";
			$dados['idcliente'] = 0;		
			$dados['idvaga'] = 0;
			$dados['posicao'] = 0;
			$dados['limite'] = 0;
			$dados['total'] = 0;
			$dados['finalizado'] = true;
			RetornaJSONcode($dados);
			return;
		}
		else
		{
			$obj = GetModelo('nacionalidade');
			$dados = $obj->lerFiltroNacionalidade();
			RetornaJSONcode($dados);
			return;
		}
	}
	#######################################################################################################
	public function lerfiltroidioma()
	{
		$obj = GetModelo('idioma');
		$dados = $obj->lerFiltroIdioma();//XDebug($dados, $this);
		RetornaJSONcode($dados);
		return;
	}
	#######################################################################################################
	public function lerlistasexo()
	{
		if(TemAcesso("Cliente"))
		{
			$dados['sucesso'] = true;
			$dados['lista'] = false;
			$dados['mensagem'] = "";
			$dados['titulo'] = "";
			$dados['idcliente'] = 0;		
			$dados['idvaga'] = 0;
			$dados['posicao'] = 0;
			$dados['limite'] = 0;
			$dados['total'] = 0;
			$dados['finalizado'] = true;
			RetornaJSONcode($dados);
			return;
		}
		else
		{
			$obj = GetModelo('candidato');
			$dados = $obj->LerListaSexo();
			RetornaJSONcode($dados);
			return;
		}
	}
	#######################################################################################################
	public function lerlistaavaliados()
	{
		if(TemAcesso("Cliente"))
		{
			$dados['sucesso'] = true;
			$dados['lista'] = false;
			$dados['mensagem'] = "";
			$dados['titulo'] = "";
			$dados['idcliente'] = 0;		
			$dados['idvaga'] = 0;
			$dados['posicao'] = 0;
			$dados['limite'] = 0;
			$dados['total'] = 0;
			$dados['finalizado'] = true;
			RetornaJSONcode($dados);
			return;
		}
		else
		{
			$obj = GetModelo('avaliacao');
			$dados = $obj->LerListaAvaliados();
			//XDebug($dados, $this);
			RetornaJSONcode($dados);
			return;
		}
	}	
	#######################################################################################################
	public function lertotalavaliacao()
	{
		$obj = GetModelo('avaliacao');
		$chave = Get("chave", false);
		$identificador = Get("identificador", false);
		if(!$obj->VerificarChave($chave, $identificador))
		{
			$dados['sucesso'] = false;
			$dados['erro'] = __("Chave de acesso inválida.");
			RetornaJSON($dados, true);
			return;
		}
		$total = $obj->GetTotalAvaliacaoEnviado();
		$dados['sucesso'] = true;
		$dados['titulo'] = __("Sucesso");
		if(empty($total))
		{
			$dados['mensagem'] = __("Nenhuma avaliação a ser enviada.");
		}
		elseif($total == 1)
		{
			$dados['mensagem'] = sprintf( __("1 avaliação que não foi enviada."), $total);
		}
		else
		{
			$dados['mensagem'] = sprintf( __("%d avaliações que não foram enviadas."), $total);	
		}
		$dados['total'] = $total;//XDebug($dados, $this);
		RetornaJSONcode($dados);
	}
	#######################################################################################################
	public function getavaliacaoenviado()
	{
		$obj = GetModelo('avaliacao');
		$chave = Get("chave", false);
		$identificador = Get("identificador", false);
		$total = Get("total", 0);
		$posicao = Get("posicao", 0);
		$limite = Get("limite", $obj->GetLimite());
		if(!$obj->VerificarChave($chave, $identificador))
		{
			$dados['sucesso'] = false;
			$dados['erro'] = __("Chave de acesso inválida.");
			RetornaJSONcode($dados);
			return;
		}
		if(empty($total))
			$total = $obj->GetTotalAvaliacaoEnviado();
		if(empty($total))
		{
			$dados['sucesso'] = false;
			$dados['erro'] = __("Nenhuma avaliação a ser enviada.");
			RetornaJSONcode($dados);
			return;
		}
		$curriculos = $obj->GetAvaliacaoEnviado();
		if(empty($curriculos))
		{
			$dados['sucesso'] = false;
			$dados['erro'] = __("Nenhuma avaliação a ser enviada.");
			RetornaJSONcode($dados);
			return;
		}
		$dados['sucesso'] = true;
		$enviados = $posicao + $limite;
		if($enviados >= $total)
		{
			$dados['finalizado'] = true;
			$dados['titulo'] = __("Importação finalizada.");
			$dados['mensagem'] = __("Importação de avaliações foi finalizada.");
		}
		else
		{
			$dados['finalizado'] = false;
			$dados['titulo'] = __("Importação de avaliações.");
			$dados['mensagem'] = __("Importação de avaliações está sendo processada.");
		}
		$dados['total'] = $total;
		$dados['posicao'] = $enviados;
		$dados['limite'] = $limite;
		$dados['curriculos'] = $curriculos;
		
		//XDebug($dados, $this);
		RetornaJSONcode($dados);
	}
	#######################################################################################################
	public function buscarcandidatointeressemercado()
	{
		$obj = GetModelo('avaliacao');
		$chave = Get("chave", false);
		$identificador = Get("identificador", false);
		if(!$obj->VerificarChave($chave, $identificador))
		{
			$dados['sucesso'] = false;
			$dados['erro'] = __("Chave de acesso inválida.");
			RetornaJSONcode($dados);
			return;
		}
		$lista = $obj->BuscarOpcoesDeInteressemercado();
		$dados['sucesso'] = true;
		$dados['lista'] = $lista;
		//XDebug($dados, $this);
		RetornaJSONcode($dados);
	}
	#######################################################################################################
	public function buscarcandidatovagas()
	{
		$obj = GetModelo('avaliacao');
		$chave = Get("chave", false);
		$identificador = Get("identificador", false);
		if(!$obj->VerificarChave($chave, $identificador))
		{
			$dados['sucesso'] = false;
			$dados['erro'] = __("Chave de acesso inválida.");
			RetornaJSONcode($dados);
			return;
		}
		$lista = $obj->BuscarOpcoesDeVagas();
		$dados['sucesso'] = true;
		$dados['lista'] = $lista;
		//XDebug($dados, $this);
		RetornaJSONcode($dados);
	}
	#######################################################################################################
	public function buscarcandidatoclientes()
	{
		$obj = GetModelo('avaliacao');
		$chave = Get("chave", false);
		$identificador = Get("identificador", false);
		if(!$obj->VerificarChave($chave, $identificador))
		{
			$dados['sucesso'] = false;
			$dados['erro'] = __("Chave de acesso inválida.");
			RetornaJSONcode($dados);
			return;
		}
		$lista = $obj->BuscarOpcoesDeClientes();
		$dados['sucesso'] = true;
		$dados['lista'] = $lista;
		//XDebug($dados, $this);
		RetornaJSONcode($dados);
	}
	#######################################################################################################
	public function teste()
	{
		$d = 233.17;
		P(GetFloat($d));
	}
	#######################################################################################################
	public function lercurriculoenviado()
	{
		$obj = GetLibrary('curriculoenviado');
		if(!$obj)
		{
			$dados['sucesso'] = false;
			$dados['erro'] = __("Erro na classe de contato.");
			RetornaJSON($dados, true);
			return;
		}
		$dados = $obj->LerCurriculoEnviado();
		//XDebug($dados, $this);
		RetornaJSON($dados, true);
	}
	#######################################################################################################
	public function marcarcontato()
	{
		$obj = GetModelo('candidatocontato');
		$dados = $obj->MarcarContato();
		//XDebug($dados, $this);
		RetornaJSON($dados, true);
		return;
	}
	#######################################################################################################
	public function lerlistacandidatocontato()
	{
		if(TemAcesso("Cliente"))
		{
			$dados['sucesso'] = true;
			$dados['lista'] = false;
			$dados['mensagem'] = "";
			$dados['titulo'] = "";
			$dados['idcliente'] = 0;		
			$dados['idvaga'] = 0;
			$dados['posicao'] = 0;
			$dados['limite'] = 0;
			$dados['total'] = 0;
			$dados['finalizado'] = true;
			RetornaJSONcode($dados);
			return;
		}
		else
		{
			$obj = GetModelo('candidatocontato');
			$dados = $obj->LerListaContatos();
			RetornaJSONcode($dados);
			return;
		}
	}
	#######################################################################################################
	public function lerlistaacaolinkedin()
	{
		if(TemAcesso("Cliente"))
		{
			$dados['sucesso'] = true;
			$dados['lista'] = false;
			$dados['mensagem'] = "";
			$dados['titulo'] = "";
			$dados['idcliente'] = 0;		
			$dados['idvaga'] = 0;
			$dados['posicao'] = 0;
			$dados['limite'] = 0;
			$dados['total'] = 0;
			$dados['finalizado'] = true;
			RetornaJSONcode($dados);
			return;
		}
		else
		{
			$obj = GetModelo('candidato');
			$dados = $obj->LerListaAcaoLinkedin();
			RetornaJSONcode($dados);
			return;
		}
	}
	#######################################################################################################
	public function buscarretornoinvitelkd()
	{
		$obj = GetModelo('candidato');
		$idcandidato = Get("idcandidato",0);
		if(empty($idcandidato))
		{
			$dados['sucesso'] = false;
			$dados['erro'] = __("Candidato não foi possível identificar");
			RetornaJSON($dados);
			return;
		}
		$sql = "SELECT idcandidato, retornoinvitelkd FROM candidato";
		if(!$obj->Load($idcandidato, $sql))
		{
			$dados['sucesso'] = false;
			$dados['erro'] = __("Não foi possível localizar o candidato.");
			RetornaJSON($dados);
			return;
		}

		$lista['idcandidato'] = intval($obj->idcandidato);
		if(empty($obj->retornoinvitelkd))
			$lista['retornoinvitelkd'] = "";
		else
			$lista['retornoinvitelkd'] = $obj->retornoinvitelkd;

		$dados['sucesso'] = true;
		$dados['obj'] = $lista;
		$dados['titulo'] = __("Sucesso");
		$dados['mensagem'] = __("Candidato foi localizado com sucesso.");
		//XDebug($dados, $this);
		RetornaJSON($dados);
	}
	#######################################################################################################
	public function salvarretornoinvitelkd()
	{
		$obj = GetModelo('candidato');
		$idcandidato = Get("idcandidato",0);
		if(empty($idcandidato))
		{
			$dados['sucesso'] = false;
			$dados['erro'] = __("Candidato não foi possível identificar");
			RetornaJSON($dados);
			return;
		}
		if(!$obj->Load($idcandidato))
		{
			$dados['sucesso'] = false;
			$dados['erro'] = __("Não foi possível localizar o candidato.");
			RetornaJSON($dados);
			return;
		}

		$obj->retornoinvitelkd = Get("retornoinvitelkd","");
		$obj->retornoinvitelkd = trim(strip_tags($obj->retornoinvitelkd));
		$obj->Ajustar(true);
		if(!$obj->Salvar())
		{
			$dados['sucesso'] = false;
			$dados['erro'] = __("Não foi possível salvar os dados do candidato.");
			RetornaJSON($dados);
			return;
		}
		$idvaga = Get("idvaga", 0);
		$idcliente = GetAcesso("idcliente");
		$registro = GetModelo("rastreio");
		$codigo = "SalvarRetornoInviteLKD";
		$registro->Registrar($idcliente, $codigo, $idvaga, $idcandidato);
		$dados['sucesso'] = true;
		$dados['titulo'] = __("Sucesso");
		$dados['mensagem'] = __("Os dados do candidato foram salvos com sucesso.");
		//XDebug($dados, $this);
		RetornaJSON($dados);
	}
	#######################################################################################################
	public function marcarlinkedindesatualizado()
	{
		$obj = GetModelo('candidato');
		$dados = $obj->MarcarLinkedinDesatualizado();//XDebug($dados, $this);

		$idcandidato = Get("idcandidato", "");
		$idvaga = Get("idvaga", 0);
		$desmarcar = Get("desmarcar", 0);
		$idcliente = GetAcesso("idcliente");
		$registro = GetModelo("rastreio");
		if(empty($desmarcar))
			$codigo = "MarcarLinkedinDesatualizado";
		else
			$codigo = "DesmarcarLinkedinDesatualizado";
		$registro->Registrar($idcliente, $codigo, $idvaga, $idcandidato);

		RetornaJSON($dados);
		return;
	}
	#######################################################################################################
	public function exportarcandidato()
	{
		$obj = GetModelo('candidato');
		if($obj)
		{
			$dados = $obj->ExportarCandidatoSite();
		}
		else
		{
			$dados['sucesso'] = false;
			$dados['erro'] = __("Erro ao carregar a classe do candidato.");
		}
		//XDebug($dados, $this);
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
	public function lercandidatoscomidiomas()
	{
		$obj = GetModelo('candidatoidioma');
		if(!$obj)
		{
			$dados['sucesso'] = false;
			$dados['erro'] = __("Erro na classe de candidato idioma.");
			RetornaJSON($dados, true);
			return;
		}
		$dados = $obj->LerCandidatosComIdiomas();
		//XDebug($dados, $this);
		RetornaJSON($dados, true);
	}
	#######################################################################################################
	public function exportarcandidatosidiomas()
	{
		$obj = GetModelo('candidatoidioma');
		if($obj)
		{
			$dados = $obj->ExportarCandidatoIdiomas();
		}
		else
		{
			$dados['sucesso'] = false;
			$dados['erro'] = __("Erro ao carregar a classe de candidato idioma.");
		}
		//XDebug($dados, $this);
		RetornaJSON($dados);
	}
	#######################################################################################################
	public function baixarcandidatosidiomas($file = "")
	{
		if(empty($file))
		{
			$data = array('act'=>__("Erro"),'titulo'=>__("Nome do arquivo não foi enviado ao sistema."));
			$this->gestao->GetView('layout/erro', $data );
			return;
		}
		
		$obj = GetModelo('candidatoidioma');
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
	public function marcarabordagem()
	{
		$obj = GetModelo('abordagem');
		if(!$obj)
		{
			$dados['sucesso'] = false;
			$dados['erro'] = __("Erro na classe de abordagem de candidato.");
			RetornaJSON($dados, true);
			return;
		}
		$dados = $obj->MarcarAbordagem();//XDebug($dados, $this);

		RetornaJSON($dados);
		return;
	}
}
?>