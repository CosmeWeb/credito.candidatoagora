<div class="col-lg-12">
	<div class="panel panel-blue">
		<div class="panel-heading"><?php echo __("Formulário de Vaga"); ?></div>
		<div class="panel-body pan">
			<form id="frmvaga" action="<?php echo site_url('vaga/editar/'.$obj->idvaga); ?>" method="POST" class="form-horizontal">
				<div class="form-body pal">
					<input id="idvaga" name="idvaga" type="hidden" value="<?php echo $obj->FormGet('idvaga'); ?>">
					<input id="fasecadastro" name="fasecadastro" type="hidden" value="<?php echo $obj->FormGet('fasecadastro'); ?>">
					<input id="cadastradoem" name="cadastradoem" type="hidden" value="<?php echo $obj->FormGet('cadastradoem'); ?>">
					<input id="ip" name="ip" type="hidden" value="<?php echo $obj->FormGet('ip'); ?>">
					<div class="form-group">
						<label for="idcliente" class="col-md-2 control-label"><?php echo __("Cliente"); ?>
						<span class="require">*</span></label>
						<div class="col-md-4">
							<select id="idcliente" name="idcliente" class="form-control">
								<?php echo $obj->GerarOpcoesCliente($obj->FormGet('idcliente')); ?>
							</select>
							<?php echo form_error('idcliente', '<div class="alert alert-error msn-error">', '</div>'); ?>
						</div>
						<label for="empresacontratante" class="col-md-2 control-label"><?php echo __("Empresa contratante"); ?>
						<span class="require">*</span></label>
						<div class="col-md-4">
							<div class="input-icon">
							<i class="fa fa-building"></i>
							<input id="empresacontratante" name="empresacontratante" type="text" value="<?php echo $obj->FormGet('empresacontratante'); ?>" class="form-control">
							<?php echo form_error('empresacontratante', '<div class="alert alert-error msn-error">', '</div>'); ?>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label for="titulodavaga" class="col-md-2 control-label"><?php echo __("Título da vaga"); ?>
						<span class="require">*</span></label>
						<div class="col-md-4">
							<div class="input-icon">
							<i class="fa fa-group"></i>
							<input id="titulodavaga" name="titulodavaga" type="text" value="<?php echo $obj->FormGet('titulodavaga'); ?>" class="form-control">
							<?php echo form_error('titulodavaga', '<div class="alert alert-error msn-error">', '</div>'); ?>
							</div>
						</div>
						<label for="idsetor" class="col-md-2 control-label"><?php echo __("Setor de atuação"); ?></label>
						<div class="col-md-4">					
							<select id="idsetor" name="idsetor" class="form-control">
								<?php echo $obj->GerarOpcoesSetor($obj->FormGet('idsetor'), __("-- Selecione --")); ?>
							</select>
							<?php echo form_error('idsetor', '<div class="alert alert-error msn-error">', '</div>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="idtamanho" class="col-md-2 control-label"><?php echo __("Quantidade de funcionários"); ?></label>
						<div class="col-md-4">
							<select id="idtamanho" name="idtamanho" class="form-control">
								<?php echo $obj->GerarOpcoesTamanho($obj->FormGet('idtamanho')); ?>
							</select>
							<?php echo form_error('idtamanho', '<div class="alert alert-error msn-error">', '</div>'); ?>
						</div>
						<label for="idfaturamento" class="col-md-2 control-label"><?php echo __("Faturamento anual da empresa"); ?></label>
						<div class="col-md-4">
							<select id="idfaturamento" name="idfaturamento" class="form-control">
								<?php echo $obj->GerarOpcoesFaturamento($obj->FormGet('idfaturamento')); ?>
							</select>
							<?php echo form_error('idfaturamento', '<div class="alert alert-error msn-error">', '</div>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="idarea" class="col-md-2 control-label"><?php echo __("Área"); ?></label>
						<div class="col-md-4">
							<select id="idarea" name="idarea" class="form-control">
								<?php echo $obj->GerarOpcoesArea($obj->FormGet('idarea')); ?>
							</select>
							<?php echo form_error('idarea', '<div class="alert alert-error msn-error">', '</div>'); ?>
						</div>
						<label for="idnivel" class="col-md-2 control-label"><?php echo __("Nível"); ?></label>
						<div class="col-md-4">
							<select id="idnivel" name="idnivel" class="form-control">
								<?php echo $obj->GerarOpcoesNivel($obj->FormGet('idnivel')); ?>
							</select>
							<?php echo form_error('idnivel', '<div class="alert alert-error msn-error">', '</div>'); ?>
						</div>
					</div>					
                    <div class="form-group">
                        <h4 class="block-heading col-md-12" style="margin-left: 30px;">
                            <span style="float: left">Subáreas</span>
                            <a href="javascript:;" class="" onclick="AdicionarSubarea()" style="margin-left: 12px; float: left;">
							<i class="fa fa-plus-square"></i> </a>
						</h4>
                        <div class="row col-md-12">
                            <div class="row col-md-10" id="AreaSubarea" style="float: right; padding: 0px;">
								
                            </div>
                        </div>
                    </div>
					<div class="form-group">
						<label for="momentoatualempresa" class="col-md-2 control-label"><?php echo __("Momento atual da empresa"); ?></label>
						<div class="col-md-4">
							<select id="momentoatualempresa" name="momentoatualempresa" class="form-control">
								<?php echo $obj->GerarOpcoesMomentoatualempresa($obj->FormGet('momentoatualempresa')); ?>
							</select>
							<?php echo form_error('momentoatualempresa', '<div class="alert alert-error msn-error">', '</div>'); ?>
						</div>
						<label for="linhadereporte" class="col-md-2 control-label"><?php echo __("Linha de reporte"); ?></label>
						<div class="col-md-4">
							<select id="linhadereporte" name="linhadereporte" class="form-control">
								<?php echo $obj->GerarOpcoesLinhadereporte($obj->FormGet('linhadereporte')); ?>
							</select>
							<?php echo form_error('linhadereporte', '<div class="alert alert-error msn-error">', '</div>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="mobilidade" class="col-md-2 control-label"><?php echo __("Mobilidade"); ?></label>
						<div class="col-md-8">
							<select id="mobilidade" name="mobilidade" class="form-control">
								<?php echo $obj->GerarOpcoesMobilidade($obj->FormGet('mobilidade')); ?>
							</select>
							<?php echo form_error('mobilidade', '<div class="alert alert-error msn-error">', '</div>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="idestado" class="col-md-2 control-label"><?php echo __("Estado"); ?></label>
						<div class="col-md-4">
							<select id="idestado" name="idestado" class="form-control">
								<?php echo $obj->GerarOpcoesEstado($obj->FormGet('idestado')); ?>
							</select>
							<?php echo form_error('idestado', '<div class="alert alert-error msn-error">', '</div>'); ?>
						</div>
						<label for="idcidade" class="col-md-2 control-label"><?php echo __("Cidade"); ?></label>
						<div class="col-md-4">
							<select id="idcidade" name="idcidade" class="form-control">
								<?php echo $obj->GerarOpcoesCidade($obj->FormGet('idcidade')); ?>
							</select>
							<?php echo form_error('idcidade', '<div class="alert alert-error msn-error">', '</div>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="raiodepesquisa" class="col-md-2 control-label"><?php echo __("Considerar candidatos no"); ?></label>
						<div class="col-md-2">
							<select id="raiodepesquisa" name="raiodepesquisa" class="form-control">
								<?php echo $obj->GerarOpcoesRaiodepesquisa($obj->FormGet('raiodepesquisa')); ?>
							</select>
							<?php echo form_error('raiodepesquisa', '<div class="alert alert-error msn-error">', '</div>'); ?>
						</div>
						<label for="faixaderemuneracaoinicial" class="col-md-2 control-label"><?php echo __("Faixa de remuneração inícial"); ?></label>
						<div class="col-md-2">
							<div class="input-icon">
							<i class="el el-usd"></i>
							<input id="faixaderemuneracaoinicial" name="faixaderemuneracaoinicial" type="text" placeholder="" value="<?php echo $obj->FormGet('faixaderemuneracaoinicial'); ?>" class="form-control">
							<?php echo form_error('faixaderemuneracaoinicial', '<div class="alert alert-error msn-error">', '</div>'); ?>
							</div>
						</div>
						<label for="faixaderemuneracaofim" class="col-md-2 control-label"><?php echo __("Faixa de remuneração fim"); ?></label>
						<div class="col-md-2">
							<div class="input-icon">
							<i class="el el-usd"></i>
							<input id="faixaderemuneracaofim" name="faixaderemuneracaofim" type="text" placeholder="" value="<?php echo $obj->FormGet('faixaderemuneracaofim'); ?>" class="form-control">
							<?php echo form_error('faixaderemuneracaofim', '<div class="alert alert-error msn-error">', '</div>'); ?>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label for="descricaodavaga" class="col-md-2 control-label"><?php echo __("Descrição da vaga"); ?></label>
						<div class="col-md-10">
							<textarea id="descricaodavaga" name="descricaodavaga" rows="5" class="form-control"><?php echo $obj->FormGet('descricaodavaga'); ?></textarea>
							<?php echo form_error('descricaodavaga', '<div class="alert alert-error msn-error">', '</div>'); ?>
						</div>
					</div>
                    <div class="form-group">
                        <h4 class="block-heading col-md-12" style="margin-left: 30px;">
                            <span style="float: left">Cargos correlatos existentes no mercado</span>
                            <a href="javascript:;" class="" onclick="AdicionarCargos()" style="margin-left: 12px; float: left;">
							<i class="fa fa-plus-square"></i> </a>
						</h4>
                        <div class="row col-md-12">
                            <div class="row col-md-10" id="AreaCargos" style="float: right; padding: 0px;">
								
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <h4 class="block-heading col-md-12" style="margin-left: 30px;">
                            <span style="float: left">Setores target para incluir na busca</span>
                            <a href="javascript:;" class="" onclick="AdicionarSetores()" style="margin-left: 12px; float: left;">
							<i class="fa fa-plus-square"></i> </a>
						</h4>
                        <div class="row col-md-12">
                            <div class="row col-md-10" id="AreaSetores" style="float: right; padding: 0px;">
								
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <h4 class="block-heading col-md-12" style="margin-left: 30px;">
                            <span style="float: left">Empresas target para incluir na busca</span>
                            <a href="javascript:;" class="" onclick="AdicionarEmpresa()" style="margin-left: 12px; float: left;">
							<i class="fa fa-plus-square"></i> </a>
						</h4>
                        <div class="row col-md-12">
                            <div class="row col-md-10" id="AreaEmpresas" style="float: right; padding: 0px;">
								
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <h4 class="block-heading col-md-12" style="margin-left: 30px;">
                            <span style="float: left">Empresas target para excluir na busca</span>
                            <a href="javascript:;" class="" onclick="AdicionarEmpresaExcluir()" style="margin-left: 12px; float: left;">
							<i class="fa fa-plus-square"></i> </a>
						</h4>
                        <div class="row col-md-12">
                            <div class="row col-md-10" id="AreaEmpresasExcluir" style="float: right; padding: 0px;">
								
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <h4 class="block-heading col-md-12" style="margin-left: 30px;">
                            <span style="float: left">Empresas fora das opções de empresa cadastrada</span>
                            <a href="javascript:;" class="" onclick="AdicionarEmpresacorrelata()" style="margin-left: 12px; float: left;">
							<i class="fa fa-plus-square"></i> </a>
						</h4>
                        <div class="row col-md-12">
                            <div class="row col-md-10" id="AreaEmpresacorrelata" style="float: right; padding: 0px;">
								
                            </div>
                        </div>
                    </div>
					<div class="form-group">
						<label for="nacionalidadeempresasprofissionaltrabalhou" class="col-md-4 control-label">
						<?php echo __("Nacionalidade das empresas nas quais o profissional trabalhou"); ?>
						</label>
						<div class="col-md-2">
							<select id="nacionalidadeempresasprofissionaltrabalhou" name="nacionalidadeempresasprofissionaltrabalhou" class="form-control">
								<?php echo $obj->GerarOpcoesNacionalidadeempresasprofissionaltrabalhou($obj->FormGet('nacionalidadeempresasprofissionaltrabalhou')); ?>
							</select>
							<?php echo form_error('nacionalidadeempresasprofissionaltrabalhou', '<div class="alert alert-error msn-error">', '</div>'); ?>
						</div>
						<label for="incluirempresasforatarget" class="col-md-4 control-label"><?php echo __("Considerar outras empresas fora do target dos setores selecionados"); ?></label>
						<div class="col-md-2">
							<select id="incluirempresasforatarget" name="incluirempresasforatarget" class="form-control">
								<?php echo $obj->GerarOpcoesIncluirempresasforatarget($obj->FormGet('incluirempresasforatarget')); ?>
							</select>
							<?php echo form_error('incluirempresasforatarget', '<div class="alert alert-error msn-error">', '</div>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="excluirprofissionaisjatrabalhouempresa" class="col-md-4 control-label"><?php echo __("Excluir profissionais que já tenham trabalhado na empresa"); ?></label>
						<div class="col-md-2">
							<select id="excluirprofissionaisjatrabalhouempresa" name="excluirprofissionaisjatrabalhouempresa" class="form-control">
								<?php echo $obj->GerarOpcoesExcluirprofissionaisjatrabalhouempresa($obj->FormGet('excluirprofissionaisjatrabalhouempresa')); ?>
							</select>
							<?php echo form_error('excluirprofissionaisjatrabalhouempresa', '<div class="alert alert-error msn-error">', '</div>'); ?>
						</div>
						<label for="melhores1000empresa" class="col-md-4 control-label"><?php echo __("Considerar apenas empresas listadas nas 1.000 maiores"); ?></label>
						<div class="col-md-2">
							<select id="melhores1000empresa" name="melhores1000empresa" class="form-control">
								<?php echo $obj->GerarOpcoesMelhores1000empresa($obj->FormGet('melhores1000empresa')); ?>
							</select>
							<?php echo form_error('melhores1000empresa', '<div class="alert alert-error msn-error">', '</div>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="listadaembolsa" class="col-md-4 control-label"><?php echo __("Considerar apenas empresas listadas na bolsa"); ?></label>
						<div class="col-md-2">
							<select id="listadaembolsa" name="listadaembolsa" class="form-control">
								<?php echo $obj->GerarOpcoesListadaembolsa($obj->FormGet('listadaembolsa')); ?>
							</select>
							<?php echo form_error('listadaembolsa', '<div class="alert alert-error msn-error">', '</div>'); ?>
						</div>
						<label for="startup" class="col-md-4 control-label"><?php echo __("Considerar apenas startups"); ?></label>
						<div class="col-md-2">
							<select id="startup" name="startup" class="form-control">
								<?php echo $obj->GerarOpcoesStartup($obj->FormGet('startup')); ?>
							</select>
							<?php echo form_error('startup', '<div class="alert alert-error msn-error">', '</div>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="gptw" class="col-md-4 control-label"><?php echo __("Considerar apenas empresas premiadas pelo GPTW"); ?></label>
						<div class="col-md-2">
							<select id="gptw" name="gptw" class="form-control">
								<?php echo $obj->GerarOpcoesGptw($obj->FormGet('gptw')); ?>
							</select>
							<?php echo form_error('gptw', '<div class="alert alert-error msn-error">', '</div>'); ?>
						</div>
						<label for="perfilinovacao" class="col-md-4 control-label"><?php echo __("Considerar apenas empresas do prêmio inovação"); ?></label>
						<div class="col-md-2">
							<select id="perfilinovacao" name="perfilinovacao" class="form-control">
								<?php echo $obj->GerarOpcoesPerfilinovacao($obj->FormGet('perfilinovacao')); ?>
							</select>
							<?php echo form_error('perfilinovacao', '<div class="alert alert-error msn-error">', '</div>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="autorizado" class="col-md-2 control-label"><?php echo __("Cliente autorizou o uso de seus dados"); ?></label>
						<div class="col-md-2">
							<select id="autorizado" name="autorizado" class="form-control">
								<?php echo $obj->GerarOpcoesAutorizado($obj->FormGet('autorizado')); ?>
							</select>
							<?php echo form_error('autorizado', '<div class="alert alert-error msn-error">', '</div>'); ?>
						</div>
						<label for="declarado" class="col-md-3 control-label"><?php echo __("Cliente se declarou ciênte dos termos e condições"); ?></label>
						<div class="col-md-2">
							<select id="declarado" name="declarado" class="form-control">
								<?php echo $obj->GerarOpcoesDeclarado($obj->FormGet('declarado')); ?>
							</select>
							<?php echo form_error('declarado', '<div class="alert alert-error msn-error">', '</div>'); ?>
						</div>
						<label for="status" class="col-md-1 control-label"><?php echo __("Status da vaga"); ?>
						<span class="require">*</span></label>
						<div class="col-md-2">
							<select id="status" name="status" class="form-control">
								<?php echo $obj->GerarOpcoesStatus($obj->FormGet('status')); ?>
							</select>
							<?php echo form_error('status', '<div class="alert alert-error msn-error">', '</div>'); ?>
						</div>
					</div>
					<?php
					if(!empty($obj->idvaga)):
					?>
					<div class="form-group">
						<label for="cadastradoemview" class="col-md-2 control-label"><?php echo __("Cadastrado em"); ?></label>
						<div class="col-md-3">
							<div class="input-icon">
							<i class="fa fa-user"></i>
							<input id="cadastradoemview" name="cadastradoemview" type="text" re  value="<?php echo $obj->FormGet('cadastradoem'); ?>" class="form-control">
							</div>
						</div>
						<label for="ipview" class="col-md-3 control-label"><?php echo __("IP"); ?></label>
						<div class="col-md-2">
							<div class="input-icon">
							<i class="fa fa-user"></i>
							<input id="ipview" name="ipview" type="text" value="<?php echo $obj->FormGet('ip'); ?>" class="form-control">
							</div>
						</div>
					</div>
					<?php
					endif;
					?>
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
<div id="OcultarSubarea" style="display: none;">
<!--<div class="col-md-6 caixa" id="caixasubarea{cont}">
	<label for="idsubarea{cont}" class="control-label"><?php echo __("Subárea"); ?></label>
	<a href="javascript:;" class="btn-excluir" title="Excluir subárea" onclick="DeletarSubarea(this, {idsubareavaga})"><i class="fa fa-trash"></i></a>
	<input id="idsubareavaga{cont}" name="idsubareavaga[]" type="hidden" value="{idsubareavaga}">
	<select id="idsubarea{cont}" name="idsubarea[]" class="form-control">
		<?php echo $obj->GerarOpcoesSubarea("", " -- Selecionar --"); ?>
	</select>
</div>-->
</div>
<div id="OcultarCargos" style="display: none;">
<!--<div class="col-md-6 caixa" id="caixacargo{cont}">
	<label for="idcargo{cont}" class="control-label"><?php echo __("Cargo"); ?></label>
	<a href="javascript:;" class="btn-excluir" title="Excluir cargo" onclick="DeletarCargo(this, {idcargocorrelato})">
		<i class="fa fa-trash"></i>
	</a>
	<input id="idcargocorrelato{cont}" name="idcargocorrelato[]" type="hidden" value="{idcargocorrelato}">
	<input id="cargo{cont}" name="cargo[]" value="{cargo}" type="text" class="form-control">
</div>-->
</div>
<div id="OcultarSetores" style="display: none;">
<!--<div class="col-md-6 caixa" id="caixasetor{cont}">
	<label for="idsetor{cont}" class="control-label"><?php echo __("Setor"); ?></label>
	<a href="javascript:;" class="btn-excluir" title="Excluir setor" onclick="DeletarSetor(this, {idsetortarget})"><i class="fa fa-trash"></i></a>
	<input id="idsetortarget{cont}" name="idsetortarget[]" type="hidden" value="{idsetortarget}">
	<select id="idsetor{cont}" name="idsetortemp[]" class="form-control">
		<?php echo $obj->GerarOpcoesSetor("", " -- Selecionar --"); ?>
	</select>
</div>-->
</div>
<div id="OcultarEmpresas" style="display: none;">
<!--<div class="col-md-6 caixa" id="caixaempresa{cont}">
	<label for="idempresa{cont}" class="control-label"><?php echo __("Empresa"); ?></label>
	<a href="javascript:;" class="btn-excluir" title="Excluir empresa" onclick="DeletarEmpresa(this, {idempresatarget})"><i class="fa fa-trash"></i></a>
	<input id="idempresatarget{cont}" name="idempresatarget[]" type="hidden" value="{idempresatarget}">
	<select id="idempresa{cont}" name="idempresa[]" class="form-control">
		<?php echo $obj->GerarOpcoesEmpresas("", " -- Selecionar --"); ?>
	</select>
</div>-->
</div>
<div id="OcultarEmpresasExcluir" style="display: none;">
<!--<div class="col-md-6 caixa" id="caixaempresaexcluir{cont}">
	<label for="idempresaexcluir{cont}" class="control-label"><?php echo __("Empresa"); ?></label>
	<a href="javascript:;" class="btn-excluir" title="Excluir empresa" onclick="DeletarEmpresaExcluir(this, {idempresatargetexcluir})"><i class="fa fa-trash"></i></a>
	<input id="idempresatargetexcluir{cont}" name="idempresatargetexcluir[]" type="hidden" value="{idempresatargetexcluir}">
	<select id="idempresaexcluir{cont}" name="idempresaexcluir[]" class="form-control">
		<?php echo $obj->GerarOpcoesEmpresas("", " -- Selecionar --"); ?>
	</select>
</div>-->
</div>
<div id="OcultarEmpresacorrelata" style="display: none;">
<!--<div class="col-md-6 caixa" id="caixaempresacorrelata{cont}">
	<label for="idempresacorrelata{cont}" class="control-label"><?php echo __("Empresa correlata"); ?></label>
	<a href="javascript:;" class="btn-excluir" title="Excluir empresa correlata" onclick="DeletarEmpresacorrelata(this, {idempresacorrelata})">
		<i class="fa fa-trash"></i>
	</a>
	<input id="idempresacorrelata{cont}" name="idempresacorrelata[]" type="hidden" value="{idempresacorrelata}">
	<input id="empresa{cont}" name="empresa[]" value="{empresa}" type="text" class="form-control">
</div>-->
</div>

<script>
    function AdicionarSubarea(setor = null)
    {
        let obj = $("#AreaSubarea div.col-md-6:last-of-type");
        let id = 0;
        if(Vazio(obj))
        {
            id = 0;
        }
        else
        {
            id = obj.attr('id');
            id = GetNumero(id);
            id++;
        }
		if(Vazio(setor))
        {
            setor = {"idsubareavaga":0,"idsubarea":0};
        }
        let caixa = $("#OcultarSubarea").html();
		caixa = caixa.replaceAll("{cont}", id);
        caixa = caixa.replaceAll("<!--", "");
		caixa = caixa.replaceAll("-->", "");
		caixa = caixa.replaceAll("{idsubareavaga}", setor.idsubareavaga);
        $("#AreaSubarea").append(caixa);
		$("#AreaSubarea #idsubarea"+id).val(setor.idsubarea);
    }
    function CarregarSubarea(posicao = 0, total = 0)
	{
		let url = GetUrlAcao("vaga","carregarsubarea");
		let id = $("#idvaga").val();
		let data = null;
		if(Vazio(id))
		{
			let setores = $("#AreaSubarea div.col-md-6").length;
			if(Vazio(setores))
				AdicionarSubarea();
			return;
		}
		data = {
			"idvaga": id,
			"posicao": posicao, 
			"total": total
		};
		$.ajax({
			url: url,
			method:'POST',
			data:data,
			success:function(data){
				if(data.sucesso)
				{
					if(!Vazio(data.lista))
					{						
						for(let i = 0; i < data.lista.length; i++)
						{
							AdicionarSubarea(data.lista[i]);
						}
						if(Vazio(data.finalizar))
						{
							CarregarSubarea(data.posicao, data.total);
						}
						else
							CarregarCargo();
					}
					else
					{
						AdicionarSubarea();
						CarregarCargo();
					}
				}
				else
				{
					AdicionarSubarea();
					CarregarCargo();
				}
			},
			error: function(XHR, textStatus, errorThrown){
				msn = "<?php echo __("Falha em carregar os dados das subárea.");?>";
				alert(msn);
			}
		});
	}
    function DeletarSubarea(obj = null, id = 0)
    {
		let titulo = '<?php echo __("Confirme"); ?>';
		let msn = '<?php echo __("Tem certeza que deseja deletar definitivamente esta subárea de pesquisa desta vaga?<br /><b>Atenção: Ao confirmar não será possível desfazer essa ação.</b>"); ?>';
		let url = GetUrlAcao("vaga","deletarsubarea");
        if(Vazio(obj))
        {
           return;
        }
		if(Vazio(id))
        {
			$(obj).parent().remove();
			return;
        }
        confirm(msn, titulo, function(confirmed) {
            if (confirmed)
            {
                data = {
					"idsubareavaga": id,
				};
				$.ajax({
					url: url,
					method:'POST',
					data:data,
					success:function(data){
						if(data.sucesso)
						{
							MsnSucesso(data.titulo, data.mensagem);
							$(obj).parent().remove();
						}
						else
						{
							msn = data.erro;
                    		alert(msn);
						}
					},
					error: function(XHR, textStatus, errorThrown){
						msn = "<?php echo __("Falha em deletar este setor da vaga");?>";
						alert(msn);
					}
				});
            }
        });		
    }
	function AdicionarCargos(cargo = null)
    {
        let obj = $("#AreaCargos div.col-md-6:last-of-type");
        let id = 0;
        if(Vazio(obj))
        {
            id = 0;
        }
        else
        {
            id = obj.attr('id');
            id = GetNumero(id);
            id++;
        }
		if(Vazio(cargo))
        {
            cargo = {"idcargocorrelato":0,"cargo":""};
        }
        let caixa = $("#OcultarCargos").html();
		caixa = caixa.replaceAll("{cont}", id);
        caixa = caixa.replaceAll("<!--", "");
		caixa = caixa.replaceAll("-->", "");
		caixa = caixa.replaceAll("{idcargocorrelato}", cargo.idcargocorrelato);
		caixa = caixa.replaceAll("{cargo}", cargo.cargo);
        $("#AreaCargos").append(caixa);
    }
    function CarregarCargo(posicao = 0, total = 0)
	{
		let url = GetUrlAcao("vaga","carregarcargo");
		let id = $("#idvaga").val();
		let data = null;
		if(Vazio(id))
		{
			let cargos = $("#AreaCargos div.col-md-6").length;
			if(Vazio(cargos))
				AdicionarCargos();
			return;
		}
		data = {
			"idvaga": id,
			"posicao": posicao, 
			"total": total
		};
		$.ajax({
			url: url,
			method:'POST',
			data:data,
			success:function(data){
				if(data.sucesso)
				{
					if(!Vazio(data.lista))
					{
						for(let i = 0; i < data.lista.length; i++)
						{
							AdicionarCargos(data.lista[i]);
						}
						if(Vazio(data.finalizar))
						{
							CarregarCargo(data.posicao, data.total);
						}
						else
							CarregarSetor();
					}
					else
					{
						AdicionarCargos();
						CarregarSetor();
					}
				}
				else
				{
					AdicionarCargos();
					CarregarSetor();
				}
			},
			error: function(XHR, textStatus, errorThrown){
				msn = "<?php echo __("Falha em carregar os dados dos cargos correlatos ao cargo da vaga.");?>";
				alert(msn);
			}
		});
	}
    function DeletarCargo(obj = null, id = 0)
    {
		let titulo = '<?php echo __("Confirme"); ?>';
		let msn = '<?php echo __("Tem certeza que deseja deletar definitivamente este cargo correlato ao cargo da vaga?<br /><b>Atenção: Ao confirmar não será possível desfazer essa ação.</b>"); ?>';
		let url = GetUrlAcao("vaga","deletarcargo");
        if(Vazio(obj))
        {
           return;
        }
		if(Vazio(id))
        {
			$(obj).parent().remove();
			return;
        }
        confirm(msn, titulo, function(confirmed) {
            if (confirmed)
            {
                data = {
					"idcargocorrelato": id,
				};
				$.ajax({
					url: url,
					method:'POST',
					data:data,
					success:function(data){
						if(data.sucesso)
						{
							MsnSucesso(data.titulo, data.mensagem);
							$(obj).parent().remove();
						}
						else
						{
							msn = data.erro;
                    		alert(msn);
						}
					},
					error: function(XHR, textStatus, errorThrown){
						msn = "<?php echo __("Falha em deletar este cargo correlato ao cargo da vaga");?>";
						alert(msn);
					}
				});
            }
        });		
	}
    function AdicionarSetores(setor = null)
    {
        let obj = $("#AreaSetores div.col-md-6:last-of-type");
        let id = 0;
        if(Vazio(obj))
        {
            id = 0;
        }
        else
        {
            id = obj.attr('id');
            id = GetNumero(id);
            id++;
        }
		if(Vazio(setor))
        {
            setor = {"idcargocorrelato":0,"idsetor":0};
        }
        let caixa = $("#OcultarSetores").html();
		caixa = caixa.replaceAll("{cont}", id);
        caixa = caixa.replaceAll("<!--", "");
		caixa = caixa.replaceAll("-->", "");
		caixa = caixa.replaceAll("{idsetortarget}", setor.idsetortarget);
        $("#AreaSetores").append(caixa);
		$("#AreaSetores #idsetor"+id).val(setor.idsetor);
    }
    function CarregarSetor(posicao = 0, total = 0)
	{
		let url = GetUrlAcao("vaga","carregarsetor");
		let id = $("#idvaga").val();
		let data = null;
		if(Vazio(id))
		{
			let setores = $("#AreaSetores div.col-md-6").length;
			if(Vazio(setores))
				AdicionarSetores();
			return;
		}
		data = {
			"idvaga": id,
			"posicao": posicao, 
			"total": total
		};
		$.ajax({
			url: url,
			method:'POST',
			data:data,
			success:function(data){
				if(data.sucesso)
				{
					if(!Vazio(data.lista))
					{						
						for(let i = 0; i < data.lista.length; i++)
						{
							AdicionarSetores(data.lista[i]);
						}
						if(Vazio(data.finalizar))
						{
							CarregarSetor(data.posicao, data.total);
						}
						else
							CarregarEmpresa();
					}
					else
					{
						AdicionarSetores();
						CarregarEmpresa();
					}
				}
				else
				{
					AdicionarSetores();
					CarregarEmpresa();
				}
			},
			error: function(XHR, textStatus, errorThrown){
				msn = "<?php echo __("Falha em carregar os dados dos setores.");?>";
				alert(msn);
			}
		});
	}
    function DeletarSetor(obj = null, id = 0)
    {
		let titulo = '<?php echo __("Confirme"); ?>';
		let msn = '<?php echo __("Tem certeza que deseja deletar definitivamente este setor com target de pesquisa desta vaga?<br /><b>Atenção: Ao confirmar não será possível desfazer essa ação.</b>"); ?>';
		let url = GetUrlAcao("vaga","deletarsetor");
        if(Vazio(obj))
        {
           return;
        }
		if(Vazio(id))
        {
			$(obj).parent().remove();
			return;
        }
        confirm(msn, titulo, function(confirmed) {
            if (confirmed)
            {
                data = {
					"idsetortarget": id,
				};
				$.ajax({
					url: url,
					method:'POST',
					data:data,
					success:function(data){
						if(data.sucesso)
						{
							MsnSucesso(data.titulo, data.mensagem);
							$(obj).parent().remove();
						}
						else
						{
							msn = data.erro;
                    		alert(msn);
						}
					},
					error: function(XHR, textStatus, errorThrown){
						msn = "<?php echo __("Falha em deletar este setor da vaga");?>";
						alert(msn);
					}
				});
            }
        });		
    }
	function AdicionarEmpresa(empresa = null)
    {
        let obj = $("#AreaEmpresas div.col-md-6:last-of-type");
        let id = 0;
        if(Vazio(obj))
        {
            id = 0;
        }
        else
        {
            id = obj.attr('id');
            id = GetNumero(id);
            id++;
        }
		if(Vazio(empresa))
        {
            empresa = {"idempresatarget":0,"idempresa":0};
        }
        let caixa = $("#OcultarEmpresas").html();
		caixa = caixa.replaceAll("{cont}", id);
        caixa = caixa.replaceAll("<!--", "");
		caixa = caixa.replaceAll("-->", "");
		caixa = caixa.replaceAll("{idempresatarget}", empresa.idempresatarget);
        $("#AreaEmpresas").append(caixa);
		$("#AreaEmpresas #idempresa"+id).val(empresa.idempresa);
    }
    function CarregarEmpresa(posicao = 0, total = 0)
	{
		let url = GetUrlAcao("vaga","carregarempresa");
		let id = $("#idvaga").val();
		let data = null;
		if(Vazio(id))
		{
			let empresas = $("#AreaEmpresas div.col-md-6").length;
			if(Vazio(empresas))
				AdicionarEmpresa();
			return;
		}
		data = {
			"idvaga": id,
			"posicao": posicao, 
			"total": total
		};
		$.ajax({
			url: url,
			method:'POST',
			data:data,
			success:function(data){
				if(data.sucesso)
				{
					if(!Vazio(data.lista))
					{
						for(let i = 0; i < data.lista.length; i++)
						{
							AdicionarEmpresa(data.lista[i]);
						}
						if(Vazio(data.finalizar))
						{
							CarregarEmpresa(data.posicao, data.total);
						}
						else
							CarregarEmpresaExcluir();
					}
					else
					{
						AdicionarEmpresa();
						CarregarEmpresaExcluir();
					}
				}
				else
				{
					AdicionarEmpresa();
					CarregarEmpresaExcluir();
				}
			},
			error: function(XHR, textStatus, errorThrown){
				msn = "<?php echo __("Falha em carregar os dados das empresas.");?>";
				alert(msn);
			}
		});
	}
    function DeletarEmpresa(obj = null, id = 0)
    {
		let titulo = '<?php echo __("Confirme"); ?>';
		let msn = '<?php echo __("Tem certeza que deseja deletar definitivamente este empresa como target de pesquisa desta vaga?<br /><b>Atenção: Ao confirmar não será possível desfazer essa ação.</b>"); ?>';
		let url = GetUrlAcao("vaga","deletarempresa");
        if(Vazio(obj))
        {
           return;
        }
		if(Vazio(id))
        {
			$(obj).parent().remove();
			return;
        }
        confirm(msn, titulo, function(confirmed) {
            if (confirmed)
            {
                data = {
					"idempresatarget": id,
				};
				$.ajax({
					url: url,
					method:'POST',
					data:data,
					success:function(data){
						if(data.sucesso)
						{
							MsnSucesso(data.titulo, data.mensagem);
							$(obj).parent().remove();
						}
						else
						{
							msn = data.erro;
                    		alert(msn);
						}
					},
					error: function(XHR, textStatus, errorThrown){
						msn = "<?php echo __("Falha em deletar este empresa da vaga");?>";
						alert(msn);
					}
				});
            }
        });		
    }
	function AdicionarEmpresaExcluir(empresa = null)
    {
        let obj = $("#AreaEmpresasExcluir div.col-md-6:last-of-type");
        let id = 0;
        if(Vazio(obj))
        {
            id = 0;
        }
        else
        {
            id = obj.attr('id');
            id = GetNumero(id);
            id++;
        }
		if(Vazio(empresa))
        {
            empresa = {"idempresatargetexcluir":0,"idempresaexcluir":0};
        }
        let caixa = $("#OcultarEmpresasExcluir").html();
		caixa = caixa.replaceAll("{cont}", id);
        caixa = caixa.replaceAll("<!--", "");
		caixa = caixa.replaceAll("-->", "");
		caixa = caixa.replaceAll("{idempresatargetexcluir}", empresa.idempresatargetexcluir);
        $("#AreaEmpresasExcluir").append(caixa);
		$("#AreaEmpresasExcluir #idempresaexcluir"+id).val(empresa.idempresaexcluir);
    }
    function CarregarEmpresaExcluir(posicao = 0, total = 0)
	{
		let url = GetUrlAcao("vaga","carregarempresaexcluir");
		let id = $("#idvaga").val();
		let data = null;
		if(Vazio(id))
		{
			let empresas = $("#AreaEmpresasExcluir div.col-md-6").length;
			if(Vazio(empresas))
				AdicionarEmpresaExcluir();
			return;
		}
		data = {
			"idvaga": id,
			"posicao": posicao, 
			"total": total
		};
		$.ajax({
			url: url,
			method:'POST',
			data:data,
			success:function(data){
				if(data.sucesso)
				{
					if(!Vazio(data.lista))
					{
						for(let i = 0; i < data.lista.length; i++)
						{
							AdicionarEmpresaExcluir(data.lista[i]);
						}
						if(Vazio(data.finalizar))
						{
							CarregarEmpresaExcluir(data.posicao, data.total);
						}
						else
							CarregarEmpresacorrelata();
					}
					else
					{
						AdicionarEmpresaExcluir();
						CarregarEmpresacorrelata();
					}
				}
				else
				{
					AdicionarEmpresaExcluir();
					CarregarEmpresacorrelata();
				}
			},
			error: function(XHR, textStatus, errorThrown){
				msn = "<?php echo __("Falha em carregar os dados das empresas excluidas da pequisa.");?>";
				alert(msn);
			}
		});
	}
	function DeletarEmpresaExcluir(obj = null, id = 0)
    {
		let titulo = '<?php echo __("Confirme"); ?>';
		let msn = '<?php echo __("Tem certeza que deseja deletar definitivamente este empresa como target a não ser pesquisada nesta vaga?<br /><b>Atenção: Ao confirmar não será possível desfazer essa ação.</b>"); ?>';
		let url = GetUrlAcao("vaga","deletarempresaexcluir");
        if(Vazio(obj))
        {
           return;
        }
		if(Vazio(id))
        {
			$(obj).parent().remove();
			return;
        }
        confirm(msn, titulo, function(confirmed) {
            if (confirmed)
            {
                data = {
					"idempresatargetexcluir": id,
				};
				$.ajax({
					url: url,
					method:'POST',
					data:data,
					success:function(data){
						if(data.sucesso)
						{
							MsnSucesso(data.titulo, data.mensagem);
							$(obj).parent().remove();
						}
						else
						{
							msn = data.erro;
                    		alert(msn);
						}
					},
					error: function(XHR, textStatus, errorThrown){
						msn = "<?php echo __("Falha em deletar este empresa da vaga");?>";
						alert(msn);
					}
				});
            }
        });		
    }
	function AdicionarEmpresacorrelata(empresa = null)
    {
        let obj = $("#AreaEmpresacorrelata div.col-md-6:last-of-type");
        let id = 0;
        if(Vazio(obj))
        {
            id = 0;
        }
        else
        {
            id = obj.attr('id');
            id = GetNumero(id);
            id++;
        }
		if(Vazio(empresa))
        {
            empresa = {"idempresacorrelata":0,"empresa":""};
        }
        let caixa = $("#OcultarEmpresacorrelata").html();
		caixa = caixa.replaceAll("{cont}", id);
        caixa = caixa.replaceAll("<!--", "");
		caixa = caixa.replaceAll("-->", "");
		caixa = caixa.replaceAll("{idempresacorrelata}", empresa.idempresacorrelata);
		caixa = caixa.replaceAll("{empresa}", empresa.empresa);
        $("#AreaEmpresacorrelata").append(caixa);
    }
    function CarregarEmpresacorrelata(posicao = 0, total = 0)
	{
		let url = GetUrlAcao("vaga","carregarempresacorrelata");
		let id = $("#idvaga").val();
		let data = null;
		if(Vazio(id))
		{
			let empresas = $("#AreaEmpresacorrelata div.col-md-6").length;
			if(Vazio(empresas))
				AdicionarEmpresacorrelata();
			return;
		}
		data = {
			"idvaga": id,
			"posicao": posicao, 
			"total": total
		};
		$.ajax({
			url: url,
			method:'POST',
			data:data,
			success:function(data){
				if(data.sucesso)
				{
					if(!Vazio(data.lista))
					{
						for(let i = 0; i < data.lista.length; i++)
						{
							AdicionarEmpresacorrelata(data.lista[i]);
						}
						if(Vazio(data.finalizar))
						{
							CarregarEmpresacorrelata(data.posicao, data.total);
						}
					}
					else
					{
						AdicionarEmpresacorrelata();
					}
				}
				else
				{
					AdicionarEmpresacorrelata();
				}
			},
			error: function(XHR, textStatus, errorThrown){
				msn = "<?php echo __("Falha em carregar os dados das empresas correlatas da pequisa.");?>";
				alert(msn);
			}
		});
	}
	function DeletarEmpresacorrelata(obj = null, id = 0)
    {
		let titulo = '<?php echo __("Confirme"); ?>';
		let msn = '<?php echo __("Tem certeza que deseja deletar definitivamente este empresa correlata a não ser pesquisada nesta vaga?<br /><b>Atenção: Ao confirmar não será possível desfazer essa ação.</b>"); ?>';
		let url = GetUrlAcao("vaga","deletarempresacorrelata");
        if(Vazio(obj))
        {
           return;
        }
		if(Vazio(id))
        {
			$(obj).parent().remove();
			return;
        }
        confirm(msn, titulo, function(confirmed) {
            if (confirmed)
            {
                data = {
					"idempresacorrelata": id,
				};
				$.ajax({
					url: url,
					method:'POST',
					data:data,
					success:function(data){
						if(data.sucesso)
						{
							MsnSucesso(data.titulo, data.mensagem);
							$(obj).parent().remove();
						}
						else
						{
							msn = data.erro;
                    		alert(msn);
						}
					},
					error: function(XHR, textStatus, errorThrown){
						msn = "<?php echo __("Falha em deletar este empresa correlata da vaga");?>";
						alert(msn);
					}
				});
            }
        });		
    }
    $(document).ready(function() {
		formatDecimal("#faixaderemuneracaoinicial");
		formatDecimal("#faixaderemuneracaofim");
		CarregarSubarea();		
    });
</script>