<div class="col-lg-12">
	<div class="panel panel-blue">
		<div class="panel-heading"><?php echo __("Formulário de Faturamento"); ?></div>
		<div class="panel-body pan">
			<form id="frmfaturamento" action="<?php echo site_url('faturamento/editar/'.$obj->idfaturamento); ?>" method="POST" class="form-horizontal">
				<div class="form-body pal">
					<input id="idfaturamento" name="idfaturamento" type="hidden" placeholder="" value="<?php echo $obj->FormGet('idfaturamento'); ?>">
					<div class="form-group">
						<label for="faturamento" class="col-md-2 control-label"><?php echo __("Faturamento"); ?>
						<span class="require">*</span></label>
						<div class="col-md-6">
							<div class="input-icon">
							<i class="ion ion-android-image"></i>
							<input id="faturamento" name="faturamento" type="text" value="<?php echo $obj->FormGet('faturamento'); ?>" class="form-control">
							<?php echo form_error('faturamento', '<div class="alert alert-error msn-error">', '</div>'); ?>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label for="ordem" class="col-md-2 control-label"><?php echo __("Ordem do Faturamento"); ?></label>
						<div class="col-md-2">
							<div class="input-icon">
							<i class="fa fa-sort-numeric-asc"></i>
							<input id="ordem" name="ordem" type="number" value="<?php echo $obj->FormGet('ordem'); ?>" class="form-control">
							<?php echo form_error('ordem', '<div class="alert alert-error msn-error">', '</div>'); ?>
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