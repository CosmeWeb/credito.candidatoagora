<?php
/***********************************************************************
 * Module:  /models/Area_model.PHP
 * Author:  Host-up
 * Date:	03/04/2020 18:06:28
 * Purpose: Definição da Classe Area_model
 * Instancias: $this->load->model('Area_model', 'area');
 * Objeto: $area = $this->area->GetInstancia($dados);
 ***********************************************************************/
if (!class_exists('Area_model'))
{
	class Area_model extends MY_Model
	{
		################################################################################################################
		public function __construct( $dados = false)
		{
			try
			{
				$this->Tabela = "area";
				$this->PrimaryKey = "idarea";
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
		public function GetSqlLista()
		{
			$retorno = "";
			try
			{
				return "SELECT * FROM area ";
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
				return "SELECT COUNT(*) AS CONT FROM area ";
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
				$filtro .= " AND buscar LIKE '%{$buscar}%'";
			}
			
			$idarea = GetFiltro("idarea");
			if(!empty($idarea))
			{
				$filtro .= " AND idarea = '{$idarea}'";
			}
			$area = GetFiltro("area");
			if(!empty($area))
			{
				$filtro .= " AND area = '{$area}'";
			}
			if(!empty($filtro))
			{
				$filtro  = substr($filtro, 4);
			}
			if($semOrder)
			{
				return $filtro;
			}
			$ordem = array('idarea', 'area', 'idarea');
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
			$obj = GetModelo("area");
			if(empty($obj))
				return $retorno;
			foreach ($lista as $key=>$linha)
			{
				$obj->SalvarListaArea($linha);
			}
			return true;
		}
		################################################################################################################
		public function SalvarListaArea($dados = false)
		{
			if(empty($dados))
				return;
			$area = self::GetDadosChave($dados, array('area','área','Area','Área','AREA','ÁREA'));
			if(empty($area))
				return;
			$aux = Escape($area);	
			$filtro = "area = '{$aux}'";
			$obj = $this->FiltroObjeto($filtro);
			if(empty($obj))
			{
				$obj = $this->GetInstancia();
				$obj->area = $area;
				$obj->idarea = 0;
				$id = 0;
			}
			else
			{
				$id = $obj->idarea;
			}
			$obj->Ajustar(true);
			$idarea = $obj->Salvar();
			if(empty($id))
				$obj->idarea = $idarea;
			return $obj->idarea;
		}
		################################################################################################################
		public function ExportarArea()
		{
			$filtro = $this->Filtro(true);
			$filtro .= " ORDER BY area ASC";
			$obj = GetModelo('area');
			$sql = $this->GetSqlLista();
			$objs = $obj->FiltroObjetos($filtro, $sql);
			if($objs)
			{
				$file = $obj->GetNomeFile();
				$data = array(
					"file"=> $file,
					"lista"=>$objs,
					"html"=>false,
					"campos"=>$obj->GetNomesCampos(),
					"download"=>false,
					"pasta"=>$obj->GetCaminho()
				);
				Excel($data);
				$dados['sucesso'] = true;
				$dados['mensagem'] = __("Verificação de area foi finalizado.<br/>O download se iniciará em instantes");
				$dados['url'] = site_url("area/baixararea/{$file}");
				$dados['titulo'] = __("Exportação de area");
			}
			else
			{
				$dados['sucesso'] = false;
				$dados['erro'] = __("Nenhum area foi encontrado.");
			}
			return $dados;
		}
		################################################################################################################
		public function GetNomeFile()
		{
			$retorno = "exportacaoarea_".date("Y-m-d_H-i-s").".xls";
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
			$campos = array("ID"=>"idarea","area"=>"area");
			return $campos;
		}
		################################################################################################################
		public function GetCaminho($file = "")
		{
			return $this->SetDominio($file);
		}
		################################################################################################################
		public function LerIdArea($palavraschaves = false)
		{
			if(empty($palavraschaves))
			{
				return 0;
			}
			$palavraschaves = trim($palavraschaves," \n\t\r");
			$aux = Escape($palavraschaves);
			$sql = "SELECT idarea FROM {$this->Tabela} WHERE area = '{$aux}' LIMIT 1";
			$id = $this->GetSqlCampo($sql,"idarea", 0);
			if(empty($id))
			{
				$this->idarea = 0;
				$this->area = $palavraschaves;
				$this->Ajustar(true);
				$id = $this->Salvar();
				if(empty($id))
				{
					return 0;
				}
			}
			return $id;
		}
		################################################################################################################
		public function LerListaAreas()
		{
			$idcliente = Get("idcliente", 0);
			$idvaga = Get("idvaga", 0);
			$posicao = Get("posicao", 0);
			$limite = Get("limite", 10);
			$total = Get("total", 0);

			$rows = false;
			$titulo = __("Erro");
			$mensagem = __("Nenhuma área foi encontrado.");
			
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
				$filtro .= " AND (F.idfavorito IS NULL OR F.tipo = 'Favorito') AND CV.idvaga ".GerarIN($idvaga);
			}
			if(empty($total))
			{
				$sql = "SELECT COUNT(DISTINCT A.idarea) AS CONT FROM area A INNER JOIN candidatocargo CG ON(A.idarea = CG.idarea) INNER JOIN candidatovaga CV ON(CG.idcandidato = CV.idcandidato) INNER JOIN vaga V ON(CV.idvaga = V.idvaga) LEFT JOIN favorito F FORCE INDEX(idxcandidato) ON(CV.idcandidato = F.idcandidato AND F.idvaga = V.idvaga) WHERE {$filtro}";
				$total = $this->TotalRegistro(false, $sql);
			}
			if(!empty($total))
			{
				if($limite < 0)
					$limite = $total;
				$filtro .= " GROUP BY A.idarea ORDER BY total DESC LIMIT {$posicao}, {$limite}";
				$sql = "SELECT A.idarea, A.area, COUNT(DISTINCT CV.idcandidato) AS total FROM area A INNER JOIN candidatocargo CG ON(A.idarea = CG.idarea) INNER JOIN candidatovaga CV ON(CG.idcandidato = CV.idcandidato) INNER JOIN vaga V ON(CV.idvaga = V.idvaga) LEFT JOIN favorito F FORCE INDEX(idxcandidato) ON(CV.idcandidato = F.idcandidato AND F.idvaga = V.idvaga) WHERE {$filtro}";
				$rows = $this->GetRows(false, $sql);
				if(!empty($rows))
				{
					$rows = array_map(array($this,'Map'), $rows);
					$titulo = __("Sucesso");
					$mensagem = __("Lista de área foi encontrada com sucesso.");
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
			$dados['posicao'] = $novaposicao;
			$dados['limite'] = intval($limite);
			$dados['total'] = intval($total);
			$dados['finalizado'] = $finalizado;
			return $dados;
		}
		################################################################################################################
		public static function Map($row = false)
		{
			$row['idarea'] = intval($row['idarea']);
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