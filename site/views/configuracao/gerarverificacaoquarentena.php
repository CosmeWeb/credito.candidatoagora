<div class="col-lg-12">
	<div class="panel panel-primary">
		<div class="panel-heading"><?php echo __("Verificação de quarentena."); ?></div>
		<div class="panel-body pan">
			<form action="#" method="POST" class="form-horizontal">
				<div class="form-body pal">
					<div class="form-group">
						<div id="flat-skin" class="row skin skin-flat">
							<div class="col-md-12">
								<h5>
									<?php
										echo __("Verifica os currículos que estão em quarentena no sistema.");
									?>
								</h5>
								<div>
									<span class="col-md-12" id="lblmsm">
                                    <?php
                                        if($total <= 0)
                                            echo __("<b>Atenção: </b> Não há nenhum currículos em quarentena.");
                                        else
	                                        echo sprintf(__("<b>%2d </b> registros de quarentana no sistema."), $total);
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
                            <button type="button" class="btn btn-danger" style="float: right; margin-right: 20px;" onclick="IniciarVerificacaoDeQuarentena();"><i class="fa fa-file-pdf-o"></i> <?php echo __("Verificar currículos em quarentana"); ?></button>&nbsp
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
function IniciarVerificacaoDeQuarentena()
{
	$("#Geracurriculo").css("display","block");
	$("#processo").html("<?php echo __("0% Verificando quarentena..."); ?>");
	$("#processo").css("width","0%");
    VerificacaoDeQuarentena(0, 0, TotalCurriculos);
}
function FecharCurriculos()
{
	$("#processo").css("width","100%");
	$("#processo").html("<?php echo __("100% Verificação finalizada."); ?>");
	MsnSucesso("Sucesso", "<?php echo __("Verificação finalizada."); ?>");
	$("#Geracurriculo").delay(2000).fadeOut();
    $("#lblmsm").html("<?php echo __("Verificação finalizada com sucesso."); ?>");
}
function VerificacaoDeQuarentena(id, posicao, total)
{
	var url =  GetDominio("index.php/api/verificacaodequarentena");
    var data = {"id":id,"posicao":posicao,"total":total};
	$.ajax({
        url: url,
        method:'POST',
        data:data,
        beforeSend:function(xhr){
            if(posicao == 0)
            {
                $("#Geracurriculo").css("display","block");
                $("#processo").css("width","0%");
                $("#processo").html("<?php echo __("0% dos registros da quarentena foram verificado..."); ?>");
            }
            else
            {
                var aux = Math.ceil((posicao/total) * 100);
                $("#processo").css("width",aux + "%");
                $("#processo").html("<?php echo __("\"+aux+\"% dos registros da quarentena foram verificado..."); ?>");
            }
        },
		success: function (data) {
			if(Vazio(data))
			{
				MsnDanger("Erro", "Ocorreu um erro desconhecido.");
				return;
			}
			if(data.sucesso)
			{
				if(data.finalizado)
                {
                    FecharCurriculos();
                }
                else
                {
                    MsnSucesso(data.titulo, data.mensagem);
                    VerificacaoDeQuarentena(data.id, data.posicao, data.total);
                }
			}
			else
			{
                MsnDanger("Erro", data.erro);
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