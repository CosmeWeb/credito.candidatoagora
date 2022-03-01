<?php
/***********************************************************************
 * Module:  /models/Cliente_model.PHP
 * Author:  Host-up
 * Date:	13/05/2020 21:03:18
 * Purpose: Definição da Classe Cliente_model
 * Instancias: $this->load->model('Cliente_model', 'cliente');
 * Objeto: $cliente = $this->cliente->GetInstancia($dados);
 ***********************************************************************/
if (!class_exists('Cliente_model'))
{
	class Cliente_model extends MY_Model
	{
		################################################################################################################
		public function __construct( $dados = false)
		{
			try
			{
				$this->Tabela = "cliente";
				$this->PrimaryKey = "idcliente";
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
				if(empty($this->idcliente))
					$this->senha = $this->Encrypt($this->senha);
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
		public function GerarOpcoesStatus($value = "Ativo", $texto = "", $default = "Ativo")
		{
			if(empty($texto))
				$texto = __("-- Selecione --");
			$primeiro = array("valor"=>$default,"texto"=>$texto);
			return $this->GeraOpcoesEnum($value, $this->Tabela, "status", $primeiro);
		}
		################################################################################################################
		public function GerarOpcoesAcesso($value = "", $texto = "", $default = "")
		{
			if(empty($texto))
				$texto = __("-- Selecione --");
			$primeiro = array("valor"=>$default,"texto"=>$texto);
			return $this->GeraOpcoesEnum($value, $this->Tabela, "acesso", $primeiro);
		}
		################################################################################################################
		public function GerarOpcoesClientes($value = "0", $texto = "", $default = "0")
		{
			if(empty($texto))
				$texto = __("-- Selecione --");
			$primeiro = array("valor"=>$default,"texto"=>$texto);
			$sql = "SELECT idcliente AS 'id', CONCAT(nome,' (',empresa,')') AS 'texto' FROM cliente ORDER BY texto ASC";
			return $this->GeraOpcoesSql($value, $sql, "id", "texto", $primeiro);
		}
		################################################################################################################
		public function GerarOpcoesEmpresaClientes($value = "0", $texto = "", $default = "0")
		{
			if(empty($texto))
				$texto = __("-- Selecione --");
			$primeiro = array("valor"=>$default,"texto"=>$texto);
			$sql = "SELECT DISTINCT empresa AS 'texto' FROM cliente ORDER BY texto ASC";
			return $this->GeraOpcoesSql($value, $sql, "texto", "texto", $primeiro);
		}
		################################################################################################################
		public function GetSqlLista()
		{
			$retorno = "";
			try
			{
				return "SELECT * FROM cliente ";
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
				return "SELECT COUNT(*) AS CONT FROM cliente ";
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
				$filtro .= " AND (nome LIKE '%{$buscar}%' OR email LIKE '%{$buscar}%' OR empresa LIKE '%{$buscar}%')";
			}
			$status = GetFiltro("status");
			if(!empty($status))
			{
				$filtro .= " AND status = '{$status}'";
			}
			$acesso = GetFiltro("acesso");
			if(!empty($acesso))
			{
				$filtro .= " AND acesso = '{$acesso}'";
			}
			$cadastradoeminicio = GetFiltro("cadastradoeminicio");
			if(!empty($cadastradoeminicio))
			{
				$data = date("Y-m-d", TimeData($cadastradoeminicio));
				$filtro .= " AND cadastradoem >= '{$data}'";
			}
			$cadastradoemfim = GetFiltro("cadastradoemfim");
			if(!empty($cadastradoemfim))
			{
				$data = date("Y-m-d", TimeData($cadastradoemfim));
				$filtro .= " AND cadastradoem <= '{$data}'";
			}
			if(!empty($filtro))
			{
				$filtro  = substr($filtro, 4);
			}
			if($semOrder)
			{
				return $filtro;
			}
			$ordem = array('idcliente', 'nome', 'email', 'acesso', 'status', 'cadastradoem', 'idcliente');
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
			$obj = GetModelo("cliente");
			if(empty($obj))
				return $retorno;
			foreach ($lista as $key=>$linha)
			{
				$obj->SalvarListaCliente($linha);
			}
			return true;
		}
		################################################################################################################
		public function SalvarListaCliente($dados = false)
		{
			if(empty($dados))
				return;
			$cliente = self::GetDadosChave($dados, array('cliente','cliente'));
			if(empty($cliente))
				return;
			$filtro = "cliente = '{$cliente}'";
			$obj = $this->FiltroObjeto($filtro);
			if(empty($obj))
			{
				$obj = $this->GetInstancia();
				$obj->cliente = $cliente;
			}
			$obj->Ajustar(true);
			$obj->Salvar();
			return;
		}
		################################################################################################################
		public function ExportarCliente()
		{
			$filtro = $this->Filtro(true);
			$filtro .= " ORDER BY cliente ASC";
			$obj = GetModelo('cliente');
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
				$dados['mensagem'] = __("Verificação de cliente foi finalizado.<br/>O download se iniciará em instantes");
				$dados['url'] = site_url("cliente/baixarcliente/{$file}");
				$dados['titulo'] = __("Exportação de cliente");
			}
			else
			{
				$dados['sucesso'] = false;
				$dados['erro'] = __("Nenhum cliente foi encontrado.");
			}
			return $dados;
		}
		################################################################################################################
		public function GetNomeFile()
		{
			$retorno = "exportacaocliente_".date("Y-m-d_H-i-s").".xls";
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
		public function Encrypt($codigo = "")
		{
			$retorno = sha1(md5(gerarSenha(8)));
			try
			{
				if(empty($codigo))
					return $retorno;
				return sha1(md5($codigo));
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
			$campos = array(
				"ID"=>"idcliente",
				"nome"=>"nome",
				"email"=>"email",
				"empresa"=>"empresa",
				"status"=>"status",
				"acesso"=>"acesso",
				"concordo"=>"concordo",
				"manterconectado"=>"manterconectado",
				"ip"=>"ip",
				"cadastrado em"=>"cadastradoem"
			);
			return $campos;
		}
		################################################################################################################
		public function GetCaminho($file = "")
		{
			return $this->SetDominio($file);
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
				if(!emptyData($dados['cadastradoem']))
					$dados['cadastradoem'] = date("d/m/Y H:i:s", TimeData($dados['cadastradoem']));
				else
					$dados['cadastradoem'] = "";
				return $dados;
			}
			catch( Exception $e )
			{
				throw new Exception( $e );
				return $retorno;
			}
		}
		#######################################################################################################
		public function EmailExiste()
		{
			if(empty($this->email))
			{
				return false;
			}
			$id = $this->GetID();
			if(empty($id))
				$filtro = "email = '{$this->email}'";
			else
				$filtro = "email = '{$this->email}' AND {$this->PrimaryKey} != '{$id}'";
			return $this->Existe($filtro);
		}
		################################################################################################################
		public function &Login($email = "", $senha = "")
		{
			$retorno = false;
			try
			{
				if(empty($email))
				{
					return $retorno;
				}
				if(empty($senha))
				{
					return $retorno;
				}
				$senha = $this->Encrypt($senha);
				$filtro = "email = '{$email}' AND senha = '{$senha}' AND status = 'Ativo'";
				return $this->FiltroObjeto($filtro);
			}
			catch( Exception $e )
			{
				throw new Exception( $e );
				return $retorno;
			}
		}
		################################################################################################################
		public function SetManterConectado($manterconectado = "", $senha = "")
		{
			$retorno = false;
			try
			{
				$id = $this->GetID();
				if(empty($manterconectado))
				{
					return $retorno;
				}
				if(empty($id))
				{
					return $retorno;
				}
				if($manterconectado == "Sim")
				{
					$this->Atualizar($id, array('manterconectado'=>'Sim'));
				}
				else
				{
					$this->Atualizar($id, array('manterconectado'=>'Não'));
				}
			}
			catch( Exception $e )
			{
				throw new Exception( $e );
				return $retorno;
			}
		}
		################################################################################################################
		public function GetLinkAbertura()
		{
			$retorno = false;
			try
			{
				$id = GetAcesso("idcliente");
				if(empty($id))
				{
					return GetDomino("index.php");
				}
				$sql = "SELECT COUNT(*) AS CONT FROM vaga WHERE idcliente = '{$id}'";
				$total = $this->TotalRegistro(false, $sql);
				if(empty($total))
				{
					return GetDomino('index.php/vaga/novavaga/');
				}
				else
				{
					return GetDomino('index.php/vaga/dashboard/');
				}				
			}
			catch( Exception $e )
			{
				throw new Exception( $e );
				return $retorno;
			}
		}
		################################################################################################################
		public function AlterarSenha()
		{
			$retorno = false;
			try
			{
				$id = Get("idcliente", 0);
				if(empty($id))
				{
					$dados['sucesso'] = false;
					$dados['erro'] = __("Erro ao enviar o indentificador do cliente.");
					return $dados;
				}
				$senha = Get("senha","");
				if(empty($senha))
				{
					$dados['sucesso'] = false;
					$dados['erro'] = __("Erro ao enviar a nova senha do cliente.");
					return $dados;
				}
				$obj = GetModelo("cliente");
				$obj->idcliente = $id;
				if(!$obj->Load())
				{
					$dados['sucesso'] = false;
					$dados['erro'] = __("Erro ao localizar o cliente.");
					return $dados;
				}
				else
				{
					$senha = $obj->Encrypt($senha);
					$data = ["senha"=>$senha];
					$retorno = $obj->Atualizar($id, $data);
					if(empty($retorno))
					{
						$dados['sucesso'] = false;
						$dados['erro'] = __("Não foi possivel alterar a senha do cliente.");						
					}
					else
					{
						$dados['sucesso'] = true;
						$dados['titulo'] = __("Sucesso.");
						$dados['mensagem'] = __("Senha foi alterada com sucesso.");
						$dados['url'] = site_url('cliente/listar/');
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
		public function &BuscarFiltrosDeClientes()
		{
			$filtro = "";
			$search =  Get("search","");
			$empresa =  Get("empresa","");
			if(!empty($search))
			{
				$filtro .= " AND (nome LIKE '%{$search}%' OR email LIKE '%{$search}%')";
			}
			if(!empty($empresa))
			{
				$filtro .= " AND (empresa = '{$empresa}')";
			}
			if(!empty($filtro))
			{
				$filtro  = " WHERE ".substr($filtro, 4);
			}
			$sql = "SELECT idcliente AS 'id', IF(empresa = '',nome, CONCAT(nome,' (',empresa,')')) AS 'text' FROM cliente {$filtro} ORDER BY text ASC";
			$lista = $this->GetRows(false, $sql);
			return $lista;
		}
		################################################################################################################
		public function LerIdCliente($nome = "")
		{
			if(empty($nome))
			{
				return 0;
			}
			$aux = Escape($nome);
			$sql = "SELECT idcliente FROM cliente WHERE nome = '{$aux}' LIMIT 1";
			$id = $this->GetSqlCampo($sql,"idcliente", 0);
			if(empty($id))
			{
				return 0;
			}
			return $id;
		}
		################################################################################################################
		public function __destruct()
		{
			unset($this->dados, $this->Tabela, $this->PrimaryKey);
		}

	}
}
?>
