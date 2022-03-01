<!DOCTYPE html>
<html>
<head>
<style>
#footer { position: fixed; right: 0px; bottom: 10px; text-align: center;border-top: 1px solid black;}
        #footer .page:after { content: counter(page, decimal); }
@page { margin: 20px 30px 40px 50px; }
*{
	margin:10px 0px;
	padding: 0px;
	font-family: 'Source Sans Pro','Open Sans','Noto Sans KR';
}
html{margin: 0cm;}	
body {
    position: relative;
    float: left;
    display: block;
    width:19cm;
    margin: 1cm;
    height: auto;
	font-family: 'Source Sans Pro','Open Sans','Noto Sans KR';
	background-color:transparent;
}
img{
	position: relative;
    float: left;
    display: block;
    width:100%;
    margin:35px 0px;
	padding: 0px;
    height: auto;
}
h2, h4,h3{
	width:100%;
    margin: 0;
	padding: 0px;
	font-size: 18px;
}
h2 b, h4 b, h3 b{
	font-weight: bolder;clear: none;
}
h4{font-size: 16px;}
h3{font-size: 14px; font-weight: normal; width:100%;}
.painel{
	margin: 10px 0px 15px 0px;
	width:100%;
}
.painel .titulo{
	text-align: center;
	font-size: 20px;
	font-weight: bold;
	padding: 8px 0px 16px 0px;
}
.painel .titulo b{color:brown;}

.paineltab{
	margin: 10px 0px 15px 0px;
    width: 100%;
    border: #efefef 1px solid;
    padding: 0px;
    border-collapse: collapse;
}
.paineltab .titulo{
	background-color: #fff;
    color: #000;
    text-align: center;
    border-bottom: 1px solid #efefef;
    border-right: 1px solid #efefef;
	font-weight: bold;
}

.paineltab tr.rodape .titulo{
	padding: 0px 10px 0px 0px;
	background-color: #fff;
    color: #000;
    text-align: center;
	font-weight: bold;
}

.paineltab tr.rodape .corpo{
	padding: 0px 0px 0px 8px;
    text-align: center;
    border-bottom: 1px solid #efefef;
	background-color:#fff;
	font-weight: bold;
}
.paineltab .data{
	padding: 0px 0px 0px 0px;
    text-align: center;
    border-bottom: 1px solid #efefef;
    border-right: 1px solid #efefef;
}
.paineltab .corpo{
	padding: 0px 0px 0px 8px;
    text-align: center;
    border-bottom: 1px solid #efefef;
}
.paineltab .livazio{
    width:100%;
	text-align:center;
	padding: 30px 0px;
}
.quebrapagina{
	page-break-before: left;
}
.cabpainel{
	margin: 10px 0px 15px 0px;
	width:100%;
}
.cabpainel .titulo{
	text-align: left;
	font-size: 20px;
	padding: 0px 0px 0px 0px;
}
.cabecario{
	margin: 0px 0px 0px 0px;
	width:100%;
}
</style>
</head>
<body>
	<table class="cabecario">
		<tr>
			<td style="width: 20%;">
				<img   src="<?php echo base_url('assets/images/avatar/logosistema.jpg'); ?>"/>
			</td>
			<td style="width: 2%;">
				&nbsp;
			</td>
			<td style="width:78%;">
				<table class="cabpainel">
					<?php
					if(!empty($empresa)):
					?>
					<tr><td class="titulo"><h2><b>Empresa:</b> <?php echo $empresa; ?></h2></td></tr>
					<?php
					endif;
					?>
					<tr><td class="titulo"><h3><b>Cliente responsável:</b> <?php echo $cliente; ?></h3></td></tr>
					<tr><td class="titulo"><h3><b>Período:</b> <?php echo $periodo; ?></h3></td></tr>
					<tr><td class="titulo"><h3><b>Emitido em:</b> <?php echo date("d/m/Y"); ?></h3></td></tr>
				</table>
			</td>
		</tr>
	</table>
	<table class="painel">
		<tr>
			<td class="titulo">Histórico de tempo estimado de acesso</td>
		</tr>
	</table>
	<table class="paineltab">
		<tr>
			<td class="titulo">Data</td>
			<td class="titulo">Tempo estimado de acesso</td>
		</tr>
		<tr>
			<td class="data" colspan="2">
				&nbsp;
			</td>
		</tr>
		<?php
			$total = 0;
			if(!empty($lista)):
				foreach($lista as $obj):
					$row = $obj->GetDadosExcelPorCliente($obj->GetDados(), true);
					$total += $row['tempo'];
		?>
		<tr>
			<td class="data">
			<?php echo $row['dia']; ?>
			</td>
			<td class="corpo">
			<?php echo $row['tempototal']; ?>
			</td>
		</tr>
		<?php
				endforeach;
			else:
		?>
		<tr><td class="livazio">Nenhuma data foi localizada</td></tr>
		<?php
			endif;
		?>
		<tr>
			<td class="data" colspan="2">
				&nbsp;
			</td>
		</tr>
		<tr class="rodape">
			<td class="titulo">Total</td>
			<td class="corpo"><?php echo $rastreio->FormataData($total); ?></td>
		</tr>
	</table>
</body>
</html>