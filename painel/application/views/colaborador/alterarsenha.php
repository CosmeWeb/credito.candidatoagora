<div class="col-lg-12">
	<div class="panel panel-blue">
		<div class="panel-heading"><?php echo __("Alterar senha"); ?></div>
		<div class="panel-body pan">
			<form id="frmcliente" action="<?php echo site_url('colaborador/alterarsenha/'.$obj->idcolaborador); ?>" method="POST" class="form-horizontal">
				<div class="form-body pal">
                    <input id="idcolaborador" name="idcolaborador" type="hidden" value="<?php echo $obj->FormGet('idcolaborador'); ?>">
					<div class="form-group">
						<label for="senha" class="col-md-3 control-label"><?php echo __("Senha"); ?>
						<span class="require">*</span></label>
						<div class="col-md-2">
							<div class="input-icon">
							<i class="fa fa-key"></i>
							<input id="senha" name="senha" type="password" value="<?php echo $obj->FormGet('senha'); ?>" class="form-control">
                            <?php echo form_error('senha', '<div class="alert alert-error msn-error">', '</div>'); ?>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label for="confirma" class="col-md-3 control-label"><?php echo __("Confirmar Senha"); ?>
						<span class="require">*</span></label>
						<div class="col-md-2">
							<div class="input-icon">
							<i class="fa fa-key"></i>
							<input id="confirma" name="confirma" type="password" value="<?php echo $obj->FormGet('confirma'); ?>" class="form-control">
                            <?php echo form_error('confirma', '<div class="alert alert-error msn-error">', '</div>'); ?>
							</div>
						</div>
					</div>
				</div>
				<div class="form-actions none-bg">
					<div class="col-md-offset-3 col-md-9">
						<button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> <?php echo __("Alterar Senha"); ?></button>
						&nbsp;
						<button type="button" class="btn btn-green" onclick="window.history.back();"><i class="fa fa-times"></i> <?php echo __("Cancelar"); ?></button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>