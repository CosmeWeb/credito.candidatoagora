<?php
/***********************************************************************
 * Module:  /models/Candidato_model.PHP
 * Author:  Host-up
 * Date:	25/06/2020 15:28:56
 * Purpose: Definição da Classe Candidato_model
 * Instancias: $this->load->model('Candidato_model', 'candidato');
 * Objeto: $candidato = $this->candidato->GetInstancia($dados);
 ***********************************************************************/
if (!class_exists('Candidato_model'))
{
	class Candidato_model extends MY_Model
	{
		private static $_cidade = null;
		private static $_candidatocompetencia = null;
		private static $_candidatocargo = null;
		private static $_candidatocurso = null;
		private static $_vaga = null;
		private static $_candidatovaga = null;
		private static $_candidatoidioma = null;
		private static $_candidatointeresse = null;
		private static $_candidatonovo = null;
		private static $_candidatobot = null;
		private static $_candidatoperfil = null;
		private static $_toptalent = null;
		private static $_favorito = null;
		private static $_avaliacao = null;
		private static $_candidatocertificado = null;
		private static $_candidatocontato = null;
		################################################################################################################
		public function __construct( $dados = false)
		{
			try
			{
				$this->Tabela = "candidato";
				$this->PrimaryKey = "idcandidato";
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
				if(!emptyData($this->datacoleta))
					$this->datacoleta = date("Y-m-d", TimeData($this->datacoleta));
				if(!emptyData($this->dataaplicacao))
					$this->dataaplicacao = date("Y-m-d", TimeData($this->dataaplicacao));
			}
			else
			{
				if(!emptyData($this->datacoleta))
					$this->datacoleta = date("d/m/Y", TimeData($this->datacoleta));
				else
					$this->datacoleta = "";
				if(!emptyData($this->dataaplicacao))
					$this->dataaplicacao = date("d/m/Y", TimeData($this->dataaplicacao));
				else
					$this->dataaplicacao = "";
			}
		}
		################################################################################################################
		public static function &NewCidade() {
			if (self::$_cidade == null)
				self::$_cidade = GetModelo("cidade");
			return self::$_cidade;
		}
		################################################################################################################
		public static function &NewCandidatocertificado() {
			if (self::$_candidatocertificado == null)
				self::$_candidatocertificado = GetModelo("candidatocertificado");
			return self::$_candidatocertificado;
		}
		################################################################################################################
		public static function &NewCandidatocompetencia() {
			if (self::$_candidatocompetencia == null)
				self::$_candidatocompetencia = GetModelo("candidatocompetencia");
			return self::$_candidatocompetencia;
		}
		################################################################################################################
		public static function &NewCandidatocontato() {
			if (self::$_candidatocontato == null)
				self::$_candidatocontato = GetModelo("candidatocontato");
			return self::$_candidatocontato;
		}
		################################################################################################################
		public static function &NewCandidatocargo() {
			if (self::$_candidatocargo == null)
				self::$_candidatocargo = GetModelo("candidatocargo");
			return self::$_candidatocargo;
		}
		################################################################################################################
		public static function &NewCandidatocurso() {
			if (self::$_candidatocurso == null)
				self::$_candidatocurso = GetModelo("candidatocurso");
			return self::$_candidatocurso;
		}
		################################################################################################################
		public static function &NewVaga() {
			if (self::$_vaga == null)
				self::$_vaga = GetModelo("vaga");
			return self::$_vaga;
		}
		################################################################################################################
		public static function &NewCandidatoVaga() {
			if (self::$_candidatovaga == null)
				self::$_candidatovaga = GetModelo("candidatovaga");
			return self::$_candidatovaga;
		}
		################################################################################################################
		public static function &NewCandidatoBot() {
			if (self::$_candidatobot == null)
				self::$_candidatobot = GetModelo("candidatobot");
			return self::$_candidatobot;
		}
		################################################################################################################
		public static function &NewCandidatoperfil() {
			if (self::$_candidatoperfil == null)
				self::$_candidatoperfil = GetModelo("candidatoperfil");
			return self::$_candidatoperfil;
		}
		################################################################################################################
		public static function &NewCandidatoIdioma() {
			if (self::$_candidatoidioma == null)
				self::$_candidatoidioma = GetModelo("candidatoidioma");
			return self::$_candidatoidioma;
		}
		################################################################################################################
		public static function &NewToptalent() {
			if (self::$_toptalent == null)
				self::$_toptalent = GetModelo("toptalent");
			return self::$_toptalent;
		}
		################################################################################################################
		public static function &NewFavorito() {
			if (self::$_favorito == null)
				self::$_favorito = GetModelo("favorito");
			return self::$_favorito;
		}
		################################################################################################################
		public static function &NewCandidatonovo() {
			if (self::$_candidatonovo == null)
				self::$_candidatonovo = GetModelo("candidatonovo");
			return self::$_candidatonovo;
		}
		################################################################################################################
		public static function &NewCandidatointeresse() {
			if (self::$_candidatointeresse == null)
				self::$_candidatointeresse = GetModelo("candidatointeresse");
			return self::$_candidatointeresse;
		}
		################################################################################################################
		public static function &NewAvaliacao() {
			if (self::$_avaliacao == null)
				self::$_avaliacao = GetModelo("avaliacao");
			return self::$_avaliacao;
		}
		################################################################################################################
		public function GerarOpcoesCidade($value = "0", $texto = "", $default = "0")
		{
			if(empty($texto))
				$texto = __("-- Selecione --");
			$primeiro = array("valor"=>$default,"texto"=>$texto);
			$sql = "SELECT idcidade AS 'id', cidade AS 'texto' FROM cidade ORDER BY texto ASC";
			return $this->GeraOpcoesSql($value, $sql, "id", "texto", $primeiro);
		}
		################################################################################################################
		public function GerarOpcoesEstado($value = "0", $texto = "", $default = "0")
		{
			if(empty($texto))
				$texto = __("-- Selecione --");
			$primeiro = array("valor"=>$default,"texto"=>$texto);
			$sql = "SELECT idestado AS 'id', estado AS 'texto' FROM estado ORDER BY texto ASC";
			return $this->GeraOpcoesSql($value, $sql, "id", "texto", $primeiro);
		}
		################################################################################################################
		public function GerarOpcoesPais($value = "0", $texto = "", $default = "0")
		{
			if(empty($texto))
				$texto = __("-- Selecione --");
			$primeiro = array("valor"=>$default,"texto"=>$texto);
			$sql = "SELECT idpais AS 'id', pais AS 'texto' FROM pais ORDER BY texto ASC";
			return $this->GeraOpcoesSql($value, $sql, "id", "texto", $primeiro);
		}
		################################################################################################################
		public function GerarOpcoesCargo($value = "0", $texto = "", $default = "0")
		{
			if(empty($texto))
				$texto = __("-- Selecione --");
			$primeiro = array("valor"=>$default,"texto"=>$texto);
			$sql = "SELECT idcargo AS 'id', cargo AS 'texto' FROM cargo ORDER BY texto ASC";
			return $this->GeraOpcoesSql($value, $sql, "id", "texto", $primeiro);
		}
		################################################################################################################
		public function GerarOpcoesVagas($value = "0", $texto = "", $default = "0")
		{
			if(empty($texto))
				$texto = __("-- Selecione --");
			$primeiro = array("valor"=>$default,"texto"=>$texto);
			$sql = "SELECT idvaga AS 'id',IF(empresacontratante = '', TRIM(titulodavaga), IF(titulodavaga = '',TRIM(empresacontratante), TRIM(CONCAT(titulodavaga,' (',empresacontratante,')')))) AS 'texto' FROM vaga ORDER BY texto ASC";
			return $this->GeraOpcoesSql($value, $sql, "id", "texto", $primeiro);
		}
		################################################################################################################
		public function GerarOpcoesFavorito($value = "", $texto = "", $default = "")
		{
			if(empty($texto))
				$texto = __("-- Selecione --");
			$primeiro = array("valor"=>$default,"texto"=>$texto);
			$lista = array(
				'Não'=>'Não',
				'Sim'=>'Sim'
			);
			return self::GeraOpcoesArray($value, $lista, $primeiro);
		}
		################################################################################################################
		public function GerarOpcoesFavorito123($value = "", $texto = "", $default = "")
		{
			$obj = GetModelo("favoritogrupo");
			return $obj->GerarOpcoesFavorito123($value, $texto, $default);
		}
		################################################################################################################
		public function GerarOpcoesNovo($value = "", $texto = "", $default = "")
		{
			if(empty($texto))
				$texto = __("-- Selecione --");
			$primeiro = array("valor"=>$default,"texto"=>$texto);
			$lista = array(
				'Não'=>'Não',
				'Sim'=>'Sim'
			);
			return self::GeraOpcoesArray($value, $lista, $primeiro);
		}
		################################################################################################################
		public function GerarOpcoesSexo($value = "", $texto = "", $default = "")
		{
			if(empty($texto))
				$texto = __("-- Selecione --");
			$primeiro = array("valor"=>$default,"texto"=>$texto);
			return $this->GeraOpcoesEnum($value, $this->Tabela, "sexo", $primeiro);
		}
		################################################################################################################
		public function GerarOpcoesAvaliacao($value = "", $texto = "", $default = "")
		{
			if(empty($texto))
				$texto = __("-- Selecione --");
			$primeiro = array("valor"=>$default,"texto"=>$texto);
			$lista = array(
				'Com interesse'=>'Com interesse',
				'Sem interesse'=>'Sem interesse',
				'Sem resposta até o momento'=>'Sem resposta até o momento',
				'Telefone correto'=>'Telefone correto',
				'Telefone não pertence a pessoa'=>'Telefone não pertence a pessoa',
				'Telefone inexistente/incompleto'=>'Telefone inexistente/incompleto',
				'Candidatos avaliados'=>'Candidatos avaliados',
				'Candidatos não avaliados'=>'Candidatos não avaliados',
				'Com perfil técnico comportamental'=>'Candidatos com perfil técnico comportamental',
				'Sem perfil técnico comportamental'=>'Candidatos sem perfil técnico comportamental',
				'Linkedin atualizados'=>'Linkedin atualizados',
				'Linkedin desatualizados'=>'Linkedin desatualizados',
				'Candidatos declararam ter inglês fluente'=>'Candidatos declararam ter inglês fluente',
				'Candidatos declararam ter inglês avançado'=>'Candidatos declararam ter inglês avançado',
				'Candidatos declararam ter inglês intermediário'=>'Candidatos declararam ter inglês intermediário',
				'Candidatos declararam ter inglês básico'=>'Candidatos declararam ter inglês básico',
				'Candidatos declararam não ter inglês'=>'Candidatos declararam não ter inglês'
			);
			return self::GeraOpcoesArray($value, $lista, $primeiro);
		}
		################################################################################################################
		public function GerarOpcoesLinkedinDesatualizado($value = "", $texto = "", $default = "")
		{
			if(empty($texto))
				$texto = __("-- Selecione --");
			$primeiro = array("valor"=>$default,"texto"=>$texto);
			return $this->GeraOpcoesEnum($value, $this->Tabela, "linkedin_desatualizado", $primeiro);
		}
		################################################################################################################
		public function GerarOpcoesRetornoInviteLKD($value = "", $texto = "", $default = "")
		{
			if(empty($texto))
				$texto = __("-- Selecione --");
			$primeiro = array("valor"=>$default,"texto"=>$texto);
			$lista = array(
				'Não'=>'Não',
				'Sim'=>'Sim'
			);
			return self::GeraOpcoesArray($value, $lista, $primeiro);
		}
		################################################################################################################
		public function GerarOpcoesAbordagem($value = "", $texto = "", $default = "")
		{
			$obj = GetModelo("abordagem");			
			return $obj->GerarOpcoesTipo($value, $texto, $default);
		}
		################################################################################################################
		public function GetSqlLista()
		{
			$retorno = "";
			try
			{
				return "SELECT DISTINCT C.idcandidato, C.nome, C.email, C.telefone, C.telefone_verificado, C.linkedin, P.pais, C.sexo, E.estado, CD.cidade, C.datacoleta, C.dataaplicacao, C.twitter FROM candidato C USE INDEX(idxcidade,idxestado,idxpais) LEFT JOIN pais P ON(C.idpais = P.idpais) LEFT JOIN estado E ON(C.idestado = E.idestado) LEFT JOIN cidade CD ON(C.idcidade = CD.idcidade) LEFT JOIN candidatocargo CC USE INDEX(idxcandidato, idxcargo) ON(C.idcandidato = CC.idcandidato) LEFT JOIN candidatovaga CV USE INDEX(idxcandidato, idxvaga) ON(C.idcandidato = CV.idcandidato) LEFT JOIN vaga V ON(V.idvaga = CV.idvaga) LEFT JOIN favorito F USE INDEX(idxcandidato, idxvaga) ON(C.idcandidato = F.idcandidato AND CV.idvaga = F.idvaga) LEFT JOIN avaliacao AV USE INDEX(idxcandidato) ON(C.idcandidato = AV.idcandidato) LEFT JOIN favoritogrupo FG USE INDEX(idxcandidato, idxvaga) ON(FG.idcandidato = CV.idcandidato AND FG.idvaga = CV.idvaga) LEFT JOIN abordagem AB USE INDEX(idxcandidato) ON(C.idcandidato = AB.idcandidato)";
			}
			catch( Exception $e )
			{
				throw new Exception( $e );
				return $retorno;
			}
		}
		################################################################################################################
		public function GetSqlListaExport($tipo = "geral")
		{
			$retorno = "";
			try
			{
				if($tipo == "geral")
				{
					return "SELECT DISTINCT C.idcandidato, C.nome, C.email, C.telefone, C.telefone_verificado, C.sexo, C.linkedin, P.pais, E.estado, CD.cidade, C.datacoleta, C.dataaplicacao, C.linkedin_desatualizado, C.retornoinvitelkd, F.tipo AS 'favorito', FG.tipo AS 'favorito123', AB.tipo AS 'abordagem' FROM candidato C USE INDEX(idxcidade,idxestado,idxpais) LEFT JOIN pais P ON(C.idpais = P.idpais) LEFT JOIN estado E ON(C.idestado = E.idestado) LEFT JOIN cidade CD ON(C.idcidade = CD.idcidade) LEFT JOIN candidatocargo CC USE INDEX(idxcandidato, idxcargo) ON(C.idcandidato = CC.idcandidato) LEFT JOIN cargo CG ON(CC.idcargo = CG.idcargo) LEFT JOIN candidatovaga CV USE INDEX(idxcandidato, idxvaga) ON(C.idcandidato = CV.idcandidato) LEFT JOIN vaga V ON(V.idvaga = CV.idvaga) LEFT JOIN favorito F USE INDEX(idxcandidato, idxvaga) ON(C.idcandidato = F.idcandidato AND CV.idvaga = F.idvaga) LEFT JOIN avaliacao AV LEFT JOIN favoritogrupo FG USE INDEX(idxcandidato, idxvaga) ON(FG.idcandidato = CV.idcandidato AND FG.idvaga = CV.idvaga) USE INDEX(idxcandidato) ON(C.idcandidato = AV.idcandidato) LEFT JOIN abordagem AB USE INDEX(idxcandidato) ON(C.idcandidato = AB.idcandidato)";
				}
				elseif($tipo == "geral antigo")
				{
					return "SELECT DISTINCT C.idcandidato, C.nome, C.email, C.telefone, C.sexo, C.linkedin, P.pais, E.estado, CD.cidade, C.datacoleta, C.dataaplicacao, C.linkedin_desatualizado, C.retornoinvitelkd, F.tipo AS 'favorito', FG.tipo AS 'favorito123', AB.tipo AS 'abordagem' FROM candidato C USE INDEX(idxcidade,idxestado,idxpais) LEFT JOIN pais P ON(C.idpais = P.idpais) LEFT JOIN estado E ON(C.idestado = E.idestado) LEFT JOIN cidade CD ON(C.idcidade = CD.idcidade) LEFT JOIN candidatocargo CC USE INDEX(idxcandidato, idxcargo) ON(C.idcandidato = CC.idcandidato) LEFT JOIN cargo CG ON(CC.idcargo = CG.idcargo) LEFT JOIN candidatovaga CV USE INDEX(idxcandidato, idxvaga) ON(C.idcandidato = CV.idcandidato) LEFT JOIN vaga V ON(V.idvaga = CV.idvaga) LEFT JOIN favorito F USE INDEX(idxcandidato, idxvaga) ON(C.idcandidato = F.idcandidato AND CV.idvaga = F.idvaga) LEFT JOIN avaliacao AV LEFT JOIN favoritogrupo FG USE INDEX(idxcandidato, idxvaga) ON(FG.idcandidato = CV.idcandidato AND FG.idvaga = CV.idvaga) USE INDEX(idxcandidato) ON(C.idcandidato = AV.idcandidato) LEFT JOIN abordagem AB USE INDEX(idxcandidato) ON(C.idcandidato = AB.idcandidato)";
				}
				else
				{
					return "SELECT DISTINCT C.idcandidato, C.nome, C.email, AV.* FROM candidato C USE INDEX(idxcidade,idxestado,idxpais) LEFT JOIN pais P ON(C.idpais = P.idpais) LEFT JOIN estado E ON(C.idestado = E.idestado) LEFT JOIN cidade CD ON(C.idcidade = CD.idcidade) LEFT JOIN candidatocargo CC USE INDEX(idxcandidato, idxcargo) ON(C.idcandidato = CC.idcandidato) LEFT JOIN cargo CG ON(CC.idcargo = CG.idcargo) LEFT JOIN candidatovaga CV USE INDEX(idxcandidato, idxvaga) ON(C.idcandidato = CV.idcandidato) LEFT JOIN vaga V ON(V.idvaga = CV.idvaga) LEFT JOIN favorito F USE INDEX(idxcandidato, idxvaga) ON(C.idcandidato = F.idcandidato AND CV.idvaga = F.idvaga) LEFT JOIN avaliacao AV USE INDEX(idxcandidato) ON(C.idcandidato = AV.idcandidato) LEFT JOIN abordagem AB USE INDEX(idxcandidato) ON(C.idcandidato = AB.idcandidato)";
				}
				
			}
			catch( Exception $e )
			{
				throw new Exception( $e );
				return $retorno;
			}
		}
		################################################################################################################
		public function GetSqlTotalLista($tipo = "geral")
		{
			$retorno = "";
			try
			{
				return "SELECT COUNT(DISTINCT C.idcandidato) AS CONT FROM candidato C USE INDEX(idxcidade,idxestado,idxpais) LEFT JOIN pais P ON(C.idpais = P.idpais) LEFT JOIN estado E ON(C.idestado = E.idestado) LEFT JOIN cidade CD ON(C.idcidade = CD.idcidade) LEFT JOIN candidatocargo CC USE INDEX(idxcandidato, idxcargo) ON(C.idcandidato = CC.idcandidato) LEFT JOIN cargo CG ON(CC.idcargo = CG.idcargo) LEFT JOIN candidatovaga CV USE INDEX(idxcandidato, idxvaga) ON(C.idcandidato = CV.idcandidato) LEFT JOIN vaga V ON(V.idvaga = CV.idvaga) LEFT JOIN favorito F USE INDEX(idxcandidato, idxvaga) ON(C.idcandidato = F.idcandidato AND CV.idvaga = F.idvaga) LEFT JOIN avaliacao AV USE INDEX(idxcandidato) ON(C.idcandidato = AV.idcandidato) LEFT JOIN favoritogrupo FG USE INDEX(idxcandidato, idxvaga) ON(FG.idcandidato = CV.idcandidato AND FG.idvaga = CV.idvaga) LEFT JOIN abordagem AB USE INDEX(idxcandidato) ON(C.idcandidato = AB.idcandidato)";
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
				$filtro .= " AND (C.nome LIKE '%{$buscar}%' OR C.email LIKE '%{$buscar}%' OR C.telefone LIKE '%{$buscar}%')";
			}
			$idcidade = GetFiltro("idcidade");
			if(!empty($idcidade))
			{
				$filtro .= " AND C.idcidade = '{$idcidade}'";
			}
			$idestado = GetFiltro("idestado");
			if(!empty($idestado))
			{
				$filtro .= " AND C.idestado = '{$idestado}'";
			}
			$idpais = GetFiltro("idpais");
			if(!empty($idpais))
			{
				$filtro .= " AND C.idpais = '{$idpais}'";
			}
			$favorito = GetFiltro("favorito");
			if(!empty($favorito))
			{
				if($favorito == "Não")
					$filtro .= " AND F.idfavorito IS NULL";
				else
					$filtro .= " AND F.idfavorito IS NOT NULL";
			}
			$favorito123 = GetFiltro("favorito123");
			if(!empty($favorito123))
			{
				if($favorito123 == "-1")
					$filtro .= " AND FG.idfavoritogrupo IS NULL";
				else
					$filtro .= " AND FG.tipo = '{$favorito123}'";
			}
			$idabordagem = GetFiltro("idabordagem");
			if(!empty($idabordagem))
			{
				if($idabordagem == "-1")
					$filtro .= " AND AB.idabordagem IS NULL";
				else
					$filtro .= " AND AB.tipo = '{$idabordagem}'";
			}
			$sexo = GetFiltro("sexo");
			if(!empty($sexo))
			{
				if($sexo == "-1")
					$filtro .= " AND ISNULL(NULLIF(C.sexo,'')) = 1";
				else
					$filtro .= " AND C.sexo = '{$sexo}'";
			}
			$idcargo = GetFiltro("idcargo");
			if(!empty($idcargo))
			{
				$filtro .= " AND CC.idcargo = '{$idcargo}'";
			}
			$nomeempresa = trim(GetFiltro("nomeempresa"));
			$idvaga = GetFiltro("idvaga");
			if(!empty($idvaga))
			{
				$filtro .= " AND CV.idvaga = '{$idvaga}'";
			}
			elseif(!empty($nomeempresa))
			{
				if($nomeempresa == "-1")
					$filtro .= " AND V.empresacontratante != ''";
				else
					$filtro .= " AND V.empresacontratante = '{$nomeempresa}'";
			}
			$linkedin_desatualizado = trim(GetFiltro("linkedin_desatualizado"));
			if(!empty($linkedin_desatualizado))
			{
				if($linkedin_desatualizado == "-1")
					$filtro .= " AND ISNULL(NULLIF(C.linkedin_desatualizado,'')) = 1";
				elseif($linkedin_desatualizado == "Sim")
					$filtro .= " AND C.linkedin_desatualizado = 'Sim'";
				else
					$filtro .= " AND C.linkedin_desatualizado = 'Não'";
			}
			$retornoinvitelkd = trim(GetFiltro("retornoinvitelkd"));
			if(!empty($retornoinvitelkd))
			{
				if($retornoinvitelkd == "Sim")
					$filtro .= " AND ISNULL(NULLIF(C.retornoinvitelkd,'')) = 0";
				elseif($retornoinvitelkd == "Não")
					$filtro .= " AND ISNULL(NULLIF(C.retornoinvitelkd,'')) = 1";
			}
			$avaliacao = GetFiltro("avaliacao");
			if(!empty($avaliacao))
			{
				if($avaliacao == "Com interesse")
				{
					$filtro .= " AND AV.interessemercado IN('Sim (estou buscando)','Depende (até considero avaliar)')";
				}
				elseif($avaliacao == "Sem interesse")
				{
					$filtro .= " AND AV.interessemercado = 'Sem interesse'";
				}
				elseif($avaliacao == "Sem resposta até o momento")
				{
					$filtro .= " AND AV.interessemercado = 'Sem resposta até o momento (mandei msg sem retorno)'";
				}
				elseif($avaliacao == "Telefone correto")
				{
					$filtro .= " AND AV.situacaotelefone = 'Telefone correto'";
				}
				elseif($avaliacao == "Telefone não pertence a pessoa")
				{
					$filtro .= " AND AV.situacaotelefone = 'Telefone não pertence a pessoa'";
				}
				elseif($avaliacao == "Telefone inexistente/incompleto")
				{
					$filtro .= " AND AV.situacaotelefone = 'Telefone inexistente/incompleto'";
				}
				elseif($avaliacao == "Candidatos avaliados")
				{
					$filtro .= " AND AV.idavaliacao IS NOT NULL";
				}
				elseif($avaliacao == "Com perfil técnico comportamental")
				{
					$filtro .= " AND AV.perfiltecnicocomportamental = 'Sim'";
				}
				elseif($avaliacao == "Sem perfil técnico comportamental")
				{
					$filtro .= " AND AV.perfiltecnicocomportamental = 'Não'";
				}
				elseif($avaliacao == "Linkedin atualizados")
				{
					$filtro .= " AND AV.linkedindesatualizado != 'Sim'";
				}
				elseif($avaliacao == "Linkedin desatualizados")
				{
					$filtro .= " AND AV.linkedindesatualizado = 'Sim'";
				}
				elseif($avaliacao == "Candidatos declararam ter inglês fluente")
				{
					$filtro .= " AND AV.inglesdeclarado = 'Fluente'";
				}
				elseif($avaliacao == "Candidatos declararam ter inglês avançado")
				{
					$filtro .= " AND AV.inglesdeclarado = 'Avançado'";
				}
				elseif($avaliacao == "Candidatos declararam ter inglês intermediário")
				{
					$filtro .= " AND AV.inglesdeclarado = 'Intermediário'";
				}
				elseif($avaliacao == "Candidatos declararam ter inglês básico")
				{
					$filtro .= " AND AV.inglesdeclarado = 'Básico'";
				}
				elseif($avaliacao == "Candidatos declararam não ter inglês")
				{
					$filtro .= " AND AV.inglesdeclarado = 'Sem Inglês'";
				}
				else
				{
					$filtro .= " AND AV.idavaliacao IS NULL";
				}
			}
			$tipo = Get("tipo");
			if(!empty($tipo))
			{
				if($tipo != "geral")
				{
					$filtro .= " AND AV.idavaliacao IS NOT NULL";
				}		
			}
			$aux = GetFiltro("datacoletainicio");
			if(!emptyData($aux))
			{
				$data = date("Y-m-d", TimeData($aux));
				$filtro .= " AND C.datacoleta >= '{$data}'";
			}
			$aux = GetFiltro("datacoletafim");
			if(!emptyData($aux))
			{
				$data = date("Y-m-d", TimeData($aux));
				$filtro .= " AND C.datacoleta <= '{$data}'";
			}
			$aux = GetFiltro("dataaplicacaoinicio");
			if(!emptyData($aux))
			{
				$data = date("Y-m-d", TimeData($aux));
				$filtro .= " AND C.dataaplicacao >= '{$data}'";
			}
			$aux = GetFiltro("dataaplicacaofim");
			if(!emptyData($aux))
			{
				$data = date("Y-m-d", TimeData($aux));
				$filtro .= " AND C.dataaplicacao <= '{$data}'";
			}
			if(!empty($filtro))
			{
				$filtro  = substr($filtro, 4);
			}
			if($semOrder)
			{
				return $filtro;
			}
			
			$ordem = array('C.idcandidato', 'C.nome', 'C.email', 'C.telefone', 'CG.cargo', 'CD.cidade', 'C.datacoleta', 'C.dataaplicacao', 'C.idcandidato');
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
		public function Importar($posicao = 0, $limite = 0, $file = "", $idvaga = 0, $novo = "Não", $importarnovos = "Não")
		{
			$retorno = false;
			
			if(empty($file))
				return $retorno;
			
			$lista = $this->LerRows($posicao, $limite, $file);
			if(empty($lista))
				return $retorno;
			$obj = GetModelo("candidato");
			if(empty($obj))
				return $retorno;
			foreach ($lista as $key=>$linha)
			{
				$obj->SalvarListaCandidato($linha, $idvaga, $novo, $importarnovos);
			}
			return true;
		}
		################################################################################################################
		public function SalvarListaCandidato($dados = false, $idvaga = 0, $novo = "Não", $importarnovos = "Não")
		{
			if(empty($dados))
				return;
			$email = self::GetDadosChave($dados, array('email','Email','e-mail','E-mail','EMAIL','E-MAIL'));
			if(empty($email))
				return;
			$tipo = self::GetDadosChave($dados, array('lkd_tipo','LKD_tipo','lkd_Tipo','LKD_Tipo','lkd tipo','LKD tipo','LKD_TIPO','lkd TIPO'));
			$novo = false;
			$auxEmail = Escape($email);
			$auxTipo = Escape($tipo);
			$filtro = "email = '{$auxEmail}' AND tipo = '{$auxTipo}'";
			$obj = $this->FiltroObjeto($filtro);
			if(empty($obj))
			{
				$obj = $this->GetInstancia();
				$obj->email = $email;
				$obj->tipo = $tipo;
				$novo = true;
			}
			elseif($importarnovos == "Novos")
			{
				return;
			}
			$obj->idcurriculo = self::GetDadosChave($dados, array('ID','id','Id','idcurriculo','Idcurriculo','IDCURRICULO'));
			$obj->nome = self::GetDadosChave($dados, array('nome','Nome','NOME','LKD_Nome','LKD_nome','lkd_nome','LKD_NOME'));
			$obj->telefone = self::GetDadosChave($dados, array('telefone','Telefone','TELEFONE','LKD_Telefone','LKD_telefone','lkd_telefone','LKD_TELEFONE'));
			$obj->linkedin = self::GetDadosChave($dados, array('url','Url','URL','LKD_URL','LKD_url','lkd_Url'));
			//$obj->twitter = self::GetDadosChave($dados, array('twitter','Twitter','TWITTER','LKD_TWITTER','LKD_twitter','lkd_Twitter'));
			
			$datacoleta = self::GetDadosChave($dados, array('LKD_data_coleta','datacoleta','Datacoleta','DATACOLETA','LKD_Data coleta','lkd_data coleta','lkd_data_coleta','LKD_Data Coleta'));
			if(!emptyData($datacoleta))
				$obj->datacoleta = $datacoleta;
			$dataaplicacao = self::GetDadosChave($dados, array('LKD_data_aplicacao','dataaplicacao','Dataaplicacao','DATAAPLICACAO','LKD_Data aplicacao','lkd_data aplicacao','lkd_data_aplicacao','LKD_Data Aplicacao'));
			if(!emptyData($dataaplicacao))
				$obj->dataaplicacao = $dataaplicacao;
			

			$telefone_verificado = self::GetDadosChave($dados, array('telefone_verificado','telefone verificado','Telefone_verificado','Telefone Verificado','TELEFONE_VERIFICADO','TELEFONE VERIFICADO'));
			if(!empty($telefone_verificado))
			{
				$obj->telefone_verificado = $telefone_verificado;
				$obj->telefone = $telefone_verificado;
			}
			else
			{
				$obj->telefone = "";
			}

			$pais = self::GetDadosChave($dados, array('pais','país','Pais','País','PAIS','PAÍS','LKD_pais','lkd_pais','lkd_país','LKD_país'));
			if(empty($pais))
				$pais = "brasil";
			$estado = self::GetDadosChave($dados, array('estado','Estado','ESTADO','LKD_estado','lkd_estado','LKD_ESTADO'));
			$cidade = self::GetDadosChave($dados, array('cidade','Cidade','CIDADE','LKD_cidade','lkd_cidade','LKD_CIDADE'));
			
			$sexo = self::GetDadosChave($dados, array('sexo','Sexo','SEXO','LKD_sexo','lkd_sexo','LKD_SEXO','LKD_Sexo','Lkd_Sexo'));
			if(!empty($sexo))
			{
				if(strcasecmp($sexo,"F") == 0)
				{
					$sexo = "Feminino";
				}
				elseif(strcasecmp($sexo,"M") == 0)
				{
					$sexo = "Masculino";
				}
				$obj->sexo = $sexo;
			}
			
			$objCidade = self::NewCidade();
			$ids = $objCidade->LerDadosCidade($cidade, $estado, $pais);
			$obj->idpais = $ids['idpais'];
			$obj->idestado = $ids['idestado'];
			$obj->idcidade = $ids['idcidade'];
			$obj->Ajustar(true);
			$idcandidato = $obj->Salvar();
			if($novo)
			{
				$obj->idcandidato = $idcandidato;
			}
			$competencia = self::NewCandidatocompetencia();
			$competencia->SalvarListaCandidatocompetencia($dados, $obj->idcandidato);
			$cargo = self::NewCandidatocargo();
			$cargo->SalvarListaCandidatocargo($dados, $obj->idcandidato);
			$curso = self::NewCandidatocurso();
			$curso->SalvarListaCandidatocurso($dados, $obj->idcandidato);
			$idioma = self::NewCandidatoIdioma();
			$idioma->SalvarIdioma($dados, $obj->idcandidato);
			$avaliacao = self::NewAvaliacao();
			$avaliacao->SalvarListaAvaliacao($dados, $obj->idcandidato);
			if(!empty($idvaga))
			{
				$vaga = self::NewCandidatoVaga();
				$vaga->SalvarVaga($idvaga, $obj->idcandidato);
				$perfil = self::NewCandidatoperfil();
				$perfil->SalvarPerfil($dados, $idvaga, $obj->idcandidato);
				$toptalent = self::NewToptalent();
				$toptalent->SalvaTopTalent($dados, $idvaga, $obj->idcandidato);
				$favorito = self::NewFavorito();
				$favorito->SalvarFavoritoMarcar($dados, $idvaga, $obj->idcandidato);
				$interesse = self::NewCandidatointeresse();
				$interesse->SalvarInteresseMarcar($dados, $idvaga, $obj->idcandidato);
				$certificado = self::NewCandidatocertificado();
				$certificado->SalvarCandidatoCertificado($dados, $obj->idcandidato);
				if($novo == "Sim")
				{
					$candidatonovo = self::NewCandidatonovo();
					$candidatonovo->SalvarCandidatoNovo($idvaga, $obj->idcandidato);
				}
			}
			return;
		}
		################################################################################################################
		public function ExportarCandidato()
		{
			$posicao = Get("posicao", 0);
			$total = Get("total", 0);
			$file = Get("file");
			$tipo = Get("tipo", "geral");
			$limite = 500;
			$obj = GetModelo('candidato');
			
			if(empty($total))
			{
				$sqlTotal = $obj->GetSqlTotalLista($tipo);
				$filtro = $obj->Filtro(true);
				$total = $obj->TotalRegistro($filtro, $sqlTotal, false);
				if(empty($total))
				{
					$dados['sucesso'] = false;
					$dados['erro'] = __("Nenhum candidato foi encontrado no momento.");
				}
				else
				{
					$dados['sucesso'] = true;
					$dados['titulo'] = __("Processando Exportação");
					$dados['mensagem'] = __("Exportação de candidato está processando.");
					$dados['url'] = "";
					$dados['finalizado'] = false;
					$dados['file'] = $file;
					$dados['posicao'] = $posicao;
					$dados['total'] = $total;
				}
				return $dados;
			}
			$sql = $obj->GetSqlListaExport($tipo);
			$filtro = $obj->Filtro(true);
			if($tipo == "geral")
			{
				$filtro .= " ORDER BY C.idcandidato ASC";
				$filtro .= " LIMIT {$posicao},{$limite}";
				$funcao = "GetDadosExcel";
			}
			elseif($tipo == "geral antigo")
			{
				$filtro .= " ORDER BY C.idcandidato ASC";
				$filtro .= " LIMIT {$posicao},{$limite}";
				$funcao = "GetDadosExcel";
			}
			else
			{
				$filtro .= " ORDER BY C.idcandidato ASC";
				$filtro .= " LIMIT {$posicao},{$limite}";
				$funcao = "GetDadosExcelAvaliacao";
			}

			$objs = $obj->FiltroObjetos($filtro, $sql);
			if($objs)
			{
				if(empty($file))
					$file = $obj->GetNomeFile($tipo);
				$data = array(
					"file"=> $file,
					"lista"=>$objs,
					"posicao"=>$posicao,
					"total"=>$total,
					"html"=>false,
					"campos"=>$obj->GetNomesCampos($tipo),
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
					$dados['titulo'] = __("Exportação de candidato");
					$dados['mensagem'] = __("Exportação de candidato foi finalizada.<br/>O download se iniciará em instantes");
					$dados['url'] = site_url("candidato/baixarcandidato/{$file}");
					$dados['finalizado'] = true;
					$dados['file'] = $file;
					$dados['posicao'] = $posicao;
					$dados['total'] = $total;
				}
				else
				{
					$dados['titulo'] = __("Exportação de candidato");
					$dados['mensagem'] = __("Exportação de candidato está processando.");
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
				$dados['erro'] = __("Nenhum candidato foi encontrado.");
			}
			return $dados;
		}
		################################################################################################################
		public function ExportarCandidatoSite()
		{
			$obj = GetModelo("candidato");
			$idcliente = Get("idcliente", 0);
			$buscar = Get("buscar", "");
			$classificacao = Get("classificacao", "");
			$idcompetencia = Get("idcompetencia", "");
			$idvaga = Get("idvaga", 0);
			$favorito = Get("favorito", "");
			$favoritogrupo = Get("favoritogrupo", "");
			$interesse = Get("interesse", "");
			$tipobot = Get("tipobot", "");
			$idpais = Get("idpais", 0);
			$idestado = Get("idestado", 0);
			$idcidade = Get("idcidade", 0);			
			$idarea = Get("idarea", 0);
			$idsubarea = Get("idsubarea", 0);
			$idnivel = Get("idnivel", 0);
			$idsetor = Get("idsetor", 0);
			$idempresacargo = Get("idempresacargo", 0);
			$idtamanho = Get("idtamanho", 0);
			$idnacionalidade = Get("idnacionalidade", 0);
			$ididioma = Get("ididioma", 0);
			$perfil = Get("perfil", 0);
			$sexo = Get("sexo", 0);
			$setorcargo = Get("setorcargo", "Todos");
			$avaliados = Get("avaliados", "");
			$acaocandidato = Get("acaocandidato", "");
			$empresacargo = Get("empresacargo", "Todos");
			$idestadonaodisponivel = Get("idestadonaodisponivel", 0);
			$idcidadenaodisponivel = Get("idcidadenaodisponivel", 0);
			$idareanaodisponivel = Get("idareanaodisponivel", 0);
			$idsubareanaodisponivel = Get("idsubareanaodisponivel", 0);
			$idnivelnaodisponivel = Get("idnivelnaodisponivel", 0);
			$perfilnaodisponivel = Get("perfilnaodisponivel", 0);
			$dataaplicacaonaodisponivel = Get("dataaplicacaonaodisponivel", 0);
			$idtamanhonaodisponivel = Get("idtamanhonaodisponivel", 0);
			$idnacionalidadenaodisponivel = Get("idnacionalidadenaodisponivel", 0);
			$ididiomanaodisponivel = Get("ididiomanaodisponivel", 0);			
			$sexonaodisponivel = Get("sexonaodisponivel", 0);
			$contatos = Get("contatos", false);
			$toptalent = Get("toptalent", false);
			$dataaplicacao = Get("dataaplicacao", false);

			$posicao = Get("posicao", 0);
			$limite = 100;
			$total = Get("total", 0);
			$file = Get("file", 0);
			
			$filtro = "";
					
			$sqlToptalent = ", IF(T.idcandidato IS NULL, 'Não', 'Sim') AS toptalent";
			$sqlInteresse = ", IF(CIT.idcandidatointeresse IS NULL, 'Não', 'Sim') AS interesse";
			$sqlFavorito = ", IF(F.idfavorito IS NULL OR F.tipo = 'Desconsiderado', 'Não', 'Sim') AS favorito, IF(F.idfavorito IS NULL OR F.tipo = 'Favorito', 'Não', 'Sim') AS desconsiderado, FG.tipo AS 'favoritogrupo'";
			$joinToptalent = " LEFT JOIN toptalent T USE INDEX(idxcandidato, idxvaga) ON(T.idcandidato = C.idcandidato AND T.idvaga = V.idvaga)";
			$joinFavorito = "";
			$joinInteresse = " LEFT JOIN candidatointeresse CIT USE INDEX(idxcandidato) ON(C.idcandidato = CIT.idcandidato AND CIT.idvaga = V.idvaga)";

			$sqlAvaliador = ", A.idavaliacao, A.salariofixomensal, A.interessemercado, A.finalista, A.placement ";
			$joinAvaliador = " LEFT JOIN avaliacao A USE INDEX(idxcandidato) ON(C.idcandidato = A.idcandidato)";

			if(!empty($idcliente))
			{
				if(!E_Cliente($idcliente))
				{
					$dados['sucesso'] = false;
					$dados['erro'] = __("ID do cliente não foi enviado.");
					return $dados;
				}
				$filtro .= " 1 ";
			}
			else
			{
				$dados['sucesso'] = false;
				$dados['erro'] = __("ID do cliente não foi enviado.");
				return $dados;
			}
			if(!empty($buscar))
			{
				$filtro .= " AND (C.nome LIKE '%{$buscar}%' OR CG.cargo LIKE '%{$buscar}%' OR EC.empresa LIKE '%{$buscar}%' OR CC.descricao LIKE '%{$buscar}%')";
			}
			if(!empty($idcompetencia))
			{
				$filtro .= " AND CCT.idcompetencia ".GerarIN($idcompetencia);
			}
			if(!empty($idvaga))
			{
				$filtro .= " AND CV.idvaga ".GerarIN($idvaga);
				$sqlIdvaga = ", CV.idvaga";
				$joinFavorito = " LEFT JOIN favorito F USE INDEX(idxcandidato) ON(C.idcandidato = F.idcandidato AND CV.idvaga = F.idvaga)";			
				$joinFavorito .= " LEFT JOIN favoritogrupo FG USE INDEX(idxcandidato) ON(C.idcandidato = FG.idcandidato AND FG.idvaga = V.idvaga)";
				$sqlPerfil = ", IF(ISNULL(NULLIF(CP.perfil,'')) = 1, '', CP.perfil) AS perfil";
				$joinPerfil = " LEFT JOIN candidatoperfil CP USE INDEX(idxcandidato, idxvaga) ON(C.idcandidato = CP.idcandidato AND CV.idvaga = CP.idvaga)";
			}
			else
			{
				$sqlFavorito = ", 'Não' AS favorito, '' AS favoritogrupo";
				$sqlIdvaga = "";
				$joinFavorito = "";
				$sqlPerfil = ", '' AS perfil";
				$joinPerfil = "";
			}
			if(!empty($toptalent))
			{
				$aux = $toptalent[0];
				if($aux == "Sim")
					$filtro .= " AND T.idcandidato IS NOT NULL ";
			}
			if(!empty($favorito))
			{
				$aux = $favorito[0];
				if($aux == "Sim")
					$filtro .= " AND F.tipo = 'Favorito' ";
				elseif($aux == "Desconsiderado")
					$filtro .= " AND F.tipo = 'Desconsiderado' ";
				elseif($aux == "Nao_Avaliado")
					$filtro .= " AND F.idfavorito IS NULL ";
			}
			elseif(!empty($idvaga))
			{
				$filtro .= " AND (F.idfavorito IS NULL OR F.tipo = 'Favorito')";
			}			
			if(!empty($interesse))
			{
				$aux = $interesse[0];
				if($aux == "Sim")
					$filtro .= " AND CIT.idcandidatointeresse IS NOT NULL ";
				else
					$filtro .= " AND CIT.idcandidatointeresse IS NULL ";
			}
			if(!empty($contatos))
			{
				foreach($contatos as $contato)
				{
					switch($contato)
					{
						case "email":
							$filtro .= " AND ISNULL(NULLIF(C.email,'')) = 0 AND C.email NOT LIKE '%@habu.com.br%' AND ISNULL(NULLIF(C.telefone,'')) = 1";
							break;
						case "emailhabu":
							$filtro .= " AND ISNULL(NULLIF(C.email,'')) = 0 AND C.email LIKE '%@habu.com.br%'";
							break;
						case "telefone":
							$filtro .= " AND ISNULL(NULLIF(C.telefone,'')) = 0";
							break;
						case "linkedin":
							$filtro .= " AND ISNULL(NULLIF(C.linkedin,'')) = 0";
							break;
						case "twitter":
							$filtro .= " AND ISNULL(NULLIF(C.twitter,'')) = 0";
							break;						
					}
				}
			}
			if(!empty($tipobot))
			{
				$filtro .= " AND CB.tipo ".GerarIN($tipobot);
			}
			if(!empty($idpais))
			{
				$filtro .= " AND C.idpais ".GerarIN($idpais);
			}
			if(!empty($idestado))
			{
				if(!empty($idestadonaodisponivel))
				{
					$filtro .= " AND (C.idestado = '0' OR C.idestado ".GerarIN($idestado).")";
				}
				else
				{
					$filtro .= " AND C.idestado ".GerarIN($idestado);
				}
			}
			elseif(!empty($idestadonaodisponivel))
			{
				$filtro .= " AND C.idestado = '0'";
			}
			if(!empty($idcidade))
			{
				if(!empty($idcidadenaodisponivel))
				{
					$filtro .= " AND (C.idcidade = '0' OR C.idcidade ".GerarIN($idcidade).")";
				}
				else
				{
					$filtro .= " AND C.idcidade ".GerarIN($idcidade);
				}
			}
			elseif(!empty($idcidadenaodisponivel))
			{
				$filtro .= " AND C.idcidade = '0'";
			}
			if(!empty($idarea))
			{
				if(!empty($idareanaodisponivel))
				{
					$filtro .= " AND (CC.idarea = '0' OR CC.idarea ".GerarIN($idarea).") AND CC.historico = 'Cargo 1'";
				}
				else
				{
					$filtro .= " AND CC.idarea ".GerarIN($idarea)." AND CC.historico = 'Cargo 1'";
				}
			}
			elseif(!empty($idareanaodisponivel))
			{
				$filtro .= " AND CC.idarea = '0' AND CC.historico = 'Cargo 1'";
			}
			if(!empty($idsubarea))
			{
				if(!empty($idsubareanaodisponivel))
				{
					$filtro .= " AND (CC.idsubarea = '0' OR CC.idsubarea ".GerarIN($idsubarea).") AND CC.historico = 'Cargo 1'";
				}
				else
				{
					$filtro .= " AND CC.idsubarea ".GerarIN($idsubarea)." AND CC.historico = 'Cargo 1'";;
				}
			}
			elseif(!empty($idsubareanaodisponivel))
			{
				$filtro .= " AND CC.idsubarea = '0' AND CC.historico = 'Cargo 1'";
			}
			if(!empty($idnivel))
			{
				if(!empty($idnivelnaodisponivel))
				{
					$filtro .= " AND (CC.idnivel = '0' OR CC.idnivel ".GerarIN($idnivel).") AND CC.historico = 'Cargo 1'";
				}
				else
				{
					$filtro .= " AND CC.idnivel ".GerarIN($idnivel)." AND CC.historico = 'Cargo 1'";;
				}
			}
			elseif(!empty($idnivelnaodisponivel))
			{
				$filtro .= " AND CC.idnivel = '0' AND CC.historico = 'Cargo 1'";
			}
			if(!empty($idsetor))
			{
				if($setorcargo == "Atual")
					$filtro .= " AND CC.idsetor ".GerarIN($idsetor)." AND CC.atual = 'Sim'";
				elseif($setorcargo == "Anterior")
					$filtro .= " AND CC.idsetor ".GerarIN($idsetor)." AND CC.atual != 'Sim'";
				else
					$filtro .= " AND CC.idsetor ".GerarIN($idsetor);
			}
			if(!empty($idempresacargo))
			{
				if($empresacargo == "Atual")
					$filtro .= " AND CC.idempresacargo ".GerarIN($idempresacargo)." AND CC.atual = 'Sim'";
				elseif($empresacargo == "Anterior")
					$filtro .= " AND CC.idempresacargo ".GerarIN($idempresacargo)." AND CC.atual != 'Sim'";
				else
					$filtro .= " AND CC.idempresacargo ".GerarIN($idempresacargo);
			}			
			if(!empty($idtamanho))
			{
				if(!empty($idtamanhonaodisponivel))
				{
					$filtro .= " AND (CC.idtamanho = '0' OR CC.idtamanho ".GerarIN($idtamanho).") AND CC.historico = 'Cargo 1'";
				}
				else
				{
					$filtro .= " AND CC.idtamanho ".GerarIN($idtamanho)." AND CC.historico = 'Cargo 1'";;
				}
			}
			elseif(!empty($idtamanhonaodisponivel))
			{
				$filtro .= " AND CC.idtamanho = '0' AND CC.historico = 'Cargo 1'";
			}
			if(!empty($idnacionalidade))
			{
				if(!empty($idnacionalidadenaodisponivel))
				{
					$filtro .= " AND (CC.idnacionalidade = '0' OR CC.idnacionalidade ".GerarIN($idnacionalidade).") AND CC.historico = 'Cargo 1'";
				}
				else
				{
					$filtro .= " AND CC.idnacionalidade ".GerarIN($idnacionalidade)." AND CC.historico = 'Cargo 1'";;
				}
			}
			elseif(!empty($idnacionalidadenaodisponivel))
			{
				$filtro .= " AND CC.idnacionalidade = '0' AND CC.historico = 'Cargo 1'";
			}
			if(!empty($ididioma))
			{
				if(!empty($ididiomanaodisponivel))
				{
					$filtro .= " AND (CI.idcandidatoidioma IS NULL OR CI.ididioma ".GerarIN($ididioma).")";
				}
				else
				{
					$filtro .= " AND CI.ididioma ".GerarIN($ididioma)." ";;
				}
			}
			elseif(!empty($ididiomanaodisponivel))
			{
				$filtro .= " AND CI.idcandidatoidioma IS NULL ";
			}
			if(!empty($perfil))
			{
				if(!empty($perfilnaodisponivel))
				{
					$filtro .= " AND (ISNULL(NULLIF(CP.perfil,'')) = 1 OR CP.perfil ".GerarIN($perfil).")";
				}
				else
				{
					$filtro .= " AND CP.perfil ".GerarIN($perfil);
				}
				if(empty($sqlPerfil))
					$sqlPerfil = ", IF(ISNULL(NULLIF(CP.perfil,'')) = 1, '', CP.perfil) AS perfil";
				if(empty($joinPerfil))
					$joinPerfil = " LEFT JOIN candidatoperfil CP USE INDEX(idxcandidato, idxvaga) ON(C.idcandidato = CP.idcandidato AND CV.idvaga = CP.idvaga)";
			}
			elseif(!empty($perfilnaodisponivel))
			{
				$filtro .= " AND ISNULL(NULLIF(CP.perfil,'')) = 1";
				if(empty($sqlPerfil))
					$sqlPerfil = ", IF(ISNULL(NULLIF(CP.perfil,'')) = 1, '', CP.perfil) AS perfil";
				if(empty($joinPerfil))
					$joinPerfil = " LEFT JOIN candidatoperfil CP USE INDEX(idxcandidato, idxvaga) ON(C.idcandidato = CP.idcandidato AND CV.idvaga = CP.idvaga)";
			}
			
			if(!empty($sexo))
			{
				if(!empty($sexonaodisponivel))
				{
					$filtro .= " AND ((ISNULL(NULLIF(C.sexo,'')) = 1) OR C.sexo ".GerarIN($sexo).")";
				}
				else
				{
					$filtro .= " AND C.sexo ".GerarIN($sexo);
				}
			}
			elseif(!empty($sexonaodisponivel))
			{
				$filtro .= " AND ISNULL(NULLIF(C.sexo,'')) = 1";
			}
			if(!empty($avaliados))
			{
				$aux = $avaliados[0];
				if($aux == "Sim")
				{
					$filtro .= " AND A.idavaliacao IS NOT NULL";
				}
				elseif($aux == "Não")
				{
					$filtro .= " AND A.idavaliacao IS NULL";
				}
				elseif($aux == "Cominteresse")
				{
					$filtro .= " AND A.interessemercado IN('Sim (estou buscando)','Depende (até considero avaliar)')";
				}
				elseif($aux == "Seminteresse")
				{
					$filtro .= " AND A.interessemercado = 'Sem interesse'";
				}
				elseif($aux == "Telefoneinexistente")
				{
					$filtro .= " AND A.situacaotelefone = 'Telefone inexistente/incompleto'";
				}
				elseif($aux == "Finalista")
				{
					$filtro .= " AND A.finalista = 'Sim'";
				}
				elseif($aux == "Placement")
				{
					$filtro .= " AND A.placement = 'Sim'";
				}
				else
				{
					$filtro .= " AND A.idavaliacao IS NULL";
				}
			}
			if(!empty($acaocandidato))
			{
				$index = array_search("Não", $acaocandidato);
				if($index === false)
					$filtro .= " AND CCO.tipo ".GerarIN($acaocandidato);
				else
				{
					unset($acaocandidato[$index]);
					if(count($acaocandidato) == 0)
						$filtro .= " AND CCO.idcandidatocontato IS NULL";
					else
						$filtro .= " AND (CCO.tipo ".GerarIN($acaocandidato)." OR CCO.idcandidatocontato IS NULL)";
				}
				$joinCandidatoContato = " LEFT JOIN candidatocontato CCO USE INDEX(idxcandidato, idxvaga) ON(CCO.idcandidato = CV.idcandidato AND CV.idvaga = CCO.idvaga)";
			}
			else
			{
				$joinCandidatoContato = "";
			}			
			if(!empty($favoritogrupo))
			{
				foreach($favoritogrupo as $item)
				{
					switch($item)
					{
						case "Favorito1":
							$filtro .= " AND FG.tipo = 'Favorito 1'";
							break;
						case "Favorito2":
							$filtro .= " AND FG.tipo = 'Favorito 2'";
							break;											
						case "Favorito3":
							$filtro .= " AND FG.tipo = 'Favorito 3'";
							break;											
						case "Nao Avaliado":
							$filtro .= " AND FG.idfavoritogrupo IS NULL";
							break;
					}
				}
			}
			if(!empty($dataaplicacao))
			{
				$filtroaplicacao = "";
				foreach ($dataaplicacao as $key=>$aplicacao)
				{
					if($aplicacao == "1")
						$aux = " C.dataaplicacao >= ADDDATE(CURDATE(),INTERVAL -30 DAY) ";
					elseif($aplicacao == "2")
						$aux = " (C.dataaplicacao < ADDDATE(CURDATE(),INTERVAL -30 DAY) AND C.dataaplicacao >= ADDDATE(CURDATE(),INTERVAL -90 DAY)) ";
					elseif($aplicacao == "3")
						$aux = " (C.dataaplicacao < ADDDATE(CURDATE(),INTERVAL -90 DAY) AND C.dataaplicacao >= ADDDATE(CURDATE(),INTERVAL -180 DAY)) ";
					else
						$aux = " C.dataaplicacao < ADDDATE(CURDATE(),INTERVAL -180 DAY) ";
					if(empty($key))
					{
						$filtroaplicacao .= "{$aux}";
					}
					else
					{
						$filtroaplicacao .= " OR {$aux}";
					}
				}
				if(!empty($dataaplicacaonaodisponivel))
				{
					$filtro .= " AND (ISNULL(NULLIF(C.dataaplicacao,'0000-00-00')) = 1 OR {$filtroaplicacao})";
				}
				else
				{
					$filtro .= " AND (ISNULL(NULLIF(C.dataaplicacao,'0000-00-00')) = 0 AND ({$filtroaplicacao}))";
				}
			}
			elseif(!empty($dataaplicacaonaodisponivel))
			{
				$filtro .= " AND ISNULL(NULLIF(C.dataaplicacao,'0000-00-00')) = 1";
			}
			
			if(empty($total))
			{
				$sqlTotal = "SELECT COUNT(DISTINCT C.idcandidato) AS CONT FROM candidato C USE INDEX( idxcidade, idxestado, idxpais) LEFT JOIN pais P ON(C.idpais = P.idpais) LEFT JOIN estado E ON(C.idestado = E.idestado) LEFT JOIN cidade CD ON(C.idcidade = CD.idcidade) LEFT JOIN candidatocargo CC USE INDEX(idxcandidato, idxcargo, idxempresacargo) ON(C.idcandidato = CC.idcandidato) LEFT JOIN cargo CG ON(CC.idcargo = CG.idcargo) LEFT JOIN empresacargo EC ON(CC.idempresacargo = EC.idempresacargo) LEFT JOIN candidatocompetencia CCT USE INDEX(idxcandidato) ON(C.idcandidato = CCT.idcandidato) LEFT JOIN candidatobot CB USE INDEX(idxcandidato) ON(C.idcandidato = CB.idcandidato) INNER JOIN candidatovaga CV USE INDEX(idxcandidato, idxvaga) ON(C.idcandidato = CV.idcandidato) LEFT JOIN candidatoidioma CI USE INDEX(idxcandidato, idxidioma) ON(CI.idcandidato = CV.idcandidato) INNER JOIN vaga V ON(CV.idvaga = V.idvaga){$joinFavorito}{$joinPerfil}{$joinToptalent}{$joinInteresse}{$joinAvaliador}{$joinCandidatoContato} WHERE {$filtro}";

				$total = $obj->TotalRegistro(false, $sqlTotal, false);
				if(empty($total))
				{
					$dados['sucesso'] = false;
					$dados['erro'] = __("Nenhum candidato foi encontrado no momento.");
				}
				else
				{
					$dados['sucesso'] = true;
					$dados['titulo'] = __("Processando Exportação");
					$dados['mensagem'] = __("Exportação de candidato está processando.");
					$dados['url'] = "";
					$dados['finalizado'] = false;
					$dados['file'] = $file;
					$dados['posicao'] = $posicao;
					$dados['total'] = $total;
				}
				return $dados;
			}
			$tipo = "vagas";
			$funcao = "GetDadosExcelVagas";
			$ordem = self::GetOrdem($classificacao);

			$filtro .= " ORDER BY {$ordem} LIMIT {$posicao}, {$limite}";
			$sql = "SELECT DISTINCT C.*{$sqlFavorito}{$sqlPerfil}{$sqlToptalent}{$sqlInteresse}{$sqlAvaliador}{$sqlIdvaga}, P.pais, E.estado, E.uf, CD.cidade FROM candidato C USE INDEX( idxcidade, idxestado, idxpais) LEFT JOIN pais P ON(C.idpais = P.idpais) LEFT JOIN estado E ON(C.idestado = E.idestado) LEFT JOIN cidade CD ON(C.idcidade = CD.idcidade) LEFT JOIN candidatocargo CC USE INDEX(idxcandidato, idxcargo, idxempresacargo) ON(C.idcandidato = CC.idcandidato) LEFT JOIN cargo CG ON(CC.idcargo = CG.idcargo) LEFT JOIN empresacargo EC ON(CC.idempresacargo = EC.idempresacargo) LEFT JOIN candidatocompetencia CCT USE INDEX(idxcandidato) ON(C.idcandidato = CCT.idcandidato) LEFT JOIN candidatobot CB USE INDEX(idxcandidato) ON(C.idcandidato = CB.idcandidato) INNER JOIN candidatovaga CV USE INDEX(idxcandidato, idxvaga) ON(C.idcandidato = CV.idcandidato) LEFT JOIN candidatoidioma CI USE INDEX(idxcandidato, idxidioma) ON(CI.idcandidato = CV.idcandidato) INNER JOIN vaga V ON(CV.idvaga = V.idvaga) {$joinFavorito}{$joinPerfil}{$joinToptalent}{$joinInteresse}{$joinAvaliador}{$joinCandidatoContato} WHERE {$filtro}";

			$objs = $obj->FiltroObjetos(false, $sql);
			if($objs)
			{
				if(empty($file))
					$file = $obj->GetNomeFile($tipo);
				$data = array(
					"file"=> $file,
					"lista"=>$objs,
					"posicao"=>$posicao,
					"total"=>$total,
					"html"=>false,
					"campos"=>$obj->GetNomesCampos($tipo),
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
					$dados['titulo'] = __("Exportação de candidato");
					$dados['mensagem'] = __("Exportação de candidato foi finalizada.<br/>O download se iniciará em instantes");
					$dados['url'] = site_url("api/baixarcandidato/{$file}");
					$dados['finalizado'] = true;
					$dados['file'] = $file;
					$dados['posicao'] = $posicao;
					$dados['total'] = $total;
				}
				else
				{
					$dados['titulo'] = __("Exportação de candidato");
					$dados['mensagem'] = __("Exportação de candidato está processando.");
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
				$dados['erro'] = __("Nenhum candidato foi encontrado.");
			}
			return $dados;
		}
		################################################################################################################
		public function GetNomeFile($tipo = "geral")
		{
			$retorno = "exportacaocandidato_".date("Y-m-d_H-i-s").".xls";
			try
			{
				if($tipo == "geral")
					return $retorno;
				elseif($tipo == "vagas")
					return "exportacaoCandidatos_Vagas_".date("Y-m-d_H-i-s").".xls";
				else
					return "exportacaoAvaliacaoCandidatos_".date("Y-m-d_H-i-s").".xls";
			}
			catch( Exception $e )
			{
				throw new Exception( $e );
				return $retorno;
			}
		}
		################################################################################################################
		public function GetNomesCampos($tipo = "geral")
		{
			if($tipo == "geral")
			{
				$campos = array(
					'LKD_Nome'=>'nome',
					'Email'=>'email',
					'LKD_Telefone'=>'telefone',
					'telefone_verificado'=>"telefone_verificado",
					'DOC_Telefone 1'=>'vazio',
					'DOC_Telefone 2'=>'vazio',
					'LKD_URL'=>'linkedin',
					'LKD_Sexo'=>'sexo'
				);
				for($i = 1; $i <= 6; $i++)
				{
					$campos["LKD_Empresa {$i}"] = "empresa {$i}";
					$campos["lkd-emp{$i}-depara"] = "vazio";
					$campos["LKD_Cargo {$i}"] = "cargo {$i}";
					$campos["LKD_Descrição {$i}"] = "descricao {$i}";
					$campos["LKD_Cargo{$i}_Area"] = "area {$i}";
					$campos["LKD_Cargo{$i}_Subarea"] = "subarea {$i}";
					$campos["LKD_Cargo{$i}_Nivel"] = "nivel {$i}";
					$campos["LKD_Setor {$i}"] = "setor {$i}";
					$campos["LKD_Tamanho {$i}"] = "tamanho {$i}";
					$campos["LKD_Nacionalidade {$i}"] = "nacionalidade {$i}";
					$campos["LKD_Início {$i}"] = "inicio {$i}";
					$campos["LKD_Término {$i}"] = "termino {$i}";
					$campos["LKD_duracao_{$i}"] = "duracao {$i}";
					$campos["LKD_empregado{$i}"] = "empregado {$i}";
				}
				/*for($i = 1; $i <= 4; $i++)
				{
					$campos["LKD_Instituicao {$i}"] = "lkd_instituicao_{$i}";
					$campos["LKD_Curso {$i}"] = "lkd_curso_{$i}";
					$campos["LKD_Início curso {$i}"] = "lkd_inicio_curso_{$i}";
					$campos["LKD_Término curso {$i}"] = "lkd_termino_curso_{$i}";
				}
				for($i = 1; $i <= 4; $i++)
				{
					$campos["Competência {$i}"] = "lkd_competencia_{$i}";
				}*/			
				for($i = 1; $i <= 4; $i++)
				{
					$campos["Idioma {$i}"] = "idioma_{$i}";
				}
				$campos["É aplicado"] = "vazio";
				$campos["toptalent"] = "toptalent";
				$campos["perfil"] = "perfil";
				$campos["favorito"] = "favorito";
				$campos["Favorito 123"] = "favoritogrupo";
				$campos["abordagem"] = "abordagem";
				$campos["interesse"] = "interesse";
				$campos["LKD_Twitter"] = "twitter";
				$campos["LKD_data_coleta"] = "datacoleta";
				$campos["LKD_data_aplicacao"] = "dataaplicacao";
				$campos["LKD_tipo"] = "vazio";
				$campos["Cidade"] = "cidade";
				$campos["Estado"] = "estado";
				$campos["Pais"] = "pais";
				$campos["linkedin_desatualizado"] = "linkedin_desatualizado";
				$campos["retornoinvitelkd"] = "retornoinvitelkd";
				$campos["coletar dados"] = "coletardados";
				$campos["tem anexo"] = "temanexo";
				$campos["tem celular"] = "temcelular";
				$campos["telefone_sobre"] = "telefone_sobre";
				$campos["telefone_sobre1"] = "telefone_sobre1";
				$campos["telefone_sobre2"] = "telefone_sobre2";
				$campos["tel_mapa"] = "tel_mapa";
				$campos["tel_ca"] = "tel_ca";
			}
			elseif($tipo == "geral antigo")
			{
				$campos = array(
					"ID" => "idcandidato",
					"nome" => "nome",
					"Email" => "email",
					"telefone" => "telefone",
					"linkedin" => "linkedin",
					"sexo" => "sexo",
					"cidade" => "cidade",
					"estado" => "estado",
					"pais" => "pais"
				);
				for($i = 1; $i <= 6; $i++)
				{
					$campos["cargo {$i}"] = "cargo {$i}";
					$campos["empresa {$i}"] = "empresa {$i}";
					$campos["inicio {$i}"] = "inicio {$i}";
					$campos["termino {$i}"] = "termino {$i}";
					$campos["atual {$i}"] = "atual {$i}";
				}
				$campos["linkedin_desatualizado"] = "linkedin_desatualizado";
				$campos["retornoinvitelkd"] = "retornoinvitelkd";
				$campos["vagas"] = "vagas";
				$campos["datacoleta"] = "datacoleta";
				$campos["dataaplicacao"] = "dataaplicacao";
			}
			elseif($tipo == "vagas")
			{
				$campos = array(
					"ID" => "idcandidato",
					"nome" => "nome",
					"cargo 1" => "cargo 1",
					"empresa 1" => "empresa 1",
					"Email" => "email",
					"telefone" => "telefone",
					"linkedin" => "linkedin",
					"Favorito" => "favorito",
					"Favorito 123" => "favoritogrupo",
					"abordagem" => "abordagem",
					"sexo" => "sexo",
					"cidade" => "cidade",
					"estado" => "estado",
					"pais" => "pais"
				);
				
				for($i = 1; $i <= 5; $i++)
				{
					$campos["idioma {$i}"] = "idioma {$i}";
				}
				
				for($i = 1; $i <= 4; $i++)
				{
					$campos["Ação Linkedin {$i}"] = "Ação Linkedin {$i}";
				}
				$campos["datacoleta"] = "datacoleta";
				$campos["dataaplicacao"] = "dataaplicacao";
			}
			else
			{
				$campos = array(
					"ID" => "idcandidato",
					"nome" => "nome",
					"Email" => "email"
				);
			}
			$vaga = GetModelo("vaga");
			$campos["avaliador"] = "cliente";
			$campos["interessemercado"] = "interessemercado";
			$campos["salariofixomensal"] = "salariofixomensal";
			$campos["bonusrealizadoanual"] = "bonusrealizadoanual";
			$campos["tipodecontratacao"] = "tipodecontratacao";
			$campos["situacaotelefone"] = "situacaotelefone";
			$campos["linkedindesatualizado"] = "linkedindesatualizado";
			$campos["avaliacaofinalista"] = "finalista";
			$campos["avaliacaoplacement"] = "placement";
			$campos["inglesdeclarado"] = "inglesdeclarado";
			$campos["preferenciamobilidade"] = "preferenciamobilidade";
			$campos["perfiltecnicocomportamental"] = "perfiltecnicocomportamental";
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
		public static function GetListaVagas($id = 0)
		{
			$retorno = false;
			try
			{
				if(empty($id))
					return $retorno;
				$obj = self::NewVaga();
				$sql = "SELECT V.idvaga, IF(V.empresacontratante = '', TRIM(V.titulodavaga), IF(V.titulodavaga = '',TRIM(V.empresacontratante), TRIM(CONCAT(V.titulodavaga,' (',V.empresacontratante,')')))) AS 'titulodavaga' FROM vaga V INNER JOIN candidatovaga CV ON(V.idvaga = CV.idvaga) WHERE CV.idcandidato = '{$id}' ORDER BY titulodavaga ASC";
				$rows = $obj->GetRows(false, $sql);
				if(!empty($rows))
				{
					return $rows;
				}
				return $retorno;
			}
			catch( Exception $e )
			{
				throw new Exception( $e );
				return $retorno;
			}
		}
		################################################################################################################
		public function &GetUtimoCargo($idcandidato = 0)
		{
			$retorno = false;
			try
			{
				if(empty($idcandidato))
					return $retorno;
				$sql = "SELECT CC.historico, C.cargo, CG.empresa FROM candidatocargo CC USE INDEX(idxcandidato, idxcargo, idxempresacargo) INNER JOIN cargo C ON(CC.idcargo = C.idcargo) INNER JOIN empresacargo CG ON(CC.idempresacargo = CG.idempresacargo) WHERE CC.idcandidato = '{$idcandidato}' ORDER BY CC.historico ASC LIMIT 1";
				$row = $this->GetRow(false, $sql);
				return $row;
			}
			catch( Exception $e )
			{
				throw new Exception( $e );
			}
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
				if(!emptyData($dados['datacoleta']))
					$dados['datacoleta'] = date("d/m/Y", TimeData($dados['datacoleta']));
				else
					$dados['datacoleta'] = "";
				if(!emptyData($dados['dataaplicacao']))
					$dados['dataaplicacao'] = date("d/m/Y", TimeData($dados['dataaplicacao']));
				else
					$dados['dataaplicacao'] = "";
				$dados['vagas'] = self::GetListaVagas($dados['idcandidato']);
				if(!empty($dados['telefone_verificado']))
				{
					$dados['telefone'] = $dados['telefone_verificado'];
				}
				$row = $this->GetUtimoCargo($dados['idcandidato']);
				if(!empty($row))
				{
					$dados['historico'] = $row['historico'];
					$dados['cargo'] = $row['cargo'];
					$dados['empresa'] = $row['empresa'];
				}
				else
				{
					$dados['historico'] = "";
					$dados['cargo'] = "";
					$dados['empresa'] = "";
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
		public static function GetListaNomesVagas($id = 0)
		{
			$retorno = "";
			try
			{
				if(empty($id))
					return $retorno;
				$obj = self::NewCandidatoVaga();
				return $obj->GetListaDeVagas($id);
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
				$id = $dados['idcandidato'];
				if(!emptyData($dados['datacoleta']))
					$dados['datacoleta'] = date("d/m/Y", TimeData($dados['datacoleta']));
				else
					$dados['datacoleta'] = "";
				if(!emptyData($dados['dataaplicacao']))
					$dados['dataaplicacao'] = date("d/m/Y", TimeData($dados['dataaplicacao']));
				else
					$dados['dataaplicacao'] = "";
				
				$cargo = self::NewCandidatocargo();
				$cargos = $cargo->GetListaDeCargos($id);
				if(!empty($cargos))
				{
					foreach($cargos as $key=>$row)
					{
						$aux = $key + 1;					
						$dados["cargo {$aux}"] = $row["cargo"];
						$dados["empresa {$aux}"] = $row["empresa"];
						$dados["duracao {$aux}"] = $row["duracao"];
						$dados["inicio {$aux}"] = $row["inicio"];
						$dados["termino {$aux}"] = $row["termino"];
						$dados["empregado {$aux}"] = $row["atual"];
						$dados["descricao {$aux}"] = $row["descricao"];
						$dados["area {$aux}"] = $row["area"];
						$dados["subarea {$aux}"] = $row["subarea"];
						$dados["nivel {$aux}"] = $row["nivel"];
						$dados["setor {$aux}"] = $row["setor"];
						$dados["tamanho {$aux}"] = $row["tamanho"];
						$dados["nacionalidade {$aux}"] = $row["nacionalidade"];
					}
				}
				$idioma = self::NewCandidatoIdioma();
				$idiomas = $idioma->ListaDeIdiomas($id);
				if(!empty($idiomas))
				{
					foreach($idiomas as $key=>$row)
					{
						$aux = $key + 1;					
						$dados["idioma {$aux}"] = $row["idioma"];
					}
				}
				/*$competencia = self::NewCandidatocompetencia();
				$row['competencias'] = $competencia->ListaDeCompetencias($id);
				$bot = self::NewCandidatoBot();
				$row['bots'] = $bot->ListaDeBots($id);*/
				$dados['retornoinvitelkd'] = self::GetListaNomesVagas($id);				
				$dados['vagas'] = self::GetListaNomesVagas($id);
				
				$avaliacao = self::NewAvaliacao();
				$avaliacao->GetDadosDeAvaliacao($dados);
				$dados["coletardados"] = self::GetColetarDados($dados["datacoleta"]);
				$dados['vazio'] = "";
				return $dados;
			}
			catch( Exception $e )
			{
				throw new Exception( $e );
				return $retorno;
			}
		}
		################################################################################################################
		public function &GetDadosExcelAvaliacao(&$dados = false)
		{
			$retorno = false;
			try
			{
				if(empty($dados))
				{
					$dados = $this->GetDados();
				}
				
				$avaliacao = self::NewAvaliacao();
				$avaliacao->GetDadosDeAvaliacao($dados);
				return $dados;
			}
			catch( Exception $e )
			{
				throw new Exception( $e );
				return $retorno;
			}
		}
		################################################################################################################
		public function &GetDadosExcelVagas(&$dados = false)
		{
			$retorno = false;
			try
			{
				if(empty($dados))
				{
					$dados = $this->GetDados();
				}
				$id = $dados['idcandidato'];
				if(!emptyData($dados['datacoleta']))
					$dados['datacoleta'] = date("d/m/Y", TimeData($dados['datacoleta']));
				else
					$dados['datacoleta'] = "";
				if(!emptyData($dados['dataaplicacao']))
					$dados['dataaplicacao'] = date("d/m/Y", TimeData($dados['dataaplicacao']));
				else
					$dados['dataaplicacao'] = "";
				
				$cargo = self::NewCandidatocargo();
				$cargos = $cargo->GetListaDeCargos($id, 1);
				if(!empty($cargos))
				{
					foreach($cargos as $key=>$row)
					{
						$aux = $key + 1;					
						$dados["cargo {$aux}"] = $row["cargo"];
						$dados["empresa {$aux}"] = $row["empresa"];
					}
				}
				$idioma = self::NewCandidatoIdioma();
				$idiomas = $idioma->ListaDeIdiomas($id);
				if(!empty($idiomas))
				{
					foreach($idiomas as $key=>$row)
					{
						$aux = $key + 1;					
						$dados["idioma {$aux}"] = $row["idioma"];
					}
				}
				$avaliacao = self::NewAvaliacao();
				$avaliacao->GetDadosDeAvaliacao($dados);
				$icontato = self::NewCandidatocontato();
				$icontatos = $icontato->ListaDeContatosExportar($id);
				if(!empty($icontatos))
				{
					foreach($icontatos as $key=>$valor)
					{
						$aux = $key + 1;					
						$dados["Ação Linkedin {$aux}"] = $valor;
					}
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
		public function LerListaCandidatos()
		{
			$idcliente = Get("idcliente", 0);
			$buscar = Get("buscar", "");
			$classificacao = Get("classificacao", "");
			$idcompetencia = Get("idcompetencia", "");
			$idvaga = Get("idvaga", 0);
			$favorito = Get("favorito", "");
			$favoritogrupo = Get("favoritogrupo", "");
			$abordagem = Get("abordagem", "");
			$interesse = Get("interesse", "");
			$tipobot = Get("tipobot", "");
			$idpais = Get("idpais", 0);
			$idestado = Get("idestado", 0);
			$idcidade = Get("idcidade", 0);			
			$idarea = Get("idarea", 0);
			$idsubarea = Get("idsubarea", 0);
			$idnivel = Get("idnivel", 0);
			$idsetor = Get("idsetor", 0);
			$idempresacargo = Get("idempresacargo", 0);
			$idtamanho = Get("idtamanho", 0);
			$idnacionalidade = Get("idnacionalidade", 0);
			$ididioma = Get("ididioma", 0);
			$perfil = Get("perfil", 0);
			$sexo = Get("sexo", 0);
			$setorcargo = Get("setorcargo", "Todos");
			$avaliados = Get("avaliados", "");
			$acaocandidato = Get("acaocandidato", "");
			$acaolinkedin = Get("acaolinkedin", "");
			$empresacargo = Get("empresacargo", "Todos");
			$idestadonaodisponivel = Get("idestadonaodisponivel", 0);
			$idcidadenaodisponivel = Get("idcidadenaodisponivel", 0);
			$idareanaodisponivel = Get("idareanaodisponivel", 0);
			$idsubareanaodisponivel = Get("idsubareanaodisponivel", 0);
			$idnivelnaodisponivel = Get("idnivelnaodisponivel", 0);
			$perfilnaodisponivel = Get("perfilnaodisponivel", 0);
			$dataaplicacaonaodisponivel = Get("dataaplicacaonaodisponivel", 0);
			$idtamanhonaodisponivel = Get("idtamanhonaodisponivel", 0);
			$idnacionalidadenaodisponivel = Get("idnacionalidadenaodisponivel", 0);
			$ididiomanaodisponivel = Get("ididiomanaodisponivel", 0);			
			$sexonaodisponivel = Get("sexonaodisponivel", 0);
			$contatos = Get("contatos", false);
			$toptalent = Get("toptalent", false);
			$dataaplicacao = Get("dataaplicacao", false);

			$posicao = Get("posicao", 0);
			$limite = Get("limite", 10);
			$total = Get("total", 0);
			$totalgeral = Get("totalgeral", 0);
			$rows = false;
			$titulo = __("Erro");
			$mensagem = __("Nenhum candidato foi encontrado.");
			
			$filtro = "";
			$filtroTotal = "";
					
			$sqlToptalent = ", IF(T.idcandidato IS NULL, 'Não', 'Sim') AS toptalent";
			$sqlInteresse = ", IF(CIT.idcandidatointeresse IS NULL, 'Não', 'Sim') AS interesse";
			$sqlNovo = ", 'Não' AS novo";
			$sqlFavorito = ", IF(F.idfavorito IS NULL OR F.tipo = 'Desconsiderado', 'Não', 'Sim') AS favorito, IF(F.idfavorito IS NULL OR F.tipo = 'Favorito', 'Não', 'Sim') AS desconsiderado, FG.tipo AS 'favoritogrupo', AB.tipo AS 'abordagem'";
			$joinToptalent = " LEFT JOIN toptalent T USE INDEX(idxcandidato, idxvaga) ON(T.idcandidato = C.idcandidato AND T.idvaga = V.idvaga)";
			$joinFavorito = "";
			$joinInteresse = " LEFT JOIN candidatointeresse CIT USE INDEX(idxcandidato) ON(C.idcandidato = CIT.idcandidato AND CIT.idvaga = V.idvaga)";		
			$joinNovo = "";

			$acesso = GetAcesso("acesso");
			$sqlAvaliador = ", A.idavaliacao, A.salariofixomensal, A.interessemercado, A.finalista, A.placement, A.perfiltecnicocomportamental ";
			$joinAvaliador = " LEFT JOIN avaliacao A USE INDEX(idxcandidato) ON(C.idcandidato = A.idcandidato)";

			if(!empty($idcliente))
			{
				if(!E_Cliente($idcliente))
				{
					$dados['sucesso'] = false;
					$dados['erro'] = __("ID do cliente não foi enviado.");
					return $dados;
				}
				$filtro .= " 1 ";
				$filtroTotal .= " 1 ";
				//$filtro .= " V.idcliente = '{$idcliente}' ";
				//$filtroTotal .= " V.idcliente = '{$idcliente}' ";
			}
			else
			{
				$dados['sucesso'] = false;
				$dados['erro'] = __("ID do cliente não foi enviado.");
				return $dados;
			}
			if(!empty($buscar))
			{
				$filtro .= " AND (C.nome LIKE '%{$buscar}%' OR CG.cargo LIKE '%{$buscar}%' OR EC.empresa LIKE '%{$buscar}%' OR CC.descricao LIKE '%{$buscar}%')";
			}
			if(!empty($idcompetencia))
			{
				$filtro .= " AND CCT.idcompetencia ".GerarIN($idcompetencia);
			}
			if(!empty($idvaga))
			{
				$filtro .= " AND CV.idvaga ".GerarIN($idvaga);
				$filtroTotal .= " AND CV.idvaga ".GerarIN($idvaga);
				$sqlIdvaga = ", CV.idvaga";
				$joinFavorito = " LEFT JOIN favorito F USE INDEX(idxcandidato) ON(C.idcandidato = F.idcandidato AND CV.idvaga = F.idvaga)";
				$joinFavorito .= " LEFT JOIN favoritogrupo FG USE INDEX(idxcandidato) ON(C.idcandidato = FG.idcandidato AND FG.idvaga = V.idvaga)";
				$joinFavorito .= " LEFT JOIN abordagem AB USE INDEX(idxcandidato, idxvaga) ON(C.idcandidato = AB.idcandidato AND AB.idvaga = V.idvaga)";
				$sqlPerfil = ", IF(ISNULL(NULLIF(CP.perfil,'')) = 1, '', CP.perfil) AS perfil";
				$joinPerfil = " LEFT JOIN candidatoperfil CP USE INDEX(idxcandidato, idxvaga) ON(C.idcandidato = CP.idcandidato AND CV.idvaga = CP.idvaga)";
			}
			else
			{
				$sqlFavorito = ", 'Não' AS favorito";
				$sqlIdvaga = "";
				$joinFavorito = "";
				$sqlPerfil = ", '' AS perfil";
				$joinPerfil = "";
			}
			if(!empty($toptalent))
			{
				$aux = $toptalent[0];
				if($aux == "Sim")
					$filtro .= " AND T.idcandidato IS NOT NULL ";
			}
			if(!empty($favorito))
			{
				$aux = $favorito[0];
				if($aux == "Sim")
					$filtro .= " AND F.tipo = 'Favorito' ";
				elseif($aux == "Desconsiderado")
					$filtro .= " AND F.tipo = 'Desconsiderado' ";
				elseif(($aux == "Nao Avaliado")||($aux == "Nao_Avaliado"))
					$filtro .= " AND F.idfavorito IS NULL ";
			}
			elseif(!empty($idvaga))
			{
				$filtro .= " AND (F.idfavorito IS NULL OR F.tipo = 'Favorito')";
			}			
			if(!empty($interesse))
			{
				$aux = $interesse[0];
				if($aux == "Sim")
					$filtro .= " AND CIT.idcandidatointeresse IS NOT NULL ";
				else
					$filtro .= " AND CIT.idcandidatointeresse IS NULL ";
			}
			if(!empty($contatos))
			{
				foreach($contatos as $contato)
				{
					switch($contato)
					{
						case "email":
							$filtro .= " AND ISNULL(NULLIF(C.email,'')) = 0 AND C.email NOT LIKE '%@habu.com.br%' AND ISNULL(NULLIF(C.telefone,'')) = 1";
							break;
						case "emailhabu":
							$filtro .= " AND ISNULL(NULLIF(C.email,'')) = 0 AND C.email LIKE '%@habu.com.br%'";
							break;
						case "telefone":
							$filtro .= " AND ISNULL(NULLIF(C.telefone,'')) = 0";
							break;
						case "linkedin":
							$filtro .= " AND ISNULL(NULLIF(C.linkedin,'')) = 0";
							break;
						case "twitter":
							$filtro .= " AND ISNULL(NULLIF(C.twitter,'')) = 0";
							break;						
					}
				}
			}
			/*
			if(!empty($tipobot))
			{
				$filtro .= " AND CB.tipo ".GerarIN($tipobot);
			}*/
			if(!empty($idpais))
			{
				$filtro .= " AND C.idpais ".GerarIN($idpais);
			}
			if(!empty($idestado))
			{
				if(!empty($idestadonaodisponivel))
				{
					$filtro .= " AND (C.idestado = '0' OR C.idestado ".GerarIN($idestado).")";
				}
				else
				{
					$filtro .= " AND C.idestado ".GerarIN($idestado);
				}
			}
			elseif(!empty($idestadonaodisponivel))
			{
				$filtro .= " AND C.idestado = '0'";
			}
			if(!empty($idcidade))
			{
				if(!empty($idcidadenaodisponivel))
				{
					$filtro .= " AND (C.idcidade = '0' OR C.idcidade ".GerarIN($idcidade).")";
				}
				else
				{
					$filtro .= " AND C.idcidade ".GerarIN($idcidade);
				}
			}
			elseif(!empty($idcidadenaodisponivel))
			{
				$filtro .= " AND C.idcidade = '0'";
			}
			if(!empty($idarea))
			{
				if(!empty($idareanaodisponivel))
				{
					$filtro .= " AND (CC.idarea = '0' OR CC.idarea ".GerarIN($idarea).") AND CC.historico = 'Cargo 1'";
				}
				else
				{
					$filtro .= " AND CC.idarea ".GerarIN($idarea)." AND CC.historico = 'Cargo 1'";
				}
			}
			elseif(!empty($idareanaodisponivel))
			{
				$filtro .= " AND CC.idarea = '0' AND CC.historico = 'Cargo 1'";
			}
			if(!empty($idsubarea))
			{
				if(!empty($idsubareanaodisponivel))
				{
					$filtro .= " AND (CC.idsubarea = '0' OR CC.idsubarea ".GerarIN($idsubarea).") AND CC.historico = 'Cargo 1'";
				}
				else
				{
					$filtro .= " AND CC.idsubarea ".GerarIN($idsubarea)." AND CC.historico = 'Cargo 1'";;
				}
			}
			elseif(!empty($idsubareanaodisponivel))
			{
				$filtro .= " AND CC.idsubarea = '0' AND CC.historico = 'Cargo 1'";
			}
			if(!empty($idnivel))
			{
				if(!empty($idnivelnaodisponivel))
				{
					$filtro .= " AND (CC.idnivel = '0' OR CC.idnivel ".GerarIN($idnivel).") AND CC.historico = 'Cargo 1'";
				}
				else
				{
					$filtro .= " AND CC.idnivel ".GerarIN($idnivel)." AND CC.historico = 'Cargo 1'";;
				}
			}
			elseif(!empty($idnivelnaodisponivel))
			{
				$filtro .= " AND CC.idnivel = '0' AND CC.historico = 'Cargo 1'";
			}
			if(!empty($idsetor))
			{
				if($setorcargo == "Atual")
					$filtro .= " AND CC.idsetor ".GerarIN($idsetor)." AND CC.atual = 'Sim'";
				elseif($setorcargo == "Anterior")
					$filtro .= " AND CC.idsetor ".GerarIN($idsetor)." AND CC.atual != 'Sim'";
				else
					$filtro .= " AND CC.idsetor ".GerarIN($idsetor);
			}
			if(!empty($idempresacargo))
			{
				if($empresacargo == "Atual")
					$filtro .= " AND CC.idempresacargo ".GerarIN($idempresacargo)." AND CC.atual = 'Sim'";
				elseif($empresacargo == "Anterior")
					$filtro .= " AND CC.idempresacargo ".GerarIN($idempresacargo)." AND CC.atual != 'Sim'";
				else
					$filtro .= " AND CC.idempresacargo ".GerarIN($idempresacargo);
			}			
			if(!empty($idtamanho))
			{
				if(!empty($idtamanhonaodisponivel))
				{
					$filtro .= " AND (CC.idtamanho = '0' OR CC.idtamanho ".GerarIN($idtamanho).") AND CC.historico = 'Cargo 1'";
				}
				else
				{
					$filtro .= " AND CC.idtamanho ".GerarIN($idtamanho)." AND CC.historico = 'Cargo 1'";;
				}
			}
			elseif(!empty($idtamanhonaodisponivel))
			{
				$filtro .= " AND CC.idtamanho = '0' AND CC.historico = 'Cargo 1'";
			}
			if(!empty($idnacionalidade))
			{
				if(!empty($idnacionalidadenaodisponivel))
				{
					$filtro .= " AND (CC.idnacionalidade = '0' OR CC.idnacionalidade ".GerarIN($idnacionalidade).") AND CC.historico = 'Cargo 1'";
				}
				else
				{
					$filtro .= " AND CC.idnacionalidade ".GerarIN($idnacionalidade)." AND CC.historico = 'Cargo 1'";;
				}
			}
			elseif(!empty($idnacionalidadenaodisponivel))
			{
				$filtro .= " AND CC.idnacionalidade = '0' AND CC.historico = 'Cargo 1'";
			}
			if(!empty($ididioma))
			{
				if(!empty($ididiomanaodisponivel))
				{
					$filtro .= " AND (CI.idcandidatoidioma IS NULL OR CI.ididioma ".GerarIN($ididioma).")";
				}
				else
				{
					$filtro .= " AND CI.ididioma ".GerarIN($ididioma)." ";;
				}
			}
			elseif(!empty($ididiomanaodisponivel))
			{
				$filtro .= " AND CI.idcandidatoidioma IS NULL ";
			}
			if(!empty($perfil))
			{
				if(!empty($perfilnaodisponivel))
				{
					$filtro .= " AND (ISNULL(NULLIF(CP.perfil,'')) = 1 OR CP.perfil ".GerarIN($perfil).")";
				}
				else
				{
					$filtro .= " AND CP.perfil ".GerarIN($perfil);
				}
				if(empty($sqlPerfil))
					$sqlPerfil = ", IF(ISNULL(NULLIF(CP.perfil,'')) = 1, '', CP.perfil) AS perfil";
				if(empty($joinPerfil))
					$joinPerfil = " LEFT JOIN candidatoperfil CP USE INDEX(idxcandidato, idxvaga) ON(C.idcandidato = CP.idcandidato AND CV.idvaga = CP.idvaga)";
			}
			elseif(!empty($perfilnaodisponivel))
			{
				$filtro .= " AND ISNULL(NULLIF(CP.perfil,'')) = 1";
				if(empty($sqlPerfil))
					$sqlPerfil = ", IF(ISNULL(NULLIF(CP.perfil,'')) = 1, '', CP.perfil) AS perfil";
				if(empty($joinPerfil))
					$joinPerfil = " LEFT JOIN candidatoperfil CP USE INDEX(idxcandidato, idxvaga) ON(C.idcandidato = CP.idcandidato AND CV.idvaga = CP.idvaga)";
			}
			
			if(!empty($sexo))
			{
				if(!empty($sexonaodisponivel))
				{
					$filtro .= " AND ((ISNULL(NULLIF(C.sexo,'')) = 1) OR C.sexo ".GerarIN($sexo).")";
				}
				else
				{
					$filtro .= " AND C.sexo ".GerarIN($sexo);
				}
			}
			elseif(!empty($sexonaodisponivel))
			{
				$filtro .= " AND ISNULL(NULLIF(C.sexo,'')) = 1";
			}
			if(!empty($avaliados))
			{
				$aux = $avaliados[0];
				if($aux == "Sim")
				{
					$filtro .= " AND A.idavaliacao IS NOT NULL";
				}
				elseif($aux == "Não")
				{
					$filtro .= " AND A.idavaliacao IS NULL";
				}
				elseif($aux == "Cominteresse")
				{
					$filtro .= " AND A.interessemercado IN('Sim (estou buscando)','Depende (até considero avaliar)')";
				}
				elseif($aux == "Seminteresse")
				{
					$filtro .= " AND A.interessemercado = 'Sem interesse'";
				}
				elseif($aux == "Comperfil")
				{
					$filtro .= " AND A.perfiltecnicocomportamental = 'Sim'";
				}
				elseif($aux == "Semperfil")
				{
					$filtro .= " AND A.perfiltecnicocomportamental = 'Não'";
				}
				elseif($aux == "Telefoneinexistente")
				{
					$filtro .= " AND A.situacaotelefone = 'Telefone inexistente/incompleto'";
				}
				elseif($aux == "Finalista")
				{
					$filtro .= " AND A.finalista = 'Sim'";
				}
				elseif($aux == "Placement")
				{
					$filtro .= " AND A.placement = 'Sim'";
				}
				else
				{
					$filtro .= " AND A.idavaliacao IS NULL";
				}
			}
			if(!empty($acaocandidato))
			{
				$index = array_search("Não", $acaocandidato);
				if($index === false)
					$filtro .= " AND CCO.tipo ".GerarIN($acaocandidato);
				else
				{
					unset($acaocandidato[$index]);
					if(count($acaocandidato) == 0)
						$filtro .= " AND CCO.idcandidatocontato IS NULL";
					else
						$filtro .= " AND (CCO.tipo ".GerarIN($acaocandidato)." OR CCO.idcandidatocontato IS NULL)";
				}
				$joinCandidatoContato = " LEFT JOIN candidatocontato CCO USE INDEX(idxcandidato, idxvaga) ON(CCO.idcandidato = CV.idcandidato AND CV.idvaga = CCO.idvaga)";
			}
			else
			{
				$joinCandidatoContato = "";
			}
			if(!empty($acaolinkedin))
			{
				foreach($acaolinkedin as $acao)
				{
					switch($acao)
					{
						case "linkedindesatualizado":
							$filtro .= " AND C.linkedin_desatualizado = 'Sim'";
							break;
						case "nolinkedindesatualizado":
							$filtro .= " AND C.linkedin_desatualizado != 'Sim'";
							break;											
						case "retornoinvite":
							$filtro .= " AND ISNULL(NULLIF(C.retornoinvitelkd,'')) = 0";
							break;											
						case "noretornoinvite":
							$filtro .= " AND ISNULL(NULLIF(C.retornoinvitelkd,'')) = 1";
							break;
					}
				}
			}
			if(!empty($favoritogrupo))
			{
				foreach($favoritogrupo as $item)
				{
					switch($item)
					{
						case "Favorito1":
							$filtro .= " AND FG.tipo = 'Favorito 1'";
							break;
						case "Favorito2":
							$filtro .= " AND FG.tipo = 'Favorito 2'";
							break;											
						case "Favorito3":
							$filtro .= " AND FG.tipo = 'Favorito 3'";
							break;											
						case "Nao Avaliado":
							$filtro .= " AND FG.idfavoritogrupo IS NULL";
							break;
					}
				}
			}
			if(!empty($abordagem))
			{
				foreach($abordagem as $item)
				{
					switch($item)
					{
						case "Associado":
							$filtro .= " AND AB.tipo = 'Associado'";
							break;
						case "Researcher":
							$filtro .= " AND AB.tipo = 'Researcher'";
							break;
						case "Nao_Avaliado":
						case "Nao Avaliado":
							$filtro .= " AND AB.idabordagem IS NULL";
							break;
					}
				}
			}
			if(!empty($dataaplicacao))
			{
				$filtroaplicacao = "";
				foreach ($dataaplicacao as $key=>$aplicacao)
				{
					if($aplicacao == "1")
						$aux = " C.dataaplicacao >= ADDDATE(CURDATE(),INTERVAL -30 DAY) ";
					elseif($aplicacao == "2")
						$aux = " (C.dataaplicacao < ADDDATE(CURDATE(),INTERVAL -30 DAY) AND C.dataaplicacao >= ADDDATE(CURDATE(),INTERVAL -90 DAY)) ";
					elseif($aplicacao == "3")
						$aux = " (C.dataaplicacao < ADDDATE(CURDATE(),INTERVAL -90 DAY) AND C.dataaplicacao >= ADDDATE(CURDATE(),INTERVAL -180 DAY)) ";
					else
						$aux = " C.dataaplicacao < ADDDATE(CURDATE(),INTERVAL -180 DAY) ";
					if(empty($key))
					{
						$filtroaplicacao .= "{$aux}";
					}
					else
					{
						$filtroaplicacao .= " OR {$aux}";
					}
				}
				if(!empty($dataaplicacaonaodisponivel))
				{
					$filtro .= " AND (ISNULL(NULLIF(C.dataaplicacao,'0000-00-00')) = 1 OR {$filtroaplicacao})";
				}
				else
				{
					$filtro .= " AND (ISNULL(NULLIF(C.dataaplicacao,'0000-00-00')) = 0 AND ({$filtroaplicacao}))";
				}
			}
			elseif(!empty($dataaplicacaonaodisponivel))
			{
				$filtro .= " AND ISNULL(NULLIF(C.dataaplicacao,'0000-00-00')) = 1";
			}
			
			//$filtro .= " AND ISNULL(NULLIF(CC.descricao,'')) = 0";
			if(empty($total))
			{
				$sql = "SELECT COUNT(DISTINCT C.idcandidato) AS CONT FROM candidato C USE INDEX( idxcidade, idxestado, idxpais) LEFT JOIN pais P ON(C.idpais = P.idpais) LEFT JOIN estado E ON(C.idestado = E.idestado) LEFT JOIN cidade CD ON(C.idcidade = CD.idcidade) LEFT JOIN candidatocargo CC USE INDEX(idxcandidato, idxcargo, idxempresacargo) ON(C.idcandidato = CC.idcandidato) INNER JOIN cargo CG ON(CC.idcargo = CG.idcargo) LEFT JOIN empresacargo EC ON(CC.idempresacargo = EC.idempresacargo) LEFT JOIN candidatocompetencia CCT USE INDEX(idxcandidato) ON(C.idcandidato = CCT.idcandidato) INNER JOIN candidatovaga CV USE INDEX(idxcandidato, idxvaga) ON(C.idcandidato = CV.idcandidato) LEFT JOIN candidatoidioma CI USE INDEX(idxcandidato, idxidioma) ON(CI.idcandidato = CV.idcandidato) INNER JOIN vaga V ON(CV.idvaga = V.idvaga){$joinFavorito}{$joinPerfil}{$joinToptalent}{$joinInteresse}{$joinNovo}{$joinAvaliador}{$joinCandidatoContato} WHERE {$filtro}";
				$total = $this->TotalRegistro(false, $sql);				
			}
			if(empty($totalgeral))
			{
				if($filtro == $filtroTotal)
				{
					$totalgeral = $total;
				}
				else
				{
					$sql = "SELECT COUNT(DISTINCT C.idcandidato) AS CONT FROM candidato C USE INDEX( idxcidade, idxestado, idxpais) LEFT JOIN pais P ON(C.idpais = P.idpais) LEFT JOIN estado E ON(C.idestado = E.idestado) LEFT JOIN cidade CD ON(C.idcidade = CD.idcidade) LEFT JOIN candidatocargo CC USE INDEX(idxcandidato, idxcargo, idxempresacargo) ON(C.idcandidato = CC.idcandidato) INNER JOIN cargo CG ON(CC.idcargo = CG.idcargo) LEFT JOIN empresacargo EC ON(CC.idempresacargo = EC.idempresacargo) LEFT JOIN candidatocompetencia CCT USE INDEX(idxcandidato) ON(C.idcandidato = CCT.idcandidato) INNER JOIN candidatovaga CV USE INDEX(idxcandidato, idxvaga) ON(C.idcandidato = CV.idcandidato) LEFT JOIN candidatoidioma CI USE INDEX(idxcandidato, idxidioma) ON(CI.idcandidato = CV.idcandidato) INNER JOIN vaga V ON(CV.idvaga = V.idvaga){$joinFavorito}{$joinPerfil}{$joinToptalent}{$joinInteresse}{$joinNovo}{$joinAvaliador}{$joinCandidatoContato} WHERE {$filtroTotal}";
					$totalgeral = $this->TotalRegistro(false, $sql);
				}			
			}
			if($limite < 0)
				$limite = $total;
			if(!empty($total))
			{
				$ordem = self::GetOrdem($classificacao);

				$filtro .= " ORDER BY {$ordem} LIMIT {$posicao}, {$limite}";
				$sql = "SELECT DISTINCT C.*{$sqlFavorito}{$sqlPerfil}{$sqlToptalent}{$sqlInteresse}{$sqlNovo}{$sqlAvaliador}{$sqlIdvaga}, P.pais, E.estado, E.uf, CD.cidade FROM candidato C USE INDEX( idxcidade, idxestado, idxpais) LEFT JOIN pais P ON(C.idpais = P.idpais) LEFT JOIN estado E ON(C.idestado = E.idestado) LEFT JOIN cidade CD ON(C.idcidade = CD.idcidade) LEFT JOIN candidatocargo CC USE INDEX(idxcandidato, idxcargo, idxempresacargo) ON(C.idcandidato = CC.idcandidato) INNER JOIN cargo CG ON(CC.idcargo = CG.idcargo) LEFT JOIN empresacargo EC ON(CC.idempresacargo = EC.idempresacargo) LEFT JOIN candidatocompetencia CCT USE INDEX(idxcandidato) ON(C.idcandidato = CCT.idcandidato) INNER JOIN candidatovaga CV USE INDEX(idxcandidato, idxvaga) ON(C.idcandidato = CV.idcandidato) LEFT JOIN candidatoidioma CI USE INDEX(idxcandidato, idxidioma) ON(CI.idcandidato = CV.idcandidato) INNER JOIN vaga V ON(CV.idvaga = V.idvaga) {$joinFavorito}{$joinPerfil}{$joinToptalent}{$joinInteresse}{$joinNovo}{$joinAvaliador}{$joinCandidatoContato} WHERE {$filtro}";
				$rows = $this->GetRows(false, $sql);
				if(!empty($rows))
				{
					$rows = array_map(array($this,'Map'), $rows);
					$titulo = __("Sucesso");
					$mensagem = __("Lista de candidato foi encontrada com sucesso.");
				}
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
			$dados['posicao'] = $novaposicao;
			$dados['limite'] = intval($limite);
			$dados['total'] = intval($total);
			$dados['totalgeral'] = intval($totalgeral);
			$dados['finalizado'] = $finalizado;
			return $dados;
		}
		################################################################################################################
		public static function GetColetarDados($datacoleta = "")
		{
			if(emptyData($datacoleta))
			{
				return "Sim";				
			}
			$data = date("Y-m-d", DiaAdd($datacoleta, -45));
			$aux = date("Y-m-d");
			$limite = 45 * 60 * 60 * 24;
			if(ComparaData($aux, $data) <= $limite)
				return "Não";
			else
				return "Sim";
		}
		################################################################################################################
		public static function Map($row = false)
		{
			$row['idcandidato'] = intval($row['idcandidato']);
			$id = $row['idcandidato'];
			if(emptyData($row['datacoleta']))
			{
				$row['datacoleta'] = date("d/m/Y", TimeData($row['datacoleta']));				
			}
			else
			{
				$row['datacoleta'] = "";				
			}
			if(!emptyData($row['dataaplicacao']))
			{
				$row['dataaplicacao'] = date("Y-m-d 00:00:00", TimeData($row['dataaplicacao']));				
			}
			else
			{
				$row['dataaplicacao'] = "";				
			}
			if(empty($row['idavaliacao']))
				$row['idavaliacao'] = 0;
			
			if(empty($row['interessemercado']))
				$row['interessemercado'] = "Não";
				
			if(empty($row['placement']))
				$row['placement'] = "Não";
			
			if(empty($row['finalista']))
				$row['finalista'] = "Não"; 
			if(empty($row['retornoinvitelkd']))
				$row['retornoinvitelkd'] = ""; 
			if(empty($row['idvaga']))
				$row['idvaga'] = 0;
			else
				$row['idvaga'] = intval($row['idvaga']);

			if(empty($row['favoritogrupo']))
				$row['favoritogrupo'] = "";	

			if(empty($row['perfiltecnicocomportamental']))
				$row['perfiltecnicocomportamental'] = "";
				
			$row['salariofixomensal'] = floatval($row['salariofixomensal']);
			$vaga = self::NewCandidatoVaga();
			$row['vagas'] = $vaga->ListaDeVagas($id);
			$idioma = self::NewCandidatoIdioma();
			$row['idiomas'] = $idioma->ListaDeIdiomas($id);
			$cargo = self::NewCandidatocargo();
			$row['cargos'] = $cargo->ListaDeCargos($id);
			$row['dadosempresa']= $cargo->GetDadosCargoAtual($id);
			$competencia = self::NewCandidatocompetencia();
			$row['competencias'] = $competencia->ListaDeCompetencias($id);
			$certificado = self::NewCandidatocertificado();
			$row['certificados'] = $certificado->ListaDeCertificados($id);
			$icontato = self::NewCandidatocontato();
			$row['contatos'] = $icontato->ListaDeContatos($id, $row['idvaga']);
			$bot = self::NewCandidatoBot();
			$row['bots'] = $bot->ListaDeBots($id);
			$row['notasavaliacao'] = self::GetNotasAvaliacoes($id, $row['idavaliacao']);
			return $row;
		}
		################################################################################################################
		public static function GetNotasAvaliacoes($idcandidato = 0, $idavaliacao = 0)
		{
			$retorno = false;
			try
			{
				if(empty($idavaliacao))
				{
					return $retorno;
				}
				if(empty($idcandidato))
				{
					return $retorno;
				}
				$sql = "SELECT AC.titulo, AM.marcado AS 'valor' FROM avaliacaomarcado AM USE INDEX(idxavaliacaocompetencia, idxcandidato) INNER JOIN avaliacaocompetencia AC ON(AM.idavaliacaocompetencia = AC.idavaliacaocompetencia) WHERE AM.idcandidato = '{$idcandidato}' AND AM.idavaliacao = '{$idavaliacao}' AND AC.ativo = 'Sim' ORDER BY AC.ordem ASC";
				return self::GetSqlrows($sql, false);
			}
			catch( Exception $e )
			{
				throw new Exception( $e );
				return $retorno;
			}
		}
		################################################################################################################
		public static function GetOrdem($classificacao = "")
		{
			$ordem = "";
			$classificacao = strtolower($classificacao);
			switch($classificacao)
			{
				case "por nome em ordem crescente":
					$ordem = "C.nome ASC";
					break;
				case "por nome em ordem decrescente":
					$ordem = "C.nome DESC";
					break;
				case "por cidade em ordem crescente":
					$ordem = "CD.cidade ASC";
					break;
				case "por cidade em ordem decrescente":
					$ordem = "CD.cidade DESC";
					break;
				case "por data de aplicacao em ordem crescente":
					$ordem = "C.datacoleta DESC";
					break;
				case "por data de aplicacao em ordem decrescente":
					$ordem = "C.datacoleta ASC";
					break;
				case "por favorito em ordem crescente":
					$ordem = "favorito ASC";
					break;
				default:
					$ordem = "C.nome ASC";
				
			}
			return $ordem;
		}
		################################################################################################################
		public function LerOpcaoClassificacaoCandidatos()
		{
			$titulo = __("Sucesso");
			$mensagem = __("Lista de opções da classificação do candidatos.");
			$rows = array(
				array("texto"=>"Por nome A-Z", "valor"=>"por nome em ordem crescente"), 
				array("texto"=>"Por nome Z-A", "valor"=>"por nome em ordem decrescente"),
				//array("texto"=>"Por Favorito", "valor"=>"por favorito em ordem crescente"), 
				//array("texto"=>"Por cidade em ordem crescente", "valor"=>"por cidade em ordem crescente"), 
				//array("texto"=>"Por cidade em ordem decrescente", "valor"=>"por cidade em ordem decrescente"), 
				//array("texto"=>"Por data de aplicação do candidato em ordem crescente", "valor"=>"por data de aplicacao em ordem crescente"), 
				//array("texto"=>"Por data de aplicação do candidato em ordem decrescente", "valor"=>"por data de aplicacao em ordem decrescente")
			);	
			
			$dados['sucesso'] = true;
			$dados['opcoes'] = $rows;
			$dados['mensagem'] = $mensagem;
			$dados['titulo'] = $titulo;
			return $dados;
		}
		#######################################################################################################################
		function TemMaisdeVaga($idvaga = 0) {
			$id = $this->GetID();
			if(empty($id))
				return 0;
			if(empty($idvaga))
			{
				$sql = "SELECT COUNT(*) AS CONT FROM candidatovaga WHERE idcandidato = '{$id}'";
			}
			else
			{
				$sql = "SELECT COUNT(*) AS CONT FROM candidatovaga WHERE idcandidato = '{$id}' AND idvaga = '{$idvaga}'";
			}
			return $this->TotalRegistro(false, $sql, false);
		}
		#######################################################################################################################
		function DeletarCandidatoDaVaga($idvaga = 0, $idcandidato = 0) {
			if(empty($idcandidato))
				$id = $this->GetID();
			else
				$id = $idcandidato;
			if(empty($id))
				return 0;
			if(empty($idvaga))
				return 0;
			$sql = "SELECT * FROM candidatovaga WHERE idcandidato = '{$id}' AND idvaga = '{$idvaga}'";
			$obj = GetModelo("candidatovaga");
			$obj = $obj->FiltroObjeto(false, $sql);
			if(empty($obj))
			{
				return 0;
			}
			else
			{
				return $obj->Apagar();
			}
		}
		#######################################################################################################################
		function Apagar() {
			$id = $this->GetID();
			$obj = GetModelo("candidatobot");
			$obj->ApagarLista("idcandidato = '{$id}'");
			$obj = GetModelo("candidatocargo");
			$obj->ApagarLista("idcandidato = '{$id}'");
			$obj = GetModelo("candidatocompetencia");
			$obj->ApagarLista("idcandidato = '{$id}'");
			$obj = GetModelo("candidatocontratado");
			$obj->ApagarLista("idcandidato = '{$id}'");
			$obj = GetModelo("candidatocurso");
			$obj->ApagarLista("idcandidato = '{$id}'");
			$obj = GetModelo("candidatorecomendado");
			$obj->ApagarLista("idcandidato = '{$id}'");
			$obj = GetModelo("candidatovaga");
			$obj->ApagarLista("idcandidato = '{$id}'");
			$obj = GetModelo("candidatoidioma");
			$obj->ApagarLista("idcandidato = '{$id}'");

			return $this->Excluir($id);
		}
		################################################################################################################
		public function LerFiltroContatos()
		{
			$idcliente = Get("idcliente", 0);
			$idvaga = Get("idvaga", 0);
			$posicao = Get("posicao", 0);
			$limite = Get("limite", 10);
			$total = Get("total", 0);

			$rows = false;
			$titulo = __("Erro");
			$mensagem = __("Nenhum contatos do candidato foi encontrado.");

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
			if(empty($total))
			{
				$total = 3;				
			}
			if(!empty($total))
			{
				if($limite < 0)
					$limite = $total;

				$sql = "SELECT COUNT(DISTINCT CV.idcandidato) AS CONT FROM candidatovaga CV INNER JOIN candidato C ON(C.idcandidato = CV.idcandidato) INNER JOIN vaga V ON(CV.idvaga = V.idvaga) LEFT JOIN favorito F USE INDEX(idxcandidato) ON(CV.idcandidato = F.idcandidato AND F.idvaga = V.idvaga) WHERE {$filtro} AND ISNULL(NULLIF(C.email,'')) = 0 AND C.email NOT LIKE '%@habu.com.br%' AND ISNULL(NULLIF(C.telefone,'')) = 1";
				$totalEmail = $this->TotalRegistro(false, $sql, false);

				$sql = "SELECT COUNT(DISTINCT CV.idcandidato) AS CONT FROM candidatovaga CV INNER JOIN candidato C ON(C.idcandidato = CV.idcandidato) INNER JOIN vaga V ON(CV.idvaga = V.idvaga) LEFT JOIN favorito F USE INDEX(idxcandidato) ON(CV.idcandidato = F.idcandidato AND F.idvaga = V.idvaga) WHERE {$filtro} AND ISNULL(NULLIF(C.email,'')) = 0 AND C.email LIKE '%@habu.com.br%'";
				$totalEmailHabu = $this->TotalRegistro(false, $sql, false);

				$sql = "SELECT COUNT(DISTINCT CV.idcandidato) AS CONT FROM candidatovaga CV INNER JOIN candidato C ON(C.idcandidato = CV.idcandidato) INNER JOIN vaga V ON(CV.idvaga = V.idvaga) LEFT JOIN favorito F USE INDEX(idxcandidato) ON(CV.idcandidato = F.idcandidato AND F.idvaga = V.idvaga) WHERE {$filtro} AND ISNULL(NULLIF(C.telefone,'')) = 0";
				$totalTelefone = $this->TotalRegistro(false, $sql, false);

				$rows = [
					["contatos"=>"email","texto"=>"Candidatos só com e-mail e sem telefone","total"=>$totalEmail],
					["contatos"=>"emailhabu","texto"=>"Candidato com ID habu","total"=>$totalEmailHabu],
					["contatos"=>"telefone","texto"=>"Candidatos com telefone","total"=>$totalTelefone]
				];
				if(!empty($rows))
				{
					$rows = array_map(array($this,'MapContatos'), $rows);
					$titulo = __("Sucesso");
					$mensagem = __("Lista de tipo de contato foi encontrada com sucesso.");
				}
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
		public static function MapContatos($row = false)
		{
			$row['total'] = intval($row['total']);
			return $row;
		}
		################################################################################################################
		public function LerFiltroDatadaAplicacao()
		{
			$idcliente = Get("idcliente", 0);
			$idvaga = Get("idvaga", 0);
			$posicao = Get("posicao", 0);
			$limite = Get("limite", 10);
			$total = Get("total", 0);

			$rows = false;
			$titulo = __("Erro");
			$mensagem = __("Nenhum contatos do candidato foi encontrado.");

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
			if(empty($total))
			{
				$total = 4;				
			}
			if(!empty($total))
			{
				if($limite < 0)
					$limite = $total;
				$sql = "SELECT COUNT(DISTINCT CV.idcandidato) AS CONT FROM candidatovaga CV INNER JOIN candidato C ON(C.idcandidato = CV.idcandidato) INNER JOIN vaga V ON(CV.idvaga = V.idvaga) LEFT JOIN favorito F USE INDEX(idxcandidato) ON(CV.idcandidato = F.idcandidato AND F.idvaga = V.idvaga) WHERE {$filtro} AND ISNULL(NULLIF(C.dataaplicacao,'0000-00-00')) = 0 AND C.dataaplicacao >= ADDDATE(CURDATE(),INTERVAL -30 DAY)";
				$total30 = $this->TotalRegistro(false, $sql, false);

				$sql = "SELECT COUNT(DISTINCT CV.idcandidato) AS CONT FROM candidatovaga CV INNER JOIN candidato C ON(C.idcandidato = CV.idcandidato) INNER JOIN vaga V ON(CV.idvaga = V.idvaga) LEFT JOIN favorito F USE INDEX(idxcandidato) ON(CV.idcandidato = F.idcandidato AND F.idvaga = V.idvaga) WHERE {$filtro} AND ISNULL(NULLIF(C.dataaplicacao,'0000-00-00')) = 0 AND C.dataaplicacao < ADDDATE(CURDATE(),INTERVAL -30 DAY) AND C.dataaplicacao >= ADDDATE(CURDATE(),INTERVAL -90 DAY)";
				$total90 = $this->TotalRegistro(false, $sql, false);

				$sql = "SELECT COUNT(DISTINCT CV.idcandidato) AS CONT FROM candidatovaga CV INNER JOIN candidato C ON(C.idcandidato = CV.idcandidato) INNER JOIN vaga V ON(CV.idvaga = V.idvaga) LEFT JOIN favorito F USE INDEX(idxcandidato) ON(CV.idcandidato = F.idcandidato AND F.idvaga = V.idvaga) WHERE {$filtro} AND ISNULL(NULLIF(C.dataaplicacao,'0000-00-00')) = 0 AND C.dataaplicacao < ADDDATE(CURDATE(),INTERVAL -90 DAY) AND C.dataaplicacao >= ADDDATE(CURDATE(),INTERVAL -180 DAY)";
				$total180 = $this->TotalRegistro(false, $sql, false);

				$sql = "SELECT COUNT(DISTINCT CV.idcandidato) AS CONT FROM candidatovaga CV INNER JOIN candidato C ON(C.idcandidato = CV.idcandidato) INNER JOIN vaga V ON(CV.idvaga = V.idvaga) LEFT JOIN favorito F USE INDEX(idxcandidato) ON(CV.idcandidato = F.idcandidato AND F.idvaga = V.idvaga) WHERE {$filtro} AND ISNULL(NULLIF(C.dataaplicacao,'0000-00-00')) = 0 AND C.dataaplicacao < ADDDATE(CURDATE(),INTERVAL -180 DAY)";
				$totalmais180 = $this->TotalRegistro(false, $sql, false);
				if(!empty($total30))
				{
					$rows[] = ["dataaplicacao"=>1,"texto"=>"Até 30 dias","total"=>intval($total30)];
				}
				else
				{
					$total--;
				}
				if(!empty($total90))
				{
					$rows[] = ["dataaplicacao"=>2,"texto"=>"De 30 até 90 dias","total"=>intval($total90)];
				}
				else
				{
					$total--;
				}
				if(!empty($total180))
				{
					$rows[] = ["dataaplicacao"=>3,"texto"=>"De 90 até 180 dias","total"=>intval($total180)];
				}
				else
				{
					$total--;
				}
				if(!empty($totalmais180))
				{
					$rows[] = ["dataaplicacao"=>4,"texto"=>"Mais de 180 dias","total"=>intval($totalmais180)];
				}
				else
				{
					$total--;
				}
				if(!empty($rows))
				{
					$titulo = __("Sucesso");
					$mensagem = __("Lista de tipo de contato foi encontrada com sucesso.");
				}
			}
			$novaposicao = $posicao + $limite;
			$finalizado = true;
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
		public function LerListaSexo()
		{
			$idcliente = Get("idcliente", 0);
			$idvaga = Get("idvaga", 0);
			$posicao = Get("posicao", 0);
			$limite = Get("limite", 10);
			$total = Get("total", 0);

			$rows = false;
			$titulo = __("Erro");
			$mensagem = __("Nenhuma candidato foi encontrada.");
			
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
			if(empty($total))
			{
				$sql = "SELECT COUNT(DISTINCT C.idcandidato) AS CONT FROM candidato C INNER JOIN candidatovaga CV USE INDEX(idxcandidato, idxvaga) ON(C.idcandidato = CV.idcandidato) INNER JOIN vaga V ON(CV.idvaga = V.idvaga) LEFT JOIN favorito F USE INDEX(idxcandidato) ON(CV.idcandidato = F.idcandidato AND F.idvaga = V.idvaga) WHERE {$filtro} AND ISNULL(NULLIF(C.sexo,'')) = 0";
				$total = $this->TotalRegistro(false, $sql,false);
				if(empty($total))
					$total = 0;
				else
					$total = 2;
			}
			if(!empty($total))
			{
				if($limite < 0)
					$limite = $total;
				$sql = "SELECT COUNT(DISTINCT C.idcandidato) AS CONT FROM candidato C INNER JOIN candidatovaga CV USE INDEX(idxcandidato, idxvaga) ON(C.idcandidato = CV.idcandidato) INNER JOIN vaga V ON(CV.idvaga = V.idvaga) LEFT JOIN favorito F USE INDEX(idxcandidato) ON(CV.idcandidato = F.idcandidato AND F.idvaga = V.idvaga) WHERE {$filtro} AND C.sexo = 'Feminino'";
				$totalFeminino = $this->TotalRegistro(false, $sql,false);

				$sql = "SELECT COUNT(DISTINCT C.idcandidato) AS CONT FROM candidato C INNER JOIN candidatovaga CV USE INDEX(idxcandidato, idxvaga) ON(C.idcandidato = CV.idcandidato) INNER JOIN vaga V ON(CV.idvaga = V.idvaga) LEFT JOIN favorito F USE INDEX(idxcandidato) ON(CV.idcandidato = F.idcandidato AND F.idvaga = V.idvaga) WHERE {$filtro} AND C.sexo = 'Masculino'";
				$totalMasculino = $this->TotalRegistro(false, $sql,false);
				$rows = [
					["sexo"=>"Feminino","texto"=>"Feminino","total"=>$totalFeminino],
					["sexo"=>"Masculino","texto"=>"Masculino","total"=>$totalMasculino]
				];
				if(!empty($rows))
				{
					$rows = array_map(array($this,'MapSexo'), $rows);
					$titulo = __("Sucesso");
					$mensagem = __("Lista de subárea foi encontrada com sucesso.");
				}
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
		public static function MapSexo($row = false)
		{
			$row['total'] = intval($row['total']);
			return $row;
		}
		################################################################################################################
		public function LimparNovos($idvaga = 0, $novo = "Não")
		{
			$retorno = false;
			try
			{
				if($novo != "Sim")
				{
					return $retorno;
				}
				if(empty($idvaga))
				{
					return $retorno;
				}
				$obj = GetModelo("candidatonovo");
				$obj->DeletarCandidatos($idvaga);

				return true;
			}
			catch( Exception $e )
			{
				throw new Exception( $e );
				return $retorno;
			}
		}
		################################################################################################################
		public function LerIdCandidato($dados = false)
		{
			if(empty($dados))
			{
				return 0;
			}
			$email = self::GetDadosChave($dados, array('email','Email','e-mail','E-mail','EMAIL','E-MAIL'));
			if(empty($email))
				return;
			$tipo = self::GetDadosChave($dados, array('lkd_tipo','LKD_tipo','lkd_Tipo','LKD_Tipo','lkd tipo','LKD tipo','LKD_TIPO','lkd TIPO'));
			$auxEmail = Escape($email);
			$auxTipo = Escape($tipo);
			$filtro = "email = '{$auxEmail}' AND tipo = '{$auxTipo}'";

			$sql = "SELECT idcandidato FROM {$this->Tabela} WHERE {$filtro} LIMIT 1";
			$id = $this->GetSqlCampo($sql,"idcandidato", 0);
			if(empty($id))
			{
				$this->idcandidato = 0;
				$this->email = $email;
				$this->tipo = $tipo;
				
				$this->nome = self::GetDadosChave($dados, array('nome','Nome','NOME','LKD_Nome','LKD_nome','lkd_nome','LKD_NOME'));
				$this->telefone = self::GetDadosChave($dados, array('telefone','Telefone','TELEFONE','LKD_Telefone','LKD_telefone','lkd_telefone','LKD_TELEFONE'));
				$this->linkedin = self::GetDadosChave($dados, array('url','Url','URL','LKD_URL','LKD_url','lkd_Url'));

				$this->Ajustar(true);
				$id = $this->Salvar();
				if(empty($id))
				{
					return 0;
				}
			}
			return $id;
		}
		################################################################################################################
		public function CandidatosMarcados()
		{
			$retorno = false;
			try
			{
				$obj = GetModelo("candidato");
				if(empty($obj))
				{					
					$dados['sucesso'] = false;
					$dados['erro'] = __("Nenhum candidato marcado foi encontrado no momento.");
				}
				else
				{
					$idvaga = intval(Get("idvaga",0));
					$temVaga = "";
					if(!empty($idvaga))
					{
						if($idvaga > 0)
							$temVaga = " AND CV.idvaga = '{$idvaga}'";	
					}

					$sql = "SELECT COUNT(DISTINCT CV.idcandidato) AS CONT FROM candidatovaga CV INNER JOIN candidato C ON(C.idcandidato = CV.idcandidato) INNER JOIN vaga V ON(CV.idvaga = V.idvaga) LEFT JOIN favorito F USE INDEX(idxcandidato) ON(CV.idcandidato = F.idcandidato AND F.idvaga = V.idvaga)";

					$filtro = " (F.tipo = 'Favorito') AND ISNULL(NULLIF(C.telefone,'')) = 0{$temVaga} ";
					$total = $obj->TotalRegistro($filtro, $sql);
					$lista['favorito'][0] = intval($total);

					$filtro = " (F.tipo = 'Favorito') AND ISNULL(NULLIF(C.email,'')) = 0 AND C.email NOT LIKE '%@habu.com.br%' AND ISNULL(NULLIF(C.telefone,'')) = 1{$temVaga} ";
					$total = $obj->TotalRegistro($filtro, $sql);
					$lista['favorito'][1] = intval($total);

					$filtro = " (F.tipo = 'Favorito') AND ISNULL(NULLIF(C.email,'')) = 0 AND C.email LIKE '%@habu.com.br%'{$temVaga} ";
					$total = $obj->TotalRegistro($filtro, $sql);
					$lista['favorito'][2] = intval($total);

					/*
					$filtro = " (F.tipo != 'Favorito') AND ISNULL(NULLIF(C.telefone,'')) = 0{$temVaga} ";
					$total = $obj->TotalRegistro($filtro, $sql);
					$lista['desconsiderado'][0] = intval($total);

					$filtro = " (F.tipo != 'Favorito') AND ISNULL(NULLIF(C.email,'')) = 0 AND C.email NOT LIKE '%@habu.com.br%' AND ISNULL(NULLIF(C.telefone,'')) = 1{$temVaga} ";
					$total = $obj->TotalRegistro($filtro, $sql);
					$lista['desconsiderado'][1] = intval($total);

					$filtro = " (F.tipo != 'Favorito') AND ISNULL(NULLIF(C.email,'')) = 0 AND C.email LIKE '%@habu.com.br%'{$temVaga} ";
					$total = $obj->TotalRegistro($filtro, $sql);
					$lista['desconsiderado'][2] = intval($total);*/

					$sql = "SELECT COUNT(DISTINCT CV.idcandidato) AS CONT FROM candidatovaga CV INNER JOIN toptalent T ON(T.idcandidato = CV.idcandidato) INNER JOIN candidato C ON(C.idcandidato = CV.idcandidato) INNER JOIN vaga V ON(CV.idvaga = V.idvaga) LEFT JOIN favorito F USE INDEX(idxcandidato) ON(CV.idcandidato = F.idcandidato AND F.idvaga = V.idvaga)";

					$filtro = " ISNULL(NULLIF(C.telefone,'')) = 0{$temVaga} ";
					$total = $obj->TotalRegistro($filtro, $sql);
					$lista['toptalent'][0] = intval($total);

					$filtro = " ISNULL(NULLIF(C.email,'')) = 0 AND C.email NOT LIKE '%@habu.com.br%' AND ISNULL(NULLIF(C.telefone,'')) = 1{$temVaga} ";
					$total = $obj->TotalRegistro($filtro, $sql);
					$lista['toptalent'][1] = intval($total);

					$filtro = " ISNULL(NULLIF(C.email,'')) = 0 AND C.email LIKE '%@habu.com.br%'{$temVaga} ";
					$total = $obj->TotalRegistro($filtro, $sql);
					$lista['toptalent'][2] = intval($total);

					$lista['total'][0] = $lista['favorito'][0]+$lista['toptalent'][0];
					$lista['total'][1] = $lista['favorito'][1]+$lista['toptalent'][1];
					$lista['total'][2] = $lista['favorito'][2]+$lista['toptalent'][2];

					$dados['sucesso'] = true;
					$dados['lista'] = $lista;
					$dados['mensagem'] = __("Total de candidatos marcados foi encontrado.");;
					$dados['titulo'] = __("Sucesso");
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
		public function CandidatosAvaliados()
		{
			$retorno = false;
			try
			{
				$obj = GetModelo("candidato");
				if(empty($obj))
				{					
					$dados['sucesso'] = false;
					$dados['erro'] = __("Nenhum candidato marcado foi encontrado no momento.");
				}
				else
				{
					$idvaga = intval(Get("idvaga",0));
					$temVaga = "";
					$join = "";
					if(!empty($idvaga))
					{
						if($idvaga > 0)
							$temVaga .= " AND CV.idvaga = '{$idvaga}'";	
					}
					$tipo = Get("tipo", "");
					if($tipo == "favoritos")
					{
						$join = " INNER JOIN favorito F USE INDEX(idxcandidato, idxvaga) ON(CV.idvaga = F.idvaga AND F.idcandidato = CV.idcandidato AND F.tipo = 'Favorito')";	
					}
					elseif($tipo == "toptalent")
					{
						$join = " INNER JOIN toptalent T USE INDEX(idxcandidato, idxvaga) ON(CV.idvaga = T.idvaga AND T.idcandidato = CV.idcandidato)";	
					}

					$sql = "SELECT COUNT(DISTINCT C.idcandidato) AS CONT FROM candidato C INNER JOIN candidatovaga CV USE INDEX(idxcandidato, idxvaga) ON(C.idcandidato = CV.idcandidato) INNER JOIN vaga V ON(CV.idvaga = V.idvaga){$join} LEFT JOIN avaliacao A USE INDEX(idxcandidato) ON(A.idcandidato = C.idcandidato)";

					$filtro = " ISNULL(NULLIF(C.telefone,'')) = 0 AND A.idavaliacao IS NOT NULL{$temVaga} ";
					$total = $obj->TotalRegistro($filtro, $sql);
					$lista['comtelefone'][0] = intval($total);

					$filtro = " ISNULL(NULLIF(C.telefone,'')) = 0 AND A.idavaliacao IS NULL{$temVaga} ";
					$total = $obj->TotalRegistro($filtro, $sql);
					$lista['comtelefone'][1] = intval($total);

					$filtro = " A.idavaliacao IS NOT NULL AND ISNULL(NULLIF(C.email,'')) = 0 AND C.email NOT LIKE '%@habu.com.br%' AND ISNULL(NULLIF(C.telefone,'')) = 1{$temVaga} ";
					$total = $obj->TotalRegistro($filtro, $sql);
					$lista['comemail'][0] = intval($total);

					$filtro = " A.idavaliacao IS NULL AND ISNULL(NULLIF(C.email,'')) = 0 AND C.email NOT LIKE '%@habu.com.br%' AND ISNULL(NULLIF(C.telefone,'')) = 1{$temVaga} ";
					$total = $obj->TotalRegistro($filtro, $sql);
					$lista['comemail'][1] = intval($total);

					$filtro = " A.idavaliacao IS NOT NULL AND ISNULL(NULLIF(C.email,'')) = 0 AND C.email LIKE '%@habu.com.br%'{$temVaga} ";
					$total = $obj->TotalRegistro($filtro, $sql);
					$lista['habu'][0] = intval($total);

					$filtro = " A.idavaliacao IS NULL AND ISNULL(NULLIF(C.email,'')) = 0 AND C.email LIKE '%@habu.com.br%'{$temVaga} ";
					$total = $obj->TotalRegistro($filtro, $sql);
					$lista['habu'][1] = intval($total);

					$filtro = " A.idavaliacao IS NOT NULL {$temVaga} ";
					$total = $obj->TotalRegistro($filtro, $sql);
					$lista['total'][0] = intval($total);

					$filtro = " A.idavaliacao IS NULL {$temVaga} ";
					$total = $obj->TotalRegistro($filtro, $sql);
					$lista['total'][1] = intval($total);

					$dados['sucesso'] = true;
					$dados['lista'] = $lista;
					$dados['mensagem'] = __("Total de candidatos marcados foi encontrado.");;
					$dados['titulo'] = __("Sucesso");
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
		public function MarcarLinkedinDesatualizado()
		{
			$idcandidato = Get("idcandidato", "");
			$idvaga = Get("idvaga", 0);
			$desmarcar = Get("desmarcar", 0);
						
			if(empty($idcandidato))
			{
				$dados['sucesso'] = false;
				$dados['erro'] = __("ID do candidato não foi enviado.");
				return $dados;
			}
			if(empty($idvaga))
			{
				$dados['sucesso'] = false;
				$dados['erro'] = __("ID da vaga não foi enviado.");
				return $dados;
			}			
			if(!$this->Load($idcandidato))
			{
				$dados['sucesso'] = false;
				$dados['erro'] = __("Não foi possível localizar o candidato.");
				return $dados;
			}
			if(empty($desmarcar))
			{
				$this->linkedin_desatualizado = "Sim";
				$titulo = __("Sucesso");
				$mensagem = __("Candidato foi marcado como linkedin desatualizado.");
			}
			else
			{
				$this->linkedin_desatualizado = "Não";
				$titulo = __("Sucesso");
				$mensagem = __("Candidato foi desmarcado como linkedin desatualizado.");
			}
			$this->Ajustar(true);
			if(!$this->Salvar())
			{
				$dados['sucesso'] = false;
				$dados['erro'] = __("Não foi possível salvar os dados do candidato.");
				return $dados;
			}
			$dados['sucesso'] = true;
			$dados['mensagem'] = $mensagem;
			$dados['titulo'] = $titulo;
			return $dados;
		}
		################################################################################################################
		public function LerListaAcaoLinkedin()
		{
			$idcliente = Get("idcliente", 0);
			$idvaga = Get("idvaga", 0);
			$posicao = Get("posicao", 0);
			$limite = Get("limite", 10);
			$total = Get("total", 0);

			$rows = false;
			$titulo = __("Erro");
			$mensagem = __("Nenhuma candidato foi encontrada.");
			
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
			if(empty($total))
			{
				$total = 4;
			}
			if(!empty($total))
			{
				if($limite < 0)
					$limite = $total;
				$sql = "SELECT COUNT(DISTINCT C.idcandidato) AS CONT FROM candidato C INNER JOIN candidatovaga CV USE INDEX(idxcandidato, idxvaga) ON(C.idcandidato = CV.idcandidato) INNER JOIN vaga V ON(CV.idvaga = V.idvaga) LEFT JOIN favorito F USE INDEX(idxcandidato) ON(CV.idcandidato = F.idcandidato AND F.idvaga = V.idvaga) WHERE {$filtro} AND C.linkedin_desatualizado = 'Sim'";
				$totalLinkedindesatualizado = $this->TotalRegistro(false, $sql,false);

				$sql = "SELECT COUNT(DISTINCT C.idcandidato) AS CONT FROM candidato C INNER JOIN candidatovaga CV USE INDEX(idxcandidato, idxvaga) ON(C.idcandidato = CV.idcandidato) INNER JOIN vaga V ON(CV.idvaga = V.idvaga) LEFT JOIN favorito F USE INDEX(idxcandidato) ON(CV.idcandidato = F.idcandidato AND F.idvaga = V.idvaga) WHERE {$filtro} AND C.linkedin_desatualizado != 'Sim'";
				$totalNoLinkedindesatualizado = $this->TotalRegistro(false, $sql,false);			
				
				$sql = "SELECT COUNT(DISTINCT C.idcandidato) AS CONT FROM candidato C INNER JOIN candidatovaga CV USE INDEX(idxcandidato, idxvaga) ON(C.idcandidato = CV.idcandidato) INNER JOIN vaga V ON(CV.idvaga = V.idvaga) LEFT JOIN favorito F USE INDEX(idxcandidato) ON(CV.idcandidato = F.idcandidato AND F.idvaga = V.idvaga) WHERE {$filtro} AND ISNULL(NULLIF(C.retornoinvitelkd,'')) = 0";
				$totalRetornoinvite = $this->TotalRegistro(false, $sql,false);

				$sql = "SELECT COUNT(DISTINCT C.idcandidato) AS CONT FROM candidato C INNER JOIN candidatovaga CV USE INDEX(idxcandidato, idxvaga) ON(C.idcandidato = CV.idcandidato) INNER JOIN vaga V ON(CV.idvaga = V.idvaga) LEFT JOIN favorito F USE INDEX(idxcandidato) ON(CV.idcandidato = F.idcandidato AND F.idvaga = V.idvaga) WHERE {$filtro} AND ISNULL(NULLIF(C.retornoinvitelkd,'')) = 1";
				$totalNoRetornoinvite = $this->TotalRegistro(false, $sql,false);
				$rows = [
					["acaolinkedin"=>"linkedindesatualizado","texto"=>"Linkedin desatualizado","total"=>intval($totalLinkedindesatualizado)],
					["acaolinkedin"=>"nolinkedindesatualizado","texto"=>"Linkedin atualizado","total"=>intval($totalNoLinkedindesatualizado)],
					["acaolinkedin"=>"retornoinvite","texto"=>"Com Invite Linkedin","total"=>intval($totalRetornoinvite)],
					["acaolinkedin"=>"noretornoinvite","texto"=>"Sem Invite Linkedin","total"=>intval($totalNoRetornoinvite)]
				];
				if(!empty($rows))
				{
					$titulo = __("Sucesso");
					$mensagem = __("Lista de ações linkedin foi encontrada com sucesso.");
				}
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
		public function __destruct()
		{
			unset($this->dados, $this->Tabela, $this->PrimaryKey);
		}
	}
}
?>