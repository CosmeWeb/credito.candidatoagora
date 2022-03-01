<?php
/***********************************************************************
 * Module:  /models/Abordagem_model.PHP
 * Author:  Host-up
 * Date:	18/01/2022 22:01:25
 * Purpose: Definição da Classe Abordagem_model
 * Instancias: $this->load->model('Abordagem_model', 'abordagem');
 * Objeto: $abordagem = $this->abordagem->GetInstancia($dados);
 ***********************************************************************/
if (!class_exists('Abordagem_model'))
{
	class Abordagem_model extends MY_Model
	{
		################################################################################################################
		public function __construct( $dados = false)
		{
			try
			{
				$this->Tabela = "abordagem";
				$this->PrimaryKey = "idabordagem";
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
		public function GerarOpcoesTipo($value = "", $texto = "", $default = "")
		{
			if(empty($texto))
				$texto = __("-- Selecione --");
			$primeiro = array("valor"=>$default,"texto"=>$texto);
			return $this->GeraOpcoesEnum($value, $this->Tabela, "tipo", $primeiro);
		}
		################################################################################################################
		public function GetSqlLista()
		{
			$retorno = "";
			try
			{
				return "SELECT * FROM abordagem ";
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
				return "SELECT COUNT(*) AS CONT FROM abordagem ";
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
				$buscar = explode(";", $buscar);
				$filtrobuscar = " AND (";
				$first = true;
				foreach($buscar as $busca)
				{
					$busca = trim($busca);
					if(empty($busca))
						continue;
					$busca = Escape(trim($busca));
					if(!$first)
					{
						$filtrobuscar .= " OR ";
					}
					else
					{
						$first = false;
					}
					$filtrobuscar .= " buscar LIKE '%{$busca}%'";
				}
				$filtrobuscar .= ")";
				$filtro .= $filtrobuscar;
			}
			
			$idabordagem = GetFiltro("idabordagem");
			if(!empty($idabordagem))
			{
				$filtro .= " AND idabordagem = '{$idabordagem}'";
			}
			$idcandidato = GetFiltro("idcandidato");
			if(!empty($idcandidato))
			{
				$filtro .= " AND idcandidato = '{$idcandidato}'";
			}
			$tipo = GetFiltro("tipo");
			if(!empty($tipo))
			{
				$filtro .= " AND tipo = '{$tipo}'";
			}
			if(!empty($filtro))
			{
				$filtro  = substr($filtro, 4);
			}
			if($semOrder)
			{
				return $filtro;
			}
			$ordem = array('idabordagem', 'idcandidato', 'tipo', 'idabordagem');
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
			$obj = GetModelo("abordagem");
			if(empty($obj))
				return $retorno;
			foreach ($lista as $key=>$linha)
			{
				$obj->SalvarListaAbordagem($linha);
			}
			return true;
		}
		################################################################################################################
		public function SalvarListaAbordagem($dados = false)
		{
			if(empty($dados))
				return;
			$abordagem = self::GetDadosChave($dados, array('abordagem','abordagem'));
			if(empty($abordagem))
				return;
			$filtro = "abordagem = '{$abordagem}'";
			$obj = $this->FiltroObjeto($filtro);
			if(empty($obj))
			{
				$obj = $this->GetInstancia();
				$obj->abordagem = $abordagem;
			}
			$obj->Ajustar(true);
			$obj->Salvar();
			return;
		}
		################################################################################################################
		public function GetCaminho($file = "")
		{
			return $this->SetDominio($file);
		}
		################################################################################################################
		public function LerListaAbordagens()
		{
			$idcliente = Get("idcliente", 0);
			$idvaga = Get("idvaga", 0);
			$posicao = Get("posicao", 0);
			$limite = Get("limite", 10);
			$total = Get("total", 0);

			$rows = false;
			$titulo = __("Erro");
			$mensagem = __("Nenhuma abordagem foi encontrada.");

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
				$total = 3;
			}
			if(!empty($total))
			{
				if($limite < 0)
					$limite = $total;
				$sql = "SELECT COUNT(DISTINCT AB.idabordagem) AS CONT FROM abordagem AB USE INDEX(idxcandidato, idxvaga) INNER JOIN candidatovaga CV USE INDEX(idxcandidato, idxvaga) ON(AB.idcandidato = CV.idcandidato AND AB.idvaga = CV.idvaga) LEFT JOIN favorito F FORCE INDEX(idxcandidato) ON(CV.idcandidato = F.idcandidato AND F.idvaga = CV.idvaga) WHERE {$filtro} AND AB.tipo = 'Associado'";
				$totalAssociado = $this->TotalRegistro(false, $sql,false);

				$sql = "SELECT COUNT(DISTINCT AB.idabordagem) AS CONT FROM abordagem AB USE INDEX(idxcandidato, idxvaga) INNER JOIN candidatovaga CV USE INDEX(idxcandidato, idxvaga) ON(AB.idcandidato = CV.idcandidato AND AB.idvaga = CV.idvaga) LEFT JOIN favorito F FORCE INDEX(idxcandidato) ON(CV.idcandidato = F.idcandidato AND F.idvaga = CV.idvaga) WHERE {$filtro} AND AB.tipo = 'Researcher'";
				$totalResearcher = $this->TotalRegistro(false, $sql,false);

				$sql = "SELECT COUNT(DISTINCT CV.idcandidato) AS CONT FROM candidatovaga CV USE INDEX(idxcandidato, idxvaga) LEFT JOIN abordagem AB USE INDEX(idxcandidato, idxvaga) ON(AB.idcandidato = CV.idcandidato AND AB.idvaga = CV.idvaga) LEFT JOIN favorito F FORCE INDEX(idxcandidato) ON(CV.idcandidato = F.idcandidato AND F.idvaga = CV.idvaga) WHERE {$filtro} AND AB.idabordagem IS NULL";
				$totalNaoMarcado = $this->TotalRegistro(false, $sql,false);

				$rows = [
					["abordagem"=>"Associado","texto"=>"Associado","total"=>$totalAssociado],
					["abordagem"=>"Researcher","texto"=>"Researcher","total"=>$totalResearcher],
					["abordagem"=>"Nao_Avaliado","texto"=>"Candidatos não abordados","total"=>$totalNaoMarcado]
				];
				if(!empty($rows))
				{
					$rows = array_map(array($this,'Map'), $rows);
					$titulo = __("Sucesso");
					$mensagem = __("Lista de abodagem foi encontrada com sucesso.");
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
			$row['total'] = intval($row['total']);
			return $row;
		}
		################################################################################################################
		public function MarcarAbordagem()
		{
			$idcandidato = Get("idcandidato", 0);
			$idvaga = Get("idvaga", 0);
			$tipo = Get("tipo", 0);
			$marcar = Get("marcar", 0);

			$rows = false;
			$titulo = __("Erro");
			$mensagem = __("Nenhuma abordagem foi encontrada.");

			$filtro = "";
			if(empty($idcandidato))
			{
				$dados['sucesso'] = false;
				$dados['erro'] = __("ID do candidato não foi enviado.");
				return $dados;
			}
			if(empty($idvaga))
			{
				$dados['sucesso'] = false;
				$dados['erro'] = __("ID do vaga não foi enviado.");
				return $dados;
			}
			$obj = GetModelo("abordagem");
			$filtro .= " idcandidato = '{$idcandidato}' AND idvaga = '{$idvaga}'";
			if($obj->Load($filtro))
			{				
				if(($obj->tipo == $tipo)&&(!empty($marcar)))
				{
					$titulo = __("Sucesso");
					$mensagem = __("Candidato foi marcado como sucesso.");
					$dados['sucesso'] = true;
					$dados['titulo'] = $titulo;
					$dados['mensagem'] = $mensagem;
					$dados['idcandidato'] = $idcandidato;
					$dados['idvaga'] = $idvaga;
					$dados['tipo'] = $tipo;
					if($tipo == "Associado")
					{
						$dados['msn'] = __("Candidato é Associado");
					}
					elseif($tipo == "Associado")
					{
						$dados['msn'] = __("Candidato é Researcher");
					}
					else
					{
						$dados['msn'] = __("Candidato não foi abordado");
					}
					return $dados;
				}
			}
			if(!empty($marcar))
			{
				$obj->idcandidato = $idcandidato;
				$obj->idvaga = $idvaga;
				$obj->Ajustar(true);
				$obj->Salvar();
				$titulo = __("Sucesso");
				$mensagem = __("Candidato foi marcado como sucesso.");
				$dados['sucesso'] = true;
				$dados['titulo'] = $titulo;
				$dados['mensagem'] = $mensagem;
				$dados['idcandidato'] = $idcandidato;
				$dados['idvaga'] = $idvaga;
				$dados['tipo'] = $tipo;
				if($tipo == "Associado")
				{
					$dados['msn'] = __("Candidato é Associado");
				}
				elseif($tipo == "Researcher")
				{
					$dados['msn'] = __("Candidato é Researcher");
				}
				else
				{
					$dados['msn'] = __("Candidato não foi abordado");
				}
			}			
			else
			{
				if(!empty($obj->idabordagem))
					$obj->Apagar();
				$titulo = __("Sucesso");
				$mensagem = __("Candidato foi desmarcado como sucesso.");
				$dados['sucesso'] = true;
				$dados['titulo'] = $titulo;
				$dados['mensagem'] = $mensagem;
				$dados['idcandidato'] = $idcandidato;
				$dados['idvaga'] = $idvaga;
				$dados['tipo'] = "";
				$dados['msn'] = __("Candidato não foi abordado");
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