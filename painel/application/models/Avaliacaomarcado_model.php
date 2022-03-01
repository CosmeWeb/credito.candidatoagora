<?php
/***********************************************************************
 * Module:  /models/Avaliacaomarcado_model.PHP
 * Author:  Host-up
 * Date:	14/02/2021 23:55:19
 * Purpose: Definição da Classe Avaliacaomarcado_model
 * Instancias: $this->load->model('Avaliacaomarcado_model', 'avaliacaomarcado');
 * Objeto: $avaliacaomarcado = $this->avaliacaomarcado->GetInstancia($dados);
 ***********************************************************************/
if (!class_exists('Avaliacaomarcado_model'))
{
	class Avaliacaomarcado_model extends MY_Model
	{
		################################################################################################################
		public function __construct( $dados = false)
		{
			try
			{
				$this->Tabela = "avaliacaomarcado";
				$this->PrimaryKey = "idavaliacaomarcado";
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
		public function SalvarMarcados($idavaliacao = 0, $idcandidato = 0)
		{
			try
			{
				$idavaliacaocompetencias = Get("idavaliacaocompetencia");
				$idavaliacaomarcados = Get("idavaliacaomarcado");
				if(!empty($idavaliacaocompetencias))
				{
					foreach($idavaliacaocompetencias as $key=>$idavaliacaocompetencia)
					{
						$this->idavaliacaomarcado = $idavaliacaomarcados[$key];
						$this->idavaliacaocompetencia = $idavaliacaocompetencia;
						$this->idavaliacao = $idavaliacao;
						$this->idcandidato = $idcandidato;
						$this->marcado = Get("marcado{$idavaliacaocompetencia}","");
						$this->Ajustar(true);
						$this->Salvar();
					}
				}
			}
			catch( Exception $e )
			{
				throw new Exception( $e );
			}
		}
		################################################################################################################
		public function SalvarListaMarcados($dados = false, $idavaliacao = 0, $idcandidato = 0)
		{
			try
			{
				$comunicacao = self::GetDadosChave($dados, array('comunicacao', 'Comunicacao', 'COMUNICACAO','comunicação', 'Comunicação', 'COMUNICAÇÃO'));
				if(!empty($comunicacao))
				{
					$obj = GetModelo("avaliacaomarcado");
					$sql = "SELECT idavaliacaocompetencia AS id FROM avaliacaocompetencia WHERE titulo = 'Comunicação' LIMIT 1";
					$idavaliacaocompetencia = self::GetSqlCampo($sql, "id", 0);
					if(!empty($idavaliacaocompetencia))
					{
						$filtro = "idavaliacaocompetencia = '{$idavaliacaocompetencia}' AND idavaliacao = '{$idavaliacao}' AND idcandidato = '{$idcandidato}'";
						if(!$obj->Load($filtro))
						{
							$obj->idavaliacaomarcado = 0;
							$obj->idavaliacaocompetencia = $idavaliacaocompetencia;
							$obj->idavaliacao = $idavaliacao;
							$obj->idcandidato = $idcandidato;
						}

						$obj->marcado = $comunicacao;
						$obj->Ajustar(true);
						$obj->Salvar();
					}
				}
				$conhecimento_tecnico = self::GetDadosChave($dados, array('conhecimento_tecnico', 'Conhecimento_tecnico', 'CONHECIMENTO_TECNICO','conhecimento tecnico', 'Conhecimento tecnico', 'CONHECIMENTO TECNICO','conhecimento técnico', 'Conhecimento técnico', 'CONHECIMENTO TÉCNICO'));
				if(!empty($conhecimento_tecnico))
				{
					$obj = GetModelo("avaliacaomarcado");
					$sql = "SELECT idavaliacaocompetencia AS id FROM avaliacaocompetencia WHERE titulo = 'Conhecimento técnico' LIMIT 1";
					$idavaliacaocompetencia = self::GetSqlCampo($sql, "id", 0);
					if(!empty($idavaliacaocompetencia))
					{
						$filtro = "idavaliacaocompetencia = '{$idavaliacaocompetencia}' AND idavaliacao = '{$idavaliacao}' AND idcandidato = '{$idcandidato}'";
						if(!$obj->Load($filtro))
						{
							$obj->idavaliacaomarcado = 0;
							$obj->idavaliacaocompetencia = $idavaliacaocompetencia;
							$obj->idavaliacao = $idavaliacao;
							$obj->idcandidato = $idcandidato;
						}

						$obj->marcado = $conhecimento_tecnico;
						$obj->Ajustar(true);
						$obj->Salvar();
					}
				}
				$relacionamento = self::GetDadosChave($dados, array('relacionamento','Relacionamento', 'RELACIONAMENTO'));
				if(!empty($relacionamento))
				{
					$obj = GetModelo("avaliacaomarcado");
					$sql = "SELECT idavaliacaocompetencia AS id FROM avaliacaocompetencia WHERE titulo = 'Relacionamento' LIMIT 1";
					$idavaliacaocompetencia = self::GetSqlCampo($sql, "id", 0);
					if(!empty($idavaliacaocompetencia))
					{
						$filtro = "idavaliacaocompetencia = '{$idavaliacaocompetencia}' AND idavaliacao = '{$idavaliacao}' AND idcandidato = '{$idcandidato}'";
						if(!$obj->Load($filtro))
						{
							$obj->idavaliacaomarcado = 0;
							$obj->idavaliacaocompetencia = $idavaliacaocompetencia;
							$obj->idavaliacao = $idavaliacao;
							$obj->idcandidato = $idcandidato;
						}

						$obj->marcado = $relacionamento;
						$obj->Ajustar(true);
						$obj->Salvar();
					}
				}
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