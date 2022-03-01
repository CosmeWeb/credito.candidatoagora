<div class="row">
<?php
 	$msgFlash = $this->session->flashdata('msg_flash');
 	if(!empty($msgFlash))
 		echo $msgFlash;
?>
    <div class="col-lg-12">
        <div class="panel panel-blue">
            <div class="panel-heading"><?php echo __("Filtro de Empresa") ?></div>
            <div class="panel-body pan">
                <form id="frmempresa" action="<?php echo site_url('empresa/listar/'); ?>" class="horizontal-form" method="GET">
                    <div class="form-body pal">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                	<label for="buscar" class="control-label"><?php echo __("Buscar") ?></label>
                                    <div class="input-icon right">
                                    	<input id="buscar" name="buscar" type="text" placeholder="Buscar" value="<?php echo Get("buscar"); ?>" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="cadastradoinicio" class="control-label"><?php echo __("Cadastrado entre") ?></label>
                                    <div class="input-group datetimepicker-default date">
                                        <input type="text" id="cadastradoinicio" name="cadastradoinicio" value="" class="form-control">
                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="cadastradofim" class="control-label"><?php echo __("a") ?></label>
                                    <div class="input-group datetimepicker-default date">
                                        <input type="text" id="cadastradofim" name="cadastradofim" value="" class="form-control">
                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row" id="divImportar" style="display: none; background-color: #e0f3e3; padding: 20px 0px;">
                            <div class="form-group">
                                <label for="subarea" class="col-md-3 control-label text-right"><?php echo __("Importar arquivo xls de empresas"); ?> </label>
                                <div class="col-md-5">
                                    <div class="input-icon">
                                        <i class="fa fa-table"></i>
                                        <input id="fileempresa" name="fileempresa" type="file" value="" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <button type="button" id="btn-EnviarExcel" class="btn btn-primary" onclick="EnviarExcel()">
                                        <i class="fa fa-cloud-upload"></i> <?php echo __("Enviar Arquivo") ?>
                                    </button>
                                    <a href="javascript:;" class="btn pull-right btn-exportar" style="color: #FF0000;" onclick="FecharImportarEmpresa();">
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
                                <h5> <?php echo sprintf(__("Importação de %s"), $titulo); ?></h5>
                                <div class="progress progress-striped active">
                                    <div id="processo" role="progressbar" aria-valuetransitiongoal="80" class="progress-bar progress-bar-warning" aria-valuenow="80" style="width: 80%;">80%</div>
                                </div>
                            </div>
                        </div>
                        <div class="row" id="divExportar" style="display: none;">
                            <div class="col-lg-12 mtm mbm">
                                <a href="javascript:;" class="btn pull-right btn-exportar" onclick="FecharExportarEmpresa();">
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
                        <button type="button" class="btn btn-green" onclick="AdicionarNovo('<?php echo site_url('empresa/editar/'); ?>')"><i class="fa fa-plus"></i> <?php echo __("Adicionar Empresa") ?></button>
                        <button type="button" class="btn btn-blue" onclick="AbrirImportarEmpresa()"><i class="fa fa fa-sign-in"></i> <?php echo __("Importar Empresa") ?></button>
                        <button type="button" class="btn btn-blue" onclick="ExportarEmpresa();"><i class="fa fa-sign-out"></i> <?php echo __("Exportar Empresa") ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
	<div class="col-lg-12">
		<div class="portlet box">
			<div class="portlet-header">
				<div class="caption"><?php echo __("Lista de Empresa") ?></div>
			</div>
			<div class="portlet-body">
				<div class="row mbm">
					<div class="col-lg-12">
						<div class="table-responsive">
							<table id="empresa_tabela" class="table table-hover table-bordered table-advanced display">
								<thead>
								<tr>									
                                    <th style="width: 8%;"><?php echo __("ID"); ?></th>
                                    <th style="width: 22%;"><?php echo __("Nome"); ?></th>
                                    <th style="width: 17%;"><?php echo __("E-mail"); ?></th>
                                    <th style="width: 20%;"><?php echo __("Empresa"); ?></th>
                                    <th style="width: 11%;"><?php echo __("Telefone"); ?></th>
                                    <th style="width: 12%;"><?php echo __("Cadastrado em"); ?></th>
									<th style="width: 10%;"><?php echo __("Ação") ?></th>
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
    function confirmar(obj)
    {
        var url = $(obj).data('url');
        confirm("<?php echo __("Tem certeza que deseja deletar definitivamente a empresa?<br /><b>Atenção: Ao confirmar não será possível desfazer essa ação.</b>"); ?>", "<?php echo __("Confirme"); ?>", function(confirmed) {
            if (confirmed)
            {
                window.location = url;
            }
        });
    }
    function ExportarEmpresa()
    {
        var url = GetUrlAcao("empresa","exportarempresa");
        var data = $("#frmempresa").serialize();
        $.ajax({
            url: url,
            method:'POST',
            data:data,
            beforeSend:function(xhr){
                $('#divloding').css('display','block');
            },
            success:function(data){
                if(data.sucesso)
                {
                    titulo = data.titulo;
                    msn = data.mensagem;
                    MsnSucesso(titulo, msn);
                    $('#divloding').slideUp("slow");
                    $('#divExportar').css('display','block');
                    $('#downExpotar').attr("href", data.url);
                    window.open(data.url, "_blank");
                }
                else
                {
                    msn = data.erro;
                    alert(msn);
                }
            },
            error: function(XHR, textStatus, errorThrown){
                $('#divloding').slideUp("slow");
                msn = "<?php echo __("Falha na de verificação do xls de empresa");?>";
                alert(msn);
            }
        });
    }
    function FecharExportarEmpresa()
    {
        $('#fileempresa').val("");
        $('#divExportar').slideUp("slow");
    }
    function FecharImportarEmpresa()
    {
        $('#divImportar').slideUp("slow");
        document.getElementById('fileempresa').files = null;
        $('fileempresa').val('');
    }
    function AbrirImportarEmpresa()
    {
        $('#divImportar').slideDown("slow");
    }
    function EnviarExcel(){
        var property = document.getElementById('fileempresa').files[0];
        if(Vazio(property))
        {
            alert("<?php echo __("Você deve selecionar o arquivo com os dados de importação de Empresas");?>");
            return;
        }
        var file_name = property.name;
        var file_extension = file_name.split('.').pop().toLowerCase();
        var urlfile = GetUrlAcao("empresa","enviarexcel");
        var file_size = property.size;
        var max_size = parseInt("<?php echo $tamanhomax; ?>") * Math.pow(1024, 2);

        if(jQuery.inArray(file_extension,['csv','xls','xlsx','']) == -1){
            alert("<?php echo __("Extensão de arquivo inválida<br/>extensões permitidas são csv, xls e xlsx"); ?>");
            return;
        }
        if(file_size > max_size){
            alert("<?php echo sprintf(__("O arquivo não pode ser enviado porque excede o tamanho maxímo de %s"), $tamanhomax); ?>");
            return;
        }
        var form_data = new FormData();
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
                    msn = "<?php echo __("Arquivo foi enviado com sucesso.<br/>Aguarde a finalização do processo de importação de Empresas.");?>";
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
                $('#divloding').css('display','none');
                msn = "<?php echo __("Falha ao enviar o arquivo de importação.");?>";
                alert(msn);
            }
        });
    }
    function ImportacaoExcel(file, posicao, total){

        var url = GetUrlAcao("empresa","importacaoexcel");

        var data = {
            "file":file,
            "posicao": posicao,
            "total": total,
        };

        $.ajax({
            url: url,
            method:'POST',
            data:data,
            beforeSend:function(xhr){
                var porcente = (posicao / total) * 100;
                var texto = posicao+' / '+total;
                $('#divBarra .progress .progress-bar').css('width',porcente+'%').html(texto);
                $('#divBarra').css('display','block');
                $('#divloding').css('display','block');
            },
            success:function(data){
                if(data.sucesso)
                {
                    var porcente = (data.posicao / data.total) * 100;
                    var texto = data.posicao +' / '+ data.total;
                    $('#divBarra .progress .progress-bar').css('width',porcente+'%').html(texto);
                    if(data.status == "Finalizado")
                    {
                        $('#divloding').css('display','none');
                        $('#divBarra').delay(3000).fadeOut( "slow" );
                        titulo = "<?php echo __("Sucesso.");?>";
                        msn = data.mensagem;
                        MsnSucesso(titulo, msn);
                        FecharImportarEmpresa();
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
                $('#divloding').css('display','none');
                $('#divBarra').css('display','none');
                msn = "<?php echo __("Falha na importação dos dados.");?>";
                alert(msn);
            }
        });
    }
    $(document).ready(function() {
        var el_datatable = $('#empresa_tabela').DataTable({
            "language":{ "url": "//cdn.datatables.net/plug-ins/1.10.12/i18n/Portuguese-Brasil.json" },
            "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": GetDominio('index.php/empresa/listatabela/'),
                "data": function ( d ) {
                    return $.extend( {}, d, {"FILTRO": $('#frmempresa').serializeArray()} );
                },
                "type": 'post',
                "dataType": 'json',
            },
            columns: [
                {"data": "idempresa", render: $.fn.dataTable.render.number(',', '.', '')},                
                {'data': 'nome'},
                {'data': 'email'},
                {'data': 'empresa'},
                {'data': 'telefone'},
                {'data': 'cadastrado'},
                {"data": "idempresa",
                    "render": function ( data, type, row, meta ) {
                        var url = GetDominio('index.php/empresa/editar/'+data);
                        var link = '<a href="'+url+'" class="btn-tab-editar" title="Editar empresa"><i class="fa fa-edit"></i></a>';
                        url = GetDominio('index.php/empresa/excluir/'+data);
                        link += '<a href="javascript:;" class="btn-tab-excluir" title="Excluir empresa" onclick="confirmar(this)" data-url="'+url+'"><i class="ion ion-android-trash"></i></a>';
                        return link;
                    }
                }
            ],
        });
        $("#btn-pesquisa").click(function(){
            el_datatable.ajax.reload();
            return false;
        })
        el_datatable.on( 'draw', function () {
            $('#empresa_tabela_filter').css('display','none');
        } );
        formatData('#cadastradoinicio', pais);
        formatData('#cadastradofim', pais);
    });
</script>