<div class="col-lg-12">
	<div class="panel panel-blue">
		<div class="panel-heading"><?php echo __("Formulário de Área"); ?></div>
		<div class="panel-body pan">
			<form id="frmarea" action="<?php echo site_url('area/editar/'.$obj->idarea); ?>" method="POST" class="form-horizontal">
				<div class="form-body pal">
					<input id="idarea" name="idarea" type="hidden" value="<?php echo $obj->FormGet('idarea'); ?>">
					<div class="form-group">
						<label for="area" class="col-md-3 control-label"><?php echo __("Área"); ?>
						<span class="require">*</span></label>
						<div class="col-md-9">
							<div class="input-icon">
							<i class="fa fa-cube"></i>
							<input id="area" name="area" type="text" value="<?php echo $obj->FormGet('area'); ?>" class="form-control">
							<?php echo form_error('area', '<div class="alert alert-error msn-error">', '</div>'); ?>
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