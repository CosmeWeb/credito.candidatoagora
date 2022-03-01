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
                                    <th style="width: 30%;"><?php echo __("Nome"); ?></th>
                                    <th style="width: 20%;"><?php echo __("Telefone"); ?></th>
                                    <th style="width: 20%;"><?php echo __("Email"); ?></th>
									<th style="width: 12%;"><?php echo __("Ação") ?></th>
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
        var url = $(obj).data('url');
        confirm("<?php echo __("Tem certeza que deseja deletar definitivamente o colaborador?<br /><b>Atenção: O colaborador será removido permanentemente junto com todos os usuários relacionados ao mesmo. Ao confirmar não será possível desfazer essa ação.</b>"); ?>", "<?php echo __("Confirme"); ?>", function(confirmed) {
            if (confirmed)
            {
                window.location = url;
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
        
    });
</script>