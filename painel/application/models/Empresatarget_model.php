<?php
/***********************************************************************
 * Module:  /models/Empresatarget_model.PHP
 * Author:  Host-up
 * Date:	25/05/2020 21:37:04
 * Purpose: Definição da Classe Empresatarget_model
 * Instancias: $this->load->model('Empresatarget_model', 'empresatarget');
 * Objeto: $empresatarget = $this->empresatarget->GetInstancia($dados);
 ***********************************************************************/
if (!class_exists('Empresatarget_model'))
{
	class Empresatarget_model extends MY_Model
	{
		################################################################################################################
		public function __construct( $dados = false)
		{
			try
			{
				$this->Tabela = "empresatarget";
				$this->PrimaryKey = "idempresatarget";
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
		public function SalvarEmpresa( $idempresatarget = 0, $idempresa = 0, $idvaga = 0)
		{
			try
			{
				if(empty($idempresa))
					return;
				if(empty($idvaga))
					return;
				$filtro = "idempresa = '{$idempresa}' AND idvaga = '{$idvaga}'";
				if($this->Existe($filtro))
				{
					return;
				}
				$this->idempresatarget = $idempresatarget;
				$this->idempresa = $idempresa;
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
		public function GetListaEmpresaTotal($idvaga = 0)
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
		public function GetListaEmpresa($idvaga = 0, $posicao = 0 , $limite = 0)
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
		public function CarregarMaisEmpresas()
		{
			$posicao = Get("posicao", 0);
			$total = Get("total", 0);
			$idvaga = Get("idvaga", 0);
			$somarcado = Get("somarcado", 0);
			if(empty($total))
			{
				if(empty($somarcado))
				{
					$sql = "SELECT COUNT(DISTINCT E.idempresa) AS CONT FROM empresa E INNER JOIN setor S ON(E.idsetor = S.idsetor) INNER JOIN setortarget ST ON(E.idsetor = ST.idsetor) LEFT JOIN empresatarget ET ON(E.idempresa = ET.idempresa AND ET.idvaga = '{$idvaga}') WHERE ST.idvaga = '{$idvaga}'";
				}
				else
				{
					$sql = "SELECT COUNT(DISTINCT S.idsetor) AS CONT FROM empresa E INNER JOIN setor S ON(E.idsetor = S.idsetor) LEFT JOIN empresatarget ET ON(E.idempresa = ET.idempresa AND ET.idvaga = '{$idvaga}') WHERE ET.idvaga = '{$idvaga}'";
				}
				$total = $this->TotalRegistro(false, $sql);
				if(empty($total))
				{
					$dados['sucesso'] = false;
					$dados['erro'] = __("Nenhuma empresa dos setores selecionado esta disponível no momento.");
					$dados['titulo'] = __("Erro");
					return $dados;
				}
			}
			$limiterows = 100;
			$limite = $total - $posicao;
			if(empty($somarcado))
			{
				$sql = "SELECT DISTINCT IF(ISNULL(ET.idempresatarget), 0, ET.idempresatarget) AS idempresatarget, E.idempresa AS id, E.empresa, S.setor, S.idsetor, IF(ISNULL(ET.idempresatarget),'', 'checked') AS 'checked' FROM empresa E INNER JOIN setor S ON(E.idsetor = S.idsetor) INNER JOIN setortarget ST ON(E.idsetor = ST.idsetor) LEFT JOIN empresatarget ET ON(E.idempresa = ET.idempresa AND ET.idvaga = '{$idvaga}') WHERE ST.idvaga = '{$idvaga}' ORDER BY S.setor ASC, E.empresa ASC LIMIT {$posicao}, {$limiterows}";
			}
			else
			{
				$sql = "SELECT DISTINCT ET.idempresatarget, E.idempresa AS id, E.empresa, S.setor, S.idsetor FROM empresa E INNER JOIN setor S ON(E.idsetor = S.idsetor) LEFT JOIN empresatarget ET ON(E.idempresa = ET.idempresa AND ET.idvaga = '{$idvaga}') WHERE ET.idvaga = '{$idvaga}' ORDER BY S.setor ASC, E.empresa ASC LIMIT {$posicao}, {$limiterows}";
			}
			$rows = $this->GetRows(false, $sql);
			if(empty($rows))
			{
				$dados['sucesso'] = true;
				$dados['lista'] = false;
				$dados['mensagem'] = __("Lista de empresas foi encontrada com sucesso.");
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
				$dados['mensagem'] = __("Lista de empresas foi encontrada com sucesso.");
				$dados['titulo'] = __("Sucesso");
				$dados['finalizar'] = true;
				$dados['total'] = $total;
				$dados['posicao'] = $posicao + $limite;
			}
			else
			{
				$dados[ 'sucesso' ] = true;
				$dados['lista'] = $rows;
				$dados['mensagem'] = __("Lista de empresas foi encontrada com sucesso.");
				$dados['titulo'] = __("Sucesso");
				$dados['finalizar'] = false;
				$dados['total'] = $total;
				$dados['posicao'] = $posicao + $limiterows;
			}
			return $dados;
		}
		################################################################################################################
		public function ListadeEmpresa($idvaga = 0, $separacao = ",")
		{
			$retorno = "";
			try
			{
				if(empty($idvaga))
					return $retorno;
				$sql = "SELECT E.empresa FROM empresatarget ET LEFT JOIN empresa E ON(ET.idempresa = E.idempresa) WHERE ET.idvaga = '{$idvaga}' ORDER BY E.empresa ASC";
				$rows = $this->GetRows(false, $sql);
				if(empty($rows))
					return "";
				$lista = "";
				foreach($rows as $key=>$row)
				{
					if(empty($row['empresa']))
						continue;
					if(empty($lista))
						$lista .= $row['empresa'];
					else
					{
						$lista .= "{$separacao} ".$row['empresa'];
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
		public function __destruct()
		{
			unset($this->dados, $this->Tabela, $this->PrimaryKey);
		}
	}
}
?>