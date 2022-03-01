<?php
/***********************************************************************
 * Module:  /models/Candidatocertificado_model.PHP
 * Author:  Host-up
 * Date:	03/08/2021 15:44:33
 * Purpose: Definição da Classe Candidatocertificado_model
 * Instancias: $this->load->model('Candidatocertificado_model', 'candidatocertificado');
 * Objeto: $candidatocertificado = $this->candidatocertificado->GetInstancia($dados);
 ***********************************************************************/
if (!class_exists('Candidatocertificado_model'))
{
	class Candidatocertificado_model extends MY_Model
	{
		################################################################################################################
		public function __construct( $dados = false)
		{
			try
			{
				$this->Tabela = "candidatocertificado";
				$this->PrimaryKey = "idcandidatocertificado";
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
		public function ListaDeCertificados($idcandidato = 0)
		{
			$retorno = false;
			try
			{
				if(empty($idcandidato))
					return $retorno;
				$sql = "SELECT DISTINCT CC.idcandidatocertificado AS idcertificado, CC.certificado, CC.emissor, IF(ISNULL(NULLIF(CC.emitido,'')) = 0, DATE_FORMAT(CC.emitido, '%Y'), '') AS 'emitido' FROM candidatocertificado CC USE INDEX(idxcandidato) WHERE CC.idcandidato = '{$idcandidato}' ORDER BY CC.certificado ASC";
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
			$row['idcertificado'] = intval($row['idcertificado']);
			return $row;
		}
		################################################################################################################
		public function SalvarCandidatoCertificado($dados = false, $idcandidato = 0)
		{
			if(empty($dados))
				return;
			if(empty($idcandidato))
				return;
			for($i = 1; $i <= 10; $i++)
			{
				$certificado = self::GetDadosChave($dados, array("lkd_certificado_{$i}","LKD_Certificado {$i}","LKD certificado {$i}","LKD certificado {$i}","certificado {$i}","Certificado {$i}","CERTIFICADO {$i}"));
				if(empty($certificado))
					return;
				$aux = Escape($certificado);
				$filtro = "certificado = '{$aux}' AND idcandidato = '{$idcandidato}'";
				$obj = $this->FiltroObjeto($filtro);
				if(empty($obj))
				{
					$obj = $this->GetInstancia();
					$obj->idcandidatocertificado = 0;
					$obj->certificado = $certificado;
					$obj->idcandidato = $idcandidato;
				}
				$emissor = self::GetDadosChave($dados, array("lkd_emissor_{$i}","LKD_Emissor {$i}","LKD_emissor_{$i}","emissor {$i}","Emissor {$i}","EMISSOR {$i}"));
				if(empty($emissor))
					$obj->emissor = $emissor;
				$emitido = self::GetDadosChave($dados, array("lkd_emitido_{$i}","LKD_Emitido {$i}","LKD_emitido_{$i}","emitido {$i}","Emitido {$i}","EMITIDO {$i}"));
				if(empty($emitido))
					$obj->emitido = $emitido;
				$obj->Ajustar(true);
				$obj->Salvar();
			}
			return;
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