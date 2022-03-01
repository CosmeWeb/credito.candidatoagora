<?php
/***********************************************************************
 * Module:  /models/Subarea_model.PHP
 * Author:  Host-up
 * Date:	18/05/2020 20:30:42
 * Purpose: Definição da Classe Subarea_model
 * Instancias: $this->load->model('Subarea_model', 'subarea');
 * Objeto: $subarea = $this->subarea->GetInstancia($dados);
 ***********************************************************************/
if (!class_exists('Subarea_model'))
{
	class Subarea_model extends MY_Model
	{
		private static $_area = null;
		################################################################################################################
		public function __construct( $dados = false)
		{
			try
			{
				$this->Tabela = "subarea";
				$this->PrimaryKey = "idsubarea";
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
		public function GerarOpcoesArea($value = "0", $texto = "", $default = "0")
		{
			if(empty($texto))
				$texto = __("-- Selecione --");
			$primeiro = array("valor"=>$default,"texto"=>$texto);
			$sql = "SELECT idarea AS 'id', area AS 'texto' FROM area ORDER BY texto ASC";
			return $this->GeraOpcoesSql($value, $sql, "id", "texto", $primeiro);
		}
		################################################################################################################
		public function GetSqlLista()
		{
			$retorno = "";
			try
			{
				return "SELECT S.*, A.area  FROM subarea S LEFT JOIN area A ON(S.idarea = A.idarea)";
			}
			catch( Exception $e )
			{
				throw new Exception( $e );
				return $retorno;
			}
		}
		################################################################################################################
		public function GetSqlTotalLista()
		{
			$retorno = "";
			try
			{
				return "SELECT COUNT(DISTINCT S.idarea) AS CONT FROM subarea S LEFT JOIN area A ON(S.idarea = A.idarea)";
			}
			catch( Exception $e )
			{
				throw new Exception( $e );
				return $retorno;
			}
		}
		#######################################################################################################
		public function Filtro($semOrder = false)
		{
			$filtro = "";
			$buscar = GetFiltro("buscar");
			if(!empty($buscar))
			{
				$filtro .= " AND S.subarea LIKE '%{$buscar}%'";
			}
			$idarea = GetFiltro("idarea");
			if(!empty($idarea))
			{
				$filtro .= " AND S.idarea = '{$idarea}'";
			}
			
			if(!empty($filtro))
			{
				$filtro  = substr($filtro, 4);
			}
			if($semOrder)
			{
				return $filtro;
			}
			$ordem = array('S.idsubarea', 'S.subarea', 'A.area', 'S.idsubarea');
			$start = Get("start", 0);
			$length = Get("length", 10);
			$order = Get("order", 0,0);
			if(!empty($order['column']))
				$coluna = $order['column'];
			else
				$coluna = 0;
			if(!empty($order['dir']))
				$dir = $order['dir'];
			else
				$dir = 'asc';
			if(!empty($ordem[$coluna]))
			{
				$order = $ordem[$coluna];
				$filtro .= " ORDER BY {$order} {$dir}";
			}
			if($length >= 0)
			{
				$filtro .= " LIMIT {$start}, {$length}";
			}
			return $filtro;
		}
		################################################################################################################
		public function Importar($posicao = 0, $limite = 0, $file = "")
		{
			$retorno = false;
			
			if(empty($file))
				return $retorno;
			
			$lista = $this->LerRows($posicao, $limite, $file);
			if(empty($lista))
				return $retorno;
			$obj = GetModelo("subarea");
			if(empty($obj))
				return $retorno;
			foreach ($lista as $key=>$linha)
			{
				$obj->SalvarListaSubarea($linha);
			}
			return true;
		}
		################################################################################################################
		public function SalvarListaSubarea($dados = false)
		{
			if(empty($dados))
				return;
			$subarea = self::GetDadosChave($dados, array('subarea','subárea','Subarea','Subárea','sub area','sub área','Sub area','Sub área','SUBAREA','SUBÁREA'));
			if(empty($subarea))
				return;
			$filtro = "subarea = '{$subarea}'";
			$obj = $this->FiltroObjeto($filtro);
			if(empty($obj))
			{
				$obj = $this->GetInstancia();
				$obj->subarea = $subarea;
			}
			$objArea = self::NewArea();
			$area = self::GetDadosChave($dados, array('area','área','Area','Área','AREA','ÁREA'));
			$obj->idarea = $objArea->LerIdArea($area);
			$obj->Ajustar(true);
			$obj->Salvar();
			return;
		}
		################################################################################################################
		public function ExportarSubarea()
		{
			$filtro = $this->Filtro(true);
			$filtro .= " ORDER BY subarea ASC";
			$obj = GetModelo('subarea');
			$sql = $this->GetSqlLista();
			$objs = $obj->FiltroObjetos($filtro, $sql);
			if($objs)
			{
				$file = $obj->GetNomeFile();
				$data = array(
					"file"=> $file,
					"lista"=>$objs,
					"html"=>true,
					"campos"=>$obj->GetNomesCampos(),
					"download"=>false,
					"pasta"=>$obj->GetCaminho()
				);
				Excel($data);
				$dados['sucesso'] = true;
				$dados['mensagem'] = __("Verificação de subárea foi finalizada.<br/>O download se iniciará em instantes");
				$dados['url'] = site_url("subarea/baixarsubarea/{$file}");
				$dados['titulo'] = __("Exportação de subárea");
			}
			else
			{
				$dados['sucesso'] = false;
				$dados['erro'] = __("Nenhum subárea foi encontrada.");
			}
			return $dados;
		}
		################################################################################################################
		public function GetNomeFile()
		{
			$retorno = "exportacaosubarea_".date("Y-m-d_H-i-s").".xls";
			try
			{
				return $retorno;
			}
			catch( Exception $e )
			{
				throw new Exception( $e );
				return $retorno;
			}
		}
		################################################################################################################
		public function GetNomesCampos()
		{
			$campos = array("ID"=>"idsubarea","subarea"=>"subarea","area"=>"area");
			return $campos;
		}
		################################################################################################################
		public function GetCaminho($file = "")
		{
			return $this->SetDominio($file);
		}
		################################################################################################################
		public function ListaSubareas()
		{
			$idarea = Get("idarea", 0);
			if(!empty($idarea))
			{
				$filtro = " WHERE idarea = '{$idarea}' ";
			}
			else
			{
				$filtro = "";
			}	
			$filtro .= " ORDER BY texto ASC";
			$sql = "SELECT DISTINCT idsubarea AS 'id', subarea AS 'texto' FROM subarea {$filtro}";
			$rows = $this->GetRows(false, $sql);
			if(!empty($rows))
			{
				$dados['sucesso'] = true;
				$dados['lista'] = $rows;
				$dados['mensagem'] = __("Lista de subárea foi encontrada com sucesso.");
				$dados['titulo'] = __("Sucesso");
			}
			else
			{
				$dados['sucesso'] = false;
				$dados['erro'] = __("Nenhuma subárea foi encontrada.");
				$dados['titulo'] = __("Erro");
			}
			return $dados;
		}
		################################################################################################################
		public function LerIdSubarea($palavraschaves = false, $idarea = 0)
		{
			if(empty($palavraschaves))
			{
				return 0;
			}
			$palavraschaves = trim($palavraschaves," \n\t\r");
			$aux = Escape($palavraschaves);
			$sql = "SELECT idsubarea FROM {$this->Tabela} WHERE subarea = '{$aux}' AND idarea = '{$idarea}' LIMIT 1";
			$id = $this->GetSqlCampo($sql,"idsubarea", 0);
			if(empty($id))
			{
				$sql = "SELECT idsubarea FROM {$this->Tabela} WHERE subarea = '{$aux}' LIMIT 1";
				$id = $this->GetSqlCampo($sql,"idsubarea", 0);
				if(empty($id))
				{
					$this->idsubarea = 0;
					$this->subarea = $palavraschaves;
					$this->idarea = $idarea;
					$this->Ajustar(true);
					$id = $this->Salvar();
					if(empty($id))
					{
						return 0;
					}
				}
			}
			return $id;
		}
		################################################################################################################
		public function LerListaSubareas()
		{
			$idcliente = Get("idcliente", 0);
			$idvaga = Get("idvaga", 0);
			$idarea = Get("idarea", 0);
			$posicao = Get("posicao", 0);
			$limite = Get("limite", 10);
			$total = Get("total", 0);

			$rows = false;
			$titulo = __("Erro");
			$mensagem = __("Nenhuma subárea foi encontrada.");
			
			$filtro = "";
			if(!empty($idcliente))
			{
				if(!E_Cliente($idcliente))
				{
					$dados['sucesso'] = false;
					$dados['erro'] = __("ID do cliente não foi enviado.");
					return $dados;
				}
				$filtro .= " 1 ";
				//$filtro .= " V.idcliente = '{$idcliente}' ";
			}
			else
			{
				$dados['sucesso'] = false;
				$dados['erro'] = __("ID do cliente não foi enviado.");
				return $dados;
			}
			if(!empty($idvaga))
			{
				if(!is_array($idvaga))
					$idvaga = array($idvaga);
				$filtro .= " AND CV.idvaga ".GerarIN($idvaga);
			}
			if(!empty($idarea))
			{
				if(!is_array($idarea))
					$idarea = array($idarea);
				$filtro .= " AND S.idarea ".GerarIN($idarea);
			}
			if(empty($total))
			{
				$sql = "SELECT COUNT(DISTINCT S.idsubarea) AS CONT FROM subarea S INNER JOIN candidatocargo CG ON(S.idsubarea = CG.idsubarea) INNER JOIN candidatovaga CV ON(CG.idcandidato = CV.idcandidato) INNER JOIN vaga V ON(CV.idvaga = V.idvaga) WHERE {$filtro}";
				$total = $this->TotalRegistro(false, $sql);
			}
			if(!empty($total))
			{
				if($limite < 0)
					$limite = $total;
				$filtro .= " GROUP BY S.idsubarea ORDER BY total DESC LIMIT {$posicao}, {$limite}";
				$sql = "SELECT S.idsubarea, S.subarea, S.idarea, COUNT(DISTINCT CV.idcandidato) AS total FROM subarea S INNER JOIN candidatocargo CG ON(S.idsubarea = CG.idsubarea) INNER JOIN candidatovaga CV ON(CG.idcandidato = CV.idcandidato) INNER JOIN vaga V ON(CV.idvaga = V.idvaga) WHERE {$filtro}";
				$rows = $this->GetRows(false, $sql);
				if(!empty($rows))
				{
					$rows = array_map(array($this,'Map'), $rows);
					$titulo = __("Sucesso");
					$mensagem = __("Lista de subárea foi encontrada com sucesso.");
				}
			}
			$novaposicao = $posicao + $limite;
			if($novaposicao >= $total)
				$finalizado = true;
			else
				$finalizado = false;
			$dados['sucesso'] = true;
			$dados['lista'] = $rows;
			$dados['mensagem'] = $mensagem;
			$dados['titulo'] = $titulo;
			$dados['idcliente'] = intval($idcliente);
			if(empty($idvaga))
				$dados['idvaga'] = null;
			else
				$dados['idvaga'] = $idvaga;
			if(empty($idarea))
				$dados['idarea'] = null;
			else
				$dados['idarea'] = $idarea;
			$dados['posicao'] = $novaposicao;
			$dados['limite'] = intval($limite);
			$dados['total'] = intval($total);
			$dados['finalizado'] = $finalizado;
			return $dados;
		}
		################################################################################################################
		public static function Map($row = false)
		{
			$row['idsubarea'] = intval($row['idsubarea']);
			$row['total'] = intval($row['total']);
			return $row;
		}
		################################################################################################################
		public function __destruct()
		{
			unset($this->dados, $this->Tabela, $this->PrimaryKey);
		}
	}
}
?>