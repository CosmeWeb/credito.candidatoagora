<?php
/***********************************************************************
 * Module:  /models/Setortarget_model.PHP
 * Author:  Host-up
 * Date:	22/05/2020 21:30:20
 * Purpose: Definição da Classe Setortarget_model
 * Instancias: $this->load->model('Setortarget_model', 'setortarget');
 * Objeto: $setortarget = $this->setortarget->GetInstancia($dados);
 ***********************************************************************/
if (!class_exists('Setortarget_model'))
{
	class Setortarget_model extends MY_Model
	{
		################################################################################################################
		public function __construct( $dados = false)
		{
			try
			{
				$this->Tabela = "setortarget";
				$this->PrimaryKey = "idsetortarget";
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
		public function GerarOpcoesSetor($value = "0", $texto = "", $default = "0")
		{
			if(empty($texto))
				$texto = __("-- Selecione --");
			$primeiro = array("valor"=>$default,"texto"=>$texto);
			$sql = "SELECT idsetor AS 'id', setor AS 'texto' FROM setor ORDER BY texto ASC";
			return $this->GeraOpcoesSql($value, $sql, "id", "texto", $primeiro);
		}
		################################################################################################################
		public function SalvarSetor( $idsetortarget = 0, $idsetor = 0, $idvaga = 0)
		{
			try
			{
				if(empty($idsetor))
					return;
				if(empty($idvaga))
					return;
				$filtro = "idsetor = '{$idsetor}' AND idvaga = '{$idvaga}'";
				if($this->Existe($filtro))
				{
					return;
				}
				$this->idsetortarget = $idsetortarget;
				$this->idsetor = $idsetor;
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
		public function GetListaSetor($idvaga = 0, $posicao = 0 , $limite = 0)
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
		public function GetListaSetorTotal($idvaga = 0)
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
		public function CarregarMaisSetores()
		{
			$posicao = Get("posicao", 0);
			$total = Get("total", 0);
			$idvaga = Get("idvaga", 0);
			$somarcado = Get("somarcado", 0);
			if(empty($total))
			{
				if(empty($somarcado))
				{
					$sql = "SELECT COUNT(DISTINCT S.idsetor) AS CONT FROM setor S LEFT JOIN setortarget ST ON(S.idsetor = ST.idsetor AND ST.idvaga = '{$idvaga}')";
				}
				else
				{
					$sql = "SELECT COUNT(DISTINCT S.idsetor) AS CONT FROM setor S INNER JOIN setortarget ST ON(S.idsetor = ST.idsetor) WHERE ST.idvaga = '{$idvaga}'";
				}
				$total = $this->TotalRegistro(false, $sql);
				if(empty($total))
				{
					$dados['sucesso'] = false;
					$dados['erro'] = __("Nenhum setor esta disponível no momento.");
					$dados['titulo'] = __("Erro");
					return $dados;
				}
			}
			$limiterows = 30;
			$limite = $total - $posicao;
			if(empty($somarcado))
			{
				$sql = "SELECT IF(ISNULL(ST.idsetortarget),0, ST.idsetortarget) AS idsetortarget, S.setor, S.idsetor, IF(ISNULL(ST.idsetortarget),'', 'checked') AS 'checked' FROM setor S LEFT JOIN setortarget ST ON(S.idsetor = ST.idsetor AND ST.idvaga = '{$idvaga}') ORDER BY S.setor ASC LIMIT {$posicao}, {$limiterows}";
			}
			else
			{
				$sql = "SELECT IF(ISNULL(ST.idsetortarget),0, ST.idsetortarget) AS idsetortarget, S.setor, S.idsetor, IF(ISNULL(ST.idsetortarget),'', 'checked') AS 'checked' FROM setor S INNER JOIN setortarget ST ON(S.idsetor = ST.idsetor) WHERE ST.idvaga = '{$idvaga}' ORDER BY S.setor ASC LIMIT {$posicao}, {$limiterows}";
			}
			$rows = $this->GetRows(false, $sql);
			if(empty($rows))
			{
				$dados['sucesso'] = true;
				$dados['lista'] = false;
				$dados['mensagem'] = __("Lista de setores foi encontrado com sucesso.");
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
				$dados['mensagem'] = __("Lista de setores foi encontrado com sucesso.");
				$dados['titulo'] = __("Sucesso");
				$dados['finalizar'] = true;
				$dados['total'] = $total;
				$dados['posicao'] = $posicao + $limite;
			}
			else
			{
				$dados[ 'sucesso' ] = true;
				$dados['lista'] = $rows;
				$dados['mensagem'] = __("Lista de setores foi encontrado com sucesso.");
				$dados['titulo'] = __("Sucesso");
				$dados['finalizar'] = false;
				$dados['total'] = $total;
				$dados['posicao'] = $posicao + $limiterows;
			}
			return $dados;
		}
		################################################################################################################
		public function DeletarEmpresaVaga()
		{
			$retorno = false;
			try
			{
				if(empty($this->idsetor))
					return $retorno;
				if(empty($this->idvaga))
					return $retorno;
				$empresa = GetModelo("empresatarget");
				$sql = "SELECT ET.* FROM empresatarget ET INNER JOIN empresa E ON(ET.idempresa = E.idempresa) WHERE ET.idvaga = '{$this->idvaga}' AND E.idsetor = '{$this->idsetor}'";
				$objs = $empresa->FiltroObjetos(false, $sql);
				if(!empty($objs))
				{
					foreach($objs as $key=>$obj)
						$obj->Apagar();
				}
			}
			catch( Exception $e )
			{
				throw new Exception( $e );
			}
		}
		################################################################################################################
		public function ListadeSetor($idvaga = 0, $separacao = ",")
		{
			$retorno = "";
			try
			{
				if(empty($idvaga))
					return $retorno;
				$sql = "SELECT S.setor FROM setortarget ST LEFT JOIN setor S ON(ST.idsetor = S.idsetor) WHERE ST.idvaga = '{$idvaga}' ORDER BY S.setor ASC";
				$rows = $this->GetRows(false, $sql);
				if(empty($rows))
					return "";
				$lista = "";
				foreach($rows as $key=>$row)
				{
					if(empty($row['setor']))
						continue;
					if(empty($lista))
						$lista .= $row['setor'];
					else
					{
						$lista .= "{$separacao} ".$row['setor'];
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