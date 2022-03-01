<?php
/***********************************************************************
 * Module:  /models/Toptalent_model.PHP
 * Author:  Host-up
 * Date:	13/11/2020 15:31:18
 * Purpose: Definição da Classe Toptalent_model
 * Instancias: $this->load->model('Toptalent_model', 'toptalent');
 * Objeto: $toptalent = $this->toptalent->GetInstancia($dados);
 ***********************************************************************/
if (!class_exists('Toptalent_model'))
{
	class Toptalent_model extends MY_Model
	{
		################################################################################################################
		public function __construct( $dados = false)
		{
			try
			{
				$this->Tabela = "toptalent";
				$this->PrimaryKey = "idtoptalent";
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

			}
			else
			{

			}
		}
		################################################################################################################
		public function GetSqlLista()
		{
			$retorno = "";
			try
			{
				return "SELECT * FROM toptalent ";
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
				return "SELECT COUNT(*) AS CONT FROM toptalent ";
			}
			catch( Exception $e )
			{
				throw new Exception( $e );
				return $retorno;
			}
		}
		################################################################################################################
		public function LerFiltroToptalent()
		{
			$idcliente = Get("idcliente", 0);
			$idvaga = Get("idvaga", 0);
			$posicao = Get("posicao", 0);
			$limite = Get("limite", 10);
			$total = Get("total", 0);

			$rows = false;
			$titulo = __("Erro");
			$mensagem = __("Nenhum contatos do candidato foi encontrado.");

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
				$filtro .= " AND (F.idfavorito IS NULL OR F.tipo = 'Favorito') AND T.idvaga ".GerarIN($idvaga);
			}
			if(empty($total))
			{
				$total = 1;				
			}
			if(!empty($total))
			{
				if($limite < 0)
					$limite = $total;
				$sql = "SELECT COUNT(DISTINCT CV.idcandidato) AS CONT FROM candidatovaga CV INNER JOIN toptalent T ON(T.idcandidato = CV.idcandidato) INNER JOIN candidato C ON(C.idcandidato = CV.idcandidato) INNER JOIN vaga V ON(CV.idvaga = V.idvaga) LEFT JOIN favorito F FORCE INDEX(idxcandidato) ON(CV.idcandidato = F.idcandidato AND F.idvaga = V.idvaga) WHERE {$filtro} ";
				$totalToptalent = $this->TotalRegistro(false, $sql, false);

				$rows = [
					["toptalent"=>"Sim","texto"=>"Perfil TopTalent CA","total"=>$totalToptalent]
				];
				if(!empty($rows))
				{
					$rows = array_map(array($this,'Map'), $rows);
					$titulo = __("Sucesso");
					$mensagem = __("Lista de toptalent foi encontrada com sucesso.");
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
		public function MarcarToptalent()
		{
			$idcliente = Get("idcliente", 0);
			$idcandidato = Get("idcandidato", "");
			$idvaga = Get("idvaga", 0);
			$toptalent = Get("toptalent", "Não");
						
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
			if($toptalent == "Sim")
			{
				$this->SalvarToptalent($idcandidato, $idvaga);
				$titulo = __("Sucesso");
				$mensagem = __("Candidato foi marcado como toptalent.");
			}
			else
			{
				$this->DesmarcarToptalent($idcandidato, $idvaga);
				$titulo = __("Sucesso");
				$mensagem = __("Candidato foi desmarcado como toptalent.");
			}
			$filtro = "";
			if(!empty($idcliente))
			{
				$filtro .= " 1 ";
				//$filtro .= " V.idcliente = '{$idcliente}' ";
			}
			if(!empty($idvaga))
			{
				if(!is_array($idvaga))
					$idvaga = array($idvaga);
				$filtro .= " AND CV.idvaga ".GerarIN($idvaga);
			}
			$sql = "SELECT COUNT(DISTINCT CV.idcandidato) AS CONT FROM candidatovaga CV INNER JOIN toptalent T ON(T.idcandidato = CV.idcandidato) INNER JOIN candidato C ON(C.idcandidato = CV.idcandidato) INNER JOIN vaga V ON(CV.idvaga = V.idvaga) WHERE {$filtro} ";
			$total = $this->TotalRegistro(false, $sql);
			$dados['sucesso'] = true;
			$dados['mensagem'] = $mensagem;
			$dados['titulo'] = $titulo;
			$dados['total'] = $total;
			return $dados;
		}
		################################################################################################################
		public function SalvarToptalent($idcandidato = 0, $idvaga = 0)
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
					$this->idtoptalent = 0;
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
		public function DesmarcarToptalent($idcandidato = 0, $idvaga = 0)
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
		public function SalvaTopTalent(&$dados = false, $idvaga = 0, $idcandidato = 0)
		{
			try
			{
				if(empty($idvaga))
					return;
				if(empty($idcandidato))
					return;
				
				$toptalent = self::GetDadosChave($dados, array("toptalent","top talent","TopTalent","Top Talent","TOPTALENT","TOP TALENT"));
				if(empty($toptalent))
				{
					return;
				}
				if(strcasecmp($toptalent , "Sim" ) == 0)
				{
					$filtro = "idvaga = '{$idvaga}' AND idcandidato = '{$idcandidato}'";
					if($this->Load($filtro))
					{
						return;
					}
					$this->idtoptalent = 0;
					$this->idcandidato = $idcandidato;
					$this->idvaga = $idvaga;
					$this->Ajustar(true);
					$this->Salvar();
				}
				else
				{
					$filtro = "idvaga = '{$idvaga}' AND idcandidato = '{$idcandidato}'";
					if($this->Load($filtro))
					{
						$this->Apagar();
					}
				}
				return;
			}
			catch( Exception $e )
			{
				throw new Exception( $e );
			}
		}
		################################################################################################################
		public function GetCandidatoToptalent($idcandidato = 0, $idvaga = 0)
		{
			$retorno = "Não";
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