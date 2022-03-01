<div class="col-lg-12">
	<div class="panel panel-blue">
		<div class="panel-heading"><?php echo __("Formulário de Empresa"); ?></div>
		<div class="panel-body pan">
			<form id="frmempresa" action="<?php echo site_url('empresa/editar/'.$obj->idempresa); ?>" method="POST" class="form-horizontal">
				<div class="form-body pal">
					<input id="idempresa" name="idempresa" type="hidden" value="<?php echo $obj->FormGet('idempresa'); ?>">
					<input id="ip" name="ip" type="hidden" value="<?php echo $obj->FormGet('ip'); ?>">
					<input id="cadastrado" name="cadastrado" type="hidden" value="<?php echo $obj->FormGet('cadastrado'); ?>">
					<div class="form-group">
						<label for="nome" class="col-md-2 control-label"><?php echo __("Nome"); ?>
						<span class="require">*</span></label>
						<div class="col-md-4">
							<div class="input-icon">
							<i class="fa fa-user"></i>
							<input id="nome" name="nome" type="text" placeholder="" value="<?php echo $obj->FormGet('nome'); ?>" class="form-control">
							<?php echo form_error('nome', '<div class="alert alert-error msn-error">', '</div>'); ?>
							</div>
						</div>
						<label for="email" class="col-md-2 control-label"><?php echo __("E-mail"); ?>
						<span class="require">*</span></label>
						<div class="col-md-4">
							<div class="input-icon">
							<i class="fa fa-user"></i>
							<input id="email" name="email" type="text" placeholder="" value="<?php echo $obj->FormGet('email'); ?>" class="form-control">
							<?php echo form_error('email', '<div class="alert alert-error msn-error">', '</div>'); ?>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label for="empresa" class="col-md-2 control-label"><?php echo __("Empresa"); ?>
						<span class="require">*</span></label>
						<div class="col-md-4">
							<div class="input-icon">
							<i class="fa fa-user"></i>
							<input id="empresa" name="empresa" type="text" placeholder="" value="<?php echo $obj->FormGet('empresa'); ?>" class="form-control">
							<?php echo form_error('empresa', '<div class="alert alert-error msn-error">', '</div>'); ?>
							</div>
						</div>
						<label for="telefone" class="col-md-2 control-label"><?php echo __("Telefone"); ?>
						<span class="require">*</span></label>
						<div class="col-md-4">
							<div class="input-icon">
							<i class="fa fa-user"></i>
							<input id="telefone" name="telefone" type="text" placeholder="" value="<?php echo $obj->FormGet('telefone'); ?>" class="form-control">
							<?php echo form_error('telefone', '<div class="alert alert-error msn-error">', '</div>'); ?>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label for="ip" class="col-md-2 control-label"><?php echo __("Cadastrado em"); ?></label>
						<div class="col-md-4">
							<div class="input-icon">
							<i class="fa fa-calendar-o"></i>
							<input id="cadastradotemp" name="cadastradotemp" type="text" readonly value="<?php echo $obj->FormGet('cadastrado'); ?>" class="form-control">
							</div>
						</div>
						<label for="ip" class="col-md-2 control-label"><?php echo __("IP"); ?></label>
						<div class="col-md-4">
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