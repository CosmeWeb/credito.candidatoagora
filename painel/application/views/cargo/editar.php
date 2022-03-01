<div class="col-lg-12">
	<div class="panel panel-blue">
		<div class="panel-heading"><?php echo __("Formulário de Cargo"); ?></div>
		<div class="panel-body pan">
			<form id="frmcargo" action="<?php echo site_url('cargo/editar/'.$obj->idcargo); ?>" method="POST" class="form-horizontal">
				<div class="form-body pal">
					<input id="idcargo" name="idcargo" type="hidden" value="<?php echo $obj->FormGet('idcargo'); ?>">
					<div class="form-group">
						<label for="cargo" class="col-md-3 control-label"><?php echo __("Cargo"); ?>
						<span class="require">*</span></label>
						<div class="col-md-6">
							<div class="input-icon">
							<i class="fa fa-user-md"></i>
							<input id="cargo" name="cargo" type="text" value="<?php echo $obj->FormGet('cargo'); ?>" class="form-control">
							<?php echo form_error('cargo', '<div class="alert alert-error msn-error">', '</div>'); ?>
							</div>
						</div>
					</div>
					<h4 class="block-heading col-md-9 col-md-offset-3"><?php echo __("Termo Semelhante"); ?></h4>
                    <div class="row col-md-12">
                        <div class=" col-md-3">
                            <button type="button" class="btn btn-blue" onclick="AdicionarTermo()" style="margin-left: 10%;"><i class="fa fa-plus-square"></i> <?php echo __("Adicionar Termo"); ?></button>
                        </div>
                        <div class=" col-md-9" id="AreaTermo">
							<div class="col-md-12" id="Termo0" style="margin-bottom: 10px;">
								<div class="input-group">
									<div class="input-group-btn">
										<input type="text" class="form-control" id="palavraschaves0"  name="palavraschaves[]" value="">
										<button type="button" class="btn btn-green" title="Excluir termo" onclick="ExcluirTermo(this,'0')">
											<i class="fa fa-remove"></i>
										</button>
									</div>
								</div>
							</div>
                        </div>
                    </div>
					<div class="form-actions none-bg">
						<div class="col-md-offset-3 col-md-9">
							<button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> <?php echo __("Salvar"); ?></button>
							&nbsp;
							<button type="button" class="btn btn-green" onclick="window.history.back();"><i class="fa fa-times"></i> <?php echo __("Cancelar"); ?></button>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
<div id="OcultarTermo" style="display: none;">
    <!--<div class="col-md-12" id="Termo{cont}" style="margin-bottom: 10px;">
        <div class="input-group">
            <div class="input-group-btn">
				<input id="idtermocargos{cont}" name="idtermocargos[]" type="hidden" value="{idtermocargo}">
                <input type="text" class="form-control" id="termos{cont}"  name="termos[]" value="{termo}">
                <button type="button" class="btn btn-green" title="Excluir termo" onclick="ExcluirTermo(this,'{cont}','{idtermocargo}')">
                    <i class="fa fa-remove"></i>
                </button>
            </div>
        </div>
    </div>-->
</div>
<script>
    function CarregarTermo(){
        let url = GetUrlAcao("cargo","getlistatermo");
        let data = {
            "idcargo": $("#idcargo").val(),
		};
		if(Vazio(data.idcargo))
		{
			$("#AreaTermo").html("");
			AdicionarTermo();
			return;
		}
        $.ajax({
            url: url,
            method:'POST',
            data:data,
            success:function(data){
				let html = "";
				$("#AreaTermo").html(html);
                if(data.sucesso)
                {
					if(Vazio(data.lista))
					{
						AdicionarTermo();
					}
					else
					{
						for(let i = 0; i < data.lista.length; i++)
						{
							AdicionarTermo(data.lista[i]);
						}
					}
				}
				else
				{
					AdicionarTermo();
				}
            },
            error: function(XHR, textStatus, errorThrown){
                msn = "<?php echo __("Falha na importação dos dados.");?>";
                alert(msn);
            }
        });
    }
    function ExcluirTermo(obj, id, valor)
    {
        var pai = $(obj).parent().parent().parent();
        if(Vazio(valor))
        {
            pai.remove();
            return
        }
        confirm("<?php echo __("Tem certeza que deseja deletar definitivamente esta termo?"); ?>", "<?php echo __("Confirme"); ?>", function() {
			
			let url = GetUrlAcao("cargo","deletartermocargo");
			let data = {
				"idtermocargo": valor,
			};
			$.ajax({
				url: url,
				method:'POST',
				data:data,
				success:function(data){					
					if(data.sucesso)
					{
						MsnSucesso(data.titulo, data.mensagem);
						pai.remove();
					}
					else
					{
						MsnDanger(data.titulo, data.erro);
					}
				},
				error: function(XHR, textStatus, errorThrown){
					msn = "<?php echo __("Falha na importação dos dados.");?>";
					alert(msn);
				}
			});
        });
    }
    function AdicionarTermo(termo = null)
    {
        var obj = $("#AreaTermo div.col-md-12:last-of-type");
        var id = 0;
        if(Vazio(obj))
        {
            id = 0;
        }
        else
        {
            id = obj.attr('id');
            id = GetNumero(id);
            id++;
		}
		if(Vazio(termo))
        {
            termo = {
				"idtermocargo": 0,
				"idcargo": 0,
				"termo": ""
			};
        }
        var caixa = $("#OcultarTermo").html();
        caixa = caixa.replaceAll('<!--',"").replaceAll('-->',"");
        caixa = caixa.replaceAll("{cont}", id);
		caixa = caixa.replaceAll("{termo}", termo.termo);
		caixa = caixa.replaceAll("{idtermocargo}", termo.idtermocargo);
        $("#AreaTermo").append(caixa);
    }
    $(function () {
		CarregarTermo();
    });
</script>