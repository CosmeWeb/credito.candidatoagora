<?php
/***********************************************************************
 * Module:  /models/Candidatoidioma_model.PHP
 * Author:  Host-up
 * Date:	21/11/2020 20:14:49
 * Purpose: Definição da Classe Candidatoidioma_model
 * Instancias: $this->load->model('Candidatoidioma_model', 'candidatoidioma');
 * Objeto: $candidatoidioma = $this->candidatoidioma->GetInstancia($dados);
 ***********************************************************************/
if (!class_exists('Candidatoidioma_model'))
{
	class Candidatoidioma_model extends MY_Model
	{
		private static $_idioma = null;
		################################################################################################################
		public function __construct( $dados = false)
		{
			try
			{
				$this->Tabela = "candidatoidioma";
				$this->PrimaryKey = "idcandidatoidioma";
				parent::__construct($dados);
			}
			catch( Exception $e )
			{
				throw new Exception( $e );
			}
		}
		################################################################################################################
		public static function &NewIdioma() {
			if (self::$_idioma == null)
				self::$_idioma = GetModelo("idioma");
			return self::$_idioma;
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
		public function &LerCandidatosComIdiomas()
		{
			$retorno = false;
			try
			{
				$obj = GetModelo("candidatoidioma");
				if(empty($obj))
				{					
					$dados['sucesso'] = false;
					$dados['erro'] = __("Nenhum candidato com idioma foi encontrado no momento.");
				}
				else
				{
					$idvaga = intval(Get("idvaga",0));
					$lista = $obj->GetCandidatosComIdiomas($idvaga);

					$dados['sucesso'] = true;
					$dados['lista'] = $lista;
					$dados['mensagem'] = __("Total de candidatos com idioma avaliados foi encontrados.");;
					$dados['titulo'] = __("Sucesso");
				}

				return $dados;
			}
			catch( Exception $e )
			{
				throw new Exception( $e );
			}
		}
		################################################################################################################
		public function &GetCandidatosComIdiomas($idvaga = 0)
		{
			$retorno = false;
			try
			{
				$temVaga = "";
				if(!empty($idvaga))
				{
					if($idvaga > 0)
						$temVaga = " AND CV.idvaga = '{$idvaga}'";	
				}

				$sql = "SELECT COUNT(DISTINCT CV.idcandidato) AS CONT FROM candidatovaga CV 
				INNER JOIN candidato C ON(C.idcandidato = CV.idcandidato) 
				LEFT JOIN favorito F FORCE INDEX(idxcandidato) ON(CV.idcandidato = F.idcandidato AND F.idvaga = CV.idvaga)";

				$filtro = " (F.tipo != 'Desconsiderado' OR F.idfavorito IS NULL){$temVaga} ";
				$total = $this->TotalRegistro($filtro, $sql);
				$total = intval($total);

				$lista[] = ["idioma"=>"Total de candidatos","total"=>$total];
				
				$sql = "SELECT I.idioma, COUNT(DISTINCT CI.idcandidato) AS 'total' FROM idioma I 
				LEFT JOIN candidatoidioma CI USE INDEX(idxidioma, idxcandidato) ON(CI.ididioma = I.ididioma) 
				LEFT JOIN candidatovaga CV USE INDEX(idxcandidato, idxvaga) ON(CI.idcandidato = CV.idcandidato)
				LEFT JOIN favorito F FORCE INDEX(idxcandidato, idxvaga) ON(CV.idcandidato = F.idcandidato AND F.idvaga = CV.idvaga)";
				$filtro = " (F.tipo != 'Desconsiderado' OR F.idfavorito IS NULL){$temVaga} GROUP BY I.idioma ORDER BY I.ordem ASC";
				$rows = $this->GetRows($filtro, $sql);
				if(!empty($rows))
				{
					foreach($rows as $row)
					{
						$row['total'] = intval($row['total']);
						$lista[] = $row;
					}
				}

				$sql = "SELECT COUNT(DISTINCT CV.idcandidato) AS CONT FROM candidatovaga CV USE INDEX(idxcandidato)
				INNER JOIN candidato C ON(C.idcandidato = CV.idcandidato) 
				LEFT JOIN favorito F FORCE INDEX(idxcandidato) ON(CV.idcandidato = F.idcandidato AND F.idvaga = CV.idvaga) 
				LEFT JOIN candidatoidioma CI USE INDEX(idxcandidato) ON(CI.idcandidato = CV.idcandidato)";

				$filtro = " (F.tipo != 'Desconsiderado' OR F.idfavorito IS NULL) AND CI.idcandidatoidioma IS NULL{$temVaga}";
				$total = $this->TotalRegistro($filtro, $sql);
				$total = intval($total);

				$lista[] = ["idioma"=>"Candidatos que faltam avaliar idioma","total"=>$total];

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
			$row['ididioma'] = intval($row['ididioma']);
			return $row;
		}
		################################################################################################################
		public function SalvarIdioma(&$dados = false, $idcandidato = 0)
		{
			try
			{
				if(empty($idcandidato))
					return;
				$idioma = self::NewIdioma();
				for($i = 1; $i <= 4; $i++)
				{
					$nomeidioma = self::GetDadosChave($dados, array("idioma {$i}","Idioma {$i}","IDIOMA {$i}","idioma_{$i}","Idioma_{$i}","IDIOMA_{$i}"));
					$ididioma = $idioma->LerIdIdioma($nomeidioma);
					if(empty($ididioma))
					{
						continue;
					}
					$filtro = "ididioma = '{$ididioma}' AND idcandidato = '{$idcandidato}'";
					if($this->Load($filtro))
					{
						continue;
					}
					$this->idcandidatoidioma = 0;
					$this->idcandidato = $idcandidato;
					$this->ididioma = $ididioma;
					$this->Ajustar(true);
					$this->Salvar();
				}
			}
			catch( Exception $e )
			{
				throw new Exception( $e );
			}
		}
		################################################################################################################
		public function ListaDeIdiomas($idcandidato = 0)
		{
			$retorno = false;
			try
			{
				if(empty($idcandidato))
					return $retorno;
				$sql = "SELECT DISTINCT I.ididioma, I.idioma FROM candidatoidioma CI USE INDEX(idxcandidato, idxidioma) INNER JOIN idioma I ON(CI.ididioma = I.ididioma) WHERE CI.idcandidato = '{$idcandidato}' ORDER BY I.ordem ASC";
				$rows = $this->GetRows(false, $sql);
				if(!empty($rows))
				{
					$rows = array_map(array($this,'Map'), $rows);
				}
				return $rows;
			}
			catch( Exception $e )
			{
				throw new Exception( $e );
			}
		}
		################################################################################################################
		public function ExportarCandidatoIdiomas()
		{
			$obj = GetModelo("candidatoidioma");
			$idvaga = Get("idvaga", 0);			
			$objs = false;
			$rows = $obj->GetCandidatosComIdiomas($idvaga);
			if($rows)
			{
				foreach($rows as $row)
				{
					$icandidato = GetModelo("candidatoidioma");
					$icandidato->Carregar($row);
					$objs[] = $icandidato;
				}
			}
			$total = count($rows);
			$posicao = $total;
			if($objs)
			{
				if(empty($file))
					$file = $obj->GetNomeFile();
				$data = array(
					"file"=> $file,
					"lista"=>$objs,
					"posicao"=>0,
					"total"=>$total,
					"html"=>false,
					"campos"=>$obj->GetNomesCampos(),
					"download"=>false,
					"maiusculo"=>false,
					"pasta"=>$obj->GetCaminho()
				);
				Excel($data);
				$dados['sucesso'] = true;
				$dados['titulo'] = __("Exportação de idiomas dos candidatos");
				$dados['mensagem'] = __("Exportação de idiomas dos candidatos foi finalizada.<br/>O download se iniciará em instantes");
				$dados['url'] = site_url("api/baixarcandidatosidiomas/{$file}");
				$dados['finalizado'] = true;
				$dados['file'] = $file;
				$dados['posicao'] = $posicao;
				$dados['total'] = $total;
			}
			else
			{
				$dados['sucesso'] = false;
				$dados['erro'] = __("Nenhum idioma dos candidatos foi encontrado.");
			}
			return $dados;
		}		
		################################################################################################################
		public function GetNomeFile()
		{
			$retorno = "exportacaocandidato_".date("Y-m-d_H-i-s").".xls";
			try
			{
				return "exportacao_candidatos_com_idiomas_avaliados_".date("Y-m-d_H-i-s").".xls";
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
				' '=>'idioma',
				'total de candidatos'=>'total'
			);
			return $campos;
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