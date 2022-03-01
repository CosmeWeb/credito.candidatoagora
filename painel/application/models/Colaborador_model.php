<?php
/***********************************************************************
 * Module:  /models/Colaborador_model.PHP
 * Author:  Host-up
 * Date:	16/11/2018 11:07:45
 * Purpose: Definição da Classe Colaborador_model
 * Instancias: $this->load->model('Colaborador_model', 'colaborador');
 * Objeto: $colaborador = $this->colaborador->GetInstancia($dados);
 ***********************************************************************/
if (!class_exists('Colaborador_model'))
{
	class Colaborador_model extends MY_Model
	{
		################################################################################################################
		public function __construct( $dados = false)
		{
			try
			{
				$this->Tabela = "colaborador";
				$this->PrimaryKey = "idcolaborador";
				parent::__construct($dados);
			}
			catch( Exception $e )
			{
				throw new Exception( $e );
			}
		}
		################################################################################################################
		# Destrutor da classe
		public function __destruct()
		{
			unset($this->dados, $this->Tabela, $this->PrimaryKey);
		}
		################################################################################################################
		public function Ajustar($salvar = false)
		{
			if($salvar)
			{

			}
			else
			{

			}
		}
		################################################################################################################
		public function GerarOpcoesAcesso($value = "", $texto = "", $default = "")
		{
			if(empty($texto))
				$texto = __(" -- Selecione --");
			$primeiro = array("valor"=>$default,"texto"=>$texto);
			return $this->GeraOpcoesEnum($value, $this->Tabela, "acesso", $primeiro);
		}
		################################################################################################################
		public function GerarOpcoesVisualizadashboard($value = "", $texto = "", $default = "")
		{
			if(empty($texto))
				$texto = __("-- Selecione --");
			$primeiro = array("valor"=>$default,"texto"=>$texto);
			return $this->GeraOpcoesEnum($value, $this->Tabela, "visualizadashboard", $primeiro);
		}
		#######################################################################################################
		public function Login()
		{
			if(empty($this->email))
			{
				return false;
			}
			if(empty($this->senha))
			{
				return false;
			}
			$filtro = "email = '{$this->email}' AND senha = sha1(CONCAT(salt, '{$this->senha}'))";
			return $this->Load($filtro);
		}
		#######################################################################################################
		public function EmailExiste()
		{
			if(empty($this->email))
			{
				return false;
			}
			$id = $this->GetID();
			if(empty($id))
				$filtro = "email = '{$this->email}'";
			else
				$filtro = "email = '{$this->email}' AND {$this->PrimaryKey} != '{$id}'";
			return $this->Existe($filtro);
		}
		#######################################################################################################
		public function GetListaIcones()
		{
			$lista = array();
			for($i = 0; $i <= 20; $i++)
			{
				$aux = str_pad($i,2, "0", STR_PAD_LEFT);
				$lista[] = "image{$aux}.png";
			}
			return $lista;
		}
		#######################################################################################################
		public function GetSrcIcones($icone = "")
		{
			if(empty($icone))
				$icone = $this->icone;
			return base_url("assets/images/avatar/{$icone}");
		}
		################################################################################################################
		public function GetURL($thumb = false, $fisico = false)
		{
			if(empty($this->foto))
				return "";
			if(!$thumb)
			{
				$url = "{$this->foto}";
				if($fisico)
					$file = $this->SetDominio($url);
				else
					$file = $this->SetURL($url);
			}
			else
			{
				$url = "thumb/{$this->foto}";
				if($fisico)
					$file = $this->SetDominio($url);
				else
					$file = $this->SetURL($url);
			}
			return $file;
		}
		################################################################################################################
		public function GetFoto($thumb = false)
		{
			if(empty($this->foto))
				return $this->GetFotoPadrao();
			$file = $this->GetURL($thumb, true);
			if(!$thumb)
			{
				if(!$this->FileExiste($file))
					return $this->GetFotoPadrao();
			}
			else
			{
				if(!$this->FileExiste($file))
				{
					if(!$this->GerarThumb())
						return $this->GetFotoPadrao();
				}
			}
			return $this->GetURL($thumb);
		}
		################################################################################################################
		public function TemFoto($thumb = false)
		{
			if(empty($this->foto))
				return false;
			$file = $this->GetURL($thumb, true);
			if(!$thumb)
			{
				if(!$this->FileExiste($file))
					return false;
			}
			else
			{
				if(!$this->FileExiste($file))
				{
					return false;
				}
			}
			return true;
		}
		################################################################################################################
		public function GerarThumb()
		{
			if(empty($this->foto))
				return false;
			$file =  $this->GetURL(true, true);
			if(!$this->FileExiste($file))
			{
				$filePadrao = $this->GetURL(false, true);
				if(!$this->FileExiste($filePadrao))
					return false;
				CriarPastas(dirname($file), 0755);
				$CI =& get_instance();
				$CI->load->library('image');
				$imagem = $CI->image->carrega($filePadrao);
				$imagem->resize(128,0,"w");
				$imagem->save($file);
			}
			return true;
		}
		################################################################################################################
		public function deletarFoto()
		{
			if(empty($this->foto))
				return false;
			$file =  $this->GetURL(true, true);
			if($this->FileExiste($file))
			{
				unlink($file);
			}
			$file =  $this->GetURL(false, true);
			if($this->FileExiste($file))
			{
				unlink($file);
			}
			return true;
		}
		################################################################################################################
		public function GetFotoPadrao()
		{
			return $this->SetPadrao("foto.jpg");
		}
		################################################################################################################
		public function GetAvatar()
		{
			if($this->TemFoto())
			{
				return $this->GetFoto();
			}
			elseif(empty($this->icone))
			{
				return $this->SetPadrao("foto.jpg");
			}
			else
			{
				return base_url("assets/images/avatar/{$this->icone}");
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
					$dados = $this->GetDefault();
				}
				$this->icone = $dados['icone'];
				$this->foto = $dados['foto'];
				$dados['foto'] = $this->GetAvatar();
				unset($dados['icone'], $dados['senha']);
				return $dados;
			}
			catch( Exception $e )
			{
				throw new Exception( $e );
				return $retorno;
			}
		}
		################################################################################################################
		public function &GetLink($idcolaborador = 0)
		{
			$retorno = site_url('colaborador/listar');
			if(empty($idcolaborador))
				$idcolaborador = $this->Get("idcolaborador");
			if(empty($idcolaborador))
				return $retorno;
			return site_url('colaborador/editar/'.$idcolaborador);
		}
		################################################################################################################
		public function GerarSenha($senha = "12345678")
		{
			try
			{
				$salt = gerarSalt(32);
				$this->senha = sha1($salt.$senha);
				$this->salt = $salt;
			}
			catch( Exception $e )
			{
				throw new Exception( $e );
				return;
			}
		}
	}
}
?>