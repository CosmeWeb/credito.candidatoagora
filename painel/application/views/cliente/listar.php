<div class="row">
<?php
 	$msgFlash = $this->session->flashdata('msg_flash');
 	if(!empty($msgFlash))
 		echo $msgFlash;
?>
    <div class="col-lg-12">
        <div class="panel panel-blue">
            <div class="panel-heading">
            <?php echo __("Filtro de Cliente") ?>
                <div class="tools">
                    <i class="fa fa-chevron-down" onclick="ExibePainel(this,'#painelcliente')"></i>
                </div>
            </div>
            <div id="painelcliente" class="panel-body pan">
                <form id="frmcliente" action="<?php echo site_url('cliente/listar/'); ?>" class="horizontal-form" method="GET">
                    <div class="form-body pal">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                	<label for="buscar" class="control-label"><?php echo __("Buscar") ?></label>
                                    <div class="input-icon right">
                                    	<input id="buscar" name="buscar" type="text" placeholder="Buscar" value="<?php echo Get("buscar"); ?>" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="acesso" class="control-label"><?php echo __("Acesso") ?></label>
                                    <select id="acesso" name="acesso" class="form-control">
				                        <?php echo $obj->GerarOpcoesAcesso("", __("-- Todos --")); ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="status" class="control-label"><?php echo __("Status") ?></label>
                                    <select id="status" name="startup" class="form-control">
				                        <?php echo $obj->GerarOpcoesStatus("", __("-- Todos --")); ?>
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
                        <div class="row" id="divImportar" style="display: none; background-color: #e0f3e3; padding: 20px 0px;">
                            <div class="form-group">
                                <label for="subarea" class="col-md-3 control-label text-right"><?php echo __("Importar arquivo xls de clientes"); ?> </label>
                                <div class="col-md-5">
                                    <div class="input-icon">
                                        <i class="fa fa-table"></i>
                                        <input id="filecliente" name="filecliente" type="file" value="" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <button type="button" id="btn-EnviarExcel" class="btn btn-primary" onclick="EnviarExcel()">
                                        <i class="fa fa-cloud-upload"></i> <?php echo __("Enviar Arquivo") ?>
                                    </button>
                                    <a href="javascript:;" class="btn pull-right btn-exportar" style="color: #FF0000;" onclick="FecharImportarCliente();">
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
                                <h5> <?php echo __("Importa????o de Cliente"); ?></h5>
                                <div class="progress progress-striped active">
                                    <div id="processo" role="progressbar" aria-valuetransitiongoal="80" class="progress-bar progress-bar-warning" aria-valuenow="80" style="width: 80%;">80%</div>
                                </div>
                            </div>
                        </div>
                        <div class="row" id="divExportar" style="display: none;">
                            <div class="col-lg-12 mtm mbm">
                                <a href="javascript:;" class="btn pull-right btn-exportar" onclick="FecharExportarCliente();">
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
                        <button type="button" class="btn btn-green" onclick="AdicionarNovo('<?php echo site_url('cliente/editar/'); ?>')"><i class="fa fa-plus"></i> <?php echo __("Adicionar Cliente") ?></button>
                        <button type="button" class="btn btn-blue" onclick="AbrirImportarCliente()"><i class="fa fa fa-sign-in"></i> <?php echo __("Importar Cliente") ?></button>
                        <button type="button" class="btn btn-blue" onclick="ExportarCliente();"><i class="fa fa-sign-out"></i> <?php echo __("Exportar Cliente") ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
	<div class="col-lg-12">
		<div class="portlet box">
			<div class="portlet-header">
				<div class="caption"><?php echo __("Lista de Cliente") ?></div>
			</div>
			<div class="portlet-body">
				<div class="row mbm">
					<div class="col-lg-12">
						<div class="table-responsive">
							<table id="cliente_tabela" class="table table-hover table-bordered table-advanced display">
								<thead>
                                    <tr>
                                        <th style="width: 7%;"><?php echo __("ID"); ?></th>
                                        <th style="width: 18%;"><?php echo __("Nome"); ?></th>
                                        <th style="width: 15%;"><?php echo __("E-mail"); ?></th>
                                        <th style="width: 14%;"><?php echo __("Empresa"); ?></th>
                                        <th style="width: 8%;"><?php echo __("Cr??ditos"); ?></th>
                                        <th style="width: 11%;"><?php echo __("Gestores"); ?></th>
                                        <th style="width: 8%;"><?php echo __("Acesso"); ?></th>
                                        <th style="width: 10%;"><?php echo __("Cadastrado em"); ?></th>
                                        <th style="width: 9%;"><?php echo __("A????o") ?></th>
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
<!--BEGIN MODAL ALTERAR SENHA-->
<div id="modal-alterar-senha" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" data-dismiss="modal" aria-hidden="true" class="close"><i class="fa fa-close"></i></button>
                <h4 class="modal-title"><?php echo __("Gerar nova um nova senha para o cliente") ?></h4>
            </div>
            <div class="modal-body">
                <form id="frmsenha">
                    <div class="row">
                        <div class="col-md-12">
                            <input id="idcliente" name="idcliente" type="hidden" value="">
                            <div class="form-group">
                                <label for="idcliente" class="control-label"><?php echo __("Cliente") ?></label>
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fa fa-user"></i>
                                    </span>
                                    <input id="nome" name="nome" type="text" class="form-control" value="">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="senha" class="control-label"><?php echo __("Nova Senha") ?></label>
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fa fa-key"></i>
                                    </span>
                                    <input id="senha" name="senha" type="text" class="form-control" value="">
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-default">
                    <i class="fa fa-remove"></i>
                    <?php echo __("Fechar") ?>
                </button>
                <button id="btnGerarSenha" type="button" class="btn btn-orange" onclick="GerarSenha(this)">
                    <i class="ion ion-loop"></i>
                    <?php echo __("Gerar nova senha") ?>
                </button>
                <button id="btnCopiarSenha" type="button" class="btn btn-primary" onclick="CopiarSenha()">
                    <i class="fa fa-copy"></i>
                    <?php echo __("Copiar") ?>
                </button>
                <button id="btnGerarNovaSenha" type="button" class="btn btn-green" onclick="GerarNovaSenha()">
                    <i class="fa fa-save"></i>
                    <?php echo __("Salvar") ?>
                </button>
            </div>
        </div>
    </div>
