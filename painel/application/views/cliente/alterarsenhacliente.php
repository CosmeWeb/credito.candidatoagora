<div class="col-lg-12">
	<div class="panel panel-blue">
		<div class="panel-heading"><?php echo __("Formulário de Cliente"); ?></div>
		<div class="panel-body pan">
			<form id="frmcliente" action="<?php echo site_url('cliente/editar/'.$obj->idcliente); ?>" method="POST" class="form-horizontal">
				<div class="form-body pal">                    
					<div class="form-group">
						<label for="status" class="col-md-3 control-label"><?php echo __("Status"); ?>
						<span class="require">*</span></label>
						<div class="col-md-3">
							<select id="idcliente" name="idcliente" class="form-control">
								<?php echo $obj->GerarOpcoesClientes(); ?>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label for="senha" class="col-md-3 control-label"><?php echo __("Senha"); ?>
						<span class="require">*</span></label>
						<div class="col-md-2">
							<div class="input-icon">
							<i class="fa fa-key"></i>
							<input id="senha" name="senha" type="password" value="<?php echo $obj->senha; ?>" class="form-control">
							</div>
						</div>
					</div>
					<div class="form-group">
						<label for="confirma" class="col-md-3 control-label"><?php echo __("Confirmar Senha"); ?>
						<span class="require">*</span></label>
						<div class="col-md-2">
							<div class="input-icon">
							<i class="fa fa-key"></i>
							<input id="confirma" name="confirma" type="password" value="<?php echo $obj->senha; ?>" class="form-control">
							</div>
						</div>
					</div>
				</div>
				<div class="form-actions none-bg">
					<div class="col-md-offset-3 col-md-9">
						<button type="button" class="btn btn-primary" onclick="AlterarSenha(this);"><i class="fa fa-save"></i> <?php echo __("Alterar Senha"); ?></button>
						&nbsp;
						<button type="button" class="btn btn-green" onclick="window.history.back();"><i class="fa fa-times"></i> <?php echo __("Cancelar"); ?></button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
<script>
    function AlterarSenha(obj)
    {
        var url = GetUrlAcao("cliente","alterarsenha");
        var data = $("#frmcliente").serialize();
        var aux = "";
        aux = $("#senha").val();
        if(aux.length < 8)
        {
            msn = "Sua senha deve conter no mínimo 8 caracteres";
            titulo = "Atenção!";
            alert(msn, "error", titulo);
            $("#senha").get(0).focus();
            return;
        }
        if(aux != $("#confirma").val())
        {
            msn = "Os campos de senha e confirmação de senha são diferentes";
            titulo = "Atenção!";
            alert(msn, "error", titulo);
            $("#confirma").get(0).focus();
            return;
        }
        $.ajax({
            url: url,
            method:'POST',
            data:data,
            beforeSend:function(xhr){
                $(obj).html("<i class=\"ion ion-loading-a\"></i> <?php echo __("Alterando..."); ?>");
            },
            success:function(data){
                if(data.sucesso)
                {
                    titulo = data.titulo;
                    msn = data.mensagem;
                    MsnSucesso(titulo, msn);
                    $(obj).html("<i class=\"fa fa-save\"></i> <?php echo __("Alterar Senha"); ?>");
                    window.location.assign(data.url);
                }
                else
                {
                    msn = data.erro;
                    alert(msn);
                }
            },
            error: function(XHR, textStatus, errorThrown){
                $(obj).html("<i class=\"fa fa-save\"></i> <?php echo __("Alterar Senha"); ?>");
                msn = "<?php echo __("Falha na de verificação de cliente");?>";
                alert(msn);
            }
        });
    }
</script>