<div class="col-lg-12">
	<div class="panel panel-blue">
		<div class="panel-heading"><?php echo __("Formulário de Newsletter"); ?></div>
		<div class="panel-body pan">
			<form id="frmnewsletter" action="<?php echo site_url('newsletter/editar/'.$obj->idnewsletter); ?>" method="POST" class="form-horizontal">
				<div class="form-body pal">
					<input id="idnewsletter" name="idnewsletter" type="hidden" value="<?php echo $obj->FormGet('idnewsletter'); ?>">
					<input id="idcolaborador" name="idcolaborador" type="hidden" value="<?php echo $obj->FormGet('idcolaborador'); ?>">
					<input id="ip" name="ip" type="hidden" value="<?php echo $obj->FormGet('ip'); ?>">
					<input id="cadastrado" name="cadastrado" type="hidden" value="<?php echo $obj->FormGet('cadastrado'); ?>">
					<div class="form-group">
						<label for="email" class="col-md-1 control-label"><?php echo __("E-mail"); ?>
						<span class="require">*</span></label>
						<div class="col-md-4">
							<div class="input-icon">
							<i class="fa fa-envelope-o"></i>
							<input id="email" name="email" type="text" value="<?php echo $obj->FormGet('email'); ?>" class="form-control">
							<?php echo form_error('email', '<div class="alert alert-error msn-error">', '</div>'); ?>
							</div>
						</div>
						<label for="ip" class="col-md-2 control-label"><?php echo __("Cadastrado em"); ?></label>
						<div class="col-md-2">
							<div class="input-icon">
							<i class="fa fa-calendar-o"></i>
							<input id="cadastradotemp" name="cadastradotemp" type="text" readonly value="<?php echo $obj->FormGet('cadastrado'); ?>" class="form-control">
							</div>
						</div>
						<label for="ip" class="col-md-1 control-label"><?php echo __("IP"); ?></label>
						<div class="col-md-2">
							<div class="input-icon">
							<i class="fa fa-map-marker"></i>
							<input id="iptemp" name="iptemp" type="text" readonly value="<?php echo $obj->FormGet('ip'); ?>" class="form-control">
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