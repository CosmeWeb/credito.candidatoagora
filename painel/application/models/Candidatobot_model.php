<?php
/***********************************************************************
 * Module:  /models/Candidatobot_model.PHP
 * Author:  Host-up
 * Date:	09/07/2020 00:40:27
 * Purpose: Definição da Classe Candidatobot_model
 * Instancias: $this->load->model('Candidatobot_model', 'candidatobot');
 * Objeto: $candidatobot = $this->candidatobot->GetInstancia($dados);
 ***********************************************************************/
if (!class_exists('Candidatobot_model'))
{
	class Candidatobot_model extends MY_Model
	{
		private static $_candidatobot = null;
		################################################################################################################
		public function __construct( $dados = false)
		{
			try
			{
				$this->Tabela = "candidatobot";
				$this->PrimaryKey = "idcandidatobot";
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
			}
			else
			{
				if(emptyData($this->cadastradoem))
					$this->cadastradoem = "";
				else
					$this->cadastradoem = date("Y-m-d H:i:s", TimeData($this->cadastradoem));
			}
		}
		################################################################################################################
		public static function &NewCandidatoBot() {
			if (self::$_candidatobot == null)
				self::$_candidatobot = GetModelo("candidatobot");
			return self::$_candidatobot;
		}
		################################################################################################################
		public function SetURL($caminho = "")
		{
			$pasta = strtolower($this->Tabela);
			$data = date("Y-m", TimeData($this->cadastradoem));
			$link = $this->GetLinkDominio();
			$aURL = $link."arquivos/{$pasta}/{$data}/{$caminho}";
			return $aURL;
		}
		################################################################################################################
		public function SetDominio($caminho = "", $pasta = "")
		{
			if(empty($pasta))
				$pasta = strtolower($this->Tabela);
			$data = date("Y-m", TimeData($this->cadastradoem));
			$aURL = dirname(BASEPATH)."/arquivos/{$pasta}/{$data}/{$caminho}";
			return $aURL;
		}
		################################################################################################################
		public function &ListaDeBots($idcandidato = 0)
		{
			$retorno = false;
			try
			{
				if(empty($idcandidato))
					return $retorno;
				$sql = "SELECT CB.idcandidatobot, CB.tipo, CB.audio, CB.cadastradoem FROM candidatobot CB WHERE CB.idcandidato = '{$idcandidato}' ORDER BY CB.tipo ASC";
				$rows = $this->GetRows(false, $sql);
				if(!empty($rows))
				{
					$rows = array_map(array($this,'Mapabot'), $rows);
				}
				return $rows;
			}
			catch( Exception $e )
			{
				throw new Exception( $e );
			}
		}
		################################################################################################################
		public static function Mapabot($row = false)
		{
			$row['idcompetencia'] = intval($row['idcompetencia']);
			$bot = self::NewCandidatoBot();
			$bot->Carregar($row);
			$row['link'] = "";
			if($bot->FileExiste($bot->audio, "", false))
			{
				$row['link'] = $bot->SetURL($bot->audio);
			}
			$row['cadastradoem'] = date("d/m/Y H:i:s", TimeData($bot->cadastradoem));
			return $row;
		}
		################################################################################################################
		public function LerListaBots()
		{
			$idcliente = Get("idcliente", 0);
			$idvaga = Get("idvaga", 0);
			$posicao = Get("posicao", 0);
			$limite = Get("limite", 10);
			$total = Get("total", 0);

			$rows = false;
			$titulo = __("Erro");
			$mensagem = __("Nenhum tipo de bot foi encontrado.");

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
				$sql = "SELECT COUNT(DISTINCT CB.tipo) AS CONT FROM candidatobot CB INNER JOIN candidatovaga CV ON(CB.idcandidato = CV.idcandidato) INNER JOIN vaga V ON(CV.idvaga = V.idvaga) LEFT JOIN favorito F FORCE INDEX(idxcandidato) ON(CV.idcandidato = F.idcandidato AND F.idvaga = V.idvaga) WHERE {$filtro}";
				$total = $this->TotalRegistro(false, $sql);				
			}
			if(!empty($total))
			{
				if($limite < 0)
					$limite = $total;	
				$filtro .= " GROUP BY CB.tipo ORDER BY total DESC LIMIT {$posicao}, {$limite}";
				$sql = "SELECT CB.tipo AS 'tipobot', COUNT(DISTINCT CV.idcandidato) AS total FROM candidatobot CB INNER JOIN candidatovaga CV ON(CB.idcandidato = CV.idcandidato) INNER JOIN vaga V ON(CV.idvaga = V.idvaga) LEFT JOIN favorito F FORCE INDEX(idxcandidato) ON(CV.idcandidato = F.idcandidato AND F.idvaga = V.idvaga) WHERE {$filtro}";
				$rows = $this->GetRows(false, $sql);
				if(!empty($rows))
				{
					$rows = array_map(array($this,'Map'), $rows);
					$titulo = __("Sucesso");
					$mensagem = __("Lista de tipo de bot foi encontrada com sucesso.");
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
		public static function Map($row = false)
		{			
			$row['total'] = intval($row['total']);
			return $row;
		}		
		################################################################################################################
		public function __destruct()
		{
			unset($this->dados, $this->Tabela, $this->PrimaryKey);
		}
	}
}
?>