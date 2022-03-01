<div class="row">
<?php
 	$msgFlash = $this->session->flashdata('msg_flash');
 	if(!empty($msgFlash))
 		echo $msgFlash;
?>
    <div class="col-lg-12">
        <div class="panel panel-blue">
            <div class="panel-heading">
                <?php echo __("Filtro de Colaborador") ?>
                <div class="tools">
                    <i class="fa fa-chevron-down" onclick="ExibePainel(this,'#painelcolaborador')"></i>
                </div>
            </div>
            <div id="painelcolaborador" class="panel-body pan">
                <form id="frmcolaborador" action="<?php echo base_url('colaborador/listar/'); ?>" class="horizontal-form" method="GET">
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
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="acesso" class="control-label"><?php echo __("Acesso"); ?></label>
                                    <select id="acesso" name="acesso" class="form-control">
				                        <?php echo $obj->GerarOpcoesAcesso("", " -- Todas --"); ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-actions text-right pal">
                        <button id="btn-pesquisa" type="submit" class="btn btn-primary"><i class="fa fa-search"></i> <?php echo __("Pesquisa") ?></button>                        &nbsp;
                        <button type="button" class="btn btn-green" onclick="AdicionarNovo('<?php echo site_url('colaborador/editar/0'); ?>')"><i class="fa fa-plus"></i> <?php echo __("Adicionar Colaborador") ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
	<div class="col-lg-12">
		<div class="portlet box">
			<div class="portlet-header">
				<div class="caption"><?php echo __("Lista de Colaboradores") ?></div>
			</div>
			<div class="portlet-body">
				<div class="row mbm">
					<div class="col-lg-12">
						<div class="table-responsive">
							<table id="colaborador_tabela" class="table table-hover table-bordered table-advanced">
								<thead>
								<tr>
                                    <th style="width: 8%;"><?php echo __("ID"); ?></th>
                                    <th style="width: 10%;"><?php echo __("Foto"); ?></th>
                                    <th style="width: 34%;"><?php echo __("Nome"); ?></th>
                                    <th style="width: 18%;"><?php echo __("Telefone"); ?></th>
                                    <th style="width: 18%;"><?php echo __("Email"); ?></th>
									<th style="width: 8%;"><?php echo __("Ação") ?></th>
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
                <h4 class="modal-title"><?php echo __("Gerar nova um nova senha para o colaborador") ?></h4>
            </div>
            <div class="modal-body">
                <form id="frmsenha">
                    <div class="row">
                        <div class="col-md-12">
                            <input id="idcolaborador" name="idcolaborador" type="hidden" value="">
                            <div class="form-group">
                                <label for="idcolaborador" class="control-label"><?php echo __("Colaborador") ?></label>
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
    function confirmar(obj)
    {
        var url = $(obj).data('url');
        confirm("<?php echo __("Tem certeza que deseja deletar definitivamente o colaborador?<br /><b>Atenção: O colaborador será removido permanentemente junto com todos os usuários relacionados ao mesmo. Ao confirmar não será possível desfazer essa ação.</b>"); ?>", "<?php echo __("Confirme"); ?>", function(confirmed) {
            if (confirmed)
            {
                window.location = url;
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
        let msn = "<?php echo __("Tem certeza que deseja alterar senha o colaborador?<br /><b>Atenção: Você deve salvar a nova senha para enviá-la ao colaborador.</b>"); ?>";
        confirm(msn, "<?php echo __("Confirme"); ?>", function(confirmed) {
            if (confirmed)
            {
                SalvarNovaSenha();
            }
        });
    }
    function SalvarNovaSenha(){
        let idcolaborador = $("#frmsenha #idcolaborador").val();
        let nome = $("#frmsenha #nome").val();
        let senha = $("#frmsenha #senha").val();
        var url = GetUrlAcao("colaborador","salvarnovasenha");

        if(Vazio(senha))
        {
            MsnDanger("<?php echo __("Erro");?>", "<?php echo __("Você deve informar a nova senha");?>");
            return;
        }
        var data = {
            "idcolaborador": idcolaborador,
            "nome": nome,
            "senha": senha,
        };
        $.ajax({
            url: url,
            method:'POST',
            data:data,
            beforeSend:function(xhr){
                $('#btnGerarNovaSenha i').removeClass("fa fa-save").addClass("ion ion-loading-b");
            },
            success:function(data){
                if(data.sucesso)
                {
                    titulo = data.titulo;
                    msn = data.mensagem;
                    MsnSucesso(titulo, msn);
                    $('#btnGerarNovaSenha i').removeClass("ion ion-loading-b").addClass("fa fa-save");
                    $('#modal-alterar-senha').modal('hide');
                }
                else
                {
                    $('#btnGerarNovaSenha i').removeClass("ion ion-loading-b").addClass("fa fa-save");
                    msn = data.erro;
                    alert(msn);
                }
            },
            error: function(XHR, textStatus, errorThrown){
                $('#btnGerarNovaSenha i').removeClass("ion ion-loading-b").addClass("fa fa-save");
                msn = "<?php echo __("Falha ao enviar o arquivo de importação.");?>";
                alert(msn);
            }
        });
    }
    $(document).ready(function() {
        var el_datatable = $('#colaborador_tabela').DataTable({
            "language":{ "url": "//cdn.datatables.net/plug-ins/1.10.12/i18n/Portuguese-Brasil.json" },
            "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": GetDominio('index.php/colaborador/listatabela/'),
                "data": function ( d ) {
                    return $.extend( {}, d, {"FILTRO": $('#frmcolaborador').serializeArray()} );
                },
                "type": 'post',
                "dataType": 'json',
            },
            columns: [
                {"data": "idcolaborador", render: $.fn.dataTable.render.number(',', '.', '')},
                {"data": "foto",
                    "render": function ( data, type, row, meta ) {
                        var imagem = '<img src="'+data+'" alt="avatar de '+row['nome']+'" class="imageAvatar"/>';
                        return imagem;
                    }
                },
                {"data": "nome"},
                {"data": "telefone"},
                {"data": "email"},
                {"data": "idcolaborador",
                    "render": function ( data, type, row, meta ) {
                        var url = GetDominio('index.php/colaborador/editar/'+data);
                        var link = '<a href="'+url+'" class="btn-tab-editar" title="Editar colaborador"><i class="fa fa-edit"></i></a>';
                        url = GetDominio('index.php/colaborador/excluir/'+data);
                        link += '<a href="javascript:;" class="btn-tab-excluir" title="Excluir colaborador" onclick="confirmar(this)" data-url="'+url+'"><i class="ion ion-android-trash"></i></a>';
                        <?php
                            if(TemAcesso(array('Administrador'))):
                        ?>
                        link += `<a href="javascript:;" class="btn-tab-excluir" title="Gerar nova senha para o colaborador" onclick="AbrirGerarNovaSenha(this)" data-nome="${row['nome']}" data-id="${row['idcolaborador']}"><i class="fa fa-key"></i></a>`;  
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
            $('#colaborador_tabela_filter').css('display','none');
        } );
        ExibePainel($('.panel-heading .tools i').get(0),'#painelcolaborador');
        
    });
</script>