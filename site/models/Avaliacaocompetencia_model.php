<?php
/***********************************************************************
 * Module:  /models/Avaliacaocompetencia_model.PHP
 * Author:  Host-up
 * Date:	12/02/2021 23:19:21
 * Purpose: Definição da Classe Avaliacaocompetencia_model
 * Instancias: $this->load->model('Avaliacaocompetencia_model', 'avaliacaocompetencia');
 * Objeto: $avaliacaocompetencia = $this->avaliacaocompetencia->GetInstancia($dados);
 ***********************************************************************/
if (!class_exists('Avaliacaocompetencia_model'))
{
	class Avaliacaocompetencia_model extends MY_Model
	{
		################################################################################################################
		public function __construct( $dados = false)
		{
			try
			{
				$this->Tabela = "avaliacaocompetencia";
				$this->PrimaryKey = "idavaliacaocompetencia";
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
		public function &GetAvaliacaoCompetencia( $idavaliacao = 0)
		{
			$retorno = false;
			try
			{
				if(empty($idavaliacao))
				{
					$idavaliacao = $this->Get("idavaliacao", 0);
				}
				if(empty($idavaliacao))
				{
					$sql = "SELECT AC.idavaliacaocompetencia, AC.titulo, AC.descricao, '0' AS idavaliacaomarcado, '' AS marcado FROM avaliacaocompetencia AC WHERE AC.ativo = 'Sim' ORDER BY AC.ordem ASC";
				}
				else
				{
					$sql = "SELECT AC.idavaliacaocompetencia, AC.titulo, AC.descricao, AM.idavaliacaomarcado, AM.marcado FROM avaliacaocompetencia AC LEFT JOIN avaliacaomarcado AM ON(AC.idavaliacaocompetencia = AM.idavaliacaocompetencia AND AM.idavaliacao = '{$idavaliacao}') WHERE AC.ativo = 'Sim' ORDER BY AC.ordem ASC";
				}
				
				$objs = $this->FiltroObjetos(false, $sql);
				return $objs;
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