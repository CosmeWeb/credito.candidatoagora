<!DOCTYPE html>
<html>
<head>
<style>
@page{margin:0px 0px;}
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
    margin:10px 0px;
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
	padding: 0px 0px 8px 0px;
	border-bottom: 1px solid #cecece;
}
.painel .titulo b{color:brown;}
.painel .corpo{padding: 3px 0px 3px 0px;}
.painel label{padding: 0px 8px 0px 0px;font-size: 15px; font-weight: bold;}
.painel span{font-size: 14px;}
.painel .lista{
    margin:0px 0px;
	padding: 0px;
	width:100%;
}
.painel .lista td{
    width:33%;
	text-align:center;
	padding: 10px 0px;
}.painel .livazio{
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
				<img   src="<?php echo base_url('assets/img/sistema/logosistema.jpg'); ?>"/>
			</td>
			<td style="width: 2%;">
				&nbsp;
			</td>
			<td style="width:78%;">
				<table class="cabpainel">
					<tr><td class="titulo"><h2><b>Vaga:</b> <?php echo $obj->titulodavaga; ?></h2></td></tr>
					<tr><td class="titulo"><h4><b>Empresa:</b> <?php echo $obj->empresacontratante; ?></h4></td></tr>
					<tr><td class="titulo"><h3><b>Código:</b> <?php echo $obj->LerCodigoVaga()." <b>Emitido em:</b> ".date("d/m/Y"); ?></h3></td></tr>
				</table>
			</td>
		</tr>
	</table>
	<table class="painel">
		<tr>
			<td class="titulo">Dados da contratante</td>
		</tr>
		<tr>
			<td class="corpo">
			<label>Nome da empresa contratante?</label>
			<span><?php echo $obj->empresacontratante; ?></span>
			</td>
		</tr>
		<tr>
			<td class="corpo">
			<label>Setor de atuação:</label>
			<span><?php echo $obj->GetSetor(); ?></span>
			</td>
		</tr>
		<tr>
			<td class="corpo">
			<label>Quando você pretende contratar o candidato para esta vaga?</label>
			<span><?php echo $obj->tempocontratacao; ?></span>
			</td>
		</tr>
		<tr>
			<td class="corpo">
			<label>Quantidade de funcionários:</label>
			<span><?php echo $obj->GetTamanho(); ?></span>
			</td>
		</tr>
		<tr>
			<td class="corpo">
			<label>Atual nível de faturamento anual da empresa?</label>
			<span><?php echo $obj->GetFaturamento(); ?></span>
			</td>
		</tr>
		<tr>
			<td class="corpo">
			<label>Como você entende o momento atual da sua empresa?</label>
			<span><?php echo $obj->GetMomentoAtualEmpresa(); ?></span>
			</td>
		</tr>
	</table>
	<table class="painel">
		<tr>
			<td class="titulo">Quais tipos de empresas você gostaria que o candidato ideal esteja trabalhando ou tenha trabalhado anteriormente?</td>
		</tr>
		<tr>
			<td class="corpo">
			<label>Nacionalidade das empresas nas quais o profissional trabalhou?</label>
			<span><?php echo $obj->nacionalidadeempresasprofissionaltrabalhou; ?></span>
			</td>
		</tr>
		<tr>
			<td class="corpo">
			<label>Considerar apenas empresas listadas nas 1.000 maiores empresas no Brasil?</label>
			<span><?php echo $obj->melhores1000empresa; ?></span>
			</td>
		</tr>
		<tr>
			<td class="corpo">
			<label>Considerar apenas empresas listadas na bolsa?</label>
			<span><?php echo $obj->listadaembolsa; ?></span>
			</td>
		</tr>
		<tr>
			<td class="corpo">
			<label>Considerar apenas empresas premiadas pelo GPTW (Great Place To Work)?</label>
			<span><?php echo $obj->gptw; ?></span>
			</td>
		</tr>
		<tr>
			<td class="corpo">
			<label>Considerar apenas empresas do prêmio inovação?</label>
			<span><?php echo $obj->perfilinovacao; ?></span>
			</td>
		</tr>
		<tr>
			<td class="corpo">
			<label>Considerar apenas startups?</label>
			<span><?php echo $obj->startup; ?></span>
			</td>
		</tr>
	</table>
	<table class="painel">
		<tr>
			<td class="titulo">Informações sobre a vaga</td>
		</tr>
		<tr>
			<td class="corpo">
			<label>Título da vaga:</label>
			<span><?php echo $obj->titulodavaga; ?></span>
			</td>
		</tr>
		<tr>
			<td class="corpo">
			<label>Área:</label>
			<span><?php echo $obj->GetArea(); ?></span>
			</td>
		</tr>
		<tr>
			<td class="corpo">
			<label>Nível:</label>
			<span><?php echo $obj->GetNivel(); ?></span>
			</td>
		</tr>
		<tr>
			<td class="corpo">
			<label>Subarea:</label>
			<span><?php echo $obj->GetSubarea(); ?></span>
			</td>
		</tr>
		<tr>
			<td class="corpo">
			<label>Cargos correlatos existentes no mercado:</label>
			<span><?php echo $obj->GetCargosCorrelatos(); ?></span>
			</td>
		</tr>
		<tr>
			<td class="corpo">
			<label>Linha de reporte:</label>
			<span><?php echo $obj->linhadereporte; ?></span>
			</td>
		</tr>
		<tr>
			<td class="corpo">
			<label>Faixa de remuneração:</label>
			<span><?php echo $obj->FaixaDeRemuneracao(); ?></span>
			</td>
		</tr>
		<tr>
			<td class="corpo">
			<label>Descrição da vaga:</label>
			<span><?php echo $obj->descricaodavaga; ?></span>
			</td>
		</tr>
		<tr>
			<td class="corpo">
			<label>Quais competências os candidatos devem ter para satisfazer a posição?</label>
			<span><?php echo $obj->GetCompetencias(); ?></span>
			</td>
		</tr>
		<tr>
			<td class="corpo">
			<label>A vaga é remoto:</label>
			<span><?php echo $obj->remoto; ?></span>
			</td>
		</tr>
		<tr>
			<td class="corpo">
			<label>Estado:</label>
			<span><?php echo $obj->GetEstado(); ?></span>
			</td>
		</tr>
		<tr>
			<td class="corpo">
			<label>Cidade:</label>
			<span><?php echo $obj->GetCidade(); ?></span>
			</td>
		</tr>
		<tr>
			<td class="corpo">
			<label>Candidatos no raio de:</label>
			<span><?php echo $obj->GetRaiodePesquisa(); ?></span>
			</td>
		</tr>
		<tr>
			<td class="corpo">
			<label>Mobilidade:</label>
			<span><?php echo $obj->GetMobilidade(); ?></span>
			</td>
		</tr>
	</table>
	<table class="painel quebrapagina">
		<tr>
			<td class="titulo">Setores target para <b>incluir</b> na busca</td>
		</tr>
		<tr>
			<td class="corpo">				
				<label>Setores:</label>
				<span><?php echo $obj->GetListaSetores(); ?></span>
			</td>				
		</tr>
	</table>	
	<table class="painel">
		<tr>
			<td class="titulo">Empresas target para <b>incluir</b> na busca</td>
		</tr>
		<?php 
		if($obj->selecionarempresas == "Sim"):		
		?>
			<tr><td class="livazio">Você optou pela seleção de empresas target por especialistas</td></tr>
		<?php
		else:
			$lista = $obj->GetListaEmpresas();
			if(empty($lista)):
			?>
			<tr><td class="livazio">Nenhuma empresa selecionada</td></tr>
			<?php 
			else:
				$setor = "";
				foreach($lista as $key=>$row):
					if($row['setor'] != $setor)
					{
						$setor = $row['setor'];
						if(!empty($key))
							echo '</span></td></tr>';
						echo '<tr><td class="corpo"><label>'.$setor.':</label><span>';
						echo $row['empresa'];
					}
					else
					{
						echo ", ".$row['empresa'];
					}
					?>
			<?php 
				endforeach;
				echo '</span></td></tr>';
			endif;
		?>
		<tr>
			<td class="corpo">
			<label>Considerar outras empresas fora das opções acima marcadas, mas do mesmo setor identificado com target?</label>
			<span><?php echo $obj->incluirempresasforatarget; ?></span>
			</td>
		</tr>
		<tr>
			<td class="corpo">
			<label>Outras empresas fora das opções acima marcadas:</label>
			<span><?php echo $obj->GetEmpresasCorrelatos(); ?></span>
			</td>
		</tr>
		<?php
		endif;
		?>
		<tr>
			<td class="corpo">
			<label>Excluir candidatos que já tenham trabalhado na empresa contratante no passado?</label>
			<span><?php echo $obj->excluirprofissionaisjatrabalhouempresa; ?></span>
			</td>
		</tr>
	</table>
	<table class="painel">
		<tr>
			<td class="titulo">Empresas target para <b>excluir</b> da busca</td>
		</tr>
		<?php 
		$lista = $obj->GetListaEmpresasExcluir();
		if(empty($lista)):
		?>
		<tr><td class="livazio">Nenhuma empresa selecionada</td></tr>
		<?php 
		else:
			$setor = "";
			foreach($lista as $key=>$row):
				if($row['setor'] != $setor)
				{
					$setor = $row['setor'];
					if(!empty($key))
						echo '</span></td></tr>';
					echo '<tr><td class="corpo"><label>'.$setor.':</label><span>';
					echo $row['empresa'];
				}
				else
				{
					echo ", ".$row['empresa'];
				}
				?>
		<?php 
			endforeach;
			echo '</span></td></tr>';
		endif;
		?>
	</table>
</body>
</html>