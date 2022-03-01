<?php
/***********************************************************************
 * Module:  /models/Favoritogrupo_model.PHP
 * Author:  Host-up
 * Date:	12/11/2021 15:14:13
 * Purpose: Definição da Classe Favoritogrupo_model
 * Instancias: $this->load->model('Favoritogrupo_model', 'favoritogrupo');
 * Objeto: $favoritogrupo = $this->favoritogrupo->GetInstancia($dados);
 ***********************************************************************/
if (!class_exists('Favoritogrupo_model'))
{
	class Favoritogrupo_model extends MY_Model
	{
		################################################################################################################
		public function __construct( $dados = false)
		{
			try
			{
				$this->Tabela = "favoritogrupo";
				$this->PrimaryKey = "idfavoritogrupo";
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
				if(empty($this->ip))
					$this->ip = GetIP();
				if(emptyData($this->marcadoem))
					$this->marcadoem = date("Y-m-d H:i:s");
				else
					$this->marcadoem = date("Y-m-d H:i:s", TimeData($this->marcadoem));
			}
			else
			{
				$this->marcadoem = date("d/m/Y H:i:s", TimeData($this->marcadoem));
			}
		}
		################################################################################################################
		public function GerarOpcoesFavorito123($value = "", $texto = "", $default = "")
		{
			if(empty($texto))
				$texto = __("-- Selecione --");
			$primeiro = array("valor"=>$default,"texto"=>$texto);
			return $this->GeraOpcoesEnum($value, $this->Tabela, "tipo", $primeiro);
		}
		################################################################################################################
		public function GetSqlLista()
		{
			$retorno = "";
			try
			{
				return "SELECT * FROM favoritogrupo ";
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
				return "SELECT COUNT(*) AS CONT FROM favoritogrupo ";
			}
			catch( Exception $e )
			{
				throw new Exception( $e );
				return $retorno;
			}
		}
		################################################################################################################
		public function LerListaFavoritos()
		{
			$idcliente = Get("idcliente", 0);
			$idvaga = Get("idvaga", 0);
			$posicao = Get("posicao", 0);
			$limite = Get("limite", 10);
			$total = Get("total", 0);

			$rows = false;
			$titulo = __("Erro");
			$mensagem = __("Nenhum favorito 123 foi encontrado.");

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
				$sql = "SELECT COUNT(DISTINCT FG.idfavoritogrupo) AS CONT FROM favoritogrupo FG USE INDEX(idxcandidato, idxvaga) INNER JOIN candidatovaga CV USE INDEX(idxcandidato, idxvaga) ON(FG.idcandidato = CV.idcandidato AND FG.idvaga = CV.idvaga) LEFT JOIN favorito F FORCE INDEX(idxcandidato) ON(CV.idcandidato = F.idcandidato AND F.idvaga = CV.idvaga) WHERE {$filtro} AND FG.tipo = 'Favorito 1'";
				$totalFavorito1 = $this->TotalRegistro(false, $sql,false);

				$sql = "SELECT COUNT(DISTINCT FG.idfavoritogrupo) AS CONT FROM favoritogrupo FG USE INDEX(idxcandidato, idxvaga) INNER JOIN candidatovaga CV USE INDEX(idxcandidato, idxvaga) ON(FG.idcandidato = CV.idcandidato AND FG.idvaga = CV.idvaga) LEFT JOIN favorito F FORCE INDEX(idxcandidato) ON(CV.idcandidato = F.idcandidato AND F.idvaga = CV.idvaga) WHERE {$filtro} AND FG.tipo = 'Favorito 2'";
				$totalFavorito2 = $this->TotalRegistro(false, $sql,false);

				$sql = "SELECT COUNT(DISTINCT FG.idfavoritogrupo) AS CONT FROM favoritogrupo FG USE INDEX(idxcandidato, idxvaga) INNER JOIN candidatovaga CV USE INDEX(idxcandidato, idxvaga) ON(FG.idcandidato = CV.idcandidato AND FG.idvaga = CV.idvaga) LEFT JOIN favorito F FORCE INDEX(idxcandidato) ON(CV.idcandidato = F.idcandidato AND F.idvaga = CV.idvaga) WHERE {$filtro} AND FG.tipo = 'Favorito 3'";
				$totalFavorito3 = $this->TotalRegistro(false, $sql,false);

				$sql = "SELECT COUNT(DISTINCT CV.idcandidato) AS CONT FROM candidatovaga CV USE INDEX(idxcandidato, idxvaga) LEFT JOIN favoritogrupo FG USE INDEX(idxcandidato, idxvaga) ON(FG.idcandidato = CV.idcandidato AND FG.idvaga = CV.idvaga) LEFT JOIN favorito F FORCE INDEX(idxcandidato) ON(CV.idcandidato = F.idcandidato AND F.idvaga = CV.idvaga) WHERE {$filtro} AND FG.idfavoritogrupo IS NULL";
				$totalNaoMarcado = $this->TotalRegistro(false, $sql,false);

				$rows = [
					["favoritogrupo"=>"Favorito1","texto"=>"Favorito 1","total"=>$totalFavorito1],
					["favoritogrupo"=>"Favorito2","texto"=>"Favorito 2","total"=>$totalFavorito2],
					["favoritogrupo"=>"Favorito3","texto"=>"Favorito 3","total"=>$totalFavorito3],
					["favoritogrupo"=>"Nao_Avaliado","texto"=>"Candidatos não avaliados","total"=>$totalNaoMarcado]
				];
				if(!empty($rows))
				{
					$rows = array_map(array($this,'Map'), $rows);
					$titulo = __("Sucesso");
					$mensagem = __("Lista de favorito 123 foi encontrada com sucesso.");
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
		public function MarcarCandidato()
		{
			$idcandidato = Get("idcandidato", "");
			$idvaga = Get("idvaga", 0);
			$desmarcar = Get("desmarcar", 0);
			$tipo = Get("tipo", 0);
						
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
			if(empty($desmarcar))
			{
				$this->SalvarFavorito($idcandidato, $idvaga, $tipo);
				$tipo = strtolower($tipo);
				$titulo = __("Sucesso");
				$mensagem = __("Candidato foi marcado como {$tipo}.");
			}
			else
			{
				$this->DesmarcarFavorito($idcandidato, $idvaga, $tipo);
				$tipo = strtolower($tipo);
				$titulo = __("Sucesso");
				$mensagem = __("Candidato foi desmarcado como {$tipo}.");
			}
			
			$dados['sucesso'] = true;
			$dados['mensagem'] = $mensagem;
			$dados['titulo'] = $titulo;
			return $dados;
		}
		################################################################################################################
		public function SalvarFavorito($idcandidato = 0, $idvaga = 0, $tipo = "")
		{
			try
			{
				if(empty($idcandidato))
					return;
				if(empty($idvaga))
					return;
				$filtro = "idcandidato = '{$idcandidato}' AND idvaga = '{$idvaga}'";
				if(!$this->Load($filtro))
				{
					$this->idfavorito = 0;
					$this->idcandidato = $idcandidato;
					$this->idvaga = $idvaga;
				}
				$this->tipo = $tipo;
				$this->Ajustar(true);
				$this->Salvar();
			}
			catch( Exception $e )
			{
				throw new Exception( $e );
			}
		}
		################################################################################################################
		public function DesmarcarFavorito($idcandidato = 0, $idvaga = 0, $tipo = "")
		{
			try
			{
				if(empty($idcandidato))
					return;
				if(empty($idvaga))
					return;
				$filtro = "idcandidato = '{$idcandidato}' AND idvaga = '{$idvaga}'";
				if(!$this->Load($filtro))
				{
					return;
				}
				$this->Apagar();
			}
			catch( Exception $e )
			{
				throw new Exception( $e );
			}
		}
		################################################################################################################
		public function GetCaminho($file = "")
		{
			return $this->SetDominio($file);
		}
		################################################################################################################
		public function __destruct()
		{
			unset($this->dados, $this->Tabela, $this->PrimaryKey);
		}
	}
}
?>