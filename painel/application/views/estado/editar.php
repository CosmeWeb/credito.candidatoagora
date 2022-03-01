<div class="col-lg-12">
	<div class="panel panel-blue">
		<div class="panel-heading"><?php echo __("Formulário de Estado"); ?></div>
		<div class="panel-body pan">
			<form id="frmestado" action="<?php echo site_url('estado/editar/'.$obj->idestado); ?>" method="POST" class="form-horizontal">
				<div class="form-body pal">
					<input id="idestado" name="idestado" type="hidden" placeholder="" value="<?php echo $obj->FormGet('idestado'); ?>">
					<div class="form-group">
						<label for="idpais" class="col-md-1 control-label"><?php echo __("País"); ?>
						<span class="require">*</span></label>
						<div class="col-md-3">
							<select id="idpais" name="idpais" class="form-control">
								<?php echo $obj->GerarOpcoesPais($obj->FormGet('idpais')); ?>
							</select>
							<?php echo form_error('idpais', '<div class="alert alert-error msn-error">', '</div>'); ?>
						</div>
						<label for="estado" class="col-md-1 control-label"><?php echo __("Estado"); ?>
						<span class="require">*</span></label>
						<div class="col-md-4">
							<div class="input-icon">
							<i class="el el-globe"></i>
							<input id="estado" name="estado" type="text" value="<?php echo $obj->FormGet('estado'); ?>" class="form-control">
							<?php echo form_error('estado', '<div class="alert alert-error msn-error">', '</div>'); ?>
							</div>
						</div>
						<label for="uf" class="col-md-1 control-label"><?php echo __("UF"); ?>
						<span class="require">*</span></label>
						<div class="col-md-2">
							<div class="input-icon">
							<i class="ion ion-earth"></i>
							<input id="uf" name="uf" type="text" value="<?php echo $obj->FormGet('uf'); ?>" class="form-control">
							<?php echo form_error('uf', '<div class="alert alert-error msn-error">', '</div>'); ?>
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