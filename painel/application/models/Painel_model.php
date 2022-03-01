<?php
/***********************************************************************
 * Module:  /models/Painel_model.PHP
 * Author:  Host-up
 * Date:	25/11/2018 22:18:33
 * Purpose: Definição da Classe Painel_model
 * Instancias: $this->load->model('Painel_model', 'painel');
 * Objeto: $painel = $this->painel->GetInstancia($dados);
 ***********************************************************************/
if (!class_exists('Painel_model'))
{
	class Painel_model extends MY_Model
	{
		################################################################################################################
		public function __construct( $dados = false)
		{
			try
			{
				$this->Tabela = "painel";
				$this->PrimaryKey = "idpainel";
				parent::__construct($dados);
			}
			catch( Exception $e )
			{
				throw new Exception( $e );
			}
		}
		################################################################################################################
		public function ExportarCandidatosContatos()
		{
			$filtro = $this->Filtro(true);
			$filtro .= " ORDER BY C.nome ASC";
			$obj = GetModelo('painel');
			$sql = $this->GetSqlLista();
			$objs = $obj->FiltroObjetos($filtro, $sql);
			if($objs)
			{
				$file = $obj->GetNomeFile();
				$data = array(
					"file"=> $file,
					"lista"=>$objs,
					"html"=>false,
					"maiusculo"=>false,
					"campos"=>$obj->GetNomesCampos(),
					"download"=>false,
					"pasta"=>$obj->GetCaminho()
				);
				Excel($data);
				$dados['sucesso'] = true;
				$dados['mensagem'] = __("Exportação de candidatos contactados foi finalizado.<br/>O download se iniciará em instantes");
				$dados['url'] = site_url("api/baixarcandidatoscontatos/{$file}");
				$dados['titulo'] = __("Exportação de setor");
			}
			else
			{
				$dados['sucesso'] = false;
				$dados['erro'] = __("Nenhum candidato contactado foi encontrado.");
			}
			return $dados;
		}
		################################################################################################################
		public function ExportarCandidatosMarcados()
		{
			$obj = GetModelo('painel');
			$candidato = GetModelo('candidato');
			$sql = $this->GetSqlLista();
			$data = $candidato->CandidatosMarcados();
			if(empty($data['lista']))
			{
				$objs = false;
			}
			else
			{
				$lista = $data['lista'];
				$objs = false;
				foreach ($lista as $key=>$valor)
				{					
					$obj = GetModelo('painel');
					$dados = ["marcado"=>$key, "comtelefone"=>$valor[0], "comemail"=>$valor[1], "habu"=>$valor[2]];
					$obj->Carregar($dados);
					$objs[] = $obj;
				}
			}
			if($objs)
			{
				$file = $obj->GetNomeFile("Marcados");
				$data = array(
					"file"=> $file,
					"lista"=>$objs,
					"html"=>false,
					"campos"=>$obj->GetNomesCampos("Marcados"),
					"download"=>false,
					"maiusculo"=>false,
					"pasta"=>$obj->GetCaminho(),
					"funcao"=>"GetDadosExcelMarcados"
				);
				Excel($data);
				$dados['sucesso'] = true;
				$dados['mensagem'] = __("Exportação de candidatos contactados foi finalizado.<br/>O download se iniciará em instantes");
				$dados['url'] = site_url("api/baixarcandidatoscontatos/{$file}");
				$dados['titulo'] = __("Exportação de candidatos contactados");
			}
			else
			{
				$dados['sucesso'] = false;
				$dados['erro'] = __("Nenhum candidato contactado foi encontrado.");
			}
			return $dados;
		}
		################################################################################################################
		public function ExportarCandidatosAvaliados()
		{
			$obj = GetModelo('painel');
			$candidato = GetModelo('candidato');
			$sql = $this->GetSqlLista();
			$data = $candidato->CandidatosAvaliados();
			if(empty($data['lista']))
			{
				$objs = false;
			}
			else
			{
				$lista = $data['lista'];
				$objs = false;
				foreach ($lista as $key=>$valor)
				{					
					$obj = GetModelo('painel');
					$dados = ["marcado"=>$key, "avaliados"=>$valor[0], "naoavaliados"=>$valor[1]];
					$obj->Carregar($dados);
					$objs[] = $obj;
				}
			}
			if($objs)
			{
				$file = $obj->GetNomeFile("Avaliados");
				$data = array(
					"file"=> $file,
					"lista"=>$objs,
					"html"=>false,
					"campos"=>$obj->GetNomesCampos("Avaliados"),
					"download"=>false,
					"maiusculo"=>false,
					"pasta"=>$obj->GetCaminho(),
					"funcao"=>"GetDadosExcelAvaliados"
				);
				Excel($data);
				$dados['sucesso'] = true;
				$dados['mensagem'] = __("Exportação de candidatos avaliados foi finalizado.<br/>O download se iniciará em instantes");
				$dados['url'] = site_url("api/baixarcandidatoscontatos/{$file}");
				$dados['titulo'] = __("Exportação de candidato avaliado");
			}
			else
			{
				$dados['sucesso'] = false;
				$dados['erro'] = __("Nenhum candidato avaliado foi encontrado.");
			}
			return $dados;
		}
		#######################################################################################################
		public function Filtro($semOrder = false)
		{
			$filtro = " AND A.idavaliacao IS NULL AND ISNULL(NULLIF(CC.tipo,'')) = 0";
			$idvaga = intval(Get("idvaga",0));
			if(!empty($idvaga))
			{
				if($idvaga > 0)
					$filtro .= " AND CV.idvaga = '{$idvaga}'";
			}
			$tipo = Get("tipo","");
			if(!empty($tipo))
			{
				switch($tipo)
				{
					case "comtelefone":
						$filtro .= " AND ISNULL(NULLIF(C.telefone,'')) = 0 ";
						break;
					case "comemail":
						$filtro .= " AND ISNULL(NULLIF(C.email,'')) = 0 AND C.email NOT LIKE '%@habu.com.br%' AND ISNULL(NULLIF(C.telefone,'')) = 1";
						break;
					case "habu":
						$filtro .= " AND ISNULL(NULLIF(C.email,'')) = 0 AND C.email LIKE '%@habu.com.br%'";
						break;
				}
				
			}

			if(!empty($filtro))
			{
				$filtro  = substr($filtro, 4);
			}
			if($semOrder)
			{
				return $filtro;
			}
			$ordem = array('C.nome', 'C.email', 'C.telefone', 'CC.tipo', 'CC.tipo', 'CC.tipo', 'CC.tipo');
			$start = Get("start", 0);
			$length = Get("length", 10);
			$order = Get("order", 0,0);
			$filtro .= " GROUP BY C.idcandidato, C.nome, C.email, C.telefone";
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
		public function GetSqlLista()
		{
			$retorno = "";
			try
			{
				return "SELECT C.idcandidato, C.nome, C.email, C.telefone FROM candidato C
				INNER JOIN candidatovaga CV FORCE INDEX(idxcandidato, idxvaga) ON(C.idcandidato = CV.idcandidato) 
				INNER JOIN vaga V ON(V.idvaga = CV.idvaga)
				LEFT JOIN candidatocontato CC FORCE INDEX(idxcandidato) ON(C.idcandidato = CC.idcandidato AND CC.idvaga = CV.idvaga) 
				LEFT JOIN avaliacao A FORCE INDEX(idxcandidato) ON(C.idcandidato = A.idcandidato) 
				 ";
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
				return "SELECT COUNT(DISTINCT C.idcandidato) AS CONT FROM candidato C
				INNER JOIN candidatovaga CV FORCE INDEX(idxcandidato, idxvaga) ON(C.idcandidato = CV.idcandidato)
				INNER JOIN vaga V ON(V.idvaga = CV.idvaga) 
				LEFT JOIN candidatocontato CC FORCE INDEX(idxcandidato) ON(C.idcandidato = CC.idcandidato AND CC.idvaga = CV.idvaga) 
				LEFT JOIN avaliacao A FORCE INDEX(idxcandidato) ON(C.idcandidato = A.idcandidato)  ";
			}
			catch( Exception $e )
			{
				throw new Exception( $e );
				return $retorno;
			}
		}
		#######################################################################################################
		public function listatabela($filtro = "", $sql = "", $sqlTotal = "")
		{
			if(empty($sqlTotal))
			{
				$sqlTotal = $sql;
				$limparSql = true;
			}
			else
			{
				$limparSql = false;
			}
			$filtroTotal = " AND A.idavaliacao IS NULL";
			$idvaga = intval(Get("idvaga",0));
			if(!empty($idvaga))
			{
				if($idvaga > 0)
					$filtroTotal .= " AND CV.idvaga = '{$idvaga}'";
			}
			$tipo = Get("tipo","");
			if(!empty($tipo))
			{
				switch($tipo)
				{
					case "comtelefone":
						$filtroTotal .= " AND ISNULL(NULLIF(C.telefone,'')) = 0 ";
						break;
					case "comemail":
						$filtroTotal .= " AND ISNULL(NULLIF(C.email,'')) = 0 AND C.email NOT LIKE '%@habu.com.br%' AND ISNULL(NULLIF(C.telefone,'')) = 1";
						break;
					case "habu":
						$filtroTotal .= " AND ISNULL(NULLIF(C.email,'')) = 0 AND C.email LIKE '%@habu.com.br%'";
						break;
				}
				
			}
			if(!empty($filtroTotal))
			{
				$filtroTotal  = substr($filtroTotal, 4);
			}
			$total = $this->TotalRegistro($filtroTotal, $sqlTotal, $limparSql);
			$totalfiltro = $this->TotalRegistro($filtro, $sqlTotal, $limparSql);
			$lista = $this->FiltroJson($filtro, $sql);
			$dados = array("draw" => Get('draw', 0),
				"recordsTotal" => $total,
				"recordsFiltered" => $totalfiltro,
				"data" => $lista);
			return $dados;
		}
		################################################################################################################
		public function GetNomeFile($tipo = "geral")
		{
			$retorno = "exportacao_Candidatos_Contatos_".date("Y-m-d_H-i-s").".xls";
			try
			{
				if($tipo == "geral")
				{
					return $retorno;
				}
				elseif($tipo == "Marcados")
				{
					return "exportacao_Candidatos_Marcados_".date("Y-m-d_H-i-s").".xls";
				}
				elseif($tipo == "Avaliados")
				{
					$modo = Get("tipo","");
					if(empty($modo))
						$modo = "geral";
					return "exportacao_Candidatos_Avaliados_{$modo}_".date("Y-m-d_H-i-s").".xls";
				}
			}
			catch( Exception $e )
			{
				throw new Exception( $e );
				return $retorno;
			}
		}
		################################################################################################################
		public function GetCaminho($file = "")
		{
			$obj = GetModelo('candidato');
			return $obj->SetDominio($file);
		}
		################################################################################################################
		public function GetNomesCampos($tipo = "geral")
		{
			$retorno = "";
			try
			{
				if($tipo == "geral")
				{
					return array(
						"nome" => "nome",
						"email" => "email",
						"telefone" => "telefone",
						"Mandei whatsapp" => "mandei_whatsapp",
						"Mandei e-mail" => "mandei_email",
						"Tentativa de contato por telefone" => "tentativa_de_contato_por_telefone",
						"Conectei pelo linkedin" => "conectei_pelo_linkedin",
					);
				}
				elseif($tipo == "Marcados")
				{
					return array(
						" " => "marcado",
						"Candidatos com telefone" => "comtelefone",
						"Candidatos só com e-mail e sem telefone" => "comemail",
						"Candidato com ID habu" => "habu",
						"Total" => "total"
					);
				}				
				elseif($tipo == "Avaliados")
				{
					return array(
						" " => "marcado",
						"Avaliados" => "avaliados",
						"Sem avaliação" => "naoavaliados",
						"Total" => "total"
					);
				}
			}
			catch( Exception $e )
			{
				throw new Exception( $e );
				return $retorno;
			}
		}
		################################################################################################################
		public function &GetJson(&$dados = false)
		{
			$retorno = false;
			try
			{
				if(empty($dados))
				{
					$dados = $this->GetDados();
				}
				$dados['mandei_whatsapp'] = "";
				$dados['mandei_email'] = "";
				$dados['tentativa_de_contato_por_telefone'] = "";
				$dados['conectei_pelo_linkedin'] = "";
				
				$rows = self::GetTipoCandidato($dados['idcandidato']);
				if($rows)
				{
					foreach($rows as $row)
					{
						switch($row['tipo'])
						{
							case "Mandei whatsapp":
								$dados['mandei_whatsapp'] = "Sim";
								break;
							case "Mandei e-mail":
								$dados['mandei_email'] = "Sim";
								break;
							case "Tentativa de contato por telefone":
								$dados['tentativa_de_contato_por_telefone'] = "Sim";
								break;
							case "Conectei pelo linkedin":
								$dados['conectei_pelo_linkedin'] = "Sim";
								break;
						}
					}
				}
				return $dados;
			}
			catch( Exception $e )
			{
				throw new Exception( $e );
				return $retorno;
			}
		}
		################################################################################################################
		public function &GetDadosExcel(&$dados = false)
		{
			$retorno = false;
			try
			{
				if(empty($dados))
				{
					$dados = $this->GetDados();
				}
				$dados['mandei_whatsapp'] = "";
				$dados['mandei_email'] = "";
				$dados['tentativa_de_contato_por_telefone'] = "";
				$dados['conectei_pelo_linkedin'] = "";
				
				$rows = self::GetTipoCandidato($dados['idcandidato']);
				if($rows)
				{
					foreach($rows as $row)
					{
						switch($row['tipo'])
						{
							case "Mandei whatsapp":
								$dados['mandei_whatsapp'] = "Sim";
								break;
							case "Mandei e-mail":
								$dados['mandei_email'] = "Sim";
								break;
							case "Tentativa de contato por telefone":
								$dados['tentativa_de_contato_por_telefone'] = "Sim";
								break;
							case "Conectei pelo linkedin":
								$dados['conectei_pelo_linkedin'] = "Sim";
								break;
						}
					}
				}
				unset($dados['tipo']);
				return $dados;
			}
			catch( Exception $e )
			{
				throw new Exception( $e );
				return $retorno;
			}
		}
		################################################################################################################
		public static function &GetTipoCandidato($idcandidato = 0)
		{
			$retorno = false;
			try
			{
				if(empty($idcandidato))
				{
					return $retorno;
				}
				$sql = "SELECT DISTINCT tipo FROM candidatocontato WHERE idcandidato = '{$idcandidato}' ";
				return self::GetSqlrows($sql);
			}
			catch( Exception $e )
			{
				throw new Exception( $e );
				return $retorno;
			}
		}
		################################################################################################################
		public function &GetDadosExcelMarcados(&$dados = false)
		{
			$retorno = false;
			try
			{
				if(empty($dados))
				{
					$dados = $this->GetDados();
				}
				$dados["total"] = intval($dados["comtelefone"]) + intval($dados["comemail"]) + intval($dados["habu"]);
				return $dados;
			}
			catch( Exception $e )
			{
				throw new Exception( $e );
				return $retorno;
			}
		}
		################################################################################################################
		public function &GetDadosExcelAvaliados(&$dados = false)
		{
			$retorno = false;
			try
			{
				if(empty($dados))
				{
					$dados = $this->GetDados();
				}
				$dados["total"] = intval($dados["avaliados"]) + intval($dados["naoavaliados"]);
				return $dados;
			}
			catch( Exception $e )
			{
				throw new Exception( $e );
				return $retorno;
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