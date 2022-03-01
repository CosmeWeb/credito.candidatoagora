<?php
	/***********************************************************************
	 * Module:  /models/Configuracao_model.PHP
	 * Author:  Host-up
	 * Date:	06/07/2017 10:52:52
	 * Purpose: Definição da Classe Configuracao_model
	 * Instancias: $this->load->model('Configuracao_model', 'configuracao');
	 * Objeto: $configuracao = $this->configuracao->GetInstancia($dados);
	 ***********************************************************************/
	if (!class_exists('Configuracao_model'))
	{
		class Configuracao_model extends MY_Model
		{
			public static $dadosconfig = NULL;
			################################################################################################################
			function __construct( $dados = false)
			{
				try
				{
					$this->Tabela = "configuracao";
					$this->PrimaryKey = "idconfiguracao";
					parent::__construct($dados);
				}
				catch( Exception $e )
				{
					throw new Exception( $e );
				}
			}
			################################################################################################################
			public function GerarOpcoesTipo($value = "", $texto = "", $default = "")
			{
				if(empty($texto))
					$texto = __(" -- Selecione Tipo --");
				$primeiro = array("valor"=>$default,"texto"=>$texto);
				return $this->GeraOpcoesEnum($value, $this->Tabela, "tipo", $primeiro);
			}
			################################################################################################################
			public function GetConfig($nome = "", $default = "")
			{
				if(empty($nome))
					return $default;
				if(empty(self::$dadosconfig[$nome]))
				{
					$sql = "SELECT IF((valor = '' OR valor IS NULL), padrao, valor) AS valor FROM configuracao WHERE nome = '{$nome}'";
					self::$dadosconfig[$nome] = $this->GetSqlCampo($sql, "valor", $default);
				}
				return self::$dadosconfig[$nome];
			}
			################################################################################################################
			public function SetConfig($nome = "", $default = "")
			{
				if(empty($nome))
					return;
				self::$dadosconfig[$nome] = $default;
				return;
			}
			################################################################################################################
			public function PrintCampoConfig($nome = "", $default = "")
			{
				if(empty($nome))
					return;
				$aux = $this->FormGet($nome, $default);
				switch($this->tipo)
				{
					case "text":
						$campo = "<input type=\"text\" name=\"{$nome}\" id=\"{$nome}\" value=\"{$aux}\" class=\"form-control\">";
						break;
					case "email":
						$campo = "<input type=\"email\" name=\"{$nome}\" id=\"{$nome}\" value=\"{$aux}\" class=\"form-control\">";
						break;
					case "date":
						$campo = "<input type=\"date\" name=\"{$nome}\" id=\"{$nome}\" value=\"{$aux}\" class=\"form-control\">";
						break;
					case "month":
						$campo = "<input type=\"month\" name=\"{$nome}\" id=\"{$nome}\" value=\"{$aux}\" class=\"form-control\">";
						break;
					case "time":
						$campo = "<input type=\"time\" name=\"{$nome}\" id=\"{$nome}\" value=\"{$aux}\" class=\"form-control\">";
						break;
					case "datetime-local":
						$campo = "<input type=\"datetime-local\" name=\"{$nome}\" id=\"{$nome}\" value=\"{$aux}\" class=\"form-control\">";
						break;
					case "number":
						$campo = "<input type=\"number\" name=\"{$nome}\" id=\"{$nome}\" value=\"{$aux}\" class=\"form-control\">";
						break;
					case "color":
						$campo = "<input type=\"color\" name=\"{$nome}\" id=\"{$nome}\" value=\"{$aux}\" class=\"form-control\">";
						break;
					case "url":
						$campo = "<input type=\"text\" name=\"{$nome}\" id=\"{$nome}\" value=\"{$aux}\" class=\"form-control\">";
						break;
					case "textarea":
						$campo = "<textarea name=\"{$nome}\" id=\"{$nome}\" rows=\"8\" class=\"form-control\">{$aux}</textarea>";
						break;
					case "datalist":
						$lista = explode(",", $this->opcao);
						if(is_array($lista))
						{
							$opcao = "";
							foreach ($lista as $valor)
							{
								$opcao .= "<option value=\"{$valor}\">{$valor}</option>";
							}
						}
						$campo = "<input name=\"{$nome}\" autocomplete=\"off\" list=\"{$nome}\" value=\"{$aux}\" class=\"form-control\">";
						$campo .= "<datalist id=\"{$nome}\">{$opcao}</datalist>";
						break;
					case "select":
						$pos = stripos($this->opcao, "SELECT ");
						$opcao = "";
						if($pos === false)
						{
							$lista = explode(",", $this->opcao);
							if(is_array($lista))
							{
								$opcoes = false;
								foreach ($lista as $valor)
								{
									$pos = stripos($valor, "=");
									if($pos === false)
									{
										$opcoes[$valor] = $valor;
									}
									else
									{
										list($key,$value) = explode("=", $valor);
										$opcoes[$key] = $value;
									}
								}
								$opcao = $this->GeraOpcoesArray($aux, $opcoes, "-- Selecione --");
							}
						}
						else
						{
							$opcao = $this->GeraOpcoesSql($aux, $this->opcao, "", "", "-- Selecione --");
						}
						$campo = "<select name=\"{$nome}\" id=\"{$nome}\" class=\"form-control\">{$opcao}</select>";
						
						break;
					default:
						$campo = "<input type=\"text\" name=\"{$nome}\" id=\"{$nome}\" value=\"{$aux}\">";
						break;
				}
				echo $campo;
				return;
			}
			################################################################################################################
			public function &GetJson(&$dados = false)
			{
				$retorno = false;
				try
				{
					if(empty($dados))
					{
						$dados = $this->GetDefault();
					}
					unset($dados['descricao'], $dados['opcao'], $dados['tipo']);
					return $dados;
				}
				catch( Exception $e )
				{
					throw new Exception( $e );
					return $retorno;
				}
			}
			################################################################################################################
			function __destruct()
			{
				unset($this->dados, $this->Tabela, $this->PrimaryKey);
			}
		}
	}
?>