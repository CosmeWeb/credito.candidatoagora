<?php
if( !defined( 'BASEPATH' ) )
	exit( 'No direct script access allowed' );
#####################################################################################################
function debug( $var = NULL, $opt = NULL)
{
	$CI = & get_instance();
	$var = ($var != NULL) ? $var : $CI->session->all_userdata();
	echo '<pre>';
	($opt == NULL) ? print_r( $var ) : var_dump( $var );
	echo '</pre>';
}
#####################################################################################################
function P()
{
	$numargs = func_num_args();
	if($numargs == 0)
	{
		debug();
		return;
	}
	for ($i = 0; $i < $numargs; $i++)
	{
		$valor = func_get_arg($i);
		if(empty($valor))
		{
			echo "<pre>Variavel vazia =>[".print_r($valor, true)."]</pre>";
		}
		else
		{
			echo "<pre>";
			if(is_object($valor))
			{
				print_r($valor);
			}
			elseif(is_array($valor))
				print_r($valor);
			else
				var_dump($valor);
			echo "</pre>";
		}
	}
	return;
}
#####################################################################################################
function XDebug(&$data = null, $CI = null, $tipo = false)
{
	if(empty($tipo))
	{
		$rows = [];
		foreach ($CI->db->queries as $key=>$valor)
		{
			$rows[] = ["sql"=>$valor,"tempo"=>$CI->db->query_times[$key]];
		}
		$data['db'] = $rows;
	}
	elseif($tipo == "queries")
		$data['db'] = $CI->db->queries;
	return;
}
#####################################################################################################
function Escape($valor = "")
{
    $CI = &get_instance();
    $str = $CI->db->escape_str($valor);
	return $str;
}
#####################################################################################################
function CompletaArray( $atts, $pairs, $limita = 1)
{
	$atts = (array)$atts;
	$out = array();
	if($limita == 1)
	{
		$out = $atts;
		foreach($pairs as $name => $default)
		{
			if(@array_key_exists($name, $atts) === false)
				$out[$name] = $default;
		}
	}
	elseif($limita == 2)
	{
		foreach($atts as $name => $default)
		{
			if((@array_key_exists($name, $pairs) !== false)&&(isset($pairs[$name]))&&(empty($default)))
				$out[$name] = $pairs[$name];
			else
				$out[$name] = $default;
		}
	}
	else
	{
		foreach($atts as $name => $default)
		{
			if((@array_key_exists($name, $pairs) !== false)&&(isset($pairs[$name])))
				$out[$name] = $default;
		}
	}
	return $out;
}
#####################################################################################################
function status( $status)
{
	switch( $status ):
		case 'Pendente':
			return 'error';
			break;
		case 'Pago':
			return 'success';
			break;
	endswitch;
}
#####################################################################################################
function message( $type, $name, $msg)
{
	$CI = &get_instance();
	switch ($type)
	{
		case 'default':
			$titulo = __("questão");
			$icone = '<i class="fa fa-question-circle"></i>';
			break;
		case 'success':
			$titulo = __("Sucesso");
			$icone = '<i class="fa fa-check-circle"></i>';
			break;
		case 'warning':
			$titulo = __("Atenção");
			$icone = '<i class="fa fa-exclamation-circle"></i>';
			break;
		case 'primary':
			$titulo = __("Mensagem");
			$icone = '<i class="fa fa-comments"></i>';
			break;
		case 'info':
			$titulo =  __("Informação");
			$icone = '<i class="fa fa-exclamation-triangle"></i>';
			break;
		case 'danger':
			$titulo = __("Perigoso");
			$icone = '<i class="fa fa-times-circle"></i>';
			break;
		case 'error':
			$titulo = __("Erro");
			$icone = '<i class="fa fa-times-circle"></i>';
			break;
		default:
			$titulo = __("Informação");
			$icone = '<i class="fa fa-comment-o"></i>';
			$type = "info";
			break;
	}

	$aux = '<div class="alertMsn '.$type.' col-lg-12"><div class="note note-'.$type.'"><h4 class="box-heading">'.$titulo.'</h4><p>'.$icone." ".$msg.'</p></div></div>';
	$CI->session->set_flashdata( $name, $aux);
}
#####################################################################################################
function eUrl( $data)
{
	return base64_encode( serialize( $data ) );
}
#####################################################################################################
function dUrl( $data)
{
	$data = base64_decode( $data );
	return unserialize( $data );
}
#####################################################################################################
function convertDate( $date)
{
	list($d, $m, $a) = explode( '/', $date );
	return "$a-$m-$d";
}
#####################################################################################################
function convertDateBr( $date)
{
	list($a, $m, $d) = explode( '-', $date );
	return "$d/$m/$a";
}
#####################################################################################################
function converteData($date = "", $br = true)
{
	if(empty($date))
		return "";
	if(strpos($date, "-") !== false)
	{
		list($a, $m, $d) = explode( "-", $date );
	}
	elseif(strpos($date, "/") !== false)
	{
		list($d, $m, $a) = explode( "/", $date );
	}
	else
		return "";
	if($br)
		return "$d/$m/$a";
	else
		return "$a-$m-$d";
}
#####################################################################################################
function TimeData($valor = false)
{
	if($valor == false)
	{
		return mktime (0, 0, 0, date("m")  , date("d"), date("Y"));
	}
	$valor = trim($valor);
	$aux = explode(" ",$valor);
	if(strpos($aux[0],"/") !== false)
	{
		if(strlen($aux[0]) <= 6)
			$aux[0] = "01/".$aux[0];
		list($dia, $mes, $ano) = explode("/", $aux[0]);
	}
	elseif(strpos($aux[0],"-") !== false)
	{
		if(strlen($aux[0]) == 7)
			$aux[0] = $aux[0]."-01";
		list($ano, $mes, $dia) = explode("-", $aux[0]);
	}
	elseif(strpos($aux[0],":") !== false)
	{
		if(strlen($aux[0]) <= 5)
			$aux[1] = "00:".$aux[0];
		else
			$aux[1] = $aux[0];
		$ano = 0;
		$mes = 0;
		$dia = 0;
	}
	else
	{
		$ano = $aux[0];
		$mes = 0;
		$dia = 0;
	}
	if( count($aux) > 1 )
		$hora = $aux[1];
	else
		$hora = "0:0:0";
	if( ($hora == "00:00:00") || ($hora == "::"))
		$hora = "0:0:0";
	if(!empty($hora))
	{
		list($horas, $minuto, $segundo) = explode(":", $hora);
	}
	return mktime($horas, $minuto, $segundo, $mes, $dia, $ano);
}
#####################################################################################################
function FormataData($valor = false, $form = "d/m/Y", $default = false)
{
	if((empty($valor))&&(!is_bool($default)))
		return $default;
	list($data,$hora) = explode(" ", $valor);
	$temp = preg_replace('/\D/', "", $data);
	
	if(strlen($temp) <= 4)
	{
		$pos = strpos($data, "-");
		if($pos !== false)
		{
			if(empty($hora))
				$aux = $data. "-01";
			else
				$aux = $data. "-01 ".$hora;
			$tempo = TimeData($aux);
			return date($form, $tempo);
		}
		$pos = strpos($data, "/");
		if($pos !== false)
		{
			if(empty($hora))
				$aux = "01/".$data;
			else
				$aux = "01/".$data.$hora;
			
			$tempo = TimeData($aux);
			return date($form, $tempo);
		}
		return $valor;
	}
	elseif(strlen($temp) <= 6)
	{
		$pos = strpos($data, "-");
		if($pos !== false)
		{
			if($pos == 4)
			{
				if(empty($hora))
					$aux = $data. "-01";
				else
					$aux = $data. "-01 ".$hora;
				$tempo = TimeData($aux);
				return date($form, $tempo);
			}
			$tempo = TimeData($valor);
			return date($form, $tempo);
		}
		$pos = strrpos($data, "/");
		if($pos !== false)
		{
			$aux = strlen($data) - ($pos + 1);
			if($aux == 4)
			{
				if(empty($hora))
					$aux = "01/".$data;
				else
					$aux = "01/".$data." ".$hora;
				$tempo = TimeData($aux);
				return date($form, $tempo);
			}
			$tempo = TimeData($valor);
			return date($form, $tempo);
		}
		return $valor;
	}
	$tempo = TimeData($valor);
	return date($form, $tempo);
}
#####################################################################################################
function ComparaData( $Data1 = false, $Data2 = false)
{
	$num1 = TimeData( $Data1 );
	$num2 = TimeData( $Data2 );
	return $num1 - $num2;
}
#####################################################################################################
function DiaAdd( $valor = false, $num = 0)
{
	if( $valor == false )
	{
		return mktime( 0, 0, 0, date( "m" ), date( "d" ) + $num, date( "Y" ) );
	}
	$aux = explode( " ", $valor );
	if( strpos( $aux[0], "-" ) === false )
		list($dia, $mes, $ano) = explode( "/", $aux[0] );
	else
		list($ano, $mes, $dia) = explode( "-", $aux[0] );
	if( count( $aux ) > 1 )
		$hora = $aux[1];
	else
		$hora = "0:0:0";
	if( ($hora == "00:00:00") || ($hora == "::") )
		$hora = "0:0:0";
	if( $hora != "" )
	{
		list($horas, $minuto, $segundo) = explode( ":", $hora );
	}
	return mktime( $horas, $minuto, $segundo, $mes, $dia + $num, $ano );
}
#####################################################################################################
function DiaUtil( $valor = false, $antecipado = false)
{
	if( $valor == false )
	{
		$valor = date("d/m/Y");
	}
	if($antecipado)
	{
		$sabado = -1;
		$domingo = -2;
	}
	else
	{
		$sabado = 2;
		$domingo = 1;
	}
	$semana = date("N", TimeData($valor));
	if($semana == 6)
		$valor = date("d/m/Y", DiaAdd($valor, $sabado));
	elseif($semana == 7)
		$valor = date("d/m/Y", DiaAdd($valor, $domingo));
	else
		return $valor;

	return DiaUtil($valor, $antecipado);
}
#####################################################################################################
function debugBd()
{
	$CI = & get_instance();
	$sql = $CI->db->last_query();
	echo nl2br( $sql );
}
#####################################################################################################
function gerarSenha($tam = 6, $tipo = "Normal")
{
	if($tipo == "Normal")
		$con = 'aeiou1234567890ybdghwjmnxpqflrstvzck';
	elseif($tipo == "Numerico")
		$con = '123456789';
	elseif($tipo == "Alfanumerico")
		$con = 'aeiouybdghwjmnxpqflrstvzck';
	elseif($tipo == "Minusculas")
		$con = strtoupper('aeiou1234567890ybdghwjmnxpqflrstvzck');
	$senha = '';
	for($i = 0; $i < $tam; $i++):
		$senha .= $con[(rand() % strlen( $con ))];
	endfor;
	return $senha;
}
#####################################################################################################
function eMoney( $money)
{
	return 'R$ ' . number_format( $money, 2, ',', '.' );
}
#####################################################################################################
function jMoney($money)
{
	return number_format( $money, 2, ',', '.' );
}
#####################################################################################################
function Getfloat($num)
{
	$dotPos = strrpos($num, '.');
	$commaPos = strrpos($num, ',');
	$sep = (($dotPos > $commaPos) && $dotPos) ? $dotPos : ((($commaPos > $dotPos) && $commaPos) ? $commaPos : false);

	if(!$sep)
	{
		return floatval(preg_replace("/[^0-9]/", "", $num));
	}
	$decimal = preg_replace("/[^0-9]/", "", substr($num, $sep+1, strlen($num)));
	if(strlen($decimal)>=3)
	{
		return floatval(preg_replace("/[^0-9]/", "", $num));
	}
	return floatval(
		preg_replace("/[^0-9]/", "", substr($num, 0, $sep)) . '.' .
		preg_replace("/[^0-9]/", "", substr($num, $sep+1, strlen($num)))
	);
}
#####################################################################################################
function SemFormatNumero($str, $isdecimal = false)
{
	return Getfloat($str);
}
#####################################################################################################
function FormatNumero($str, $isdecimal = true)
{
	$str = Getfloat($str);
	$CI = & get_instance();
	$codigo = $CI->gestao->GetPaisPadrao();
	switch($codigo):
		case 'pt-br':
			if($isdecimal)
				return number_format( $str, 2, ',', '.' );
			else
				return number_format( $str, 0, ',', '.' );
			break;
		case 'en':
			if($isdecimal)
				return number_format( $str, 0, ',', '.' );
			else
				return number_format( $str, 0, ',', '.' );
			break;
		case 'fr':
			if($isdecimal)
				return number_format( $str, 0, ',', '.' );
			else
				return number_format( $str, 0, ',', '.' );
			break;
		case 'ar':
			if($isdecimal)
				return number_format( $str, 0, ',', '.' );
			else
				return number_format( $str, 0, ',', '.' );
			break;
		case 'de':
			if($isdecimal)
				return number_format( $str, 0, ',', '.' );
			else
				return number_format( $str, 0, ',', '.' );
			break;
		case 'it':
			if($isdecimal)
				return number_format( $str, 0, ',', '.' );
			else
				return number_format( $str, 0, ',', '.' );
			break;
		case 'es':
			if($isdecimal)
				return number_format( $str, 0, ',', '.' );
			else
				return number_format( $str, 0, ',', '.' );
			break;
		defatul:
			if($isdecimal)
				return number_format( $str, 0, ',', '.' );
			else
				return number_format( $str, 0, ',', '.' );
			break;
	endswitch;
}
#####################################################################################################
function mesCobranca( $data)
{
	switch( $data ):
		case 'M':
			return '1 mês';
			break;
		case 'T':
			return '3 meses';
			break;
		case 'S':
			return '6 meses';
			break;
		case 'A':
			return '12 meses';
			break;
		default:
			return '---';
			break;
	endswitch;
}
#####################################################################################################
function nomeMes( $mes)
{
	switch( $mes ):
		case 1:
			return "Janeiro";
			break;
		case 2:
			return "Fevereiro";
			break;
		case 3:
			return "Março";
			break;
		case 4:
			return "Abril";
			break;
		case 5:
			return "Maio";
			break;
		case 6:
			return "Junho";
			break;
		case 7:
			return "Julho";
			break;
		case 8:
			return "Agosto";
			break;
		case 9:
			return "Setembro";
			break;
		case 10:
			return "Outubro";
			break;
		case 11:
			return "Novembro";
			break;
		case 12:
			return "Dezembro";
			break;
	endswitch
	;
}
#####################################################################################################
function dataExtenso( $date)
{
	setlocale( LC_TIME, 'pt_BR.utf8' );
	echo strftime( "%d de %B de %Y - %H:%M", strtotime( $date ) );
}
#####################################################################################################
function isFirefox()
{
	$CI = &get_instance();
	$CI->load->library('user_agent');
	return $CI->agent->is_browser('Firefox');
}
#####################################################################################################
function AjustaData( $valor = "", $default = "")
{
	if(empty($valor))
		return $default;
	if(!isFirefox())
	{
		return date('Y-m-d', TimeData($valor));
	}
	else
	{
		return date('d/m/Y', TimeData($valor));
	}
}
#####################################################################################################
function validaCPF($cpf = "")
{
	// Verifiva se o número digitado contém todos os digitos
	$cpf = trim($cpf);
	$cpf = preg_replace( '/\D/', '', $cpf );
	$cpf = str_pad( $cpf, 11, '0', STR_PAD_LEFT );
	// Verifica se nenhuma das sequências abaixo foi digitada, caso seja, retorna falso
	if(strlen( $cpf ) != 11)
		return false;
	elseif($cpf == '00000000000')
		return false;
	elseif($cpf == '11111111111')
		return false;
	elseif($cpf == '22222222222')
		return false;
	elseif($cpf == '33333333333')
		return false;
	elseif($cpf == '44444444444')
		return false;
	elseif($cpf == '55555555555')
		return false;
	elseif($cpf == '66666666666')
		return false;
	elseif($cpf == '77777777777')
		return false;
	elseif($cpf == '88888888888')
		return false;
	elseif($cpf == '99999999999')
		return false;
	else
	{ // Calcula os números para verificar se o CPF é verdadeiro
		for($t = 9; $t < 11; $t++)
		{
			for($d = 0, $c = 0; $c < $t; $c++)
			{
				$d += $cpf{$c} * (($t + 1) - $c);
			}
			$d = ((10 * $d) % 11) % 10;
			if( $cpf{$c} != $d )
			{
				return false;
			}
		}
		return true;
	}
}
#####################################################################################################
function multiplica_cnpj( $cnpj = "", $posicao = 5)
{
	// Variável para o cálculo
	$calculo = 0;
	// Laço para percorrer os item do cnpj
	for($i = 0; $i < strlen( $cnpj ); $i++)
	{
		// Cálculo mais posição do CNPJ * a posição
		$calculo = $calculo + ($cnpj[$i] * $posicao);
		// Decrementa a posição a cada volta do laço
		$posicao--;
		// Se a posição for menor que 2, ela se torna 9
		if( $posicao < 2 )
		{
			$posicao = 9;
		}
	}
	// Retorna o cálculo
	return $calculo;
}
#####################################################################################################
function validaCNPJ($cnpj = "")
{
	$cnpj = preg_replace( '/\D/', '', $cnpj );
	if( strlen( $cnpj ) != 14 )
	{
		return false;
	}
	// Garante que o CNPJ é uma string
	$cnpj = (string) $cnpj;
	// O valor original
	$cnpj_original = $cnpj;
	// Captura os primeiros 12 números do CNPJ
	$primeiros_numeros_cnpj = substr( $cnpj, 0, 12 );

	// Faz o primeiro cálculo
	$primeiro_calculo = multiplica_cnpj( $primeiros_numeros_cnpj );
	// Se o resto da divisão entre o primeiro cálculo e 11 for menor que 2, o primeiro
	// Dígito é zero (0), caso contrário é 11 - o resto da divisão entre o cálculo e 11
	$primeiro_digito = ($primeiro_calculo % 11) < 2 ? 0 : 11 - ($primeiro_calculo % 11);
	// Concatena o primeiro dígito nos 12 primeiros números do CNPJ
	// Agora temos 13 números aqui
	$primeiros_numeros_cnpj .= $primeiro_digito;
	// O segundo cálculo é a mesma coisa do primeiro, porém, começa na posição 6
	$segundo_calculo = multiplica_cnpj( $primeiros_numeros_cnpj, 6 );
	$segundo_digito = ($segundo_calculo % 11) < 2 ? 0 : 11 - ($segundo_calculo % 11);
	// Concatena o segundo dígito ao CNPJ
	$cnpj = $primeiros_numeros_cnpj . $segundo_digito;
	// Verifica se o CNPJ gerado é idêntico ao enviado
	if( $cnpj === $cnpj_original )
	{
		return true;
	}
	else
	{
		return false;
	}
}
#####################################################################################################
function ValidarTelefone($campo = "")
{
	$internacional = true;
	if(strpos($campo, "+")===false)
		$internacional = false;

	$vr = preg_replace('/\D/', '', $campo);
	$tam = strlen($vr);

	if(!$internacional)
	{
		if( $tam <= 9 )
		{
			return false;
		}
		$vr = ValidarTelefoneBR($vr, "");
	}
	else
	{
		if( $tam <= 8 )
		{
			return false;
		}
		$formato = DDDPais( $vr );
		if($formato['iso_code'] == "BR")
			$vr = ValidarTelefoneBR($vr);
		else
			$vr = ComparaTelefone($vr, $formato['mask'] );
	}
	return $vr;
}
#####################################################################################################
function ValidarTelefoneBR($vr = "", $ddi = "+## " )
{
	$mask = $ddi."(##) ####-####";
	$teste = Tipofone($vr, $ddi);
	if( $teste == 0 )
	{
		$mask = $ddi."####-###-####";
		$retorno = ComparaTelefone($vr, $mask );
	}
	else
	{
		if( $teste == 2 )
		{
			$mask = $ddi."(##) # ####-####";
			$retorno = ComparaTelefone($vr, $mask );
			if($retorno)
			{
				if(!empty($ddi))
				{
					$digito = intval(substr($vr, 4, 1));
				}
				else
				{
					$digito = intval(substr($vr, 2, 1));
				}
				if($digito != 9)
					$retorno = false;
			}
		}
		elseif( $teste == 3 )
		{
			$retorno = false;
		}
		else
		{
			$mask = $ddi."(##) ####-####";
			$retorno = ComparaTelefone($vr, $mask );
		}
	}
	return $retorno;
}
#####################################################################################################
function ComparaTelefone($vr = "", $mask = "" )
{
	if(empty($mask))
	{
		return false;
	}
	if(empty($vr))
	{
		return false;
	}
	$len = strlen($vr);
	$cont = substr_count($mask, '#');
	if($len == $cont)
		return true;
	else
		return false;
}
#####################################################################################################
function FormatarTelefone($campo = "")
{
	$internacional = true;
	if(strpos($campo, "+")===false)
		$internacional = false;

	$vr = preg_replace('/\D/', '', $campo);
	$tam = strlen($vr);
	if( $tam <= 2 )
	{
		return $vr;
	}
	if(!$internacional)
	{
		$vr = FormatarBR($vr, "");
	}
	else
	{
		$formato = DDDPais( $vr );
		if($formato['iso_code'] == "BR")
			$vr = FormatarBR($vr);
		else
			$vr = FormatarInternacional($vr, $formato['mask'] );
	}
	return $vr;
}
#####################################################################################################
function DDDPais( $vr = "" )
{
	$codigo = CodigoPais();
	$len = count($codigo);
	for($i = 0; $i < $len; $i++)
	{
		$tam = strlen($codigo[$i]['call_prefix']);
		$prefixo = substr($vr, 0, $tam );
		if($codigo[$i]['call_prefix'] == $prefixo)
			return $codigo[$i];
	}
	return $codigo[0];
}
#####################################################################################################
function FormatarBR($vr = "", $ddi = "+## " )
{
	$mask = $ddi."(##) ####-####";
	$teste = Tipofone($vr, $ddi);
	if( $teste == 0 )
	{
		$mask = $ddi."####-###-####";
		$retorno = mascara($vr, $mask );
	}
	else
	{
		if( $teste == 2 )
		{
			$mask = $ddi."(##) # ####-####";
			$retorno = mascara($vr, $mask );
		}
		elseif( $teste == 3 )
		{
			$mask = $ddi."(##) 9 ####-####";
			$retorno = mascara($vr, $mask );
		}
		else
		{
			$mask = $ddi."(##) ####-####";
			$retorno = mascara($vr, $mask );
		}
	}
	return $retorno;
}
#####################################################################################################
function FormatarInternacional( $vr, $mask = "+## ####-###-####")
{
	$retorno = mascara($vr, $mask );
	return $retorno;
}
#####################################################################################################
function mascara($texto = "", $mask = "+## (##) #####-####")
{
	$i = strlen($texto);
	$saida = "";
	$j = 0;
	$tam = strlen($mask);
	for($x = 0; $x < $i; $x++)
	{
		if($j >= $tam)
			return $saida;
		if($mask[$j] == "#")
		{
			$saida .= $texto[$x];
			$j++;
		}
		else
		{
			while($mask[$j] != "#")
			{
				$saida .= $mask[$j];
				$j++;
			}
			$saida .= $texto[$x];
			$j++;
		}
	}
	return $saida;
}
#####################################################################################################
function Tipofone($num = "", $ddi = false)
{
	if(!empty($ddi))
		$teste = substr($num, 2, 3 );
	else
		$teste = substr($num, 0, 3 );
	if( $teste == "080" )
		return 0;
	$DDD = Array("11","12", "13", "14", "15", "16", "17", "18", "19", "21", "22", "24", "27", "28", "91", "92", "93", "94", "95", "96", "97", "98", "99", "81", "87", "82", "83", "84", "85", "88", "86", "89", "31", "32", "33", "34", "35", "37", "38", "71", "73", "74", "75", "77", "79");
	if(!empty($ddi))
		$teste = substr($num, 2, 2 );
	else
		$teste = substr($num, 0, 2 );
	foreach ($DDD as $value)
	{
		if( $teste == $value )
		{
			if(IsCelular($num, $ddi))
			{
				$len = strlen($num);
				if(!empty($ddi))
				{
					if($len == 12)
						return 3;
					elseif($len <= 10)
						return 1;
				}
				else
				{
					if($len == 10)
						return 3;
					elseif($len <= 9)
						return 1;
				}
				return 2;
			}
		}
	}
	return 1;
}
#####################################################################################################
function IsCelular($campo = "", $ddi = false)
{
	$digito = 0;
	$len = strlen($campo);
	if(!empty($ddi))
	{
		if($len <= 4)
			return false;
		if($len >= 13)
			$digito = intval(substr($campo, 5, 1));
		else
			$digito = intval(substr($campo, 4, 1));
	}
	else
	{
		if($len <= 2)
			return false;
		if($len >= 11)
			$digito = intval(substr($campo, 3, 1));
		else
			$digito = intval(substr($campo, 2, 1));
	}
	if($digito >= 8)
		return true;

	if($digito < 6)
		return false;
	if(!empty($ddi))
		$ddd = intval(substr($campo, 2, 2));
	else
		$ddd = intval(substr($campo, 0, 2));

	if(($ddd >= 11)&&($ddd <= 28)&&($ddd != 20))
		return true;

	return false;
}
#####################################################################################################
function CodigoPais()
{
	//https://www.virtualvista.com/app/public/mobile/examples?lang=pt
	return array(
	array('iso_code'=>'BR', 'call_prefix'=>'55', 'mask'=>'+## (##) #####-####' ),
	array('iso_code'=>'US', 'call_prefix'=>'1', 'mask'=>'+# ###-###-####' ),
	array('iso_code'=>'AX', 'call_prefix'=>'0', 'mask'=>'+# (###) ###-####' ),
	array('iso_code'=>'RU', 'call_prefix'=>'7', 'mask'=>'+# ### ###-##-##' ),
	array('iso_code'=>'EG', 'call_prefix'=>'20', 'mask'=>'+## ### ### ####' ),
	array('iso_code'=>'ZA', 'call_prefix'=>'27', 'mask'=>'+## (###) ###-####' ),
	array('iso_code'=>'GR', 'call_prefix'=>'30', 'mask'=>'+## (###) ###-####' ),
	array('iso_code'=>'NL', 'call_prefix'=>'31', 'mask'=>'+## (###) ###-####' ),
	array('iso_code'=>'BE', 'call_prefix'=>'32', 'mask'=>'+## (###) ###-####' ),
	array('iso_code'=>'FR', 'call_prefix'=>'33', 'mask'=>'+## # ## ## ## ##' ),
	array('iso_code'=>'ES', 'call_prefix'=>'34', 'mask'=>'+## ### ## ## ##' ),
	array('iso_code'=>'HU', 'call_prefix'=>'36', 'mask'=>'+## (###) ###-####' ),
	array('iso_code'=>'IT', 'call_prefix'=>'39', 'mask'=>'+## ### ### ####' ),
	array('iso_code'=>'RO', 'call_prefix'=>'40', 'mask'=>'+## (###) ###-####' ),
	array('iso_code'=>'CH', 'call_prefix'=>'41', 'mask'=>'+## (###) ###-####' ),
	array('iso_code'=>'AT', 'call_prefix'=>'43', 'mask'=>'+## (###) ###-####' ),
	array('iso_code'=>'GB', 'call_prefix'=>'44', 'mask'=>'+## #### ######' ),
	array('iso_code'=>'DK', 'call_prefix'=>'45', 'mask'=>'+## ## ## ## ##' ),
	array('iso_code'=>'SE', 'call_prefix'=>'46', 'mask'=>'+## (###) ###-####' ),
	array('iso_code'=>'NO', 'call_prefix'=>'47', 'mask'=>'+## (###) ###-####' ),
	array('iso_code'=>'PL', 'call_prefix'=>'48', 'mask'=>'+## (###) ###-####' ),
	array('iso_code'=>'DE', 'call_prefix'=>'49', 'mask'=>'+## ### ########' ),
	array('iso_code'=>'PE', 'call_prefix'=>'51', 'mask'=>'+## ### ### ###' ),
	array('iso_code'=>'MX', 'call_prefix'=>'52', 'mask'=>'+## # ### ### ####' ),
	array('iso_code'=>'CU', 'call_prefix'=>'53', 'mask'=>'+## # #######' ),
	array('iso_code'=>'AR', 'call_prefix'=>'54', 'mask'=>'+## # ## ####-####' ),
	array('iso_code'=>'BR', 'call_prefix'=>'55', 'mask'=>'+## (###) ###-####' ),
	array('iso_code'=>'CL', 'call_prefix'=>'56', 'mask'=>'+## # #### ####' ),
	array('iso_code'=>'CO', 'call_prefix'=>'57', 'mask'=>'+## ### #######' ),
	array('iso_code'=>'VE', 'call_prefix'=>'58', 'mask'=>'+## ###-#######' ),
	array('iso_code'=>'MY', 'call_prefix'=>'60', 'mask'=>'+## (###) ###-####' ),
	array('iso_code'=>'AU', 'call_prefix'=>'61', 'mask'=>'+## ### ### ###' ),
	array('iso_code'=>'ID', 'call_prefix'=>'62', 'mask'=>'+## (###) ###-####' ),
	array('iso_code'=>'PH', 'call_prefix'=>'63', 'mask'=>'+## (###) ###-####' ),
	array('iso_code'=>'NZ', 'call_prefix'=>'64', 'mask'=>'+## (###) ###-####' ),
	array('iso_code'=>'SG', 'call_prefix'=>'65', 'mask'=>'+## (###) ###-####' ),
	array('iso_code'=>'TH', 'call_prefix'=>'66', 'mask'=>'+## (###) ###-####' ),
	array('iso_code'=>'JP', 'call_prefix'=>'81', 'mask'=>'+## ##-####-####' ),
	array('iso_code'=>'KR', 'call_prefix'=>'82', 'mask'=>'+## (###) ###-####' ),
	array('iso_code'=>'VN', 'call_prefix'=>'84', 'mask'=>'+## ## ### ## ##' ),
	array('iso_code'=>'CN', 'call_prefix'=>'86', 'mask'=>'+## ### #### ####' ),
	array('iso_code'=>'TR', 'call_prefix'=>'90', 'mask'=>'+## (###) ###-####' ),
	array('iso_code'=>'IN', 'call_prefix'=>'91', 'mask'=>'+## ## ## ######' ),
	array('iso_code'=>'PK', 'call_prefix'=>'92', 'mask'=>'+## (###) ###-####' ),
	array('iso_code'=>'AF', 'call_prefix'=>'93', 'mask'=>'+## ## ### ####' ),
	array('iso_code'=>'LK', 'call_prefix'=>'94', 'mask'=>'+## (###) ###-####' ),
	array('iso_code'=>'MM', 'call_prefix'=>'95', 'mask'=>'+## (###) ###-####' ),
	array('iso_code'=>'IR', 'call_prefix'=>'98', 'mask'=>'+## (###) ###-####' ),
	array('iso_code'=>'MA', 'call_prefix'=>'212', 'mask'=>'+### ###-######' ),
	array('iso_code'=>'DZ', 'call_prefix'=>'213', 'mask'=>'+### (##) #### ####' ),
	array('iso_code'=>'TN', 'call_prefix'=>'216', 'mask'=>'+### (##) #### ####' ),
	array('iso_code'=>'LY', 'call_prefix'=>'218', 'mask'=>'+### ##-#######' ),
	array('iso_code'=>'GM', 'call_prefix'=>'220', 'mask'=>'+### (##) #### ####' ),
	array('iso_code'=>'SN', 'call_prefix'=>'221', 'mask'=>'+### ## ### ## ##' ),
	array('iso_code'=>'MR', 'call_prefix'=>'222', 'mask'=>'+### (##) #### ####' ),
	array('iso_code'=>'ML', 'call_prefix'=>'223', 'mask'=>'+### (##) #### ####' ),
	array('iso_code'=>'GN', 'call_prefix'=>'224', 'mask'=>'+### (##) #### ####' ),
	array('iso_code'=>'CI', 'call_prefix'=>'225', 'mask'=>'+### (##) #### ####' ),
	array('iso_code'=>'BF', 'call_prefix'=>'226', 'mask'=>'+### (##) #### ####' ),
	array('iso_code'=>'NE', 'call_prefix'=>'227', 'mask'=>'+### (##) #### ####' ),
	array('iso_code'=>'TG', 'call_prefix'=>'228', 'mask'=>'+### (##) #### ####' ),
	array('iso_code'=>'BJ', 'call_prefix'=>'229', 'mask'=>'+### (##) #### ####' ),
	array('iso_code'=>'MU', 'call_prefix'=>'230', 'mask'=>'+### (##) #### ####' ),
	array('iso_code'=>'LR', 'call_prefix'=>'231', 'mask'=>'+### (##) #### ####' ),
	array('iso_code'=>'SL', 'call_prefix'=>'232', 'mask'=>'+### (##) #### ####' ),
	array('iso_code'=>'GH', 'call_prefix'=>'233', 'mask'=>'+### (##) #### ####' ),
	array('iso_code'=>'NG', 'call_prefix'=>'234', 'mask'=>'+### (##) #### ####' ),
	array('iso_code'=>'TD', 'call_prefix'=>'235', 'mask'=>'+### (##) #### ####' ),
	array('iso_code'=>'CF', 'call_prefix'=>'236', 'mask'=>'+### (##) #### ####' ),
	array('iso_code'=>'CM', 'call_prefix'=>'237', 'mask'=>'+### (##) #### ####' ),
	array('iso_code'=>'CV', 'call_prefix'=>'238', 'mask'=>'+### (##) #### ####' ),
	array('iso_code'=>'ST', 'call_prefix'=>'239', 'mask'=>'+### (##) #### ####' ),
	array('iso_code'=>'GQ', 'call_prefix'=>'240', 'mask'=>'+### (##) #### ####' ),
	array('iso_code'=>'GA', 'call_prefix'=>'241', 'mask'=>'+### (##) #### ####' ),
	array('iso_code'=>'CD', 'call_prefix'=>'242', 'mask'=>'+### (##) #### ####' ),
	array('iso_code'=>'CG', 'call_prefix'=>'243', 'mask'=>'+### (##) #### ####' ),
	array('iso_code'=>'AO', 'call_prefix'=>'244', 'mask'=>'+### ### ### ###' ),
	array('iso_code'=>'GW', 'call_prefix'=>'245', 'mask'=>'+### ### ####' ),
	array('iso_code'=>'SC', 'call_prefix'=>'248', 'mask'=>'+### (##) #### ####' ),
	array('iso_code'=>'SD', 'call_prefix'=>'249', 'mask'=>'+### (##) #### ####' ),
	array('iso_code'=>'RW', 'call_prefix'=>'250', 'mask'=>'+### (##) #### ####' ),
	array('iso_code'=>'ET', 'call_prefix'=>'251', 'mask'=>'+### (##) #### ####' ),
	array('iso_code'=>'SO', 'call_prefix'=>'252', 'mask'=>'+### (##) #### ####' ),
	array('iso_code'=>'DJ', 'call_prefix'=>'253', 'mask'=>'+### (##) #### ####' ),
	array('iso_code'=>'KE', 'call_prefix'=>'254', 'mask'=>'+### (##) #### ####' ),
	array('iso_code'=>'TZ', 'call_prefix'=>'255', 'mask'=>'+### (##) #### ####' ),
	array('iso_code'=>'UG', 'call_prefix'=>'256', 'mask'=>'+### (##) #### ####' ),
	array('iso_code'=>'BI', 'call_prefix'=>'257', 'mask'=>'+### (##) #### ####' ),
	array('iso_code'=>'MZ', 'call_prefix'=>'258', 'mask'=>'+### (##) #### ####' ),
	array('iso_code'=>'ZM', 'call_prefix'=>'260', 'mask'=>'+### ## #######' ),
	array('iso_code'=>'MG', 'call_prefix'=>'261', 'mask'=>'+### (##) #### ####' ),
	array('iso_code'=>'YT', 'call_prefix'=>'262', 'mask'=>'+### (##) #### ####' ),
	array('iso_code'=>'RE', 'call_prefix'=>'262', 'mask'=>'+### (##) #### ####' ),
	array('iso_code'=>'ZW', 'call_prefix'=>'263', 'mask'=>'+### ## ### ####' ),
	array('iso_code'=>'NA', 'call_prefix'=>'264', 'mask'=>'+### (##) #### ####' ),
	array('iso_code'=>'MW', 'call_prefix'=>'265', 'mask'=>'+### (##) #### ####' ),
	array('iso_code'=>'LS', 'call_prefix'=>'266', 'mask'=>'+### (##) #### ####' ),
	array('iso_code'=>'BW', 'call_prefix'=>'267', 'mask'=>'+### (##) #### ####' ),
	array('iso_code'=>'SZ', 'call_prefix'=>'268', 'mask'=>'+### (##) #### ####' ),
	array('iso_code'=>'KM', 'call_prefix'=>'269', 'mask'=>'+### (##) #### ####' ),
	array('iso_code'=>'ER', 'call_prefix'=>'291', 'mask'=>'+### (##) #### ####' ),
	array('iso_code'=>'AW', 'call_prefix'=>'297', 'mask'=>'+### (##) #### ####' ),
	array('iso_code'=>'FO', 'call_prefix'=>'298', 'mask'=>'+### (##) #### ####' ),
	array('iso_code'=>'GL', 'call_prefix'=>'299', 'mask'=>'+### (##) #### ####' ),
	array('iso_code'=>'GI', 'call_prefix'=>'350', 'mask'=>'+### (##) #### ####' ),
	array('iso_code'=>'PT', 'call_prefix'=>'351', 'mask'=>'+### ### ### ###' ),
	array('iso_code'=>'LU', 'call_prefix'=>'352', 'mask'=>'+### (##) #### ####' ),
	array('iso_code'=>'IE', 'call_prefix'=>'353', 'mask'=>'+### (##) #### ####' ),
	array('iso_code'=>'IS', 'call_prefix'=>'354', 'mask'=>'+### (##) #### ####' ),
	array('iso_code'=>'AL', 'call_prefix'=>'355', 'mask'=>'+### ## ### ####' ),
	array('iso_code'=>'MT', 'call_prefix'=>'356', 'mask'=>'+### (##) #### ####' ),
	array('iso_code'=>'CY', 'call_prefix'=>'357', 'mask'=>'+### (##) #### ####' ),
	array('iso_code'=>'FI', 'call_prefix'=>'358', 'mask'=>'+### (##) #### ####' ),
	array('iso_code'=>'BG', 'call_prefix'=>'359', 'mask'=>'+### (##) #### ####' ),
	array('iso_code'=>'LT', 'call_prefix'=>'370', 'mask'=>'+### (##) #### ####' ),
	array('iso_code'=>'LV', 'call_prefix'=>'371', 'mask'=>'+### (##) #### ####' ),
	array('iso_code'=>'EE', 'call_prefix'=>'372', 'mask'=>'+### (##) #### ####' ),
	array('iso_code'=>'MD', 'call_prefix'=>'373', 'mask'=>'+### (##) #### ####' ),
	array('iso_code'=>'AM', 'call_prefix'=>'374', 'mask'=>'+### (##) #### ####' ),
	array('iso_code'=>'AD', 'call_prefix'=>'376', 'mask'=>'+### (##) #### ####' ),
	array('iso_code'=>'MC', 'call_prefix'=>'377', 'mask'=>'+### (##) #### ####' ),
	array('iso_code'=>'SM', 'call_prefix'=>'378', 'mask'=>'+### (##) #### ####' ),
	array('iso_code'=>'VA', 'call_prefix'=>'379', 'mask'=>'+### (##) #### ####' ),
	array('iso_code'=>'UA', 'call_prefix'=>'380', 'mask'=>'+### (##) #### ####' ),
	array('iso_code'=>'RS', 'call_prefix'=>'381', 'mask'=>'+### (##) #### ####' ),
	array('iso_code'=>'ME', 'call_prefix'=>'382', 'mask'=>'+### (##) #### ####' ),
	array('iso_code'=>'HR', 'call_prefix'=>'385', 'mask'=>'+### (##) #### ####' ),
	array('iso_code'=>'SI', 'call_prefix'=>'386', 'mask'=>'+### (##) #### ####' ),
	array('iso_code'=>'BA', 'call_prefix'=>'387', 'mask'=>'+### (##) #### ####' ),
	array('iso_code'=>'MK', 'call_prefix'=>'389', 'mask'=>'+### (##) #### ####' ),
	array('iso_code'=>'CZ', 'call_prefix'=>'420', 'mask'=>'+### (##) #### ####' ),
	array('iso_code'=>'SK', 'call_prefix'=>'421', 'mask'=>'+### ### ### ###' ),
	array('iso_code'=>'LI', 'call_prefix'=>'423', 'mask'=>'+### (##) #### ####' ),
	array('iso_code'=>'BZ', 'call_prefix'=>'501', 'mask'=>'+### (##) #### ####' ),
	array('iso_code'=>'GT', 'call_prefix'=>'502', 'mask'=>'+### #### ####' ),
	array('iso_code'=>'SV', 'call_prefix'=>'503', 'mask'=>'+### (##) #### ####' ),
	array('iso_code'=>'HN', 'call_prefix'=>'504', 'mask'=>'+### (##) #### ####' ),
	array('iso_code'=>'NI', 'call_prefix'=>'505', 'mask'=>'+### (##) #### ####' ),
	array('iso_code'=>'CR', 'call_prefix'=>'506', 'mask'=>'+### (##) #### ####' ),
	array('iso_code'=>'PA', 'call_prefix'=>'507', 'mask'=>'+### (##) #### ####' ),
	array('iso_code'=>'PM', 'call_prefix'=>'508', 'mask'=>'+### (##) #### ####' ),
	array('iso_code'=>'HT', 'call_prefix'=>'509', 'mask'=>'+### ## ## ####' ),
	array('iso_code'=>'GP', 'call_prefix'=>'590', 'mask'=>'+### (##) #### ####' ),
	array('iso_code'=>'BO', 'call_prefix'=>'591', 'mask'=>'+### ########' ),
	array('iso_code'=>'GY', 'call_prefix'=>'592', 'mask'=>'+### ### ####' ),
	array('iso_code'=>'EC', 'call_prefix'=>'593', 'mask'=>'+### (##) #### ####' ),
	array('iso_code'=>'GF', 'call_prefix'=>'594', 'mask'=>'+### (##) #### ####' ),
	array('iso_code'=>'PY', 'call_prefix'=>'595', 'mask'=>'+### ### ######' ),
	array('iso_code'=>'MQ', 'call_prefix'=>'596', 'mask'=>'+### (##) #### ####' ),
	array('iso_code'=>'SR', 'call_prefix'=>'597', 'mask'=>'+### (##) #### ####' ),
	array('iso_code'=>'UY', 'call_prefix'=>'598', 'mask'=>'+### ## ### ###' ),
	array('iso_code'=>'AN', 'call_prefix'=>'599', 'mask'=>'+### (##) #### ####' ),
	array('iso_code'=>'TL', 'call_prefix'=>'670', 'mask'=>'+### (##) #### ####' ),
	array('iso_code'=>'BN', 'call_prefix'=>'673', 'mask'=>'+### (##) #### ####' ),
	array('iso_code'=>'NR', 'call_prefix'=>'674', 'mask'=>'+### (##) #### ####' ),
	array('iso_code'=>'PG', 'call_prefix'=>'675', 'mask'=>'+### (##) #### ####' ),
	array('iso_code'=>'TO', 'call_prefix'=>'676', 'mask'=>'+### (##) #### ####' ),
	array('iso_code'=>'SB', 'call_prefix'=>'677', 'mask'=>'+### (##) #### ####' ),
	array('iso_code'=>'VU', 'call_prefix'=>'678', 'mask'=>'+### (##) #### ####' ),
	array('iso_code'=>'FJ', 'call_prefix'=>'679', 'mask'=>'+### (##) #### ####' ),
	array('iso_code'=>'PW', 'call_prefix'=>'680', 'mask'=>'+### (##) #### ####' ),
	array('iso_code'=>'WF', 'call_prefix'=>'681', 'mask'=>'+### ## ## ##' ),
	array('iso_code'=>'CK', 'call_prefix'=>'682', 'mask'=>'+### (##) #### ####' ),
	array('iso_code'=>'NU', 'call_prefix'=>'683', 'mask'=>'+### (##) #### ####' ),
	array('iso_code'=>'WS', 'call_prefix'=>'685', 'mask'=>'+### (##) #### ####' ),
	array('iso_code'=>'KI', 'call_prefix'=>'686', 'mask'=>'+### (##) #### ####' ),
	array('iso_code'=>'NC', 'call_prefix'=>'687', 'mask'=>'+### (##) #### ####' ),
	array('iso_code'=>'TV', 'call_prefix'=>'688', 'mask'=>'+### (##) #### ####' ),
	array('iso_code'=>'PF', 'call_prefix'=>'689', 'mask'=>'+### (##) #### ####' ),
	array('iso_code'=>'TK', 'call_prefix'=>'690', 'mask'=>'+### (##) #### ####' ),
	array('iso_code'=>'FM', 'call_prefix'=>'691', 'mask'=>'+### (##) #### ####' ),
	array('iso_code'=>'MH', 'call_prefix'=>'692', 'mask'=>'+### (##) #### ####' ),
	array('iso_code'=>'KP', 'call_prefix'=>'850', 'mask'=>'+### (##) #### ####' ),
	array('iso_code'=>'HK', 'call_prefix'=>'852', 'mask'=>'+### #### ####' ),
	array('iso_code'=>'MO', 'call_prefix'=>'853', 'mask'=>'+### (##) #### ####' ),
	array('iso_code'=>'KH', 'call_prefix'=>'855', 'mask'=>'+### (##) #### ####' ),
	array('iso_code'=>'LA', 'call_prefix'=>'856', 'mask'=>'+### (##) #### ####' ),
	array('iso_code'=>'BD', 'call_prefix'=>'880', 'mask'=>'+### (##) #### ####' ),
	array('iso_code'=>'TW', 'call_prefix'=>'886', 'mask'=>'+### (##) #### ####' ),
	array('iso_code'=>'MV', 'call_prefix'=>'960', 'mask'=>'+### (##) #### ####' ),
	array('iso_code'=>'LB', 'call_prefix'=>'961', 'mask'=>'+### (##) #### ####' ),
	array('iso_code'=>'JO', 'call_prefix'=>'962', 'mask'=>'+### (##) #### ####' ),
	array('iso_code'=>'SY', 'call_prefix'=>'963', 'mask'=>'+### (##) #### ####' ),
	array('iso_code'=>'IQ', 'call_prefix'=>'964', 'mask'=>'+### (##) #### ####' ),
	array('iso_code'=>'KW', 'call_prefix'=>'965', 'mask'=>'+### (##) #### ####' ),
	array('iso_code'=>'SA', 'call_prefix'=>'966', 'mask'=>'+### (##) #### ####' ),
	array('iso_code'=>'YE', 'call_prefix'=>'967', 'mask'=>'+### ### ### ###' ),
	array('iso_code'=>'OM', 'call_prefix'=>'968', 'mask'=>'+### (##) #### ####' ),
	array('iso_code'=>'AE', 'call_prefix'=>'971', 'mask'=>'+### ## ### ####' ),
	array('iso_code'=>'IL', 'call_prefix'=>'972', 'mask'=>'+### ##-###-####' ),
	array('iso_code'=>'BH', 'call_prefix'=>'973', 'mask'=>'+### (##) #### ####' ),
	array('iso_code'=>'QA', 'call_prefix'=>'974', 'mask'=>'+### (##) #### ####' ),
	array('iso_code'=>'BT', 'call_prefix'=>'975', 'mask'=>'+### (##) #### ####' ),
	array('iso_code'=>'MN', 'call_prefix'=>'976', 'mask'=>'+### (##) #### ####' ),
	array('iso_code'=>'NP', 'call_prefix'=>'977', 'mask'=>'+### (##) #### ####' ),
	array('iso_code'=>'TJ', 'call_prefix'=>'992', 'mask'=>'+### (##) #### ####' ),
	array('iso_code'=>'TM', 'call_prefix'=>'993', 'mask'=>'+### (##) #### ####' ),
	array('iso_code'=>'AZ', 'call_prefix'=>'994', 'mask'=>'+### (##) #### ####' ),
	array('iso_code'=>'GE', 'call_prefix'=>'995', 'mask'=>'+### (##) #### ####' ),
	array('iso_code'=>'KG', 'call_prefix'=>'996', 'mask'=>'+### (##) #### ####' ),
	array('iso_code'=>'UZ', 'call_prefix'=>'998', 'mask'=>'+### (##) #### ####' )
	);
}
#####################################################################################################
function GetIP() {
    $ip_keys = array('HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR');
    foreach ($ip_keys as $key)
    {
        if (array_key_exists($key, $_SERVER) === true)
        {
            foreach (explode(',', $_SERVER[$key]) as $ip)
            {
                $ip = trim($ip);
                if (validate_ip($ip)) {
                    return $ip;
                }
            }
        }
    }
    return isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : 'unknown';
}
#####################################################################################################
function GetIPServidor() {
    $ip_keys = array('SERVER_ADDR', 'LOCAL_ADDR');
    foreach ($ip_keys as $key)
    {
        if (array_key_exists($key, $_SERVER) === true)
        {
            if(!empty($_SERVER[$key]))
            {
                $ip = trim($_SERVER[$key]);
                if (validate_ip($ip)) {
                    return $ip;
                }
            }
        }
    }
    return isset($_SERVER['SERVER_ADDR']) ? $_SERVER['SERVER_ADDR'] : 'unknown';
}
#####################################################################################################
function GetNomeServidor() {
    $ip_keys = array('SERVER_NAME', 'HTTP_HOST');
    foreach ($ip_keys as $key)
    {
        if (array_key_exists($key, $_SERVER) === true)
        {
            if(!empty($_SERVER[$key]))
            {
                $ip = trim($_SERVER[$key]);
                if (validate_ip($ip)) {
                    return $ip;
                }
            }
        }
    }
    return isset($_SERVER['SERVER_NAME']) ? $_SERVER['SERVER_NAME'] : 'unknown';
}
#####################################################################################################
function validate_ip($ip)
{
    if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4 | FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) === false)
    {
        return false;
    }
    return true;
}
#####################################################################################################
function validaCep($cep)
{
	$cep = trim($cep);
	$avaliaCep = preg_replace("/\D/", "", $cep);
	if(strlen($avaliaCep) == 8)
		return true;
	else
	return false;
}
#####################################################################################################
function AcertaNomeArquivo($nomeAquivo)
{
	if(empty($nomeAquivo))
		return "";
	$nomeAquivo = TiraAcento($nomeAquivo);
	$nomeAquivo = strtolower($nomeAquivo);
	$caracter = array('%','?','!','$','&','~','+','-',' ','#',"\'","[","\\","]","^","]","`",":",";","<","=",">",
	"@","/","(",")","*",'°');
	for($i = 123; $i <= 255; $i++)
		$caracter[] = chr($i);
	$nomeAquivo = str_replace($caracter,"_",$nomeAquivo);
	return $nomeAquivo;
}
#####################################################################################################
function TiraAcento( $nome)
{
	if( empty( $nome ) )
		return "";
	$nome = preg_replace( '/[áàâãª]/u', "a", $nome );
	$nome = preg_replace( '/[ÁÀÂÃ]/u', "A", $nome );
	$nome = preg_replace( '/[éèêë]/u', "e", $nome );
	$nome = preg_replace( '/[ÉÈÊË]/u', "E", $nome );
	$nome = preg_replace( '/[óòôõº]/u', "o", $nome );
	$nome = preg_replace( '/[ÓÒÔÕ]/u', "O", $nome );
	$nome = preg_replace( '/[ìíîï]/u', "i", $nome );
	$nome = preg_replace( '/[ÌÍÎÏ]/u', "I", $nome );
	$nome = preg_replace( '/[úùûü]/u', "u", $nome );
	$nome = preg_replace( '/[ÚÙÛÜ]/u', "U", $nome );
	$nome = str_replace( "ç", "c", $nome );
	$nome = str_replace( "Ç", "C", $nome );
	$nome = trim( $nome );
	return $nome;
}
#####################################################################################################
if(!function_exists('controller'))
{
    function controller($name)
    {
        $filename = realpath(__DIR__ . '/../controllers/'.$name.'.php');

        if(file_exists($filename))
        {
            require_once $filename;

            $class = ucfirst($name);

            if(class_exists($class))
            {
                $ci =& get_instance();

                if(!isset($ci->{$name.'_controller'}))
                {
                    $ci->{$name.'_controller'} = new $class();
                }
            }
        }
    }
}
#####################################################################################################
if(!function_exists('GetModelo'))
{
    function &GetModelo($nome = "")
    {
    	$retorno = false;
    	if(empty($nome))
    		return $retorno;
    	$CI = &get_instance();
    	$nome = strtolower($nome);
    	$modelo = ucfirst($nome).'_model';
        $CI->load->model($modelo, $nome);
		$obj = $CI->$nome->GetInstancia();
		return $obj;
    }
}
#####################################################################################################
if(!function_exists('GetLibrary'))
{
	function &GetLibrary($nome = "")
	{
		$retorno = false;
		if(empty($nome))
			return $retorno;
		$CI = &get_instance();
		$CI->load->library($nome);
		$nome = strtolower($nome);
		return $CI->$nome->GetInstancia();
	}
}
#####################################################################################################
function Get($campo = "", $padrao = "", $index = false)
{
	if(empty($campo))
		return $padrao;
	if(!is_numeric($index))
    {
    	if(isset($_REQUEST[$campo]))
    		$valor = $_REQUEST[$campo];
    	else
    		$valor = $padrao;
    }
    else
    {
    	if(isset($_REQUEST[$campo][$index]))
    		$valor = $_REQUEST[$campo][$index];
    	else
    		$valor = $padrao;
    }
    return $valor;
}
#####################################################################################################
function GetFiltro($campo = "", $padrao = "")
{
	header ('Content-type: text/json; charset=utf-8');
	if(empty($campo))
		return $padrao;
	$filtro = Get("FILTRO");
	if(empty($filtro))
		return $padrao;
	$key = array_search($campo, array_column($filtro, 'name'));
	if($key === false)
		return $padrao;
	if(empty($filtro[$key]['value']))
		return $padrao;
	return htmlspecialchars_decode($filtro[$key]['value']);
}
#####################################################################################################
function GetChecked($valor = "", $campo = "", $padrao = "")
{
	if(empty($campo))
		return $padrao;
	if(!isset($_REQUEST[$campo]))
		return $padrao;
	if($_REQUEST[$campo] != $valor)
		return $padrao;
    return ' selected="selected"';
}
#####################################################################################################
function SetChecked($valor = "", $opcao = "", $padrao = false)
{
	if($valor == $opcao)
		return ' checked="checked"';
	if($padrao)
		return ' checked="checked"';
    return '';
}
#####################################################################################################
function GetConfiguracao($nome = "", $default = 0)
{
	$CI = &get_instance();
	$chave = "Config_".$nome;
	$tempo = 10 * 60;
	if($CI->cache->memcached->is_supported())
	{
		if (!$valor = $CI->cache->memcached->get($chave)) {
			$valor = $CI->gestao->Config->GetConfig($nome, $default);
			$CI->cache->memcached->save($chave, $valor, $tempo);
		}
	}
	elseif($CI->cache->apc->is_supported())
	{
		if (!$valor = $CI->cache->apc->get($chave)) {
			$valor = $CI->gestao->Config->GetConfig($nome, $default);
			$CI->cache->apc->save($chave, $valor, $tempo);
		}
	}
	elseif($CI->cache->file->is_supported())
	{
		if (!$valor = $CI->cache->file->get($chave)) {
			$valor = $CI->gestao->Config->GetConfig($nome, $default);
			$CI->cache->file->save($chave, $valor, $tempo);
		}
	}
	else
	{
		$valor = $CI->gestao->Config->GetConfig($nome, $default);
	}
	
	return $valor;
}
#####################################################################################################
function CriarPastas($dirName, $rights = 0777)
{
    $dirs = explode('/', $dirName);
    $dir = '';
    foreach ($dirs as $part)
    {
    	if(empty($part))
    		continue;
        $dir .= $part;
        if(!is_dir($dir) && strlen($dir) > 0)
        {
        	@mkdir($dir, $rights);
        }
        $dir .='/';
	}
}
#####################################################################################################
function RetornaJSON($data, $crossorigin = false)
{
	if($crossorigin)
	{
		header('Access-Control-Allow-Origin: *');
	}
	header("Content-Type: text/json; charset=utf-8");
    echo json_encode($data);
}
#####################################################################################################
function RetornaJSONerro($erro, $crossorigin = false)
{
	$data['sucesso'] = false;
	$data['erro'] = $erro;
	RetornaJSON($data, $crossorigin);
}
#####################################################################################################
function Acesso($classeExclude = null, $metodoExclude = null)
{
    $CI = &get_instance();
	$class = $CI->router->class;
	if(empty($classeExclude))
		$classeExclude =  array('painel');
	if(in_array($class, $classeExclude))
	{
		$metodo = $CI->router->method;
		if(empty($metodoExclude))
			$metodoExclude =  array('login','teste','recuperarsenha','icones');
		if(in_array($metodo, $metodoExclude))
		{
			return false;
		}
	}
	$session = $CI->session->all_userdata();
	if( !isset( $session['idcliente'] ) or !isset( $session['email'] ) or !isset( $session['nome'] ) ):
		$CI->session->sess_destroy();
		redirect('/');
	endif;
	return;
}
#####################################################################################################
function GetAcesso($chave = "idcliente")
{
	$CI = &get_instance();
	$session = $CI->session->all_userdata();
	if(array_key_exists($chave, $session) === false)
		return false;
	
	if(isset($session[$chave]))
	{
		return $session[$chave];
	}
	return false;
}
#####################################################################################################
function TemAcesso($tipo = null)
{
	
	if(empty($tipo))
		return true;
	$acesso = GetAcesso("acesso");
	if(is_string($tipo))
	{
		if($acesso == $tipo)
			return true;
		else
			return false;
	}
	if(is_array($tipo))
	{
		if(in_array($acesso, $tipo) !== false)
			return true;
		else
			return false;
	}
	
	return false;
}
#####################################################################################################
function E_Cliente($idcliente = 0)
{
	$retorno = false;
	try
	{
		if(empty($idcliente))
		{
			return $retorno;
		}
		$idclientelogado = GetAcesso("idcliente");
		if(empty($idclientelogado))
		{
			return $retorno;
		}
		if($idclientelogado != $idcliente)
		{
			return $retorno;
		}
		return true;
	}
	catch( Exception $e )
	{
		throw new Exception( $e );
		return $retorno;
	}
}
#####################################################################################################
function encryptCookie($value)
{
	if(!$value){return false;}
	/*$CI = &get_instance();
	$key = $CI->config->item('encryption_key');
	if(function_exists("mcrypt_create_iv"))
	{
		$text = $value;
		$iv_size = @mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);
		$iv = @mcrypt_create_iv($iv_size, MCRYPT_RAND);
		$crypttext = @mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $key, $text, MCRYPT_MODE_ECB, $iv);
	}
	else*/
		$crypttext = $value;
	return trim(base64_encode($crypttext)); //encode for cookie
}
#####################################################################################################
function decryptCookie($value)
{
	if(!$value){return false;}
	$crypttext = base64_decode($value); //decode cookie
	/*$CI = &get_instance();
	$key = $CI->config->item('encryption_key');
	if(function_exists("mcrypt_create_iv"))
	{
		$iv_size = @mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);
		$iv = @mcrypt_create_iv($iv_size, MCRYPT_RAND);
		$decrypttext = @mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $key, $crypttext, MCRYPT_MODE_ECB, $iv);
	}*/
	return trim($crypttext);
}
#####################################################################################################
function force_ssl()
{
    if (!isset($_SERVER['HTTPS']) || $_SERVER['HTTPS'] != "on")
    {
        $url = base_url($_SERVER['REQUEST_URI']);
        redirect($url);
        exit;
    }
}
#####################################################################################################
function GetReferencia($url = "", $metodo = "listar")
{
	$CI =& get_instance();
	if(!empty($_SERVER['HTTP_REFERER']))
	{
		$link = $_SERVER['HTTP_REFERER'];
		$pos = strpos($link, $CI->uri->uri_string());
		if($pos === false)
		{
			$CI->session->set_userdata("URLretorno",$link);
			return $link;
		}
		$link = $CI->session->userdata("URLretorno");
		if(!empty($link))
		{
			$pos = strpos($link, $CI->uri->uri_string());
			if($pos === false)
			{
				return $link;
			}
		}
	}
	if(empty($url))
	{
		$class = $CI->router->class;
		$url = "{$class}/{$metodo}";
	}
	return $url;
}
#####################################################################################################
function OrdenaOutro(&$lista = false, $campo = "", $limite = 500)
{
	if(empty($lista))
	{
		return;
	}
	if(empty($campo))
	{
		return;
	}
	if(!is_array($lista))
	{
		return;
	}
	if($limite < count($lista))
		return;
	$nova = array();
	$outros = array();
	foreach ($lista as $key=>$item)
	{
		$label = $item[$campo];
		if((strcasecmp($label, "outro") == 0)||(strcasecmp($label, "outros") == 0)||(strcasecmp($label, "outra") == 0)||(strcasecmp($label, "outras") == 0))
		{
			$outros[] = $item;
		}
		else
		{
			$nova[] = $item;
		}
	}
	$lista = array_merge($nova, $outros);
	unset($nova, $outros);
	return;
}
#####################################################################################################
function Excel($dados = false)
{
	$default = array(
		"file"=>"excel_projeto_".date("Y-m-d_H-m-s").".xls",
		"lista"=>false,
		"html"=>true,
		"campos"=>false,
		"download"=>true,
		"maiusculo"=>true,
		"posicao"=>0,
		"total"=>0,
		"pasta"=>"",
		"tamanhofile"=>30,
		"particionar"=>false,
		"funcao"=>"GetDadosExcel"
	);
	$dados = CompletaArray($dados, $default);
	if(!empty($dados['download']))
	{
		header('Content-type: application/x-msdownload');
		header('Content-Disposition: attachment; filename='.$dados['file'].'.xls');
		header('Pragma: no-cache');
		header('Expires: 0');
	}
	$spreadsheet = "";
	if(empty($dados['lista']))
	{
		$spreadsheet = "Falha ao gerar o arquivo!\t";
		if(!empty($dados['download']))
			echo $spreadsheet;
		else
		{
			if(empty($dados['pasta']))
			{
				$caminho = GetPasta("/arquivos/excel/");
			}
			else
			{
				$caminho = $dados['pasta'];
			}
			CriarPastas($caminho);
			$file = $caminho.$dados['file'];
			file_put_contents($file,utf8_decode($spreadsheet),FILE_TEXT);
		}
		return;
	}
	$n = count($dados['lista']);
	$posicao = $dados['posicao'] + $n;
	$finalizado = false;
	if(($dados['posicao'] == 0)&&($dados['total'] == 0))
	{
		$finalizado = true;
	}
	elseif($posicao >=  $dados['total'])
	{
		$finalizado = true;
	}
	if( $n > 0)
	{
		if($dados['posicao'] == 0)
			$spreadsheet = MontarCabecario($dados);
		
		foreach($dados['lista'] as $key=>$obj)
		{
			if(method_exists($obj,$dados['funcao']))
			{
				if($dados['funcao'] == "GetDadosExcel")
					$linha = $obj->GetDadosExcel();
				else
				{
					$linha = call_user_func(array($obj, $dados['funcao']));
				}
			}
			else
			{
				$linha = $obj->GetDados();
			}
			$spreadsheet .= MontarLinha($dados['campos'], $linha, $dados['html']);
		}
	}
	else
	{
		$spreadsheet .= "Nenhum registro foi encontrado!\t";
	}
	if(!empty($dados['download']))
		echo $spreadsheet;
	else
	{
		if(empty($dados['pasta']))
		{
			$caminho = GetPasta("/arquivos/excel/");
		}
		else
		{
			$caminho = $dados['pasta'];
		}
		CriarPastas($caminho);
		$file = $caminho.$dados['file'];
		$nomeFile = $dados['file'];
		
		if($dados['posicao'] == 0)
		{
			if($finalizado && $dados['html'])
				$spreadsheet .= "</table>";
			file_put_contents($file,utf8_decode($spreadsheet),FILE_TEXT);
		}
		else
		{
			if (is_writable($file))
			{
				if (!$handle = fopen($file, 'a'))
				{
					echo "Não foi possível abrir o arquivo ({$file})";
					if(!empty($dados['download']))
						exit;
					else
						return "";
				}
				if($finalizado && $dados['html'])
					$spreadsheet .= "</table>";
				if (fwrite($handle,utf8_decode($spreadsheet)) === FALSE)
				{
					echo "Não foi possível escrever no arquivo ({$file})";
					if(!empty($dados['download']))
						exit;
					else
						return "";
				}
				fclose($handle);
				if((!empty($dados['particionar']))&&(!$finalizado))
				{
					$tamanho = filesize($file);
					$limite = strval($dados['tamanhofile']) * 1024 * 1024;
					if($tamanho >= $limite)
					{
						$nomeFile = gera_Nova_Parte($nomeFile);
						$file = $caminho.$nomeFile;
						$spreadsheet = MontarCabecario($dados);
						file_put_contents($file, utf8_decode($spreadsheet), FILE_TEXT);
					}
				}
			}
			else
			{
				echo "O arquivo {$file} não pode ser alterado";
				if(!empty($dados['download']))
					exit;
				else
					return "";
			}
		}
	}
	return $nomeFile;
}
########################################################################################################################
function gera_Nova_Parte($file = "")
{
	if(empty($file))
		$file = "excel_projeto_".date("Y-m-d_H-m-s").".xls";
	else
	{
		$pos = stripos($file, "_parte_");
		if($pos === false)
		{
			$file = str_replace(".xls", "_Parte_1.xls", $file);
		}
		else
		{
			$primeiraparte = substr($file, 0, $pos);
			$segundaparte = substr($file, $pos);
			$segundaparte = str_replace(".xls", "", $segundaparte);
			$segundaparte = str_ireplace("_Parte_", "", $segundaparte);
			$parte = strval($segundaparte) + 1;
			$file = $primeiraparte."_Parte_{$parte}.xls";
		}
	}
	return $file;
}
########################################################################################################################
function GetPasta($caminho = "")
{
	$aux = substr($caminho,0, 1);
	if($aux == "/")
		$caminho = substr($caminho,1);
	$aURL = dirname(BASEPATH)."/{$caminho}";
	return $aURL;
}
########################################################################################################################
function GetCamposCabecario(&$dados = false)
{
	if(!$dados)
		return "";
	if(empty($dados['campos']))
	{
		if(empty($dados['lista']))
			return "";
		$obj = $dados['lista'][0];
		if(empty($obj))
			return "";
		if(method_exists($obj,'CamposExcel'))
		{
			$campos = $obj->CamposExcel();
		}
		else
		{
			$columns = $obj->GetDados();
			foreach($columns as $nome=>$valor)
			{
				if(!is_numeric($nome))
					$campos[$nome] = $nome;
			}
		}
		$dados['campos'] = $campos;
	}
	else
		$campos = $dados['campos'];
	return $campos;
}
########################################################################################################################
function MontarCabecario(&$dados = false)
{
	if(!$dados)
		return "";
	$spreadsheet = "";
	if(empty($dados['campos']))
	{
		if(empty($dados['lista']))
			return "";
		$obj = $dados['lista'][0];
		if(empty($obj))
			return "";
		if(method_exists($obj,'CamposExcel'))
		{
			$campos = $obj->CamposExcel();
		}
		else
		{
			$columns = $obj->GetDados();
			foreach($columns as $nome=>$valor)
			{
				if(!is_numeric($nome))
					$campos[$nome] = $nome;
			}
		}
		$dados['campos'] = $campos;
	}
	else
		$campos = $dados['campos'];
	$maiusculo = $dados['maiusculo'];
	foreach ($campos as $key => $v)
	{
		if($maiusculo)
			$aux = Maiusculo($key);
		else
			$aux = $key;
		if($dados['html'])
			$spreadsheet .= "<th align='center' valign='middle' bgcolor='#FB7474' color='#ffffff'>{$aux}</th>";
		else
			$spreadsheet .= "{$aux}\t";
	}
	if($dados['html'])
		$spreadsheet = "<table  dir='ltr' border='1' cellspacing='0' cellpadding='1'><tr>{$spreadsheet}</tr>";
	return $spreadsheet;
}
########################################################################################################################
function MontarLinha($Campos = [], &$r = false, $html = false)
{
	if(!$r)
		return "";
	$linha = "";
	$cor = SetColor();
	foreach ($Campos as $nome)
	{
		if(empty($r[$nome]))
			$aux = "";
		else
			$aux = $r[$nome];
		$linha .= MontarCelula($aux, $html, $cor);
	}
	if($html)
		$linha = "<tr>{$linha}</tr>";
	else
		$linha = "\n{$linha}";
	return $linha;
}
#######################################################################################################################
function SetColor()
{
	static $CorLinha = "#ffffff";
	if($CorLinha == "#ffffff")
		$CorLinha = "#E4E4E4";
	else
		$CorLinha = "#ffffff";
	return $CorLinha;
}
#######################################################################################################################
function IsHtml($html = "")
{
	return preg_match_all('/<(.+?)[\s]*\/?[\s]*>/si', $html);
}
#######################################################################################################################
function Minusculo($texto = "")
{
    $convertePara = array("á", "à", "â", "ã", "ä", "é", "è", "ê", "ë", "í", "ì", "î", "ï", "ó", "ò", "ô", "õ", "ö", "ú", "ù", "û", "ü", "ç");
    $converteDe = array("Á", "À", "Â", "Ã", "Ä", "É", "È", "Ê", "Ë", "Í", "Ì", "Î", "Ï", "Ó", "Ò", "Ô", "Õ", "Ö", "Ú", "Ù", "Û", "Ü", "Ç");
    $texto = strtolower($texto);
    return str_replace($converteDe, $convertePara, $texto);
}
#######################################################################################################################
function Maiusculo($texto = "")
{
    $converteDe = array("á", "à", "â", "ã", "ä", "é", "è", "ê", "ë", "í", "ì", "î", "ï", "ó", "ò", "ô", "õ", "ö", "ú", "ù", "û", "ü", "ç");
    $convertePara = array("Á", "À", "Â", "Ã", "Ä", "É", "È", "Ê", "Ë", "Í", "Ì", "Î", "Ï", "Ó", "Ò", "Ô", "Õ", "Ö", "Ú", "Ù", "Û", "Ü", "Ç");
    $texto = strtoupper($texto);
    return str_replace($converteDe, $convertePara, $texto);
}
#######################################################################################################################
function MontarCelula(&$AUX = false, $html = false, $cor = "#ffffff")
{
	if($html)
	{
		if( (is_double($AUX)) || (is_float($AUX)) )
		{
			$celula = jMoney($AUX);
			$celula = "<td bgcolor='{$cor}' valign='middle' align='right'>{$celula}</td>";
		}
		elseif( (is_int($AUX)) || (is_numeric($AUX)) || (is_integer($AUX)) )
			$celula = "<td bgcolor='{$cor}' valign='middle' align='right'>{$AUX}</td>";
		else
		{
			if(!IsHtml($AUX))
				$AUX = nl2br($AUX);
			$celula = "<td bgcolor='{$cor}' valign='middle'  align='left'>{$AUX}</td>";
		}
	}
	else
	{
		if( (is_double($AUX)) || (is_float($AUX)) )
			$celula = jMoney($AUX)."\t";
		elseif( (is_int($AUX)) || (is_numeric($AUX)) || (is_integer($AUX)) )
			$celula = $AUX."\t";
		else
		{
			$AUX = preg_replace('/\\r\\n/m', ' ', $AUX);
			$AUX = preg_replace('/\\n/m', ' ', $AUX);
			$AUX = preg_replace('/\\t/m', '   ', $AUX);
			$celula = $AUX."\t";
		}
	}
	return $celula;
}
#######################################################################################################################
function &GetColaborador($id = 0)
{
	$retorno = false;
	if(!empty($id))
	{
		$obj = GetModelo("colaborador");
		if($obj->Load($id))
			return $obj;
		else
			return $retorno;
	}
	else
	{
		$CI =& get_instance();
		$obj = GetModelo("colaborador");
		$dados = $CI->session->userdata();
		$obj->Carregar($dados);
		return $obj;
	}
}
#######################################################################################################################
function TamanhoUpload()
{
	$TamanhoPost = ini_get( 'post_max_size' );
	$TamanhoUpload = ini_get( 'upload_max_filesize' );
	$valor = min( $TamanhoPost, $TamanhoUpload );
	return $valor."B";
}
#######################################################################################################################
if ( !function_exists('mb_detect_encoding') )
{
	function mb_detect_encoding ($string, $enc=null, $ret=null)
	{
		static $enclist = array(
			'UTF-8', 'ASCII',
			'ISO-8859-1', 'ISO-8859-2', 'ISO-8859-3', 'ISO-8859-4', 'ISO-8859-5',
			'ISO-8859-6', 'ISO-8859-7', 'ISO-8859-8', 'ISO-8859-9', 'ISO-8859-10',
			'ISO-8859-13', 'ISO-8859-14', 'ISO-8859-15', 'ISO-8859-16',
			'Windows-1251', 'Windows-1252', 'Windows-1254',
		);
		
		$result = false;
		
		foreach ($enclist as $item)
		{
			$sample = iconv($item, $item, $string);
			if (md5($sample) == md5($string))
			{
				if ($ret === NULL) { $result = $item; } else { $result = true; }
				break;
			}
		}
		return $result;
	}
}
#######################################################################################################################
function CriarCurriculos()
{
	$CI = &get_instance();
	return $CI->db->query("CALL CriarCurriculoCache();");
}
#######################################################################################################################
function CarregarCurriculos($posicao = 0, $qtd = 50)
{
	$CI = &get_instance();
	return $CI->db->query("CALL CarregarCurriculos({$posicao}, {$qtd});");
}
#####################################################################################################
function LimparCurriculos()
{
	$CI = &get_instance();
	return $CI->db->query("CALL LimparCurriculos();");
}
#####################################################################################################
function SalvarCurriculo($idcurriculo = 0)
{
	if(empty($idcurriculo))
		return false;
	$curriculo = GetModelo("curriculocache");
	$sql = "SELECT idcurriculocache AS id FROM curriculocache WHERE idcurriculo = '{$idcurriculo}' LIMIT 1;";
	$idcurriculocache = $curriculo->GetSqlCampo($sql, "id", 0);
	$sql = "SELECT C.*,CB.nome AS colaborador, D.nomefantasia AS dataowners, DC.dadoscampos FROM curriculo C INNER JOIN dadoscurriculo DC
	FORCE INDEX(idxcurriculo) ON(C.idcurriculo = DC.idcurriculo) LEFT JOIN colaborador CB ON(C.idcolaborador = CB.idcolaborador)
	LEFT JOIN dataowners D ON(C.iddataowners = D.iddataowners) WHERE C.idcurriculo = '{$idcurriculo}' LIMIT 1;";
	$row = $curriculo->GetRow(false, $sql, false);
	if(empty($row))
		return false;
	$dados = json_decode($row['dadoscampos'], true);
	$row = array_merge($row, $dados, array("idcurriculocache"=>$idcurriculocache));
	unset($row['dadoscampos']);
	$curriculo->Carregar($row);
	return $curriculo->Salvar();
}
#####################################################################################################
function GerarIN( $dados = 0, $not_in = false)
{
	if( is_array( $dados ) )
	{
		$lista = '';
		foreach( $dados as $valor )
		{
			$valor = trim($valor);
			$lista .= ", '{$valor}'";
		}
		$lista = substr( $lista, 2 );
		if($not_in)
			return " NOT IN({$lista})";
		else
			return " IN({$lista})";
	}
	if($not_in)
		return " != '{$dados}'";
	else
		return " = '{$dados}'";
}
#####################################################################################################
function GetMimes($tipo = "extenção")
{
	$lista = array(
		'csv'	=>	array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain'),
		'pdf'	=>	array('application/pdf', 'application/force-download', 'application/x-download'),
		'xls'	=>	array('application/vnd.ms-excel', 'application/msexcel', 'application/x-msexcel', 'application/x-ms-excel', 'application/x-excel', 'application/x-dos_ms_excel', 'application/xls', 'application/x-xls', 'application/excel', 'application/download', 'application/vnd.ms-office', 'application/msword') ,
		'gtar'	=>	'application/x-gtar',
		'gz'	=>	'application/x-gzip',
		'gzip'  =>	'application/x-gzip',
		'tgz'	=>	array('application/x-tar', 'application/x-gzip-compressed'),
		'zip'	=>	array('application/x-zip', 'application/zip', 'application/x-zip-compressed', 'application/s-compressed', 'multipart/x-zip'),
		'rar'	=>	array('application/x-rar', 'application/rar', 'application/x-rar-compressed'),
		'gif'	=>	'image/gif',
		'jpeg'	=>	array('image/jpeg', 'image/pjpeg'),
		'jpg'	=>	array('image/jpeg', 'image/pjpeg'),
		'jpe'	=>	array('image/jpeg', 'image/pjpeg'),
		'png'	=>	array('image/png',  'image/x-png'),
		'tiff'	=>	'image/tiff',
		'tif'	=>	'image/tiff',
		'txt'	=>	'text/plain',
		'text'	=>	'text/plain',
		'rtx'	=>	'text/richtext',
		'rtf'	=>	'text/rtf',
		'doc'	=>	array('application/msword', 'application/vnd.ms-office'),
		'docx'	=>	array('application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/zip', 'application/msword', 'application/x-zip'),
		'dotx'	=>	array('application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/zip', 'application/msword'),
		'xlsx'	=>	array('application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'application/zip', 'application/vnd.ms-excel', 'application/msword', 'application/x-zip'),
		'xl'	=>	'application/excel',
		'xml'	=>	'application/xml',
		'ofx'	=>	array('application/octet-stream','application/ofx'),
		'oxps'	=>	array('application/octet-stream','application/oxps'),
		'ppt'	=>	array('application/vnd.ms-powerpoint'),
		'pptx'	=>	array('application/vnd.openxmlformats-officedocument.presentationml.presentation','application/vnd.ms-powerpoint')
	);
	if($tipo == "extenção")
	{
		$aux = array_keys($lista);
		sort($aux);
		$extencoes = "";
		foreach ($aux as $key => $value)
		{
			$extencoes .= ", {$value}";
		}
		if(!empty($extencoes))
		{
			$extencoes = substr($extencoes, 2);
		}
		return $extencoes;
	}
	elseif($tipo == "mimes")
	{
		$aux = $lista;
		ksort($aux);
		$mimes = "";
		foreach ($aux as $key => $value)
		{
			if(!is_array($value))
			{
				if(strpos($mimes, $value) === false)
					$mimes .= ", {$value}";
			}
			else
			{
				foreach ($value as $mime)
				{
					if(strpos($mimes, $mime) === false)
						$mimes .= ", {$mime}";
				}
			}
		}
		if(!empty($mimes))
		{
			$mimes = substr($mimes, 2);
		}
		return $mimes;
	}
	elseif($tipo == "lista")
	{
		return $lista;
	}
	elseif($tipo == "extenções")
	{
		$aux = array_keys($lista);
		sort($aux);
		return $aux;
	}
	elseif($tipo == "listamimes")
	{
		$aux = $lista;
		$mimes = [];
		foreach ($aux as $key => $value)
		{
			if(!is_array($value))
			{
				$mimes[] =  $value;
			}
			else
			{
				foreach ($value as $mime)
				{
					$mimes[] =  $mime;
				}
			}
		}
		$mimes = array_unique($mimes);
		sort($mimes);
		return $mimes;
	}
}
#####################################################################################################
function GetCampoConfig($nome = "", $default = "", $idcampo = 0, $nomecampo = false )
{
	$codigo = GetConfiguracao($nome, $idcampo);
	if($nomecampo)
		$sql = "SELECT coluna AS nome FROM campo WHERE tipo != 'Vaga' AND idcampo = '{$codigo}'";
	else
		$sql = "SELECT RetiraAcento(coluna) AS nome FROM campo WHERE tipo != 'Vaga' AND idcampo = '{$codigo}'";
	return GetSqlCampo($sql, "nome", $default);
}
#####################################################################################################
function emptyData($data = "" )
{
	if(empty($data))
		return true;
	if($data == "0000-00-00")
		return true;
	if($data == "0000-00-00 00:00:00")
		return true;
	return false;
}
#####################################################################################################
function createZip($files = array(), $destination = '', $overwrite = false)
{
	$validFiles = array();
	if(is_array($files))
	{
		foreach($files as $file)
		{
			if(file_exists($file['local']))
			{
				$validFiles[] = $file;
			}
		}
	}
	if(count($validFiles))
	{
		$zip = new ZipArchive();
		if($zip->open($destination,$overwrite ? ZIPARCHIVE::CHECKCONS : ZIPARCHIVE::CREATE) !== true) {
			return false;
		}
		foreach($validFiles as $key=>$file)
		{
			$zip->addFile($file['local'], $file['localname']);
		}
		$zip->close();
		return file_exists($destination);
	}
	else
	{
		return false;
	}
}
#####################################################################################################
function SorteiaLista($input = array())
{
	$rand_keys = array_rand($input, 1);
	return $input[$rand_keys];
}
#####################################################################################################
function lero_lero($palavra = 50)
{
	$lista = array("Nunca", "é", "demais", "lembrar", "o", "peso", "e", "o", "significado", "destes", "problemas,", "uma", "vez", "que", "a", "revolução", "dos", "costumes", "garante", "a", "contribuição", "de", "um", "grupo", "importante", "na", "determinação", "do", "sistema", "de", "participação", "geral","Não", "obstante,", "a", "determinação", "clara", "de", "objetivos", "deve", "passar", "por", "modificações", "independentemente", "das", "diretrizes", "de", "desenvolvimento", "para", "o", "futuro","Percebemos,", "cada", "vez", "mais,", "que", "o", "entendimento", "das", "metas", "propostas", "oferece", "uma", "interessante", "oportunidade", "para", "verificação", "do", "retorno", "esperado", "a", "longo", "prazo");
	$rand_keys = array_rand($lista, $palavra);
	$palavras = "";
	foreach ($rand_keys as $posicao)
	{
		$palavras .= $lista[$posicao] ." ";
	}
	return $palavras;
}
#####################################################################################################
function &ExplodePalavras($palavras = "")
{
	if(empty($palavras))
		return false;
	if(stripos($palavras, ";") !== false)
		$lista = explode(";", $palavras);
	elseif(stripos($palavras, ",") !== false)
		$lista = explode(",", $palavras);
	else
		$lista = array($palavras);
	foreach($lista as $key=>$palavra)
	{
		$palavra = trim($palavra);
		if(empty($palavra))
			unset($lista[$key]);
		else
			$lista[$key] = $palavra;
	}
	return $lista;
}
################################################################################################################
function GetSqlCampo($sql = "", $nome = "", $defult = false)
{
	if(empty($sql))
		return $defult;
	if(empty($nome))
		return $defult;
	$CI	=& get_instance();
	$query = $CI->db->query($sql);
	$row = $query->row_array();
	if (isset($row))
	{
		if(!empty($row[$nome]))
			return $row[$nome];
	}
	return $defult;
}
######################################################################################################################
function objectToArray($d)
{
	if (is_object($d))
	{
		$d = get_object_vars( $d );
	}
	if( is_array( $d ) )
	{
		return array_map( "objectToArray", $d );
	}
	else
	{
		return $d;
	}
}
####################################################################################################
function Escape_str($valor =  "")
{
	if(empty($valor))
		return $valor;
	$CI	=& get_instance();
	return $CI->db->escape_str($valor);
}
####################################################################################################
function URL_Imagem($file =  "")
{	
	$link = base_url("assets/img/{$file}");
	return $link;
}
####################################################################################################
function GetDomino($url = "")
{
	$CI	=& get_instance();
	$config =& get_config();
	// Set the base_url automatically if none was provided
	if (empty($config['dominio']))
	{
		if (isset($_SERVER['SERVER_ADDR']))
		{
			if (strpos($_SERVER['SERVER_ADDR'], ':') !== FALSE)
			{
				$server_addr = '['.$_SERVER['SERVER_ADDR'].']';
			}
			else
			{
				$server_addr = $_SERVER['SERVER_ADDR'];
			}

			$dominio = (is_https() ? 'https' : 'http').'://'.$server_addr . substr($_SERVER['SCRIPT_NAME'], 0, strpos($_SERVER['SCRIPT_NAME'], basename($_SERVER['SCRIPT_FILENAME'])));
		}
		else
		{
			$dominio = 'http://localhost/';
		}

		$CI->config->set_item('dominio', $dominio);
		$config['dominio'] = $dominio;
	}

	return $config['dominio'].$url;
}
################################################################################################################
function isMobile() {
	$useragent=$_SERVER['HTTP_USER_AGENT'];
	if(preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino/i',$useragent)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',substr($useragent,0,4)))
		return true;
	
	return false;
}
?>