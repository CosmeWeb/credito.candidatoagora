<?php
/***********************************************************************
 * Module:  /models/Candidatocontato_model.PHP
 * Author:  Host-up
 * Date:	07/09/2021 21:34:43
 * Purpose: Definição da Classe Candidatocontato_model
 * Instancias: $this->load->model('Candidatocontato_model', 'candidatocontato');
 * Objeto: $candidatocontato = $this->candidatocontato->GetInstancia($dados);
 ***********************************************************************/
if (!class_exists('Candidatocontato_model'))
{
	class Candidatocontato_model extends MY_Model
	{
		################################################################################################################
		public function __construct( $dados = false)
		{
			try
			{
				$this->Tabela = "candidatocontato";
				$this->PrimaryKey = "idcandidatocontato";
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
				if(empty($this->ip))
					$this->ip = GetIP();
				if(emptyData($this->cadastradoem))
					$this->cadastradoem = date("Y-m-d H:i:s");
				else
					$this->cadastradoem = date("Y-m-d H:i:s", TimeData($this->cadastradoem));				
			}
			else
			{
				if(emptyData($this->cadastradoem))
					$this->cadastradoem = "";
				else
					$this->cadastradoem = date("d/m/Y H:i:s", TimeData($this->cadastradoem));
			}
		}
		################################################################################################################
		public function LerListaContatos()
		{
			$idcliente = Get("idcliente", 0);
			$idvaga = Get("idvaga", 0);
			$posicao = Get("posicao", 0);
			$limite = Get("limite", 10);
			$total = Get("total", 0);

			$rows = false;
			$titulo = __("Erro");
			$mensagem = __("Nenhuma avaliação foi encontrada.");

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
			
			$tipos = $this->ArrayEnum( $this->Tabela, "tipo");
			if(empty($total))
			{
				$total = count($tipos) + 1;
			}
			if(!empty($total))
			{
				if($limite < 0)
					$limite = $total;
				
				if(!empty($tipos))
				{
					foreach($tipos as $tipo)
					{
						$sql = "SELECT COUNT(DISTINCT CV.idcandidato) AS CONT FROM candidatovaga CV USE INDEX(idxcandidato, idxvaga) INNER JOIN vaga V ON(CV.idvaga = V.idvaga) LEFT JOIN favorito F FORCE INDEX(idxcandidato) ON(CV.idcandidato = F.idcandidato AND F.idvaga = V.idvaga) LEFT JOIN candidatocontato CC USE INDEX(idxcandidato, idxvaga) ON(CC.idcandidato = CV.idcandidato) WHERE {$filtro} AND CC.tipo = '{$tipo}'";
						$totalContatos = $this->TotalRegistro(false, $sql,false);
						$rows[] = ["acaocandidato"=>$tipo, "texto"=>$tipo, "total"=>$totalContatos];
					}
				}
				
				$sql = "SELECT COUNT(DISTINCT CV.idcandidato) AS CONT FROM candidatovaga CV USE INDEX(idxcandidato, idxvaga) INNER JOIN vaga V ON(CV.idvaga = V.idvaga) LEFT JOIN favorito F FORCE INDEX(idxcandidato) ON(CV.idcandidato = F.idcandidato AND F.idvaga = V.idvaga) LEFT JOIN candidatocontato CC USE INDEX(idxcandidato, idxvaga) ON(CC.idcandidato = CV.idcandidato) WHERE {$filtro} AND CC.idcandidatocontato IS NULL";
				$totalNaoContatos = $this->TotalRegistro(false, $sql,false);

				$rows[] = ["acaocandidato"=>"Não","texto"=>"Sem ação","total"=>$totalNaoContatos];

				if(!empty($rows))
				{
					$rows = array_map(array($this,'Map'), $rows);
					$titulo = __("Sucesso");
					$mensagem = __("Lista de candidatos avaliados foi encontrada com sucesso.");
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
		public function ListaDeContatos($idcandidato = 0, $idvaga = 0)
		{
			$retorno = false;
			try
			{
				if(empty($idcandidato))
					return $retorno;
				$sql = "SELECT CC.idcandidatocontato, CC.idcliente, CC.tipo, CC.cadastradoem, C.nome AS 'cliente'  FROM candidatocontato CC LEFT JOIN cliente C ON(CC.idcliente = C.idcliente) WHERE CC.idcandidato = '{$idcandidato}' AND CC.idvaga = '{$idvaga}' ORDER BY CC.tipo ASC";
				$rows = $this->GetRows(false, $sql);
				if(!empty($rows))
				{
					$rows = array_map(array($this,'Map'), $rows);
				}
				$tipos = $this->ArrayEnum( $this->Tabela, "tipo");
				$lista = false;
				if(!empty($tipos))
				{
					$tiposRows = array_column($rows, 'tipo');
					foreach($tipos as $tipo)
					{
						if(empty($tiposRows))
							$index = false;
						else
							$index = array_search($tipo, $tiposRows);
						if($index === false)
						{
							$lista[] = ["idcandidatocontato"=>0, "idcliente"=>0, "cliente"=>"", "tipo"=>$tipo, "cadastradoem"=>""];
						}
						else
						{
							$lista[] = $rows[$index];
						}
					}
				}
				return $lista;
			}
			catch( Exception $e )
			{
				throw new Exception( $e );
			}
		}
		################################################################################################################
		public function ListaDeContatosExportar($idcandidato = 0, $idvaga = 0)
		{
			$retorno = false;
			try
			{
				if(empty($idcandidato))
					return $retorno;
				$sql = "SELECT CC.tipo, MAX(CC.cadastradoem) AS cadastradoem, C.nome AS 'cliente' FROM candidatocontato CC LEFT JOIN cliente C ON(CC.idcliente = C.idcliente) WHERE CC.idcandidato = '{$idcandidato}' GROUP BY CC.tipo, CC.cadastradoem, C.nome ORDER BY CC.tipo ASC";
				$rows = $this->GetRows(false, $sql);
				$lista = false;
				if(!empty($rows))
				{
					foreach($rows as $row)
					{
						if(emptyData($row['cadastradoem']))
							$row['cadastradoem'] = "";
						else
							$row['cadastradoem'] = date("d/m/Y H:i", TimeData($row['cadastradoem']));
						$lista[] = $row['tipo']." ".$row['cliente']." - ".$row['cadastradoem'];
					}
				}
				return $lista;
			}
			catch( Exception $e )
			{
				throw new Exception( $e );
			}
		}
		################################################################################################################
		public static function Map($row = false)
		{
			$row['idcandidatocontato'] = intval($row['idcandidatocontato']);
			$row['idcliente'] = intval($row['idcliente']);
			if(emptyData($row['cadastradoem']))
				$row['cadastradoem'] = "";
			else
				$row['cadastradoem'] = date("d/m/Y H:i", TimeData($row['cadastradoem']));
			return $row;
		}
		################################################################################################################
		public function MarcarContato()
		{
			$idcandidatocontato = Get("idcandidatocontato", 0);
			$idcandidato = Get("idcandidato", 0);
			$idvaga = Get("idvaga", 0);
			$idcliente = Get("idcliente", 0);
			$deletar = Get("deletar", 0);
			$tipo = Get("tipo", 0);
						
			if(empty($idcandidato))
			{
				$dados['sucesso'] = false;
				$dados['erro'] = __("ID do candidato não foi enviado.");
				return $dados;
			}
			if(empty($idvaga))
			{
				$dados['sucesso'] = false;
				$dados['erro'] = __("ID da vaga não foi enviado.");
				return $dados;
			}
			if(empty($deletar))
			{
				if(empty($idcandidatocontato))
				{
					$obj = GetModelo("candidatocontato");
					$obj->idcandidatocontato = 0;
					$novo = true;
				}
				else
				{
					$filtro  = "idcandidatocontato = '{$idcandidatocontato}'";
					$obj = GetModelo("candidatocontato");
					if(!$obj->Load($filtro))
					{
						$obj->idcandidatocontato = 0;
						$novo = true;
					}
					else
					{						
						$novo = false;
					}
				}
				$obj->idcandidato = $idcandidato;
				$obj->idcliente = $idcliente;
				$obj->idvaga = $idvaga;
				$obj->tipo = $tipo;
				$obj->ip = "";
				$obj->cadastradoem = "";
				$obj->Ajustar(true);
				$id = $obj->Salvar();
				if($id)
				{
					$dados['sucesso'] = true;
					$dados['mensagem'] = __("Sucesso");
					$dados['titulo'] = __("Contato com o candidato foi marcado com sucesso.");
					$dados['idcliente'] = $idcliente;
					$sql = "SELECT nome FROM cliente WHERE idcliente = '{$idcliente}'";
					$dados['cliente'] = self::GetSqlCampo($sql, "nome","");
					$dados['cadastradoem'] = date("d/m/Y H:i", TimeData($obj->cadastradoem));
					if($novo)
					{
						$obj->idcandidatocontato = $id;
					}
					$dados['idcandidatocontato'] = $obj->idcandidatocontato;
				}
				else
				{
					$dados['sucesso'] = false;
					$dados['erro'] = __("Não foi possível registrar o contato com o candidato.");
				}
			}
			else
			{
				if(empty($idcandidatocontato))
				{
					$dados['sucesso'] = false;
					$dados['erro'] = __("Não foi possível apagar o registro do contato com o candidato.");
					return $dados;
				}
				$obj = GetModelo("candidatocontato");
				$obj->idcandidatocontato = $idcandidatocontato;
				if(!$obj->Apagar())
				{
					$dados['sucesso'] = false;
					$dados['erro'] = __("Não foi possível apagar o registro do contato com o candidato.");
				}
				else
				{
					$dados['sucesso'] = true;
					$dados['mensagem'] = __("Sucesso");
					$dados['titulo'] = __("O registro do contato com o candidato foi apagado com sucesso.");
					$dados['idcliente'] = 0;
					$dados['cliente'] = "";
					$dados['idcandidatocontato'] = 0;
				}
			}
			return $dados;
		}
		################################################################################################################
		public function GetCaminho($file = "")
		{
			return $this->SetDominio($file);
		}
		################################################################################################################
		public function __destruct()
		{
			unset($this->dados, $this->Tabela, $this->PrimaryKey);
		}
	}
}
?>