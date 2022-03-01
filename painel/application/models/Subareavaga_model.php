<?php
/***********************************************************************
 * Module:  /models/Subareavaga_model.PHP
 * Author:  Host-up
 * Date:	24/06/2020 21:04:59
 * Purpose: Definição da Classe Subareavaga_model
 * Instancias: $this->load->model('Subareavaga_model', 'subareavaga');
 * Objeto: $subareavaga = $this->subareavaga->GetInstancia($dados);
 ***********************************************************************/
if (!class_exists('Subareavaga_model'))
{
	class Subareavaga_model extends MY_Model
	{
		################################################################################################################
		public function __construct( $dados = false)
		{
			try
			{
				$this->Tabela = "subareavaga";
				$this->PrimaryKey = "idsubareavaga";
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
		public function SalvarSubareavaga($idsubareavaga = 0, $idsubarea = 0, $idvaga = 0)
		{
			try
			{
				if(empty($idsubarea))
					return;
				if(empty($idvaga))
					return;
				$filtro = "idsubarea = '{$idsubarea}' AND idvaga = '{$idvaga}'";
				if($this->Existe($filtro))
				{
					return;
				}
				$this->idsubareavaga = $idsubareavaga;
				$this->idsubarea = $idsubarea;
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
		public function CarregarMaisSubareaVaga()
		{
			$posicao = Get("posicao", 0);
			$total = Get("total", 0);
			$idvaga = Get("idvaga", 0);
			if(empty($total))
			{
				$sql = "SELECT COUNT(*) AS CONT FROM subareavaga SV INNER JOIN subarea S ON(SV.idsubarea = S.idsubarea) WHERE SV.idvaga = '{$idvaga}'";
				$total = $this->TotalRegistro(false, $sql);
				if(empty($total))
				{
					$dados['sucesso'] = false;
					$dados['erro'] = __("Nenhuma subarea esta disponível no momento.");
					$dados['titulo'] = __("Erro");
					return $dados;
				}
			}
			$limiterows = 100;
			$limite = $total - $posicao;
			$sql = "SELECT SV.*, S.subarea, S.idarea FROM subareavaga SV INNER JOIN subarea S ON(SV.idsubarea = S.idsubarea) WHERE SV.idvaga = '{$idvaga}' ORDER BY S.subarea ASC LIMIT {$posicao}, {$limiterows}";
			$rows = $this->GetRows(false, $sql);
			if(empty($rows))
			{
				$dados['sucesso'] = true;
				$dados['lista'] = false;
				$dados['mensagem'] = __("Lista de subareas foi encontrada com sucesso.");
				$dados['titulo'] = __("Sucesso");				
				$dados['finalizar'] = true;
				$dados['total'] = $total;
				$dados['posicao'] = $posicao + $limiterows;
				return $dados;
			}
			if($limite <= $limiterows)
			{
				$dados[ 'sucesso' ] = true;
				$dados['lista'] = $rows;
				$dados['mensagem'] = __("Lista de subareas foi encontrada com sucesso.");
				$dados['titulo'] = __("Sucesso");
				$dados['finalizar'] = true;
				$dados['total'] = $total;
				$dados['posicao'] = $posicao + $limite;
			}
			else
			{
				$dados[ 'sucesso' ] = true;
				$dados['lista'] = $rows;
				$dados['mensagem'] = __("Lista de subareas foi encontrada com sucesso.");
				$dados['titulo'] = __("Sucesso");
				$dados['finalizar'] = false;
				$dados['total'] = $total;
				$dados['posicao'] = $posicao + $limiterows;
			}
			return $dados;
		}
		################################################################################################################
		public function ListadeSubarea($idvaga = 0, $separacao = ",")
		{
			$retorno = "";
			try
			{
				if(empty($idvaga))
					return $retorno;
				$sql = "SELECT S.subarea FROM subareavaga SB LEFT JOIN subarea S ON(SB.idsubarea = S.idsubarea) WHERE SB.idvaga = '{$idvaga}' ORDER BY S.subarea ASC";
				$rows = $this->GetRows(false, $sql);
				if(empty($rows))
					return "";
				$lista = "";
				foreach($rows as $key=>$row)
				{
					if(empty($row['subarea']))
						continue;
					if(empty($lista))
						$lista .= $row['subarea'];
					else
					{
						$lista .= "{$separacao} ".$row['subarea'];
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
		public function GetListaSubarea($idvaga = 0, $posicao = 0 , $limite = 0)
		{
			$retorno = false;
			try
			{
				if(empty($idvaga))
					return $retorno;
					
				$filtro = " idvaga = '{$idvaga}' LIMIT {$posicao},{$limite}";
				return $this->FiltroJson($filtro);
			}
			catch( Exception $e )
			{
				throw new Exception( $e );
			}
		}
		################################################################################################################
		public function GetListaSubareaTotal($idvaga = 0)
		{
			$retorno = false;
			try
			{
				if(empty($idvaga))
					return $retorno;
					
				$filtro = " idvaga = '{$idvaga}' ";
				return $this->TotalRegistro($filtro);
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