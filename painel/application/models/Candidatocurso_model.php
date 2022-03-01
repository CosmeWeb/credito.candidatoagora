<?php
/***********************************************************************
 * Module:  /models/Candidatocurso_model.PHP
 * Author:  Host-up
 * Date:	01/07/2020 20:59:11
 * Purpose: Definição da Classe Candidatocurso_model
 * Instancias: $this->load->model('Candidatocurso_model', 'candidatocurso');
 * Objeto: $candidatocurso = $this->candidatocurso->GetInstancia($dados);
 ***********************************************************************/
if (!class_exists('Candidatocurso_model'))
{
	class Candidatocurso_model extends MY_Model
	{
		private static $_curso = null;
		private static $_instituicao = null;
		################################################################################################################
		public function __construct( $dados = false)
		{
			try
			{
				$this->Tabela = "candidatocurso";
				$this->PrimaryKey = "idcandidatocurso";
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
		public static function &NewCurso() {
			if (self::$_curso == null)
				self::$_curso = GetModelo("curso");
			return self::$_curso;
		}
		################################################################################################################
		public static function &NewInstituicao() {
			if (self::$_instituicao == null)
				self::$_instituicao = GetModelo("instituicao");
			return self::$_instituicao;
		}
		################################################################################################################
		public function SalvarListaCandidatocurso($dados = false, $idcandidato = 0)
		{
			if(empty($dados))
				return;
			$curso = self::NewCurso();
			$instituicao = self::NewInstituicao();
			for($i = 1; $i <= 4; $i++)
			{
				$nomeinstituicao = self::GetDadosChave($dados, array("LKD_Instituição {$i}","LKD_Instituicao {$i}","LKD_instituição {$i}","LKD_instituicao {$i}","lkd_instituição {$i}","lkd_instituicao {$i}","LKD_INSTITUIÇÃO {$i}","LKD_INSTITUICAO {$i}"));
				$nomecurso = self::GetDadosChave($dados, array("LKD_Curso {$i}","LKD_curso {$i}","lkd_curso {$i}","lkd_curso_{$i}","LKD_CURSO {$i}","LKD_CURSO_{$i}"));
				$inicio = self::GetDadosChave($dados, array("LKD_Início curso {$i}","LKD_Inicio curso {$i}","LKD_início curso {$i}","lkd_início curso {$i}","lkd_inicio curso {$i}","lkd_inicio_curso_{$i}","LKD_INÍCIO CURSO {$i}","LKD_INICIO CURSO {$i}"));
				$termino = self::GetDadosChave($dados, array("LKD_Término curso {$i}","LKD_Termino curso {$i}","LKD_término curso {$i}","LKD_termino curso {$i}","lkd_término curso {$i}","lkd_termino curso {$i}","LKD_TÉRMINO CURSO {$i}","LKD_TERMINO CURSO {$i}"));
				
				$historico = "Curso {$i}";

				$filtro = " historico = '{$historico}' AND idcandidato = '{$idcandidato}'";
				if(!$this->Load($filtro))
				{
					if(empty($nomecurso))
						continue;
					$this->Carregar($this->GetDefault());
				}
				else
				{
					if(empty($nomecurso))
					{
						$this->Apagar();
						continue;
					}
				}
				$idcurso = $curso->LerIdCurso($nomecurso);
				$idinstituicao = $instituicao->LerIdInstituicao($nomeinstituicao);

				$this->idcandidato = $idcandidato;
				$this->idcurso = $idcurso;
				$this->idinstituicao = $idinstituicao;
				$this->inicio = $inicio;
				$this->termino = $termino;
				$this->historico = $historico;

				$this->Ajustar(true);
				$this->Salvar();
			}
			return;
		}
		################################################################################################################
		public function &GetListaDeCursos($idcandidato = 0)
		{
			$retorno = false;
			try
			{
				if(empty($idcandidato))
					return $retorno;
				$sql = "SELECT CC.idcandidatocurso, C.curso, I.instituicao, CC.inicio, CC.termino, CC.historico  FROM candidatocurso CC USE INDEX(idxcandidato, idxcurso, idxinstituicao) LEFT JOIN curso C ON(CC.idcurso = C.idcurso) LEFT JOIN instituicao I ON(CC.idinstituicao = I.idinstituicao) WHERE CC.idcandidato = '{$idcandidato}' ORDER BY CC.historico ASC";
				$rows = $this->GetRows(false, $sql);
				return $rows;
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