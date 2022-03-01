<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-blue">
            <div class="panel-heading">
            <?php echo __("Filtro do cockpit de rastreamento de cliente") ?>
                <div class="tools">
                    <i class="fa fa-chevron-down" onclick="ExibePainel(this,'#painelrastreio')"></i>
                </div>
            </div>
            <div id="painelrastreio" class="panel-body pan">
                <form id="frmrastreio" action="<?php echo site_url('rastreio/listar/'); ?>" class="horizontal-form" method="GET">
                    <div class="form-body pal">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="empresa" class="control-label"><?php echo __("Empresa"); ?></label>
                                    <select id="empresa" name="empresa" class="form-control">
                                        <?php echo $obj->GerarOpcoesEmpresas("", __("--Todas--")); ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="idcliente" class="control-label"><?php echo __("Cliente"); ?></label>
                                    <select id="idcliente" name="idcliente" class="form-control">
                                        <?php echo $obj->GerarOpcoesClientes($obj->Get('idcliente'), __("--Todas--")); ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="cadastradoeminicio" class="control-label"><?php echo __("Cadastradoem entre") ?></label>
                                    <div class="input-group datetimepicker-default date">
                                        <input id="cadastradoeminicio" name="cadastradoeminicio" type="text" value="" class="form-control">
                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="cadastradoemfim" class="control-label"><?php echo __("a") ?></label>
                                    <div class="input-group datetimepicker-default date">
                                        <input id="cadastradoemfim" name="cadastradoemfim" type="text" value="" class="form-control">
                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row" id="divImportar" style="display: none; background-color: #e0f3e3; padding: 20px 0px;">
                            <div class="form-group">
                                <label for="subarea" class="col-md-3 control-label text-right"><?php echo __("Importar arquivo xls de rastreios"); ?> </label>
                                <div class="col-md-5">
                                    <div class="input-icon">
                                        <i class="fa fa-table"></i>
                                        <input id="filerastreio" name="filerastreio" type="file" value="" class="form-control">
                                    </div>
                                </div>


                                <div class="col-md-4">
                                    <button type="button" id="btn-EnviarExcel" class="btn btn-primary" onclick="EnviarExcel()">
                                        <i class="fa fa-cloud-upload"></i> <?php echo __("Enviar Arquivo") ?>
                                    </button>
                                    <a href="javascript:;" class="btn pull-right btn-exportar" style="color: #FF0000;" onclick="FecharImportarRastreio();">
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
                                <h5> <?php echo __("Importação de Rastreio"); ?></h5>
                                <div class="progress progress-striped active">
                                    <div id="processo" role="progressbar" aria-valuetransitiongoal="80" class="progress-bar progress-bar-warning" aria-valuenow="80" style="width: 80%;">80%</div>
                                </div>
                            </div>
                        </div>
                        <div class="row" id="divExportar" style="display: none;">
                            <div class="col-lg-12 mtm mbm">
                                <a href="javascript:;" class="btn pull-right btn-exportar" onclick="FecharExportarRastreio();">
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
                        <button id="btn-pesquisa" type="button" class="btn btn-primary"><i class="fa fa-search"></i> <?php echo __("Pesquisa") ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
	<div class="col-lg-2">
		<div class="portlet box">
			<div class="portlet-header">
				<div class="caption"><?php echo __("Login") ?></div>
			</div>
			<div class="portlet-body">
				<div class="row">
					<div class="col-lg-12 cx-rastreio" id="portlet-Login">
                    </div>
                    <div class="col-lg-12">
						<a href="javascript:;" class="btn-rastreio" data-posicao="0" data-total="0" data-tipo="Login"><i class="fa fa-plus"></i></a>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-lg-2">
		<div class="portlet box">
			<div class="portlet-header">
				<div class="caption"><?php echo __("Sua vagas") ?></div>
			</div>
			<div class="portlet-body">
				<div class="row">
					<div class="col-lg-12 cx-rastreio" id="portlet-VisualVaga">
                    </div>
                    <div class="col-lg-12">
						<a href="javascript:;" class="btn-rastreio" data-posicao="0" data-total="0" data-tipo="VisualVaga"><i class="fa fa-plus"></i></a>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-lg-2">
		<div class="portlet box">
			<div class="portlet-header">
				<div class="caption"><?php echo __("Nova vaga") ?></div>
			</div>
			<div class="portlet-body">
				<div class="row">
					<div class="col-lg-12 cx-rastreio" id="portlet-CadVaga">
                    </div>
                    <div class="col-lg-12">
						<a href="javascript:;" class="btn-rastreio" data-posicao="0" data-total="0" data-tipo="CadVaga"><i class="fa fa-plus"></i></a>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-lg-2">
		<div class="portlet box">
			<div class="portlet-header">
				<div class="caption"><?php echo __("Lista de candidato") ?></div>
			</div>
			<div class="portlet-body">
				<div class="row">
					<div class="col-lg-12 cx-rastreio" id="portlet-VisualCandidatosVaga">
                    </div>
                    <div class="col-lg-12">
						<a href="javascript:;" class="btn-rastreio" data-posicao="0" data-total="0" data-tipo="VisualCandidatosVaga"><i class="fa fa-plus"></i></a>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-lg-2">
		<div class="portlet box">
			<div class="portlet-header">
				<div class="caption"><?php echo __("Resumo vaga") ?></div>
			</div>
			<div class="portlet-body">
				<div class="row">
					<div class="col-lg-12 cx-rastreio" id="portlet-VisualResumoVaga">
                    </div>
                    <div class="col-lg-12">
						<a href="javascript:;" class="btn-rastreio" data-posicao="0" data-total="0" data-tipo="VisualResumoVaga"><i class="fa fa-plus"></i></a>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-lg-2">
		<div class="portlet box">
			<div class="portlet-header">
				<div class="caption"><?php echo __("Cadastro concluído") ?></div>
			</div>
			<div class="portlet-body">
				<div class="row">
					<div class="col-lg-12 cx-rastreio" id="portlet-CadVagaConcluido">
                    </div>
                    <div class="col-lg-12">
						<a href="javascript:;" class="btn-rastreio" data-posicao="0" data-total="0" data-tipo="CadVagaConcluido"><i class="fa fa-plus"></i></a>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-lg-12">
		<div class="portlet box">
			<div class="portlet-header">
				<div class="caption"><?php echo __("Candidatos das suas vagas") ?></div>
			</div>
			<div class="portlet-body">
				<div class="row mbm">
					<div class="col-lg-12">
						<div class="table-responsive">
							<table id="rastreio_tabela" class="table table-hover table-bordered table-advanced display">
								<thead>
                                
								<tr>
									<th rowspan="2" style="width: 10%;text-align: center; vertical-align: center;"><?php echo __("Data"); ?></th>
									<th colspan="6" style="text-align: center;"><?php echo __("Visualizou"); ?></th>
								</tr>
								<tr>
									<th style="width: 15%;"><?php echo __("Lista de candidato"); ?></th>
									<th style="width: 15%;"><?php echo __("Linkedin"); ?></th>
									<th style="width: 15%;"><?php echo __("Twitter") ?></th>
									<th style="width: 15%;"><?php echo __("Marcar Favorito"); ?></th>
									<th style="width: 15%;"><?php echo __("Desmarcar Favorito"); ?></th>
									<th style="width: 15%;"><?php echo __("Detalhes de candidato"); ?></th>
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
	<div class="col-lg-12">
		<div class="portlet box">
			<div class="portlet-header">
				<div class="caption"><?php echo __("Candidatos Visualizados") ?></div>
			</div>
			<div class="portlet-body">
				<div class="row mbm">
					<div class="col-lg-12">
						<div class="table-responsive">
							<table id="candidato_tabela" class="table table-hover table-bordered table-advanced display">
								<thead>
								<tr>
									<th style="width: 15%;"><?php echo __("Vaga"); ?></th>
									<th style="width: 15%;"><?php echo __("Candidato"); ?></th>
									<th style="width: 15%;"><?php echo __("Data") ?></th>
									<th style="width: 15%;"><?php echo __("Marcar Favorito"); ?></th>
									<th style="width: 15%;"><?php echo __("Desmarcar Favorito"); ?></th>
									<th style="width: 15%;"><?php echo __("Linkedin"); ?></th>
                                    <th style="width: 15%;"><?php echo __("Detalhes de candidato"); ?></th>
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
    
    function AdicionarLinhas(tipo = "Login", lista = null, posicao = 0) {        
        let html = '';
        let nome = '#portlet-'+tipo;
        if(Vazio(lista))
            return;
        lista.forEach(item => {
            html += `<div class="linha"><label>${item.data}</label><span>${item.qtd}</span></div>`;
        });

        if(Vazio(posicao))
        {
            $(nome).html(html);
        }
        else
        {
            $(nome).append(html);
        }
        return;
    };
    function GetTabelaRestreio(obj = null){

        let url = GetUrlAcao("rastreio","gettabelarestreio");

        let data = {
            "posicao": $(obj).data("posicao"),
            "total": $(obj).data("total"),
            "tipo": $(obj).data("tipo"),
        };
        data = $.extend( {}, data, {"FILTRO": $('#frmrastreio').serializeArray()} );
        $.ajax({
            url: url,
            method:'POST',
            data:data,
            beforeSend:function(xhr){
                let i = $(obj).find("i");
                i.removeClass("fa fa-plus").addClass("ion ion-loading-a");
            },
            success:function(data){
                let i = $(obj).find("i");
                let posicao = $(obj).data("posicao");
                if(data.sucesso)
                {
                    AdicionarLinhas($(obj).data("tipo"), data.lista, posicao);
                    if(data.finalizado == true)
                    {
                        $(obj).fadeOut( "slow" );
                    }
                    else
                    {
                        $(obj).data("total",data.total);
                        $(obj).data("posicao", data.posicao)
                    }
                }
                else
                {
                    let tipo = $(obj).data("tipo");
                    let nome = '#portlet-'+tipo;
                    html = `<div class="linha"><h5>${data.erro}</h5></div>`;
                    $(nome).html(html);
                }
                i.removeClass("ion ion-loading-a").addClass("fa fa-plus");
            },
            error: function(XHR, textStatus, errorThrown){
                let i = $(obj).find("i");
                let msn = "<?php echo __("Falha na importação dos dados.");?>";
                i.removeClass("ion ion-loading-a").addClass("fa fa-plus");
                alert(msn);
            }
        });
    }
    $(document).ready(function() {
        $( "a.btn-rastreio" ).click(function() {
            GetTabelaRestreio(this);
        });
        $( "a.btn-rastreio" ).each(function( index ) {
            GetTabelaRestreio(this);
        });
        formatData('#cadastradoeminicio', pais);
        formatData('#cadastradoemfim', pais);
        var el_datatable = $('#rastreio_tabela').DataTable({
            "language":{ "url": CDN_Url('datatables') },
            "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": GetDominio('index.php/rastreio/listatabelacockpitcandidato/'),
                "data": function ( d ) {
                    return $.extend( {}, d, {"FILTRO": $('#frmrastreio').serializeArray()},{"cockpitcandidato":1} );
                },
                "type": 'post',
                "dataType": 'json',
            },
            columns: [
                {"data": "data"},
				{'data': "VisualCandidatosVaga", render: $.fn.dataTable.render.number(',', '.', '')},
				{'data': "VisualLKD", render: $.fn.dataTable.render.number(',', '.', '')},
				{'data': "VisualTwitter", render: $.fn.dataTable.render.number(',', '.', '')},
				{'data': "MarcarFavorito", render: $.fn.dataTable.render.number(',', '.', '')},
				{'data': "DesmarcarFavorito", render: $.fn.dataTable.render.number(',', '.', '')},
                {'data': "VisualEdit", render: $.fn.dataTable.render.number(',', '.', '')}
            ],
        });
        
        var el_candidatotable = $('#candidato_tabela').DataTable({
            "language":{ "url": CDN_Url('datatables') },
            "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": GetDominio('index.php/rastreio/listatabelacandidatocockpit/'),
                "data": function ( d ) {
                    return $.extend( {}, d, {"FILTRO": $('#frmrastreio').serializeArray()},{"candidatocockpit":1} );
                },
                "type": 'post',
                "dataType": 'json',
            },
            columns: [
                {"data": "titulodavaga",
                    "render": function ( data, type, row, meta ) {
                        let empresa = row['empresacontratante'];
                        let link = data;
                        if(!Vazio(empresa))
                            link += ' ('+empresa+')';
                        return link;
                    }
                },
                {'data': "nome"},
                {'data': "data"},
				{'data': "MarcarFavorito", render: $.fn.dataTable.render.number(',', '.', '')},
				{'data': "DesmarcarFavorito", render: $.fn.dataTable.render.number(',', '.', '')},
                {'data': "VisualEdit", render: $.fn.dataTable.render.number(',', '.', '')},
				{'data': "VisualLKD", render: $.fn.dataTable.render.number(',', '.', '')}
            ],
        });

        $("#btn-pesquisa").click(function(){
            el_datatable.ajax.reload();
            el_candidatotable.ajax.reload();
            $( "a.btn-rastreio" ).each(function( index ) {
                $(this).data("total", 0);
                $(this).data("posicao", 0);
                GetTabelaRestreio(this);
            });
            return false;
        });
        el_datatable.on( 'draw', function () {
            $('#rastreio_tabela_filter').css('display','none');
        });
        
        el_candidatotable.on( 'draw', function () {
            $('#candidato_tabela_filter').css('display','none');
        });
        $("#empresa").change(function() {
            let url = GetUrlAcao("rastreio","listacliente");
            let data = null;
            let empresa = $(this).val();
            let msn = "";
            if(Vazio(empresa))
            {
                return;
            }
            data = {
                "empresa":empresa
            }    
            $.ajax({
                url: url,
                method:'POST',
                data:data,
                success:function(data){
                    if(data.sucesso)
                    {
                        let html = '<option value=""><?php echo __("-- Selecione --"); ?></option>';
                        if(!Vazio(data.lista))
                        {
                            for( let i = 0; i < data.lista.length; i++)
                            {
                                id = data.lista[i].id;
                                texto = data.lista[i].texto;
                                html += `<option value="${id}">${texto}</option>`;
                            }
                        }
                        $("#idcliente").html(html);
                    }
                    else
                    {
                        let html = '<option value=""><?php echo __("-- Selecione --"); ?></option>';
                        $("#idcliente").html(html);
                    }
                },
                error: function(XHR, textStatus, errorThrown){
                    msn = "Falha ao buscar lista de cliente.";
                    MsnDanger("Erro", msn);
                }
            });
        });
    });
</script>