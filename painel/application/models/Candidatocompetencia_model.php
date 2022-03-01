<?php
/***********************************************************************
 * Module:  /models/Candidatocompetencia_model.PHP
 * Author:  Host-up
 * Date:	27/06/2020 18:14:54
 * Purpose: Definição da Classe Candidatocompetencia_model
 * Instancias: $this->load->model('Candidatocompetencia_model', 'candidatocompetencia');
 * Objeto: $candidatocompetencia = $this->candidatocompetencia->GetInstancia($dados);
 ***********************************************************************/
if (!class_exists('Candidatocompetencia_model'))
{
	class Candidatocompetencia_model extends MY_Model
	{
		private static $_competencia = null;
		################################################################################################################
		public function __construct( $dados = false)
		{
			try
			{
				$this->Tabela = "candidatocompetencia";
				$this->PrimaryKey = "idcandidatocompetencia";
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
		public static function &NewCompetencia() {
			if (self::$_competencia == null)
				self::$_competencia = GetModelo("competencia");
			return self::$_competencia;
		}
		################################################################################################################
		public function SalvarListaCandidatocompetencia(&$dados = false, $idcandidato = 0)
		{
			if(empty($dados))
				return;
			$competencia = self::NewCompetencia();
			for($i = 1; $i <= 10; $i++)
			{
				$nomecompetencia = self::GetDadosChave($dados, array("Competência {$i}","competência {$i}","competencia {$i}","competencia {$i}","LKD_competencia {$i}","LKD_Competencia {$i}","LKD_competência {$i}","LKD_Competência {$i}"));
				if(empty($nomecompetencia))
					continue;
				$idcompetencia = $competencia->LerIdCompetencia($nomecompetencia);
				$this->SalvarCompetencia(0, $idcompetencia, $idcandidato);
			}
			return;
		}
		################################################################################################################
		public function SalvarCompetencia( $idcandidatocompetencia = 0, $idcompetencia = 0, $idcandidato = 0)
		{
			try
			{
				if(empty($idcompetencia))
					return;
				if(empty($idcandidato))
					return;
				$filtro = "idcompetencia = '{$idcompetencia}' AND idcandidato = '{$idcandidato}'";
				if($this->Existe($filtro))
				{
					return;
				}
				$this->idcandidatocompetencia = $idcandidatocompetencia;
				$this->idcompetencia = $idcompetencia;
				$this->idcandidato = $idcandidato;
				$this->Ajustar(true);
				$this->Salvar();
			}
			catch( Exception $e )
			{
				throw new Exception( $e );
			}
		}
		################################################################################################################
		public function &ListaDeCompetencias($idcandidato = 0)
		{
			$retorno = false;
			try
			{
				if(empty($idcandidato))
					return $retorno;
				$sql = "SELECT CCT.idcompetencia, C.competencia FROM candidatocompetencia CCT INNER JOIN competencia C ON(CCT.idcompetencia = C.idcompetencia) WHERE CCT.idcandidato = '{$idcandidato}' ORDER BY C.competencia ASC";
				$rows = $this->GetRows(false, $sql);
				if(!empty($rows))
				{
					$rows = array_map(array($this,'Map'), $rows);
				}
				return $rows;
			}
			catch( Exception $e )
			{
				throw new Exception( $e );
			}
		}
		################################################################################################################
		public static function Map($row = false)
		{
			$row['idcompetencia'] = intval($row['idcompetencia']);
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