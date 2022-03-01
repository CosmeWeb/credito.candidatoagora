<div class="col-lg-12">
	<div class="panel panel-primary">
		<div class="panel-heading"><?php echo __("Gerar PDF dos anexo de Currículos."); ?></div>
		<div class="panel-body pan">
			<form action="#" method="POST" class="form-horizontal">
				<div class="form-body pal">
					<div class="form-group">
						<div id="flat-skin" class="row skin skin-flat">
							<div class="col-md-12">
								<h5>
									<?php
										echo __("Converte os arquivos DOC ou DOCX dos anexos de currículos em PDF no sistema.");
									?>
								</h5>
								<div>
									<span class="col-md-12" id="lblmsm">
                                    <?php
                                        if($total <= 0)
                                            echo __("<b>Atenção: </b> Não há nenhum anexo a ser gerado em PDF.");
                                        else
	                                        echo sprintf(__("<b>%2d </b> anexos a serem convertido em PDF."), $total);
                                    ?>
                                    </span>
								</div>
							</div>
							<div class="col-md-12">
								<div id="Geracurriculo" class="progress progress-striped active" style="clear: both; margin-top: 20px; background-color: #b7b5b5; display: none;">
									<div id="processo" role="progressbar" aria-valuetransitiongoal="100" class="progress-bar progress-bar-danger" aria-valuenow="100" style="width: 0%;"><?php echo __("Carregando currículos 0%"); ?></div>
								</div>
							</div>
						</div>
					</div>

				<div class="form-actions none-bg">
					<div class="col-md-12">
                        <button type="button" class="btn btn-danger" style="float: right;" onclick="goBack();"><i class="fa fa-caret-square-o-left"></i> <?php echo __("Voltar"); ?></button>&nbsp
                        <?php
                        if($total > 0):
                        ?>
                            <button type="button" class="btn btn-danger" style="float: right; margin-right: 20px;" onclick="IniciarGerarPDF();"><i class="fa fa-file-pdf-o"></i> <?php echo __("Gerar PDF"); ?></button>&nbsp
                        <?php
                        endif;
                        ?>
                    </div>
				</div>
			</form>
		</div>
	</div>
</div>
<script>
var TotalCurriculos = <?php echo $total; ?>;
function goBack() {
    window.history.back()
}
function IniciarGerarPDF()
{
	$("#Geracurriculo").css("display","block");
	$("#processo").html("<?php echo __("0% Carregando currículos..."); ?>");
	$("#processo").css("width","0%");
    ReiniciarOoservice(0);
}
function FecharCurriculos()
{
	$("#processo").css("width","100%");
	$("#processo").html("<?php echo __("100% Processamento finalizado."); ?>");
	MsnSucesso("Sucesso", "<?php echo __("Processamento finalizado."); ?>");
	$("#Geracurriculo").delay(2000).fadeOut();
    $("#lblmsm").html("<?php echo __("PDF gerados com sucesso."); ?>");
}
function GerarPDF(posicao)
{
	if(TotalCurriculos <= posicao)
	{
		FecharCurriculos();
		return
	}
	var url =  GetDominio("index.php/api/converteanexos");
	$.ajax({
		type: 'GET',
		dataType: 'json',
		url: url,
		success: function (data) {
			if(Vazio(data))
			{
				MsnDanger("Erro", "Ocorreu um erro desconhecido.");
				return;
			}
			if(data.sucesso)
			{
				posicao++;
				let aux = Math.ceil((posicao/TotalCurriculos) * 100);
				$("#processo").css("width",aux + "%");
				$("#processo").html("<?php echo __("\"+aux+\"% Processando currículos..."); ?>");
				aux = posicao % 200;
				if(aux == 0)
                    ReiniciarOoservice(posicao);
				else
                    GerarPDF(posicao);
			}
			else
			{
                MsnDanger("Erro", data.erro);
                if(data.reiniciar)
                {
                    //alert("Reiniciar servidor openoffce");
                    ReiniciarOoservice(posicao);
                }
                else
                {
                    posicao++;
                    aux = Math.ceil((posicao/TotalCurriculos) * 100);
                    $("#processo").css("width",aux + "%");
                    $("#processo").html("<?php echo __("\"+aux+\"% Processando currículos..."); ?>");
                    GerarPDF(posicao);
                }
			}
			return;
		},
		fail: function (jqXHR, status, errorThrown) {
			throw Error('JSONFixture could not be loaded: ' + url + ' (status: ' + status + ', message: ' + errorThrown.message + ')')
		}
	});
}
function ReiniciarOoservice(posicao)
{
    var url =  GetDominio("index.php/api/reiniciarooservice");
    $.ajax({
        type: 'GET',
        dataType: 'json',
        url: url,
        success: function (data) {
            if(Vazio(data))
            {
                MsnDanger("Erro", "Ocorreu um erro desconhecido.");
                return;
            }
            if(data.sucesso)
            {
                GerarPDF(posicao);
            }
            else
            {
                alert("Reiniciar servidor openoffce");
            }
            return;
        },
        fail: function (jqXHR, status, errorThrown) {
            throw Error('JSONFixture could not be loaded: ' + url + ' (status: ' + status + ', message: ' + errorThrown.message + ')')
        }
    });
}
$(function () {

});
</script>