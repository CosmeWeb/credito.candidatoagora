<div class="row">
<?php
 	$msgFlash = $this->session->flashdata('msg_flash');
 	if(!empty($msgFlash))
 		echo $msgFlash;
?>
    <div class="col-lg-12">
        <div class="panel panel-blue">
            <div class="panel-heading">
            <?php echo __("Filtro de Faturamento") ?>
                <div class="tools">
                    <i class="fa fa-chevron-down" onclick="ExibePainel(this,'#painelfaturamento')"></i>
                </div>
            </div>
            <div id="painelfaturamento" class="panel-body pan">
                <form id="frmfaturamento" action="<?php echo site_url('faturamento/listar/'); ?>" class="horizontal-form" method="GET">
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
                        </div>
                        <div class="row" id="divImportar" style="display: none; background-color: #e0f3e3; padding: 20px 0px;">
                            <div class="form-group">
                                <label for="subarea" class="col-md-3 control-label text-right"><?php echo __("Importar arquivo xls de faturamentos"); ?> </label>
                                <div class="col-md-5">
                                    <div class="input-icon">
                                        <i class="fa fa-table"></i>
                                        <input id="filefaturamento" name="filefaturamento" type="file" value="" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <button type="button" id="btn-EnviarExcel" class="btn btn-primary" onclick="EnviarExcel()">
                                        <i class="fa fa-cloud-upload"></i> <?php echo __("Enviar Arquivo") ?>
                                    </button>
                                    <a href="javascript:;" class="btn pull-right btn-exportar" style="color: #FF0000;" onclick="FecharImportarFaturamento();">
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
                                <h5> <?php echo __("Importa????o de Faturamento"); ?></h5>
                                <div class="progress progress-striped active">
                                    <div id="processo" role="progressbar" aria-valuetransitiongoal="80" class="progress-bar progress-bar-warning" aria-valuenow="80" style="width: 80%;">80%</div>
                                </div>
                            </div>
                        </div>
                        <div class="row" id="divExportar" style="display: none;">
                            <div class="col-lg-12 mtm mbm">
                                <a href="javascript:;" class="btn pull-right btn-exportar" onclick="FecharExportarFaturamento();">
                                    <i class="fa fa-close"></i>
                                </a>
                                <a id="downExpotar" href="#" target="_blank" class="btn btn-green pull-right">
                                    <i class="fa fa-cloud-download"></i> <?php echo __("Download da exporta????o") ?>
                                </a>
                                <span> <?php echo __("Caso o documento n??o seja baixado automaticamente, clique aqui"); ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="form-actions text-right pal">
                        <button id="btn-pesquisa" type="submit" class="btn btn-primary"><i class="fa fa-search"></i> <?php echo __("Pesquisa") ?></button>                        &nbsp;
                        <button type="button" class="btn btn-green" onclick="AdicionarNovo('<?php echo site_url('faturamento/editar/'); ?>')"><i class="fa fa-plus"></i> <?php echo __("Adicionar Faturamento") ?></button>
                        <button type="button" class="btn btn-blue" onclick="AbrirImportarFaturamento()"><i class="fa fa fa-sign-in"></i> <?php echo __("Importar Faturamento") ?></button>
                        <button type="button" class="btn btn-blue" onclick="ExportarFaturamento();"><i class="fa fa-sign-out"></i> <?php echo __("Exportar Faturamento") ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
	<div class="col-lg-12">
		<div class="portlet box">
			<div class="portlet-header">
				<div class="caption"><?php echo __("Lista de Faturamento") ?></div>
			</div>
			<div class="portlet-body">
				<div class="row mbm">
					<div class="col-lg-12">
						<div class="table-responsive">
							<table id="faturamento_tabela" class="table table-hover table-bordered table-advanced display">
								<thead>
								<tr>
									<th style="width: 8%;"><?php echo __("ID"); ?></th>
									<th style="width: 64%;"><?php echo __("Faturamento"); ?></th>
									<th style="width: 20%;"><?php echo __("Ordem"); ?></th>
									<th style="width: 8%;"><?php echo __("A????o") ?></th>
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
    function confirmar(obj)
    {
        let url = $(obj).data('url');
        let msn = "<?php echo __("Tem certeza que deseja deletar definitivamente o faturamento?<br /><b>Aten????o: Ao confirmar n??o ser?? poss??vel desfazer essa a????o.</b>"); ?>";
        let titulo = "<?php echo __("Confirme"); ?>";
        confirm(msn, titulo, function(confirmed) {
            if (confirmed)
            {
                window.location = url;
            }
        });
    }
    function ExportarFaturamento(file = "", posicao = 0, total = 0)
    {
        let url = GetUrlAcao("faturamento","exportarfaturamento");
        let data = {
            "file":file,
            "posicao": posicao,
            "total": total,
        };
        data = $.extend( {}, data, {"FILTRO": $("#frmfaturamento").serializeArray()} );
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
                        ExportarFaturamento(data.file, data.posicao, data.total);
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
                let msn = "<?php echo __("Falha na de verifica????o de faturamento");?>";
                $('#divloding').slideUp("slow");
                $('#divBarra').slideUp("slow");
                alert(msn);
            }
        });
    }
    function FecharExportarFaturamento()
    {
        $('#filefaturamento').val("");
        $('#divExportar').slideUp("slow");
    }
    function FecharImportarFaturamento()
    {
        $('#divImportar').slideUp("slow");
        document.getElementById('filefaturamento').files = null;
        $('filefaturamento').val('');
    }
    function AbrirImportarFaturamento()
    {
        $('#divImportar').slideDown("slow");
    }
    function EnviarExcel(){
        let property = document.getElementById('filefaturamento').files[0];
        if(Vazio(property))
        {
            alert("<?php echo __("Voc?? deve selecionar o arquivo com os dados de importa????o de Faturamentos");?>");
            return;
        }
        let file_name = property.name;
        let file_extension = file_name.split('.').pop().toLowerCase();
        let urlfile = GetUrlAcao("faturamento","enviarexcel");
        let file_size = property.size;
        let max_size = parseInt("<?php echo $tamanhomax; ?>") * Math.pow(1024, 2);

        if(jQuery.inArray(file_extension,['csv','xls','xlsx','']) == -1){
            alert("<?php echo __("Extens??o de arquivo inv??lida<br/>extens??es permitidas s??o csv, xls e xlsx"); ?>");
            return;
        }
        if(file_size > max_size){
            alert("<?php echo sprintf(__("O arquivo n??o pode ser enviado porque excede o tamanho max??mo de %s"), $tamanhomax); ?>");
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
                    titulo = "<?php echo __("Importa????o");?>";
                    msn = "<?php echo __("Arquivo foi enviado com sucesso.<br/>Aguarde a finaliza????o do processo de importa????o de Faturamento.");?>";
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
                let msn = "<?php echo __("Falha ao enviar o arquivo de importa????o.");?>";
                $('#divloding').css('display','none');
                alert(msn);
            }
        });
    }
    function ImportacaoExcel(file, posicao, total){

        let url = GetUrlAcao("faturamento","importacaoexcel");

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
                        FecharImportarFaturamento();
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
                let msn = "<?php echo __("Falha na importa????o dos dados.");?>";
                $('#divloding').css('display','none');
                $('#divBarra').css('display','none');
                alert(msn);
            }
        });
    }
    $(document).ready(function() {
        var el_datatable = $('#faturamento_tabela').DataTable({
            "language":{ "url": CDN_Url('datatables') },
            "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": GetDominio('index.php/faturamento/listatabela/'),
                "data": function ( d ) {
                    return $.extend( {}, d, {"FILTRO": $('#frmfaturamento').serializeArray()} );
                },
                "type": 'post',
                "dataType": 'json',
            },
            columns: [
                {"data": "idfaturamento", render: $.fn.dataTable.render.number(',', '.', '')},            
				{'data': 'faturamento'},
				{'data': 'ordem'},
                {"data": "idfaturamento",
                    "render": function ( data, type, row, meta ) {
                        let url = GetDominio('index.php/faturamento/editar/'+data);
                        let link = '<a href="'+url+'" class="btn-tab-editar" title="Editar faturamento"><i class="fa fa-edit"></i></a>';
                        url = GetDominio('index.php/faturamento/excluir/'+data);
                        link += '<a href="javascript:;" class="btn-tab-excluir" title="Excluir faturamento" onclick="confirmar(this)" data-url="'+url+'"><i class="ion ion-android-trash"></i></a>';
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
            $('#faturamento_tabela_filter').css('display','none');
        } );

    });
</script>