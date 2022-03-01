<div class="row">
	<?php
		$msgFlash = $this->session->flashdata('msg_flash');
		if(!empty($msgFlash))
			echo $msgFlash;
	?>
    <div class="col-lg-12">
        <div class="panel panel-blue">
            <div class="panel-heading">
                <?php echo __("Filtro de Configurações") ?>
                <div class="tools">
                    <i class="fa fa-chevron-down" onclick="ExibePainel(this,'#painelconfiguracao')"></i>
                </div>
            </div>
            <div id="painelconfiguracao" class="panel-body pan">
                <form id="frmconfiguracao" action="<?php echo base_url('configuracao/listar/'); ?>" class="horizontal-form" method="GET">
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
                    </div>
                    <div class="form-actions text-right pal">
                        <button id="btn-pesquisa" type="submit" class="btn btn-primary"><i class="fa fa-search"></i> <?php echo __("Pesquisa") ?></button>
                        <button type="button" class="btn btn-green" onclick="AdicionarNovo('<?php echo base_url('configuracao/editar/0'); ?>')"><i class="fa fa-plus"></i> <?php echo __("Adicionar Configuração") ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-lg-12">
        <div class="portlet box">
            <div class="portlet-header">
                <div class="caption"><?php echo __("Lista de Configurações") ?></div>
            </div>
            <div class="portlet-body">
                <div class="row mbm">
                    <div class="col-lg-12">
                        <div class="table-responsive">
                            <table id="configuracao_tabela" class="table table-hover table-bordered table-advanced display">
                                <thead>
                                <tr>
                                    <th style="width: 7%;"><?php echo __("ID"); ?></th>
                                    <th style="width: 15%;"><?php echo __("Nome"); ?></th>
                                    <th style="width: 26%;"><?php echo __("Título"); ?></th>
                                    <th style="width: 26%;"><?php echo __("Valor"); ?></th>
                                    <th style="width: 20%;"><?php echo __("Padrão"); ?></th>
                                    <th style="width: 6%;"><?php echo __("Ação") ?></th>
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
        confirm("<?php echo __("Tem certeza que deseja deletar definitivamente a configuração?<br /><b>Atenção: a configuração será removido permanentemente junto com todos os usuários relacionados ao mesmo. Ao confirmar não será possível desfazer essa ação.</b>"); ?>", "<?php echo __("Confirme"); ?>", function(confirmed) {
            if (confirmed)
            {
                window.location = url;
            }
        });
    }
    $(document).ready(function() {
        var el_datatable = $('#configuracao_tabela').DataTable({
            "language":{ "url": "//cdn.datatables.net/plug-ins/1.10.12/i18n/Portuguese-Brasil.json" },
            "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": GetDominio('index.php/configuracao/listatabela/'),
                "data": function ( d ) {
                    return $.extend( {}, d, {"FILTRO": $('#frmconfiguracao').serializeArray()} );
                },
                "type": 'post',
                "dataType": 'json',
            },
            columns: [
                {"data": "idconfiguracao", render: $.fn.dataTable.render.number(',', '.', '')},
                {'data': 'nome'},
                {'data': 'titulo'},
                {'data': 'valor'},
                {'data': 'padrao'},
                {"data": "idconfiguracao",
                    "render": function ( data, type, row, meta ) {
                        var url = GetDominio('index.php/configuracao/editar/'+data);
                        var link = '<a href="'+url+'" class="btn-tab-editar" title="Editar configuração"><i class="fa fa-edit"></i></a>';
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
            $('#configuracao_tabela_filter').css('display','none');
        } );

    });
</script>