<div class="col-lg-12">
	<div class="panel panel-blue">
		<div class="panel-heading"><?php echo __("Formulário de Subárea"); ?></div>
		<div class="panel-body pan">
			<form id="frmsubarea" action="<?php echo site_url('subarea/editar/'.$obj->idsubarea); ?>" method="POST" class="form-horizontal">
				<div class="form-body pal">
					<input id="idsubarea" name="idsubarea" type="hidden" value="<?php echo $obj->FormGet('idsubarea'); ?>">
					<div class="form-group">
						<label for="idarea" class="col-md-3 control-label"><?php echo __("Área"); ?>
						<span class="require">*</span></label>
						<div class="col-md-9">
							<select id="idarea" name="idarea" class="form-control">
								<?php echo $obj->GerarOpcoesArea($obj->FormGet('idarea')); ?>
							</select>
							<?php echo form_error('idarea', '<div class="alert alert-error msn-error">', '</div>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="subarea" class="col-md-3 control-label"><?php echo __("Subárea"); ?>
						<span class="require">*</span></label>
						<div class="col-md-9">
							<div class="input-icon">
							<i class="el el-list"></i>
							<input id="subarea" name="subarea" type="text" placeholder="" value="<?php echo $obj->FormGet('subarea'); ?>" class="form-control">
							<?php echo form_error('subarea', '<div class="alert alert-error msn-error">', '</div>'); ?>
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