<?php
/***********************************************************************
 * Module:  /models/Candidatovaga_model.PHP
 * Author:  Host-up
 * Date:	03/07/2020 14:38:05
 * Purpose: Definição da Classe Candidatovaga_model
 * Instancias: $this->load->model('Candidatovaga_model', 'candidatovaga');
 * Objeto: $candidatovaga = $this->candidatovaga->GetInstancia($dados);
 ***********************************************************************/
if (!class_exists('Candidatovaga_model'))
{
	class Candidatovaga_model extends MY_Model
	{
		################################################################################################################
		public function __construct( $dados = false)
		{
			try
			{
				$this->Tabela = "candidatovaga";
				$this->PrimaryKey = "idcandidatovaga";
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
		public function SalvarVaga($idvaga = 0, $idcandidato = 0)
		{
			try
			{
				if(empty($idcandidato))
					return;
				if(empty($idvaga))
					return;
				$filtro = "idcandidato = '{$idcandidato}' AND idvaga = '{$idvaga}'";
				if($this->Existe($filtro))
				{
					return;
				}
				$this->idcandidatovaga = 0;
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
		public function &ListaDeVagas($idcandidato = 0, $comCliente = false)
		{
			$retorno = false;
			try
			{
				if(empty($idcandidato))
					return $retorno;
				if($comCliente)
				{
					$idcliente = Get("idcliente", 0);
					if(empty($idcliente))
						return $retorno;
					$filtro = " AND V.idcliente = '{$idcliente}'";
				}
				else
				{
					$filtro = "";
				}
				$sql = "SELECT V.idvaga, V.titulodavaga, V.empresacontratante, V.status, V.cadastradoem FROM candidatovaga CV FORCE INDEX(idxcandidato, idxvaga) INNER JOIN vaga V ON(CV.idvaga = V.idvaga) WHERE CV.idcandidato = '{$idcandidato}'{$filtro} ORDER BY V.cadastradoem DESC";
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
			$row['idvaga'] = intval($row['idvaga']);
			if(!emptyData($row['cadastradoem']))
			{
				$ano = date("Y", TimeData($row['cadastradoem']));
				$row['cadastradoem'] = date("d/m/Y", TimeData($row['cadastradoem']));				
			}
			else
			{
				$ano = date("Y");
				$row['cadastradoem'] = "";				
			}
			$codigo = intval($row['idvaga']);
			if($codigo < 10)
				$row['codigovaga'] = $ano."0".$codigo."T";
			else
				$row['codigovaga'] = $ano.$codigo."T";
			return $row;
		}
		################################################################################################################
		public function GetListaDeVagas($idcandidato = 0)
		{
			$retorno = false;
			try
			{
				if(empty($idcandidato))
					return $retorno;
				$sql = "SELECT DISTINCT IF(ISNULL(NULLIF(V.empresacontratante,'')) = 0, CONCAT(V.titulodavaga,' (',V.empresacontratante,')'), V.titulodavaga) AS vaga FROM candidatovaga CV FORCE INDEX(idxcandidato, idxvaga) INNER JOIN vaga V ON(CV.idvaga = V.idvaga) WHERE CV.idcandidato = '{$idcandidato}' ORDER BY V.titulodavaga DESC";
				$rows = $this->GetRows(false, $sql);
				$lista = "";
				if(is_array($rows))
				{
					foreach ($rows as $key=>$row)
					{
						if(empty($key))
							$lista .= $row['vaga'];
						else
							$lista .= "; ".$row['vaga'];
					}
				}
				return $lista;
			}
			catch( Exception $e )
			{
				throw new Exception( $e );
			}
		}
		################################################################################################################
		public function &GetTotalVaga($idvaga = 0)
		{
			$retorno = 0;
			try
			{
				if(empty($idvaga))
					return $retorno;
				$sql = "SELECT COUNT(*) AS CONT FROM candidatovaga CV WHERE CV.idcandidato = '{$idvaga}'";
				$total = $this->TotalRegistro(false, $sql);
				return $total;
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