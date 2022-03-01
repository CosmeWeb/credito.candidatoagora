<?php
/***********************************************************************
 * Module:  /models/Cliente_model.PHP
 * Author:  Host-up
 * Date:	18/03/2020 15:21:56
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
				if(emptyData($this->cadastradoem))
					$this->cadastradoem = date("Y-m-d H:i:s");
				else
					$this->cadastradoem = date("Y-m-d H:i:s",TimeData($this->cadastradoem));
				if(empty($this->ip))
					$this->ip = GetIP();
				if(empty($this->idcolaborador))
					$this->idcolaborador = GetAcesso("idcolaborador");
			}
			else
			{
				if(!emptyData($this->cadastradoem))
					$this->cadastradoem = date("d/m/Y H:i:s",TimeData($this->cadastradoem));
			}
		}
		################################################################################################################
		public function GerarOpcoesColaborador($value = "0", $texto = "", $default = "0")
		{
			if(empty($texto))
				$texto = __(" -- Selecione --");
			$primeiro = array("valor"=>$default,"texto"=>$texto);
			$sql = "SELECT idcolaborador AS id, nome AS texto FROM colaborador ORDER BY texto ASC";
			return $this->GeraOpcoesSql($value, $sql, "id", "texto", $primeiro);
		}
		################################################################################################################
		public function VerificarArquivo($arquivo = "")
		{
			$file = $this->SetDominio($arquivo);
			if(!$this->FileExiste($file))
				return __("Arquivo da importação não existe");
			if(filesize($file) <= 0)
				return __("Arquivo da importação está vazio");
			$test = explode('.', strtolower($file));
			$extension = end($test);
			if($extension == "xlsx")
				$excel = GetLibrary('SimpleXLSX');
			elseif($extension == "xls")
				$excel = GetLibrary('Excel');
			elseif($extension == "csv")
				$excel = GetLibrary('SimpleCSV');
			else
				return 0;
			$xlsx = $excel->read($file);
			if($xlsx)
			{
				$linhas = $xlsx->TotaldeLinhas();
				if($linhas <= 0)
				{
					if($extension == "xls")
						if($linhas < 0)
							return __("Arquivo da importação não possui nenhuma linha.");
						else
							return __("Arquivo da importação possui apenas uma linha.");
					else
						return __("Arquivo da importação não possui nenhuma linha.");
				}
				if($linhas == 1)
				{
					return __("Arquivo da importação possui apenas uma linha.");
				}
			}
			else
			{
				if($excel->error == 1)
				{
					return __("Arquivo da importação sem permissão de leitura.");
				}
				if($excel->error == 2)
				{
					return __("Arquivo da importação está vazio.");
				}
				if($excel->error == 3)
				{
					return __("Arquivo da importação está fora do formato do excel, para corrigir este erro você deve salvar o arquivo em uma versão mais recente do excel(*.xlsx).");
				}
			}
			return false;
		}
		################################################################################################################
		public function LerTotalRows($arquivo = "")
		{
			$file = $this->SetDominio($arquivo);
			if(!$this->FileExiste($file))
				return 0;
			$test = explode('.', strtolower($file));
			$extension = end($test);
			if($extension == "xlsx")
				$excel = GetLibrary('SimpleXLSX');
			elseif($extension == "xls")
				$excel = GetLibrary('Excel');
			elseif($extension == "csv")
				$excel = GetLibrary('SimpleCSV');
			else
				return 0;
			$xlsx = $excel->read($file);
			if($xlsx)
			{
				return $xlsx->TotaldeLinhas();
			}
			return 0;
		}
		################################################################################################################
		public function &LerRows($index = 0, $limite = 50, $arquivo = "")
		{
			$retorno = false;
			if(empty($arquivo))
				$arquivo = $this->arquivo;
			$file = $this->SetDominio($arquivo);
			if(!$this->FileExiste($file))
				return $retorno;
			$test = explode('.', strtolower($file));
			$extension = end($test);
			if($extension == "xlsx")
				$excel = GetLibrary('SimpleXLSX');
			elseif($extension == "xls")
				$excel = GetLibrary('Excel');
			elseif($extension == "csv")
				$excel = GetLibrary('SimpleCSV');
			else
				return $retorno;
			$xlsx = $excel->read($file);
			if($xlsx)
			{
				$lista = $xlsx->rows();
				if(empty($lista))
					return $retorno;
				$total = count($lista) - 1;
				if($total <= $index)
					return $retorno;
				$primeira = $lista[0];
				$index ++;
				$total = $index + $limite;
				$linhas = array();
				$totalprimeira = count($primeira);
				for($i = $index; $i < $total; $i++)
				{
					$num = count($lista[$i]);
					if($num != $totalprimeira )
					{
						for($j = $index; $j < $totalprimeira; $j++)
						{
							if(!isset($lista[$i][$j]))
								$lista[$i][$j] = "";
						}
					}
					$linhas[] = array_combine($primeira, $lista[$i]);
				}
				return $linhas;
			}
			return $retorno;
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
			if(empty($dados['cliente']))
				return;
			$filtro = "cliente = '{$dados['cliente']}'";
			$obj = $this->FiltroObjeto($filtro);
			if(empty($obj))
			{
				$obj = $this->GetInstancia();
				$obj->cliente = $dados['cliente'];
			}
			//P($obj);
			$obj->Salvar();
			return;
		}
		################################################################################################################
		public function ExportarCliente()
		{
			$filtro = $this->Filtro(true);
			$filtro .= " ORDER BY C.nome ASC";
			$obj = GetModelo('cliente');
			$sql = "SELECT * FROM cliente C";
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
				$dados['mensagem'] = __("Verificação de cliente foi finalizada.<br/>O download se iniciará em instantes");
				$dados['url'] = site_url("cliente/baixarcliente/{$file}");
				$dados['titulo'] = __("Exportação de cliente");
			}
			else
			{
				$dados['sucesso'] = false;
				$dados['erro'] = __("Nenhum e-mail deste arquivo enviado foi encontrado.");
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
		public function GetNomesCampos()
		{
			$campos = array("ID"=>"idcliente","cliente"=>"cliente");
			return $campos;
		}
		################################################################################################################
		public function GetCaminho($file = "")
		{
			return $this->SetDominio($file);
		}
		################################################################################################################
		public function GetSqlLista()
		{
			return "SELECT * FROM cliente C";
		}
		################################################################################################################
		public function GetSqlTotalLista()
		{
			return "SELECT COUNT(DISTINCT C.idcliente) AS CONT FROM cliente C";
		}
		################################################################################################################
		public function Filtro($semOrder = false)
		{
			$filtro = "";
			$buscar = GetFiltro("buscar");
			if(!empty($buscar))
			{
				$filtro .= " AND (C.nome LIKE '%{$buscar}%')";
			}
			$cadastradoinicio = GetFiltro("cadastradoinicio");
			if(!empty($cadastradoinicio))
			{
				$data = date("Y-m-d 00:00:00", TimeData($cadastradoinicio));
				$filtro .= " AND C.cadastradoem >= '{$data}'";
			}
			$cadastradofim = GetFiltro("cadastradofim");
			if(!empty($cadastradofim))
			{
				$data = date("Y-m-d 23:59:59", TimeData($cadastradofim));
				$filtro .= " AND C.cadastradoem <= '{$data}'";
			}
			$idcolaborador = GetFiltro("idcolaborador");
			if(!empty($idcolaborador))
			{
				$filtro .= " AND C.idcolaborador = '{$idcolaborador}'";
			}
			if(!empty($filtro))
			{
				$filtro  = substr($filtro, 4);
			}
			if($semOrder)
			{
				return $filtro;
			}
			$ordem = array('C.idcliente', 'C.nome', 'C.logo', 'C.cadastradoem','C.idcliente');
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
		public function GetURL($thumb = false, $fisico = false)
		{
			if(empty($this->logo))
				return "";
			if(!$thumb)
			{
				$url = "{$this->logo}";
				if($fisico)
					$file = $this->SetDominio($url);
				else
					$file = $this->SetURL($url);
			}
			else
			{
				$url = "thumb/{$this->logo}";
				if($fisico)
					$file = $this->SetDominio($url);
				else
					$file = $this->SetURL($url);
			}
			return $file;
		}
		################################################################################################################
		public function GetLogo($thumb = false)
		{
			if(empty($this->logo))
				return $this->GetLogoPadrao();
			$file = $this->GetURL($thumb, true);
			if(!$thumb)
			{
				if(!$this->FileExiste($file))
					return $this->GetLogoPadrao();
			}
			else
			{
				if(!$this->FileExiste($file))
				{
					if(!$this->GerarThumb())
						return $this->GetLogoPadrao();
				}
			}
			return $this->GetURL($thumb);
		}
		################################################################################################################
		public function TemLogo($thumb = false)
		{
			if(empty($this->logo))
				return false;
			$file = $this->GetURL($thumb, true);
			if(!$thumb)
			{
				if(!$this->FileExiste($file))
					return false;
			}
			else
			{
				if(!$this->FileExiste($file))
				{
					return false;
				}
			}
			return true;
		}
		################################################################################################################
		public function GerarThumb()
		{
			if(empty($this->logo))
				return false;
			$file =  $this->GetURL(true, true);
			if(!$this->FileExiste($file))
			{
				$filePadrao = $this->GetURL(false, true);
				if(!$this->FileExiste($filePadrao))
					return false;
				CriarPastas(dirname($file), 0755);
				$CI =& get_instance();
				$CI->load->library('image');
				$imagem = $CI->image->carrega($filePadrao);
				$imagem->resize(128,0,"w");
				$imagem->save($file);
			}
			return true;
		}
		################################################################################################################
		public function deletarLogo()
		{
			if(empty($this->logo))
				return false;
			$file =  $this->GetURL(true, true);
			if($this->FileExiste($file))
			{
				unlink($file);
			}
			$file =  $this->GetURL(false, true);
			if($this->FileExiste($file))
			{
				unlink($file);
			}
			return true;
		}
		################################################################################################################
		public function GetLogoPadrao()
		{
			return $this->SetPadrao("logo.jpg");
		}
		################################################################################################################
		public function GetAvatar()
		{
			if($this->TemLogo())
			{
				return $this->GetLogo();
			}
			else
			{
				return $this->SetPadrao("logo.jpg");
			}
			
		}
		################################################################################################################
		public function GetClientes()
		{
			$sql = "SELECT * FROM cliente WHERE logo != '' ORDER BY nome ASC";
			$Rows = $this->FiltroJson(false, $sql);
			return $Rows;
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
					$dados['cadastradoem'] = date("d/m/Y H:i", TimeData($dados['cadastradoem']));
				else
					$dados['cadastradoem'] = "";
				$dados['linklogo'] = base_url("arquivos/cliente/".$dados['logo']);
				return $dados;
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
				return GetDomino('index.php/vaga/dashboard/');		
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