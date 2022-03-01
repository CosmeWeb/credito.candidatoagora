<div class="col-lg-12">
	<div class="panel panel-blue">
		<div class="panel-heading"><?php echo __("Formulário de Idioma"); ?></div>
		<div class="panel-body pan">
			<form id="frmidioma" action="<?php echo site_url('idioma/editar/'.$obj->ididioma); ?>" method="POST" class="form-horizontal">
				<div class="form-body pal">

					<input id="ididioma" name="ididioma" type="hidden" placeholder="" value="<?php echo $obj->FormGet('ididioma'); ?>">
					<div class="form-group">
						<label for="ordem" class="col-md-3 control-label"><?php echo __("Ordem"); ?>
						<span class="require">*</span></label>
						<div class="col-md-9">
							<div class="input-icon">
							<i class="fa fa-user"></i>
							<input id="ordem" name="ordem" type="number" placeholder="0" value="<?php echo $obj->FormGet('ordem'); ?>" class="form-control">
							<?php echo form_error('ordem', '<div class="alert alert-error msn-error">', '</div>'); ?>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label for="idioma" class="col-md-3 control-label"><?php echo __("Idioma"); ?>
						<span class="require">*</span></label>
						<div class="col-md-9">
							<div class="input-icon">
							<i class="fa fa-user"></i>
							<input id="idioma" name="idioma" type="text" placeholder="" value="<?php echo $obj->FormGet('idioma'); ?>" class="form-control">
							<?php echo form_error('idioma', '<div class="alert alert-error msn-error">', '</div>'); ?>
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