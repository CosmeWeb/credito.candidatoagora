<div class="col-lg-12">
	<div class="panel panel-blue">
		<div class="panel-heading"><?php echo __("Formulário de Cliente"); ?></div>
		<div class="panel-body pan">
			<form id="frmcliente" action="<?php echo site_url('cliente/editar/'.$obj->idcliente); ?>" method="POST" class="form-horizontal">
				<div class="form-body pal">
					<input id="idcliente" name="idcliente" type="hidden" placeholder="" value="<?php echo $obj->FormGet('idcliente'); ?>">
					<div class="form-group">
						<label for="nome" class="col-md-3 control-label"><?php echo __("Nome"); ?>
						<span class="require">*</span></label>
						<div class="col-md-9">
							<div class="input-icon">
							<i class="fa fa-user"></i>
							<input id="nome" name="nome" type="text" placeholder="" value="<?php echo $obj->FormGet('nome'); ?>" class="form-control">
							<?php echo form_error('nome', '<div class="alert alert-error msn-error">', '</div>'); ?>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label for="nome" class="col-md-3 control-label"><?php echo __("Empresa"); ?></label>
						<div class="col-md-9">
							<div class="input-icon">
							<i class="fa fa-building"></i>
							<input id="empresa" name="empresa" type="text" placeholder="" value="<?php echo $obj->FormGet('empresa'); ?>" class="form-control">
							<?php echo form_error('empresa', '<div class="alert alert-error msn-error">', '</div>'); ?>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label for="saldoconta" class="col-md-3 control-label"><?php echo __("Saldo em créditos"); ?></label>
						<div class="col-md-2">
							<div class="input-icon">
							<i class="el el-cog-alt"></i>
							<input id="saldoconta" name="saldoconta" type="number" value="<?php echo $obj->FormGet('saldoconta'); ?>" class="form-control">
							<?php echo form_error('saldoconta', '<div class="alert alert-error msn-error">', '</div>'); ?>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label for="idgestor" class="col-md-3 control-label"><?php echo __("Gestor"); ?></label>
						<div class="col-md-2">
							<select id="idgestor" name="idgestor" class="form-control">
								<?php echo $obj->GerarOpcoesGestores($obj->FormGet('acesso')); ?>
							</select>
							<?php echo form_error('idgestor', '<div class="alert alert-error msn-error">', '</div>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="email" class="col-md-3 control-label"><?php echo __("Email"); ?>
						<span class="require">*</span></label>
						<div class="col-md-9">
							<div class="input-icon">
							<i class="fa fa-envelope-o"></i>
							<input id="email" name="email" type="text" placeholder="" value="<?php echo $obj->FormGet('email'); ?>" class="form-control">
							<?php echo form_error('email', '<div class="alert alert-error msn-error">', '</div>'); ?>
							</div>
						</div>
					</div>
					<?php
					if(empty($obj->FormGet('idcliente'))):
					?>
					<div class="form-group">
						<label for="senha" class="col-md-3 control-label"><?php echo __("Senha"); ?>
						<span class="require">*</span></label>
						<div class="col-md-2">
							<div class="input-icon">
							<i class="fa fa-key"></i>
							<input id="senha" name="senha" type="password" placeholder="" value="<?php echo $obj->FormGet('senha'); ?>" class="form-control">
							<?php echo form_error('senha', '<div class="alert alert-error msn-error">', '</div>'); ?>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label for="confirma" class="col-md-3 control-label"><?php echo __("Confirmar Senha"); ?>
						<span class="require">*</span></label>
						<div class="col-md-2">
							<div class="input-icon">
							<i class="fa fa-key"></i>
							<input id="confirma" name="confirma" type="password" placeholder="" value="<?php echo $obj->FormGet('senha'); ?>" class="form-control">
							<?php echo form_error('confirma', '<div class="alert alert-error msn-error">', '</div>'); ?>
							</div>
						</div>
					</div>
					<?php
					endif;
					?>
					<div class="form-group">
						<label for="acesso" class="col-md-3 control-label"><?php echo __("Acesso"); ?>
						<span class="require">*</span></label>
						<div class="col-md-2">
							<select id="acesso" name="acesso" class="form-control">
								<?php echo $obj->GerarOpcoesAcesso($obj->FormGet('acesso')); ?>
							</select>
							<?php echo form_error('acesso', '<div class="alert alert-error msn-error">', '</div>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="status" class="col-md-3 control-label"><?php echo __("Status"); ?>
						<span class="require">*</span></label>
						<div class="col-md-2">
							<select id="status" name="status" class="form-control">
								<?php echo $obj->GerarOpcoesStatus($obj->FormGet('status')); ?>
							</select>
							<?php echo form_error('status', '<div class="alert alert-error msn-error">', '</div>'); ?>
						</div>
						<?php
						if(!empty($obj->FormGet('idcliente'))):
						?>
						<label for="ip" class="col-md-1 control-label"><?php echo __("IP"); ?></label>
						<div class="col-md-2">
							<div class="input-icon">
							<i class="ion ion-android-location"></i>
							<input id="ipvisao" name="ipvisao" type="text" placeholder="" value="<?php echo $obj->FormGet('ip'); ?>" class="form-control">
							</div>
						</div>
						<label for="ip" class="col-md-1 control-label"><?php echo __("Cadastrado em"); ?></label>
						<div class="col-md-2">
							<div class="input-icon">
							<i class="fa fa-calendar"></i>
							<input id="cadastradoemvisao" name="cadastradoemvisao" type="text" placeholder="" value="<?php echo $obj->FormGet('cadastradoem'); ?>" class="form-control">
							</div>
						</div>
						<?php
						endif;
						?>
					</div>
					<input id="ip" name="ip" type="hidden" placeholder="" value="<?php echo $obj->FormGet('ip'); ?>">
					<input id="cadastradoem" name="cadastradoem" type="hidden" placeholder="" value="<?php echo $obj->FormGet('cadastradoem'); ?>">
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