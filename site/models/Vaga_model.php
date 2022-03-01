<?php
/***********************************************************************
 * Module:  /models/Vaga_model.PHP
 * Author:  Host-up
 * Date:	17/03/2020 21:01:48
 * Purpose: Definição da Classe Vaga_model
 * Instancias: $this->load->model('Vaga_model', 'vaga');
 * Objeto: $vaga = $this->vaga->GetInstancia($dados);
 ***********************************************************************/
if (!class_exists('Vaga_model'))
{
	class Vaga_model extends MY_Model
	{
		################################################################################################################
		public function __construct( $dados = false)
		{
			try
			{
				$this->Tabela = "vaga";
				$this->PrimaryKey = "idvaga";
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
				if(emptyData($this->cadastradoem))
					$this->cadastradoem = date("Y-m-d H:i:s");
				else
					$this->cadastradoem = date("Y-m-d H:i:s",TimeData($this->cadastradoem));
				if(empty($this->ip))
					$this->ip = GetIP();
				if(empty($this->idcolaborador))
					$this->idcolaborador = GetAcesso("idcolaborador");
			}
			else
			{
				if(!emptyData($this->cadastradoem))
					$this->cadastradoem = date("d/m/Y H:i:s",TimeData($this->cadastradoem));
			}
		}
		################################################################################################################
		public function GetSetor()
		{
			$sql = "SELECT setor FROM setor WHERE idsetor = '{$this->idsetor}'";
			return self::GetSqlCampo($sql, "setor", "");
		}
		################################################################################################################
		public function GetFaturamento()
		{
			$sql = "SELECT faturamento FROM faturamento WHERE idfaturamento = '{$this->idfaturamento}'";
			return self::GetSqlCampo($sql, "faturamento", "");
		}
		################################################################################################################
		public function GetTamanho()
		{
			$sql = "SELECT tamanho FROM tamanho WHERE idtamanho = '{$this->idtamanho}'";
			return self::GetSqlCampo($sql, "tamanho", "");
		}
		################################################################################################################
		public function GetMomentoAtualEmpresa()
		{
			$retorno = "Não foi informado.";
			$lista = array(
				'Manutenção'=>"Manutenção: a empresa busca crescer no seu mercado principal, utilizando mesmos canais.",
				'Crescimento'=>"Crescimento: a empresa busca crescer e ganhar competitividade ampliando oferta de soluções e canais.",
				'Startup fase de expansão/captação'=>"Startup fase de expansão / captação: a empresa é uma scale-up, tem produto validado, busca expandir negócio seja com capital próprio ou rodada de investimento.",
				'Startup'=>"Startup: a empresa ainda é considerada uma startup, e busca validação e posicionamento do seu produto no mercado."
			);
			if(empty($this->momentoatualempresa))
				return $retorno;
			if(empty($lista[$this->momentoatualempresa]))
				return $retorno;
			return $lista[$this->momentoatualempresa];
		}
		################################################################################################################
		public function GetArea()
		{
			$sql = "SELECT area FROM area WHERE idarea = '{$this->idarea}'";
			return self::GetSqlCampo($sql, "area", "");
		}
		################################################################################################################
		public function GetNivel()
		{
			$sql = "SELECT nivel FROM nivel WHERE idnivel = '{$this->idnivel}'";
			return self::GetSqlCampo($sql, "nivel", "");
		}
		################################################################################################################
		public function GetSubarea($idvaga = 0)
		{
			$retorno = "Não definidas";
			if(empty($idvaga))
				$idvaga = $this->GetID();
			if(empty($idvaga))
				return $retorno;
			$sql = "SELECT DISTINCT S.subarea FROM subareavaga SV LEFT JOIN subarea S ON(SV.idsubarea = S.idsubarea) WHERE SV.idvaga = '{$idvaga}' ORDER BY S.subarea ASC";
			$rows = $this->GetRows(false, $sql );
			$lista = "";
			if(!empty($rows))
			{
				foreach ($rows as $key=>$row)
				{
					if(empty($key))
						$lista .= "{$row['subarea']}";
					else
						$lista .= ", {$row['subarea']}";
				}
			}
			if(empty($lista))
				return $retorno;
			return $lista;
		}
		################################################################################################################
		public function GetCargosCorrelatos($idvaga = 0)
		{
			$retorno = "Não definidos";
			try
			{
				if(empty($idvaga))
					$idvaga = $this->GetID();
				if(empty($idvaga))
					return $retorno;
				$sql = "SELECT DISTINCT CC.cargo FROM cargocorrelato CC WHERE CC.idvaga = '{$idvaga}' ORDER BY CC.cargo ASC";
				$rows = $this->GetRows(false, $sql );
				$lista = "";
				if(!empty($rows))
				{
					foreach ($rows as $key=>$row)
					{
						if(empty($key))
							$lista .= "{$row['cargo']}";
						else
							$lista .= ", {$row['cargo']}";
					}
				}
				if(empty($lista))
					return $retorno;
				return $lista;
			}
			catch( Exception $e )
			{
				throw new Exception( $e );
			}
		}
		################################################################################################################
		public function GetListaSetores($idvaga = 0)
		{
			$retorno = "Não definidos";
			try
			{				
				if(empty($idvaga))
					$idvaga = $this->GetID();
				if(empty($idvaga))
					return $retorno;
				$sql = "SELECT S.setor FROM setortarget ST LEFT JOIN setor S ON(ST.idsetor = S.idsetor) WHERE ST.idvaga = '{$idvaga}' ORDER BY S.setor ASC";
				$rows = $this->GetRows(false, $sql );
				$lista = "";
				if(!empty($rows))
				{
					foreach ($rows as $key=>$row)
					{
						if(empty($key))
							$lista .= "{$row['setor']}";
						else
							$lista .= ", {$row['setor']}";
					}
				}
				if(empty($lista))
					return $retorno;
				return $lista;
			}
			catch( Exception $e )
			{
				throw new Exception( $e );
			}
		}
		################################################################################################################
		public function GetEmpresasCorrelatos($idvaga = 0)
		{
			$retorno = "Não definidos";
			try
			{
				if(empty($idvaga))
					$idvaga = $this->GetID();
				if(empty($idvaga))
					return $retorno;
				$sql = "SELECT DISTINCT EC.empresa FROM empresacorrelata EC WHERE EC.idvaga = '{$idvaga}' ORDER BY EC.empresa ASC";
				$rows = $this->GetRows(false, $sql );
				$lista = "";
				if(!empty($rows))
				{
					foreach ($rows as $key=>$row)
					{
						if(empty($key))
							$lista .= "{$row['empresa']}";
						else
							$lista .= ", {$row['empresa']}";
					}
				}
				if(empty($lista))
					return $retorno;
				return $lista;
			}
			catch( Exception $e )
			{
				throw new Exception( $e );
			}
		}
		################################################################################################################
		public function GetCompetencias($idvaga = 0)
		{
			$retorno = "Não definidas";
			try
			{
				if(empty($idvaga))
					$idvaga = $this->GetID();
				if(empty($idvaga))
					return $retorno;
				$sql = "SELECT DISTINCT C.competencia FROM competenciacorrelata CC INNER JOIN competencia C ON(CC.idcompetencia = C.idcompetencia) WHERE CC.idvaga = '{$idvaga}' ORDER BY C.competencia ASC";
				$rows = $this->GetRows(false, $sql );
				$lista = "";
				if(!empty($rows))
				{
					foreach ($rows as $key=>$row)
					{
						if(empty($key))
							$lista .= "{$row['competencia']}";
						else
							$lista .= ", {$row['competencia']}";
					}
				}
				if(empty($lista))
					return $retorno;
				return $lista;
			}
			catch( Exception $e )
			{
				throw new Exception( $e );
			}
		}
		################################################################################################################
		public function GetListaEmpresas($idvaga = 0)
		{
			$retorno = false;
			try
			{
				$retorno = "Não definidas";
				if(empty($idvaga))
					$idvaga = $this->GetID();
				if(empty($idvaga))
					return $retorno;
				$sql = "SELECT E.empresa, S.setor FROM empresatarget ET LEFT JOIN empresa E ON(ET.idempresa = E.idempresa) INNER JOIN setor S ON(E.idsetor = S.idsetor) WHERE ET.idvaga = '{$idvaga}' AND ISNULL(NULLIF(E.empresa,'')) = 0 ORDER BY S.setor ASC, E.empresa ASC";
				$rows = $this->GetRows(false, $sql );
				return $rows;
			}
			catch( Exception $e )
			{
				throw new Exception( $e );
			}
		}
		################################################################################################################
		public function GetListaEmpresasExcluir($idvaga = 0)
		{
			$retorno = false;
			try
			{
				$retorno = "Não definidas";
				if(empty($idvaga))
					$idvaga = $this->GetID();
				if(empty($idvaga))
					return $retorno;
				$sql = "SELECT E.empresa, S.setor FROM empresatargetexcluir ET LEFT JOIN empresa E ON(ET.idempresa = E.idempresa) INNER JOIN setor S ON(E.idsetor = S.idsetor) WHERE ET.idvaga = '{$idvaga}' AND ISNULL(NULLIF(E.empresa,'')) = 0 ORDER BY S.setor ASC, E.empresa ASC";
				$rows = $this->GetRows(false, $sql );
				return $rows;
			}
			catch( Exception $e )
			{
				throw new Exception( $e );
			}
		}
		################################################################################################################
		public function FaixaDeRemuneracao()
		{
			$inicio = $this->faixaderemuneracaoinicial;
			$final = $this->faixaderemuneracaofim;
			
			if(empty($inicio))
				$inicio = 0;
			else
				$inicio = floatval($inicio);
			if(empty($final))
				$final = 0;
			else
				$final = floatval($final);
			if(($inicio > 0.0)&&($final > 0.0))
			{
				return "Inicial: ". eMoney($inicio)." - Final: ".eMoney($final);
			}
			elseif($inicio > 0.0)
			{
				return "Inicial: ". eMoney($inicio);
			}
			elseif($final > 0.0)
			{
				return "Final: ". eMoney($final);
			}
			else
				return "Não declarado";
		}
		################################################################################################################
		public function GetEstado()
		{
			$sql = "SELECT estado FROM estado WHERE idestado = '{$this->idestado}'";
			return self::GetSqlCampo($sql, "estado", "Não foi informado.");
		}
		################################################################################################################
		public function GetCidade()
		{
			$sql = "SELECT cidade FROM cidade WHERE idcidade = '{$this->idcidade}'";
			return self::GetSqlCampo($sql, "cidade", "Não foi informado.");
		}
		################################################################################################################
		public function GetRaiodePesquisa()
		{
			$retorno = "Não foi informado.";
			$lista = self::ListaRaiodepesquisa();
			if(empty($this->raiodepesquisa))
				return $retorno;
			if(empty($lista[$this->raiodepesquisa]))
				return $retorno;
			return $lista[$this->raiodepesquisa];
		}
		################################################################################################################
		public function GetMobilidade()
		{
			$retorno = "Não foi informado.";
			if(empty($this->mobilidade))
				return $retorno;
			return $this->mobilidade;
		}
		################################################################################################################
		public function GerarOpcoesTamanhos($value = "", $texto = "", $default = "")
		{
			if(empty($texto))
				$texto = __("-- Selecione --");
			$primeiro = array("valor"=>$default,"texto"=>$texto);
			$sql = "SELECT idtamanho AS 'id', tamanho AS 'texto' FROM tamanho ORDER BY ordem ASC";
			return $this->GeraOpcoesSql($value, $sql, "id", "texto", $primeiro);
		}
		################################################################################################################
		public function GerarOpcoesFaturamentos($value = "0", $texto = "", $default = "0")
		{
			if(empty($texto))
				$texto = __("-- Selecione --");
			$primeiro = array("valor"=>$default,"texto"=>$texto);
			$sql = "SELECT idfaturamento AS 'id', faturamento AS 'texto' FROM faturamento ORDER BY ordem ASC";
			return $this->GeraOpcoesSql($value, $sql, "id", "texto", $primeiro);
		}
		################################################################################################################
		public function GerarOpcoesColaborador($value = "0", $texto = "", $default = "0")
		{
			if(empty($texto))
				$texto = __(" -- Selecione --");
			$primeiro = array("valor"=>$default,"texto"=>$texto);
			$sql = "SELECT idcolaborador AS id, nome AS texto FROM colaborador ORDER BY texto ASC";
			return $this->GeraOpcoesSql($value, $sql, "id", "texto", $primeiro);
		}
		################################################################################################################
		public function GerarOpcoesAreas($value = "0", $texto = "", $default = "0")
		{
			if(empty($texto))
				$texto = __(" -- Selecione --");
			$primeiro = array("valor"=>$default,"texto"=>$texto);
			$sql = "SELECT idarea AS 'id', area AS 'texto' FROM area ORDER BY texto ASC";
			return $this->GeraOpcoesSql($value, $sql, "id", "texto", $primeiro);
		}
		################################################################################################################
		public function GerarOpcoesSetores($value = "0", $texto = "", $default = "0")
		{
			if(empty($texto))
				$texto = __(" -- Selecione --");
			$primeiro = array("valor"=>$default,"texto"=>$texto);
			$sql = "SELECT idsetor AS 'id', setor AS 'texto' FROM setor ORDER BY texto ASC";
			return $this->GeraOpcoesSql($value, $sql, "id", "texto", $primeiro);
		}
		################################################################################################################
		public function GerarOpcoesNiveis($value = "", $texto = "", $default = "")
		{
			if(empty($texto))
				$texto = __("-- Selecione --");
			$primeiro = array("valor"=>$default,"texto"=>$texto);
			$sql = "SELECT idnivel AS 'id', nivel AS 'texto' FROM nivel ORDER BY ordem ASC";
			return $this->GeraOpcoesSql($value, $sql, "id", "texto", $primeiro);
		}
		################################################################################################################
		public function GerarOpcoesSubareas($value = "", $texto = "", $default = "")
		{
			if(empty($texto))
				$texto = __("-- Selecione --");
			$primeiro = array("valor"=>$default,"texto"=>$texto);
			$sql = "SELECT idsubarea AS 'id', subarea AS 'texto' FROM subarea ORDER BY texto ASC";
			return $this->GeraOpcoesSql($value, $sql, "id", "texto", $primeiro);
		}
		################################################################################################################
		public function GerarOpcoesCompetencias($value = "", $texto = "", $default = "")
		{
			if(empty($texto))
				$texto = __("-- Selecione --");
			$primeiro = array("valor"=>$default,"texto"=>$texto);
			$sql = "SELECT idcompetencia AS 'id', competencia AS 'texto' FROM competencia ORDER BY texto ASC";
			return $this->GeraOpcoesSql($value, $sql, "id", "texto", $primeiro);
		}
		################################################################################################################
		public function GerarOpcoesEstados($value = "", $texto = "", $default = "")
		{
			if(empty($texto))
				$texto = __("-- Selecione --");
			$primeiro = array("valor"=>$default,"texto"=>$texto);
			$sql = "SELECT DISTINCT E.idestado AS 'id', E.estado AS 'texto' FROM estado E INNER JOIN pais P ON(P.idpais = E.idpais) WHERE P.pais = 'brasil' AND E.estado IN('Acre','Alagoas','Amapá','Amazonas','Bahia','Ceará','Distrito Federal','Espirito Santo','Goiás','Maranhão','Mato Grosso','Mato Grosso Do Sul','Minas Gerais','Pará','Paraíba','Paraná','Pernambuco','Piauí','Rio de Janeiro','Rio Grande do Norte','Rio Grande do Sul','Rondônia','Roraima','Santa Catarina','São Paulo','Sergipe','Tocantins') ORDER BY texto ASC";
			return $this->GeraOpcoesSql($value, $sql, "id", "texto", $primeiro);
		}
		################################################################################################################
		public function GerarOpcoesCidades($value = "", $texto = "", $default = "")
		{
			if(empty($texto))
				$texto = __("-- Selecione --");
			$primeiro = array("valor"=>$default,"texto"=>$texto);
			$sql = "SELECT C.idcidade AS 'id', C.cidade AS 'texto' FROM cidade C LEFT JOIN estado E ON(C.idestado = E.idestado) LEFT JOIN pais P ON(E.idpais = P.idpais) WHERE P.pais = 'Brasil' ORDER BY texto ASC";
			return $this->GeraOpcoesSql($value, $sql, "id", "texto", $primeiro);
		}
		################################################################################################################
		public function GerarOpcoesRaiodepesquisa($valor = "", $texto = "", $default = "")
		{
			if(empty($texto))
				$texto = __("-- Selecione --");
			$primeiro = array("valor"=>$default,"texto"=>$texto);
			$lista = self::ListaRaiodepesquisa();
			return self::GeraOpcoesArray($valor, $lista, $primeiro);
		}
		################################################################################################################
		public function GerarOpcoesLinhadereporte($valor = "", $texto = "", $default = "")
		{
			if(empty($texto))
				$texto = __("-- Selecione --");
			$primeiro = array("valor"=>$default,"texto"=>$texto);
			$lista = self::ListaLinhadereporte();
			return self::GeraOpcoesArray($valor, $lista, $primeiro);
		}
		################################################################################################################
		public function FormGetRadio($nome = "", $valor = "", $defult = "")
		{

			$aux = $this->Get($nome, $defult);
			if($aux == $valor)
				return 'checked="checked"';
			else
				return '';
		}
		################################################################################################################
		public static function &ListaRaiodepesquisa()
		{
			$lista = array(
				'5'=>'Até 5 Km',
				'15'=>'De 6-15 Km',
				'25'=>'De 15-25 Km',
				'50'=>'De 25-50 Km',
				'100'=>'De 50-100 Km',
				'150'=>'Até 100 Km',
			);
			return $lista;
		}
		################################################################################################################
		public static function &ListaLinhadereporte()
		{
			$lista = array(
				"Reporte para o nível de especialista"=>"Reporte para o nível de especialista",
				"Reporte para o nível  de coordenação"=>"Reporte para o nível  de coordenação",
				"Reporte para o nível gerencial"=>"Reporte para o nível gerencial",
				"Reporte para o nível de diretoria, presidência"=>"Reporte para o nível de diretoria, presidência",
				"Reporte direto aos acionistas, conselho"=>"Reporte direto aos acionistas, conselho",
			);
			return $lista;
		}
		################################################################################################################
		public function CheckTempoContratacao($tipo = "", $defult = false)
		{
			if(empty($this->tempocontratacao))
			{
				if($defult)
					return 'ativo';
				else
					return '';
			}
			if($this->tempocontratacao == $tipo)
			{
				return 'ativo';
			}
			if($defult)
				return 'ativo';
			else
				return '';
		}
		################################################################################################################
		public function AtivoSelecionarEmpresas($tipo = "")
		{
			if(empty($this->selecionarempresas))
			{
				return '';
			}
			if($this->tempocontratacao == $tipo)
			{
				return 'ativo';
			}
			return '';
		}
		################################################################################################################
		public function CheckFase($posicao = 0)
		{
			if(empty($posicao))
				return "nao_iniciado";
			if(($posicao > 6)||($posicao < 1))
				return "nao_iniciado";

			$nome = "fase{$posicao}";
			$aux = $this->Get($nome, 'Não iniciado');
			if($aux == 'Não iniciado')
			{
				return "nao_iniciado";
			}
			elseif($aux == 'Concluído')
			{
				return 'concluido';
			}
			elseif($aux == 'Iniciado')
			{
				return 'iniciado';
			}
			else
				return 'nao_iniciado';
		}
		################################################################################################################
		public function InitFase($posicao = 0)
		{
			if(empty($posicao))
				return;
			if(($posicao > 6)||($posicao < 1))
				return;

			$nome = "fase{$posicao}";
			$aux = $this->Get($nome, 'Não iniciado');
			if($aux == 'Não iniciado')
			{
				$this->Atualizar($this->GetID(), array($nome=>'Iniciado'));
			}
		}
		################################################################################################################
		public function TemUmfaseConcluido()
		{
			for($i = 1; $i <= 6; $i++)
			{
				$nome = "fase{$i}";
				$aux = $this->Get($nome, 'Não iniciado');
				if($aux == 'Concluído')
				{
					return true;
				}
			}
			return false;
		}
		################################################################################################################
		public static function GetCodigoVaga($codigo = 0, $data = "")
		{
			$codigo = intval($codigo);
			if(!emptyData($data))
			{
				$ano = date("Y", TimeData($data));			
			}
			else
			{
				$ano = date("Y");		
			}
			if($codigo < 10)
				$codigovaga = $ano."0".$codigo."T";
			else
				$codigovaga = $ano.$codigo."T";
			return $codigovaga;
		}
		################################################################################################################
		public function LerCodigoVaga($codigo = 0, $data = "")
		{
			if(emptyData($data))
			{
				if(emptyData($this->cadastradoem))
				{
					$data = date("d/m/Y");
				}
				else
					$data = $this->cadastradoem;	
			}
			if(empty($codigo))
			{
				$codigo = $this->idvaga;
				if(empty($codigo))
				{
					$codigo = 0;			
				}
			}
			$codigo = intval($codigo);
			return self::GetCodigoVaga($codigo, $data);
		}
		################################################################################################################
		public function __destruct()
		{
			unset($this->dados, $this->Tabela, $this->PrimaryKey);
		}
	}
}
?>