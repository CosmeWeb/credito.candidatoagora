<div class="col-lg-12">
	<div class="panel panel-blue">
		<div class="panel-heading"><?php echo __("Formulário de Empresa"); ?></div>
		<div class="panel-body pan">
			<form id="frmempresa" action="<?php echo site_url('empresa/editar/'.$obj->idempresa); ?>" method="POST" class="form-horizontal">
				<div class="form-body pal">

					<input id="idempresa" name="idempresa" type="hidden" placeholder="" value="<?php echo $obj->FormGet('idempresa'); ?>">
					<div class="form-group">
						<label for="idsetor" class="col-md-2 control-label"><?php echo __("Setor"); ?>
						<span class="require">*</span></label>
						<div class="col-md-4">
							<select id="idsetor" name="idsetor" class="form-control">
								<?php echo $obj->GerarOpcoesSetor($obj->FormGet('idsetor')); ?>
							</select>
							<?php echo form_error('idsetor', '<div class="alert alert-error msn-error">', '</div>'); ?>
						</div>
						<label for="idtamanho" class="col-md-2 control-label"><?php echo __("Tamanho empresa"); ?>
						<span class="require">*</span></label>
						<div class="col-md-4">
							<select id="idtamanho" name="idtamanho" class="form-control">
								<?php echo $obj->GerarOpcoesTamanho($obj->FormGet('idtamanho')); ?>
							</select>
							<?php echo form_error('idtamanho', '<div class="alert alert-error msn-error">', '</div>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="empresa" class="col-md-2 control-label"><?php echo __("Empresa"); ?>
						<span class="require">*</span></label>
						<div class="col-md-4">
							<div class="input-icon">
							<i class="fa fa-building"></i>
							<input id="empresa" name="empresa" type="text" placeholder="" value="<?php echo $obj->FormGet('empresa'); ?>" class="form-control">
							<?php echo form_error('empresa', '<div class="alert alert-error msn-error">', '</div>'); ?>
							</div>
						</div>
						<label for="idnacionalidade" class="col-md-2 control-label"><?php echo __("Nacionalidade"); ?>
						<span class="require">*</span></label>
						<div class="col-md-4">
							<select id="idnacionalidade" name="idnacionalidade" class="form-control">
								<?php echo $obj->GerarOpcoesNacionalidade($obj->FormGet('idnacionalidade')); ?>
							</select>
							<?php echo form_error('idnacionalidade', '<div class="alert alert-error msn-error">', '</div>'); ?>
						</div>
					</div>
					<div class="form-group">
                        <label for="gptw" class="col-md-3 control-label"><?php echo __("Gptw:"); ?></label>
                        <div class="col-md-2">
                            <?php echo $obj->PrintRadioSimOuNao('gptw'); ?>
                        </div>
                        <label for="melhores1000empresa" class="col-md-3 control-label"><?php echo __("Lista +1000 melhores empresas:"); ?></label>
                        <div class="col-md-3">
	                        <?php echo $obj->PrintRadioMelhores('melhores1000empresa'); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="startup" class="col-md-3 control-label"><?php echo __("Startup:"); ?></label>
                        <div class="col-md-2">
	                        <?php echo $obj->PrintRadioSimOuNao('startup'); ?>
                        </div>
                        <label for="perfilformcaopessoas" class="col-md-3 control-label"><?php echo __("Perfil formção pessoas:"); ?></label>
                        <div class="col-md-2">
	                        <?php echo $obj->PrintRadioSimOuNao('perfilformcaopessoas'); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="perfilresultadoagressivo" class="col-md-3 control-label"><?php echo __("Perfil resultado agressivo:"); ?></label>
                        <div class="col-md-2">
	                        <?php echo $obj->PrintRadioSimOuNao('perfilresultadoagressivo'); ?>
                        </div>
                        <label for="perfilinovacao" class="col-md-3 control-label"><?php echo __("Perfil inovação:"); ?></label>
                        <div class="col-md-2">
	                        <?php echo $obj->PrintRadioSimOuNao('perfilinovacao'); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="listadaembolsa" class="col-md-3 control-label"><?php echo __("Listada em bolsa:"); ?></label>
                        <div class="col-md-2">
							<?php echo $obj->PrintRadioSimOuNao('listadaembolsa'); ?>
                        </div>
                        <label for="empresarelevante" class="col-md-3 control-label"><?php echo __("Empresa Relevante:"); ?></label>
                        <div class="col-md-2">
							<?php echo $obj->PrintRadioSimOuNao('empresarelevante'); ?>
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