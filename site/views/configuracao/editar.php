<div class="col-lg-12">
    <div class="panel panel-blue">
        <div class="panel-heading"><?php echo __("Formulário de Configuração"); ?></div>
        <div class="panel-body pan">
            <form id="frmconfiguracao" action="<?php echo site_url('configuracao/editar/'.$obj->idconfiguracao); ?>" method="POST" class="form-horizontal">
                <div class="form-body pal">
                    <input id="idconfiguracao" name="idconfiguracao" type="hidden" value="<?php echo $obj->FormGet('idconfiguracao'); ?>">
                    <input id="nome" name="nome" type="hidden" value="<?php echo $obj->FormGet('nome'); ?>">
                    <input id="titulo" name="titulo" type="hidden" value="<?php echo $obj->FormGet('titulo'); ?>">
                    <input id="descricao" name="descricao" type="hidden" value="<?php echo $obj->FormGet('descricao'); ?>">
                    <input id="opcao" name="opcao" type="hidden" value="<?php echo $obj->FormGet('opcao'); ?>">
                    <input id="tipo" name="tipo" type="hidden" value="<?php echo $obj->FormGet('tipo'); ?>">
                    <div class="form-group mbn">
                        <label for="valor" class="col-md-3 control-label"><?php echo $obj->FormGet('titulo'); ?>
                            <span class="require">*</span></label>
                        <div class="col-md-9" style="margin-bottom: 20px;">
							<?php echo $obj->PrintCampoConfig('valor',$obj->FormGet('padrao')); ?>
                            <small class="help-block"><?php echo $obj->FormGet('descricao'); ?></small>
							<?php echo form_error('valor', '<div class="alert alert-error msn-error">', '</div>'); ?>
                        </div>
                    </div>
                    <div class="form-group mbn">
                        <label for="padrao" class="col-md-3 control-label"><?php echo __("Valor Padrão"); ?>
                        </label>
                        <div class="col-md-9">
							<?php echo $obj->PrintCampoConfig('padrao'); ?>
                        </div>
                    </div>
                </div>
                <div class="form-actions none-bg">
                    <div class="col-md-offset-3 col-md-9">
                        <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> <?php echo __("Enviar"); ?></button>						&nbsp;
                        <button type="button" class="btn btn-green" onclick="window.history.back();"><i class="fa fa-times"></i> <?php echo __("Cancelar"); ?></button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>