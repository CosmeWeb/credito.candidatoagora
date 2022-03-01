<?php
/***********************************************************************
 * Module:  /models/Nacionalidade_model.PHP
 * Author:  Host-up
 * Date:	06/04/2020 16:18:08
 * Purpose: Definição da Classe Nacionalidade_model
 * Instancias: $this->load->model('Nacionalidade_model', 'nacionalidade');
 * Objeto: $nacionalidade = $this->nacionalidade->GetInstancia($dados);
 ***********************************************************************/
if (!class_exists('Nacionalidade_model'))
{
	class Nacionalidade_model extends MY_Model
	{
		################################################################################################################
		public function __construct( $dados = false)
		{
			try
			{
				$this->Tabela = "nacionalidade";
				$this->PrimaryKey = "idnacionalidade";
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
				$this->nacionalidade = ucwords(strtolower($this->nacionalidade));
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
				return "SELECT * FROM nacionalidade ";
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
				return "SELECT COUNT(*) AS CONT FROM nacionalidade ";
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
				$filtro .= " AND nacionalidade LIKE '%{$buscar}%'";
			}
			if(!empty($filtro))
			{
				$filtro  = substr($filtro, 4);
			}
			if($semOrder)
			{
				return $filtro;
			}
			$ordem = array('idnacionalidade', 'nacionalidade', 'idnacionalidade');
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
			$obj = GetModelo("nacionalidade");
			if(empty($obj))
				return $retorno;
			foreach ($lista as $key=>$linha)
			{
				$obj->SalvarListaNacionalidade($linha);
			}
			return true;
		}
		################################################################################################################
		public function SalvarListaNacionalidade($dados = false)
		{
			if(empty($dados))
				return;
			$nacionalidade = self::GetDadosChave($dados, array('nacionalidade','Nacionalidade','NACIONALIDADE'));
			if(empty($nacionalidade))
				return;
			$aux = Escape($nacionalidade);
			$filtro = "nacionalidade = '{$aux}'";
			$obj = $this->FiltroObjeto($filtro);
			if(empty($obj))
			{
				$obj = $this->GetInstancia();
				$obj->nacionalidade = $nacionalidade;
				$obj->Ajustar(true);
				$obj->Salvar();
			}
			return;
		}
		################################################################################################################
		public function ExportarNacionalidade()
		{
			$filtro = $this->Filtro(true);
			$filtro .= " ORDER BY nacionalidade ASC";
			$obj = GetModelo('nacionalidade');
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
				$dados['mensagem'] = __("Verificação de nacionalidade foi finalizado.<br/>O download se iniciará em instantes");
				$dados['url'] = site_url("nacionalidade/baixarnacionalidade/{$file}");
				$dados['titulo'] = __("Exportação de nacionalidade");
			}
			else
			{
				$dados['sucesso'] = false;
				$dados['erro'] = __("Nenhuma nacionalidade foi encontrado.");
			}
			return $dados;
		}
		################################################################################################################
		public function GetNomeFile()
		{
			$retorno = "exportacaonacionalidade_".date("Y-m-d_H-i-s").".xls";
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
			$campos = array("ID"=>"idnacionalidade","nacionalidade"=>"nacionalidade");
			return $campos;
		}
		################################################################################################################
		public function GetCaminho($file = "")
		{
			return $this->SetDominio($file);
		}
		################################################################################################################
		public function LerIdNacionalidade($palavraschaves = false)
		{
			if(empty($palavraschaves))
			{
				return 0;
			}
			$aux = Escape($palavraschaves);
			$sql = "SELECT idnacionalidade FROM {$this->Tabela} WHERE nacionalidade = '{$aux}' LIMIT 1";
			$id = $this->GetSqlCampo($sql,"idnacionalidade", 0);
			if(empty($id))
			{
				$this->idnacionalidade = 0;
				$this->nacionalidade = $palavraschaves;
				$id = $this->Salvar();
				if(empty($id))
				{
					return 0;
				}
			}
			return $id;
		}
		################################################################################################################
		public function lerFiltroNacionalidade()
		{
			$idcliente = Get("idcliente", 0);
			$idvaga = Get("idvaga", 0);
			$calcular = Get("calcular", 0);
			$posicao = Get("posicao", 0);
			$limite = Get("limite", 10);
			$total = Get("total", 0);

			$rows = false;
			$titulo = __("Erro");
			$mensagem = __("Nenhum nacionalidade foi encontrado.");
			
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
			$filtro .= " AND CG.historico = 'Cargo 1'";
			if(empty($total))
			{
				$sql = "SELECT COUNT(DISTINCT N.idnacionalidade) AS CONT FROM nacionalidade N INNER JOIN candidatocargo CG ON(N.idnacionalidade = CG.idnacionalidade) INNER JOIN candidatovaga CV ON(CG.idcandidato = CV.idcandidato) INNER JOIN vaga V ON(CV.idvaga = V.idvaga) LEFT JOIN favorito F FORCE INDEX(idxcandidato) ON(CV.idcandidato = F.idcandidato AND F.idvaga = V.idvaga) WHERE {$filtro}";
				$total = $this->TotalRegistro(false, $sql);				
			}
			if(!empty($total))
			{
				if($limite < 0)
					$limite = $total;
				if(empty($calcular))
				{
					$filtro .= " ORDER BY N.nacionalidade DESC LIMIT {$posicao}, {$limite}";
					$sql = "SELECT DISTINCT N.idnacionalidade, N.nacionalidade, '0' AS 'total' FROM nacionalidade N INNER JOIN candidatocargo CG ON(N.idnacionalidade = CG.idnacionalidade) INNER JOIN candidatovaga CV ON(CG.idcandidato = CV.idcandidato) INNER JOIN vaga V ON(CV.idvaga = V.idvaga) LEFT JOIN favorito F FORCE INDEX(idxcandidato) ON(CV.idcandidato = F.idcandidato AND F.idvaga = V.idvaga) WHERE {$filtro}";
				}
				else
				{
					$filtro .= " GROUP BY N.idnacionalidade, N.nacionalidade ORDER BY total DESC LIMIT {$posicao}, {$limite}";
					$sql = "SELECT N.idnacionalidade, N.nacionalidade, COUNT(DISTINCT CV.idcandidato) AS 'total' FROM nacionalidade N INNER JOIN candidatocargo CG ON(N.idnacionalidade = CG.idnacionalidade) INNER JOIN candidatovaga CV ON(CG.idcandidato = CV.idcandidato) INNER JOIN vaga V ON(CV.idvaga = V.idvaga) LEFT JOIN favorito F FORCE INDEX(idxcandidato) ON(CV.idcandidato = F.idcandidato AND F.idvaga = V.idvaga) WHERE {$filtro}";
				}
				$rows = $this->GetRows(false, $sql);
				if(!empty($rows))
				{
					$rows = array_map(array($this,'Map'), $rows);
					$titulo = __("Sucesso");
					$mensagem = __("Lista de tamanho de empresa foi encontrada com sucesso.");
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
			$row['idnacionalidade'] = intval($row['idnacionalidade']);
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