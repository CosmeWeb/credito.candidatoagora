<?php
/***********************************************************************
 * Module:  /models/Candidatoperfil_model.PHP
 * Author:  Host-up
 * Date:	12/09/2020 18:17:27
 * Purpose: Definição da Classe Candidatoperfil_model
 * Instancias: $this->load->model('Candidatoperfil_model', 'candidatoperfil');
 * Objeto: $candidatoperfil = $this->candidatoperfil->GetInstancia($dados);
 ***********************************************************************/
if (!class_exists('Candidatoperfil_model'))
{
	class Candidatoperfil_model extends MY_Model
	{
		################################################################################################################
		public function __construct( $dados = false)
		{
			try
			{
				$this->Tabela = "candidatoperfil";
				$this->PrimaryKey = "idcandidatoperfil";
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
		public function GerarOpcoesPerfil($value = "", $texto = "", $default = "")
		{
			if(empty($texto))
				$texto = __("-- Selecione --");
			$primeiro = array("valor"=>$default,"texto"=>$texto);
			return $this->GeraOpcoesEnum($value, $this->Tabela, "perfil", $primeiro);
		}
		################################################################################################################
		public function SalvarPerfil(&$dados = false, $idvaga = 0, $idcandidato = 0)
		{
			try
			{
				if(empty($idvaga))
					return;
				if(empty($idcandidato))
					return;
				$filtro = "idvaga = '{$idvaga}' AND idcandidato = '{$idcandidato}'";
				if(!$this->Load($filtro))
				{
					$this->idcandidatoperfil = 0;
				}
				$perfil = self::GetDadosChave($dados, array("perfil","Perfil","PERFIL"));
				$perfil = trim($perfil);
				if(empty($perfil))
					return;
				$perfil = strtolower($perfil);
				switch($perfil)
				{
					case "prioridade empresas target":
					case "candidatos de empresas target":
					case "empresas target":
					case "empresa target":
						$this->perfil = 'Prioridade Empresas target';
						break;
					case "prioridade setores target":
					case "candidatos de setores target":
					case "setores target":
					case "setor target":
						$this->perfil = 'Prioridade Setores target';
						break;
					case "outros":
					case "outro":
					case "outra":
					case "outras":
						$this->perfil = 'Outros';
						break;
					default:
						$this->perfil = 'Outros';
				}
				$this->idcandidato = $idcandidato;
				$this->idvaga = $idvaga;
				$this->Ajustar(true);
				$this->Salvar();
			}
			catch( Exception $e )
			{
				throw new Exception( $e );
			}
		}
		################################################################################################################
		public function LerListaPerfis()
		{
			$idcliente = Get("idcliente", 0);
			$idvaga = Get("idvaga", 0);
			$posicao = Get("posicao", 0);
			$limite = Get("limite", 10);
			$total = Get("total", 0);

			$rows = false;
			$titulo = __("Erro");
			$mensagem = __("Nenhum perfil foi encontrado.");

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
				$total = 3;
			}
			if(!empty($total))
			{
				
				$sql = "SELECT COUNT(DISTINCT CV.idcandidato) AS CONT FROM candidatovaga CV USE INDEX(idxcandidato, idxvaga) LEFT JOIN candidatoperfil CP USE INDEX(idxcandidato, idxvaga) ON(CP.idcandidato = CV.idcandidato AND CV.idvaga = CP.idvaga) INNER JOIN vaga V ON(CV.idvaga = V.idvaga) LEFT JOIN favorito F FORCE INDEX(idxcandidato) ON(CV.idcandidato = F.idcandidato AND F.idvaga = V.idvaga) WHERE {$filtro} AND CP.perfil = 'Prioridade Empresas target'";
				$totalEmpresa = $this->TotalRegistro(false, $sql,false);
				
				$sql = "SELECT COUNT(DISTINCT CV.idcandidato) AS CONT FROM candidatovaga CV USE INDEX(idxcandidato, idxvaga) LEFT JOIN candidatoperfil CP USE INDEX(idxcandidato, idxvaga) ON(CP.idcandidato = CV.idcandidato AND CV.idvaga = CP.idvaga) INNER JOIN vaga V ON(CV.idvaga = V.idvaga) LEFT JOIN favorito F FORCE INDEX(idxcandidato) ON(CV.idcandidato = F.idcandidato AND F.idvaga = V.idvaga) WHERE {$filtro} AND CP.perfil = 'Prioridade Setores target'";
				$totalSetor = $this->TotalRegistro(false, $sql,false);
				
				$sql = "SELECT COUNT(DISTINCT CV.idcandidato) AS CONT FROM candidatovaga CV USE INDEX(idxcandidato, idxvaga) LEFT JOIN candidatoperfil CP USE INDEX(idxcandidato, idxvaga) ON(CP.idcandidato = CV.idcandidato AND CV.idvaga = CP.idvaga) INNER JOIN vaga V ON(CV.idvaga = V.idvaga) LEFT JOIN favorito F FORCE INDEX(idxcandidato) ON(CV.idcandidato = F.idcandidato AND F.idvaga = V.idvaga) WHERE {$filtro} AND CP.perfil = 'Outros'";
				$totalOutros = $this->TotalRegistro(false, $sql,false);
				if(!empty($totalEmpresa))
				{
					$rows[] = ["perfil"=>"Prioridade Empresas target","texto"=>"Candidatos de empresas target","total"=>intval($totalEmpresa)];
				}
				else
				{
					$total--;
				}
				if(!empty($totalSetor))
				{
					$rows[] = ["perfil"=>"Prioridade Setores target","texto"=>"Candidatos de setores target","total"=>intval($totalSetor)];
				}
				else
				{
					$total--;
				}
				if(!empty($totalOutros))
				{
					$rows[] = ["perfil"=>"Outros","texto"=>"Outros","total"=>intval($totalOutros)];
				}
				else
				{
					$total--;
				}
				
				if(!empty($rows))
				{
					$titulo = __("Sucesso");
					$mensagem = __("Lista de perfis de candidatos foi encontrada com sucesso.");
				}
			}
			$novaposicao = 3;
			$finalizado = true;

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
		public function GetCandidatoperfil($idcandidato = 0, $idvaga = 0)
		{
			$retorno = "Outros";
			try
			{
				if(empty($idvaga))
					return $retorno;
				if(empty($idcandidato))
					return $retorno;
				
				$sql = "SELECT perfil FROM candidatoperfil WHERE idvaga = '{$idvaga}' AND idcandidato = '{$idcandidato}' ORDER BY perfil ASC , idcandidato ASC LIMIT 1";
				return $this->GetSqlCampo($sql, "perfil", $retorno);
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