</div>
<!--END MODAL ALTERAR SENHA-->
<script>
    var pais = '<?php echo $this->gestao->GetPaisPadrao(); ?>';
    function confirmar(obj)
    {
        var url = $(obj).data('url');
        confirm("<?php echo __("Tem certeza que deseja deletar definitivamente o cliente?<br /><b>Aten????o: Ao confirmar n??o ser?? poss??vel desfazer essa a????o.</b>"); ?>", "<?php echo __("Confirme"); ?>", function(confirmed) {
            if (confirmed)
            {
                window.location = url;
            }
        });
    }
    function ExportarCliente()
    {
        var url = GetUrlAcao("cliente","exportarcliente");
        var data = $("#frmcliente").serialize();
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
                msn = "<?php echo __("Falha na de verifica????o de cliente");?>";
                alert(msn);
            }
        });
    }
    function FecharExportarCliente()
    {
        $('#filecliente').val("");
        $('#divExportar').slideUp("slow");
    }
    function FecharImportarCliente()
    {
        $('#divImportar').slideUp("slow");
        document.getElementById('filecliente').files = null;
        $('filecliente').val('');
    }
    function AbrirImportarCliente()
    {
        $('#divImportar').slideDown("slow");
    }
    function EnviarExcel(){
        var property = document.getElementById('filecliente').files[0];
        if(Vazio(property))
        {
            alert("<?php echo __("Voc?? deve selecionar o arquivo com os dados de importa????o de Clientes");?>");
            return;
        }
        var file_name = property.name;
        var file_extension = file_name.split('.').pop().toLowerCase();
        var urlfile = GetUrlAcao("cliente","enviarexcel");
        var file_size = property.size;
        var max_size = parseInt("<?php echo $tamanhomax; ?>") * Math.pow(1024, 2);

        if(jQuery.inArray(file_extension,['csv','xls','xlsx','']) == -1){
            alert("<?php echo __("Extens??o de arquivo inv??lida<br/>extens??es permitidas s??o csv, xls e xlsx"); ?>");
            return;
        }
        if(file_size > max_size){
            alert("<?php echo sprintf(__("O arquivo n??o pode ser enviado porque excede o tamanho max??mo de %s"), $tamanhomax); ?>");
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
                    titulo = "<?php echo __("Importa????o");?>";
                    msn = "<?php echo __("Arquivo foi enviado com sucesso.<br/>Aguarde a finaliza????o do processo de importa????o de Cliente.");?>";
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
                msn = "<?php echo __("Falha ao enviar o arquivo de importa????o.");?>";
                alert(msn);
            }
        });
    }
    function ImportacaoExcel(file, posicao, total){

        var url = GetUrlAcao("cliente","importacaoexcel");

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
                var aux = total;
                var porcente = 0;
                var texto = posicao+' / '+total;
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
                        FecharImportarCliente();
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
                msn = "<?php echo __("Falha na importa????o dos dados.");?>";
                alert(msn);
            }
        });
    }
    function GerarSenha(obj = null)
    {
        let senha = geraStringAleatoria(10);
        let i = $(obj).find("i");
        i.removeClass("ion ion-loop").addClass("ion ion-looping");
        senha = geraStringAleatoria(10);
        $("#frmsenha #senha").val(senha);
        var myVar = setTimeout(function(){
            i.removeClass("ion ion-looping").addClass("ion ion-loop");
            clearTimeout(myVar);
        } , 2000);
       
    }
    function CopiarSenha()
    {
        try
        {
            let caixaTexto = $("#frmsenha #senha");
            let texto = caixaTexto.val();
            copyTextToClipboard(caixaTexto, texto);
        }
        catch (err)
        {
            console.error('Fallback: Oops, unable to copy', err);
        }
    }
    function AbrirGerarNovaSenha(obj = null)
    {
        let id = $(obj).data("id");
        let nome = $(obj).data("nome");
        let senha = geraStringAleatoria(10);
        $("#modal-alterar-senha").modal();
        $("#frmsenha #idcolaborador").val(id);
        $("#frmsenha #nome").val(nome);
        $("#frmsenha #senha").val(senha);
    }
    function GerarNovaSenha()
    {
        let msn = "<?php echo __("Tem certeza que deseja alterar senha do cliente?<br /><b>Aten????o: Voc?? deve salvar a nova senha para envi??-la ao cliente.</b>"); ?>";
        confirm(msn, "<?php echo __("Confirme"); ?>", function(confirmed) {
            if (confirmed)
            {
                SalvarNovaSenha();
            }
        });
    }
    $(document).ready(function() {
        var el_datatable = $('#cliente_tabela').DataTable({
            "language":{ "url": CDN_Url('datatables') },
            "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": GetDominio('index.php/cliente/listatabela/'),
                "data": function ( d ) {
                    return $.extend( {}, d, {"FILTRO": $('#frmcliente').serializeArray()} );
                },
                "type": 'post',
                "dataType": 'json',
            },
            columns: [
                {"data": "idcliente", render: $.fn.dataTable.render.number(',', '.', '')},            
				{'data': 'nome'},
                {'data': 'email'},
                {'data': 'empresa'},
                {'data': 'saldoconta'},
                {'data': 'gestor'},
				{'data': 'acesso'},
				{'data': 'cadastradoem'},
                {"data": "idcliente",
                    "render": function ( data, type, row, meta ) {
                        var url = GetDominio('index.php/cliente/editar/'+data);
                        var link = '<a href="'+url+'" class="btn-tab-editar" title="Editar cliente"><i class="fa fa-edit"></i></a>';
                        url = GetDominio('index.php/cliente/excluir/'+data);
                        link += '<a href="javascript:;" class="btn-tab-excluir" title="Excluir cliente" onclick="confirmar(this)" data-url="'+url+'"><i class="ion ion-android-trash"></i></a>';
                        if(row['status'] == 'Ativo')
                        {
                            link += '<a href="#" class="btn-tab-excluir" title="Cliente Ativado" ><i class="fa fa-check-circle-o" style="color:green"></i></a>';
                        }
                        else
                        {
                            link += '<a href="#" class="btn-tab-excluir" title="Cliente Inativado" ><i class="fa fa-times-circle-o"style="color:red"></i></a>';
                        }
                        <?php
                            if(TemAcesso(array('Administrador'))):
                        ?>
                        link += `<a href="javascript:;" class="btn-tab-excluir" title="Gerar nova senha para o cliente" onclick="AbrirGerarNovaSenha(this)" data-nome="${row['nome']}" data-id="${row['idcliente']}"><i class="fa fa-key"></i></a>`;  
                        <?php
                            endif;
                        ?>
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
            $('#cliente_tabela_filter').css('display','none');
        } );
        formatData('#cadastradoeminicio', pais);
        formatData('#cadastradoemfim', pais);
    });
</script>