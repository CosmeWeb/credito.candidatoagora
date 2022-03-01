<?php
/***********************************************************************
 * Module:  /models/Rastreio_model.PHP
 * Author:  Host-up
 * Date:	03/09/2020 00:23:32
 * Purpose: Definição da Classe Rastreio_model
 * Instancias: $this->load->model('Rastreio_model', 'rastreio');
 * Objeto: $rastreio = $this->rastreio->GetInstancia($dados);
 ***********************************************************************/
if (!class_exists('Rastreio_model'))
{
	class Rastreio_model extends MY_Model
	{
		################################################################################################################
		public function __construct( $dados = false)
		{
			try
			{
				$this->Tabela = "rastreio";
				$this->PrimaryKey = "idrastreio";
				parent::__construct($dados);
			}
			catch( Exception $e )
			{
				throw new Exception( $e );
			}
		}
		################################################################################################################
		public function Ajustar($salvar = false)
		{
			if($salvar)
			{
				if(emptyData($this->cadastradoem))
					$this->cadastradoem = date("Y-m-d H:i:s");
				else
					$this->cadastradoem = date("Y-m-d H:i:s", TimeData($this->cadastradoem));
				if(empty($this->ip))
					$this->ip = GetIP();
				
				if(empty($this->idcliente))
					$this->idcliente = GetAcesso("idcliente");
				if(empty($this->descricao))
					$this->descricao = $this->GetDescricaoCodigo($this->codigo);
				if(empty($this->sessao))
					$this->sessao = $this->GetSession();
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
		public function GerarOpcoesEmpresas($value = "", $texto = "", $default = "0")
		{
			if(empty($texto))
				$texto = __("-- Selecione --");
			$primeiro = array("valor"=>$default,"texto"=>$texto);
			$sql = "SELECT DISTINCT empresa AS 'texto' FROM cliente WHERE empresa != '' ORDER BY texto ASC";
			return $this->GeraOpcoesSql($value, $sql, "texto", "texto", $primeiro);
		}
		################################################################################################################
		public function GerarOpcoesClientes($value = "0", $texto = "", $default = "0")
		{
			if(empty($texto))
				$texto = __("-- Selecione --");
			$primeiro = array("valor"=>$default,"texto"=>$texto);
			$sql = "SELECT idcliente AS 'id', CONCAT(nome,' (',empresa,')') AS 'texto' FROM cliente ORDER BY texto ASC";
			return $this->GeraOpcoesSql($value, $sql, "id", "texto", $primeiro);
		}
		################################################################################################################
		public function GetSqlLista()
		{
			$retorno = "";
			try
			{
				return "SELECT R.*, C.nome AS cliente, C.empresa, V.titulodavaga, V.empresacontratante, CD.nome AS 'candidato' FROM rastreio R LEFT JOIN cliente C ON(R.idcliente = C.idcliente) LEFT JOIN vaga V ON(R.idvaga = V.idvaga) LEFT JOIN candidato CD ON(CD.idcandidato = R.idcandidato)";
			}
			catch( Exception $e )
			{
				throw new Exception( $e );
				return $retorno;
			}
		}
		################################################################################################################
		public function GetSqlListaPorCliente($filtro = "", $posicao = 0, $limite = 50)
		{
			$retorno = "";
			try
			{
				if(empty($filtro))
					$filtro .= "ISNULL(NULLIF(C.nome,'')) = 0";
				else
					$filtro .= " AND ISNULL(NULLIF(C.nome,'')) = 0";
				return "SELECT C.nome AS cliente, C.empresa, R.idcliente, DATE_FORMAT(R.cadastradoem, '%Y-%m-%d') AS 'dia', MIN(R.cadastradoem) AS 'inicio', MAX(R.cadastradoem) AS 'fim'  FROM rastreio R LEFT JOIN cliente C ON(R.idcliente = C.idcliente) LEFT JOIN vaga V ON(R.idvaga = V.idvaga) LEFT JOIN candidato CD ON(CD.idcandidato = R.idcandidato) WHERE {$filtro} GROUP BY C.nome, dia ORDER BY C.nome ASC LIMIT {$posicao}, {$limite}";
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
				return "SELECT COUNT(DISTINCT R.idrastreio) AS CONT FROM rastreio R LEFT JOIN cliente C ON(R.idcliente = C.idcliente) LEFT JOIN vaga V ON(R.idvaga = V.idvaga) LEFT JOIN candidato CD ON(CD.idcandidato = R.idcandidato)";
			}
			catch( Exception $e )
			{
				throw new Exception( $e );
				return $retorno;
			}
		}
		################################################################################################################
		public function GetTotalPorCliente($filtro = "")
		{
			$retorno = "";
			try
			{
				if(empty($filtro))
					$filtro = "1";
				$sql = "SELECT C.nome AS cliente, C.empresa, DATE_FORMAT(R.cadastradoem, '%Y-%m-%d') AS 'dia' FROM rastreio R LEFT JOIN cliente C ON(R.idcliente = C.idcliente) LEFT JOIN vaga V ON(R.idvaga = V.idvaga) LEFT JOIN candidato CD ON(CD.idcandidato = R.idcandidato) WHERE {$filtro} GROUP BY C.nome, dia";
				$query = self::Query($sql);
				if(empty($query))
					return 0;
				return $query->num_rows();
			}
			catch( Exception $e )
			{
				throw new Exception( $e );
				return $retorno;
			}
		}
		################################################################################################################
		public function GetSqlListaCockpit()
		{
			$retorno = "";
			try
			{
				return "SELECT DATE_FORMAT(R.cadastradoem, '%d/%m/%Y') AS 'data', R.descricao, COUNT(*) AS qtd FROM rastreio R LEFT JOIN cliente C ON(R.idcliente = C.idcliente)";
			}
			catch( Exception $e )
			{
				throw new Exception( $e );
				return $retorno;
			}
		}
		################################################################################################################
		public function GetSqlListaCockpitCandidato()
		{
			$retorno = "";
			try
			{
				return "SELECT DATE_FORMAT(R.cadastradoem, '%d/%m/%Y') AS 'data', 
				(SELECT COUNT(*) AS qdt FROM rastreio RA WHERE RA.idcliente = R.idcliente AND RA.codigo = 'VisualCandidatosVaga' AND DATE_FORMAT(R.cadastradoem, '%Y-%m-%d') = DATE_FORMAT(RA.cadastradoem, '%Y-%m-%d')) AS 'VisualCandidatosVaga', 
				(SELECT COUNT(*) AS qdt FROM rastreio RA WHERE RA.idcliente = R.idcliente AND RA.codigo = 'VisualLKD' AND DATE_FORMAT(R.cadastradoem, '%Y-%m-%d') = DATE_FORMAT(RA.cadastradoem, '%Y-%m-%d')) AS 'VisualLKD', 
				(SELECT COUNT(*) AS qdt FROM rastreio RA WHERE RA.idcliente = R.idcliente AND RA.codigo = 'MarcarFavorito' AND DATE_FORMAT(R.cadastradoem, '%Y-%m-%d') = DATE_FORMAT(RA.cadastradoem, '%Y-%m-%d')) AS 'MarcarFavorito', 
				(SELECT COUNT(*) AS qdt FROM rastreio RA WHERE RA.idcliente = R.idcliente AND RA.codigo = 'DesmarcarFavorito' AND DATE_FORMAT(R.cadastradoem, '%Y-%m-%d') = DATE_FORMAT(RA.cadastradoem, '%Y-%m-%d')) AS 'DesmarcarFavorito', 
				(SELECT COUNT(*) AS qdt FROM rastreio RA WHERE RA.idcliente = R.idcliente AND RA.codigo = 'VisualEdit' AND DATE_FORMAT(R.cadastradoem, '%Y-%m-%d') = DATE_FORMAT(RA.cadastradoem, '%Y-%m-%d')) AS 'VisualEdit', 
				(SELECT COUNT(*) AS qdt FROM rastreio RA WHERE RA.idcliente = R.idcliente AND RA.codigo = 'VisualTwitter' AND DATE_FORMAT(R.cadastradoem, '%Y-%m-%d') = DATE_FORMAT(RA.cadastradoem, '%Y-%m-%d')) AS 'VisualTwitter'
				FROM rastreio R LEFT JOIN cliente C ON(R.idcliente = C.idcliente)";
			}
			catch( Exception $e )
			{
				throw new Exception( $e );
				return $retorno;
			}
		}
		################################################################################################################
		public function GetSqlListaCandidatoCockpit()
		{
			$retorno = "";
			try
			{
				return "SELECT R.idvaga, V.titulodavaga, V.empresacontratante, CT.nome, R.idcandidato,, DATE_FORMAT(R.cadastradoem, '%d/%m/%Y') AS 'data'
				(SELECT COUNT(*) AS qdt FROM rastreio RA WHERE RA.idcandidato = R.idcandidato AND RA.codigo = 'MarcarFavorito' AND DATE_FORMAT(R.cadastradoem, '%Y-%m-%d') = DATE_FORMAT(RA.cadastradoem, '%Y-%m-%d')) AS 'MarcarFavorito',
				(SELECT COUNT(*) AS qdt FROM rastreio RA WHERE RA.idcandidato = R.idcandidato AND RA.codigo = 'DesmarcarFavorito' AND DATE_FORMAT(R.cadastradoem, '%Y-%m-%d') = DATE_FORMAT(RA.cadastradoem, '%Y-%m-%d')) AS 'DesmarcarFavorito',
				(SELECT COUNT(*) AS qdt FROM rastreio RA WHERE RA.idcandidato = R.idcandidato AND RA.codigo = 'VisualEdit' AND DATE_FORMAT(R.cadastradoem, '%Y-%m-%d') = DATE_FORMAT(RA.cadastradoem, '%Y-%m-%d')) AS 'VisualEdit',
				(SELECT COUNT(*) AS qdt FROM rastreio RA WHERE RA.idcandidato = R.idcandidato AND RA.codigo = 'VisualLKD' AND DATE_FORMAT(R.cadastradoem, '%Y-%m-%d') = DATE_FORMAT(RA.cadastradoem, '%Y-%m-%d')) AS 'VisualLKD'
				FROM rastreio R LEFT JOIN vaga V ON(R.idvaga = V.idvaga) LEFT JOIN cliente C ON(R.idcliente = C.idcliente) LEFT JOIN candidato CT ON(R.idcandidato = CT.idcandidato)";
			}
			catch( Exception $e )
			{
				throw new Exception( $e );
				return $retorno;
			}
		}
		################################################################################################################
		public function GetSqlTotalListaCockpit()
		{
			$retorno = "";
			try
			{
				return "SELECT COUNT(DISTINCT DATE_FORMAT(R.cadastradoem, '%d/%m/%Y')) AS CONT FROM rastreio R LEFT JOIN cliente C ON(R.idcliente = C.idcliente)";
			}
			catch( Exception $e )
			{
				throw new Exception( $e );
				return $retorno;
			}
		}
		################################################################################################################
		public function GetSqlTotalListaCandidatoCockpit()
		{
			$retorno = "";
			try
			{
				return "SELECT COUNT(DISTINCT DATE_FORMAT(R.cadastradoem, '%d/%m/%Y'), CT.idcandidato, R.idvaga) AS CONT
				FROM rastreio R LEFT JOIN vaga V ON(R.idvaga = V.idvaga) LEFT JOIN cliente C ON(R.idcliente = C.idcliente) LEFT JOIN candidato CT ON(R.idcandidato = CT.idcandidato)";
			}
			catch( Exception $e )
			{
				throw new Exception( $e );
				return $retorno;
			}
		}
		################################################################################################################
		public function GetSqlTotalListaClientes()
		{
			$retorno = "";
			try
			{
				return "SELECT COUNT(DISTINCT C.idcliente) AS CONT FROM cliente C INNER JOIN rastreio R ON(R.idcliente = C.idcliente)";
			}
			catch( Exception $e )
			{
				throw new Exception( $e );
				return $retorno;
			}
		}
		################################################################################################################
		public function GetSqlListaClientes()
		{
			$retorno = "";
			try
			{
				return "SELECT DISTINCT C.idcliente, C.nome, C.empresa FROM cliente C INNER JOIN rastreio R ON(R.idcliente = C.idcliente)";
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
				$filtro .= " AND (R.codigo LIKE '%{$buscar}%' OR R.descricao LIKE '%{$buscar}%')";
			}
			
			$idcliente = GetFiltro("idcliente");
			$empresa = GetFiltro("empresa");
			if(!empty($idcliente))
			{
				$filtro .= " AND R.idcliente = '{$idcliente}'";
			}
			elseif(!empty($empresa))
			{
				$filtro .= " AND C.empresa = '{$empresa}'";
			}
			else
			{
				$filtro .= " AND C.empresa NOT IN('Candidato Agora', 'NEXTHIRE', 'Forgood')";
			}
			$cadastradoeminicio = GetFiltro("cadastradoeminicio");
			if(!empty($cadastradoeminicio))
			{
				$data = date("Y-m-d", TimeData($cadastradoeminicio));
				$filtro .= " AND R.cadastradoem >= '{$data}'";
			}
			$cadastradoemfim = GetFiltro("cadastradoemfim");
			if(!empty($cadastradoemfim))
			{
				$data = date("Y-m-d", TimeData($cadastradoemfim));
				$filtro .= " AND R.cadastradoem <= '{$data}'";
			}
			$tipo = Get("tipo","");
			if(!empty($tipo))
			{
				$filtro .= " AND R.codigo = '{$tipo}'";
			}
			$cockpitcandidato = Get("cockpitcandidato");
			$candidatocockpit = Get("candidatocockpit");
			if(!empty($cockpitcandidato))
			{
				$filtro .= " AND R.codigo IN('VisualCandidatosVaga', 'VisualLKD', 'MarcarFavorito', 'DesmarcarFavorito','VisualEdit','VisualTwitter')";
			}
			elseif(!empty($candidatocockpit))
			{
				$filtro .= " AND R.codigo IN('MarcarFavorito','DesmarcarFavorito','VisualEdit','VisualLKD') AND CT.idcandidato IS NOT NULL";
			}
			if(!empty($filtro))
			{
				$filtro  = substr($filtro, 4);
			}
			if($semOrder)
			{
				return $filtro;
			}
			if(!empty($cockpitcandidato))
			{
				$ordem = array('R.cadastradoem', 'VisualCandidatosVaga', 'VisualLKD', 'VisualTwitter', 'MarcarFavorito', 'DesmarcarFavorito', 'VisualEdit');
			}
			elseif(!empty($candidatocockpit))
			{
				$ordem = array('titulodavaga','nome','data','MarcarFavorito','DesmarcarFavorito','VisualEdit','VisualLKD');
			}
			else
			{
				$ordem = array('R.idrastreio', 'R.cliente', 'R.codigo', 'R.descricao', 'R.ip', 'R.cadastradoem', 'R.idrastreio');
			}
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
			if(!empty($cockpitcandidato))
			{
				$filtro .= " GROUP BY data ";
			}
			elseif(!empty($candidatocockpit))
			{
				$filtro .= " GROUP BY data, CT.nome, R.idvaga ";
			}
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
		#######################################################################################################
		public function FiltroPDF($semOrder = false)
		{
			$filtro = "";
			$buscar = Get("buscar");
			if(!empty($buscar))
			{
				$filtro .= " AND (R.codigo LIKE '%{$buscar}%' OR R.descricao LIKE '%{$buscar}%')";
			}
			
			$idcliente = Get("idcliente");
			$empresa = Get("empresa");
			if(!empty($idcliente))
			{
				$filtro .= " AND R.idcliente = '{$idcliente}'";
			}
			elseif(!empty($empresa))
			{
				$filtro .= " AND C.empresa = '{$empresa}'";
			}
			else
			{
				$filtro .= " AND C.empresa NOT IN('Candidato Agora', 'NEXTHIRE', 'Forgood')";
			}
			$cadastradoeminicio = Get("cadastradoeminicio");
			if(!empty($cadastradoeminicio))
			{
				$data = date("Y-m-d", TimeData($cadastradoeminicio));
				$filtro .= " AND R.cadastradoem >= '{$data}'";
			}
			$cadastradoemfim = Get("cadastradoemfim");
			if(!empty($cadastradoemfim))
			{
				$data = date("Y-m-d", TimeData($cadastradoemfim));
				$filtro .= " AND R.cadastradoem <= '{$data}'";
			}
			
			if(!empty($filtro))
			{
				$filtro  = substr($filtro, 4);
			}

			return $filtro;
		}
		#######################################################################################################
		public function FiltroClientes($semOrder = false)
		{
			$filtro = "";
			$buscar = Get("buscar");
			if(!empty($buscar))
			{
				$filtro .= " AND (R.codigo LIKE '%{$buscar}%' OR R.descricao LIKE '%{$buscar}%')";
			}
			
			$idcliente = Get("idcliente");
			$empresa = Get("empresa");
			if(!empty($idcliente))
			{
				$filtro .= " AND R.idcliente = '{$idcliente}'";
			}
			elseif(!empty($empresa))
			{
				$filtro .= " AND C.empresa = '{$empresa}'";
			}
			else
			{
				$filtro .= " AND C.empresa NOT IN('Candidato Agora', 'NEXTHIRE', 'Forgood')";
			}
			$cadastradoeminicio = Get("inicio");
			if(!empty($cadastradoeminicio))
			{
				$data = date("Y-m-d 00:00:00", TimeData($cadastradoeminicio));
				$filtro .= " AND R.cadastradoem >= '{$data}'";
			}
			$cadastradoemfim = Get("final");
			if(!empty($cadastradoemfim))
			{
				$data = date("Y-m-d 23:59:59", TimeData($cadastradoemfim));
				$filtro .= " AND R.cadastradoem <= '{$data}'";
			}
			
			if(!empty($filtro))
			{
				$filtro  = substr($filtro, 4);
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
			$obj = GetModelo("rastreio");
			if(empty($obj))
				return $retorno;
			foreach ($lista as $key=>$linha)
			{
				$obj->SalvarListaRastreio($linha);
			}
			return true;
		}
		################################################################################################################
		public function SalvarListaRastreio($dados = false)
		{
			if(empty($dados))
				return;
			$rastreio = self::GetDadosChave($dados, array('rastreio','rastreio'));
			if(empty($rastreio))
				return;
			$filtro = "rastreio = '{$rastreio}'";
			$obj = $this->FiltroObjeto($filtro);
			if(empty($obj))
			{
				$obj = $this->GetInstancia();
				$obj->rastreio = $rastreio;
			}
			$obj->Ajustar(true);
			$obj->Salvar();
			return;
		}
		################################################################################################################
		public function ExportarRastreio()
		{
			$posicao = Get("posicao", 0);
			$total = Get("total", 0);
			$file = Get("file");
			$tipo = Get("tipo");
			$limite = 500;
			$obj = GetModelo('rastreio');
			$filtro = $obj->Filtro(true);
			
			if(empty($total))
			{
				if($tipo == "por cliente")
				{
					$total = $obj->GetTotalPorCliente($filtro);
				}
				else
				{
					$sqlTotal = $obj->GetSqlTotalLista();
					$total = $obj->TotalRegistro($filtro, $sqlTotal, false);
				}
				if(empty($total))
				{
					$dados['sucesso'] = false;
					$dados['erro'] = __("Nenhum rastreio foi encontrado no momento.");
				}
				else
				{
					$dados['sucesso'] = true;
					$dados['titulo'] = __("Processando Exportação");
					$dados['mensagem'] = __("Exportação de rastreio está processando.");
					$dados['url'] = "";
					$dados['finalizado'] = false;
					$dados['file'] = $file;
					$dados['posicao'] = $posicao;
					$dados['total'] = $total;
				}
				return $dados;
			}
			if($tipo == "por cliente")
			{	
				$sql = $obj->GetSqlListaPorCliente($filtro, $posicao, $limite);	
				$objs = $obj->FiltroObjetos(false, $sql);
				$funcao = "GetDadosExcelPorCliente";
				$campos = $obj->GetNomesCamposPorCliente();
			}
			else
			{
				$sql = $obj->GetSqlLista();
				$filtro .= " ORDER BY R.cadastradoem ASC";
				$filtro .= " LIMIT {$posicao},{$limite}";
				$objs = $obj->FiltroObjetos($filtro, $sql);
				$funcao = "GetDadosExcel";
				$campos = $obj->GetNomesCampos();
			}
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
					"campos"=>$campos,
					"download"=>false,
					"maiusculo"=>false,
					"funcao"=>$funcao,
					"pasta"=>$obj->GetCaminho()
				);
				Excel($data);
				$posicao += $limite;
				$dados['sucesso'] = true;
				if($posicao >= $total)
				{
					$dados['titulo'] = __("Exportação de rastreio");
					$dados['mensagem'] = __("Exportação de rastreio foi finalizada.<br/>O download se iniciará em instantes");
					$dados['url'] = site_url("rastreio/baixarrastreio/{$file}");
					$dados['finalizado'] = true;
					$dados['file'] = $file;
					$dados['posicao'] = $posicao;
					$dados['total'] = $total;
				}
				else
				{
					$dados['titulo'] = __("Exportação de rastreio");
					$dados['mensagem'] = __("Exportação de rastreio está processando.");
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
				$dados['erro'] = __("Nenhum rastreio foi encontrado.");
			}
			return $dados;
		}
		################################################################################################################
		public function &GetListaPDF()
		{
			$retorno = false;
			try
			{
				$filtro = $this->FiltroPDF();
				$sql = $this->GetSqlListaPorCliente($filtro, 0, 10000);
				$objs = $this->FiltroObjetos(false, $sql);
				return $objs;
			}
			catch( Exception $e )
			{
				throw new Exception( $e );
				return $retorno;
			}
		}
		################################################################################################################
		public function GetFileNomePDF($idcliente = 0)
		{
			$retorno = "exportacao_pdf_rastreio_".date("Y-m-d").".pdf";
			try
			{
				if(empty($idcliente))
					return $retorno;
				$sql = "SELECT IF(empresa = '', nome, CONCAT(nome,' (',empresa,')')) AS 'nome' FROM cliente WHERE idcliente = '{$idcliente}'";
				$file = self::GetSqlCampo($sql,"nome");
				if(empty($file))
					return $retorno;
				$file = AcertaNomeArquivo($file)."_".date("Y-m-d").".pdf";
				return $file;
			}
			catch( Exception $e )
			{
				throw new Exception( $e );
				return $retorno;
			}
		}
		################################################################################################################
		public function GetNomeFile()
		{
			$retorno = "exportacaorastreio_".date("Y-m-d_H-i-s").".xls";
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
				"ID" => "idrastreio",
				"código" => "codigo",
				"descrição" => "descricao",
				"idcliente" => "idcliente",
				"cliente" => "cliente",
				"empresa" => "empresa",
				"idvaga" => "idvaga",
				"titulo da vaga" => "titulodavaga",
				"empresa contratante" => "empresacontratante",
				"idcandidato" => "idcandidato",
				"candidato" => "candidato",
				"ip" => "ip",
				"cadastrado em" => "cadastradoem",
			);
			return $campos;
		}
		################################################################################################################
		public function GetNomesCamposPorCliente()
		{
			$campos = array(
				"cliente" => "cliente",
				"empresa" => "empresa",
				"dia" => "dia",
				"Tempo total " => "tempototal"
			);
			return $campos;
		}
		################################################################################################################
		public function GetCaminho($file = "")
		{
			return $this->SetDominio($file);
		}
		################################################################################################################
		public function GetSession()
		{
			$CI =& get_instance();
			return $CI->session->session_id;
		}
		################################################################################################################
		public function GetDescricaoCodigo($codigo = "")
		{
			$retorno = "Código não foi localizado";
			if(empty($codigo))
				$codigo = $this->codigo;
			if(empty($codigo))
				return $retorno;
			$lista = array(
				"Login"=>"Login foi realizado",
				"Sair"=>"Saiu do sistema do site",
				"CadVaga"=>"Visualizou pagina de cadastro de nova vaga",
				"VisualVaga"=>"Visualizou pagina de lista de vagas",
				"VisualCandidato"=>"Visualizou pagina de lista de candidatos",
				"VisualCandidatosVaga"=>"Visualizou pagina de lista de candidatos de uma vaga",
				"VisualResumoVaga"=>"Visualizou pagina de resumo de uma vaga",
				"CadVagaConcluido"=>"Cadastro de vaga concluido",
				"CadVagaCriadacliente"=>"Vaga criado pelo cliente",
				"CadVagaCriadacolaborador"=>"Vaga criado pelo colaborador",
				"VisualLKD"=>"Visualizou pagina do linkedin do candidato da vaga",
				"VisualEdit"=>"Visualizou os dados do candidato da vaga",
				"ClickEmail"=>"Clicou no link do email do candidato",
				"ClickTel"=>"Clicou no link do telefone do candidato",
				"VisualTwitter"=>"Visualizou pagina do twitter do candidato da vaga",
				"MarcarFavorito"=>"Candidato foi marcado como favorito",
				"DesmarcarFavorito"=>"Candidato foi desmarcado como favorito",
				"MarcarDesconsiderado"=>"Candidato foi desconsiderado da vaga",
				"DesmarcarDesconsiderado"=>"Candidato foi reconsiderado na vaga",
				"DeleteCandidato"=>"Deletou o candidato da vaga",
				"MarcarLinkedinDesatualizado"=>"Candidato foi marcado como Linkedin Desatualizado",
				"DesmarcarLinkedinDesatualizado"=>"Candidato foi desmarcado como Linkedin Desatualizado",
				"SalvarRetornoInviteLKD"=>"Retorno do Invite do Linkedin",
			);
			if(empty($lista[$codigo]))
				return $retorno;
			return $lista[$codigo];
		}
		################################################################################################################
		public function Registrar($idcliente = 0, $codigo = "", $idvaga = 0, $idcandidato = 0)
		{
			$retorno = false;
			$ip = GetIP();
			$listaIP = array('135.19.59.26','179.111.29.183');
			if(in_array($ip, $listaIP))
			{
				return $retorno;
			}
			$this->idrastreio = 0;
			$this->idcliente = $idcliente;
			$this->codigo = $codigo;
			$this->descricao = "";
			$this->idvaga = $idvaga;
			$this->idcandidato = $idcandidato;
			$this->ip = $ip;
			$this->cadastradoem = "";
			$this->Ajustar(true);
			return $this->Salvar();
		}		
		################################################################################################################
		public function GetTabelaRestreio()
		{
			$posicao = Get("posicao", 0);
			$total = Get("total", 0);
			$tipo = Get("tipo");
			$limite = 10;
			$obj = GetModelo('rastreio');
			
			if(empty($total))
			{
				$sqlTotal = $obj->GetSqlTotalListaCockpit();
				$filtro = $obj->Filtro(true);
				$total = $obj->TotalRegistro($filtro, $sqlTotal, false);
				if(empty($total))
				{
					$dados['sucesso'] = false;
					$dados['erro'] = __("Nenhum registro foi encontrado no momento.");
				}
			}
			$sql = $obj->GetSqlListaCockpit();
			$filtro = $obj->Filtro(true);
			$filtro .= " GROUP BY data ORDER BY R.cadastradoem DESC";
			$filtro .= " LIMIT {$posicao},{$limite}";
			$objs = $obj->GetRows($filtro, $sql);
			if($objs)
			{
				$posicao += $limite;
				$dados['sucesso'] = true;
				if($posicao >= $total)
				{
					$dados['titulo'] = __("Lista de rastreio");
					$dados['mensagem'] = __("Lista de rastreio foi finalizada.");
					$dados['lista'] = $objs;
					$dados['finalizado'] = true;
					$dados['tipo'] = $tipo;
					$dados['posicao'] = $posicao;
					$dados['total'] = $total;
				}
				else
				{
					$dados['titulo'] = __("Lista de rastreio");
					$dados['mensagem'] = __("Lista de rastreio está processando.");
					$dados['lista'] = $objs;
					$dados['finalizado'] = false;
					$dados['tipo'] = $tipo;
					$dados['posicao'] = $posicao;
					$dados['total'] = $total;
				}
			}
			else
			{
				$dados['sucesso'] = false;
				$dados['erro'] = __("Nenhum registro foi encontrado.");
			}
			//XDebug($dados, $this);
			return $dados;
		}
		#######################################################################################################
		public function listatabelaCockpitCandidato($filtro = "", $sql = "", $sqlTotal = "")
		{
			if(empty($sqlTotal))
			{
				$sqlTotal = $sql;
				$limparSql = true;
			}
			else
			{
				$limparSql = false;
			}
			$total = $this->TotalRegistro(false, $sqlTotal, $limparSql);
			$totalfiltro = $this->TotalRegistro($filtro, $sqlTotal, $limparSql);
			$lista = $this->FiltroJson($filtro, $sql);
			$dados = array("draw" => Get('draw', 0),
				"recordsTotal" => $total,
				"recordsFiltered" => $totalfiltro,
				"data" => $lista);
				//XDebug($dados, $this);
			return $dados;
		}
		#######################################################################################################
		public function listatabelaCandidatoCockpit($filtro = "", $sql = "", $sqlTotal = "")
		{
			if(empty($sqlTotal))
			{
				$sqlTotal = $sql;
				$limparSql = true;
			}
			else
			{
				$limparSql = false;
			}
			$total = $this->TotalRegistro(false, $sqlTotal, $limparSql);
			$totalfiltro = $this->TotalRegistro($filtro, $sqlTotal, $limparSql);
			$lista = $this->FiltroJson($filtro, $sql);
			$dados = array("draw" => Get('draw', 0),
				"recordsTotal" => $total,
				"recordsFiltered" => $totalfiltro,
				"data" => $lista);
				
			return $dados;
		}
		################################################################################################################
		public function ListaClientes()
		{
			$empresa = Get("empresa", 0);
			if(!empty($empresa))
			{
				$filtro = " WHERE C.empresa = '{$empresa}'";
			}
			else
			{
				$filtro = "";
			}	
			$filtro .= " ORDER BY texto ASC";
			$sql = "SELECT C.idcliente AS 'id', CONCAT(C.nome,' (',C.empresa,')') AS 'texto' FROM cliente C {$filtro}";
			$rows = $this->GetRows(false, $sql);
			if(!empty($rows))
			{
				$dados['sucesso'] = true;
				$dados['lista'] = $rows;
				$dados['mensagem'] = __("Lista de cliente foi encontrado com sucesso.");
				$dados['titulo'] = __("Sucesso");
			}
			else
			{
				$dados['sucesso'] = false;
				$dados['erro'] = __("Nenhum cliente foi encontrado.");
				$dados['titulo'] = __("Erro");
			}
			return $dados;
		}
		################################################################################################################
		public function &GetJson(&$dados = false)
		{
			$retorno = false;
			try
			{
				if(empty($dados))
				{
					$dados = $this->GetDados();
				}
				if(!emptyData($dados['cadastradoem']))
					$dados['cadastradoem'] = date("d/m/Y H:i:s", TimeData($dados['cadastradoem']));
				else
					$dados['cadastradoem'] = "";
				return $dados;
			}
			catch( Exception $e )
			{
				throw new Exception( $e );
				return $retorno;
			}
		}
		################################################################################################################
		public function &GetDadosExcel(&$dados = false)
		{
			$retorno = false;
			try
			{
				if(empty($dados))
				{
					$dados = $this->GetDados();
				}				
				if(!emptyData($dados['cadastradoem']))
					$dados['cadastradoem'] = date("d/m/Y H:i:s", TimeData($dados['cadastradoem']));
				else
					$dados['cadastradoem'] = "";

				return $dados;
			}
			catch( Exception $e )
			{
				throw new Exception( $e );
				return $retorno;
			}
		}
		################################################################################################################
		public function &GetDadosExcelPorCliente(&$dados = false, $em_minutos = false)
		{
			$retorno = false;
			try
			{
				if(empty($dados))
				{
					$dados = $this->GetDados();
				}
				if(!emptyData($dados['dia']))
					$dados['dia'] = date("d/m/Y", TimeData($dados['dia']));
				else
					$dados['dia'] = "";
				if((emptyData($dados['inicio']))||(emptyData($dados['fim'])))
				{
					$dados['tempototal'] = "Não definido";
					$dados['tempo'] = 0;
				}
				elseif(ComparaData($dados['inicio'],$dados['fim']) == 0)
				{
					$dados['tempototal'] = "1 min";
					$dados['tempo'] = 60;
				}
				else
				{
					$tempo = TimeData($dados['fim']) - TimeData($dados['inicio']);
					$limite = 60 * 10;
					if($tempo > $limite)
					{
						$tempo = self::GetFaixadeTempo($dados['idcliente'], $dados['dia']);
					}
					$dados['tempo'] = $tempo;
					$dados['tempototal'] = $this->FormataData($tempo, $em_minutos);
				}

				return $dados;
			}
			catch( Exception $e )
			{
				throw new Exception( $e );
				return $retorno;
			}
		}
		################################################################################################################
		public function &FormataData($tempo = 0, $em_minutos = false)
		{
			$retorno = "1 min";
			try
			{
				if(empty($tempo))
				{
					return $retorno;
				}				
				
				$tempototal = "";
				if($em_minutos)
				{
					$minutos = intval($tempo / 60);
					$segundos = intval($tempo % 60);
					if((!empty($minutos))&&(!empty($segundos)))
					{
						$tempototal = "{$minutos} min";
					}
					elseif((!empty($minutos))&&(empty($segundos)))
					{
						$tempototal = "{$minutos} min";
					}
					elseif((empty($minutos))&&(!empty($segundos)))
					{
						$tempototal = "1 min";
					}
					elseif((empty($minutos))&&(empty($segundos)))
					{
						$tempototal = "1 min";
					}
				}
				else
				{					
					$horas = intval($tempo / 3600);
					$minuto = intval($tempo % 3600);
					$minutos = intval($minuto / 60);
					$segundos = intval($minuto % 60);
					//P("{$dados['fim']} - {$dados['inicio']} $horas:$minutos:$segundos = $tempo {$dados['idcliente']}, {$dados['dia']}");

					if((!empty($horas))&&(!empty($minutos))&&(!empty($segundos)))
					{
						$tempototal = "{$horas}h : {$minutos} m";
					}
					elseif((empty($horas))&&(!empty($minutos))&&(!empty($segundos)))
					{
						$tempototal = "{$minutos} m";
					}
					elseif((empty($horas))&&(!empty($minutos))&&(empty($segundos)))
					{
						$tempototal = "{$minutos} m";
					}
					elseif((!empty($horas))&&(!empty($minutos))&&(empty($segundos)))
					{
						$tempototal = "{$horas}h : {$minutos} m";
					}
					elseif((!empty($horas))&&(empty($minutos))&&(!empty($segundos)))
					{
						$tempototal = "{$horas}h";
					}
					elseif((!empty($horas))&&(empty($minutos))&&(empty($segundos)))
					{
						$tempototal = "{$horas}h";
					}
					elseif((empty($horas))&&(empty($minutos))&&(!empty($segundos)))
					{
						$tempototal = "1 min";
					}
				}

				return $tempototal;
			}
			catch( Exception $e )
			{
				throw new Exception( $e );
				return $retorno;
			}
		}
		################################################################################################################
		public static function GetFaixadeTempo($idcliente, $dia)
		{
			$retorno = "";
			try
			{
				if(empty($idcliente))
					return 0;
				if(empty($dia))
					return 0;
				$sql = "SELECT R.codigo, R.cadastradoem FROM rastreio R WHERE DATE_FORMAT(R.cadastradoem, '%d/%m/%Y') = '{$dia}' AND idcliente = '{$idcliente}' ORDER BY R.cadastradoem ASC, R.idrastreio ASC";
				$rows = self::GetSqlrows($sql);
				if(empty($rows))
					return 0;
				$total = 0;
				$inicio = "";
				$anterior = "";
				$ultimo = "";
				foreach ($rows as $key=>$row)
				{//P($row);
					if($key == 0)
					{
						$inicio = $row['cadastradoem'];
						continue;
					}
					$ultimo = $rows[$key - 1]['cadastradoem'];
					if($row['codigo'] == "Login")
					{
						if((emptyData($anterior))&&(emptyData($inicio)))
						{
							$anterior = $row['cadastradoem'];
							$inicio = $row['cadastradoem'];
						}
						elseif(emptyData($anterior))
						{
							$anterior = $row['cadastradoem'];
						}
						else
						{
							$total += TimeData($anterior) - TimeData($inicio); //P("$anterior - $inicio = $total");
							$inicio = $row['cadastradoem'];
							$anterior = "";
						}						
					}
					elseif($row['codigo'] == "Sair")
					{
						$anterior = $row['cadastradoem'];
						$total += TimeData($anterior) - TimeData($inicio); //P("$anterior - $inicio = $total");
						$inicio = "";
						$anterior = "";					
					}
					else
					{
						if(emptyData($inicio))
						{
							$inicio = $row['cadastradoem'];
						}
						$anterior = $row['cadastradoem'];
					}
				}
				if((!emptyData($inicio))&&(!emptyData($anterior)))
				{
					$total += TimeData($anterior) - TimeData($inicio); //P("$anterior - $inicio = $total");
				}
				elseif((!emptyData($anterior))&&(!emptyData($ultimo)))
				{
					$total += TimeData($ultimo) - TimeData($inicio); //P("$ultimo - $inicio = $total");
				}
				return $total;
			}
			catch( Exception $e )
			{
				throw new Exception( $e );
				return $retorno;
			}
		}		
		################################################################################################################
		public function ListaCockpitRastreio()
		{
			$inicio = Get("inicio", "");
			$final = Get("final", "");
			$posicao = Get("posicao", 0);
			$total = Get("total", 0);
			$limite = 5;
			$obj = GetModelo('rastreio');
			
			if(empty($total))
			{
				$sqlTotal = $obj->GetSqlTotalListaClientes();
				$filtro = $obj->FiltroClientes(true);
				$total = $obj->TotalRegistro($filtro, $sqlTotal, false);
				if(empty($total))
				{
					$dados['sucesso'] = false;
					$dados['erro'] = __("Nenhum registro foi encontrado no momento.");
				}
			}
			$sql = $obj->GetSqlListaClientes();
			$filtro = $obj->FiltroClientes(true);
			$filtro .= " ORDER BY C.empresa ASC, C.nome ASC";
			$filtro .= " LIMIT {$posicao},{$limite}";
			$objs = $obj->GetRows($filtro, $sql);
			if($objs)
			{
				$posicao += $limite;
				$dados['sucesso'] = true;
				$lista = $this->ProcessarRastreio($objs, $inicio, $final);
				if($posicao >= $total)
				{
					$dados['titulo'] = __("Lista de rastreio");
					$dados['mensagem'] = __("Lista de rastreio foi finalizada.");
					$dados['lista'] = $lista;
					$dados['finalizado'] = true;
					$dados['posicao'] = $posicao;
					$dados['total'] = $total;
				}
				else
				{
					$dados['titulo'] = __("Lista de rastreio");
					$dados['mensagem'] = __("Lista de rastreio está processando.");
					$dados['lista'] = $lista;
					$dados['finalizado'] = false;
					$dados['posicao'] = $posicao;
					$dados['total'] = $total;
				}
			}
			else
			{
				$dados['sucesso'] = false;
				$dados['erro'] = __("Nenhum registro foi encontrado.");
			}
			//XDebug($dados, $this);
			return $dados;
		}		
		################################################################################################################
		public function &ProcessarRastreio(&$rows = [], $inicio = "", $final = "")
		{
			$retorno = false;
			if(empty($rows))
			{
				return $retorno;
			}
			foreach ($rows as $key=>$row)
			{
				$rows[$key]['tempo'] = self::GetFaixadeTempoCliente($row['idcliente'], $inicio, $final);
				$rows[$key]['tempototal'] = $this->FormataData($rows[$key]['tempo'], true);
				$rows[$key]['dias'] = $this->GetListaPorClienteDia($row['idcliente'], $inicio, $final);
			}
			return $rows;
		}
		################################################################################################################
		public static function GetFaixadeTempoCliente($idcliente = 0, $inicio = "", $final = "")
		{
			$retorno = "";
			try
			{
				if(empty($idcliente))
					return 0;
				$filtro = " R.idcliente = '{$idcliente}'";
				if(!empty($inicio))
				{
					$data = date("Y-m-d 00:00:00", TimeData($inicio));
					$filtro .= " AND R.cadastradoem >= '{$data}'";
				}
				if(!empty($final))
				{
					$data = date("Y-m-d 23:59:59", TimeData($final));
					$filtro .= " AND R.cadastradoem <= '{$data}'";
				}
				$sql = "SELECT R.codigo, R.cadastradoem, DATE_FORMAT(R.cadastradoem, '%d/%m/%Y') AS dia FROM rastreio R WHERE {$filtro} ORDER BY R.cadastradoem ASC, R.idrastreio ASC";
				$rows = self::GetSqlrows($sql);
				if(empty($rows))
					return 0;
				$total = 0;
				$inicio = "";
				$anterior = "";
				$ultimo = "";
				$ultimodia = "";
				foreach ($rows as $key=>$row)
				{//P($row);
					if($key == 0)
					{
						$inicio = $row['cadastradoem'];
						$ultimodia = $row['dia'];
						continue;
					}
					$ultimo = $rows[$key - 1]['cadastradoem'];
					if(($row['codigo'] == "Login")&&($ultimodia == $row['dia']))
					{
						if((emptyData($anterior))&&(emptyData($inicio)))
						{
							$anterior = $row['cadastradoem'];
							$inicio = $row['cadastradoem'];
						}
						elseif(emptyData($anterior))
						{
							$anterior = $row['cadastradoem'];
						}
						else
						{
							if(!emptyData($inicio))
								$total += TimeData($anterior) - TimeData($inicio); //P("$anterior - $inicio = $total");
							$inicio = $row['cadastradoem'];
							$anterior = "";
						}
					}
					elseif(($row['codigo'] == "Sair")&&($ultimodia == $row['dia']))
					{
						$anterior = $row['cadastradoem'];
						$total += TimeData($anterior) - TimeData($inicio); //P("$anterior - $inicio = $total");
						$inicio = "";
						$anterior = "";
					}
					elseif(($row['codigo'] == "Sair")&&($ultimodia != $row['dia']))
					{
						$anterior = $row['cadastradoem'];
						$total += TimeData($anterior) - TimeData($inicio); //P("$anterior - $inicio = $total");
						$inicio = "";
						$anterior = "";
						$ultimodia = $row['dia'];
					}
					elseif($ultimodia != $row['dia'])
					{
						if((!emptyData($anterior))&&(!emptyData($inicio)))
							$total += TimeData($anterior) - TimeData($inicio); //P("$anterior - $inicio = $total");
						$inicio = $row['cadastradoem'];
						$anterior = "";
						$ultimodia = $row['dia'];
					}
					else
					{
						if(emptyData($inicio))
						{
							$inicio = $row['cadastradoem'];
						}
						$anterior = $row['cadastradoem'];
					}
				}
				if((!emptyData($inicio))&&(!emptyData($anterior)))
				{
					$total += TimeData($anterior) - TimeData($inicio); //P("$anterior - $inicio = $total");
				}
				elseif((!emptyData($anterior))&&(!emptyData($ultimo)))
				{
					$total += TimeData($ultimo) - TimeData($inicio); //P("$ultimo - $inicio = $total");
				}
				return $total;
			}
			catch( Exception $e )
			{
				throw new Exception( $e );
				return $retorno;
			}
		}
		################################################################################################################
		public function &GetListaPorClienteDia($idcliente = 0, $inicio = "", $final = "")
		{
			$retorno = false;
			try
			{
				$filtro = " R.idcliente = '{$idcliente}'";
				if(!empty($inicio))
				{
					$data = date("Y-m-d 00:00:00", TimeData($inicio));
					$filtro .= " AND R.cadastradoem >= '{$data}'";
				}
				if(!empty($final))
				{
					$data = date("Y-m-d 23:59:59", TimeData($final));
					$filtro .= " AND R.cadastradoem <= '{$data}'";
				}
				$sql = "SELECT C.idcliente, DATE_FORMAT(R.cadastradoem, '%Y-%m-%d') AS 'dia', MIN(R.cadastradoem) AS 'inicio', MAX(R.cadastradoem) AS 'fim' FROM rastreio R LEFT JOIN cliente C ON(R.idcliente = C.idcliente) WHERE {$filtro} GROUP BY dia ORDER BY dia DESC LIMIT 0, 5";
				$rows = self::GetSqlrows($sql);
				if(empty($rows))
					return $retorno;
				$dados = [];
				foreach ($rows as $key=>$row)
				{
					$row = $this->GetDadosExcelPorCliente($row, true);
					$dados[$key]['dia'] = $row['dia'];
					$dados[$key]['tempo'] = $row['tempo'];
					$dados[$key]['tempototal'] = $row['tempototal'];
				}
				
				return $dados;
			}
			catch( Exception $e )
			{
				throw new Exception( $e );
				return $retorno;
			}
		}
		################################################################################################################
		public function __destruct()
		{
			unset($this->dados, $this->Tabela, $this->PrimaryKey);
		}
	}
}
?>