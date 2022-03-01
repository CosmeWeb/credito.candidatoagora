<?php
/***********************************************************************
 * Module:  /models/Cargocorrelato_model.PHP
 * Author:  Host-up
 * Date:	29/05/2020 16:21:26
 * Purpose: Definição da Classe Cargocorrelato_model
 * Instancias: $this->load->model('Cargocorrelato_model', 'cargocorrelato');
 * Objeto: $cargocorrelato = $this->cargocorrelato->GetInstancia($dados);
 ***********************************************************************/
if (!class_exists('Cargocorrelato_model'))
{
	class Cargocorrelato_model extends MY_Model
	{
		################################################################################################################
		public function __construct( $dados = false)
		{
			try
			{
				$this->Tabela = "cargocorrelato";
				$this->PrimaryKey = "idcargocorrelato";
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
		public function SalvarCargo( $idcargocorrelato = 0, $cargo = 0, $idvaga = 0)
		{
			try
			{
				if(empty($cargo))
					return;
				if(empty($idvaga))
					return;
				$filtro = "cargo = '{$cargo}' AND idvaga = '{$idvaga}'";
				if($this->Existe($filtro))
				{
					return;
				}
				$this->idcargocorrelato = $idcargocorrelato;
				$this->cargo = $cargo;
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
		public function GetListaCargo($idvaga = 0, $posicao = 0 , $limite = 0)
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
		public function GetListaCargoTotal($idvaga = 0)
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
		public function ListadeCargo($idvaga = 0, $separacao = ",")
		{
			$retorno = "";
			try
			{
				if(empty($idvaga))
					return $retorno;
				$sql = "SELECT C.cargo FROM cargocorrelato C WHERE C.idvaga = '{$idvaga}' ORDER BY C.cargo ASC";
				$rows = $this->GetRows(false, $sql);
				if(empty($rows))
					return "";
				$lista = "";
				foreach($rows as $key=>$row)
				{
					if(empty($row['cargo']))
						continue;
					if(empty($lista))
						$lista .= $row['cargo'];
					else
					{
						$lista .= "{$separacao} ".$row['cargo'];
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
		public function LimpaCargosVaga($idvaga = 0, $idcargos = false)
		{
			$retorno = false;
			try
			{
				if(empty($idvaga))
					return $retorno;
					
				$filtro = " idvaga = '{$idvaga}' ";
				if(!empty($idcargos))
				{
					$filtro .= " AND idcargo ".GerarIN($idcargos, true);
				}
				$objs =  $this->FiltroObjetos($filtro);
				if(!empty($objs))
				{
					foreach($objs as $obj)
					{
						$obj->Apagar();
					}
				}
			}
			catch( Exception $e )
			{
				throw new Exception( $e );
			}
		}
		################################################################################################################
		public function CarregarMaisCargos()
		{
			$posicao = Get("posicao", 0);
			$total = Get("total", 0);
			$idvaga = Get("idvaga", 0);
			if(empty($total))
			{
				$sql = "SELECT COUNT(*) AS CONT FROM cargocorrelato CC WHERE CC.idvaga = '{$idvaga}'";
				$total = $this->TotalRegistro(false, $sql);
				if(empty($total))
				{
					$dados['sucesso'] = false;
					$dados['erro'] = __("Nenhum cargo correlato esta disponível no momento.");
					$dados['titulo'] = __("Erro");
					return $dados;
				}
			}
			$limiterows = 100;
			$limite = $total - $posicao;
			$sql = "SELECT * FROM cargocorrelato CC WHERE CC.idvaga = '{$idvaga}' ORDER BY CC.cargo ASC LIMIT {$posicao}, {$limiterows}";
			$rows = $this->GetRows(false, $sql);
			if(empty($rows))
			{
				$dados['sucesso'] = true;
				$dados['lista'] = false;
				$dados['mensagem'] = __("Lista de cargos foi encontrado com sucesso.");
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
				$dados['mensagem'] = __("Lista de cargos foi encontrado com sucesso.");
				$dados['titulo'] = __("Sucesso");
				$dados['finalizar'] = true;
				$dados['total'] = $total;
				$dados['posicao'] = $posicao + $limite;
			}
			else
			{
				$dados[ 'sucesso' ] = true;
				$dados['lista'] = $rows;
				$dados['mensagem'] = __("Lista de cargos foi encontrado com sucesso.");
				$dados['titulo'] = __("Sucesso");
				$dados['finalizar'] = false;
				$dados['total'] = $total;
				$dados['posicao'] = $posicao + $limiterows;
			}
			return $dados;
		}
		################################################################################################################
		public function __destruct()
		{
			unset($this->dados, $this->Tabela, $this->PrimaryKey);
		}
	}
}
?>