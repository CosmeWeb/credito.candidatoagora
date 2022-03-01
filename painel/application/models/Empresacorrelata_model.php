<?php
/***********************************************************************
 * Module:  /models/Empresacorrelata_model.PHP
 * Author:  Host-up
 * Date:	03/06/2020 23:28:10
 * Purpose: Definição da Classe Empresacorrelata_model
 * Instancias: $this->load->model('Empresacorrelata_model', 'empresacorrelata');
 * Objeto: $empresacorrelata = $this->empresacorrelata->GetInstancia($dados);
 ***********************************************************************/
if (!class_exists('Empresacorrelata_model'))
{
	class Empresacorrelata_model extends MY_Model
	{
		################################################################################################################
		public function __construct( $dados = false)
		{
			try
			{
				$this->Tabela = "empresacorrelata";
				$this->PrimaryKey = "idempresacorrelata";
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
		public function SalvarEmpresa( $idempresacorrelata = 0, $empresa = "", $idvaga = 0)
		{
			try
			{
				if(empty($empresa))
					return;
				if(empty($idvaga))
					return;
				$filtro = "empresa = '{$empresa}' AND idvaga = '{$idvaga}'";
				if($this->Existe($filtro))
				{
					return;
				}
				$this->idempresacorrelata = $idempresacorrelata;
				$this->empresa = $empresa;
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
		public function CarregarMaisEmpresas()
		{
			$posicao = Get("posicao", 0);
			$total = Get("total", 0);
			$idvaga = Get("idvaga", 0);
			if(empty($total))
			{
				$sql = "SELECT COUNT(*) AS CONT FROM empresacorrelata EC WHERE EC.idvaga = '{$idvaga}'";
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
			$sql = "SELECT * FROM empresacorrelata EC WHERE EC.idvaga = '{$idvaga}' ORDER BY EC.empresa ASC LIMIT {$posicao}, {$limiterows}";
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
		public function ListadeEmpresa($idvaga = 0, $separacao = ",")
		{
			$retorno = "";
			try
			{
				if(empty($idvaga))
					return $retorno;
				$sql = "SELECT E.empresa FROM empresacorrelata E WHERE E.idvaga = '{$idvaga}' ORDER BY E.empresa ASC";
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