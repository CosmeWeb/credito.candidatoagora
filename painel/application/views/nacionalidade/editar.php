<div class="col-lg-12">
	<div class="panel panel-blue">
		<div class="panel-heading"><?php echo __("Formulário de Nacionalidade"); ?></div>
		<div class="panel-body pan">
			<form id="frmnacionalidade" action="<?php echo site_url('nacionalidade/editar/'.$obj->idnacionalidade); ?>" method="POST" class="form-horizontal">
				<div class="form-body pal">
					<input id="idnacionalidade" name="idnacionalidade" type="hidden" value="<?php echo $obj->FormGet('idnacionalidade'); ?>">
					<div class="form-group">
						<label for="nacionalidade" class="col-md-2 control-label"><?php echo __("Nacionalidade"); ?>
						<span class="require">*</span></label>
						<div class="col-md-6">
							<div class="input-icon">
							<i class="ion ion-android-earth"></i>
							<input id="nacionalidade" name="nacionalidade" type="text" value="<?php echo $obj->FormGet('nacionalidade'); ?>" class="form-control">
							<?php echo form_error('nacionalidade', '<div class="alert alert-error msn-error">', '</div>'); ?>
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