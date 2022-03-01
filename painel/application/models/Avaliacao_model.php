<?php
/***********************************************************************
 * Module:  /models/Avaliacao_model.PHP
 * Author:  Host-up
 * Date:	12/02/2021 00:48:57
 * Purpose: Definição da Classe Avaliacao_model
 * Instancias: $this->load->model('Avaliacao_model', 'avaliacao');
 * Objeto: $avaliacao = $this->avaliacao->GetInstancia($dados);
 ***********************************************************************/
if (!class_exists('Avaliacao_model'))
{
	class Avaliacao_model extends MY_Model
	{
		public static $_limite = 10;
		private static $_candidato = null;
		private static $_cliente = null;
		private static $_avaliacaomarcado = null;
		################################################################################################################
		public function __construct( $dados = false)
		{
			try
			{
				$this->Tabela = "avaliacao";
				$this->PrimaryKey = "idavaliacao";
				parent::__construct($dados);
			}
			catch( Exception $e )
			{
				throw new Exception( $e );
			}
		}
		################################################################################################################
		public static function &NewCandidato() {
			if (self::$_candidato == null)
				self::$_candidato = GetModelo("candidato");
			return self::$_candidato;
		}
		################################################################################################################
		public static function &NewCliente() {
			if (self::$_cliente == null)
				self::$_cliente = GetModelo("cliente");
			return self::$_cliente;
		}
		################################################################################################################
		public static function &NewAvaliacaoMarcado() {
			if (self::$_avaliacaomarcado == null)
				self::$_avaliacaomarcado = GetModelo("avaliacaomarcado");
			return self::$_avaliacaomarcado;
		}
		################################################################################################################
		public function Ajustar($salvar = false)
		{
			if($salvar)
			{
				if(empty($this->ip))
					$this->ip = GetIP();
				if(emptyData($this->cadastradoem))
					$this->cadastradoem = date("Y-m-d H:i:s");
				else
					$this->cadastradoem = date("Y-m-d H:i:s", TimeData($this->cadastradoem));
			}
			else
			{
				if(emptyData($this->cadastradoem))
					$this->cadastradoem = "";
				else
					$this->cadastradoem = date("d/m/Y H:i:s", TimeData($this->cadastradoem));
			}
		}		
		################################################################################################################
		public function GetLimite()
		{
			$retorno = 10;
			try
			{
				return self::$_limite;
			}
			catch( Exception $e )
			{
				throw new Exception( $e );
				return $retorno;
			}
		}
		################################################################################################################
		public function VerificarChave($chave = "", $identificador = "")
		{
			$retorno = false;
			try
			{
				if(empty($chave))
					return $retorno;
				if(empty($identificador))
					return $retorno;

				$CI=&get_instance();
				$CI->load->library('encryption');
				$chave = decryptCookie($chave);
				$aux = $CI->config->config['chave'];
				if(strcmp($aux, $chave) != 0)
					return $retorno;

				$aux = decryptCookie($identificador);
				if(stripos($aux, "|") === false)
					return $retorno;

				list($ident, $tempo) = explode("|", $aux);
				$tempo = intval($tempo);
				$aux = $CI->config->config['identificador'];
				if(strcmp($aux, $ident) != 0)
					return $retorno;

				$tempoDecorrido = intval(date("U")) - $tempo;
				$limite = (60 * 60 * 10);
				if($tempoDecorrido > $limite)
					return $retorno;

				return true;
			}
			catch( Exception $e )
			{
				throw new Exception( $e );
				return $retorno;
			}
		}
		################################################################################################################
		public function GerarOpcoesIdcliente($value = "0", $texto = "", $default = "0")
		{
			if(empty($texto))
				$texto = __("-- Selecione --");
			$primeiro = array("valor"=>$default,"texto"=>$texto);
			$sql = "SELECT idcliente AS 'id', cliente AS 'texto' FROM cliente ORDER BY texto ASC";
			return $this->GeraOpcoesSql($value, $sql, "id", "texto", $primeiro);
		}
		################################################################################################################
		public function GerarOpcoesInteressemercado($value = "", $texto = "", $default = "")
		{
			if(empty($texto))
				$texto = __("-- Selecione --");
			$primeiro = array("valor"=>$default,"texto"=>$texto);
			return $this->GeraOpcoesEnum($value, $this->Tabela, "interessemercado", $primeiro);
		}
		################################################################################################################
		public function GerarOpcoesTipodecontratacao($value = "", $texto = "", $default = "")
		{
			if(empty($texto))
				$texto = __("-- Selecione --");
			$primeiro = array("valor"=>$default,"texto"=>$texto);
			return $this->GeraOpcoesEnum($value, $this->Tabela, "tipodecontratacao", $primeiro);
		}
		################################################################################################################
		public function GetSqlLista()
		{
			$retorno = "";
			try
			{
				return "SELECT * FROM avaliacao ";
			}
			catch( Exception $e )
			{
				throw new Exception( $e );
				return $retorno;
			}
		}
		################################################################################################################
		public function GetSqlTotalLista()
		{
			$retorno = "";
			try
			{
				return "SELECT COUNT(*) AS CONT FROM avaliacao ";
			}
			catch( Exception $e )
			{
				throw new Exception( $e );
				return $retorno;
			}
		}
		#######################################################################################################
		public function Filtro($semOrder = false)
		{
			$filtro = "";
			$buscar = GetFiltro("buscar");
			if(!empty($buscar))
			{
				$filtro .= " AND buscar LIKE '%{$buscar}%'";
			}
			
			$idavaliacao = GetFiltro("idavaliacao");
			if(!empty($idavaliacao))
			{
				$filtro .= " AND idavaliacao = '{$idavaliacao}'";
			}
			$idcliente = GetFiltro("idcliente");
			if(!empty($idcliente))
			{
				$filtro .= " AND idcliente = '{$idcliente}'";
			}
			$idcandidato = GetFiltro("idcandidato");
			if(!empty($idcandidato))
			{
				$filtro .= " AND idcandidato = '{$idcandidato}'";
			}
			$interessemercado = GetFiltro("interessemercado");
			if(!empty($interessemercado))
			{
				$filtro .= " AND interessemercado = '{$interessemercado}'";
			}
			$salariofixomensal = GetFiltro("salariofixomensal");
			if(!empty($salariofixomensal))
			{
				$filtro .= " AND salariofixomensal = '{$salariofixomensal}'";
			}
			$bonusrealizadoanual = GetFiltro("bonusrealizadoanual");
			if(!empty($bonusrealizadoanual))
			{
				$filtro .= " AND bonusrealizadoanual = '{$bonusrealizadoanual}'";
			}
			$tipodecontratacao = GetFiltro("tipodecontratacao");
			if(!empty($tipodecontratacao))
			{
				$filtro .= " AND tipodecontratacao = '{$tipodecontratacao}'";
			}
			$observacao = GetFiltro("observacao");
			if(!empty($observacao))
			{
				$filtro .= " AND observacao = '{$observacao}'";
			}
			$ip = GetFiltro("ip");
			if(!empty($ip))
			{
				$filtro .= " AND ip = '{$ip}'";
			}
			$cadastradoem = GetFiltro("cadastradoem");
			if(!empty($cadastradoem))
			{
				$filtro .= " AND cadastradoem = '{$cadastradoem}'";
			}
			if(!empty($filtro))
			{
				$filtro  = substr($filtro, 4);
			}
			if($semOrder)
			{
				return $filtro;
			}
			$ordem = array('idavaliacao', 'idcliente', 'idcandidato', 'interessemercado', 'salariofixomensal', 'bonusrealizadoanual', 'tipodecontratacao', 'observacao', 'ip', 'cadastradoem', 'idavaliacao');
			$start = Get("start", 0);
			$length = Get("length", 10);
			$order = Get("order", 0,0);
			if(!empty($order['column']))
				$coluna = $order['column'];
			else
				$coluna = 0;
			if(!empty($order['dir']))
				$dir = $order['dir'];
			else
				$dir = 'asc';
			if(!empty($ordem[$coluna]))
			{
				$order = $ordem[$coluna];
				$filtro .= " ORDER BY {$order} {$dir}";
			}
			if($length >= 0)
			{
				$filtro .= " LIMIT {$start}, {$length}";
			}
			return $filtro;
		}
		################################################################################################################
		public function Importar($posicao = 0, $limite = 0, $file = "")
		{
			$retorno = false;
			
			if(empty($file))
				return $retorno;
			
			$lista = $this->LerRows($posicao, $limite, $file);
			if(empty($lista))
				return $retorno;
			$obj = GetModelo("avaliacao");
			if(empty($obj))
				return $retorno;
			foreach ($lista as $key=>$linha)
			{
				$obj->SalvarListaAvaliacao($linha);
			}
			return true;
		}
		################################################################################################################
		public function SalvarListaAvaliacao($dados = false, $idcandidato = 0)
		{
			if(empty($dados))
				return;
			if(empty($idcandidato))
			{
				$icandidato = self::NewCandidato();
				$idcandidato = $icandidato->LerIdCandidato($dados);
			}
			if(empty($idcandidato))
				return;
			$avaliador = self::GetDadosChave($dados, array('avaliador','Avaliador','AVALIADOR'));
			if(empty($avaliador))
				return;
			$icliente = self::NewCliente();
			$idcliente = $icliente->LerIdCliente($avaliador);
			if(empty($avaliador))
				return;
			$filtro = "idcandidato = '{$idcandidato}'";
			$obj = $this->FiltroObjeto($filtro);
			$novo = false;
			if(empty($obj))
			{
				$obj = $this->GetInstancia();
				$obj->idcandidato = $idcandidato;
				$novo = true;
			}

			$interessemercado = self::GetDadosChave($dados, array('interessemercado','Interessemercado','INTERESSEMERCADO', 'interesse no mercado','Interesse no mercado','INTERESSE NO MERCADO'));
			if(!empty($interessemercado))
				$obj->interessemercado = $interessemercado;
				
			$salariofixomensal = self::GetDadosChave($dados, array('salariofixomensal','Salariofixomensal','SALARIOFIXOMENSAL', 'salario fixo mensal','Salario fixo mensal','SALARIO FIXO MENSAL'));
			if(!empty($salariofixomensal))
				$obj->salariofixomensal = $salariofixomensal;

			$bonusrealizadoanual = self::GetDadosChave($dados, array('bonusrealizadoanual','Bonusrealizadoanual','BONUSREALIZADOANUAL', 'bonus realizado anual','Bonus realizado anual','BONUS REALIZADO ANUAL'));
			if(!empty($bonusrealizadoanual))
				$obj->bonusrealizadoanual = $bonusrealizadoanual;
			
			$tipodecontratacao = self::GetDadosChave($dados, array('tipodecontratacao','Tipodecontratacao','TIPODECONTRATACAO', 'tipo de contratacao','Tipo de contratacao','TIPO DE CONTRATACAO', 'tipo de contratação','Tipo de contratação','TIPO DE CONTRATAÇÃO'));
			if(!empty($tipodecontratacao))
				$obj->tipodecontratacao = $tipodecontratacao;
			
			$linkedindesatualizado = self::GetDadosChave($dados, array('linkedindesatualizado','Linkedindesatualizado','LINKEDINDESATUALIZADO', 'linkedin desatualizado','Linkedin desatualizado','LINKEDIN DESATUALIZADO'));
			if(!empty($linkedindesatualizado))
				$obj->linkedindesatualizado = $linkedindesatualizado;
			
			$finalista = self::GetDadosChave($dados, array('avaliacaofinalista', 'Avaliacaofinalista', 'AVALIACAOFINALISTA', 'avaliacao finalista','Avaliacao finalista', 'AVALIACAO FINALISTA', 'finalista','Finalista','FINALISTA', ));
			if(!empty($finalista))
				$obj->finalista = $finalista;
			
			$placement = self::GetDadosChave($dados, array('avaliacaoplacement', 'Avaliacaoplacement', 'AVALIACAOPLACEMENT', 'avaliacao placement','Avaliacao placement', 'AVALIACAO PLACEMENT', 'placement','Placement','PLACEMENT', ));
			if(!empty($placement))
				$obj->placement = $placement;
	
			$inglesdeclarado = self::GetDadosChave($dados, array('inglesdeclarado','Inglesdeclarado','INGLESDECLARADO', 'ingles declarado','Ingles declarado','INGLES DECLARADO'));
			if(!empty($inglesdeclarado))
				$obj->inglesdeclarado = $inglesdeclarado;
	
			$situacaotelefone = self::GetDadosChave($dados, array('situacaotelefone','Situacaotelefone','SITUACAOTELEFONE', 'situacao telefone','Situacao telefone','SITUACAO TELEFONE'));
			if(!empty($situacaotelefone))
				$obj->situacaotelefone = $situacaotelefone;

			$preferenciamobilidade = self::GetDadosChave($dados, array('preferenciamobilidade','Preferenciamobilidade','PREFERENCIAMOBILIDADE', 'preferencia mobilidade','Preferencia mobilidade','PREFERENCIA MOBILIDADE'));
			if(!empty($preferenciamobilidade))
				$obj->preferenciamobilidade = $preferenciamobilidade;			

			$motivacaoparamudanca = self::GetDadosChave($dados, array('motivacaoparamudanca','Motivacaoparamudanca','MOTIVACAOPARAMUDANCA', 'motivacao para mudanca','Motivacao para mudanca','MOTIVACAO PARA MUDANCA', 'motivação para mudança','Motivação para mudança','MOTIVAÇÃO PARA MUDANÇA'));
			if(!empty($motivacaoparamudanca))
				$obj->motivacaoparamudanca = $motivacaoparamudanca;

			$observacao = self::GetDadosChave($dados, array('observacao','Observacao','OBSERVACAO', 'observação','Observação','OBSERVAÇÃO'));
			if(!empty($observacao))
				$obj->observacao = $observacao;

			$avaliadoem = self::GetDadosChave($dados, array('avaliadoem','Avaliadoem','AVALIADOEM', 'avaliado em','Avaliado em','AVALIADO EM'));
			if(!empty($avaliadoem))
				$obj->avaliadoem = date("Y-m-d H:i:s", TimeData($avaliadoem));
	

			$obj->Ajustar(true);
			$idavaliacao = $obj->Salvar();
			if($novo)
			{
				$obj->idavaliacao = $idavaliacao;
			}
			$marcado = self::NewAvaliacaoMarcado();
			$marcado->SalvarListaMarcados($dados, $obj->idavaliacao, $obj->idcandidato);
			return;
		}
		################################################################################################################
		public function ExportarAvaliacao()
		{
			$posicao = Get("posicao", 0);
			$total = Get("total", 0);
			$file = Get("file");
			$limite = 500;
			$obj = GetModelo('avaliacao');
			
			if(empty($total))
			{
				$sqlTotal = $obj->GetSqlTotalLista();
				$filtro = $obj->Filtro(true);
				$total = $obj->TotalRegistro($filtro, $sqlTotal, false);
				if(empty($total))
				{
					$dados['sucesso'] = false;
					$dados['erro'] = __("Nenhum avaliacao foi encontrado no momento.");
				}
				else
				{
					$dados['sucesso'] = true;
					$dados['titulo'] = __("Processando Exportação");
					$dados['mensagem'] = __("Exportação de avaliacao está processando.");
					$dados['url'] = "";
					$dados['finalizado'] = false;
					$dados['file'] = $file;
					$dados['posicao'] = $posicao;
					$dados['total'] = $total;
				}
				return $dados;
			}
			$sql = $obj->GetSqlLista();
			$filtro = $obj->Filtro(true);
			$filtro .= " ORDER BY avaliacao ASC";
			$filtro .= " LIMIT {$posicao},{$limite}";
			$objs = $obj->FiltroObjetos($filtro, $sql);
			if($objs)
			{
				if(empty($file))
					$file = $obj->GetNomeFile();
				$data = array(
					"file"=> $file,
					"lista"=>$objs,
					"posicao"=>$posicao,
					"total"=>$total,
					"html"=>false,
					"campos"=>$obj->GetNomesCampos(),
					"download"=>false,
					"maiusculo"=>false,
					"pasta"=>$obj->GetCaminho()
				);
				Excel($data);
				$posicao += $limite;
				$dados['sucesso'] = true;
				if($posicao >= $total)
				{
					$dados['titulo'] = __("Exportação de avaliacao");
					$dados['mensagem'] = __("Exportação de avaliacao foi finalizada.<br/>O download se iniciará em instantes");
					$dados['url'] = site_url("avaliacao/baixaravaliacao/{$file}");
					$dados['finalizado'] = true;
					$dados['file'] = $file;
					$dados['posicao'] = $posicao;
					$dados['total'] = $total;
				}
				else
				{
					$dados['titulo'] = __("Exportação de avaliacao");
					$dados['mensagem'] = __("Exportação de avaliacao está processando.");
					$dados['url'] = "";
					$dados['finalizado'] = false;
					$dados['file'] = $file;
					$dados['posicao'] = $posicao;
					$dados['total'] = $total;
				}
			}
			else
			{
				$dados['sucesso'] = false;
				$dados['erro'] = __("Nenhum avaliacao foi encontrado.");
			}
			//XDebug($dados, $this);
			return $dados;
		}
		################################################################################################################
		public function GetNomeFile()
		{
			$retorno = "exportacaoavaliacao_".date("Y-m-d_H-i-s").".xls";
			try
			{
				return $retorno;
			}
			catch( Exception $e )
			{
				throw new Exception( $e );
				return $retorno;
			}
		}
		################################################################################################################
		public function GetNomesCampos()
		{
			$campos = array(
				"ID" => "idcandidato",
				"nome" => "nome",
				"Email" => "email",
				"LKD_Tipo" => "tipo"
			);
			$vaga = GetModelo("vaga");
			$campos["avaliador"] = "avaliador";
			$campos["interessemercado"] = "interessemercado";
			$campos["salariofixomensal"] = "salariofixomensal";
			$campos["bonusrealizadoanual"] = "bonusrealizadoanual";
			$campos["tipodecontratacao"] = "tipodecontratacao";
			$campos["situacaotelefone"] = "situacaotelefone";
			$campos["preferenciamobilidade"] = "preferenciamobilidade";
			$campos["avaliacaofinalista"] = "finalista";
			$campos["avaliacaoplacement"] = "placement";
			$lista = $vaga->ListaCamposAvaliacao();
			if(!empty($lista))
			{
				foreach ($lista as $row)
				{
					$key = AcertaNomeArquivo($row["campo"]);
					$campos[$key] = $row["valor"];
				}
			}
			$campos["motivacaoparamudanca"] = "motivacaoparamudanca";
			$campos["observacao"] = "observacao";
			$campos["ip"] = "ip";
			$campos["avaliadoem"] = "cadastradoem";
			return $campos;
		}
		################################################################################################################
		public function GetCaminho($file = "")
		{
			return $this->SetDominio($file);
		}
		################################################################################################################
		public function LerListaAvaliados()
		{
			$idcliente = Get("idcliente", 0);
			$idvaga = Get("idvaga", 0);
			$posicao = Get("posicao", 0);
			$limite = Get("limite", 10);
			$total = Get("total", 0);

			$rows = false;
			$titulo = __("Erro");
			$mensagem = __("Nenhuma avaliação foi encontrada.");

			$filtro = "";
			if(!empty($idcliente))
			{
				if(!E_Cliente($idcliente))
				{
					$dados['sucesso'] = false;
					$dados['erro'] = __("ID do cliente não foi enviado.");
					return $dados;
				}
				$filtro .= " 1 ";
				//$filtro .= " V.idcliente = '{$idcliente}' ";
			}
			else
			{
				$dados['sucesso'] = false;
				$dados['erro'] = __("ID do cliente não foi enviado.");
				return $dados;
			}
			if(!empty($idvaga))
			{
				if(!is_array($idvaga))
					$idvaga = array($idvaga);
				$filtro .= " AND (F.idfavorito IS NULL OR F.tipo = 'Favorito') AND CV.idvaga ".GerarIN($idvaga);
			}
			$acesso = GetAcesso("acesso");
			if($acesso != "Cliente")
			{
				if(empty($total))
				{
					$total = 9;
				}
				if(!empty($total))
				{
					if($limite < 0)
						$limite = $total;
					$sql = "SELECT COUNT(DISTINCT CV.idcandidato) AS CONT FROM candidatovaga CV USE INDEX(idxcandidato, idxvaga) INNER JOIN vaga V ON(CV.idvaga = V.idvaga) LEFT JOIN favorito F FORCE INDEX(idxcandidato) ON(CV.idcandidato = F.idcandidato AND F.idvaga = V.idvaga) LEFT JOIN avaliacao A USE INDEX(idxcandidato) ON(A.idcandidato = CV.idcandidato) WHERE {$filtro} AND A.idavaliacao IS NOT NULL";
					$totalAvaliados = $this->TotalRegistro(false, $sql,false);
					
					$sql = "SELECT COUNT(DISTINCT CV.idcandidato) AS CONT FROM candidatovaga CV USE INDEX(idxcandidato, idxvaga) INNER JOIN vaga V ON(CV.idvaga = V.idvaga) LEFT JOIN favorito F FORCE INDEX(idxcandidato) ON(CV.idcandidato = F.idcandidato AND F.idvaga = V.idvaga) LEFT JOIN avaliacao A USE INDEX(idxcandidato) ON(A.idcandidato = CV.idcandidato) WHERE {$filtro} AND A.interessemercado IN('Sim (estou buscando)','Depende (até considero avaliar)')";
					$totalAvaliadosCominteresse = $this->TotalRegistro(false, $sql,false);
					
					$sql = "SELECT COUNT(DISTINCT CV.idcandidato) AS CONT FROM candidatovaga CV USE INDEX(idxcandidato, idxvaga) INNER JOIN vaga V ON(CV.idvaga = V.idvaga) LEFT JOIN favorito F FORCE INDEX(idxcandidato) ON(CV.idcandidato = F.idcandidato AND F.idvaga = V.idvaga) LEFT JOIN avaliacao A USE INDEX(idxcandidato) ON(A.idcandidato = CV.idcandidato) WHERE {$filtro} AND A.interessemercado = 'Sem interesse'";
					$totalAvaliadosSeminteresse = $this->TotalRegistro(false, $sql,false);

					$sql = "SELECT COUNT(DISTINCT CV.idcandidato) AS CONT FROM candidatovaga CV USE INDEX(idxcandidato, idxvaga) INNER JOIN vaga V ON(CV.idvaga = V.idvaga) LEFT JOIN favorito F FORCE INDEX(idxcandidato) ON(CV.idcandidato = F.idcandidato AND F.idvaga = V.idvaga) LEFT JOIN avaliacao A USE INDEX(idxcandidato) ON(A.idcandidato = CV.idcandidato) WHERE {$filtro} AND A.perfiltecnicocomportamental = 'Sim'";
					$totalAvaliadosComperfil = $this->TotalRegistro(false, $sql,false);
					
					$sql = "SELECT COUNT(DISTINCT CV.idcandidato) AS CONT FROM candidatovaga CV USE INDEX(idxcandidato, idxvaga) INNER JOIN vaga V ON(CV.idvaga = V.idvaga) LEFT JOIN favorito F FORCE INDEX(idxcandidato) ON(CV.idcandidato = F.idcandidato AND F.idvaga = V.idvaga) LEFT JOIN avaliacao A USE INDEX(idxcandidato) ON(A.idcandidato = CV.idcandidato) WHERE {$filtro} AND A.perfiltecnicocomportamental = 'Não'";
					$totalAvaliadosSemperfil = $this->TotalRegistro(false, $sql,false);

					$sql = "SELECT COUNT(DISTINCT CV.idcandidato) AS CONT FROM candidatovaga CV USE INDEX(idxcandidato, idxvaga) INNER JOIN vaga V ON(CV.idvaga = V.idvaga) LEFT JOIN favorito F FORCE INDEX(idxcandidato) ON(CV.idcandidato = F.idcandidato AND F.idvaga = V.idvaga) LEFT JOIN avaliacao A USE INDEX(idxcandidato) ON(A.idcandidato = CV.idcandidato) WHERE {$filtro} AND A.finalista = 'Sim'";
					$totalAvaliadosFinalista = $this->TotalRegistro(false, $sql,false);

					$sql = "SELECT COUNT(DISTINCT CV.idcandidato) AS CONT FROM candidatovaga CV USE INDEX(idxcandidato, idxvaga) INNER JOIN vaga V ON(CV.idvaga = V.idvaga) LEFT JOIN favorito F FORCE INDEX(idxcandidato) ON(CV.idcandidato = F.idcandidato AND F.idvaga = V.idvaga) LEFT JOIN avaliacao A USE INDEX(idxcandidato) ON(A.idcandidato = CV.idcandidato) WHERE {$filtro} AND A.placement = 'Sim'";
					$totalAvaliadosPlacement = $this->TotalRegistro(false, $sql,false);
					
					$sql = "SELECT COUNT(DISTINCT CV.idcandidato) AS CONT FROM candidatovaga CV USE INDEX(idxcandidato, idxvaga) INNER JOIN vaga V ON(CV.idvaga = V.idvaga) LEFT JOIN favorito F FORCE INDEX(idxcandidato) ON(CV.idcandidato = F.idcandidato AND F.idvaga = V.idvaga) LEFT JOIN avaliacao A USE INDEX(idxcandidato) ON(A.idcandidato = CV.idcandidato) WHERE {$filtro} AND A.situacaotelefone = 'Telefone inexistente/incompleto'";
					$totalAvaliadosTelefoneinexistente = $this->TotalRegistro(false, $sql,false);

					$sql = "SELECT COUNT(DISTINCT CV.idcandidato) AS CONT FROM candidatovaga CV USE INDEX(idxcandidato, idxvaga) INNER JOIN vaga V ON(CV.idvaga = V.idvaga) LEFT JOIN favorito F FORCE INDEX(idxcandidato) ON(CV.idcandidato = F.idcandidato AND F.idvaga = V.idvaga) LEFT JOIN avaliacao A USE INDEX(idxcandidato) ON(A.idcandidato = CV.idcandidato) WHERE {$filtro} AND A.idavaliacao IS NULL";
					$totalNaoAvaliados = $this->TotalRegistro(false, $sql,false);

					$rows = [
						["avaliados"=>"Sim","texto"=>"Candidatos avaliados","total"=>$totalAvaliados],
						["avaliados"=>"Cominteresse","texto"=>"Candidatos com interesse","total"=>$totalAvaliadosCominteresse],
						["avaliados"=>"Seminteresse","texto"=>"Candidatos sem interesse","total"=>$totalAvaliadosSeminteresse],
						["avaliados"=>"Comperfil","texto"=>"Com perfil técnico comportamental","total"=>$totalAvaliadosComperfil],
						["avaliados"=>"Semperfil","texto"=>"Sem perfil técnico comportamental","total"=>$totalAvaliadosSemperfil],
						["avaliados"=>"Telefoneinexistente","texto"=>"Telefone inexistente/incompleto","total"=>$totalAvaliadosTelefoneinexistente],
						["avaliados"=>"Finalista","texto"=>"Candidadtos finalistas","total"=>$totalAvaliadosFinalista],
						["avaliados"=>"Placement","texto"=>"Candidadtos placement","total"=>$totalAvaliadosPlacement],
						["avaliados"=>"Não","texto"=>"Candidatos não avaliados","total"=>$totalNaoAvaliados]
					];
					if(!empty($rows))
					{
						$rows = array_map(array($this,'Map'), $rows);
						$titulo = __("Sucesso");
						$mensagem = __("Lista de candidatos avaliados foi encontrada com sucesso.");
					}
				}
			}
			else
			{
				$total = 0;
				$rows = false;
				$titulo = __("Sucesso");
				$mensagem = __("Lista de candidatos avaliados foi encontrada com sucesso.");
			}
			$novaposicao = $posicao + $limite;
			if($novaposicao >= $total)
				$finalizado = true;
			else
				$finalizado = false;
			$dados['sucesso'] = true;
			$dados['lista'] = $rows;
			$dados['mensagem'] = $mensagem;
			$dados['titulo'] = $titulo;
			$dados['idcliente'] = intval($idcliente);
			if(empty($idvaga))
				$dados['idvaga'] = null;
			else
				$dados['idvaga'] = $idvaga;
			$dados['posicao'] = $novaposicao;
			$dados['limite'] = intval($limite);
			$dados['total'] = intval($total);
			$dados['finalizado'] = $finalizado;
			return $dados;
		}
		################################################################################################################
		public static function Map($row = false)
		{
			$row['total'] = intval($row['total']);
			return $row;
		}
		################################################################################################################
		public function GetDadosDeAvaliacao(&$dados)
		{
			$idcandidato = $dados["idcandidato"];

			$filtro = "";
			if(empty($idcandidato))
			{
				return;
			}
			$filtro = "idcandidato = '{$idcandidato}'";
			if(!$this->Load($filtro))
			{
				return;
			}
			$lista = $this->GetDados();
			$dados['cliente'] = $this->GetCliente($this->idcliente);
			if(!empty($lista))
			{
				$lista['motivacaoparamudanca'] = str_replace(array("\t","\r\n","\n"),"",$lista['motivacaoparamudanca']);
				$lista['observacao'] = str_replace(array("\t","\r\n","\n"),"",$lista['observacao']);
				foreach ($lista as $key=>$valor)
				{
					$dados[$key] = $valor;
				}
			}
			$rows = self::GetMarcados($this->idavaliacao);
			if(!empty($rows))
			{
				foreach ($rows as $row)
				{
					$key = $row['campo'];
					$dados[$key] = $row['valor'];
				}
			}
			return;
		}
		################################################################################################################
		public static function GetMarcados($idavaliacao = 0)
		{
			if(empty($idavaliacao))
				return false;
			$sql = "SELECT CONCAT('marcado',AM.idavaliacaocompetencia) AS 'campo', AM.marcado AS valor FROM avaliacaomarcado AM  WHERE AM.idavaliacao = '{$idavaliacao}' ORDER BY AM.idavaliacaocompetencia ASC";
			$rows = self::GetSqlrows($sql, false);
			return $rows;
		}		
		################################################################################################################
		public function GetCliente($idcliente = 0)
		{
			if(empty($idcliente))
				return "";

			$sql = "SELECT IF(empresa = '', nome, CONCAT(nome,' (',empresa,')')) AS 'nome' FROM cliente WHERE idcliente = '{$idcliente}' ORDER BY nome ASC";
			$defult = "Não identificado";
			$campo = "avaliacao_cliente_".$idcliente;
			$cliente = $this->LerCacheSQlCampo($campo, $sql, "nome", 500, $defult);
			return $cliente;
		}		
		################################################################################################################
		public function GetTotalAvaliacaoEnviado()
		{
			$retorno = 0;
			try
			{
				$filtro = $this->ExportarFiltro(true, false);
				$sql = "SELECT COUNT(DISTINCT C.idcandidato) AS CONT FROM candidato C LEFT JOIN candidatovaga CV FORCE INDEX(idxcandidato, idxvaga) ON(C.idcandidato = CV.idcandidato) LEFT JOIN avaliacao AV FORCE INDEX(idxcandidato) ON(C.idcandidato = AV.idcandidato) LEFT JOIN cliente CT ON(AV.idcliente = CT.idcliente) LEFT JOIN vaga V ON(V.idvaga = CV.idvaga) {$filtro}";
				return $this->TotalRegistro(false, $sql);
			}
			catch( Exception $e )
			{
				throw new Exception( $e );
				return $retorno;
			}
		}
		################################################################################################################
		public function &GetAvaliacaoEnviado()
		{
			$retorno = 0;
			try
			{
				$filtro = $this->ExportarFiltro(false, false);
				$sql = "SELECT DISTINCT C.idcandidato, C.nome, C.email, C.tipo, AV.*, CT.nome AS avaliador FROM candidato C LEFT JOIN candidatovaga CV FORCE INDEX(idxcandidato, idxvaga) ON(C.idcandidato = CV.idcandidato) LEFT JOIN avaliacao AV FORCE INDEX(idxcandidato) ON(C.idcandidato = AV.idcandidato) LEFT JOIN cliente CT ON(AV.idcliente = CT.idcliente) LEFT JOIN vaga V ON(V.idvaga = CV.idvaga) {$filtro}";
				$rows = $this->GetRows(false, $sql);
				$lista = false;
				if(is_array($rows))
				{
					$campos = $this->GetNomesCampos();
					foreach($rows as $key=>$row)
					{
						$linhas = self::GetMarcados($row['idavaliacao']);
						if(!empty($linhas))
						{
							foreach ($linhas as $linha)
							{
								$chave = $linha['campo'];
								$row[$chave] = $linha['valor'];
							}
						}
						foreach($campos as $label=>$campo)
						{
							if(!isset($row[$campo]))
								continue;
							$valor = $row[$campo];
							
							if(!empty($valor))
								$lista[$key][$label] = $valor;
						}
					}
				}
				return $lista;
			}
			catch( Exception $e )
			{
				throw new Exception( $e );
				return $retorno;
			}
		}
		#######################################################################################################
		public function ExportarFiltro($semOrder = false, $comcidade = true)
		{
			$filtro = "";
			$buscar = Get("buscar");
			if(!empty($buscar))
			{
				if($comcidade)
					$filtro .= " AND (C.nome LIKE '%{$buscar}%' OR C.email LIKE '%{$buscar}%' OR CD.cidade LIKE '%{$buscar}%')";
				else
					$filtro .= " AND (C.nome LIKE '%{$buscar}%' OR C.email LIKE '%{$buscar}%'";
			}
			
			$interessemercado = Get("interessemercado");
			if(!empty($interessemercado))
			{
				$filtro .= " AND AV.interessemercado = '{$interessemercado}'";
			}
			$idcliente = Get("idcliente");
			if(!empty($idcliente))
			{				
				$filtro .= " AND V.idcliente ".GerarIN($idcliente);
			}
			$idvaga = Get("idvaga");
			if(!empty($idvaga))
			{				
				$filtro .= " AND V.idvaga ".GerarIN($idvaga);
			}
			$cadastradoeminicio = Get("cadastradoeminicio");
			if(!emptyData($cadastradoeminicio))
			{
				$cadastradoeminicio = date("Y-m-d 00:00:00", TimeData($cadastradoeminicio));
				$filtro .= " AND AV.cadastradoem >= '{$cadastradoeminicio}'";
			}
			$cadastradoemfim = Get("cadastradoemfim");
			if(!emptyData($cadastradoemfim))
			{
				$cadastradoemfim = date("Y-m-d 23:59:59", TimeData($cadastradoemfim));
				$filtro .= " AND AV.cadastradoem <= '{$cadastradoemfim}'";
			}
			
			$filtro .= " AND AV.idavaliacao IS NOT NULL";
			if(!empty($filtro))
			{
				$filtro  = " WHERE " . substr($filtro, 4);
			}
			if($semOrder)
			{
				return $filtro;
			}
			$ordem = array('C.idcandidato');
			$posicao = Get("posicao", 0);
			$limite = Get("limite", self::$_limite);
			$coluna = 0;
			$dir = 'asc';

			if($comcidade)
				$filtro .= " GROUP BY C.idcandidato ";

			if(!empty($ordem[$coluna]))
			{
				$order = $ordem[$coluna];
				$filtro .= " ORDER BY {$order} {$dir}";
			}
			if($limite >= 0)
			{
				$filtro .= " LIMIT {$posicao}, {$limite}";
			}
			return $filtro;
		}		
		################################################################################################################
		public function &BuscarOpcoesDeInteressemercado()
		{
			$retorno = false;
			try
			{
				$busca = Get('search');
				$lista = $this->ArrayEnum($this->Tabela, "interessemercado", false , true);
				$rows = false;
				if(!empty($lista))
				{
					foreach($lista as $key=>$valor)
					{
						if(!empty($busca))
						{
							if(stripos($valor, $busca) !== false)
								$rows[] = array("id"=>$key,"text"=>$valor);
						}
						else
							$rows[] = array("id"=>$key,"text"=>$valor);
					}
				}
				
				return $rows;
			}
			catch( Exception $e )
			{
				throw new Exception( $e );
				return $retorno;
			}
		}
		################################################################################################################
		public function &BuscarOpcoesDeVagas()
		{
			$retorno = false;
			try
			{
				$busca = Get('search');
				if(!empty($busca))
					$filtro = " WHERE V.empresacontratante LIKE '{$busca}%' OR V.titulodavaga LIKE '%{$busca}%' OR V.descricaodavaga LIKE '%{$busca}%'";
				else
					$filtro = "";
				$sql = "SELECT V.idvaga AS id, IF(V.empresacontratante = '', TRIM(V.titulodavaga), IF(V.titulodavaga = '',TRIM(V.empresacontratante), TRIM(CONCAT(V.titulodavaga,' (',V.empresacontratante,')')))) AS 'text' FROM vaga V {$filtro} ORDER BY text ASC";
				$lista =  $this->GetRows(false, $sql);
				if(empty($lista))
					return $retorno;
				
				return $lista;
			}
			catch( Exception $e )
			{
				throw new Exception( $e );
				return $retorno;
			}
		}
		################################################################################################################
		public function &BuscarOpcoesDeClientes()
		{
			$retorno = false;
			try
			{
				$busca = Get('search');
				if(!empty($busca))
					$filtro = " WHERE C.nome LIKE '{$busca}%' OR C.empresa LIKE '%{$busca}%' OR C.email LIKE '%{$busca}%'";
				else
					$filtro = "";
				$sql = "SELECT C.idcliente AS id, IF(C.empresa = '', TRIM(C.nome), TRIM(CONCAT(C.nome, ' (', C.empresa, ')'))) AS 'text' FROM cliente C {$filtro} ORDER BY text ASC";
				$lista =  $this->GetRows(false, $sql);
				if(empty($lista))
					return $retorno;
				
				return $lista;
			}
			catch( Exception $e )
			{
				throw new Exception( $e );
				return $retorno;
			}
		}
		#######################################################################################################################
		function Apagar() {
			$id = $this->GetID();
			$obj = GetModelo("avaliacaomarcado");
			$obj->ApagarLista("idavaliacao = '{$id}'");

			return $this->Excluir($id);
		}
		################################################################################################################
		public function __destruct()
		{
			unset($this->dados, $this->Tabela, $this->PrimaryKey);
		}
	}
}
?>