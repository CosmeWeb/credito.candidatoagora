<div class="col-lg-12">
	<div class="panel panel-blue">
		<div class="panel-heading"><?php echo __("Formulário de Competência"); ?></div>
		<div class="panel-body pan">
			<form id="frmcompetencia" action="<?php echo site_url('competencia/editar/'.$obj->idcompetencia); ?>" method="POST" class="form-horizontal">
				<div class="form-body pal">
					<input id="idcompetencia" name="idcompetencia" type="hidden" placeholder="" value="<?php echo $obj->FormGet('idcompetencia'); ?>">
					<div class="form-group">
						<label for="competencia" class="col-md-3 control-label"><?php echo __("Competência"); ?>
						<span class="require">*</span></label>
						<div class="col-md-9">
							<div class="input-icon">
							<i class="fa fa-user"></i>
							<input id="competencia" name="competencia" type="text" placeholder="" value="<?php echo $obj->FormGet('competencia'); ?>" class="form-control">
							<?php echo form_error('competencia', '<div class="alert alert-error msn-error">', '</div>'); ?>
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
			</form>
		</div>
	</div>
</div>