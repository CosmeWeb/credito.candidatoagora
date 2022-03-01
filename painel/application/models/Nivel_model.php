<?php
/***********************************************************************
 * Module:  /models/Nivel_model.PHP
 * Author:  Host-up
 * Date:	03/04/2020 19:52:38
 * Purpose: Definição da Classe Nivel_model
 * Instancias: $this->load->model('Nivel_model', 'nivel');
 * Objeto: $nivel = $this->nivel->GetInstancia($dados);
 ***********************************************************************/
if (!class_exists('Nivel_model'))
{
	class Nivel_model extends MY_Model
	{
		################################################################################################################
		public function __construct( $dados = false)
		{
			try
			{
				$this->Tabela = "nivel";
				$this->PrimaryKey = "idnivel";
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
				return "SELECT * FROM nivel ";
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
				return "SELECT COUNT(*) AS CONT FROM nivel ";
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
				$filtro .= " AND nivel LIKE '%{$buscar}%'";
			}
			if(!empty($filtro))
			{
				$filtro  = substr($filtro, 4);
			}
			if($semOrder)
			{
				return $filtro;
			}
			$ordem = array('idnivel', 'nivel', 'ordem', 'idnivel');
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
			$obj = GetModelo("nivel");
			if(empty($obj))
				return $retorno;
			foreach ($lista as $key=>$linha)
			{
				$obj->SalvarListaNivel($linha);
			}
			return true;
		}
		################################################################################################################
		public function SalvarListaNivel($dados = false)
		{
			if(empty($dados))
				return;
			$nivel = self::GetDadosChave($dados, array('nivel','nível','Nivel','Nível','NIVEL','NÍVEL','niveis','níveis','Niveis','Níveis','NIVEIS','NÍVEIS'));
			if(empty($nivel))
				return;
			$aux = Escape($nivel);
			$ordem = self::GetDadosChave($dados, array('ordem','Ordem','ORDEM'));
			$filtro = "nivel = '{$aux}'";
			$obj = $this->FiltroObjeto($filtro);
			if(empty($obj))
			{
				$obj = $this->GetInstancia();
				$obj->nivel = $nivel;
				$obj->idnivel = 0;
				$obj->ordem = $ordem;
				$id = 0;
			}
			else
			{
				$id = $obj->idnivel;
				$obj->ordem = $ordem;
			}
			$obj->Ajustar(true);
			$idnivel = $obj->Salvar();
			if(empty($id))
				$obj->idnivel = $idnivel;
			return $obj->idnivel;
		}
		################################################################################################################
		public function ExportarNivel()
		{
			$filtro = $this->Filtro(true);
			$filtro .= " ORDER BY nivel ASC";
			$obj = GetModelo('nivel');
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
				$dados['mensagem'] = __("Verificação de nível foi finalizado.<br/>O download se iniciará em instantes");
				$dados['url'] = site_url("nivel/baixarnivel/{$file}");
				$dados['titulo'] = __("Exportação de nível");
			}
			else
			{
				$dados['sucesso'] = false;
				$dados['erro'] = __("Nenhum nível foi encontrado.");
			}
			return $dados;
		}
		################################################################################################################
		public function GetNomeFile()
		{
			$retorno = "exportacaonivel_".date("Y-m-d_H-i-s").".xls";
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
			$campos = array("ID"=>"idnivel","nível"=>"nivel","ordem"=>"ordem");
			return $campos;
		}
		################################################################################################################
		public function GetCaminho($file = "")
		{
			return $this->SetDominio($file);
		}
		################################################################################################################
		public function LerIdNivel($palavraschaves = false)
		{
			if(empty($palavraschaves))
			{
				return 0;
			}
			$palavraschaves = trim($palavraschaves," \n\t\r");
			$aux = Escape($palavraschaves);
			$sql = "SELECT idnivel FROM {$this->Tabela} WHERE nivel = '{$aux}' LIMIT 1";
			$id = $this->GetSqlCampo($sql,"idnivel", 0);
			if(empty($id))
			{
				$this->idnivel = 0;
				$this->nivel = $palavraschaves;
				$this->ordem = 0;
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
		public function LerListaNiveis()
		{
			$idcliente = Get("idcliente", 0);
			$idvaga = Get("idvaga", 0);
			$calcular = Get("calcular", 0);
			$posicao = Get("posicao", 0);
			$limite = Get("limite", 10);
			$total = Get("total", 0);

			$rows = false;
			$titulo = __("Erro");
			$mensagem = __("Nenhum nível foi encontrado.");
			
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
				$sql = "SELECT COUNT(DISTINCT N.idnivel) AS CONT FROM nivel N INNER JOIN candidatocargo CG ON(N.idnivel = CG.idnivel) INNER JOIN candidatovaga CV ON(CG.idcandidato = CV.idcandidato) INNER JOIN vaga V ON(CV.idvaga = V.idvaga) LEFT JOIN favorito F FORCE INDEX(idxcandidato) ON(CV.idcandidato = F.idcandidato AND F.idvaga = V.idvaga) WHERE {$filtro}";
				$total = $this->TotalRegistro(false, $sql);				
			}
			if(!empty($total))
			{
				if($limite < 0)
					$limite = $total;
				if(empty($calcular))
				{
					$filtro .= " ORDER BY N.nivel ASC LIMIT {$posicao}, {$limite}";
					$sql = "SELECT DISTINCT N.idnivel, N.nivel, '0' AS total FROM nivel N INNER JOIN candidatocargo CG ON(N.idnivel = CG.idnivel) INNER JOIN candidatovaga CV ON(CG.idcandidato = CV.idcandidato) INNER JOIN vaga V ON(CV.idvaga = V.idvaga) LEFT JOIN favorito F FORCE INDEX(idxcandidato) ON(CV.idcandidato = F.idcandidato AND F.idvaga = V.idvaga) WHERE {$filtro}";
				}
				else
				{
					$filtro .= " GROUP BY N.idnivel ORDER BY total DESC LIMIT {$posicao}, {$limite}";
					$sql = "SELECT N.idnivel, N.nivel, COUNT(DISTINCT CV.idcandidato) AS total FROM nivel N INNER JOIN candidatocargo CG ON(N.idnivel = CG.idnivel) INNER JOIN candidatovaga CV ON(CG.idcandidato = CV.idcandidato) INNER JOIN vaga V ON(CV.idvaga = V.idvaga) LEFT JOIN favorito F FORCE INDEX(idxcandidato) ON(CV.idcandidato = F.idcandidato AND F.idvaga = V.idvaga) WHERE {$filtro}";
				}
				$rows = $this->GetRows(false, $sql);
				if(!empty($rows))
				{
					$rows = array_map(array($this,'Map'), $rows);
					$titulo = __("Sucesso");
					$mensagem = __("Lista de nível foi encontrada com sucesso.");
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
			$row['idnivel'] = intval($row['idnivel']);
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