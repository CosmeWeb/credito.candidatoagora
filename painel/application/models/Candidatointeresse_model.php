<?php
/***********************************************************************
 * Module:  /models/Candidatointeresse_model.PHP
 * Author:  Host-up
 * Date:	03/02/2021 23:43:20
 * Purpose: Definição da Classe Candidatointeresse_model
 * Instancias: $this->load->model('Candidatointeresse_model', 'candidatointeresse');
 * Objeto: $candidatointeresse = $this->candidatointeresse->GetInstancia($dados);
 ***********************************************************************/
if (!class_exists('Candidatointeresse_model'))
{
	class Candidatointeresse_model extends MY_Model
	{
		################################################################################################################
		public function __construct( $dados = false)
		{
			try
			{
				$this->Tabela = "candidatointeresse";
				$this->PrimaryKey = "idcandidatointeresse";
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
				if(emptyData($this->cadastradoem))
					$this->cadastradoem = date("Y-m-d H:i:s");
				else
					$this->cadastradoem = date("Y-m-d H:i:s", TimeData($this->cadastradoem));
			}
			else
			{
				$this->cadastradoem = date("d/m/Y H:i:s", TimeData($this->cadastradoem));
			}
		}
		################################################################################################################
		public function SalvarCandidatoInteresse($idvaga = 0, $idcandidato = 0)
		{
			if(empty($idvaga))
				return;
			if(empty($idcandidato))
				return;
				
			$filtro = " idvaga = '{$idvaga}' AND idcandidato = '{$idcandidato}'";
			if($this->Load($filtro))
			{
				return;
			}
			$this->idcandidatointeresse = 0;
			$this->idcandidato = $idcandidato;
			$this->idvaga = $idvaga;
			$this->ip = "";
			$this->cadastradoem = "";
			$this->Ajustar(true);
			$this->Salvar();
			return;
		}
		################################################################################################################
		public function DeletarCandidato($idvaga = 0, $idcandidato = 0)
		{
			try
			{
				if(empty($idvaga))
					return;
				if(empty($idcandidato))
					return;
				$filtro = " idvaga = '{$idvaga}' AND idcandidato = '{$idcandidato}'";
				if($this->Load($filtro))
				{
					$this->Apagar();
				}
				return;
			}
			catch( Exception $e )
			{
				throw new Exception( $e );
			}
		}
		################################################################################################################
		public function VerificarCandidatoInteresse($idvaga = 0, $idcandidato = 0, $interesse = "")
		{
			if(empty($idvaga))
				return;
			if(empty($idcandidato))
				return;
			if(empty($interesse))
				return;
				
			if($interesse == "Sim")
			{
				$this->SalvarCandidatoInteresse($idvaga, $idcandidato);
			}
			else
			{
				$this->DeletarCandidato($idvaga, $idcandidato);
			}
			return;
		}
		################################################################################################################
		public function SalvarInteresseMarcar(&$dados = false, $idvaga = 0, $idcandidato = 0)
		{
			try
			{
				if(empty($idvaga))
					return;
				if(empty($idcandidato))
					return;
				$interesse = self::GetDadosChave($dados, array('interesse','Interesse','INTERESSE','LKD_interesse','LKD_Interesse','LKD_INTERESSE','lkd_interesse'));
				$interesse = trim($interesse);
				if(empty($interesse))
					return;
				
				$this->VerificarCandidatoInteresse($idvaga, $idcandidato, $interesse);
			}
			catch( Exception $e )
			{
				throw new Exception( $e );
			}
		}
		################################################################################################################
		public function LerListaInteresses()
		{
			$idcliente = Get("idcliente", 0);
			$idvaga = Get("idvaga", 0);
			$posicao = Get("posicao", 0);
			$limite = Get("limite", 10);
			$total = Get("total", 0);

			$rows = false;
			$titulo = __("Erro");
			$mensagem = __("Nenhum candidato interessado foi encontrado.");

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
				$total = 2;
			}
			if(!empty($total))
			{
				if($limite < 0)
					$limite = $total;
				$sql = "SELECT COUNT(DISTINCT CI.idcandidatointeresse) AS CONT FROM candidatointeresse CI USE INDEX(idxcandidato, idxvaga) INNER JOIN candidatovaga CV USE INDEX(idxcandidato, idxvaga) ON(CI.idcandidato = CV.idcandidato AND CI.idvaga = CV.idvaga) INNER JOIN vaga V ON(CV.idvaga = V.idvaga) LEFT JOIN favorito F FORCE INDEX(idxcandidato) ON(CV.idcandidato = F.idcandidato AND F.idvaga = V.idvaga) WHERE {$filtro}";
				$totalInteresse = $this->TotalRegistro(false, $sql,false);

				$sql = "SELECT COUNT(DISTINCT CV.idcandidato) AS CONT FROM candidatovaga CV  USE INDEX(idxcandidato, idxvaga) INNER JOIN vaga V ON(CV.idvaga = V.idvaga) LEFT JOIN favorito F FORCE INDEX(idxcandidato) ON(CV.idcandidato = F.idcandidato AND F.idvaga = V.idvaga) WHERE {$filtro}";
				$totalNaoInteresse = $this->TotalRegistro(false, $sql,false);

				$rows = [
					["interesse"=>"Sim","texto"=>"Candidatos com interesse","total"=>$totalInteresse],
					["interesse"=>"Não","texto"=>"Sem resposta até o momento","total"=>$totalNaoInteresse - $totalInteresse]
				];
				if(!empty($rows))
				{
					$rows = array_map(array($this,'Map'), $rows);
					$titulo = __("Sucesso");
					$mensagem = __("Lista de candidato interessado foi encontrada com sucesso.");
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
		public function GetCandidatoInteresse($idcandidato = 0, $idvaga = 0)
		{
			$retorno = "";
			try
			{
				if(empty($idvaga))
					return $retorno;
				if(empty($idcandidato))
					return $retorno;
				
				$filtro = "idvaga = '{$idvaga}' AND idcandidato = '{$idcandidato}'";
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
		public function __destruct()
		{
			unset($this->dados, $this->Tabela, $this->PrimaryKey);
		}
	}
}
?>