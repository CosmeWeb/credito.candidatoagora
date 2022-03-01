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
		public function GerarPainel($posicao = 0)
		{
			$curriculo = GetModelo("curriculo");
			$dados = $curriculo->LerTotalCurriculo($posicao);
			$sql = "SELECT * FROM painel ORDER BY idpainel DESC LIMIT 1;";
			$obj = $this->FiltroObjeto(false, $sql);
			if(empty($obj))
				$obj = $this->GetInstancia();
			$obj->Carregar($dados);
			$obj->data = date("d/m/Y H:i:s");
			$obj->Ajustar(true);
			return $obj->Salvar();
		}
		################################################################################################################
		public function &LerPainel()
		{
			$sql = "SELECT * FROM painel ORDER BY idpainel DESC LIMIT 1;";
			$retorno = $this->LerCacheSQl("painel", $sql);
			return $retorno;
		}
		################################################################################################################
		public function SetarCampo($nome = "", $valor = "")
		{
			$sql = "SELECT * FROM painel ORDER BY idpainel DESC LIMIT 1;";
			$obj = $this->FiltroObjeto(false, $sql);
			if(empty($obj))
				$obj = $this->GetInstancia();
			$dados[$nome] = $valor;
			return $obj->Atualizar($obj->GetID(), $dados);
		}
		################################################################################################################
		public function LerCacheSQl($nome = "", $sql = "")
		{
			$retorno = 0;
			try
			{
				static $segundo = 300;
				$CI =& get_instance();
				$row = 0;
				if($CI->cache->memcached->is_supported())
				{
					if (!$row = $CI->cache->memcached->get($nome)) {
						$row = $this->GetRow(false, $sql);
						$CI->cache->memcached->save($nome, $row, $segundo);
					}
				}
				elseif($CI->cache->apc->is_supported())
				{
					if (!$row = $CI->cache->apc->get($nome)) {
						$row = $this->GetRow(false, $sql);
						$CI->cache->apc->save($nome, $row, $segundo);
					}
				}
				elseif($CI->cache->file->is_supported())
				{
					if (!$row = $CI->cache->file->get($nome)) {
						$row = $this->GetRow(false, $sql);
						$CI->cache->file->save($nome, $row, $segundo);
					}
				}
				else
				{
					$row = $this->GetRow(false, $sql);
				}
				return $row;
			}
			catch( Exception $e )
			{
				throw new Exception( $e );
				return $retorno;
			}
		}
		################################################################################################################
		public function GerarCurriculoPorCidade($posicao = 0, $total = 0)
		{
			$curriculo = GetModelo("curriculo");
			$limite = 10;
			if(empty($total))
			{
				$this->Query("TRUNCATE `curriculoporcidade`");
				$total = $curriculo->TotalCurriculoPorCidade();
			}
			$lista = $curriculo->ListaCurriculoPorCidade($posicao, $limite);
			if(empty($lista))
			{
				return false;
			}
			$resultado = $this->SalvarListaDeCurriculosPorCidade($lista);
			if(empty($resultado))
			{
				return false;
			}
			$aux = $posicao + $limite;
			if($aux >= $total)
				$dados['finalizado'] = true;
			else
				$dados['finalizado'] = false;
			$dados['posicao'] = $aux;
			$dados['total'] = $total;
			$dados['mensagem'] = __("Processando dados currículos por cidade");
			$dados['sucesso'] = true;
			return $dados;
		}
		################################################################################################################
		public function SalvarListaDeCurriculosPorCidade($lista = false)
		{
			if(empty($lista))
			{
				return false;
			}
			if(!is_array($lista))
			{
				return false;
			}
			foreach ($lista as $key=>$row)
			{
				if(!$this->SalvarCurriculosPorCidade($row))
					return false;
			}
			return true;
		}
		################################################################################################################
		public function SalvarCurriculosPorCidade($dados = false)
		{
			if(empty($dados))
			{
				return false;
			}
			if(!is_array($dados))
			{
				return false;
			}
			$this->db->insert("curriculoporcidade", $dados);
			
			return $this->db->insert_id();
		}
		################################################################################################################
		public function GerarNivelPorCidade($posicao = 0, $total = 0)
		{
			$curriculo = GetModelo("curriculo");
			$limite = 10;
			if(empty($total))
			{
				$this->Query("TRUNCATE `nivelporcidade`");
				$total = $curriculo->TotalCurriculoPorCidade();
			}
			$lista = $curriculo->ListaNivelPorCidade($posicao, $limite);
			if(empty($lista))
			{
				return false;
			}
			$resultado = $this->SalvarListaDeNiveisPorCidade($lista);
			if(empty($resultado))
			{
				return false;
			}
			$aux = $posicao + $limite;
			if($aux >= $total)
				$dados['finalizado'] = true;
			else
				$dados['finalizado'] = false;
			$dados['posicao'] = $aux;
			$dados['total'] = $total;
			$dados['mensagem'] = __("Processando dados nível por cidade");
			$dados['sucesso'] = true;
			return $dados;
		}
		################################################################################################################
		public function SalvarListaDeNiveisPorCidade($lista = false)
		{
			if(empty($lista))
			{
				return false;
			}
			if(!is_array($lista))
			{
				return false;
			}
			foreach ($lista as $key=>$row)
			{
				if(!$this->SalvarNiveisPorCidade($row))
					return false;
			}
			return true;
		}
		################################################################################################################
		public function SalvarNiveisPorCidade($dados = false)
		{
			if(empty($dados))
			{
				return false;
			}
			if(!is_array($dados))
			{
				return false;
			}
			$this->db->insert("nivelporcidade", $dados);
			
			return $this->db->insert_id();
		}
		################################################################################################################
		public function GerarAreaPorCidade($posicao = 0, $total = 0)
		{
			$curriculo = GetModelo("curriculo");
			$limite = 10;
			if(empty($total))
			{
				$this->Query("TRUNCATE `areaporcidade`");
				$total = $curriculo->TotalCurriculoPorCidade();
			}
			$lista = $curriculo->ListaAreaPorCidade($posicao, $limite);
			if(empty($lista))
			{
				return false;
			}
			$resultado = $this->SalvarListaDeAreaPorCidade($lista);
			if(empty($resultado))
			{
				return false;
			}
			$aux = $posicao + $limite;
			if($aux >= $total)
				$dados['finalizado'] = true;
			else
				$dados['finalizado'] = false;
			$dados['posicao'] = $aux;
			$dados['total'] = $total;
			$dados['mensagem'] = __("Processando dados área por cidade");
			$dados['sucesso'] = true;
			return $dados;
		}
		################################################################################################################
		public function GerarEstatisticaProjeto($posicao = 0, $total = 0)
		{
			$projeto = GetModelo("projeto");
			$limite = 2;
			$limiteTotal = 10;
			if(empty($total))
			{
				$this->Query("TRUNCATE `projetoestatistica`");
				$this->Query("TRUNCATE `estatisticafases`");
				$total = $projeto->TotalRegistro();
				if($total > $limiteTotal)
					$total = $limiteTotal;
				elseif($total <= 0)
				{
					$dados['finalizado'] = true;
					$dados['posicao'] = 0;
					$dados['total'] = 0;
					$dados['mensagem'] = __("Nenhum projeto a ser processado.");
					$dados['sucesso'] = true;
					return $dados;
				}
				
			}
			$resultado = $projeto->GerarEstatisticaProjeto($posicao, $limite);
			
			if(empty($resultado))
			{
				return false;
			}
			$aux = $posicao + $limite;
			if($aux >= $total)
				$dados['finalizado'] = true;
			else
				$dados['finalizado'] = false;
			$dados['posicao'] = $aux;
			$dados['total'] = $total;
			$dados['mensagem'] = __("Processando dados dos projetos");
			$dados['sucesso'] = true;
			return $dados;
		}
		################################################################################################################
		public function GerarNivelPorArea($posicao = 0, $total = 0)
		{
			$curriculo = GetModelo("curriculo");
			$limite = 3;
			if(empty($total))
			{
				$this->Query("TRUNCATE `nivelporarea`");
				$sql = "SELECT COUNT(*) AS CONT FROM areaporcidade;";
				$total = $curriculo->TotalRegistro(false, $sql);
			}
			$lista = $curriculo->GerarNivelPorArea($posicao, $limite);
			if(empty($lista))
			{
				return false;
			}
			$resultado = $this->SalvarListaDeNivelPorArea($lista);
			if(empty($resultado))
			{
				return false;
			}
			$aux = $posicao + $limite;
			if($aux >= $total)
				$dados['finalizado'] = true;
			else
				$dados['finalizado'] = false;
			$dados['posicao'] = $aux;
			$dados['total'] = $total;
			$dados['mensagem'] = __("Processando dados nível por área");
			$dados['sucesso'] = true;
			return $dados;
		}
		################################################################################################################
		public function SalvarListaDeAreaPorCidade($lista = false)
		{
			if(empty($lista))
			{
				return false;
			}
			if(!is_array($lista))
			{
				return false;
			}
			foreach ($lista as $key=>$row)
			{
				if(!$this->SalvarAreaPorCidade($row))
					return false;
			}
			return true;
		}
		################################################################################################################
		public function SalvarAreaPorCidade($dados = false)
		{
			if(empty($dados))
			{
				return false;
			}
			if(!is_array($dados))
			{
				return false;
			}
			$this->db->insert("areaporcidade", $dados);
			
			return $this->db->insert_id();
		}
		################################################################################################################
		public function SalvarListaDeNivelPorArea($lista = false)
		{
			if(empty($lista))
			{
				return false;
			}
			if(!is_array($lista))
			{
				return false;
			}
			foreach ($lista as $key=>$row)
			{
				if(!$this->SalvarNivelPorArea($row))
					return false;
			}
			return true;
		}
		################################################################################################################
		public function SalvarNivelPorArea($dados = false)
		{
			if(empty($dados))
			{
				return false;
			}
			if(!is_array($dados))
			{
				return false;
			}
			$this->db->insert("nivelporarea", $dados);
			
			return $this->db->insert_id();
		}
		################################################################################################################
		public function &ListaporEstado()
		{
			$retorno = false;
			try
			{
				$sql = "SELECT estado, SUM(curriculos) curriculos, SUM(porcentagem) porcentagem FROM curriculoporcidade GROUP BY estado ORDER BY curriculos DESC LIMIT 10";
				$rows = $this->GetRows(false, $sql );
				
				return $rows;
			}
			catch (Exception $e)
			{
				throw new Exception($e);
				return $ret;
			}
		}
		################################################################################################################
		public function &ListaNiveis($estado = "", $cidade = "")
		{
			$retorno = false;
			try
			{
				$filtro = "";
				if(!empty($estado))
				{
					$filtro .= " AND estado = '{$estado}'";
				}
				if(!empty($cidade))
				{
					$filtro .= " AND cidade = '{$cidade}'";
				}
				if(!empty($filtro))
				{
					$filtro = " WHERE 1 {$filtro}";
				}
				$sql = "SELECT nivel, SUM(curriculos) curriculos, SUM(porcentagem) porcentagem FROM nivelporcidade {$filtro} GROUP BY nivel ORDER BY curriculos DESC LIMIT 10";
				$rows = $this->GetRows(false, $sql );
				return $rows;
			}
			catch (Exception $e)
			{
				throw new Exception($e);
				return $ret;
			}
		}
		################################################################################################################
		public function &ListaArea($estado = "", $cidade = "")
		{
			$retorno = false;
			try
			{
				$filtro = "";
				if(!empty($estado))
				{
					$filtro .= " AND estado = '{$estado}'";
				}
				if(!empty($cidade))
				{
					$filtro .= " AND cidade = '{$cidade}'";
				}
				if(!empty($filtro))
				{
					$filtro = " WHERE 1 {$filtro}";
				}
				$sql = "SELECT area, SUM(curriculos) curriculos, SUM(porcentagem) porcentagem FROM areaporcidade {$filtro} GROUP BY area ORDER BY curriculos DESC LIMIT 10";
				$rows = $this->GetRows(false, $sql );
				
				return $rows;
			}
			catch (Exception $e)
			{
				throw new Exception($e);
				return $ret;
			}
		}
		################################################################################################################
		public function &ListaAreaNivel($estado = "", $cidade = "")
		{
			$retorno = false;
			try
			{
				$filtro = "";
				if(!empty($estado))
				{
					$filtro .= " AND estado = '{$estado}'";
				}
				if(!empty($cidade))
				{
					$filtro .= " AND cidade = '{$cidade}'";
				}
				if(!empty($filtro))
				{
					$filtro = " WHERE 1 {$filtro}";
				}
				$sql = "SELECT idareaporcidade, area, SUM(curriculos) total, nome FROM areaporcidade {$filtro} GROUP BY area ORDER BY total DESC LIMIT 50";
				$rows = $this->GetRows(false, $sql );
				if(empty($rows))
					return $retorno;
				$lista = GetModelo('curriculo')->LerListadeNivel();
				$lista[] = "Outros";
				foreach($rows as $key=>$row)
				{
					$sql = "SELECT nivel, total FROM nivelporarea WHERE idareaporcidade = '{$row['idareaporcidade']}'";
					$niveis = $this->GetRows(false, $sql );
					if(empty($niveis))
					{
						foreach($lista as $chave=>$valor)
						{
							$nivel = AcertaNomeArquivo($valor);
							$rows[$key][$nivel] = 0;
						}
						continue;
					}
					foreach($niveis as $chave=>$linha)
					{
						$nivel = AcertaNomeArquivo($linha['nivel']);
						$rows[$key][$nivel] = $linha['total'];
					}
				}
				
				return $rows;
			}
			catch (Exception $e)
			{
				throw new Exception($e);
				return $ret;
			}
		}
		################################################################################################################
		public function &ListaCurriculoPorCidade($estado = "", $limite = 10)
		{
			$retorno = false;
			try
			{
				if(!empty($estado))
				{
					$filtro = " WHERE estado = '{$estado}'";
				}
				else
					$filtro = "";
				$sql = "SELECT ";
				$sql .= " nome, curriculos, porcentagem";
				$sql .= " FROM curriculoporcidade";
				$sql .= $filtro;
				$sql .= " ORDER BY curriculos DESC LIMIT {$limite}";
				$rows = $this->GetRows(false, $sql );
				
				return $rows;
			}
			catch (Exception $e)
			{
				throw new Exception($e);
				return $ret;
			}
		}
		################################################################################################################
		public function &ListaNivelPorCidade($estado = "", $limite = 10)
		{
			$retorno = false;
			try
			{
				if(!empty($estado))
				{
					$filtro = " WHERE estado = '{$estado}'";
				}
				else
					$filtro = "";
				$sql = "SELECT ";
				$sql .= " nome, curriculos, porcentagem";
				$sql .= " FROM curriculoporcidade";
				$sql .= $filtro;
				$sql .= " ORDER BY curriculos DESC LIMIT {$limite}";
				$rows = $this->GetRows(false, $sql );
				
				return $rows;
			}
			catch (Exception $e)
			{
				throw new Exception($e);
				return $ret;
			}
		}
		################################################################################################################
		public function Ajustar($salvar = false)
		{
			if($salvar)
			{
				if(emptyData($this->data))
					$this->data = date("Y-m-d H:i:s");
				else
					$this->data = date("Y-m-d H:i:s", TimeData($this->data));
				if(!emptyData($this->dataultimobackup))
					$this->dataultimobackup = date("Y-m-d H:i:s", TimeData($this->dataultimobackup));
				if(!emptyData($this->dataultimocopia))
					$this->dataultimocopia = date("Y-m-d H:i:s", TimeData($this->dataultimocopia));
			}
			else
			{
				if(!emptyData($this->data))
					$this->data = date("d/m/Y H:i:s", TimeData($this->data));
				if(!emptyData($this->dataultimobackup))
					$this->dataultimobackup = date("d/m/Y H:i:s", TimeData($this->dataultimobackup));
				if(!emptyData($this->dataultimocopia))
					$this->dataultimocopia = date("d/m/Y H:i:s", TimeData($this->dataultimocopia));
			}
		}
		################################################################################################################
		public function TotalCurriculos()
		{
			$sql = "SELECT COUNT(*) CONT FROM curriculo";
			return $this->TotalRegistro(false, $sql);
		}
		################################################################################################################
		public function TotalCurriculosEmpresaPadronizada()
		{
			$sql = "SELECT COUNT(DISTINCT CC.idcurriculo) AS CONT FROM curriculocache CC LEFT JOIN opentextempresapadronizada OEP ON(CC.idcurriculo=OEP.idcurriculo)";
			$sql .= " WHERE (ISNULL(NULLIF(OEP.idempresapadronizada,'')) = 0 AND OEP.verificado = 'Sim')";
			
			return $this->TotalRegistro(false, $sql);
		}
		################################################################################################################
		public function TotalCurriculosAutorizados()
		{
			$sql = "SELECT COUNT(*) CONT FROM curriculocache WHERE ISNULL(NULLIF(autorizado,'')) = 0";
			return $this->TotalRegistro(false, $sql);
		}
		################################################################################################################
		public function __destruct()
		{
			unset($this->dados, $this->Tabela, $this->PrimaryKey);
		}
	}
}
?>