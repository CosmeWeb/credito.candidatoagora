<?php
/***********************************************************************
 * Module:  /models/Curriculoenviado.PHP
 * Author:  Host-up
 * Date:	15/12/2020 20:57:01
 * Purpose: Definição da Classe Curriculoenviado
 * Instancias: $this->load->model('Curriculoenviado', 'curriculoenviado');
 * Objeto: $curriculoenviado = $this->curriculoenviado->GetInstancia($dados);
 ***********************************************************************/
if (!class_exists('Curriculoenviado'))
{
	class Curriculoenviado
	{
		public static $_limite = 500;
		private static $_vaga = null;
		private static $_candidato = null;
		private static $_projeto = null;
		private static $_cliente = null;
		################################################################################################################
		public function __construct( $dados = false)
		{
			try
			{
				return;
			}
			catch( Exception $e )
			{
				throw new Exception( $e );
			}
		}
		################################################################################################################
		public static function &NewVaga() {
			if (self::$_vaga == null)
				self::$_vaga = GetModelo("vaga");
			return self::$_vaga;
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
		public static function &CriarVaga($curriculo = [])
		{
			$retorno = 0;
			try
			{
				if(empty($curriculo))
					return $retorno;
				$aux = Escape(trim($curriculo['projeto']));
				$idcliente = self::CriarCliente();
				$obj = self::NewVaga();
				$sql = "SELECT idvaga FROM vaga WHERE titulodavaga = '{$aux}' AND idcliente = '{$idcliente}' LIMIT 1";
				$id = $obj->GetSqlCampo($sql, "idvaga", 0);
				if(!empty($id))
					return $id;
				$obj->idvaga = 0;
				$obj->idcliente = $idcliente;
				$obj->titulodavaga = trim($curriculo['projeto']);
				$obj->empresacontratante = $curriculo['nomeresponsavel'];
				$obj->Ajustar(true);
				$id = $obj->Salvar();
				if(empty($id))
					return $retorno;
				else
					return $id;
			}
			catch( Exception $e )
			{
				throw new Exception( $e );
				return $retorno;
			}
		}
		################################################################################################################
		public static function &CriarCliente()
		{
			$retorno = 0;
			try
			{
				$nome = "idclientecaptador";
				$idcliente = GetConfiguracao($nome, 0);
				if(empty($idcliente))
				{
					$obj = self::NewCliente();
					$obj->idcliente = 0;
					$obj->nome = "Sistema Captador";
					$obj->email = "captador@gmail.com";
					$obj->senha = "captador0987654321";
					$obj->empresa = "Sistema Captador";

					$obj->Ajustar(true);
					$idcliente = $obj->Salvar();
					if(empty($idcliente))
						return $retorno;
					$config = GetModelo("configuracao");
					$config->SalvarConfig($nome, $idcliente);
				}
				return $idcliente;
			}
			catch( Exception $e )
			{
				throw new Exception( $e );
				return $retorno;
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

				$CI =& get_instance();
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
		public function &GetChave()
		{
			$retorno = false;
			try
			{
				$CI =& get_instance();
				
				$chave = $CI->config->config['chave'];
				$identificador = $CI->config->config['identificador'];
				$identificador .= "|".date("U");

				$chave = encryptCookie($chave);
				$identificador = encryptCookie($identificador);
				$buscar = Get("buscar");
				$tipo = Get("tipo");
				$idprojeto = Get("idprojeto");
				$idempresa = Get("idempresa");
				$empresalimite = Get("empresalimite");
				$eaplicado = Get("eaplicado");
				$datacoletainicio = Get("datacoletainicio");
				$datacoletafim = Get("datacoletafim");
				$tememail = Get("tememail");			
				$idcurriculo = Get("idcurriculo");
				$posicao = Get("posicao", 0);
				$limite = Get("limite", self::$_limite);
				$total = Get("total", 0);

				$retorno = [
					"chave"=>$chave,
					"identificador"=>$identificador,
					"buscar"=>$buscar,
					"tipo"=>$tipo,
					"idprojeto"=>$idprojeto,
					"idempresa"=>$idempresa,
					"empresalimite"=>$empresalimite,
					"eaplicado"=>$eaplicado,
					"datacoletainicio"=>$datacoletainicio,
					"datacoletafim"=>$datacoletafim,
					"tememail"=>$tememail,
					"idcurriculo"=>$idcurriculo,
					"posicao"=>$posicao,
					"limite"=>$limite,
					"total"=>$total
				];

				return $retorno;
			}
			catch( Exception $e )
			{
				throw new Exception( $e );
				return $retorno;
			}
		}
		################################################################################################################
		public function URLtotal()
		{
			$retorno = false;
			try
			{
				$CI =& get_instance();				
				$link = $CI->config->config['montado_online_link'];
				$link .= "index.php/api/lertotalcurriculo/";
				return $link;
			}
			catch( Exception $e )
			{
				throw new Exception( $e );
				return $retorno;
			}
		}
		################################################################################################################
		public function URLcurriculo()
		{
			$retorno = false;
			try
			{
				$CI =& get_instance();
				$link = $CI->config->config['montado_online_link'];
				$link .= "index.php/api/getcurriculoenviado/";
				return $link;
			}
			catch( Exception $e )
			{
				throw new Exception( $e );
				return $retorno;
			}
		}
		################################################################################################################
		public function &GetURL($dados = null, $url = "")
		{
			$retorno = false;
			try
			{
				if(empty($dados))
					return $retorno;
				if(empty($url))
					return $retorno;
				$headers[] = 'accept: application/json,text/*;q=0.99';
				$headers[] = 'Connection: Keep-Alive';
				$headers[] = 'Content-type: application/x-www-form-urlencoded; charset=utf-8';
				$user_agent = 'Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1; .NET CLR 1.0.3705; .NET CLR 1.1.4322; Media Center PC 4.0)';
				$process = curl_init($url);
				curl_setopt($process, CURLOPT_HTTPHEADER, $headers);
				curl_setopt($process, CURLOPT_HEADER, 0);
				curl_setopt($process, CURLOPT_USERAGENT, $user_agent);
				curl_setopt($process, CURLOPT_TIMEOUT, 60);
				curl_setopt($process, CURLOPT_POSTFIELDS, http_build_query($dados));
				curl_setopt($process, CURLOPT_RETURNTRANSFER, 1);
				curl_setopt($process, CURLOPT_POST, 1);
				$json = curl_exec($process);//P($json);
				$status = curl_getinfo($process, CURLINFO_HTTP_CODE);
				curl_close($process);
				if(($status >= 200) && ($status < 300))
					return $json;
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
		public function GetTotalCurriculoEnviado()
		{
			$retorno = 0;
			try
			{
				$data = $this->GetChave();
				$url = $this->URLtotal();
				$json = $this->GetURL($data, $url);
				if(empty($json))
				{
					$dados = [
						"sucesso"=>false,
						"erro"=>__("Nenhum candidato a ser enviado.")
					];
					return $dados;
				}
				$data = json_decode($json, true);
				if($data['sucesso'] == false)
				{
					$dados['sucesso'] = false;
					$dados['erro'] = $data['erro'];
				}
				else
				{
					$dados['sucesso'] = true;
					$dados['titulo'] = $data['titulo'];
					$dados['mensagem'] = $data['mensagem'];
					$dados['total'] = $data['total'];
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
		public function &LerCurriculoEnviado()
		{
			$retorno = 0;
			try
			{
				$chave = Get("chave", false);
				$identificador = Get("identificador", false);
				if(!$this->VerificarChave($chave, $identificador))
				{
					$dados['sucesso'] = false;
					$dados['erro'] = __("Chave de identificador não encontrado");
					return $dados;
				}
				$rows = Get("curriculos", false);
				if(!empty($rows))
				{
					if(!self::SalvarCurriculos($rows))
					{
						$dados['sucesso'] = false;
						$dados['erro'] = __("Erro ao salvar os dados do currículos.");
						return $dados;
					}
				}
				$dados['sucesso'] = true;
                $dados['titulo'] = __("Sucesso");
                $dados['mensagem'] = __("Dados de currículos recebidos com sucesso.");
				return $dados;
			}
			catch( Exception $e )
			{
				throw new Exception( $e );
				return $retorno;
			}
		}
		################################################################################################################
		public function SalvarCurriculos($curriculos = [])
		{
			$retorno = false;
			try
			{
				if(!is_array($curriculos))
					return $retorno;
				
				foreach($curriculos as $key=>$curriculo)
				{
					$this->SalvarCurriculo($curriculo);
				}
				return true;
			}
			catch( Exception $e )
			{
				throw new Exception( $e );
				return $retorno;
			}
		}
		################################################################################################################
		public function SalvarCurriculo(&$curriculo = [])
		{
			$retorno = false;
			try
			{
				if(empty($curriculo))
					return $retorno;
				$candidato = self::NewCandidato();
				$idvaga = self::CriarVaga($curriculo);
				$candidato->SalvarListaCandidato($curriculo, $idvaga, "Não", "Não");
				return $retorno;
			}
			catch( Exception $e )
			{
				throw new Exception( $e );
				return $retorno;
			}
		}
		################################################################################################################
		public function GetDadosAcesso()
		{
			$retorno = "{}";
			try
			{
				$CI =& get_instance();
				$link = $CI->config->config['montado_online_link'];
				$link .= "index.php/api/";
				$chave = $CI->config->config['chave'];
				$identificador = $CI->config->config['identificador'];
				$identificador .= "|".date("U");

				$chave = encryptCookie($chave);
				$identificador = encryptCookie($identificador);

				$retorno = [
					"key"=>$chave,
					"ident"=>$identificador,
					"site"=>$link
				];
				return json_encode($retorno);
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