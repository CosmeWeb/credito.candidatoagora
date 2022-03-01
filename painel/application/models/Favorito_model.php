<?php
/***********************************************************************
 * Module:  /models/Favorito_model.PHP
 * Author:  Host-up
 * Date:	23/07/2020 21:29:26
 * Purpose: Definição da Classe Favorito_model
 * Instancias: $this->load->model('Favorito_model', 'favorito');
 * Objeto: $favorito = $this->favorito->GetInstancia($dados);
 ***********************************************************************/
if (!class_exists('Favorito_model'))
{
	class Favorito_model extends MY_Model
	{
		################################################################################################################
		public function __construct( $dados = false)
		{
			try
			{
				$this->Tabela = "favorito";
				$this->PrimaryKey = "idfavorito";
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
		public function SalvarFavorito($idcandidato = 0, $idvaga = 0)
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
				$this->tipo = "Favorito";
				$this->Ajustar(true);
				$this->Salvar();
			}
			catch( Exception $e )
			{
				throw new Exception( $e );
			}
		}
		################################################################################################################
		public function DesmarcarFavorito($idcandidato = 0, $idvaga = 0)
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
				if($this->tipo == "Favorito")
					$this->Apagar();
			}
			catch( Exception $e )
			{
				throw new Exception( $e );
			}
		}
		################################################################################################################
		public function SalvarDesconsiderado($idcandidato = 0, $idvaga = 0)
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
				$this->tipo = "Desconsiderado";
				$this->Ajustar(true);
				$this->Salvar();
			}
			catch( Exception $e )
			{
				throw new Exception( $e );
			}
		}
		################################################################################################################
		public function DesmarcarDesconsiderado($idcandidato = 0, $idvaga = 0)
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
				if($this->tipo == "Desconsiderado")
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
		public function MarcarCandidato()
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
			if(empty($desmarcar))
			{
				$this->SalvarFavorito($idcandidato, $idvaga);
				$titulo = __("Sucesso");
				$mensagem = __("Candidato foi marcado como favorito.");
			}
			else
			{
				$this->DesmarcarFavorito($idcandidato, $idvaga);
				$titulo = __("Sucesso");
				$mensagem = __("Candidato foi desmarcado como favorito.");
			}
			
			$dados['sucesso'] = true;
			$dados['mensagem'] = $mensagem;
			$dados['titulo'] = $titulo;
			return $dados;
		}
		################################################################################################################
		public function MarcarDesconsiderado()
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
			if(empty($desmarcar))
			{
				$this->SalvarDesconsiderado($idcandidato, $idvaga);
				$titulo = __("Sucesso");
				$mensagem = __("Candidato foi desconsiderado da vaga.");
			}
			else
			{
				$this->DesmarcarDesconsiderado($idcandidato, $idvaga);
				$titulo = __("Sucesso");
				$mensagem = __("Candidato foi reconsiderado na vaga.");
			}
			
			$dados['sucesso'] = true;
			$dados['mensagem'] = $mensagem;
			$dados['titulo'] = $titulo;
			return $dados;
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
			$mensagem = __("Nenhum favorito foi encontrado.");

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
				$filtro .= " AND CV.idvaga ".GerarIN($idvaga);
			}
			if(empty($total))
			{
				$total = 3;
			}
			if(!empty($total))
			{
				if($limite < 0)
					$limite = $total;
				$sql = "SELECT COUNT(DISTINCT F.idfavorito) AS CONT FROM favorito F USE INDEX(idxcandidato, idxvaga) INNER JOIN candidatovaga CV USE INDEX(idxcandidato, idxvaga) ON(F.idcandidato = CV.idcandidato AND F.idvaga = CV.idvaga) INNER JOIN vaga V ON(CV.idvaga = V.idvaga) WHERE {$filtro} AND F.tipo = 'Favorito'";
				$totalFavorito = $this->TotalRegistro(false, $sql,false);

				$sql = "SELECT COUNT(DISTINCT F.idfavorito) AS CONT FROM favorito F USE INDEX(idxcandidato, idxvaga) INNER JOIN candidatovaga CV USE INDEX(idxcandidato, idxvaga) ON(F.idcandidato = CV.idcandidato AND F.idvaga = CV.idvaga) INNER JOIN vaga V ON(CV.idvaga = V.idvaga) WHERE {$filtro} AND F.tipo = 'Desconsiderado'";
				$totalDesconsiderado = $this->TotalRegistro(false, $sql,false);

				$sql = "SELECT COUNT(DISTINCT CV.idcandidato) AS CONT FROM candidatovaga CV  USE INDEX(idxcandidato, idxvaga) INNER JOIN vaga V ON(CV.idvaga = V.idvaga) WHERE {$filtro}";
				$totalNaoMarcado = $this->TotalRegistro(false, $sql,false);

				$rows = [
					["favorito"=>"Sim","texto"=>"Candidatos favoritos","total"=>$totalFavorito],
					["favorito"=>"Desconsiderado","texto"=>"Candidatos desconsiderados","total"=>$totalDesconsiderado],
					["favorito"=>"Nao_Avaliado","texto"=>"Candidatos não avaliados","total"=>$totalNaoMarcado - $totalFavorito - $totalDesconsiderado]
				];
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
		public function GetCandidatoFavorito($idcandidato = 0, $idvaga = 0)
		{
			$retorno = "";
			try
			{
				if(empty($idvaga))
					return $retorno;
				if(empty($idcandidato))
					return $retorno;
				
				$filtro = "idvaga = '{$idvaga}' AND idcandidato = '{$idcandidato}' AND tipo = 'Favorito'";
				$total = $this->TotalRegistro($filtro);
				if($total > 0)
				{
					return "Sim";
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
		public function GetCandidatoDesconsiderado($idcandidato = 0, $idvaga = 0)
		{
			$retorno = "";
			try
			{
				if(empty($idvaga))
					return $retorno;
				if(empty($idcandidato))
					return $retorno;
				
				$filtro = "idvaga = '{$idvaga}' AND idcandidato = '{$idcandidato}' AND tipo = 'Desconsiderado'";
				$total = $this->TotalRegistro($filtro);
				if($total > 0)
				{
					return "Sim";
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
		public function SalvarFavoritoMarcar(&$dados = false, $idvaga = 0, $idcandidato = 0)
		{
			try
			{
				if(empty($idvaga))
					return;
				if(empty($idcandidato))
					return;
				$favorito = self::GetDadosChave($dados, array('favorito','Favorito','FAVORITO'));
				$favorito = trim($favorito);

				$desconsiderado = self::GetDadosChave($dados, array('desconsiderado','desconsiderados','Desconsiderado','Desconsiderados','DESCONSIDERADO','DESCONSIDERADOS'));
				$desconsiderado = trim($desconsiderado);

				if((empty($favorito))&&(empty($desconsiderado)))
					return;
				$filtro = "idvaga = '{$idvaga}' AND idcandidato = '{$idcandidato}'";
				if(!$this->Load($filtro))
				{
					if($favorito == "Sim")
					{
						$this->idfavorito = 0;
						$this->idcandidato = $idcandidato;
						$this->idvaga = $idvaga;
						$this->tipo = "Favorito";
						$this->Ajustar(true);
						$this->Salvar();
					}
					elseif($desconsiderado == "Sim")
					{
						$this->idfavorito = 0;
						$this->idcandidato = $idcandidato;
						$this->idvaga = $idvaga;
						$this->tipo = "Desconsiderado";
						$this->Ajustar(true);
						$this->Salvar();
					}
				}
				else
				{
					if(($this->tipo == "Favorito")&&($favorito == "Não"))
					{
						$this->Apagar();
					}
					elseif(($this->tipo == "Desconsiderado")&&($desconsiderado == "Não"))
					{
						$this->Apagar();
					}
					elseif(($favorito == "Não")&&($desconsiderado == "Não"))
					{
						$this->Apagar();
					}
				}
			}
			catch( Exception $e )
			{
				throw new Exception( $e );
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