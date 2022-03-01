<div class="col-lg-12">
	<div class="panel panel-blue">
		<div class="panel-heading"><?php echo __("Formulário de rastreamento de cliente"); ?></div>
		<div class="panel-body pan">
			<form id="frmrastreio" action="<?php echo site_url('rastreio/editar/'.$obj->idrastreio); ?>" method="POST" class="form-horizontal">
				<div class="form-body pal">
					<input id="idrastreio" name="idrastreio" type="hidden" placeholder="" value="<?php echo $obj->FormGet('idrastreio'); ?>">
					<div class="form-group">
						<label for="idcliente" class="col-md-3 control-label"><?php echo __("Cliente"); ?></label>
						<div class="col-md-4">
							<select id="idcliente" name="idcliente" class="form-control">
								<?php echo $obj->GerarOpcoesClientes($obj->FormGet('idcliente')); ?>
							</select>
							<?php echo form_error('idcliente', '<div class="alert alert-error msn-error">', '</div>'); ?>
						</div>
						<label for="codigo" class="col-md-2 control-label"><?php echo __("Código"); ?></label>
						<div class="col-md-3">
							<div class="input-icon">
							<i class="fa fa-cog"></i>
							<input id="codigo" name="codigo" type="text" value="<?php echo $obj->FormGet('codigo'); ?>" class="form-control">
							<?php echo form_error('codigo', '<div class="alert alert-error msn-error">', '</div>'); ?>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label for="descricao" class="col-md-3 control-label"><?php echo __("Descrição"); ?></label>
						<div class="col-md-9">
							<div class="input-icon">
							<i class="ion ion-clipboard"></i>
							<input id="descricao" name="descricao" type="text" value="<?php echo $obj->FormGet('descricao'); ?>" class="form-control">
							<?php echo form_error('descricao', '<div class="alert alert-error msn-error">', '</div>'); ?>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label for="ip" class="col-md-3 control-label"><?php echo __("IP"); ?></label>
						<div class="col-md-3">
							<div class="input-icon">
								<i class="fa fa-map-marker"></i>
								<input id="ip" name="ip" type="text" value="<?php echo $obj->FormGet('ip'); ?>" class="form-control">
							</div>
						</div>
						<label for="ip" class="col-md-3 control-label"><?php echo __("Cadastrado em"); ?></label>
						<div class="col-md-3">
							<div class="input-icon">
								<i class="fa fa-calendar"></i>
								<input id="cadastradoem" name="cadastradoem" type="text" value="<?php echo $obj->FormGet('cadastradoem'); ?>" class="form-control">
							</div>
						</div>
					</div>
				</div>
				<div class="form-actions none-bg">
					<div class="col-md-offset-3 col-md-9">
						<!--<button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> <?php echo __("Salvar"); ?></button>
						&nbsp;-->
						<button type="button" class="btn btn-green" onclick="window.history.back();"><i class="fa fa-times"></i> <?php echo __("Cancelar"); ?></button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>