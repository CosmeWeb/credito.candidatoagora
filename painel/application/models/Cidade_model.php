<?php
/***********************************************************************
 * Module:  /models/Cidade_model.PHP
 * Author:  Host-up
 * Date:	01/04/2020 21:31:19
 * Purpose: Definição da Classe Cidade_model
 * Instancias: $this->load->model('Cidade_model', 'cidade');
 * Objeto: $cidade = $this->cidade->GetInstancia($dados);
 ***********************************************************************/
if (!class_exists('Cidade_model'))
{
	class Cidade_model extends MY_Model
	{
		private static $_pais = null;
		private static $_estado = null;
		################################################################################################################
		public function __construct( $dados = false)
		{
			try
			{
				$this->Tabela = "cidade";
				$this->PrimaryKey = "idcidade";
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
		public static function &NewEstado() {
			if (self::$_estado == null)
				self::$_estado = GetModelo("estado");
			return self::$_estado;
		}
		################################################################################################################
		public function Ajustar($salvar = false)
		{
			if($salvar)
			{
				$this->cidade = ucwords(strtolower($this->cidade));
			}
			else
			{

			}
		}
		################################################################################################################
		public function GerarOpcoesPais($value = "0", $texto = "", $default = "0")
		{
			$obj = GetModelo("estado");
			return $obj->GerarOpcoesPais($value, $texto , $default);
		}
		################################################################################################################
		public function GerarOpcoesEstado($value = "0", $texto = "", $default = "0")
		{
			if(empty($texto))
				$texto = __("-- Selecione --");
			$primeiro = array("valor"=>$default,"texto"=>$texto);
			$sql = "SELECT idestado AS 'id', estado AS 'texto' FROM estado ORDER BY texto ASC";
			return $this->GeraOpcoesSql($value, $sql, "id", "texto", $primeiro);
		}
		################################################################################################################
		public function GetSqlLista()
		{
			$retorno = "";
			try
			{
				return "SELECT C.*, E.estado, E.uf, P.pais, P.sigla, E.idpais FROM cidade C LEFT JOIN estado E ON(C.idestado = E.idestado) LEFT JOIN pais P ON(E.idpais = P.idpais)";
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
				return "SELECT COUNT(DISTINCT C.idcidade) AS CONT FROM cidade C LEFT JOIN estado E ON(C.idestado = E.idestado) LEFT JOIN pais P ON(E.idpais = P.idpais)";
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
				$filtro .= " AND C.cidade LIKE '%{$buscar}%'";
			}
			
			$idpais = GetFiltro("idpais");
			if(!empty($idpais))
			{
				$filtro .= " AND E.idpais = '{$idpais}'";
			}
			$idestado = GetFiltro("idestado");
			if(!empty($idestado))
			{
				$filtro .= " AND C.idestado = '{$idestado}'";
			}
			if(!empty($filtro))
			{
				$filtro  = substr($filtro, 4);
			}
			if($semOrder)
			{
				return $filtro;
			}
			$ordem = array('C.idcidade', 'C.cidade', 'E.estado', 'P.pais', 'C.longitude', 'C.idcidade');
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
			$obj = GetModelo("cidade");
			if(empty($obj))
				return $retorno;
			foreach ($lista as $key=>$linha)
			{
				$obj->SalvarListaCidade($linha);
			}
			return true;
		}
		################################################################################################################
		public function SalvarListaCidade($dados = false)
		{
			if(empty($dados))
				return;
			$nomepais = self::GetDadosChave($dados, array('pais','país','Pais','País','PAIS','PAÍS'));
			$sigla = self::GetDadosChave($dados, array('sigla','siglas','Sigla','Siglas','SIGLA','SIGLAS'));
			$pais = self::NewPais();
			$idpais = $pais->LerIdPais($nomepais, $sigla);

			$nomeestado = self::GetDadosChave($dados, array('estado','Estado','ESTADO'));
			$uf = self::GetDadosChave($dados, array('uf','uF','Uf','UF'));
			$estado = self::NewEstado();
			$idestado = $estado->LerIdEstado($nomeestado, $uf, $idpais);

			$cidade = self::GetDadosChave($dados, array('cidade','Cidade','cidades','Cidades','CIDADE','CIDADES'));
			if(empty($cidade))
				return;
			$aux = Escape($cidade);	
			$filtro = "cidade = '{$aux}'";
			if(!empty($idestado))
				$filtro .= " AND idestado = '{$idestado}'";
			$obj = $this->FiltroObjeto($filtro);
			if(empty($obj))
			{
				$obj = $this->GetInstancia();
				$obj->cidade = $cidade;
				$obj->idestado = $idestado;
				$obj->idcidade = 0;
				$id = 0;
			}
			else
			{
				$id = $obj->idcidade;
			}
			$obj->longitude = self::GetDadosChave($dados, array('longitude','Longitude','LONGITUDE'));
			$obj->longitude = self::GetDadosChave($dados, array('latitude','Latitude','LATITUDE'));
			$obj->Ajustar(true);
			$idcidade = $obj->Salvar();
			if(empty($id))
				$obj->idcidade = $idcidade;
			return $obj->idcidade;
		}
		################################################################################################################
		public function ExportarCidade()
		{
			$filtro = $this->Filtro(true);
			$filtro .= " ORDER BY cidade ASC";
			$obj = GetModelo('cidade');
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
				$dados['mensagem'] = __("Verificação de cidade foi finalizado.<br/>O download se iniciará em instantes");
				$dados['url'] = site_url("cidade/baixarcidade/{$file}");
				$dados['titulo'] = __("Exportação de cidade");
			}
			else
			{
				$dados['sucesso'] = false;
				$dados['erro'] = __("Nenhuma cidade foi encontrada.");
			}
			return $dados;
		}
		################################################################################################################
		public function GetNomeFile()
		{
			$retorno = "exportacaocidade_".date("Y-m-d_H-i-s").".xls";
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
			$campos = array("id" => "idcidade",
			"cidade" => "cidade",
			"estado" => "estado",
			"uf" => "uf",
			"pais" => "pais",
			"sigla" => "sigla",
			"longitude" =>"longitude",
			"latitude" => "latitude");
			return $campos;
		}
		################################################################################################################
		public function GetCaminho($file = "")
		{
			return $this->SetDominio($file);
		}
		#######################################################################################################
		public function GetIdPais($idestado = false)
		{
			$retorno = 0;
			try
			{
				if(empty($idestado))
					$idestado = $this->Get("idestado", 0);
				if(empty($idestado))
					return $retorno;
				$sql = "SELECT idpais AS CONT FROM estado WHERE idestado = '{$idestado}'";
				return self::GetSqlCampo($sql, "CONT", 0);
			}
			catch( Exception $e )
			{
				throw new Exception( $e );
				return $retorno;
			}
		}
		################################################################################################################
		public function GetSqlTotalCoordenadas($processando = "parcial")
		{
			if($processando == "realizado")
				$sql = "SELECT COUNT(*) AS CONT FROM cidade C WHERE ISNULL(NULLIF(C.longitude,'')) = 0 AND ISNULL(NULLIF(C.longitude,'')) = 0";
			elseif($processando == "parcial")
				$sql = "SELECT COUNT(*) AS CONT FROM cidade C WHERE ISNULL(NULLIF(C.longitude,'')) = 1 OR ISNULL(NULLIF(C.longitude,'')) = 1";
			else
				$sql = "SELECT COUNT(*) AS CONT FROM cidade C WHERE ISNULL(NULLIF(C.cidade,'')) = 0";
			return $sql;
		}
		################################################################################################################
		public function GetSqlCoordenadas($idcidade = 0, $limitecidade = 50, $processando = "parcial")
		{
			if($processando == "realizado")
			{
				$sql = "SELECT C.idcidade, C.cidade, TRIM(CONCAT(C.cidade,IF(ISNULL(NULLIF(E.estado,'')) = 1,'',CONCAT(' ',E.estado)), IF(ISNULL(NULLIF(P.pais,'')) = 1,'',CONCAT(' ',P.pais)))) AS 'buscar', C.longitude, C.latitude, C.northeast_lat, C.northeast_lng, C.southwest_lat, C.southwest_lng, '0' AS 'atualizado' FROM cidade C LEFT JOIN estado E ON(C.idestado = E.idestado) LEFT JOIN pais P ON(E.idpais = P.idpais) WHERE ISNULL(NULLIF(C.longitude,'')) = 0 AND ISNULL(NULLIF(C.longitude,'')) = 0 AND C.idcidade > '{$idcidade}' ORDER BY C.idcidade ASC LIMIT 0, {$limitecidade}";
			}
			elseif($processando == "parcial")
			{
				$sql = "SELECT C.idcidade, C.cidade, TRIM(CONCAT(C.cidade,IF(ISNULL(NULLIF(E.estado,'')) = 1,'',CONCAT(' ',E.estado)), IF(ISNULL(NULLIF(P.pais,'')) = 1,'',CONCAT(' ',P.pais)))) AS 'buscar', C.longitude, C.northeast_lat, C.northeast_lng, C.southwest_lat, C.southwest_lng, C.latitude, '0' AS 'atualizado' FROM cidade C LEFT JOIN estado E ON(C.idestado = E.idestado) LEFT JOIN pais P ON(E.idpais = P.idpais) WHERE (ISNULL(NULLIF(C.longitude,'')) = 1 OR ISNULL(NULLIF(C.longitude,'')) = 1) AND C.idcidade > '{$idcidade}' ORDER BY C.idcidade ASC LIMIT 0, {$limitecidade}";
			}
			else
			{	
				$sql = "SELECT C.idcidade, C.cidade, TRIM(CONCAT(C.cidade,IF(ISNULL(NULLIF(E.estado,'')) = 1,'',CONCAT(' ',E.estado)), IF(ISNULL(NULLIF(P.pais,'')) = 1,'',CONCAT(' ',P.pais)))) AS 'buscar', C.longitude, C.latitude, C.northeast_lat, C.northeast_lng, C.southwest_lat, C.southwest_lng, '0' AS 'atualizado' FROM cidade C LEFT JOIN estado E ON(C.idestado = E.idestado) LEFT JOIN pais P ON(E.idpais = P.idpais) WHERE ISNULL(NULLIF(C.cidade,'')) = 0 AND C.idcidade > '{$idcidade}' ORDER BY C.idcidade ASC LIMIT 0, {$limitecidade}";
			}
			return $sql;
		}
		################################################################################################################
		public function GetTotalCoordenadas($processando = "parcial")
		{
			$sql = $this->GetSqlTotalCoordenadas($processando);
			return $this->TotalRegistro(false, $sql);
		}
		################################################################################################################
		public function SalvarLista($cidades = false)
		{
			$retorno = 0;
			try
			{
				if(empty($cidades))
					return $retorno;
				if(!is_array($cidades))
					return $retorno;
				$obj = GetModelo("cidade");
				$ultimo = 0;
				foreach($cidades as $key=>$cidade)
				{
					if($cidade['atualizado'])					
					{
						$obj->idcidade = $cidade['idcidade'];
						if($obj->Load())
						{
							$obj->longitude = $cidade['longitude'];
							$obj->latitude = $cidade['latitude'];
							$obj->northeast_lat = $cidade['northeast_lat'];
							$obj->northeast_lng = $cidade['northeast_lng'];
							$obj->southwest_lat = $cidade['southwest_lat'];
							$obj->southwest_lng = $cidade['southwest_lng'];
							$obj->Ajustar(true);
							$obj->Salvar();
						}
					}
					$ultimo = $cidade['idcidade'];
				}
				return $ultimo;
			}
			catch( Exception $e )
			{
				throw new Exception( $e );
				return $retorno;
			}
		}
		################################################################################################################
		public function BuscarListadeCidades($idcidade = 0, $limitecidade = 50, $processando = "parcial")
		{
			$retorno = false;
			try
			{
				$obj = GetModelo("cidade");
				$sql = $obj->GetSqlCoordenadas($idcidade, $limitecidade, $processando);
				$rows = $obj->FiltroJson(false, $sql, false);
				return $rows;
			}
			catch( Exception $e )
			{
				throw new Exception( $e );
				return $retorno;
			}
		}
		################################################################################################################
		public function ListaCidades()
		{
			$idestado = Get("idestado", 0);
			if(!empty($idestado))
			{
				$filtro = " WHERE C.idestado = '{$idestado}' AND P.pais = 'Brasil'";
			}
			else
			{
				$filtro = " WHERE P.pais = 'Brasil'";
			}	
			$filtro .= " ORDER BY texto ASC";
			$sql = "SELECT C.idcidade AS 'id', C.cidade AS 'texto' FROM cidade C LEFT JOIN estado E ON(C.idestado = E.idestado) LEFT JOIN pais P ON(E.idpais = P.idpais) {$filtro}";
			$rows = $this->GetRows(false, $sql);
			if(!empty($rows))
			{
				$dados['sucesso'] = true;
				$dados['lista'] = $rows;
				$dados['mensagem'] = __("Lista de cidade foi encontrada com sucesso.");
				$dados['titulo'] = __("Sucesso");
			}
			else
			{
				$dados['sucesso'] = false;
				$dados['erro'] = __("Nenhuma cidade foi encontrada.");
				$dados['titulo'] = __("Erro");
			}
			return $dados;
		}
		################################################################################################################
		public function LerIdCidade($palavraschaves = false, $idestado = 0)
		{
			if(empty($palavraschaves))
			{
				return 0;
			}
			$palavraschaves = trim($palavraschaves," \n\t\r");
			$aux = Escape($palavraschaves);
			$sql = "SELECT idcidade AS id FROM {$this->Tabela} WHERE cidade = '{$aux}' LIMIT 1";
			$id = $this->GetSqlCampo($sql,"id", 0);
			if(empty($id))
			{
				$this->idcidade = 0;
				$this->cidade = $palavraschaves;
				$this->idestado = $idestado;
				$id = $this->Salvar();
				if(empty($id))
				{
					return 0;
				}
			}
			return $id;
		}
		################################################################################################################
		public function LerDadosCidade($cidade = "", $estado = "", $pais = "")
		{
			$retorno = ["idpais"=>0,"idestado"=>0,"idcidade"=>0];
			if(empty($pais))
			{
				$pais = "Brasil";
				$sigla = "BR";
			}
			elseif(strcasecmp($pais, "brazil") == 0)
			{
				$pais = "Brasil";
				$sigla = "BR";
			}
			elseif(strcasecmp($pais, "brasil") == 0)
			{
				$sigla = "BR";
			}
			else
				$sigla = "";
			$obj = self::NewPais();
			$retorno["idpais"] = $obj->LerIdPais($pais, $sigla);
			$obj = self::NewEstado();
			$retorno["idestado"] = $obj->LerIdEstado($estado, "", $retorno['idpais']);
			$retorno["idcidade"] = $this->LerIdCidade($cidade, $retorno['idestado']);
			
			return $retorno;
		}
		################################################################################################################
		public function LerListaCidades()
		{
			$idcliente = Get("idcliente", 0);
			$idvaga = Get("idvaga", 0);
			$calcular = Get("calcular", 0);
			$idestado = Get("idestado", 0);
			$posicao = Get("posicao", 0);
			$limite = Get("limite", 10);
			$total = Get("total", 0);

			$rows = false;
			$titulo = __("Erro");
			$mensagem = __("Nenhuma empresa foi encontrado.");
			
			$filtro = "";
			if(!empty($idcliente))
			{
				$filtro .= " 1 ";
				#$filtro .= " idcliente = '{$idcliente}' ";
			}
			else
			{
				$dados['sucesso'] = false;
				$dados['erro'] = __("ID do cliente não foi enviado.");
				return $dados;
			}
			if(!empty($idvaga))
			{
				$filtro .= " AND V.idvaga ".GerarIN($idvaga);
			}
			if(!empty($idestado))
			{
				$filtro .= " AND C.idestado ".GerarIN($idestado);
			}
			if(empty($total))
			{
				$sql = "SELECT COUNT(DISTINCT C.idcidade) AS CONT FROM cidade C INNER JOIN estado E ON(C.idestado = E.idestado) INNER JOIN candidato CO ON(C.idcidade = CO.idcidade) INNER JOIN candidatovaga CV ON(CO.idcandidato = CV.idcandidato) INNER JOIN vaga V ON(CV.idvaga = V.idvaga) WHERE {$filtro}";
				$total = $this->TotalRegistro(false, $sql);
			}
			if(!empty($total))
			{
				if($limite < 0)
					$limite = $total;
				if(empty($calcular))
				{
					$filtro .= " ORDER BY C.cidade ASC, E.estado ASC LIMIT {$posicao}, {$limite}";
					$sql = "SELECT DISTINCT C.idcidade, C.cidade, C.idestado, E.estado, E.uf, '0' AS total FROM cidade C INNER JOIN estado E ON(C.idestado = E.idestado) INNER JOIN candidato CO ON(C.idcidade = CO.idcidade) INNER JOIN candidatovaga CV ON(CO.idcandidato = CV.idcandidato) INNER JOIN vaga V ON(CV.idvaga = V.idvaga) WHERE {$filtro}";
				}
				else
				{
					$filtro .= " GROUP BY C.idcidade, C.cidade, C.idestado, E.estado, E.uf ORDER BY total DESC, C.cidade ASC, E.estado ASC LIMIT {$posicao}, {$limite}";
					$sql = "SELECT C.idcidade, C.cidade, C.idestado, E.estado, E.uf, COUNT(DISTINCT CV.idcandidato) AS total FROM cidade C INNER JOIN estado E ON(C.idestado = E.idestado) INNER JOIN candidato CO ON(C.idcidade = CO.idcidade) INNER JOIN candidatovaga CV ON(CO.idcandidato = CV.idcandidato) INNER JOIN vaga V ON(CV.idvaga = V.idvaga) WHERE {$filtro}";
				}
				$rows = $this->GetRows(false, $sql);
				if(!empty($rows))
				{
					$rows = array_map(array($this,'Map'), $rows);
					$titulo = __("Sucesso");
					$mensagem = __("Lista de cidade foi encontrada com sucesso.");
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
			$dados['idcliente'] = $idcliente;
			$dados['idvaga'] = $idvaga;
			$dados['posicao'] = $novaposicao;
			$dados['limite'] = $limite;
			$dados['total'] = $idcliente;
			$dados['finalizado'] = $finalizado;
			return $dados;
		}
		################################################################################################################
		public static function Map($row = false)
		{
			$row['idcidade'] = intval($row['idcidade']);
			$row['idestado'] = intval($row['idestado']);
			$row['total'] = intval($row['total']);
			return $row;
		}
		
		################################################################################################################
		public function GetListaCidades()
		{
			$idcliente = Get("idcliente", 0);
			$idvaga = Get("idvaga", 0);
			$posicao = Get("posicao", 0);
			$limite = Get("limite", 10);
			$total = Get("total", 0);
			
			$filtro = "";
			if(!empty($idcliente))
			{
				$filtro .= " 1 ";
				//$filtro .= " idcliente = '{$idcliente}' ";
			}
			else
			{
				$dados['sucesso'] = false;
				$dados['erro'] = __("ID do cliente não foi enviado.");
				return $dados;
			}
			if(!empty($idvaga))
			{
				$filtro .= " AND idvaga ".GerarIN($idvaga);
			}
			if(empty($total))
			{
				$sql = "SELECT COUNT(DISTINCT C.idcidade) AS CONT FROM cidade C INNER JOIN estado E ON(C.idestado = E.idestado) INNER JOIN candidato CO ON(C.idcidade = CO.idcidade) INNER JOIN candidatovaga CV ON(CO.idcandidato = CV.idcandidato) INNER JOIN vaga V ON(CV.idvaga = V.idvaga) WHERE {$filtro}";
				$total = $this->TotalRegistro(false, $sql);
				if(empty($total))
				{
					$dados['sucesso'] = false;
					$dados['erro'] = __("Nenhuma cidade foi encontrada.");
					return $dados;
				}
			}
			if($limite < 0)
				$limite = $total;
			$filtro .= " ORDER BY C.cidade ASC, E.estado ASC LIMIT {$posicao}, {$limite}";
			$sql = "SELECT DISTINCT C.idcidade, C.cidade, C.idestado, E.estado, E.uf FROM cidade C INNER JOIN estado E ON(C.idestado = E.idestado) INNER JOIN candidato CO ON(C.idcidade = CO.idcidade) INNER JOIN candidatovaga CV ON(CO.idcandidato = CV.idcandidato) INNER JOIN vaga V ON(CV.idvaga = V.idvaga) WHERE {$filtro}";
			$rows = $this->GetRows(false, $sql);
			if(!empty($rows))
			{
				$novaposicao = $posicao + $limite;
				if($novaposicao >= $total)
					$finalizado = true;
				else
					$finalizado = false;
				$dados['sucesso'] = true;
				$dados['lista'] = $rows;
				$dados['mensagem'] = __("Lista de cidade foi encontrada com sucesso.");
				$dados['titulo'] = __("Sucesso");
				$dados['idcliente'] = $idcliente;
				$dados['idvaga'] = $idvaga;
				$dados['posicao'] = $novaposicao;
				$dados['limite'] = $limite;
				$dados['total'] = $idcliente;
				$dados['finalizado'] = $finalizado;
			}
			else
			{
				$dados['sucesso'] = false;
				$dados['erro'] = __("Nenhuma cidade foi encontrada.");
			}
			return $dados;
		}
		################################################################################################################
		public function __destruct()
		{ 
			unset($this->dados, $this->Tabela, $this->PrimaryKey);
		}
	}
}
?>