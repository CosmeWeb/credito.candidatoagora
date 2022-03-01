<div class="col-lg-12">
	<div class="panel panel-blue">
		<div class="panel-heading"><?php echo __("Formulário de Colaborador"); ?></div>
		<div class="panel-body pan">
			<form id="frmcolaborador" action="<?php echo site_url('colaborador/editar/'.$obj->idcolaborador); ?>" method="POST" class="form-horizontal">
				<div class="form-body pal">
					<input id="idcolaborador" name="idcolaborador" type="hidden" placeholder="" value="<?php echo $obj->FormGet('idcolaborador'); ?>">
					<div class="form-group">
						<label for="nome" class="col-md-3 control-label"><?php echo __("Nome"); ?>
						<span class="require">*</span></label>
						<div class="col-md-9">
							<div class="input-icon">
							<i class="fa fa-user"></i>
							<input id="nome" name="nome" type="text" placeholder="" value="<?php echo $obj->FormGet('nome'); ?>" class="form-control">
							<?php echo form_error('nome', '<div class="alert alert-error msn-error">', '</div>'); ?>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label for="telefone" class="col-md-3 control-label"><?php echo __("Telefone"); ?></label>
						<div class="col-md-9">
							<div class="input-icon">
							<i class="el el-phone"></i>
							<input id="telefone" name="telefone" type="text" placeholder="" value="<?php echo $obj->FormGet('telefone'); ?>" class="form-control">
							<?php echo form_error('telefone', '<div class="alert alert-error msn-error">', '</div>'); ?>
							</div>
						</div>
					</div>
                    <div class="form-group">
                        <label for="email" class="col-md-3 control-label"><?php echo __("Email"); ?>
                            <span class="require">*</span></label>
                        <div class="col-md-9">
                            <div class="input-icon">
                                <i class="fa fa-envelope-o"></i>
                                <input id="email" name="email" type="email" placeholder="" value="<?php echo $obj->FormGet('email'); ?>" class="form-control">
								<?php echo form_error('email', '<div class="alert alert-error msn-error">', '</div>'); ?>
                            </div>
                        </div>
                    </div>
                    <?php
                     if(empty($obj->idcolaborador)):
                     ?>
					<div class="form-group">
						<label for="senha" class="col-md-3 control-label"><?php echo __("Senha"); ?>
						<span class="require">*</span></label>
						<div class="col-md-9">
							<div class="input-icon">
							<i class="el el-key"></i>
							<input id="senha" name="senha" type="password" placeholder="" value="<?php echo $obj->FormGet('senha'); ?>" class="form-control">
							<?php echo form_error('senha', '<div class="alert alert-error msn-error">', '</div>'); ?>
							</div>
						</div>
					</div>
                     <div class="form-group">
                         <label for="confirma" class="col-md-3 control-label"><?php echo __("Confirmar Senha"); ?>
                         </label>
                         <div class="col-md-9">
                             <div class="input-icon">
                                 <i class="fa fa-lock"></i>
                                 <input id="confirma" name="confirma" type="password" placeholder="" value="<?php echo $obj->FormGet('confirma'); ?>" class="form-control">
                                 <?php echo form_error('confirma', '<div class="alert alert-error msn-error">', '</div>'); ?>
                             </div>
                         </div>
                     </div>
                    <?php
                    else:
                    ?>
                        <input id="senha" name="senha" type="hidden" value="<?php echo $obj->FormGet('senha'); ?>">
                        <input id="confirma" name="confirma" type="hidden" value="<?php echo $obj->FormGet('senha'); ?>">
                    <?php
                    endif;
                    ?>
                    <div class="form-group">
                        <label for="acesso" class="col-md-3 control-label"><?php echo __("Acesso"); ?>
                            <span class="require">*</span></label>
                        <div class="col-md-9">
                            <select id="acesso" name="acesso" class="form-control">
								<?php echo $obj->GerarOpcoesAcesso($obj->FormGet('acesso')); ?>
                            </select>
							<?php echo form_error('acesso', '<div class="alert alert-error msn-error">', '</div>'); ?>
                        </div>
                    </div>
					<div class="form-group">
						<label for="visualizadashboard" class="col-md-3 control-label"><?php echo __("Visualizar o dashboard?"); ?></label>
						<div class="col-md-9">
							<select id="visualizadashboard" name="visualizadashboard" class="form-control">
								<?php echo $obj->GerarOpcoesVisualizadashboard($obj->FormGet('visualizadashboard')); ?>
							</select>
							<?php echo form_error('visualizadashboard', '<div class="alert alert-error msn-error">', '</div>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="icone" class="col-md-3 control-label"><?php echo __("Icone"); ?></label>
						<div class="col-md-9">
                            <div class="radio">
	                            <?php
                                    $lista = $obj->GetListaIcones();
                                    if(!empty($lista)):
                                        foreach ($lista as $key=>$icone):
                                            $checked = "";
                                            if($obj->FormGet('icone') == $icone)
	                                            $checked = " checked=\"checked\"";
                                ?>
                                <label class="radio-inline pd5">
                                    <input id="icone<?php echo $key; ?>" type="radio" name="icone" value="<?php echo $icone; ?>"<?php echo $checked; ?>/>&nbsp;
                                    <img src="<?php echo $obj->GetSrcIcones($icone); ?>" class="avatar">
                                </label>
                                <?php
                                        endforeach;
                                    endif;
                                ?>
                            </div>
						</div>
					</div>
					<div class="form-group">
						<label for="foto" class="col-md-3 control-label"><?php echo __("Foto"); ?></label>
						<div class="col-md-9">
                            <input id="foto" name="foto" type="hidden" value="<?php echo $obj->FormGet('foto'); ?>">
                            <div class="slim" id="fotoslim"
                                 data-service="<?php echo site_url('api/salvarfoto/'); ?>"
                                 data-ratio="free"
                                 data-meta-idcolaborador="<?php echo $obj->FormGet('idcolaborador'); ?>"
                                 data-label="<?php echo __("Selecione a foto do colaborador."); ?>"
                                 data-size="128,128"
                                 data-min-size="40,40"
                                 data-download="true"
                                 data-button-edit-label="<?php echo __("Editar"); ?>"
                                 data-button-remove-label="<?php echo __("Remover"); ?>"
                                 data-button-download-label="<?php echo __("baixar"); ?>"
                                 data-button-upload-label="<?php echo __("Enviar"); ?>"
                                 data-button-cancel-label="<?php echo __("Cancelar"); ?>"
                                 data-button-confirm-label="<?php echo __("Confirmar"); ?>"

                                 data-button-edit-title="<?php echo __("Editar"); ?>"
                                 data-button-remove-title="<?php echo __("Remover"); ?>"
                                 data-button-download-title="<?php echo __("baixar"); ?>"
                                 data-button-upload-title="<?php echo __("Enviar"); ?>"
                                 data-button-cancel-title="<?php echo __("Cancelar"); ?>"
                                 data-button-confirm-title="<?php echo __("Confirmar"); ?>"

                                 data-max-file-size="8"
                                 data-status-upload-success="<?php echo __("foto foi salva com sucesso."); ?>"
                                 data-did-remove="Apagarfoto"
                                 data-did-upload="Salvarfoto"
                                 style="position: relative; display: block; float: left;">
								<?php
									if($obj->TemFoto())
									{
										?>
                                        <img src="<?php echo $obj->GetFoto(); ?>" alt="">
										<?php
									}
								?>
                                <input type="file" name="slim[]">
                            </div>
						</div>
					</div>
				</div>
				<div class="form-actions none-bg">
					<div class="col-md-offset-3 col-md-9">
						<button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> <?php echo __("Enviar"); ?></button>
						&nbsp;
						<button type="button" class="btn btn-green" onclick="window.history.back();"><i class="fa fa-times"></i> <?php echo __("Cancelar"); ?></button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
<script>
    function Apagarfoto(data)
    {
        var id = data.meta.idcolaborador;
        if(Vazio(id))
            return;
        var imagem = data.input.name;
        var foto = $("#frmcolaborador #foto").val();
        if(Vazio(foto))
        {
            return
        }
        if(imagem.indexOf(foto) == 0)
        {
            return
        }

        confirm("<?php echo __("Tem certeza que deseja deletar esta foto do colaborador?"); ?>", "<?php echo __("Confirme"); ?>", function() {
            var url = GetURL("apagarfotocolaborador/"+id);
            $.ajax({
                type: 'GET',
                dataType: 'JSON',
                url: url,
                success: function (data) {
                    if(Vazio(data))
                    {
                        alert("<?php echo __("Não foi possível excluir este foto."); ?>");
                        return;
                    }
                    if(data.sucesso)
                    {
                        MsnSucesso("<?php echo __("Foto foi apagada"); ?>", data.mensagem);
                        $("#frmcolaborador #foto").val("");
                    }
                    else
                    {
                        alert(data.erro);
                    }
                    return;
                },
                fail: function (jqXHR, status, errorThrown) {
                    throw Error('JSONFixture could not be loaded: ' + url + ' (status: ' + status + ', message: ' + errorThrown.message + ')')
                }
            });
        });
    }
    function Salvarfoto(error, data, response)
    {

        if(!Vazio(error))
        {
            alert(error);
            return;
        }

        if(Vazio(response.id))
        {
            alert("<?php echo __("Não foi possível salvar a imagem da foto."); ?>");
            return;
        }
        else
        {
            $("#idcolaborador").val(response.id);
            $("#frmcolaborador #foto").val(response.nome);
            data.meta.idcliente = response.id;
            console.log(data, response,$("#frmcolaborador #foto"));
        }
    }
    
    $(function () {
        formatFoneBR('#telefone');
    });
</script>