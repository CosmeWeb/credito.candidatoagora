<?php
	if (!defined('BASEPATH')) exit('No direct script access allowed');

class MY_Model extends CI_Model
{
	// Variável que define o nome da tabela
	public $Tabela = "";
	public $PrimaryKey = "";
	public $dados = NULL;
	public static $exibirprimeiro = true;
	private static $camposdefault = NULL;

	#######################################################################################################################
	function __construct($dados = false) {
		parent::__construct();
		if(!empty($dados))
		{
			if(is_array($dados))
			{
				$this->Carregar($dados);
			}
			elseif(is_string($dados))
			{
				$row = $this->GetRow($dados);
				if($row)
					$this->Carregar($row);
				else
					$this->Carregar($this->GetDefault());
			}
			elseif(is_numeric($dados))
			{
				$row = $this->GetRow($dados);
				if($row)
					$this->Carregar($row);
				else
					$this->Carregar($this->GetDefault());
			}
		}
		else
			$this->Carregar($this->GetDefault());
	}
	################################################################################################################
	public function &GetInstancia($dados = false)
	{
		$obj = false;
		$nome = get_class($this);
		$obj = new $nome($dados);
		return $obj;
	}
	################################################################################################################
	public function __set($name, $value)
	{
		$this->dados[$name] = $value;
		$this->$name = $value;
	}
	################################################################################################################
	public function Get($nome = "", $defult = "")
	{
		$valor = $defult;
		if(isset($this->$nome))
		{
			$valor = $this->$nome;
		}
		elseif(isset($this->dados[$nome]))
		{
			$valor = $this->dados[$nome];
		}
		return $valor;
	}
	################################################################################################################
	public function Set($nome = "", $valor = "", $defult = "")
	{
		if(empty($valor))
		{
			if(!empty($defult))
				$valor = $defult;
		}
		if(!is_numeric($nome))
		{
			$this->$nome = $valor;
			$this->dados[$nome] = $valor;
		}
		return;
	}
	################################################################################################################
	public function FormGet($nome = "", $defult = "", $nomePadrao = false)
	{
		if(empty($nomePadrao))
		{
			$nomePadrao = $nome;
			$nomePadrao = str_replace("[]", "", $nomePadrao);
		}
		return set_value($nome, @$this->Get($nomePadrao, $defult));
	}
	################################################################################################################
	public function FormGetRadio($nome = "", $valor = "", $defult = "")
	{
		$aux = $this->FormGet($nome, $defult);
		if($aux == $valor)
			return 'checked="checked"';
		else
			return '';
	}
	################################################################################################################
	public function SetCheck($campo = "", $valor = "")
	{
		if(empty($campo))
			return;
		$aux = $this->Get($campo);
		if(empty($aux))
		{
			$this->Get($campo, $valor);
		}
		return;
	}
	################################################################################################################
	public function GetID()
	{
    	return $this->Get($this->PrimaryKey, 0);
	}
	################################################################################################################
	public function SetID($valor = "", $defult = 0)
	{
		return $this->Set($this->PrimaryKey, $valor, $defult);
	}
	################################################################################################################
	public function SetExibirPrimeiro($primeiro = true )
	{
		self::$exibirprimeiro = $primeiro;
	}
	################################################################################################################
	public function &FiltroObjetos($filtro = false, $sql = "", $defult = false)
	{
		$retorno = false;
		try
		{
			$instancia = $retorno;
			$rows = $this->GetRows($filtro, $sql, $defult);
			if(!empty($rows))
			{
				foreach ($rows as $key => $row)
				{
					$instancia[] = $this->GetInstancia($row);
				}
			}
			return $instancia;
		}
		catch( Exception $e )
		{
			throw new Exception( $e );
			return $retorno;
		}
	}
	################################################################################################################
	public function &FiltroObjeto($filtro = false, $sql = "", $defult = false)
	{
		$retorno = false;
		try
		{
			$instancia = $retorno;
			$row = $this->GetRow($filtro, $sql, $defult);
			if(!empty($row))
			{
				$instancia = $this->GetInstancia($row);
			}
			return $instancia;
		}
		catch( Exception $e )
		{
			throw new Exception( $e );
			return $retorno;
		}
	}
	################################################################################################################
	public function &FiltroJson($filtro = false, $sql = "", $defult = false)
	{
		$retorno = false;
		try
		{
			$instancia = $retorno;
			$rows = $this->GetRows($filtro, $sql, $defult);
			if(!empty($rows))
			{
				foreach ($rows as $key => $row)
				{
					$instancia[] = $this->GetJson($row);
				}
			}
			return $instancia;
		}
		catch( Exception $e )
		{
			throw new Exception( $e );
			return $retorno;
		}
	}
	################################################################################################################
	public function &GetRows($filtro = false, $sql = "", $defult = false)
	{
		$retorno = false;
		try
		{
			$valor = $defult;
			if((empty($sql))&&(empty($this->Tabela)))
				return $retorno;
			if(empty($sql))
				$sql = "SELECT * FROM {$this->Tabela}";
			$onde = self::MontarFiltro($filtro, $this->Tabela, $this->PrimaryKey);
			$sql .= $onde; //P($sql);exit();
			$query = $this->db->query($sql);
			$rows = $query->result_array();
			if($rows)
				return $rows;
			else
				return $retorno;
		}
		catch( Exception $e )
		{
			throw new Exception( $e );
			return $retorno;
		}
	}
	################################################################################################################
	public function &GetRow($filtro = false, $sql = "", $defult = false)
	{
		$retorno = false;
		try
		{
			$valor = $defult;
			if((empty($sql))&&(empty($this->Tabela)))
				return $retorno;
			if(empty($sql))
				$sql = "SELECT * FROM {$this->Tabela}";
			$onde = self::MontarFiltro($filtro, $this->Tabela, $this->PrimaryKey);
			$sql .= $onde;
			$query = $this->db->query($sql);//P($sql);
			$valor = $query->row_array();
			if(empty($valor))
				return $retorno;
			return $valor;
		}
		catch( Exception $e )
		{
			throw new Exception( $e );
			return $retorno;
		}
	}
	################################################################################################################
	public function Existe($filtro = false, $sql = "", $campo = "CONT")
	{
		$retorno = false;
		try
		{
			if((empty($sql))&&(empty($this->Tabela)))
				return $retorno;
			if(empty($sql))
				$sql = "SELECT COUNT(*) AS CONT FROM {$this->Tabela}";
			if(empty($filtro))
			{
				if(empty($this->dados))
					return $retorno;
				foreach ($this->dados as $key => $value)
				{
					if(!empty($value))
						$filtro[$key] = $value;
				}
			}
			$onde = self::MontarFiltro($filtro, $this->Tabela, $this->PrimaryKey);
			$sql .= $onde;
			$valor = self::GetSqlCampo($sql, $campo, 0);
			if(empty($valor))
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
	public function Load($filtro = false, $sql = "", $defult = false)
	{
		$retorno = false;
		try
		{
			if((empty($filtro))&&(empty($sql)))
			{
				$id = $this->Get($this->PrimaryKey,0);
				if(empty($id))
					return $retorno;
				else
				{
					$filtro[$this->PrimaryKey] = $id;
				}
			}
			$dados = $this->GetRow($filtro, $sql, $defult);
			if(empty($dados))
				return $retorno;
			@$this->Carregar($dados);
			return true;
		}
		catch( Exception $e )
		{
			throw new Exception( $e );
			return $retorno;
		}
	}
	################################################################################################################
	public function &GetDefault()
	{
		$retorno = false;
		try
		{
			if(empty($this->Tabela))
			{
				return $retorno;
			}
			if((self::$camposdefault == NULL)||(empty(self::$camposdefault[$this->Tabela])))
			{
				$retorno = $this->LerCacheColunasDefault(60*60);
				if(!empty($retorno))
					self::$camposdefault[$this->Tabela] = $retorno;
			}
			return self::$camposdefault[$this->Tabela];
		}
		catch( Exception $e )
		{
			throw new Exception( $e );
			return $retorno;
		}
	}
	################################################################################################################
	public function LerCacheColunasDefault($tempo = 300)
	{
		$retorno = false;
		try
		{
			$nome = "CamposClasse".$this->Tabela;
			$CI =& get_instance();
			
			if($CI->cache->memcached->is_supported())
			{
				if (!$retorno = $CI->cache->memcached->get($nome)) {
					$retorno = $this->GetColunasDefault();
					$CI->cache->memcached->save($nome, $retorno, $tempo);
				}
			}
			elseif($CI->cache->apc->is_supported())
			{
				if (!$retorno = $CI->cache->apc->get($nome)) {
					$retorno = $this->GetColunasDefault();
					$CI->cache->apc->save($nome, $retorno, $tempo);
				}
			}
			elseif($CI->cache->file->is_supported())
			{
				if (!$retorno = $CI->cache->file->get($nome)) {
					$retorno = $this->GetColunasDefault();
					$CI->cache->file->save($nome, $retorno, $tempo);
				}
			}
			else
			{
				$retorno = $this->GetColunasDefault();
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
	public function &GetColunasDefault()
	{
		$retorno = false;
		try
		{
			if(empty($this->Tabela))
			{
				return $retorno;
			}
			$sql = "SHOW COLUMNS FROM {$this->Tabela}";
			$query = $this->db->query($sql);
			if(!empty($query))
				$rows = $query->result_array();
			if(isset($rows))
			{
				foreach($rows as $key => $row)
				{
					$chave = $row['Field'];
					$valor = $row['Default'];
					if($row['Key'] == 'PRI')
						$valor = 0;
					if($valor == NULL)
						$valor = "";
					$retorno[$chave] = $valor;
				}
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
	public function SetDefault($dados = false)
	{
		$retorno = false;
		try
		{
			if(empty($dados))
			{
				$this->Carregar($this->GetDefault());
			}
			else
			{
				$this->Carregar($dados, $this->GetDefault());
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
	public function SetDados()
	{
		$retorno = false;
		try
		{
			if(empty($this->dados))
			{
				$this->Carregar($this->GetDefault());
			}
			if(is_array($this->dados))
			{
				foreach ($this->dados as $key => $value)
				{
					$this->dados[$key] = $this->Get($key, $value);
				}
				return true;
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
	public function &GetDados()
	{
		$retorno = false;
		try
		{
			$this->SetDados();
			return $this->dados;
		}
		catch( Exception $e )
		{
			throw new Exception( $e );
			return $retorno;
		}
	}
	################################################################################################################
	public function Carregar( $dados = false, $defult = false)
	{
		try
		{
			if(is_array($defult))
			{
				$dados = CompletaArray( $dados, $defult);
			}
			if( is_array( $dados ) )
			{
				foreach( $dados as $key => $value )
				{
					$this->Set($key, $value);
				}
			}
			$id = $this->Get($this->PrimaryKey,0);
			if(empty($id))
				$this->Set($this->PrimaryKey,0);
		}
		catch( Exception $e )
		{
			throw new Exception( $e );
		}
	}
	################################################################################################################
	public static function Query($sql = "", $defult = false)
	{
		if(empty($sql))
			return $defult;
		$CI	=& get_instance();
		$query = $CI->db->query($sql);

		return $query;
	}
	################################################################################################################
	public static function GetSqlrows($sql = "", $default = false)
	{
		if(empty($sql))
			return $default;
		$CI	=& get_instance();
		$query = $CI->db->query($sql);
		if(empty($query))
			return $default;
		$rows = $query->result_array();
		if($rows)
			return $rows;
		return $default;
	}
	################################################################################################################
	public static function GetSqlrow($sql = "", $defult = false)
	{
		if(empty($sql))
			return $defult;
		$CI	=& get_instance();
		$query = $CI->db->query($sql);
		$row = $query->row_array();
		if (isset($row))
		{
			return $row;
		}
		return $defult;
	}
	################################################################################################################
	public static function GetSqlCampo($sql = "", $nome = "", $defult = false)
	{
		$valor = $defult;
		$linha = self::GetSqlrow($sql, $defult);
		if(!empty($linha))
		{
			if(!empty($linha[$nome]))
				$valor = $linha[$nome];
		}
		return $valor;
	}
	################################################################################################################
	public function LerCacheSQl($nome = "", $sql = "", $tempo = 300, $limparsql = false)
	{
		$retorno = 0;
		try
		{
			$CI =& get_instance();
			$total = 0;
			if($CI->cache->memcached->is_supported())
			{
				if (!$total = $CI->cache->memcached->get($nome)) {
					$total = $this->TotalRegistro(false, $sql, $limparsql);
					$CI->cache->memcached->save($nome, $total, $tempo);
				}
			}
			elseif($CI->cache->apc->is_supported())
			{
				if (!$total = $CI->cache->apc->get($nome)) {
					$total = $this->TotalRegistro(false, $sql, $limparsql);
					$CI->cache->apc->save($nome, $total, $tempo);
				}
			}
			elseif($CI->cache->file->is_supported())
			{
				if (!$total = $CI->cache->file->get($nome)) {
					$total = $this->TotalRegistro(false, $sql, $limparsql);
					$CI->cache->file->save($nome, $total, $tempo);
				}
			}
			else
			{
				$total = $this->TotalRegistro(false, $sql, $limparsql);
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
	public function LerCacheSQlCampo($nome = "", $sql = "", $campo = "", $tempo = 300, $defult = false)
	{
		$retorno = "";
		try
		{
			$CI =& get_instance();
			$retorno = "";
			if($CI->cache->memcached->is_supported())
			{
				if (!$retorno = $CI->cache->memcached->get($nome)) {
					$retorno = self::GetSqlCampo($sql, $campo, $defult);
					$CI->cache->memcached->save($nome, $retorno, $tempo);
				}
			}
			elseif($CI->cache->apc->is_supported())
			{
				if (!$retorno = $CI->cache->apc->get($nome)) {
					$retorno = self::GetSqlCampo($sql, $campo, $defult);
					$CI->cache->apc->save($nome, $retorno, $tempo);
				}
			}
			elseif($CI->cache->file->is_supported())
			{
				if (!$retorno = $CI->cache->file->get($nome)) {
					$retorno = self::GetSqlCampo($sql, $campo, $defult);
					$CI->cache->file->save($nome, $retorno, $tempo);
				}
			}
			else
			{
				$retorno = self::GetSqlCampo($sql, $campo, $defult);
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
	public static function MontarFiltro($filtro = false, $tabela = "", $chave = "")
	{
		if(is_array($filtro))
		{
			$onde = "";
			foreach ($filtro as $key => $value)
			{
				$onde .= "AND {$key} = '{$value}' ";
			}
			if(!empty($onde))
				$onde = substr($onde, 3);
		}
		elseif(is_numeric($filtro))
		{
			if(empty($chave))
			{
				$sql = "SHOW COLUMNS FROM {$tabela} WHERE COLUMNS.Key = 'PRI';";
				$nomeID = self::GetSqlCampo($sql, "Field", "id{$tabela}");
				$onde = "{$nomeID} = '{$filtro}'";
			}
			else
			{
				$onde = "{$chave} = '{$filtro}'";
			}
		}
		elseif(is_string($filtro))
			$onde = $filtro;
		else
			$onde = "";
		if(!empty($onde))
		{
			$filtro = $onde;
			$pos = stripos($onde, ' GROUP BY');
			if ($pos !== false)
			{
				$filtro = trim(stristr($onde, ' GROUP BY', true));
			}
			elseif(stripos($onde, ' ORDER BY') !== false)
			{
				$filtro = trim(stristr($onde, ' ORDER BY', true));
			}
			elseif(stripos($onde, ' LIMIT') !== false)
			{
				$filtro = trim(stristr($onde, ' LIMIT', true));
			}
			if(!empty($filtro))
				$onde = " WHERE ".$onde;
		}
		return $onde;
	}
	################################################################################################################
	public static function MontarCampos($dados = false)
	{
		if(empty($dados))
			return false;
		if(is_array($dados))
		{
			$lista = "";
			foreach ($dados as $key => $value)
			{
				$lista .= ", {$key} = '{$value}'";
			}
			if(!empty($lista))
				$lista = substr($lista, 1);
		}
		elseif(is_string($dados))
			$lista = $dados;
		else
			return false;
		return $lista;
	}
	#######################################################################################################################
	function Inserir($dados = false) {
		if(empty($dados))
			return false;

		if(isset($dados[$this->PrimaryKey]))
			unset($dados[$this->PrimaryKey]);
		
		$this->db->insert($this->Tabela, $dados);

		return $this->db->insert_id();
	}
	#######################################################################################################################
	function GetById($id = 0) {
		if(empty($id))
			return false;
		$this->db->where($this->PrimaryKey, $id);
		$query = $this->db->get($this->Tabela);
		if ($query->num_rows() > 0)
		{
			return $query->row_array();
		}
		else
		{
			return null;
		}
	}
	#######################################################################################################################
	function GetByCampo($nome = "", $id = 0) {
		if(empty($id))
			$id = $this->GetID();
		if(empty($id))
			return "";
		if(empty($nome))
			return "";
		$sql = "SELECT {$nome} FROM {$this->Tabela} WHERE {$this->PrimaryKey} = '{$id}';";
		return self::GetSqlCampo($sql, $nome, "");
	}
	#######################################################################################################################
	function GetAll($sort = '', $order = 'asc') {
		if(empty($sort))
			$sort = $this->PrimaryKey;
		$this->db->order_by($sort, $order);
		$query = $this->db->get($this->Tabela);
		if ($query->num_rows() > 0)
		{
			return $query->result_array();
		}
		else
		{
			return null;
		}
	}
	#######################################################################################################################
	function Atualizar($id, $dados) {
		if(is_null($id) || !isset($dados))
			return false;
		if(isset($dados[$this->PrimaryKey]))
			unset($dados[$this->PrimaryKey]);
		
		$this->db->where($this->PrimaryKey, $id);
		return $this->db->update($this->Tabela, $dados);
	}
	#######################################################################################################################
	function Excluir($id) {
		if(is_null($id))
			return false;
		$this->db->where($this->PrimaryKey, $id);
		return $this->db->delete($this->Tabela);
	}
	#######################################################################################################################
	function Apagar() {
		$id = $this->GetID();
		return $this->Excluir($id);
	}
	#######################################################################################################################
	public function ApagarLista($filtro = false, $sql = "")
	{
		$objs = $this->FiltroObjetos($filtro, $sql, false);
		if(is_array($objs))
		{
			foreach ($objs as $key=>$obj)
			{
				$obj->Apagar();
			}
		}
		return;
	}
	#######################################################################################################################
	function Salvar() {
		$id = $this->GetID();
		$dados = CompletaArray( $this->GetDados(), $this->GetDefault(), 3);
		if(empty($id))
			$retorno = $this->Inserir($dados);
		else
			$retorno = $this->Atualizar($id, $dados);
		return $retorno;
	}
	################################################################################################################
	public function GeraOpcoesSql($valor = "", $sql = "", $identificador = "", $texto = "", $primeiro = false)
	{
		$lista = "";
		if(self::$exibirprimeiro)
		{
			if((is_string($primeiro))&&(!empty($primeiro)))
				$lista = "\n<option value=\"\">{$primeiro}</option>";
			elseif(is_array($primeiro))
			{
				if(!empty($primeiro['texto']))
				{
					$lista = "\n<option value=\"{$primeiro['valor']}\">{$primeiro['texto']}</option>";# code...
				}
				else
					$lista = "\n<option value=\"{$primeiro[0]}\">{$primeiro[1]}</option>";
			}
		}
		$linha = $this->GetRows(false, $sql);
		if($linha)
		{
			if(empty($identificador))
				$identificador = self::NomeCampo($linha[0], 0);
			if(empty($texto))
				$texto = self::NomeCampo($linha[0], 1);
			$value = "";
			$label = "";
			$outro = "";
			foreach( $linha as $key=>$row )
			{
				if(!empty($row[$identificador]))
					$value = $row[$identificador];
				if(!empty($row[$texto]))
					$label = $row[$texto];
				if(is_array($valor))
				{
					if(in_array($value, $valor) !== false)
						$selecionado = " selected";
					else
						$selecionado = "";
				}
				else
				{
					if(strcmp($valor, $value) == 0)
						$selecionado = " selected";
					else
						$selecionado = "";
				}
				if((strcasecmp($label, "outro") == 0)||(strcasecmp($label, "outros") == 0)||(strcasecmp($label, "outra") == 0)||(strcasecmp($label, "outras") == 0))
					$outro = "\n<option value=\"{$value}\"{$selecionado}>{$label}</option>";
				else
					$lista .= "\n<option value=\"{$value}\"{$selecionado}>{$label}</option>";
			}
			$lista .= $outro;
		}
		return $lista;
	}
	################################################################################################################
	public static function NomeCampo($dados = false, $index = 0)
	{
		if(empty($dados))
			return "";
		elseif(is_array($dados))
		{
			$lista = array_keys($dados);
			return $lista[$index];
		}

		return "";
	}
	################################################################################################################
	public function ArrayEnum( $tabela = "", $MembroValor = false, $Filtro = false, $semChave = false)
	{
		if(empty($tabela))
			return false;

		$sql = 'SHOW FIELDS FROM '.$tabela;
		$lista = $this->GetRows(false, $sql);

		if($lista)
		{
			$mess = "";
			foreach( $lista as $key=>$r )
				{
					if(!empty($MembroValor))
					{
						if($r['Field'] == $MembroValor)
						{
							$mess = $r['Type'];
							break;
						}
					}
					elseif(strpos($r['Type'], "enum(") !== false)
					{
						$mess = $r['Type'];
						break;
					}
				}
				if(empty($mess))
					return false;
				$mess = str_replace("enum(","",$mess);
				$mess = str_replace("')","",$mess);
				$mess = str_replace("'","",$mess);
				$aux = explode(",", $mess);
				if(is_array($aux))
				{
					if(is_array($Filtro))
					{
						$aux = array_diff($aux, $Filtro);
					}
					if(empty($semChave))
						return $aux;
					else
					{
						$lista = false;
						foreach ($aux as $key => $value) {
							$lista[$value] = $value;
						}
						return $lista;
					}
				}
		}
		return false;
	}
	################################################################################################################
	public function GeraOpcoesEnum($valor = "", $tabela = false, $MembroValor = false, $primeiro = false, $Filtro = false)
	{
		if(empty($tabela))
			return "";
		$lista = $this->ArrayEnum( $tabela, $MembroValor , $Filtro , true);
		if(empty($lista))
			return "";
		return self::GeraOpcoesArray($valor, $lista, $primeiro);
	}
	################################################################################################################
	public static function GeraOpcoesArray($valor = "", $vetor = array(), $primeiro = false)
	{
		$lista = "";
		if(self::$exibirprimeiro)
		{
			if (is_string($primeiro))
				$lista = "\n<option value=\"\">{$primeiro}</option>";
			elseif (is_array($primeiro))
			{
				if (!empty($primeiro[ 'texto' ]))
				{
					$lista = "\n<option value=\"{$primeiro['valor']}\">{$primeiro['texto']}</option>";# code...
				}
				else
					$lista = "\n<option value=\"{$primeiro[0]}\">{$primeiro[1]}</option>";
			}
		}
		$totalRows = count($vetor);
		if($totalRows>0)
		{
			if(!empty($vetor))
			{
				foreach ($vetor as $key => $value)
				{
					if (strcmp($valor, $key) == 0)
						$selecionado = " selected";
					else
						$selecionado = "";
					$lista .= "\n<option value=\"{$key}\"{$selecionado}>{$value}</option>";
				}
			}
		}
		return $lista;
	}
	################################################################################################################
	public static function GetDadosChave(&$dados = false, $chaves = [], $defult = "")
	{
		if(empty($dados))
			return $defult;
		if(empty($chaves))
			return $defult;
		foreach($chaves as $chave)
		{
			if(isset($dados[$chave]))
				return $dados[$chave];
		}
		return $defult;
	}
	################################################################################################################
	public function GetLinkDominio()
	{
		$CI =& get_instance();
		$link = $CI->config->item('base_link');
		if(empty($link))
			$link = dirname(base_url("/"))."/";
		return $link;
	}
	################################################################################################################
	public function SetURL($caminho = "")
	{
		$pasta = strtolower($this->Tabela);
		$link = $this->GetLinkDominio();
		$aURL = $link."arquivos/{$pasta}/{$caminho}";
		return $aURL;
	}
	################################################################################################################
	public function SetDominio($caminho = "", $pasta = "")
	{
		if(empty($pasta))
			$pasta = strtolower($this->Tabela);
		$aURL = dirname(BASEPATH)."/arquivos/{$pasta}/{$caminho}";
		return $aURL;
	}
	################################################################################################################
	public function SetPadrao($caminho = "", $fisico = false)
	{
		$CI =& get_instance();
		if($fisico)
		{
			$link = dirname(BASEPATH);
		}
		else
		{
			$link = $CI->config->item('base_link');
			if(empty($link))
				$link = dirname(base_url("/"));
		}
		$aURL = $link."/arquivos/padrao/{$caminho}";
		return $aURL;
	}
	################################################################################################################
	public function SetExibirPrimeira($exibir = true)
	{
		self::$exibirprimeiro = $exibir;
	}
	################################################################################################################
	public function FileExiste($file = "", $caminho = "", $completo = true)
	{
		$file = trim($file);
		if(empty($file))
			return false;
		if(!$completo)
		{
			if(empty($caminho))
				$file = $this->SetDominio($file);
			else
				$file = $caminho.$file;
		}
		if(is_dir($file))
			return false;
		return file_exists($file);
	}
	################################################################################################################
	public function DeletarAquivo($file = "", $caminho = "", $completo = true)
	{
		$file = trim($file);
		if(empty($file))
			return false;
		if(!$completo)
		{
			if(empty($caminho))
				$file = $this->SetDominio($file);
			else
				$file = $caminho.$file;
		}
		if(is_dir($file))
			return false;
		return unlink($file);
	}
	#######################################################################################################
	public function listatabela($filtro = "", $sql = "", $sqlTotal = "")
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
	#######################################################################################################
	public function TotalRegistro($filtro = "", $sql = "", $limparsql = false)
	{
		$retorno = 0;
		try
		{
			if((empty($sql))&&(empty($this->Tabela)))
				return $retorno;
			if(!empty($filtro))
			{
				
				$pos = stripos($filtro, ' ORDER BY');
				if ($pos !== false)
				{
					$filtro = trim(stristr($filtro, ' ORDER BY', true));
				}
				elseif(stripos($filtro, ' LIMIT') !== false)
				{
					$filtro = trim(stristr($filtro, ' LIMIT', true));
				}
			}
			if(empty($sql))
			{
				$sql = "SELECT COUNT(*) CONT FROM {$this->Tabela}";
				if(!empty($filtro))
					$sql = $sql." WHERE ".$filtro;
			}
			else
			{
				if($limparsql)
				{
					$expressao = '/SELECT[A-Za-z0-9\-_\w\W\d\D]+FROM/';
					$QueryCont = "SELECT COUNT(*) AS CONT FROM";
					$sql = preg_replace($expressao, $QueryCont, $sql);
				}
				$pos = stripos($sql, ' WHERE');
				if(($pos === false)&&(!empty($filtro)))
				{
					$sql .= " WHERE ";
				}
				if(!empty($filtro))
					$sql = $sql.$filtro;
			}
			return self::GetSqlCampo($sql, "CONT", 0);
		}
		catch( Exception $e )
		{
			throw new Exception( $e );
			return $retorno;
		}
	}
	################################################################################################################
	public function PrinfCheck($campo = "", $valor = "")
	{
		if(empty($campo))
			return "";
		if(empty($valor))
			return "";
		$aux = $this->FormGet($campo);
		if(empty($aux))
			return "";
		if($aux == $valor)
			return '  checked="checked"';
		return "";
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
			
			return $dados;
		}
		catch( Exception $e )
		{
			throw new Exception( $e );
			return $retorno;
		}
	}
	################################################################################################################
	public function VerificarArquivo($arquivo = "")
	{
		$file = $this->SetDominio($arquivo);
		if(!$this->FileExiste($file))
			return __("Arquivo da importação não existe");
		if(filesize($file) <= 0)
			return __("Arquivo da importação está vazio");
		$test = explode('.', strtolower($file));
		$extension = end($test);
		if($extension == "xlsx")
			$excel = GetLibrary('SimpleXLSX');
		elseif($extension == "xls")
			$excel = GetLibrary('Excel');
		elseif($extension == "csv")
			$excel = GetLibrary('SimpleCSV');
		else
			return 0;
		$xlsx = $excel->read($file);
		if($xlsx)
		{
			$linhas = $xlsx->TotaldeLinhas();
			if($linhas <= 0)
			{
				if($extension == "xls")
					if($linhas < 0)
						return __("Arquivo da importação não possui nenhuma linha.");
					else
						return __("Arquivo da importação possui apenas uma linha.");
				else
					return __("Arquivo da importação não possui nenhuma linha.");
			}
			if($linhas == 1)
			{
				return __("Arquivo da importação possui apenas uma linha.");
			}
		}
		else
		{
			if($excel->error == 1)
			{
				return __("Arquivo da importação sem permissão de leitura.");
			}
			if($excel->error == 2)
			{
				return __("Arquivo da importação está vazio.");
			}
			if($excel->error == 3)
			{
				return __("Arquivo da importação está fora do formato do excel, para corrigir este erro você deve salvar o arquivo em uma versão mais recente do excel(*.xlsx).");
			}
		}
		return false;
	}
	################################################################################################################
	public function LerTotalRows($arquivo = "")
	{
		$file = $this->SetDominio($arquivo);
		if(!$this->FileExiste($file))
			return 0;
		$test = explode('.', strtolower($file));
		$extension = end($test);
		if($extension == "xlsx")
			$excel = GetLibrary('SimpleXLSX');
		elseif($extension == "xls")
			$excel = GetLibrary('Excel');
		elseif($extension == "csv")
			$excel = GetLibrary('SimpleCSV');
		else
			return 0;
		$xlsx = $excel->read($file);
		if($xlsx)
		{
			return $xlsx->TotaldeLinhas();
		}
		return 0;
	}
	################################################################################################################
	public function &LerRows($index = 0, $limite = 50, $arquivo = "")
	{
		$retorno = false;
		if(empty($arquivo))
			$arquivo = $this->arquivo;
		$file = $this->SetDominio($arquivo);
		if(!$this->FileExiste($file))
			return $retorno;
		$test = explode('.', strtolower($file));
		$extension = end($test);
		if($extension == "xlsx")
			$excel = GetLibrary('SimpleXLSX');
		elseif($extension == "xls")
			$excel = GetLibrary('Excel');
		elseif($extension == "csv")
			$excel = GetLibrary('SimpleCSV');
		else
			return $retorno;
		$xlsx = $excel->read($file);
		if($xlsx)
		{
			$lista = $xlsx->rows();
			if(empty($lista))
				return $retorno;
			$total = count($lista) - 1;
			if($total <= $index)
				return $retorno;
			$primeira = $lista[0];
			$index ++;
			$total = $index + $limite;
			$linhas = array();
			$totalprimeira = count($primeira);
			for($i = $index; $i < $total; $i++)
			{
				$num = count($lista[$i]);
				if($num != $totalprimeira )
				{
					for($j = $index; $j < $totalprimeira; $j++)
					{
						if(!isset($lista[$i][$j]))
							$lista[$i][$j] = "";
					}
				}
				$linhas[] = array_combine($primeira, $lista[$i]);
			}
			return $linhas;
		}
		return $retorno;
	}
}
?>