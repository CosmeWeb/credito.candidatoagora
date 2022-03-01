<?php
/***********************************************************************
 * Module:  /models/Vaga_model.PHP
 * Author:  Host-up
 * Date:	18/05/2020 23:53:53
 * Purpose: Definição da Classe Vaga_model
 * Instancias: $this->load->model('Vaga_model', 'vaga');
 * Objeto: $vaga = $this->vaga->GetInstancia($dados);
 ***********************************************************************/
if (!class_exists('Vaga_model'))
{
	class Vaga_model extends MY_Model
	{
		private static $_cargocorrelato = null;
		private static $_empresacorrelata = null;
		private static $_empresatarget = null;
		private static $_empresatargetexcluir = null;
		private static $_setortarget = null;
		private static $_subareavaga = null;
		private static $_candidatoidioma = null;
		private static $_candidatocargo = null;
		private static $_candidatonovo = null;
		private static $_favorito = null;
		private static $_toptalent = null;
		private static $_candidatoperfil = null;
		private static $_candidatocurso = null;
		private static $_candidatocompetencia = null;
		private static $_candidatointeresse = null;
		private static $_avaliacao = null;
		private static $_candidatovaga = null;
		################################################################################################################
		public function __construct( $dados = false)
		{
			try
			{
				$this->Tabela = "vaga";
				$this->PrimaryKey = "idvaga";
				parent::__construct($dados);
			}
			catch( Exception $e )
			{
				throw new Exception( $e );
			}
		}
		################################################################################################################
		public static function &NewCargocorrelato() {
			if (self::$_cargocorrelato == null)
				self::$_cargocorrelato = GetModelo("cargocorrelato");
			return self::$_cargocorrelato;
		}
		################################################################################################################
		public static function &NewEmpresacorrelata() {
			if (self::$_empresacorrelata == null)
				self::$_empresacorrelata = GetModelo("empresacorrelata");
			return self::$_empresacorrelata;
		}
		################################################################################################################
		public static function &NewEmpresatarget() {
			if (self::$_empresatarget == null)
				self::$_empresatarget = GetModelo("empresatarget");
			return self::$_empresatarget;
		}
		################################################################################################################
		public static function &NewEmpresatargetexcluir() {
			if (self::$_empresatargetexcluir == null)
				self::$_empresatargetexcluir = GetModelo("empresatargetexcluir");
			return self::$_empresatargetexcluir;
		}
		################################################################################################################
		public static function &NewSetortarget() {
			if (self::$_setortarget == null)
				self::$_setortarget = GetModelo("setortarget");
			return self::$_setortarget;
		}
		################################################################################################################
		public static function &NewSubareavaga() {
			if (self::$_subareavaga == null)
				self::$_subareavaga = GetModelo("subareavaga");
			return self::$_subareavaga;
		}
		################################################################################################################
		public static function &NewCandidatoidioma() {
			if (self::$_candidatoidioma == null)
				self::$_candidatoidioma = GetModelo("candidatoidioma");
			return self::$_candidatoidioma;
		}
		################################################################################################################
		public static function &NewCandidatocargo() {
			if (self::$_candidatocargo == null)
				self::$_candidatocargo = GetModelo("candidatocargo");
			return self::$_candidatocargo;
		}
		################################################################################################################
		public static function &NewFavorito() {
			if (self::$_favorito == null)
				self::$_favorito = GetModelo("favorito");
			return self::$_favorito;
		}
		################################################################################################################
		public static function &NewToptalent() {
			if (self::$_toptalent == null)
				self::$_toptalent = GetModelo("toptalent");
			return self::$_toptalent;
		}
		################################################################################################################
		public static function &NewCandidatoperfil() {
			if (self::$_candidatoperfil == null)
				self::$_candidatoperfil = GetModelo("candidatoperfil");
			return self::$_candidatoperfil;
		}
		################################################################################################################
		public static function &NewCandidatocurso() {
			if (self::$_candidatocurso == null)
				self::$_candidatocurso = GetModelo("candidatocurso");
			return self::$_candidatocurso;
		}
		################################################################################################################
		public static function &NewCandidatocompetencia() {
			if (self::$_candidatocompetencia == null)
				self::$_candidatocompetencia = GetModelo("candidatocompetencia");
			return self::$_candidatocompetencia;
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
		public static function &NewCandidatoVaga() {
			if (self::$_candidatovaga == null)
				self::$_candidatovaga = GetModelo("candidatovaga");
			return self::$_candidatovaga;
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
				if(!empty($this->descricaodavaga))
					$this->descricaodavaga = trim(strip_tags($this->descricaodavaga));
				$this->faixaderemuneracaoinicial = GetFloat($this->faixaderemuneracaoinicial);
				$this->faixaderemuneracaofim = GetFloat($this->faixaderemuneracaofim);
			}
			else
			{

			}
		}
		################################################################################################################
		public function GerarOpcoesEmpresas($value = "0", $texto = "", $default = "0")
		{
			if(empty($texto))
				$texto = __("-- Selecione --");
			$primeiro = array("valor"=>$default,"texto"=>$texto);
			$sql = "SELECT idempresa AS 'id', empresa AS 'texto' FROM empresa ORDER BY texto ASC";
			return $this->GeraOpcoesSql($value, $sql, "id", "texto", $primeiro);
		}
		################################################################################################################
		public function GerarOpcoesSetor($value = "0", $texto = "", $default = "0")
		{
			$obj = GetModelo("setor");
			return $obj->GerarOpcoesSetor($value, $texto, $default);
		}
		################################################################################################################
		public function GerarOpcoesCliente($value = "0", $texto = "", $default = "0")
		{
			if(empty($texto))
				$texto = __("-- Selecione --");
			$primeiro = array("valor"=>$default,"texto"=>$texto);
			$sql = "SELECT idcliente AS 'id', CONCAT(nome,' &lt;',email,'&gt;') AS 'texto' FROM cliente ORDER BY texto ASC";
			return $this->GeraOpcoesSql($value, $sql, "id", "texto", $primeiro);
		}
		################################################################################################################
		public function GerarOpcoesEmpresaClientes($value = "0", $texto = "", $default = "0")
		{
			$obj = GetModelo("cliente");
			return $obj->GerarOpcoesEmpresaClientes($value, $texto, $default);
		}
		################################################################################################################
		public function GerarOpcoesEmpresasContratante($value = "0", $texto = "", $default = "0")
		{
			if(empty($texto))
				$texto = __("-- Selecione --");
			$primeiro = array("valor"=>$default,"texto"=>$texto);
			$sql = "SELECT DISTINCT V.empresacontratante AS 'texto' FROM vaga V ORDER BY texto ASC";
			return $this->GeraOpcoesSql($value, $sql, "texto", "texto", $primeiro);
		}
		################################################################################################################
		public function GerarOpcoesTamanho($value = "", $texto = "", $default = "")
		{
			if(empty($texto))
				$texto = __("-- Selecione --");
			$primeiro = array("valor"=>$default,"texto"=>$texto);
			$sql = "SELECT idtamanho AS 'id', tamanho AS 'texto' FROM tamanho ORDER BY ordem ASC";
			return $this->GeraOpcoesSql($value, $sql, "id", "texto", $primeiro);
		}
		################################################################################################################
		public function GerarOpcoesFaturamento($value = "0", $texto = "", $default = "0")
		{
			if(empty($texto))
				$texto = __("-- Selecione --");
			$primeiro = array("valor"=>$default,"texto"=>$texto);
			$sql = "SELECT idfaturamento AS 'id', faturamento AS 'texto' FROM faturamento ORDER BY ordem ASC";
			return $this->GeraOpcoesSql($value, $sql, "id", "texto", $primeiro);
		}
		################################################################################################################
		public function GerarOpcoesArea($value = "", $texto = "", $default = "")
		{
			if(empty($texto))
				$texto = __("-- Selecione --");
			$primeiro = array("valor"=>$default,"texto"=>$texto);
			$sql = "SELECT idarea AS 'id', area AS 'texto' FROM area ORDER BY texto ASC";
			return $this->GeraOpcoesSql($value, $sql, "id", "texto", $primeiro);
		}
		################################################################################################################
		public function GerarOpcoesNivel($value = "", $texto = "", $default = "")
		{
			if(empty($texto))
				$texto = __("-- Selecione --");
			$primeiro = array("valor"=>$default,"texto"=>$texto);
			$sql = "SELECT idnivel AS 'id', nivel AS 'texto' FROM nivel ORDER BY texto ASC";
			return $this->GeraOpcoesSql($value, $sql, "id", "texto", $primeiro);
		}
		################################################################################################################
		public function GerarOpcoesSubarea($value = "", $texto = "", $default = "")
		{
			if(empty($texto))
				$texto = __("-- Selecione --");
			$primeiro = array("valor"=>$default,"texto"=>$texto);
			$sql = "SELECT idsubarea AS 'id', subarea AS 'texto' FROM subarea ORDER BY texto ASC";
			return $this->GeraOpcoesSql($value, $sql, "id", "texto", $primeiro);
		}
		################################################################################################################
		public function GerarOpcoesEstado($value = "", $texto = "", $default = "")
		{
			if(empty($texto))
				$texto = __("-- Selecione --");
			$primeiro = array("valor"=>$default,"texto"=>$texto);
			$sql = "SELECT idestado AS 'id', estado AS 'texto' FROM estado ORDER BY texto ASC";
			return $this->GeraOpcoesSql($value, $sql, "id", "texto", $primeiro);
		}
		################################################################################################################
		public function GerarOpcoesCargo($value = "", $texto = "", $default = "")
		{
			if(empty($texto))
				$texto = __("-- Selecione --");
			$primeiro = array("valor"=>$default,"texto"=>$texto);
			$sql = "SELECT idcargo AS 'id', cargo AS 'texto' FROM cargo WHERE ISNULL(NULLIF(cargo,'')) = 0 ORDER BY texto ASC";
			return $this->GeraOpcoesSql($value, $sql, "id", "texto", $primeiro);
		}
		################################################################################################################
		public function GerarOpcoesCidade($value = "", $texto = "", $default = "")
		{
			if(empty($texto))
				$texto = __("-- Selecione --");
			$primeiro = array("valor"=>$default,"texto"=>$texto);
			$sql = "SELECT idcidade AS 'id', cidade AS 'texto' FROM cidade ORDER BY texto ASC";
			return $this->GeraOpcoesSql($value, $sql, "id", "texto", $primeiro);
		}
		################################################################################################################
		public function GerarOpcoesPais($value = "", $texto = "", $default = "")
		{
			if(empty($texto))
				$texto = __("-- Selecione --");
			$primeiro = array("valor"=>$default,"texto"=>$texto);
			$sql = "SELECT P.idpais AS 'id', IF(ISNULL(NULLIF(P.sigla,'')) = 1, P.pais, CONCAT(P.pais,' (',P.sigla,')')) AS 'texto' FROM pais P ORDER BY texto ASC";
			return $this->GeraOpcoesSql($value, $sql, "id", "texto", $primeiro);
		}
		################################################################################################################
		public function GerarOpcoesNacionalidadeempresasprofissionaltrabalhou($value = "", $texto = "", $default = "")
		{
			if(empty($texto))
				$texto = __("-- Selecione --");
			$primeiro = array("valor"=>$default,"texto"=>$texto);
			return $this->GeraOpcoesEnum($value, $this->Tabela, "nacionalidadeempresasprofissionaltrabalhou", $primeiro);
		}
		################################################################################################################
		public function GerarOpcoesMomentoatualempresa($value = "", $texto = "", $default = "")
		{
			if(empty($texto))
				$texto = __("-- Selecione --");
			$primeiro = array("valor"=>$default,"texto"=>$texto);
			return $this->GeraOpcoesEnum($value, $this->Tabela, "momentoatualempresa", $primeiro);
		}
		################################################################################################################
		public function GerarOpcoesDeclarado($value = "", $texto = "", $default = "")
		{
			if(empty($texto))
				$texto = __("-- Selecione --");
			$primeiro = array("valor"=>$default,"texto"=>$texto);
			return $this->GeraOpcoesEnum($value, $this->Tabela, "declarado", $primeiro);
		}
		################################################################################################################
		public function GerarOpcoesAutorizado($value = "", $texto = "", $default = "")
		{
			if(empty($texto))
				$texto = __("-- Selecione --");
			$primeiro = array("valor"=>$default,"texto"=>$texto);
			return $this->GeraOpcoesEnum($value, $this->Tabela, "autorizado", $primeiro);
		}
		################################################################################################################
		public function GerarOpcoesIncluirempresasforatarget($value = "", $texto = "", $default = "")
		{
			if(empty($texto))
				$texto = __("-- Selecione --");
			$primeiro = array("valor"=>$default,"texto"=>$texto);
			return $this->GeraOpcoesEnum($value, $this->Tabela, "incluirempresasforatarget", $primeiro);
		}
		################################################################################################################
		public function GerarOpcoesExcluirprofissionaisjatrabalhouempresa($value = "", $texto = "", $default = "")
		{
			if(empty($texto))
				$texto = __("-- Selecione --");
			$primeiro = array("valor"=>$default,"texto"=>$texto);
			return $this->GeraOpcoesEnum($value, $this->Tabela, "excluirprofissionaisjatrabalhouempresa", $primeiro);
		}
		################################################################################################################
		public function GerarOpcoesMelhores1000empresa($value = "", $texto = "", $default = "")
		{
			if(empty($texto))
				$texto = __("-- Selecione --");
			$primeiro = array("valor"=>$default,"texto"=>$texto);
			return $this->GeraOpcoesEnum($value, $this->Tabela, "melhores1000empresa", $primeiro);
		}
		################################################################################################################
		public function GerarOpcoesListadaembolsa($value = "", $texto = "", $default = "")
		{
			if(empty($texto))
				$texto = __("-- Selecione --");
			$primeiro = array("valor"=>$default,"texto"=>$texto);
			return $this->GeraOpcoesEnum($value, $this->Tabela, "listadaembolsa", $primeiro);
		}
		################################################################################################################
		public function GerarOpcoesStartup($value = "", $texto = "", $default = "")
		{
			if(empty($texto))
				$texto = __("-- Selecione --");
			$primeiro = array("valor"=>$default,"texto"=>$texto);
			return $this->GeraOpcoesEnum($value, $this->Tabela, "startup", $primeiro);
		}
		################################################################################################################
		public function GerarOpcoesGptw($value = "", $texto = "", $default = "")
		{
			if(empty($texto))
				$texto = __("-- Selecione --");
			$primeiro = array("valor"=>$default,"texto"=>$texto);
			return $this->GeraOpcoesEnum($value, $this->Tabela, "gptw", $primeiro);
		}
		################################################################################################################
		public function GerarOpcoesPerfilinovacao($value = "", $texto = "", $default = "")
		{
			if(empty($texto))
				$texto = __("-- Selecione --");
			$primeiro = array("valor"=>$default,"texto"=>$texto);
			return $this->GeraOpcoesEnum($value, $this->Tabela, "perfilinovacao", $primeiro);
		}
		################################################################################################################
		public function GerarOpcoesStatus($value = "", $texto = "", $default = "")
		{
			if(empty($texto))
				$texto = __("-- Selecione --");
			$primeiro = array("valor"=>$default,"texto"=>$texto);
			return $this->GeraOpcoesEnum($value, $this->Tabela, "status", $primeiro);
		}
		################################################################################################################
		public function GerarOpcoesRaiodepesquisa($valor = "", $texto = "", $default = "")
		{
			if(empty($texto))
				$texto = __("-- Selecione --");
			$primeiro = array("valor"=>$default,"texto"=>$texto);
			$lista = array(
				'5'=>'Até 5 Km',
				'15'=>'De 6-15 Km',
				'25'=>'De 15-25 Km',
				'50'=>'De 25-50 Km',
				'100'=>'De 50-100 Km',
				'150'=>'Até 100 Km',
			);
			return self::GeraOpcoesArray($valor, $lista, $primeiro);
		}
		################################################################################################################
		public function GerarOpcoesMobilidade($value = "", $texto = "", $default = "")
		{
			if(empty($texto))
				$texto = __("-- Selecione --");
			$primeiro = array("valor"=>$default,"texto"=>$texto);
			return $this->GeraOpcoesEnum($value, $this->Tabela, "mobilidade", $primeiro);
		}
		################################################################################################################
		public function GerarOpcoesLinhadereporte($valor = "", $texto = "", $default = "")
		{
			if(empty($texto))
				$texto = __("-- Selecione --");
			$primeiro = array("valor"=>$default,"texto"=>$texto);
			$lista = self::ListaLinhadereporte();
			return self::GeraOpcoesArray($valor, $lista, $primeiro);
		}
		################################################################################################################
		public static function &ListaLinhadereporte()
		{
			$lista = array(
				"Reporte para o nível de especialista"=>"Reporte para o nível de especialista",
				"Reporte para o nível  de coordenação"=>"Reporte para o nível  de coordenação",
				"Reporte para o nível gerencial"=>"Reporte para o nível gerencial",
				"Reporte para o nível de diretoria, presidência"=>"Reporte para o nível de diretoria, presidência",
				"Reporte direto aos acionistas, conselho"=>"Reporte direto aos acionistas, conselho",
			);
			return $lista;
		}
		################################################################################################################
		public function GetSqlLista()
		{
			$retorno = "";
			try
			{
				return "SELECT V.idvaga, V.titulodavaga, V.empresacontratante, C.cidade, V.linhadereporte, V.cadastradoem, CT.nome AS cliente, C.cidade, E.estado, S.setor, (SELECT COUNT(*) AS CONT FROM candidato CD INNER JOIN candidatovaga CV FORCE INDEX(idxcandidato, idxvaga) ON(CD.idcandidato = CV.idcandidato) INNER JOIN vaga VG ON(CV.idvaga = VG.idvaga) WHERE V.idvaga = VG.idvaga) AS total FROM vaga V LEFT JOIN setor S ON(V.idsetor = S.idsetor) LEFT JOIN cliente CT ON(V.idcliente = CT.idcliente) LEFT JOIN estado E ON(E.idestado = V.idestado) LEFT JOIN cidade C ON(V.idcidade = C.idcidade)";
			}
			catch( Exception $e )
			{
				throw new Exception( $e );
				return $retorno;
			}
		}
		################################################################################################################
		public function GetSqlListaExportacao($tipo = "geral")
		{
			$retorno = "";
			try
			{
				if($tipo != "candidatos")
				{
					return "SELECT V.*, T.tamanho, F.faturamento, A.area, N.nivel, CT.nome AS cliente, C.cidade, E.estado, P.pais, S.setor FROM vaga V LEFT JOIN setor S ON(V.idsetor = S.idsetor) LEFT JOIN tamanho T ON(T.idtamanho = V.idtamanho) LEFT JOIN faturamento F ON(F.idfaturamento = V.idfaturamento) LEFT JOIN area A ON(A.idarea = V.idarea) LEFT JOIN nivel N ON(N.idnivel = V.idnivel) LEFT JOIN cliente CT ON(V.idcliente = CT.idcliente) LEFT JOIN estado E ON(E.idestado = V.idestado) LEFT JOIN cidade C ON(V.idcidade = C.idcidade) LEFT JOIN pais P ON(E.idpais = P.idpais)";
				}
				else
				{
					return "SELECT DISTINCT C.idcandidato, C.nome, C.email, C.telefone, C.telefone_verificado, C.linkedin, C.sexo, P.pais, E.estado, CD.cidade, C.datacoleta, C.dataaplicacao, CV.idvaga, C.twitter FROM candidato C FORCE INDEX(idxcidade,idxestado,idxpais) LEFT JOIN pais P ON(C.idpais = P.idpais) LEFT JOIN estado E ON(C.idestado = E.idestado) LEFT JOIN cidade CD ON(C.idcidade = CD.idcidade) LEFT JOIN candidatocargo CC FORCE INDEX(idxcandidato, idxcargo) ON(C.idcandidato = CC.idcandidato) LEFT JOIN cargo CG ON(CC.idcargo = CG.idcargo) LEFT JOIN candidatovaga CV FORCE INDEX(idxcandidato, idxvaga) ON(C.idcandidato = CV.idcandidato)";
				}
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
				return "SELECT COUNT(DISTINCT V.idvaga) AS CONT FROM vaga V LEFT JOIN setor S ON(V.idsetor = S.idsetor) LEFT JOIN cliente CT ON(V.idcliente = CT.idcliente) LEFT JOIN estado E ON(E.idestado = V.idestado) LEFT JOIN cidade C ON(V.idcidade = C.idcidade)";
			}
			catch( Exception $e )
			{
				throw new Exception( $e );
				return $retorno;
			}
		}
		################################################################################################################
		public function GetSqlTotalListaExportacao($tipo = "geral")
		{
			$retorno = "";
			try
			{
				if($tipo != "candidatos")
				{
					return "SELECT COUNT(DISTINCT V.idvaga) AS CONT FROM vaga V LEFT JOIN setor S ON(V.idsetor = S.idsetor) LEFT JOIN tamanho T ON(T.idtamanho = V.idtamanho) LEFT JOIN faturamento F ON(F.idfaturamento = V.idfaturamento) LEFT JOIN area A ON(A.idarea = V.idarea) LEFT JOIN nivel N ON(N.idnivel = V.idnivel) LEFT JOIN cliente CT ON(V.idcliente = CT.idcliente) LEFT JOIN estado E ON(E.idestado = V.idestado) LEFT JOIN cidade C ON(V.idcidade = C.idcidade) LEFT JOIN pais P ON(E.idpais = P.idpais)";
				}
				else
				{
					return "SELECT COUNT(DISTINCT C.idcandidato) AS CONT FROM candidato C FORCE INDEX(idxcidade,idxestado,idxpais) LEFT JOIN pais P ON(C.idpais = P.idpais) LEFT JOIN estado E ON(C.idestado = E.idestado) LEFT JOIN cidade CD ON(C.idcidade = CD.idcidade) LEFT JOIN candidatocargo CC FORCE INDEX(idxcandidato, idxcargo) ON(C.idcandidato = CC.idcandidato) LEFT JOIN cargo CG ON(CC.idcargo = CG.idcargo) LEFT JOIN candidatovaga CV FORCE INDEX(idxcandidato, idxvaga) ON(C.idcandidato = CV.idcandidato)";
				}
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
			$idvaga = GetFiltro("idvaga",0);
			$tipo = GetFiltro("tipo","geral");
			if(empty($idvaga))
			{
				$buscar = GetFiltro("buscar");
				if(!empty($buscar))
				{
					$filtro .= " AND (V.empresacontratante LIKE '%{$buscar}%' OR V.setordeatuacao LIKE '%{$buscar}%' OR V.linhadereporte LIKE '%{$buscar}%' OR V.linhadereporte LIKE '%{$buscar}%' OR V.descricaodavaga LIKE '%{$buscar}%' OR V.titulodavaga LIKE '%{$buscar}%')";
				}
				$idcliente = GetFiltro("idcliente");
				if(!empty($idcliente))
				{
					$filtro .= " AND V.idcliente = '{$idcliente}'";
				}
				$idtamanho = GetFiltro("idtamanho");
				if(!empty($idtamanho))
				{
					$filtro .= " AND V.idtamanho = '{$idtamanho}'";
				}
				$idfaturamento = GetFiltro("idfaturamento");
				if(!empty($idfaturamento))
				{
					$filtro .= " AND idfaturamento = '{$idfaturamento}'";
				}
				$idarea = GetFiltro("idarea");
				if(!empty($idarea))
				{
					$filtro .= " AND V.idarea = '{$idarea}'";
				}
				$idnivel = GetFiltro("idnivel");
				if(!empty($idnivel))
				{
					$filtro .= " AND V.idnivel = '{$idnivel}'";
				}
				$empresa = GetFiltro("empresa");
				if(!empty($empresa))
				{
					$filtro .= " AND CT.empresa = '{$empresa}'";
				}
				$idsubarea = GetFiltro("idsubarea");
				if(!empty($idsubarea))
				{
					$filtro .= " AND V.idsubarea = '{$idsubarea}'";
				}
				$idestado = GetFiltro("idestado");
				if(!empty($idestado))
				{
					$filtro .= " AND V.idestado = '{$idestado}'";
				}
				$idcidade = GetFiltro("idcidade");
				if(!empty($idcidade))
				{
					$filtro .= " AND V.idcidade = '{$idcidade}'";
				}
				$empresacontratante = GetFiltro("empresacontratante");
				if(!empty($empresacontratante))
				{
					$filtro .= " AND V.empresacontratante = '{$empresacontratante}'";
				}
				$idsetor = GetFiltro("idsetor");
				if(!empty($idsetor))
				{
					$filtro .= " AND V.idsetor = '{$idsetor}'";
				}
				$linhadereporte = GetFiltro("linhadereporte");
				if(!empty($linhadereporte))
				{
					$filtro .= " AND V.linhadereporte = '{$linhadereporte}'";
				}
				$descricaodavaga = GetFiltro("descricaodavaga");
				if(!empty($descricaodavaga))
				{
					$filtro .= " AND V.descricaodavaga = '{$descricaodavaga}'";
				}
				$nacionalidadeempresasprofissionaltrabalhou = GetFiltro("nacionalidadeempresasprofissionaltrabalhou");
				if(!empty($nacionalidadeempresasprofissionaltrabalhou))
				{
					$filtro .= " AND V.nacionalidadeempresasprofissionaltrabalhou = '{$nacionalidadeempresasprofissionaltrabalhou}'";
				}
				$declarado = GetFiltro("declarado");
				if(!empty($declarado))
				{
					$filtro .= " AND V.declarado = '{$declarado}'";
				}
				$autorizado = GetFiltro("autorizado");
				if(!empty($autorizado))
				{
					$filtro .= " AND V.autorizado = '{$autorizado}'";
				}
				$incluirempresasforatarget = GetFiltro("incluirempresasforatarget");
				if(!empty($incluirempresasforatarget))
				{
					$filtro .= " AND V.incluirempresasforatarget = '{$incluirempresasforatarget}'";
				}
				$excluirprofissionaisjatrabalhouempresa = GetFiltro("excluirprofissionaisjatrabalhouempresa");
				if(!empty($excluirprofissionaisjatrabalhouempresa))
				{
					$filtro .= " AND V.excluirprofissionaisjatrabalhouempresa = '{$excluirprofissionaisjatrabalhouempresa}'";
				}
				$momentoatualempresa = GetFiltro("momentoatualempresa");
				if(!empty($momentoatualempresa))
				{
					$filtro .= " AND V.momentoatualempresa = '{$momentoatualempresa}'";
				}
				$melhores1000empresa = GetFiltro("melhores1000empresa");
				if(!empty($melhores1000empresa))
				{
					$filtro .= " AND V.melhores1000empresa = '{$melhores1000empresa}'";
				}
				$listadaembolsa = GetFiltro("listadaembolsa");
				if(!empty($listadaembolsa))
				{
					$filtro .= " AND V.listadaembolsa = '{$listadaembolsa}'";
				}
				$startup = GetFiltro("startup");
				if(!empty($startup))
				{
					$filtro .= " AND V.startup = '{$startup}'";
				}
				$gptw = GetFiltro("gptw");
				if(!empty($gptw))
				{
					$filtro .= " AND V.gptw = '{$gptw}'";
				}
				$perfilinovacao = GetFiltro("perfilinovacao");
				if(!empty($perfilinovacao))
				{
					$filtro .= " AND V.perfilinovacao = '{$perfilinovacao}'";
				}
				$status = GetFiltro("status");
				if(!empty($status))
				{
					$filtro .= " AND V.status = '{$status}'";
				}
				$cadastradoeminicio = GetFiltro("cadastradoeminicio");
				if(!empty($cadastradoeminicio))
				{
					$data = date("Y-m-d", TimeData($cadastradoeminicio));
					$filtro .= " AND V.cadastradoem >= '{$data}'";
				}
				$cadastradoemfim = GetFiltro("cadastradoemfim");
				if(!empty($cadastradoemfim))
				{
					$data = date("Y-m-d", TimeData($cadastradoemfim));
					$filtro .= " AND V.cadastradoem <= '{$data}'";
				}
			}
			else
			{
				if($tipo != "candidatos")
					$filtro .= " AND V.idvaga = '{$idvaga}'";
				else
					$filtro .= " AND CV.idvaga = '{$idvaga}'";
			}
			if(!empty($filtro))
			{
				$filtro  = substr($filtro, 4);
			}
			if($semOrder)
			{
				return $filtro;
			}
			$ordem = array('V.idvaga', 'V.titulodavaga', 'CT.nome', 'V.empresacontratante', 'C.cidade', 'V.linhadereporte', 'S.setor', 'V.cadastradoem', 'total', 'V.idvaga');
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
			$obj = GetModelo("vaga");
			if(empty($obj))
				return $retorno;
			foreach ($lista as $key=>$linha)
			{
				$obj->SalvarListaVaga($linha);
			}
			return true;
		}
		################################################################################################################
		public function SalvarListaVaga($dados = false)
		{
			if(empty($dados))
				return;
			$vaga = self::GetDadosChave($dados, array('vaga','vaga'));
			if(empty($vaga))
				return;
			$filtro = "vaga = '{$vaga}'";
			$obj = $this->FiltroObjeto($filtro);
			if(empty($obj))
			{
				$obj = $this->GetInstancia();
				$obj->vaga = $vaga;
			}
			$obj->Ajustar(true);
			$obj->Salvar();
			return;
		}
		################################################################################################################
		public function ExportarVaga()
		{
			$posicao = Get("posicao", 0);
			$total = Get("total", 0);
			$file = Get("file");
			$tipo = GetFiltro("tipo","geral");			
			$limite = 100;
			$obj = GetModelo('vaga');
			
			if(empty($total))
			{
				$sqlTotal = $obj->GetSqlTotalListaExportacao($tipo);
				$filtro = $obj->Filtro(true);
				$total = $obj->TotalRegistro($filtro, $sqlTotal, false);
				if(empty($total))
				{
					$dados['sucesso'] = false;
					$dados['erro'] = __("Nenhum vaga foi encontrado no momento.");
				}
				else
				{
					$dados['sucesso'] = true;
					$dados['titulo'] = __("Processando Exportação");
					$dados['mensagem'] = __("Exportação de vaga está processando.");
					$dados['url'] = "";
					$dados['finalizado'] = false;
					$dados['file'] = $file;
					$dados['posicao'] = $posicao;
					$dados['total'] = $total;
				}
				return $dados;
			}
			$sql = $obj->GetSqlListaExportacao($tipo);
			$filtro = $obj->Filtro(true);
			if($tipo != "candidatos")
			{
				$filtro .= " ORDER BY V.idvaga ASC";
				$funcao = "GetDadosExcel";
			}
			else
			{
				$filtro .= " ORDER BY C.idcandidato ASC";
				$funcao = "GetDadosExcelCandidatos";
			}

			$filtro .= " LIMIT {$posicao},{$limite}";
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
					"pasta"=>$obj->GetCaminho(),
					"funcao"=>$funcao
				);
				Excel($data);
				$posicao += $limite;
				$dados['sucesso'] = true;
				if($posicao >= $total)
				{
					$dados['titulo'] = __("Exportação de vaga");
					$dados['mensagem'] = __("Exportação de vaga foi finalizada.<br/>O download se iniciará em instantes");
					$dados['url'] = site_url("vaga/baixarvaga/{$file}");
					$dados['finalizado'] = true;
					$dados['file'] = $file;
					$dados['posicao'] = $posicao;
					$dados['total'] = $total;
				}
				else
				{
					$dados['titulo'] = __("Exportação de vaga");
					$dados['mensagem'] = __("Exportação de vaga está processando.");
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
				$dados['erro'] = __("Nenhum vaga foi encontrado.");
			}
			//XDebug($dados, $this);
			return $dados;
		}
		################################################################################################################
		public function GetNomeFile($tipo = "geral")
		{
			$retorno = "exportacaovaga_".date("Y-m-d_H-i-s").".xls";
			try
			{
				if($tipo == "candidatos")
				{
					return "exportacao_lista_candidatos_".date("Y-m-d_H-i-s").".xls";
				}
				else
				{
					return $retorno;
				}
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
			if($tipo != "candidatos")
			{
				$campos = array(
					"ID" => "idvaga",
					"titulodavaga" => "titulodavaga",
					"empresacontratante" => "empresacontratante",
					"linhadereporte" => "linhadereporte",
					"faixaderemuneracaoinicial" =>"faixaderemuneracaoinicial",
					"faixaderemuneracaofim" => "faixaderemuneracaofim",
					"descricaodavaga" => "descricaodavaga",
					"tempocontratacao"=>"tempocontratacao",
					"nacionalidadeempresasprofissionaltrabalhou" => "nacionalidadeempresasprofissionaltrabalhou",
					"momentoatualempresa" => "momentoatualempresa",
					"tamanho" => "tamanho",
					"faturamento" => "faturamento",
					"idsetor" => "idsetor",
					"setor" => "setor",
					"área" => "area",
					"nível" => "nivel",
					"subareas" => "subareas",
					"incluirempresasforatarget" => "incluirempresasforatarget",
					"excluirprofissionaisjatrabalhouempresa" => "excluirprofissionaisjatrabalhouempresa",
					"selecionarempresas"=>"selecionarempresas",
					"melhores1000empresa" => "melhores1000empresa",
					"listada em bolsa" => "listadaembolsa",
					"startup" => "startup",
					"gptw" => "gptw",
					"perfil inovação" => "perfilinovacao",
					"status" => "status",
					"id do cliente" => "idcliente",
					"cliente" => "cliente",
					"cidade" => "cidade",
					"estado" => "estado",
					"pais" => "pais",
					"remoto"=>"remoto",
					"mobilidade"=>"mobilidade",
					"raio de pesquisa" => "raiodepesquisa",
					"cargos correlatos" => "cargos correlatos",
					"empresas correlatas" => "empresas correlatas",
					"empresas target" => "empresas target",
					"empresas target excluir" => "empresas target excluir",
					"setores target" => "setores target",
					"declarado" => "declarado",
					"autorizado" => "autorizado",
					"status" => "status",
					"fase1" => "fase1",
					"fase2" => "fase2",
					"fase3" => "fase3",
					"fase4" => "fase4",
					"fase5" => "fase5",
					"fase6" => "fase6",
					"total de candidato" => "candidatos",
					"ip" => "ip",
					"cadastradoem" => "cadastradoem",
				);
			}
			else
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
				$campos["interesse"] = "interesse";
				$campos["LKD_Twitter"] = "twitter";
				$campos["LKD_data_coleta"] = "datacoleta";
				$campos["LKD_data_aplicacao"] = "dataaplicacao";
				$campos["LKD_tipo"] = "vazio";
				$campos["Cidade"] = "cidade";
				$campos["Estado"] = "estado";
				$campos["Pais"] = "pais";
				$campos["coletar dados"] = "coletardados";
				$campos["tem anexo"] = "temanexo";
				$campos["tem celular"] = "temcelular";
				$campos["telefone_sobre"] = "telefone_sobre";
				$campos["telefone_sobre1"] = "telefone_sobre1";
				$campos["telefone_sobre2"] = "telefone_sobre2";
				$campos["tel_mapa"] = "tel_mapa";
				$campos["tel_ca"] = "tel_ca";
				$campos["avaliador"] = "cliente";
				$campos["interessemercado"] = "interessemercado";
				$campos["salariofixomensal"] = "salariofixomensal";
				$campos["bonusrealizadoanual"] = "bonusrealizadoanual";
				$campos["tipodecontratacao"] = "tipodecontratacao";
				$campos["situacaotelefone"] = "situacaotelefone";
				$lista = self::ListaCamposAvaliacao();
				if(!empty($lista))
				{
					foreach ($lista as $row)
					{
						$key = $row["campo"];
						$campos[$key] = $row["valor"];
					}
				}
				$campos["motivacaoparamudanca"] = "motivacaoparamudanca";
				$campos["observacao"] = "observacao";
				$campos["ip"] = "ip";
				$campos["cadastradoem"] = "cadastradoem";
			}
			return $campos;
		}
		################################################################################################################
		public function GetCaminho($file = "")
		{
			return $this->SetDominio($file);
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
				$id = $dados['idvaga'];

				$cargo = self::NewCargocorrelato();
				$dados['cargos correlatos'] = $cargo->ListadeCargo($id, ";");
				$empresacorrelata = self::NewEmpresacorrelata();
				$dados['empresas correlatas'] = $empresacorrelata->ListadeEmpresa($id, ";");
				$empresatarget = self::NewEmpresatarget();
				$dados['empresas target'] = $empresatarget->ListadeEmpresa($id, ";");
				$empresatargetexcluir = self::NewEmpresatargetexcluir();
				$dados['empresas target excluir'] = $empresatargetexcluir->ListadeEmpresa($id, ";");
				$setor = self::NewSetortarget();
				$dados['setores target'] = $setor->ListadeSetor($id, ";");
				$subarea = self::NewSubareavaga();
				$dados['subareas'] = $subarea->ListadeSubarea($id, ";");
				$candidato = self::NewCandidatoVaga();
				$dados['candidatos'] = $candidato->GetTotalVaga($id);
				return $dados;
			}
			catch( Exception $e )
			{
				throw new Exception( $e );
				return $retorno;
			}
		}
		################################################################################################################
		public function &GetDadosExcelCandidatos(&$dados = false)
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
				$id = $dados['idcandidato'];
				$idvaga = $dados['idvaga'];

				$idioma = self::NewCandidatoidioma();
				$idiomas = $idioma->ListaDeIdiomas($id);
				if(!empty($idiomas))
				{
					foreach($idiomas as $key=>$row)
					{
						$i = $key + 1;
						$dados["Idioma {$i}"] = $row['idioma'];
					}
				}
				$cargo = self::NewCandidatocargo();
				$cargos = $cargo->GetListaDeCargos($id);
				if(!empty($cargos))
				{
					foreach($cargos as $key=>$row)
					{
						$aux = preg_replace( '/\D/', '', $row['historico']);
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
				$favorito = self::NewFavorito();
				$dados["favorito"] = $favorito->GetCandidatoFavorito($id, $idvaga);
				$dados["desconsiderado"] = $favorito->GetCandidatoDesconsiderado($id, $idvaga);
				$toptalent = self::NewToptalent();
				$dados["toptalent"] = $toptalent->GetCandidatoToptalent($id, $idvaga);
				$perfil = self::NewCandidatoperfil();
				$dados["perfil"] = $perfil->GetCandidatoperfil($id, $idvaga);
				$novo = self::NewCandidatonovo();
				$dados["novo"] = $novo->GetCandidatoNovo($id, $idvaga);
				$interesse = self::NewCandidatointeresse();
				$dados["interesse"] = $interesse->GetCandidatoInteresse($id, $idvaga);

				/*$curso = self::NewCandidatocurso();
				$cursos = $curso->GetListaDeCursos($id);
				if(!empty($cursos))
				{
					foreach($cursos as $key=>$row)
					{
						$i = preg_replace( '/\D/', '', $row['historico']);
						$dados["instituicao {$i}"] = $row['instituicao'];
						$dados["curso {$i}"] = $row['curso'];
						$dados["inicio {$i}"] = $row['inicio'];
						$dados["termino {$i}"] = $row['termino'];
					}
				}

				$competencia = self::NewCandidatocompetencia();
				$competencias = $competencia->ListaDeCompetencias($id);
				if(!empty($competencias))
				{
					foreach($competencias as $key=>$row)
					{
						$i = $key + 1;
						$dados["Competencia {$i}"] = $row['competencia'];
					}
				}*/
				$dados["coletardados"] = self::GetColetarDados($dados["datacoleta"]);
				$avaliacao = self::NewAvaliacao();
				$avaliacao->GetDadosDeAvaliacao($dados);				
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
		public function LerListaVagas()
		{
			$idcliente = Get("idcliente", "0");
			$buscar = Get("buscar", "");
			$classificacao = Get("classificacao", "");
			$ativos = Get("ativos", "");
			$posicao = Get("posicao", 0);
			$limite = Get("limite", 15);
			$total = Get("total", 0);
			
			$ordem = "V.titulodavaga ASC";
			
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
			if(!empty($buscar))
			{
				$filtro .= " AND (V.titulodavaga LIKE '%{$buscar}%' OR V.descricaodavaga LIKE '%{$buscar}%' OR V.empresacontratante LIKE '%{$buscar}%' OR E.estado LIKE '%{$buscar}%' OR E.uf LIKE '%{$buscar}%' OR C.cidade LIKE '%{$buscar}%')";
			}
			if(!empty($ativos))
			{
				$filtro .= " AND (V.status = '{$ativos}')";
			}
			if(empty($total))
			{
				$sql = "SELECT COUNT(DISTINCT V.idvaga) AS CONT FROM vaga V LEFT JOIN estado E ON(E.idestado = V.idestado) LEFT JOIN cidade C ON(V.idcidade = C.idcidade) WHERE {$filtro}";
				$total = $this->TotalRegistro(false, $sql);
				if(empty($total))
				{
					$dados['sucesso'] = false;
					$dados['erro'] = __("Nenhuma vaga foi encontrada.");
					return $dados;
				}
			}
			if($limite < 0)
				$limite = $total;
			if(!empty($classificacao))
			{
				$ordem = self::GetOrdem($classificacao);
			}
			$filtro .= " ORDER BY {$ordem} LIMIT {$posicao}, {$limite}";
			$sql = "SELECT V.idvaga, V.titulodavaga, V.empresacontratante, V.status, V.cadastradoem, V.idvaga AS 'codigovaga', (SELECT COUNT(*) FROM candidatovaga CV WHERE CV.idvaga = V.idvaga) AS disponiveis, (SELECT COUNT(*) FROM candidatocontratado CT WHERE CT.idvaga = V.idvaga) AS contratados, (SELECT COUNT(*) FROM favorito F WHERE F.idvaga = V.idvaga AND F.tipo = 'Favorito') AS favoritos, C.cidade, E.estado, E.uf FROM vaga V LEFT JOIN estado E ON(E.idestado = V.idestado) LEFT JOIN cidade C ON(V.idcidade = C.idcidade) WHERE {$filtro}";
			$rows = $this->GetRows(false, $sql);
			if(!empty($rows))
			{
				$novaposicao = $posicao + $limite;
				if($novaposicao >= $total)
					$finalizado = true;
				else
					$finalizado = false;
				$dados['sucesso'] = true;
				$dados['lista'] = array_map(array($this,'Map'), $rows);
				$dados['mensagem'] = __("Lista de vaga foi encontrada com sucesso.");
				$dados['titulo'] = __("Sucesso");
				$dados['idcliente'] = intval($idcliente);
				$dados['posicao'] = $novaposicao;
				$dados['limite'] = intval($limite);
				$dados['total'] = intval($total);
				$dados['finalizado'] = $finalizado;
			}
			else
			{
				$dados['sucesso'] = false;
				$dados['erro'] = __("Nenhum nível foi encontrado.");
			}
			return $dados;
		}
		################################################################################################################
		public static function Map($row = false)
		{
			$row['idvaga'] = intval($row['idvaga']);
			if(!emptyData($row['cadastradoem']))
			{
				$ano = date("Y", TimeData($row['cadastradoem']));
				$row['abertura'] = date("d/m/Y", TimeData($row['cadastradoem']));				
			}
			else
			{
				$ano = date("Y");
				$row['abertura'] = "";				
			}
			$codigo = intval($row['codigovaga']);
			if($codigo < 10)
				$row['codigovaga'] = $ano."0".$codigo."T";
			else
				$row['codigovaga'] = $ano.$codigo."T";
			unset($row['cadastradoem']);
			return $row;
		}
		################################################################################################################
		public static function GetOrdem($classificacao = "")
		{
			$ordem = "";
			$classificacao = strtolower($classificacao);
			switch($classificacao)
			{
				case "por titulo em ordem crescente":
					$ordem = "V.titulodavaga ASC";
					break;
				case "por titulo em ordem decrescente":
					$ordem = "V.titulodavaga DESC";
					break;
				case "por data de abertura em ordem crescente":
					$ordem = "V.cadastradoem DESC";
					break;
				case "por data de abertura em ordem decrescente":
					$ordem = "V.cadastradoem ASC";
					break;
				case "por status em ordem crescente":
					$ordem = "V.status ASC";
					break;
				case "por status em ordem decrescente":
					$ordem = "V.status DESC";
					break;
				case "por selecionados em ordem crescente":
					$ordem = "selecionados ASC";
					break;
				case "por selecionados em ordem decrescente":
					$ordem = "selecionados DESC";
					break;
				case "por contratados em ordem crescente":
					$ordem = "contratados ASC";
					break;
				case "por contratados em ordem decrescente":
					$ordem = "contratados DESC";
					break;
				case "por recomendados em ordem crescente":
					$ordem = "recomendados ASC";
					break;
				case "por recomendados em ordem decrescente":
					$ordem = "recomendados DESC";
					break;
				default:
					$ordem = "V.titulodavaga ASC";
				
			}
			return $ordem;
		}
		################################################################################################################
		public function GetTotalCandidatos($idvaga = 0)
		{
			if(empty($idvaga))
				return 0;
			$sql = "SELECT COUNT(*) AS CONT FROM candidato C INNER JOIN candidatovaga CV FORCE INDEX(idxcandidato, idxvaga) ON(C.idcandidato = CV.idcandidato) INNER JOIN vaga V ON(CV.idvaga = V.idvaga) WHERE V.idvaga = '{$idvaga}'";

			return $this->TotalRegistro(false, $sql);
		}
		################################################################################################################
		public function LerOpcaoClassificacaoVagas()
		{
			$titulo = __("Sucesso");
			$mensagem = __("Lista de opções da classificação do candidatos.");
			$rows = array( 
				//array("texto"=>"Data de abertura: a partir da mais recente", "valor"=>"por data de abertura em ordem crescente"), 
				//array("texto"=>"Data de abertura: a partir da mais antiga", "valor"=>"por data de abertura em ordem decrescente"), 
				array("texto"=>"Título da vaga: A-Z", "valor"=>"por titulo em ordem crescente"), 
				array("texto"=>"Título da vaga: Z-A", "valor"=>"por titulo em ordem decrescente")
				/*,
				array("texto"=>"Por status da vaga em ordem crescente", "valor"=>"por status em ordem crescente"), 
				array("texto"=>"Por status da vaga em ordem decrescente", "valor"=>"por status em ordem decrescente"), 
				array("texto"=>"Por número de selecionados em ordem crescente", "valor"=>"por selecionados em ordem crescente"), 
				array("texto"=>"Por número de selecionados em ordem decrescente", "valor"=>"por selecionados em ordem decrescente"),
				array("texto"=>"Por número de contratados em ordem crescente", "valor"=>"por contratados em ordem crescente"), 
				array("texto"=>"Por número de contratados em ordem decrescente", "valor"=>"por contratados em ordem decrescente"),
				array("texto"=>"Por número de recomendados em ordem crescente", "valor"=>"por recomendados em ordem crescente"), 
				array("texto"=>"Por número de recomendados em ordem decrescente", "valor"=>"por recomendados em ordem decrescente")*/
			);	
			
			$dados['sucesso'] = true;
			$dados['opcoes'] = $rows;
			$dados['mensagem'] = $mensagem;
			$dados['titulo'] = $titulo;
			return $dados;
		}
		################################################################################################################
		public function LerOpcaoAtivoVagas()
		{
			$titulo = __("Sucesso");
			$mensagem = __("Lista de opções da classificação do candidatos.");
			$rows = array(
				array("texto"=>"Cadastro incompleto da vaga", "valor"=>"Cadastro incompleto da vaga"), 
				array("texto"=>"Aguardando análise", "valor"=>"Aguardando análise"), 
				array("texto"=>"Candidatos disponíveis", "valor"=>"Candidatos disponíveis"), 
				array("texto"=>"Concluido", "valor"=>"Concluido"), 
				array("texto"=>"Cancelado pelo cliente", "valor"=>"Cancelado pelo cliente")
			);
			$dados['sucesso'] = true;
			$dados['opcoes'] = $rows;
			$dados['mensagem'] = $mensagem;
			$dados['titulo'] = $titulo;
			return $dados;
		}
		public function AlertaEmail()
		{
			// multiple recipients
			$to  = 'robertocunha@candidatoagora.com.br, danielelopes@candidatoagora.com.br, andremoreira@candidatoagora.com.br';
			//$to  = 'washcosme@gmail.com';
			// subject
			if(empty($this->idcliente))
				return;
			$cliente = GetModelo("cliente");
			$cliente->idcliente = $this->idcliente;
			if(!$cliente->Load())
			{
				return;
			}
			$dominio = GetDomino();
			$datacadastro = date("Y-m-d H:i:s");
			$ip = GetIP();
			$subject = 'Cadastro de vaga no site '.$dominio.' de '.$cliente->nome;

			// message
			$message = '
			<html>
			<head>
			<title>Cadastro de vaga no site '.$dominio.'</title>
			</head>
			<body>
			<p>Informações sobre o cadastro da vaga</p>
			<table>
			<tr>
			<td><b>Nome:</b></td><td>'.$cliente->nome.'</td>
			</tr>
			<tr>
			<td><b>E-mail:</b></td><td>'.$cliente->email.'</td>
			</tr>
			<tr>
			<td><b>Empresa:</b></td><td>'.$cliente->empresa.'</td>
			</tr>
			<tr>
			<td><b>Vaga:</b></td><td>'.$this->titulodavaga.'</td>
			</tr>
			<tr>
			<td><b>Data:</b></td><td>'.$datacadastro.'</td>
			</tr>
			<tr>
			<td><b>IP</b></td><td>'.$ip.'</td>
			</tr>
			</table>
			</body>
			</html>
			';

			// To send HTML mail, the Content-type header must be set
			$headers  = 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

			// Additional headers
			$headers .= 'To: Candidato Agora <'.$to.'>' . "\r\n";
			$headers .= 'From: Candidato Agora <'.$to.'>' . "\r\n";

			// Mail it
			mail($to, $subject, $message, $headers);
		}
		################################################################################################################
		public static function &ListaCamposAvaliacao()
		{
			$sql = "SELECT AC.titulo AS 'campo', CONCAT('marcado', AC.idavaliacaocompetencia) AS valor FROM avaliacaocompetencia AC WHERE AC.ativo = 'Sim' ORDER BY AC.ordem ASC";
			$rows = self::GetSqlrows($sql, false);
			return $rows;
		}
		################################################################################################################
		public function &BuscarFiltrosDeNomeEmpresas()
		{
			$filtro = "1";
			$search =  Get("search","");
			if(!empty($search))
			{
				$filtro .= " AND V.empresacontratante LIKE '%{$search}%'";
			}
			$sql = "SELECT DISTINCT IF(V.empresacontratante != '', V.empresacontratante, '-1') AS id,  IF(V.empresacontratante != '', V.empresacontratante, ' Empresa não definida') AS 'text' FROM vaga V WHERE {$filtro} ORDER BY text ASC";
			$lista = $this->GetRows(false, $sql);
			return $lista;
		}
		################################################################################################################
		public function &BuscarFiltrosDeVagas()
		{
			$filtro = "1";
			$search =  Get("search","");
			$nomeempresa =  trim(Get("nomeempresa",""));
			if(!empty($search))
			{
				$filtro .= " AND V.titulodavaga LIKE '%{$search}%'";
			}
			if(!empty($nomeempresa))
			{
				if($nomeempresa == "-1")
					$filtro .= " AND V.empresacontratante != ''";
				else
					$filtro .= " AND V.empresacontratante = '{$nomeempresa}'";
			}
			$sql = "SELECT V.idvaga AS id,  IF(V.empresacontratante = '', TRIM(V.titulodavaga), IF(V.titulodavaga = '',TRIM(V.empresacontratante), TRIM(CONCAT(V.titulodavaga,' (',V.empresacontratante,')')))) AS 'text' FROM vaga V WHERE {$filtro} ORDER BY text ASC";
			$lista = $this->GetRows(false, $sql);
			return $lista;
		}
		################################################################################################################
		public function LerIdVaga($palavraschaves = false, $idcliente = 0)
		{
			if(empty($palavraschaves))
			{
				return 0;
			}
			$palavraschaves = trim($palavraschaves," \n\t\r");
			$aux = Escape($palavraschaves);
			$sql = "SELECT idvaga AS id FROM {$this->Tabela} WHERE titulodavaga = '{$aux}' AND idcliente = '{$idcliente}' LIMIT 1";
			$id = $this->GetSqlCampo($sql,"id", 0);
			if(empty($id))
			{
				$this->idvaga = 0;
				$this->idcliente = $idcliente;
				$this->titulodavaga = $palavraschaves;
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
		public function __destruct()
		{
			unset($this->dados, $this->Tabela, $this->PrimaryKey);
		}
	}
}
?>
