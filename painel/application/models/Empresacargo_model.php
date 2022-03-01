<?php
/***********************************************************************
 * Module:  /models/Empresacargo_model.PHP
 * Author:  Host-up
 * Date:	01/07/2020 00:57:04
 * Purpose: Definição da Classe Empresacargo_model
 * Instancias: $this->load->model('Empresacargo_model', 'empresacargo');
 * Objeto: $empresacargo = $this->empresacargo->GetInstancia($dados);
 ***********************************************************************/
if (!class_exists('Empresacargo_model'))
{
	class Empresacargo_model extends MY_Model
	{
		################################################################################################################
		public function __construct( $dados = false)
		{
			try
			{
				$this->Tabela = "empresacargo";
				$this->PrimaryKey = "idempresacargo";
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
		public function LerIdEmpresacargo($palavraschaves = false)
		{
			if(empty($palavraschaves))
			{
				return 0;
			}
			$palavraschaves = trim($palavraschaves," \n\t\r");
			$aux = Escape($palavraschaves);
			$sql = "SELECT idempresacargo FROM {$this->Tabela} WHERE empresa = '{$aux}' LIMIT 1";
			$id = $this->GetSqlCampo($sql,"idempresacargo", 0);
			if(empty($id))
			{
				$this->idempresacargo = 0;
				$this->empresa = $palavraschaves;
				$this->Ajustar(true);
				$id = $this->Salvar();
				if(empty($id))
				{
					return 0;
				}
			}
			return $id;
		}
		################################################################################################################
		public function LerListaEmpresas()
		{
			$idcliente = Get("idcliente", 0);
			$idvaga = Get("idvaga", 0);
			$calcular = Get("calcular", 0);
			$posicao = Get("posicao", 0);
			$limite = Get("limite", 10);
			$total = Get("total", 0);

			$rows = false;
			$titulo = __("Erro");
			$mensagem = __("Nenhuma empresa foi encontrado.");

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
				$sql = "SELECT COUNT(DISTINCT EC.idempresacargo) AS CONT FROM empresacargo EC INNER JOIN candidatocargo CG ON(EC.idempresacargo = CG.idempresacargo) INNER JOIN candidatovaga CV ON(CG.idcandidato = CV.idcandidato) INNER JOIN vaga V ON(CV.idvaga = V.idvaga) LEFT JOIN favorito F FORCE INDEX(idxcandidato) ON(CV.idcandidato = F.idcandidato AND F.idvaga = V.idvaga) WHERE {$filtro}";
				$total = $this->TotalRegistro(false, $sql);				
			}
			if(!empty($total))
			{
				if($limite < 0)
					$limite = $total;
				
				if(empty($calcular))
				{
					$filtro .= " ORDER BY EC.empresa ASC, total DESC LIMIT {$posicao}, {$limite}";
				
					$sql = "SELECT DISTINCT EC.idempresacargo, EC.empresa, '0' AS total FROM empresacargo EC INNER JOIN candidatocargo CG ON(EC.idempresacargo = CG.idempresacargo) INNER JOIN candidatovaga CV ON(CG.idcandidato = CV.idcandidato) INNER JOIN vaga V ON(CV.idvaga = V.idvaga) LEFT JOIN favorito F FORCE INDEX(idxcandidato) ON(CV.idcandidato = F.idcandidato AND F.idvaga = V.idvaga) WHERE {$filtro}";
				}
				else
				{
					$filtro .= " GROUP BY EC.idempresacargo, EC.empresa ORDER BY total DESC, EC.empresa ASC LIMIT {$posicao}, {$limite}";
				
					$sql = "SELECT EC.idempresacargo, EC.empresa, COUNT(DISTINCT CV.idcandidato) AS total FROM empresacargo EC INNER JOIN candidatocargo CG ON(EC.idempresacargo = CG.idempresacargo) INNER JOIN candidatovaga CV ON(CG.idcandidato = CV.idcandidato) INNER JOIN vaga V ON(CV.idvaga = V.idvaga) LEFT JOIN favorito F FORCE INDEX(idxcandidato) ON(CV.idcandidato = F.idcandidato AND F.idvaga = V.idvaga) WHERE {$filtro}";
				}
				$rows = $this->GetRows(false, $sql);
				if(!empty($rows))
				{
					$rows = array_map(array($this,'Map'), $rows);
					$titulo = __("Sucesso");
					$mensagem = __("Lista de empresa foi encontrada com sucesso.");
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
			$row['idempresacargo'] = intval($row['idempresacargo']);
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