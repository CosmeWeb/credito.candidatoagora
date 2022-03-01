<?php
/***********************************************************************
 * Module:  /models/Empresa_model.PHP
 * Author:  Host-up
 * Date:	06/04/2020 16:14:28
 * Purpose: Definição da Classe Empresa_model
 * Instancias: $this->load->model('Empresa_model', 'empresa');
 * Objeto: $empresa = $this->empresa->GetInstancia($dados);
 ***********************************************************************/
if (!class_exists('Empresa_model'))
{
	class Empresa_model extends MY_Model
	{
		private static $setor = null;
		private static $tamanho = null;
		private static $nacionalidade = null;
		################################################################################################################
		public function __construct( $dados = false)
		{
			try
			{
				$this->Tabela = "empresa";
				$this->PrimaryKey = "idempresa";
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
				if(empty($this->gptw))
					$this->gptw = "Não";
				if(empty($this->melhores1000empresa))
					$this->melhores1000empresa = "Não";
				if(empty($this->startup))
					$this->startup = "Não";
				if(empty($this->perfilformcaopessoas))
					$this->perfilformcaopessoas = "Não";
				if(empty($this->perfilresultadoagressivo))
					$this->perfilresultadoagressivo = "Não";
				if(empty($this->perfilinovacao))
					$this->perfilinovacao = "Não";
				if(empty($this->listadaembolsa))
					$this->listadaembolsa = "Não";
				if(empty($this->empresarelevante))
					$this->empresarelevante = "Não";
			}
			else
			{

			}
		}
		################################################################################################################
		public static function &NewSetor() {
			if (self::$setor == null)
				self::$setor = GetModelo("setor");
			return self::$setor;
		}
		################################################################################################################
		public static function &NewTamanho() {
			if (self::$tamanho == null)
				self::$tamanho = GetModelo("tamanho");
			return self::$tamanho;
		}
		################################################################################################################
		public static function &NewNacionalidade() {
			if (self::$nacionalidade == null)
				self::$nacionalidade = GetModelo("nacionalidade");
			return self::$nacionalidade;
		}
		################################################################################################################
		public function GerarOpcoesSetor($value = "0", $texto = "", $default = "0")
		{
			if(empty($texto))
				$texto = __("-- Selecione --");
			$primeiro = array("valor"=>$default,"texto"=>$texto);
			$sql = "SELECT idsetor AS 'id', setor AS 'texto' FROM setor ORDER BY texto ASC";
			return $this->GeraOpcoesSql($value, $sql, "id", "texto", $primeiro);
		}
		################################################################################################################
		public function GerarOpcoesTamanho($value = "0", $texto = "", $default = "0")
		{
			if(empty($texto))
				$texto = __("-- Selecione --");
			$primeiro = array("valor"=>$default,"texto"=>$texto);
			$sql = "SELECT idtamanho AS 'id', tamanho AS 'texto' FROM tamanho ORDER BY texto ASC";
			return $this->GeraOpcoesSql($value, $sql, "id", "texto", $primeiro);
		}
		################################################################################################################
		public function GerarOpcoesNacionalidade($value = "0", $texto = "", $default = "0")
		{
			if(empty($texto))
				$texto = __("-- Selecione --");
			$primeiro = array("valor"=>$default,"texto"=>$texto);
			$sql = "SELECT idnacionalidade AS 'id', nacionalidade AS 'texto' FROM nacionalidade ORDER BY texto ASC";
			return $this->GeraOpcoesSql($value, $sql, "id", "texto", $primeiro);
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
		public function GerarOpcoesMelhores1000empresa($value = "", $texto = "", $default = "")
		{
			if(empty($texto))
				$texto = __("-- Selecione --");
			$primeiro = array("valor"=>$default,"texto"=>$texto);
			return $this->GeraOpcoesEnum($value, $this->Tabela, "melhores1000empresa", $primeiro);
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
		public function GerarOpcoesPerfilformcaopessoas($value = "", $texto = "", $default = "")
		{
			if(empty($texto))
				$texto = __("-- Selecione --");
			$primeiro = array("valor"=>$default,"texto"=>$texto);
			return $this->GeraOpcoesEnum($value, $this->Tabela, "perfilformcaopessoas", $primeiro);
		}
		################################################################################################################
		public function GerarOpcoesPerfilresultadoagressivo($value = "", $texto = "", $default = "")
		{
			if(empty($texto))
				$texto = __("-- Selecione --");
			$primeiro = array("valor"=>$default,"texto"=>$texto);
			return $this->GeraOpcoesEnum($value, $this->Tabela, "perfilresultadoagressivo", $primeiro);
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
		public function GerarOpcoesListadaembolsa($value = "", $texto = "", $default = "")
		{
			if(empty($texto))
				$texto = __("-- Selecione --");
			$primeiro = array("valor"=>$default,"texto"=>$texto);
			return $this->GeraOpcoesEnum($value, $this->Tabela, "listadaembolsa", $primeiro);
		}
		################################################################################################################
		public function GerarOpcoesEmpresarelevante($value = "", $texto = "", $default = "")
		{
			if(empty($texto))
				$texto = __("-- Selecione --");
			$primeiro = array("valor"=>$default,"texto"=>$texto);
			return $this->GeraOpcoesEnum($value, $this->Tabela, "empresarelevante", $primeiro);
		}
		################################################################################################################
		public function PrintRadioSimOuNao($campo = "", $defult = "")
		{
			$retorno = "";
			try
			{
				$checkSim = $this->FormGetRadio($campo,"Sim");
				$checkNao = $this->FormGetRadio($campo,"Não");
				$html = '<div class="radio"><label>';
                $html .= '<input id="'.$campo.'Sim" type="radio" name="'.$campo.'" value="Sim" '.$checkSim.' />&nbsp;Sim';
				$html .= '</label><label>';
				$html .= '<input id="'.$campo.'Nao" type="radio" name="'.$campo.'" value="Não" '.$checkNao.' />&nbsp;Não';
				$html .= '</label></div>';
				
				return $html;
			}
			catch( Exception $e )
			{
				throw new Exception( $e );
				return $retorno;
			}
		}
		################################################################################################################
		public function PrintRadioMelhores($campo = "", $defult = "")
		{
			$retorno = "";
			try
			{
				$checkSim = $this->FormGetRadio($campo,"+1000M");
				$checkNao = $this->FormGetRadio($campo,"Não");
				$html = '<div class="radio"><label>';
				$html .= '<input id="'.$campo.'1000M" type="radio" name="'.$campo.'" value="+1000M" '.$checkSim.' />&nbsp;Lista +1000 Maiores';
				$html .= '</label><label>';
				$html .= '<input id="'.$campo.'Nao" type="radio" name="'.$campo.'" value="Não" '.$checkNao.' />&nbsp;Não';
				$html .= '</label></div>';
				
				return $html;
			}
			catch( Exception $e )
			{
				throw new Exception( $e );
				return $retorno;
			}
		}
		################################################################################################################
		public function GetSqlLista()
		{
			$retorno = "";
			try
			{
				return "SELECT E.*, S.setor, T.tamanho, N.nacionalidade FROM empresa E LEFT JOIN setor S ON(E.idsetor = S.idsetor) LEFT JOIN tamanho T ON(E.idtamanho = T.idtamanho) LEFT JOIN nacionalidade N ON(E.idnacionalidade = N.idnacionalidade)";
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
				return "SELECT COUNT(DISTINCT E.idempresa) AS CONT FROM empresa E ";
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
				$filtro .= " AND E.empresa LIKE '%{$buscar}%'";
			}
			
			$idsetor = GetFiltro("idsetor");
			if(!empty($idsetor))
			{
				$filtro .= " AND E.idsetor = '{$idsetor}'";
			}
			$idtamanho = GetFiltro("idtamanho");
			if(!empty($idtamanho))
			{
				$filtro .= " AND E.idtamanho = '{$idtamanho}'";
			}
			$idnacionalidade = GetFiltro("idnacionalidade");
			if(!empty($idnacionalidade))
			{
				$filtro .= " AND E.idnacionalidade = '{$idnacionalidade}'";
			}
			$gptw = GetFiltro("gptw");
			if(!empty($gptw))
			{
				$filtro .= " AND E.gptw = '{$gptw}'";
			}
			$melhores1000empresa = GetFiltro("melhores1000empresa");
			if(!empty($melhores1000empresa))
			{
				$filtro .= " AND E.melhores1000empresa = '{$melhores1000empresa}'";
			}
			$startup = GetFiltro("startup");
			if(!empty($startup))
			{
				$filtro .= " AND E.startup = '{$startup}'";
			}
			$perfilformcaopessoas = GetFiltro("perfilformcaopessoas");
			if(!empty($perfilformcaopessoas))
			{
				$filtro .= " AND E.perfilformcaopessoas = '{$perfilformcaopessoas}'";
			}
			$perfilresultadoagressivo = GetFiltro("perfilresultadoagressivo");
			if(!empty($perfilresultadoagressivo))
			{
				$filtro .= " AND E.perfilresultadoagressivo = '{$perfilresultadoagressivo}'";
			}
			$perfilinovacao = GetFiltro("perfilinovacao");
			if(!empty($perfilinovacao))
			{
				$filtro .= " AND E.perfilinovacao = '{$perfilinovacao}'";
			}
			$listadaembolsa = GetFiltro("listadaembolsa");
			if(!empty($listadaembolsa))
			{
				$filtro .= " AND E.listadaembolsa = '{$listadaembolsa}'";
			}
			$empresarelevante = GetFiltro("empresarelevante");
			if(!empty($empresarelevante))
			{
				$filtro .= " AND E.empresarelevante = '{$empresarelevante}'";
			}
			if(!empty($filtro))
			{
				$filtro  = substr($filtro, 4);
			}
			if($semOrder)
			{
				return $filtro;
			}
			$ordem = array('E.idempresa', 'E.empresa', 'S.setor', 'T.tamanho', 'N.nacionalidade', 'E.gptw', 'E.melhores1000empresa', 'E.startup', 'E.perfilformcaopessoas', 'E.perfilresultadoagressivo', 'E.perfilinovacao', 'E.listadaembolsa', 'E.empresarelevante', 'E.idempresa');
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
			$obj = GetModelo("empresa");
			if(empty($obj))
				return $retorno;
			foreach ($lista as $key=>$linha)
			{
				$obj->SalvarListaEmpresa($linha);
			}
			return true;
		}
		################################################################################################################
		public function SalvarListaEmpresa($dados = false)
		{
			if(empty($dados))
				return 0;
			$empresa = self::GetDadosChave($dados, array('empresa','Empresa','EMPRESA'));
			if(empty($empresa))
				return 0;
			$aux = Escape($empresa);
			$filtro = "empresa = '{$aux}'";
			$obj = $this->FiltroObjeto($filtro);
			if(empty($obj))
			{
				$obj = $this->GetInstancia();
				$obj->empresa = $empresa;
				$obj->idempresa = 0;
				$id = 0;
			}
			else
			{
				$id = $obj->idempresa;
			}
			$setor = self::NewSetor();
			$tamanho = self::NewTamanho();
			$nacionalidade = self::NewNacionalidade();
			
			$nomesetor = self::GetDadosChave($dados,array("setor","Setor","SETOR"));
			$obj->idsetor = $setor->LerIdSetor($nomesetor);

			$nometamanho = self::GetDadosChave($dados,array("tamanho","Tamanho","TAMANHO",'func','FUNCIONARIO','funcionario','FUNCIONARIOS','funcionarios'));
			$obj->idtamanho = $tamanho->LerIdTamanho($nometamanho);

			$nacao = self::GetDadosChave($dados,array("origemcapital","Origemcapital","ORIGEMCAPITAL","nacionalidade","Nacionalidade","NACIONALIDADE"));
			$obj->idnacionalidade = $nacionalidade->LerIdNacionalidade($nacao);
			
			$gptw = self::GetDadosChave($dados,array("gptw","Gptw","GPTW"));
			if(!empty($gptw))
				$obj->gptw = $gptw;
			$melhores1000empresa = self::GetDadosChave($dados,array("melhores1000empresa","Melhores1000empresa","MELHORES1000EMPRESA"));
			if(!empty($melhores1000empresa))
				$obj->melhores1000empresa = $melhores1000empresa;
			$startup = self::GetDadosChave($dados,array("startup","startup","STARTUP"));
			if(!empty($startup))
				$obj->startup = $startup;
			$perfilformcaopessoas = self::GetDadosChave($dados,array("perfilformcaopessoas","Perfilformcaopessoas","PERFILFORMCAOPESSOAS"));
			if(!empty($perfilformcaopessoas))
				$obj->perfilformcaopessoas = $perfilformcaopessoas;
			$perfilresultadoagressivo = self::GetDadosChave($dados,array("perfilresultadoagressivo","Perfilresultadoagressivo","PERFILRESULTADOAGRESSIVO"));
			if(!empty($perfilresultadoagressivo))
				$obj->perfilresultadoagressivo = $perfilresultadoagressivo;
			$perfilinovacao = self::GetDadosChave($dados,array("perfilinovacao","Perfilinovacao","PERFILINOVACAO"));
			if(!empty($perfilinovacao))
				$obj->perfilinovacao = $perfilinovacao;
			$empresarelevante = self::GetDadosChave($dados,array("empresarelevante","empresa relevante","empresasrelevante","empresas relevante","EMPRESARELEVANTE", "EMPRESA RELEVANTE","EMPRESASRELEVANTE", "EMPRESAS RELEVANTE"));
			if(!empty($empresarelevante))
				$obj->empresarelevante = $empresarelevante;
			$listadaembolsa = self::GetDadosChave($dados,array("listadaembolsa","Listadaembolsa","listada em bolsa","LISTADAEMBOLSA"));
			if(!empty($listadaembolsa))
				$obj->listadaembolsa = $listadaembolsa;
			
			$obj->Ajustar(true);
			$idempresa = $obj->Salvar();
			if(empty($id))
				$obj->idempresa = $idempresa;
			return $obj->idempresa;
		}
		################################################################################################################
		public function ExportarEmpresa()
		{
			$filtro = $this->Filtro(true);
			$filtro .= " ORDER BY empresa ASC";
			$obj = GetModelo('empresa');
			$sql = $this->GetSqlLista();
			$objs = $obj->FiltroObjetos($filtro, $sql);
			if($objs)
			{
				$file = $obj->GetNomeFile();
				$data = array(
					"file"=> $file,
					"lista"=>$objs,
					"html"=>true,
					"campos"=>$obj->GetNomesCampos(),
					"download"=>false,
					"pasta"=>$obj->GetCaminho()
				);
				Excel($data);
				$dados['sucesso'] = true;
				$dados['mensagem'] = __("Verificação de empresa foi finalizado.<br/>O download se iniciará em instantes");
				$dados['url'] = site_url("empresa/baixarempresa/{$file}");
				$dados['titulo'] = __("Exportação de empresa");
			}
			else
			{
				$dados['sucesso'] = false;
				$dados['erro'] = __("Nenhum empresa foi encontrado.");
			}
			return $dados;
		}
		################################################################################################################
		public function GetNomeFile()
		{
			$retorno = "exportacaoempresa_".date("Y-m-d_H-i-s").".xls";
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
			$campos = array("ID"=>"idempresa","empresa"=>"empresa");
			return $campos;
		}
		################################################################################################################
		public function GetCaminho($file = "")
		{
			return $this->SetDominio($file);
		}
		################################################################################################################
		public function &BuscarFiltrosDeEmpresas()
		{
			$filtro = " WHERE E.empresa != '' ";
			$search =  Get("search","");
			if(!empty($search))
			{
				$filtro .= " AND E.empresa LIKE '%{$search}%'";
			}
			$idvaga =  Get("idvaga","");
			if(!empty($idvaga))
			{
				$filtro .= " AND ET.idempresatarget IS NULL";
			}
			$sql = "SELECT DISTINCT '0' AS idempresatarget, E.idempresa AS id, E.empresa, E.idsetor FROM empresa E LEFT JOIN empresatarget ET ON(E.idempresa = ET.idempresa AND  ET.idvaga = '{$idvaga}') {$filtro} ORDER BY E.empresa ASC";
			$lista = $this->GetRows(false, $sql);
			return $lista;
		}
		################################################################################################################
		public function __destruct()
		{
			unset($this->dados, $this->Tabela, $this->PrimaryKey);
		}
	}
}
?>