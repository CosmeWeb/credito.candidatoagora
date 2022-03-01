<div class="row">
<?php
 	$msgFlash = $this->session->flashdata('msg_flash');
 	if(!empty($msgFlash))
 		echo $msgFlash;
?>
    <form id="frmvaga" action="<?php echo site_url('vaga/listar/'); ?>" class="horizontal-form" method="GET">
        <div class="col-lg-12">
            <div class="panel panel-blue">
                <div class="panel-heading">
                <?php echo __("Filtro de Vaga") ?>
                    <div class="tools">
                        <i class="fa fa-chevron-down" onclick="ExibePainel(this,'#painelvaga')"></i>
                    </div>
                </div>
                <div id="painelvaga" class="panel-body pan">
                        <input id="idvaga" name="idvaga" type="hidden" value="0">
                        <input id="tipo" name="tipo" type="hidden" value="geral">
                        <div class="form-body pal">
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="buscar" class="control-label"><?php echo __("Buscar") ?></label>
                                        <div class="input-icon right">
                                            <input id="buscar" name="buscar" type="text" placeholder="Buscar" value="<?php echo Get("buscar"); ?>" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="empresa" class="control-label"><?php echo __("Empresa do cliente"); ?></label>
                                        <select id="empresa" name="empresa" class="form-control">
                                            <?php echo $obj->GerarOpcoesEmpresaClientes("", " -- Todos --"); ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="idcliente" class="control-label"><?php echo __("Contato cliente"); ?></label>
                                        <select id="idcliente" name="idcliente" class="form-control">
                                            <?php echo $obj->GerarOpcoesCliente("", " -- Todos --"); ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="empresacontratante" class="control-label"><?php echo __("Empresa contratante"); ?></label>
                                        <select id="empresacontratante" name="empresacontratante" class="form-control">
                                            <?php echo $obj->GerarOpcoesEmpresasContratante("", " -- Todos --"); ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="status" class="control-label"><?php echo __("Status"); ?></label>
                                        <select id="status" name="status" class="form-control">
                                            <?php echo $obj->GerarOpcoesStatus("", " -- Todos --"); ?>
                                        </select>
                                    </div>
                                </div>
                                <fieldset class="filtroavancado">
                                    <legend>Filtro avançado <a href="#"><i class="fa fa-chevron-up"></i></a></legend>
                                    <div id="areaavancado">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="idtamanho" class="control-label"><?php echo __("Tamanho empresa"); ?></label>
                                                <select id="idtamanho" name="idtamanho" class="form-control">
                                                    <?php echo $obj->GerarOpcoesTamanho("", " -- Todos --"); ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="idfaturamento" class="control-label"><?php echo __("Faturamento anual da empresa"); ?></label>
                                                <select id="idfaturamento" name="idfaturamento" class="form-control">
                                                    <?php echo $obj->GerarOpcoesFaturamento("", " -- Todos --"); ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="idarea" class="control-label"><?php echo __("Área"); ?></label>
                                                <select id="idarea" name="idarea" class="form-control">
                                                    <?php echo $obj->GerarOpcoesArea("", " -- Todos --"); ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="idnivel" class="control-label"><?php echo __("Nível"); ?></label>
                                                <select id="idnivel" name="idnivel" class="form-control">
                                                    <?php echo $obj->GerarOpcoesNivel("", " -- Todos --"); ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="idsubarea" class="control-label"><?php echo __("Subárea"); ?></label>
                                                <select id="idsubarea" name="idsubarea" class="form-control">
                                                    <?php echo $obj->GerarOpcoesSubarea("", " -- Todos --"); ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="idestado" class="control-label"><?php echo __("Estado"); ?></label>
                                                <select id="idestado" name="idestado" class="form-control">
                                                    <?php echo $obj->GerarOpcoesEstado("", " -- Todos --"); ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="idcidade" class="control-label"><?php echo __("Cidade"); ?></label>
                                                <select id="idcidade" name="idcidade" class="form-control">
                                                    <?php echo $obj->GerarOpcoesCidade("", " -- Todos --"); ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="nacionalidadeempresasprofissionaltrabalhou" class="control-label"><?php echo __("Nacionalidade das empresas nas quais o profissional trabalhou?"); ?></label>
                                                <select id="nacionalidadeempresasprofissionaltrabalhou" name="nacionalidadeempresasprofissionaltrabalhou" class="form-control">
                                                    <?php echo $obj->GerarOpcoesNacionalidadeempresasprofissionaltrabalhou("", " -- Todas --"); ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="idsetor" class="control-label"><?php echo __("Setor de atuação"); ?></label>
                                                <select id="idsetor" name="idsetor" class="form-control">
                                                    <?php echo $obj->GerarOpcoesSetor("", " -- Todos --"); ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="declarado" class="control-label"><?php echo __("Cliente se declarou ciênte dos termos e condições"); ?></label>
                                                <select id="declarado" name="declarado" class="form-control">
                                                    <?php echo $obj->GerarOpcoesDeclarado("", " -- Todos --"); ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="autorizado" class="control-label"><?php echo __("Cliente autorizou o uso de seus dados"); ?></label>
                                                <select id="autorizado" name="autorizado" class="form-control">
                                                    <?php echo $obj->GerarOpcoesAutorizado("", " -- Todos --"); ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="incluirempresasforatarget" class="control-label"><?php echo __("Considerar outras empresas fora do target dos setores selecionados"); ?></label>
                                                <select id="incluirempresasforatarget" name="incluirempresasforatarget" class="form-control">
                                                    <?php echo $obj->GerarOpcoesIncluirempresasforatarget("", " -- Todos --"); ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="excluirprofissionaisjatrabalhouempresa" class="control-label"><?php echo __("Excluir profissionais que já tenham trabalhado na empresa"); ?></label>
                                                <select id="excluirprofissionaisjatrabalhouempresa" name="excluirprofissionaisjatrabalhouempresa" class="form-control">
                                                    <?php echo $obj->GerarOpcoesExcluirprofissionaisjatrabalhouempresa("", " -- Todos --"); ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="melhores1000empresa" class="control-label"><?php echo __("Considerar apenas empresas listadas nas 1.000 maiores"); ?></label>
                                                <select id="melhores1000empresa" name="melhores1000empresa" class="form-control">
                                                    <?php echo $obj->GerarOpcoesMelhores1000empresa("", " -- Todos --"); ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="listadaembolsa" class="control-label"><?php echo __("Considerar apenas empresas listadas na bolsa"); ?></label>
                                                <select id="listadaembolsa" name="listadaembolsa" class="form-control">
                                                    <?php echo $obj->GerarOpcoesListadaembolsa("", " -- Todos --"); ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="gptw" class="control-label"><?php echo __("Considerar apenas empresas premiadas pelo GPTW"); ?></label>
                                                <select id="gptw" name="gptw" class="form-control">
                                                    <?php echo $obj->GerarOpcoesGptw("", " -- Todos --"); ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="perfilinovacao" class="control-label"><?php echo __("Considerar apenas empresas do prêmio inovação"); ?></label>
                                                <select id="perfilinovacao" name="perfilinovacao" class="form-control">
                                                    <?php echo $obj->GerarOpcoesPerfilinovacao("", " -- Todos --"); ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="startup" class="control-label"><?php echo __("Considerar apenas startups?"); ?></label>
                                                <select id="startup" name="startup" class="form-control">
                                                    <?php echo $obj->GerarOpcoesStartup("", " -- Todos --"); ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="cadastradoeminicio" class="control-label"><?php echo __("Cadastrado entre") ?></label>
                                                <div class="input-group datetimepicker-default date">
                                                    <input type="text" id="cadastradoeminicio" name="cadastradoeminicio" value="" class="form-control">
                                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="cadastradoemfim" class="control-label"><?php echo __("a") ?></label>
                                                <div class="input-group datetimepicker-default date">
                                                    <input type="text" id="cadastradoemfim" name="cadastradoemfim" value="" class="form-control">
                                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </fieldset>
                            </div>
                            <div class="row" id="divImportar" style="display: none; background-color: #e0f3e3; padding: 20px 0px;">
                                <div class="form-group">
                                    <label for="subarea" class="col-md-3 control-label text-right"><?php echo __("Importar arquivo xls de vagas"); ?> </label>
                                    <div class="col-md-5">
                                        <div class="input-icon">
                                            <i class="fa fa-table"></i>
                                            <input id="filevaga" name="filevaga" type="file" value="" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <button type="button" id="btn-EnviarExcel" class="btn btn-primary" onclick="EnviarExcel()">
                                            <i class="fa fa-cloud-upload"></i> <?php echo __("Enviar Arquivo") ?>
                                        </button>
                                        <a href="javascript:;" class="btn pull-right btn-exportar" style="color: #FF0000;" onclick="FecharImportarVaga();">
                                            <i class="fa fa-close"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="row" id="divloding" style="display: none; margin-bottom: 15px;">
                                <div class="col-lg-12 mtm">
                                    <div id="pageloader4">
                                        <div class="spinner">
                                            <div class="spinftw"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row" id="divBarra" style="display: none;">
                                <div class="col-lg-12 mtm">
                                    <h5> <?php echo __("Importação de Vaga"); ?></h5>
                                    <div class="progress progress-striped active">
                                        <div id="processo" role="progressbar" aria-valuetransitiongoal="80" class="progress-bar progress-bar-warning" aria-valuenow="80" style="width: 80%;">80%</div>
                                    </div>
                                </div>
                            </div>
                            <div class="row" id="divExportar" style="display: none;">
                                <div class="col-lg-12 mtm mbm">
                                    <a href="javascript:;" class="btn pull-right btn-exportar" onclick="FecharExportarVaga();">
                                        <i class="fa fa-close"></i>
                                    </a>
                                    <a id="downExpotar" href="#" target="_blank" class="btn btn-green pull-right">
                                        <i class="fa fa-cloud-download"></i> <?php echo __("Download da exportação") ?>
                                    </a>
                                    <span> <?php echo __("Caso o documento não seja baixado automaticamente, clique aqui"); ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="form-actions text-right pal">
                            <button id="btn-pesquisa" type="submit" class="btn btn-primary"><i class="fa fa-search"></i> <?php echo __("Pesquisa") ?></button>                        &nbsp;
                            <button type="button" class="btn btn-green" onclick="AdicionarNovo('<?php echo site_url('vaga/editar/'); ?>')"><i class="fa fa-plus"></i> <?php echo __("Adicionar Vaga") ?></button>
                            <button type="button" class="btn btn-blue" onclick="AbrirImportarVaga()"><i class="fa fa fa-sign-in"></i> <?php echo __("Importar Vaga") ?></button>
                            <button type="button" class="btn btn-blue" onclick="SetaExportarVaga(0);"><i class="fa fa-sign-out"></i> <?php echo __("Exportar Vaga") ?></button>
                        </div>
                </div>
            </div>
        </div>
    </form>
	<div class="col-lg-12">
		<div class="portlet box">
			<div class="portlet-header">
				<div class="caption"><?php echo __("Lista de Vaga") ?></div>
                <div id="dadostotais" class="tools" style="font-weight: bold;"></div>
			</div>
			<div class="portlet-body">
				<div class="row mbm">
					<div class="col-lg-12">
						<div class="table-responsive">
							<table id="vaga_tabela" class="table table-hover table-bordered table-advanced display">
								<thead>
								<tr>									
									<th style="width: 6%;"><?php echo __("ID"); ?></th>
                                    <th style="width: 13%;"><?php echo __("Título da vaga"); ?></th>
									<th style="width: 13%;"><?php echo __("Cliente"); ?></th>
									<th style="width: 12%;"><?php echo __("Empresa"); ?></th>
									<th style="width: 8%;"><?php echo __("Cidade"); ?></th>
									<th style="width: 8%;"><?php echo __("Linha de reporte"); ?></th>
									<th style="width: 8%;"><?php echo __("Setor de atuação"); ?></th>
                                    <th style="width: 8%;"><?php echo __("Cadastrado em"); ?></th>
                                    <th style="width: 7%;"><?php echo __("Candidatos"); ?></th>
									<th style="width: 9%;"><?php echo __("Ação") ?></th>
								</tr>
								<tbody>
								</tbody>
								</thead>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
    var pais = '<?php echo $this->gestao->GetPaisPadrao(); ?>';
    function SetaExportarVaga(idvaga = 0, tipo = 'geral')
    {
        $('#frmvaga #idvaga').val(idvaga);
        $('#frmvaga #tipo').val(tipo);
        ExportarVaga();
    }
    function confirmar(obj)
    {
        var url = $(obj).data('url');
        confirm("<?php echo __("Tem certeza que deseja deletar definitivamente a vaga?<br /><b>Atenção: Ao confirmar não será possível desfazer essa ação.</b>"); ?>", "<?php echo __("Confirme"); ?>", function(confirmed) {
            if (confirmed)
            {
                window.location = url;
            }
        });
    }    
    function ExportarVaga(file = "", posicao = 0, total = 0)
    {
        let url = GetUrlAcao("vaga","exportarvaga");
        let data = {
            "file":file,
            "posicao": posicao,
            "total": total,
        };
        data = $.extend( {}, data, {"FILTRO": $("#frmvaga").serializeArray()} );
        $.ajax({
            url: url,
            method:'POST',
            data:data,
            beforeSend:function(xhr){
                let aux = total;
                if(Vazio(aux))
                    aux = 1;
                let porcente = (posicao / aux) * 100;
                let texto = posicao+' / '+total;
                $('#divBarra .progress .progress-bar').css('width',porcente+'%').html(texto);
                $('#divBarra').css('display','block');
                $('#divloding').css('display','block');
            },
            success:function(data){
                if(data.sucesso)
                {
                    titulo = data.titulo;
                    msn = data.mensagem;
                    MsnSucesso(titulo, msn);
                    if(data.finalizado)
                    {
                        $('#divloding').slideUp("slow");
                        $('#divBarra').slideUp("slow");
                        $('#divExportar').css('display','block');
                        $('#downExpotar').attr("href", data.url);
                        window.open(data.url, "_blank");
                    }
                    else
                    {
                        ExportarVaga(data.file, data.posicao, data.total);
                    }
                }
                else
                {
                    msn = data.erro;
                    alert(msn);
                    $('#divloding').slideUp("slow");
                    $('#divBarra').slideUp("slow");
                }
            },
            error: function(XHR, textStatus, errorThrown){
                let msn = "<?php echo __("Falha na de verificação de vaga");?>";
                $('#divloding').slideUp("slow");
                $('#divBarra').slideUp("slow");
                alert(msn);
            }
        });
    }
    function FecharExportarVaga()
    {
        $('#filevaga').val("");
        $('#divExportar').slideUp("slow");
    }
    function FecharImportarVaga()
    {
        $('#divImportar').slideUp("slow");
        document.getElementById('filevaga').files = null;
        $('filevaga').val('');
    }
    function AbrirImportarVaga()
    {
        $('#divImportar').slideDown("slow");
    }
    function EnviarExcel(){
        let property = document.getElementById('filevaga').files[0];
        if(Vazio(property))
        {
            alert("<?php echo __("Você deve selecionar o arquivo com os dados de importação de Vagas");?>");
            return;
        }
        let file_name = property.name;
        let file_extension = file_name.split('.').pop().toLowerCase();
        let urlfile = GetUrlAcao("vaga","enviarexcel");
        let file_size = property.size;
        let max_size = parseInt("<?php echo $tamanhomax; ?>") * Math.pow(1024, 2);

        if(jQuery.inArray(file_extension,['csv','xls','xlsx','']) == -1){
            alert("<?php echo __("Extensão de arquivo inválida<br/>extensões permitidas são csv, xls e xlsx"); ?>");
            return;
        }
        if(file_size > max_size){
            alert("<?php echo sprintf(__("O arquivo não pode ser enviado porque excede o tamanho maxímo de %s"), $tamanhomax); ?>");
            return;
        }
        let form_data = new FormData();
        form_data.append("file",property);
        $.ajax({
            url: urlfile,
            method:'POST',
            data:form_data,
            contentType: false,
            cache:false,
            processData:false,
            beforeSend:function(xhr){
                $('#divloding').css('display','block');
            },
            success:function(data){
                if(data.sucesso)
                {
                    $('#divloding').css('display','none');
                    titulo = "<?php echo __("Importação");?>";
                    msn = "<?php echo __("Arquivo foi enviado com sucesso.<br/>Aguarde a finalização do processo de importação de Vaga.");?>";
                    MsnSucesso(titulo, msn);
                    ImportacaoExcel(data.file,0, data.total);
                }
                else
                {
                    $('#divloding').css('display','none');
                    msn = data.erro;
                    alert(msn);
                }
            },
            error: function(XHR, textStatus, errorThrown){
                let msn = "<?php echo __("Falha ao enviar o arquivo de importação.");?>";
                $('#divloding').css('display','none');
                alert(msn);
            }
        });
    }
    function ImportacaoExcel(file, posicao, total){

        let url = GetUrlAcao("vaga","importacaoexcel");

        let data = {
            "file":file,
            "posicao": posicao,
            "total": total,
        };

        $.ajax({
            url: url,
            method:'POST',
            data:data,
            beforeSend:function(xhr){
                let aux = total;
                let porcente = 0;
                let texto = posicao+' / '+total;
                if(Vazio(aux))
                    aux = 1;
                porcente = Math.ceil((posicao/aux) * 100);
                $('#divBarra .progress .progress-bar').css('width',porcente+'%').html(texto);
                $('#divBarra').css('display','block');
                $('#divloding').css('display','block');
            },
            success:function(data){
                if(data.sucesso)
                {
                    if(data.status == "Finalizado")
                    {
                        $('#divloding').css('display','none');
                        $('#divBarra').delay(3000).fadeOut( "slow" );
                        titulo = "<?php echo __("Sucesso.");?>";
                        msn = data.mensagem;
                        MsnSucesso(titulo, msn);
                        FecharImportarVaga();
                        $("#btn-pesquisa").trigger("click");
                    }
                    else
                    {
                        ImportacaoExcel(data.file, data.posicao, data.total);
                    }
                }
                else
                {
                    msn = data.erro;
                    alert(msn);
                }
            },
            error: function(XHR, textStatus, errorThrown){
                let msn = "<?php echo __("Falha na importação dos dados.");?>";
                $('#divloding').css('display','none');
                $('#divBarra').css('display','none');
                alert(msn);
            }
        });
    }
    function DeleteCandidatosVaga(obj, idvaga = 0, posicao = 0, total = 0){

        let url = GetUrlAcao("vaga","deletecandidatosvaga");
        let data = {
            "idvaga":idvaga,
            "posicao": posicao,
            "total": total,
        };

        $.ajax({
            url: url,
            method:'POST',
            data:data,
            beforeSend:function(xhr){
                let aux = total;
                let porcente = 0;
                let texto = 'Deletando candidatos da vaga ' + posicao+' / '+total;
                if(Vazio(aux))
                    aux = 1;
                porcente = Math.ceil((posicao/aux) * 100);
                $('#divBarra .progress .progress-bar').css('width',porcente+'%').html(texto);
                $('#divBarra').css('display','block');
                $('#divloding').css('display','block');
            },
            success:function(data){
                if(data.sucesso)
                {
                    if(data.finalizado == true)
                    {
                        $('#divloding').css('display','none');
                        $('#divBarra').delay(3000).fadeOut( "slow" );
                        titulo = data.titulo;
                        msn = data.mensagem;
                        MsnSucesso(titulo, msn);
                        $("#btn-pesquisa").trigger("click");
                    }
                    else
                    {
                        DeleteCandidatosVaga(obj, data.idvaga, data.posicao, data.total);
                    }
                }
                else
                {
                    msn = data.erro;
                    alert(msn);
                }
            },
            error: function(XHR, textStatus, errorThrown){
                let msn = "<?php echo __("Falha na importação dos dados.");?>";
                $('#divloding').css('display','none');
                $('#divBarra').css('display','none');
                alert(msn);
            }
        });
    }
    $(document).ready(function() {
        var el_datatable = $('#vaga_tabela').DataTable({
            "language":{ "url": CDN_Url('datatables') },
            "lengthMenu": [[50, 100, 250, 500, -1], [50, 100, 250, 500, "All"]],
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": GetDominio('index.php/vaga/listatabela/'),
                "data": function ( d ) {
                    return $.extend( {}, d, {"FILTRO": $('#frmvaga').serializeArray()} );
                },
                "type": 'post',
                "dataType": 'json',
                "dataFilter": function(data){
                    var json = jQuery.parseJSON( data );
                    var texto = json.recordsFiltered+"/"+json.recordsTotal;
                    MyrecordsFiltered = json.recordsFiltered;
                    MyrecordsTotal = json.recordsTotal;
                    $("#dadostotais").html(texto);
                    return JSON.stringify( json );
                },
            },
            columns: [
                {"data": "idvaga", render: $.fn.dataTable.render.number(',', '.', '')},            
				{'data': 'titulodavaga'},
                {'data': 'cliente'},
				{'data': 'empresacontratante'},
				{'data': 'cidade',
                    "render": function ( data, type, row, meta ) {
                        let cidade = row['cidade'];
                        let estado = row['estado'];
                        let link = "";
                        if((!Vazio(cidade))&&(!Vazio(estado)))
                        {
                            link = cidade+", "+estado;
                        }
                        else if(!Vazio(cidade))
                        {
                            link = cidade;
                        }
                        else if(!Vazio(estado))
                        {
                            link = estado;
                        }

                        return link;
                    }
                },
				{'data': 'linhadereporte'},
				{'data': 'setor'},
                {'data': 'cadastradoem'},
                {'data': 'total'},
                {"data": "idvaga",
                    "render": function ( data, type, row, meta ) {
                        var url = GetDominio('index.php/vaga/editar/'+data);
                        var link = '<a href="'+url+'" class="btn-tab-editar" title="Editar vaga"><i class="fa fa-edit"></i></a>';
                        url = GetDominio('index.php/vaga/excluir/'+data);
                        link += '<a href="javascript:;" class="btn-tab-excluir" title="Excluir vaga" onclick="confirmar(this)" data-url="'+url+'"><i class="ion ion-android-trash"></i></a>';
                        url = data;
                        link += '<a href="javascript:;" class="btn-tab-excluir" title="Exportar vaga" onclick="SetaExportarVaga('+url+',\'vaga\')" data-url=""><i class="fa fa-table"></i></a>';                        
                        link += '<a href="javascript:;" class="btn-tab-excluir" title="Exportar candidatos da vaga" onclick="SetaExportarVaga('+url+',\'candidatos\')" data-url=""><i class="el el-group"></i></a>';
                        url = LerDominioRaiz()+'/index.php/vaga/pdf_vaga/'+data;
                        link += '<a href="'+url+'" class="btn-tab-editar" title="Visualisa PDF da vaga" target="_blank"><i class="fa fa-file-pdf-o"></i></a>';
                        if(!Vazio(row['total']))
                        {
                            link += '<a href="javascript:;" class="btn-tab-excluir" title="Deletar candidatos da vaga" onclick="DeleteCandidatosVaga(this, '+url+')" ><i class="fa fa-user-times"></i></a>';
                        }
                        return link;
                    }
                }
            ],
        });

        $("#btn-pesquisa").click(function(){
            $("#idvaga").val("0");
            $("#tipo").val("geral");
            el_datatable.ajax.reload();
            return false;
        })
        el_datatable.on( 'draw', function () {
            $('#vaga_tabela_filter').css('display','none');
        } );
        formatData('#cadastradoeminicio', pais);
        formatData('#cadastradoemfim', pais);
        ExibePainel($("#frmvaga .tools i").get(0),'#painelvaga');
        $('.filtroavancado legend a').click(function (e) {
            e.preventDefault();
            ExibePainel($('.filtroavancado legend a i').get(0), "#areaavancado");
        });
    });
</script>