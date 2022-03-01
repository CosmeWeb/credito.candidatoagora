<?php
/***********************************************************************
 * Module:  /models/Estado_model.PHP
 * Author:  Host-up
 * Date:	01/04/2020 16:24:46
 * Purpose: Definição da Classe Estado_model
 * Instancias: $this->load->model('Estado_model', 'estado');
 * Objeto: $estado = $this->estado->GetInstancia($dados);
 ***********************************************************************/
if (!class_exists('Estado_model'))
{
	class Estado_model extends MY_Model
	{
		public static $Estados = array('AC' => 'Acre', 'AL' => 'Alagoas', 'AP' => 'Amapá', 'AM' => 'Amazonas', 'BA' => 'Bahia', 'CE' => 'Ceará', 'DF' => 'Distrito Federal', 'ES' => 'Espírito Santo', 'GO' => 'Goiás', 'MA' => 'Maranhão', 'MT' => 'Mato Grosso', 'MS' => 'Mato Grosso do Sul', 'MG' => 'Minas Gerais', 'PA' => 'Pará', 'PB' => 'Paraíba', 'PR' => 'Paraná', 'PE' => 'Pernambuco', 'PI' => 'Piauí', 'RJ' => 'Rio de Janeiro', 'RN' => 'Rio Grande do Norte', 'RS' => 'Rio Grande do Sul', 'RO' => 'Rondônia', 'RR' => 'Roraima', 'SC' => 'Santa Catarina', 'SP' => 'São Paulo', 'SE' => 'Sergipe', 'TO' => 'Tocantins');
		private static $_pais = null;
		################################################################################################################
		public function __construct( $dados = false)
		{
			try
			{
				$this->Tabela = "estado";
				$this->PrimaryKey = "idestado";
				parent::__construct($dados);
			}
			catch( Exception $e )
			{
				throw new Exception( $e );
			}
		}
		################################################################################################################
		public static function &NewPais() {
			if (self::$_pais == null)
				self::$_pais = GetModelo("pais");
			return self::$_pais;
		}
		################################################################################################################
		public function Ajustar($salvar = false)
		{
			if($salvar)
			{
				$this->estado = ucwords(strtolower($this->estado));
				$this->uf = strtoupper($this->uf);
			}
			else
			{

			}
		}
		################################################################################################################
		public function GerarOpcoesPais($value = "", $texto = "", $default = "")
		{
			if(empty($texto))
				$texto = __(" -- Selecione --");
			$primeiro = array("valor"=>$default,"texto"=>$texto);
			$sql = "SELECT idpais AS id, pais AS texto FROM pais ORDER BY texto ASC";
			return $this->GeraOpcoesSql($value, $sql, "id", "texto", $primeiro);
		}
		################################################################################################################
		public function GetSqlLista()
		{
			$retorno = "";
			try
			{
				return "SELECT E.*, P.pais, P.sigla FROM estado E LEFT JOIN pais P ON(E.idpais = P.idpais)";
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
				return "SELECT COUNT(DISTINCT E.idestado) AS CONT FROM estado E LEFT JOIN pais P ON(E.idpais = P.idpais)";
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
				$filtro .= " AND (E.estado LIKE '%{$buscar}%' OR E.uf LIKE '%{$buscar}%')";
			}
			$idpais = GetFiltro("idpais");
			if(!empty($idpais))
			{
				$filtro .= " AND E.idpais = '{$idpais}'";
			}
			if(!empty($filtro))
			{
				$filtro  = substr($filtro, 4);
			}
			if($semOrder)
			{
				return $filtro;
			}
			$ordem = array('E.idestado', 'E.estado', 'E.uf', 'P.pais', 'E.idestado');
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
			$obj = GetModelo("estado");
			if(empty($obj))
				return $retorno;
			foreach ($lista as $key=>$linha)
			{
				$obj->SalvarListaEstado($linha);
			}
			return true;
		}
		################################################################################################################
		public function SalvarListaEstado($dados = false)
		{
			if(empty($dados))
				return;
			$estado = self::GetDadosChave($dados, array('estado','Estado','ESTADO'));
			if(empty($estado))
				return;
			$aux = Escape($estado);
			$nomepais = self::GetDadosChave($dados, array('pais','país','Pais','País','PAIS','PAÍS'));
			$sigla = self::GetDadosChave($dados, array('sigla','siglas','Sigla','Siglas','SIGLA','SIGLAS'));
			$pais = self::NewPais();
			$idpais = $pais->LerIdPais($nomepais, $sigla);

			$filtro = "estado = '{$aux}'";
			if(!empty($idpais))
				$filtro = " AND idpais = '{$idpais}'";
			$obj = $this->FiltroObjeto($filtro);
			if(empty($obj))
			{
				$obj = $this->GetInstancia();
				$obj->estado = $estado;
				$obj->idpais = $idpais;
			}
			$uf = self::GetDadosChave($dados, array('uf','uF','Uf','UF'));
			if(!empty($uf))
				$obj->uf = $uf;
			
			$obj->Ajustar(true);
			$obj->Salvar();
			return;
		}
		################################################################################################################
		public function ExportarEstado()
		{
			$filtro = $this->Filtro(true);
			$filtro .= " ORDER BY E.estado ASC";
			$obj = GetModelo('estado');
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
				$dados['mensagem'] = __("Verificação de estado foi finalizado.<br/>O download se iniciará em instantes");
				$dados['url'] = site_url("estado/baixarestado/{$file}");
				$dados['titulo'] = __("Exportação de estado");
			}
			else
			{
				$dados['sucesso'] = false;
				$dados['erro'] = __("Nenhum estado foi encontrado.");
			}
			return $dados;
		}
		################################################################################################################
		public function GetNomeFile()
		{
			$retorno = "exportacao_estado_".date("Y-m-d_H-i-s").".xls";
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
			$campos = array("ID"=>"idestado","estado"=>"estado","uf"=>"uf","pais"=>"pais","sigla"=>"sigla");
			return $campos;
		}
		################################################################################################################
		public function GetCaminho($file = "")
		{
			return $this->SetDominio($file);
		}
		################################################################################################################
		public function &BuscarEstados()
		{
			$retorno = false;
			try
			{
				$filtro = "";
				$busca = Get('search');
				if(!empty($busca))
					$filtro .= " AND (estado LIKE '%{$busca}%' OR uf LIKE '%{$busca}%')";
				$idpais = Get('idpais');
				if(!empty($idpais))
				{
					$filtro .= " AND (idpais = '{$idpais}')";	
				}
				if(!empty($filtro))
				{
					$filtro  = "WHERE ".substr($filtro, 4);
				}
				
				$sql = "SELECT DISTINCT idestado AS id, estado AS text FROM estado {$filtro}";
				return $this->GetRows(false, $sql);
			}
			catch( Exception $e )
			{
				throw new Exception( $e );
				return $retorno;
			}
		}
		################################################################################################################
		public function LerIdEstado($palavraschaves = false, $uf = "", $idpais)
		{
			if(empty($palavraschaves))
			{
				return 0;
			}
			$palavraschaves = trim($palavraschaves," \n\t\r");
			$aux = Escape($palavraschaves);
			$sql = "SELECT idestado AS id FROM {$this->Tabela} WHERE estado = '{$aux}' AND idpais = '{$idpais}' LIMIT 1";
			$id = $this->GetSqlCampo($sql,"id", 0);
			if(empty($id))
			{
				$this->idestado = 0;
				$this->idpais = $idpais;
				$this->estado = $palavraschaves;
				if(empty($uf))
				{
					$uf = self::GetUF($palavraschaves);
				}
				$this->uf = $uf;
				$id = $this->Salvar();
				if(empty($id))
				{
					return 0;
				}
			}
			return $id;
		}
		################################################################################################################
		public static function GetUF($estado = "")
		{
			$retorno = "";
			try
			{
				if(empty($estado))
					return $retorno;
				$lista = self::$Estados;
				$estado = AcertaNomeArquivo($estado);
				foreach ($lista as $uf=>$nomeestado)
				{
					$nomeestado = AcertaNomeArquivo($nomeestado);
					if (strcasecmp($estado, $nomeestado) == 0)
					{
						return $uf;
					}
				}
				return $retorno;
			}
			catch( Exception $e )
			{
				throw new Exception( $e );
				return $retorno;
			}
		}
		################################################################################################################
		public function LerListaEstados()
		{
			$idcliente = Get("idcliente", 0);
			$idvaga = Get("idvaga", 0);
			$posicao = Get("posicao", 0);
			$limite = Get("limite", 10);
			$total = Get("total", 0);

			$rows = false;
			$titulo = __("Erro");
			$mensagem = __("Nenhum estado foi encontrado.");
			
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
				$sql = "SELECT COUNT(DISTINCT E.idestado) AS CONT FROM estado E LEFT JOIN pais P ON(E.idpais = P.idpais) INNER JOIN candidato CO ON(E.idestado = CO.idestado) INNER JOIN candidatovaga CV ON(CO.idcandidato = CV.idcandidato) INNER JOIN vaga V ON(CV.idvaga = V.idvaga) LEFT JOIN favorito F FORCE INDEX(idxcandidato) ON(CV.idcandidato = F.idcandidato AND F.idvaga = V.idvaga) WHERE {$filtro}";
				$total = $this->TotalRegistro(false, $sql);
				
			}
			if(!empty($total))
			{
				if($limite < 0)
					$limite = $total;
				$filtro .= " GROUP BY E.idestado, E.estado, E.uf, P.pais, P.sigla ORDER BY total DESC, E.estado ASC LIMIT {$posicao}, {$limite}";
				$sql = "SELECT E.idestado, E.estado, E.uf, P.pais, P.sigla, COUNT(DISTINCT CV.idcandidato) AS total FROM estado E LEFT JOIN pais P ON(E.idpais = P.idpais) INNER JOIN candidato CO ON(E.idestado = CO.idestado) INNER JOIN candidatovaga CV ON(CO.idcandidato = CV.idcandidato) INNER JOIN vaga V ON(CV.idvaga = V.idvaga) LEFT JOIN favorito F FORCE INDEX(idxcandidato) ON(CV.idcandidato = F.idcandidato AND F.idvaga = V.idvaga) WHERE {$filtro}";
				$rows = $this->GetRows(false, $sql);
				if(!empty($rows))
				{
					$rows = array_map(array($this,'Map'), $rows);
					$titulo = __("Sucesso");
					$mensagem = __("Lista de estado foi encontrado com sucesso.");
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
			$row['idestado'] = intval($row['idestado']);
			$row['idpais'] = intval($row['idpais']);
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