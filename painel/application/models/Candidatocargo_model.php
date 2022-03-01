<?php
/***********************************************************************
 * Module:  /models/Candidatocargo_model.PHP
 * Author:  Host-up
 * Date:	30/06/2020 21:32:44
 * Purpose: Definição da Classe Candidatocargo_model
 * Instancias: $this->load->model('Candidatocargo_model', 'candidatocargo');
 * Objeto: $candidatocargo = $this->candidatocargo->GetInstancia($dados);
 ***********************************************************************/
if (!class_exists('Candidatocargo_model'))
{
	class Candidatocargo_model extends MY_Model
	{
		private static $_area = null;
		private static $_cargo = null;
		private static $_empresacargo = null;
		private static $_subarea = null;
		private static $_nivel = null;
		private static $_setor = null;
		private static $_tamanho = null;
		private static $_nacionalidade = null;
		################################################################################################################
		public function __construct( $dados = false)
		{
			try
			{
				$this->Tabela = "candidatocargo";
				$this->PrimaryKey = "idcandidatocargo";
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
		public static function &NewArea() {
			if (self::$_area == null)
				self::$_area = GetModelo("area");
			return self::$_area;
		}
		################################################################################################################
		public static function &NewCargo() {
			if (self::$_cargo == null)
				self::$_cargo = GetModelo("cargo");
			return self::$_cargo;
		}
		################################################################################################################
		public static function &NewEmpresacargo() {
			if (self::$_empresacargo == null)
				self::$_empresacargo = GetModelo("empresacargo");
			return self::$_empresacargo;
		}
		################################################################################################################
		public static function &NewSubarea() {
			if (self::$_subarea == null)
				self::$_subarea = GetModelo("subarea");
			return self::$_subarea;
		}
		################################################################################################################
		public static function &NewNivel() {
			if (self::$_nivel == null)
				self::$_nivel = GetModelo("nivel");
			return self::$_nivel;
		}
		################################################################################################################
		public static function &NewSetor() {
			if (self::$_setor == null)
				self::$_setor = GetModelo("setor");
			return self::$_setor;
		}
		################################################################################################################
		public static function &NewTamanho() {
			if (self::$_tamanho == null)
				self::$_tamanho = GetModelo("tamanho");
			return self::$_tamanho;
		}
		################################################################################################################
		public static function &NewNacionalidade() {
			if (self::$_nacionalidade == null)
				self::$_nacionalidade = GetModelo("nacionalidade");
			return self::$_nacionalidade;
		}
		################################################################################################################
		public function SalvarListaCandidatocargo($dados = false, $idcandidato = 0)
		{
			if(empty($dados))
				return;
			$area = self::NewArea();
			$cargo = self::NewCargo();
			$empresacargo = self::NewEmpresacargo();
			$subarea = self::NewSubarea();
			$nivel = self::NewNivel();
			$setor = self::NewSetor();
			$tamanho = self::NewTamanho();
			$nacionalidade = self::NewNacionalidade();
			for($i = 1; $i <= 10; $i++)
			{
				$nomeempresa = self::GetDadosChave($dados, array("lkd-emp{$i}-depara","lkd_emp{$i}_depara","LKD-emp{$i}-depara","LKD-EMP{$i}-DEPARA","LKD_EMP{$i}_DEPARA"));
				$nomeempresa = trim($nomeempresa);
				if(empty($nomeempresa))
				{
					$nomeempresa = self::GetDadosChave($dados, array("LKD_Empresa {$i}", "LKD_empresa {$i}", "lkd_empresa {$i}", "lkd_empresa_{$i}", "LKD_EMPRESA {$i}", "LKD_EMPRESA_{$i}"));
				}
				$nomecargo = self::GetDadosChave($dados, array("LKD_Cargo {$i}","LKD_cargo {$i}","lkd_cargo {$i}","lkd_cargo_{$i}","LKD_CARGO {$i}","LKD_CARGO_{$i}"));
				$nomearea = self::GetDadosChave($dados, array("LKD_Cargo{$i}_Area","LKD_cargo{$i}_area","lkd_cargo{$i}_area","LKD_CARGO{$i}_AREA"));
				$nomesubarea = self::GetDadosChave($dados, array("LKD_Cargo{$i}_Subarea","LKD_cargo{$i}_subarea","lkd_cargo{$i}_subarea","LKD_CARGO{$i}_SUBAREA"));
				$nomenivel = self::GetDadosChave($dados, array("LKD_Cargo{$i}_Nivel","LKD_cargo{$i}_nivel","lkd_cargo{$i}_nivel","LKD_CARGO{$i}_NIVEL"));
				$nomesetor = self::GetDadosChave($dados, array("LKD_Setor {$i}","LKD_setor {$i}","LKD_SETOR {$i}","setor {$i}","Setor {$i}","SETOR {$i}"));
				$nometamanho = self::GetDadosChave($dados, array("LKD_Tamanho {$i}","LKD_tamanho {$i}","LKD_TAMANHO {$i}","tamanho {$i}","Tamanho {$i}","TAMANHO {$i}"));
				$nomenacionalidade = self::GetDadosChave($dados, array("LKD_Nacionalidade {$i}","LKD_nacionalidade {$i}","LKD_NACIONALIDADE {$i}","nacionalidade {$i}","Nacionalidade {$i}","NACIONALIDADE {$i}"));

				$inicio = self::GetDadosChave($dados, array("LKD_Início {$i}","LKD_Inicio {$i}","LKD_início {$i}","LKD_inicio {$i}","lkd_início {$i}","lkd_inicio {$i}","LKD_INÍCIO {$i}","LKD_INICIO {$i}"));
				$termino = self::GetDadosChave($dados, array("LKD_Término {$i}","LKD_Termino {$i}","LKD_término {$i}","LKD_termino {$i}","lkd_término {$i}","lkd_termino {$i}","LKD_TÉRMINO {$i}","LKD_TERMINO {$i}"));
				$empregado = self::GetDadosChave($dados, array("LKD_empregado{$i}","LKD_Empregado{$i}","lkd_empregado{$i}","LKD_EMPREGADO{$i}"));
				$duracao = self::GetDadosChave($dados, array("LKD_Duração {$i}","LKD_Duracao {$i}","LKD_duração {$i}","LKD_duracao {$i}","LKD_duração_{$i}","LKD_duracao_{$i}","lkd_duração {$i}","lkd_duracao {$i}","lkd_duração_{$i}","lkd_duracao_{$i}","LKD_DURAÇÃO {$i}","LKD_DURACAO {$i}"));
				
				$descricao = trim(self::GetDadosChave($dados, array("LKD_Descrição {$i}","lkd_descricao_{$i}","LKD_descricao_{$i}","descricao {$i}","descrição {$i}","Descricao {$i}","LKD_descrição {$i}","lkd_descrição_{$i}","LKD_Descricao_{$i}","DESCRICAO {$i}","DESCRIÇÃO {$i}","LKD_DESCRICAO {$i}")));
				if(!empty($descricao))
				{
					$descricao = str_ireplace("O LinkedIn me ajudou a conseguir esse emprego", "", $descricao);
				}
				$historico = "Cargo {$i}";

				$filtro = " historico = '{$historico}' AND idcandidato = '{$idcandidato}'";
				if(!$this->Load($filtro))
				{
					if(empty($nomecargo))
						continue;
					$this->Carregar($this->GetDefault());
				}
				else
				{
					if(empty($nomecargo))
					{
						$this->Apagar();
						continue;
					}
				}
				$idempresacargo = $empresacargo->LerIdEmpresacargo($nomeempresa);
				$idarea = $area->LerIdArea($nomearea);
				$idcargo = $cargo->LerIdCargo($nomecargo);
				$idsubarea = $subarea->LerIdSubarea($nomesubarea, $idarea);
				$idnivel = $nivel->LerIdNivel($nomenivel);
				$idsetor = $setor->LerIdSetor($nomesetor);
				$idtamanho = $tamanho->LerIdTamanho($nometamanho);
				$idnacionalidade = $nacionalidade->LerIdNacionalidade($nomenacionalidade);
				if(!empty($inicio))
				{
					$inicio = date("Y", TimeData($inicio));
				}
				if(!empty($termino))
				{
					$termino = date("Y", TimeData($termino));
				}

				$this->idcandidato = $idcandidato;
				$this->idarea = $idarea;
				$this->idcargo = $idcargo;
				$this->idempresacargo = $idempresacargo;
				$this->idsubarea = $idsubarea;
				$this->idnivel = $idnivel;
				$this->idsetor = $idsetor;
				$this->idtamanho = $idtamanho;
				$this->idnacionalidade = $idnacionalidade;
				$this->inicio = $inicio;
				$this->termino = $termino;
				$this->duracao = $duracao;
				if(!empty($descricao))
					$this->descricao = $descricao;
				if(empty($empregado))
				{
					$this->atual = "Não";
				}
				else
				{
					$empregado = ucfirst(strtolower($empregado));
					if($empregado == "Sim")
					{
						$this->atual = "Sim";
					}
					else
					{
						$this->atual = "Não";
					}
				}
				$this->historico = $historico;

				$this->Ajustar(true);
				$this->Salvar();
			}
			return;
		}
		################################################################################################################
		public function &ListaDeCargos($idcandidato = 0)
		{
			$retorno = false;
			try
			{
				if(empty($idcandidato))
					return $retorno;
				$sql = "SELECT CC.idcandidatocargo, CC.idcargo, C.cargo, CG.empresa, CC.descricao, CC.inicio, CC.termino, CC.atual, CC.historico FROM candidatocargo CC USE INDEX(idxcandidato, idxcargo, idxempresacargo) INNER JOIN cargo C ON(CC.idcargo = C.idcargo) INNER JOIN empresacargo CG ON(CC.idempresacargo = CG.idempresacargo) WHERE CC.idcandidato = '{$idcandidato}' ORDER BY CC.historico ASC";
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
		public function &GetUtimoCargo($idcandidato = 0)
		{
			$retorno = false;
			try
			{
				if(empty($idcandidato))
					return $retorno;
				$sql = "SELECT CC.historico, C.cargo, CG.empresa FROM candidatocargo CC USE INDEX(idxcandidato, idxcargo, idxempresacargo) INNER JOIN cargo C ON(CC.idcargo = C.idcargo) INNER JOIN empresacargo CG ON(CC.idempresacargo = CG.idempresacargo) WHERE CC.idcandidato = '{$idcandidato}' ORDER BY CC.historico ASC LIMIT 1";
				$row = $this->GetRow(false, $sql);
				return $row;
			}
			catch( Exception $e )
			{
				throw new Exception( $e );
			}
		}
		################################################################################################################
		public static function Map($row = false)
		{
			$row['idcandidatocargo'] = intval($row['idcandidatocargo']);
			$row['idcargo'] = intval($row['idcargo']);
			$row['inicio'] = intval($row['inicio']);
			$row['termino'] = intval($row['termino']);			
			return $row;
		}		
		################################################################################################################
		public function &GetDadosCargoAtual($idcandidato = 0)
		{
			$retorno = false;
			try
			{
				if(empty($idcandidato))
					return $retorno;
				/*$sql = "SELECT T.tamanho, S.setor, N.nacionalidade, NV.nivel, A.area, SA.subarea FROM candidatocargo CC USE INDEX(idxcandidato,idxcargo,idxarea,idxsubarea,idxnivel,idxsetor,idxtamanho,idxnacionalidade) INNER JOIN cargo C ON(CC.idcargo = C.idcargo) LEFT JOIN tamanho T ON(CC.idtamanho = T.idtamanho) LEFT JOIN setor S ON(CC.idsetor = S.idsetor) LEFT JOIN nacionalidade N ON(CC.idnacionalidade = N.idnacionalidade) LEFT JOIN nivel NV ON(CC.idnivel = NV.idnivel) LEFT JOIN area A ON(CC.idarea = A.idarea) LEFT JOIN subarea SA ON(CC.idsubarea = SA.idsubarea) WHERE CC.idcandidato = '{$idcandidato}' AND CC.historico = 'Cargo 1' ORDER BY CC.historico ASC LIMIT 1";*/
				$sql = "SELECT T.tamanho, S.setor, N.nacionalidade FROM candidatocargo CC USE INDEX(idxcandidato,idxcargo,idxsetor,idxtamanho,idxnacionalidade) INNER JOIN cargo C ON(CC.idcargo = C.idcargo) LEFT JOIN tamanho T ON(CC.idtamanho = T.idtamanho) LEFT JOIN setor S ON(CC.idsetor = S.idsetor) LEFT JOIN nacionalidade N ON(CC.idnacionalidade = N.idnacionalidade) WHERE CC.idcandidato = '{$idcandidato}' AND CC.historico = 'Cargo 1' ORDER BY CC.historico ASC LIMIT 1";
				$rows = $this->GetRow(false, $sql);
				return $rows;
			}
			catch( Exception $e )
			{
				throw new Exception( $e );
			}
		}
		################################################################################################################
		public function &GetListaDeCargos($idcandidato = 0, $limite = 0)
		{
			$retorno = false;
			try
			{
				if(empty($idcandidato))
					return $retorno;
				if(empty($limite))
					$sqlLimite = "";
				else
					$sqlLimite = " LIMIT 0, {$limite}";
				$sql = "SELECT CC.idcandidatocargo, CC.idcargo, C.cargo, CC.descricao, CG.empresa, A.area, SB.subarea, N.nivel, S.setor, T.tamanho, NL.nacionalidade, CC.duracao, CC.inicio, CC.termino, CC.atual, CC.historico FROM candidatocargo CC USE INDEX(idxcandidato, idxcargo, idxempresacargo) 
				INNER JOIN cargo C ON(CC.idcargo = C.idcargo) 
				INNER JOIN empresacargo CG ON(CC.idempresacargo = CG.idempresacargo) 
				LEFT JOIN area A ON(CC.idarea = A.idarea) 
				LEFT JOIN subarea SB ON(CC.idsubarea = SB.idsubarea) 
				LEFT JOIN nivel N ON(CC.idnivel = N.idnivel) 
				LEFT JOIN setor S ON(CC.idsetor = S.idsetor) 
				LEFT JOIN tamanho T ON(CC.idtamanho = T.idtamanho) 
				LEFT JOIN nacionalidade NL ON(CC.idnacionalidade = NL.idnacionalidade) WHERE CC.idcandidato = '{$idcandidato}' ORDER BY CC.historico ASC{$sqlLimite}";
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