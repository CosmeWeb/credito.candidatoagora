<div class="col-lg-12">
	<div class="panel panel-blue">
		<div class="panel-heading"><?php echo __("Formulário de Candidato"); ?></div>
		<div class="panel-body pan">
			<form id="frmcandidato" action="<?php echo site_url('candidato/editar/'.$obj->idcandidato); ?>" method="POST" class="form-horizontal">
				<div class="form-body pal">
					<input id="idcandidato" name="idcandidato" type="hidden" placeholder="" value="<?php echo $obj->FormGet('idcandidato'); ?>">
					<div class="form-group">
						<label for="idcidade" class="col-md-2 control-label"><?php echo __("Cidade"); ?>
						<span class="require">*</span></label>
						<div class="col-md-3">
							<select id="idcidade" name="idcidade" class="form-control">
								<?php echo $obj->GerarOpcoesCidade($obj->FormGet('idcidade')); ?>
							</select>
							<?php echo form_error('idcidade', '<div class="alert alert-error msn-error">', '</div>'); ?>
						</div>
						<label for="idestado" class="col-md-1 control-label"><?php echo __("Estado"); ?>
						<span class="require">*</span></label>
						<div class="col-md-3">
							<select id="idestado" name="idestado" class="form-control">
								<?php echo $obj->GerarOpcoesEstado($obj->FormGet('idestado')); ?>
							</select>
							<?php echo form_error('idestado', '<div class="alert alert-error msn-error">', '</div>'); ?>
						</div>
						<label for="idpais" class="col-md-1 control-label"><?php echo __("Pais"); ?>
						<span class="require">*</span></label>
						<div class="col-md-2">
							<select id="idpais" name="idpais" class="form-control">
								<?php echo $obj->GerarOpcoesPais($obj->FormGet('idpais')); ?>
							</select>
							<?php echo form_error('idpais', '<div class="alert alert-error msn-error">', '</div>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="nome" class="col-md-2 control-label"><?php echo __("Nome"); ?>
						<span class="require">*</span></label>
						<div class="col-md-3">
							<div class="input-icon">
							<i class="fa fa-user"></i>
							<input id="nome" name="nome" type="text" placeholder="" value="<?php echo $obj->FormGet('nome'); ?>" class="form-control">
							<?php echo form_error('nome', '<div class="alert alert-error msn-error">', '</div>'); ?>
							</div>
						</div>
						<label for="email" class="col-md-1 control-label"><?php echo __("E-mail"); ?>
						<span class="require">*</span></label>
						<div class="col-md-3">
							<div class="input-icon">
							<i class="fa fa-user"></i>
							<input id="email" name="email" type="text" placeholder="" value="<?php echo $obj->FormGet('email'); ?>" class="form-control">
							<?php echo form_error('email', '<div class="alert alert-error msn-error">', '</div>'); ?>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label for="telefone" class="col-md-2 control-label"><?php echo __("Telefone"); ?>
						<span class="require">*</span></label>
						<div class="col-md-3">
							<div class="input-icon">
							<i class="fa fa-user"></i>
							<input id="telefone" name="telefone" type="text" placeholder="" value="<?php echo $obj->FormGet('telefone'); ?>" class="form-control">
							<?php echo form_error('telefone', '<div class="alert alert-error msn-error">', '</div>'); ?>
							</div>
						</div>
						<label for="linkedin" class="col-md-1 control-label"><?php echo __("Linkedin"); ?>
						<span class="require">*</span></label>
						<div class="col-md-3">
							<div class="input-icon">
							<i class="fa fa-user"></i>
							<input id="linkedin" name="linkedin" type="text" placeholder="" value="<?php echo $obj->FormGet('linkedin'); ?>" class="form-control">
							<?php echo form_error('linkedin', '<div class="alert alert-error msn-error">', '</div>'); ?>
							</div>
						</div>
						<label for="linkedin_desatualizado" class="col-md-2 control-label" style="padding: 5px 15px 0px 0px; width: 15%;"><?php echo __("Linkedin desatualizado"); ?></label>
						<div class="col-md-1" style="padding: 0px;">
							<select id="linkedin_desatualizado" name="linkedin_desatualizado" class="form-control">
								<?php echo $obj->GerarOpcoesLinkedinDesatualizado($obj->FormGet('linkedin_desatualizado')); ?>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label for="favorito" class="col-md-2 control-label"><?php echo __("Favorito"); ?>
						<span class="require">*</span></label>
						<div class="col-md-3">
							<select id="favorito" name="favorito" class="form-control">
								<?php echo $obj->GerarOpcoesFavorito($obj->FormGet('favorito')); ?>
							</select>
							<?php echo form_error('favorito', '<div class="alert alert-error msn-error">', '</div>'); ?>
						</div>
						<label for="datacoleta" class="col-md-1 control-label"><?php echo __("Data de coleta"); ?></label>
						<div class="col-md-2">
							<div class="input-group datetimepicker-default date">
								<input type="text" id="datacoleta" name="datacoleta" value="<?php echo $obj->FormGet('datacoleta'); ?>" class="form-control">
								<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                            </div>
							<?php echo form_error('datacoleta', '<div class="alert alert-error msn-error">', '</div>'); ?>
						</div>
						<label for="dataaplicacao" class="col-md-1 control-label"><?php echo __("Data de aplicação"); ?></label>
						<div class="col-md-2">
							<div class="input-group datetimepicker-default date">
								<input type="text" id="dataaplicacao" name="dataaplicacao" value="<?php echo $obj->FormGet('dataaplicacao'); ?>" class="form-control">
								<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                            </div>
							<?php echo form_error('dataaplicacao', '<div class="alert alert-error msn-error">', '</div>'); ?>
						</div>
					</div>					
					<div class="form-group mbn">
						<label for="retornoinvitelkd" class="col-md-2 control-label"><?php echo __("Retorno invite linkedin"); ?></label>
						<div class="col-md-9">
							<textarea id="retornoinvitelkd" name="retornoinvitelkd" rows="5" class="form-control"><?php echo $obj->FormGet('retornoinvitelkd'); ?></textarea>
						</div>
					</div>
				</div>
				<div class="form-actions none-bg">
					<div class="col-md-offset-2 col-md-10">
						<button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> <?php echo __("Salvar"); ?></button>
						&nbsp;
						<button type="button" class="btn btn-green" onclick="window.history.back();"><i class="fa fa-times"></i> <?php echo __("Cancelar"); ?></button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
<script>
	var pais = '<?php echo $this->gestao->GetPaisPadrao(); ?>';
	formatData('#datacoleta', pais);
	formatData('#dataaplicacao', pais);
</script>