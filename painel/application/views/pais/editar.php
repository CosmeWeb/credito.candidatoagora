<div class="col-lg-12">
	<div class="panel panel-blue">
		<div class="panel-heading"><?php echo __("Formulário de País"); ?></div>
		<div class="panel-body pan">
			<form id="frmpais" action="<?php echo site_url('pais/editar/'.$obj->idpais); ?>" method="POST" class="form-horizontal">
				<div class="form-body pal">
					<input id="idpais" name="idpais" type="hidden" value="<?php echo $obj->FormGet('idpais'); ?>">
					<div class="form-group">
						<label for="pais" class="col-md-3 control-label"><?php echo __("País"); ?>
						<span class="require">*</span></label>
						<div class="col-md-6">
							<div class="input-icon">
							<i class="el el-globe-alt"></i>
							<input id="pais" name="pais" type="text" value="<?php echo $obj->FormGet('pais'); ?>" class="form-control">
							<?php echo form_error('pais', '<div class="alert alert-error msn-error">', '</div>'); ?>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label for="sigla" class="col-md-3 control-label"><?php echo __("Sigla"); ?>
						<span class="require">*</span></label>
						<div class="col-md-6">
							<div class="input-icon">
							<i class="ion ion-social-dribbble-outline"></i>
							<input id="sigla" name="sigla" type="text" value="<?php echo $obj->FormGet('sigla'); ?>" class="form-control">
							<?php echo form_error('sigla', '<div class="alert alert-error msn-error">', '</div>'); ?>
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