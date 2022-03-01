<div class="row">
<?php
 	$msgFlash = $this->session->flashdata('msg_flash');
 	if(!empty($msgFlash))
 		echo $msgFlash;
?>
    <div class="col-lg-12">
        <div class="panel panel-blue">
            <div class="panel-heading">
            <?php echo __("Filtro de Candidato") ?>
                <div class="tools">
                    <i class="fa fa-chevron-down" onclick="ExibePainel(this,'#painelcandidato')"></i>
                </div>
            </div>
            <div id="painelcandidato" class="panel-body pan">            
                <form id="frmcandidato" action="<?php echo site_url('candidato/listar/'); ?>" class="horizontal-form" method="GET">
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
                                    <label for="idpais" class="control-label"><?php echo __("Pais"); ?></label>
                                    <select id="idpais" name="idpais" class="form-control">
                                        <?php echo $obj->GerarOpcoesPais("", __("--Todas--")); ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="idestado" class="control-label"><?php echo __("Estado"); ?></label>
                                    <select id="idestado" name="idestado" class="form-control">
                                        <?php echo $obj->GerarOpcoesEstado("", __("--Todas--")); ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="idcidade" class="control-label"><?php echo __("Cidade"); ?></label>
                                    <select id="idcidade" name="idcidade" class="form-control">
                                        <?php echo $obj->GerarOpcoesCidade("", __("--Todas--")); ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="favorito" class="control-label"><?php echo __("Favorito"); ?></label>
                                    <select id="favorito" name="favorito" class="form-control">
                                        <?php echo $obj->GerarOpcoesFavorito("", __("--Todas--"));?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="sexo" class="control-label"><?php echo __("Sexo"); ?></label>
                                    <select id="sexo" name="sexo" class="form-control">
                                        <?php 
                                        $obj->SetExibirPrimeira(false); 
                                        echo $obj->GerarOpcoesSexo("", __("--Todas--"));
                                        $obj->SetExibirPrimeira(true);
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="idcargo" class="control-label"><?php echo __("Cargo"); ?></label>
                                    <select id="idcargo" name="idcargo" class="form-control">
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="datacoletainicio" class="control-label"><?php echo __("Data da coleta entre") ?></label>
                                    <div class="input-group datetimepicker-default date">
                                        <input id="datacoletainicio" name="datacoletainicio" type="text" value="" class="form-control">
                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="datacoletafim" class="control-label"><?php echo __("a") ?></label>
                                    <div class="input-group datetimepicker-default date">
                                        <input id="datacoletafim" name="datacoletafim" type="text" value="" class="form-control">
                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="dataaplicacaoinicio" class="control-label"><?php echo __("Data da aplicação entre") ?></label>
                                    <div class="input-group datetimepicker-default date">
                                        <input id="dataaplicacaoinicio" name="dataaplicacaoinicio" type="text" value="" class="form-control">
                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="dataaplicacaofim" class="control-label"><?php echo __("a") ?></label>
                                    <div class="input-group datetimepicker-default date">
                                        <input id="dataaplicacaofim" name="dataaplicacaofim" type="text" value="" class="form-control">
                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="nomeempresa" class="control-label"><?php echo __("Empresa"); ?></label>
                                    <select id="nomeempresa" name="nomeempresa" class="form-control">
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="idvaga" class="control-label"><?php echo __("Vaga"); ?></label>
                                    <select id="idvaga" name="idvaga" class="form-control">
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="avaliacao" class="control-label"><?php echo __("Avaliação"); ?></label>
                                    <select id="avaliacao" name="avaliacao" class="form-control">
                                        <?php echo $obj->GerarOpcoesAvaliacao("", __("--Todas--"));?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="linkedin_desatualizado" class="control-label"><?php echo __("Linkedin desatualizado"); ?></label>
                                    <select id="linkedin_desatualizado" name="linkedin_desatualizado" class="form-control">
                                        <?php
                                            $obj->SetExibirPrimeira(false); 
                                            echo $obj->GerarOpcoesLinkedinDesatualizado("", __("--Todas--"));
                                            $obj->SetExibirPrimeira(true);
                                         ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="retornoinvitelkd" class="control-label"><?php echo __("Com retorno invite linkedin"); ?></label>
                                    <select id="retornoinvitelkd" name="retornoinvitelkd" class="form-control">
                                        <?php echo $obj->GerarOpcoesRetornoInviteLKD("", __("--Todas--"));?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="favorito123" class="control-label"><?php echo __("Favorito 123"); ?></label>
                                    <select id="favorito123" name="favorito123" class="form-control">
                                        <?php
                                        $obj->SetExibirPrimeira(false); 
                                        echo $obj->GerarOpcoesFavorito123("", __("--Todas--"));
                                        $obj->SetExibirPrimeira(true);
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="idabordagem" class="control-label"><?php echo __("Abordagem"); ?></label>
                                    <select id="idabordagem" name="idabordagem" class="form-control">
                                        <?php
                                        $obj->SetExibirPrimeira(false); 
                                        echo $obj->GerarOpcoesAbordagem("", __("--Todas--"));
                                        $obj->SetExibirPrimeira(true);
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row" id="divImportar" style="display: none; background-color: #e0f3e3; padding: 20px 0px;">
                            <div class="form-group">
                                <div class="col-md-4">
                                    <label for="filecandidato" class="control-label text-right">
                                        <?php echo __("Importar arquivo xls de candidatos"); ?>
                                    </label>
                                    <div class="input-icon">
                                        <i class="fa fa-table"></i>
                                        <input id="filecandidato" name="filecandidato" type="file" value="" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <label for="vaga" class="control-label text-right">
                                        <?php echo __("Vaga"); ?>
                                    </label>
                                    <select id="vaga" name="vaga" class="form-control">
                                        <?php echo $obj->GerarOpcoesVagas("", __("--Todos--")); ?>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label for="novo" class="control-label text-right">
                                        <?php echo __("Incluir com a marcação de novos candidatos"); ?>
                                    </label>
                                    <select id="novo" name="novo" class="form-control">
                                        <?php echo $obj->GerarOpcoesNovo("", __("--Selecionar--")); ?>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <button type="button" id="btn-EnviarExcel" class="btn btn-primary" onclick="EnviarExcel()" style="margin-top: 22px;">
                                        <i class="fa fa-cloud-upload"></i> <?php echo __("Enviar Arquivo") ?>
                                    </button>
                                    <a href="javascript:;" class="btn pull-right btn-exportar" style="color: #FF0000;" onclick="FecharImportarCandidato();">
                                        <i class="fa fa-close"></i>
                                    </a>
                                </div>
                                <div class="col-md-12">
                                    <input id="importarnovos" name="importarnovos" type="checkbox" class="switch" value="Novos">
                                    <label for="novo" class="control-label text-right" style="margin: 5px 0px 0px 8px; font-weight: 800;">
                                        <?php echo __("Adicionar somente novos"); ?>
                                    </label>
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
                                <h5> <?php echo __("Importação de Candidato"); ?></h5>
                                <div class="progress progress-striped active">
                                    <div id="processo" role="progressbar" aria-valuetransitiongoal="80" class="progress-bar progress-bar-warning" aria-valuenow="80" style="width: 80%;">80%</div>
                                </div>
                            </div>
                        </div>
                        <div class="row" id="divExportar" style="display: none;">
                            <div class="col-lg-12 mtm mbm">
                                <a href="javascript:;" class="btn pull-right btn-exportar" onclick="FecharExportarCandidato();">
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
                        <button id="btn-pesquisa" type="submit" class="btn btn-primary"><i class="fa fa-search"></i> <?php echo __("Pesquisa") ?></button>&nbsp;
                        <button type="button" class="btn btn-green" onclick="AdicionarNovo('<?php echo site_url('candidato/editar/'); ?>')"><i class="fa fa-plus"></i> <?php echo __("Adicionar Candidato") ?></button>&nbsp;
                        <button type="button" class="btn btn-blue" onclick="AbrirImportarCandidato()"><i class="fa fa fa-sign-in"></i> <?php echo __("Importar Candidato") ?></button>&nbsp;
                        <button type="button" class="btn btn-blue" onclick="ExportarCandidato('geral');"><i class="fa fa-sign-out"></i> <?php echo __("Exportar Candidato") ?></button>&nbsp;
                        <button type="button" class="btn btn-pink" onclick="ExportarCandidato('avaliação');"><i class="fa fa-sign-out"></i> <?php echo __("Exportar Avaliação de Candidato") ?></button>&nbsp;
                    </div>
                </form>
            </div>
        </div>
    </div>
	<div class="col-lg-12">
		<div class="portlet box">
			<div class="portlet-header">
				<div class="caption"><?php echo __("Lista de Candidatos") ?></div>
                <div id="dadostotais" class="tools" style="font-weight: bold;"></div>
			</div>
			<div class="portlet-body">
				<div class="row mbm">
					<div class="col-lg-12">
						<div class="table-responsive">
							<table id="candidato_tabela" class="table table-hover table-bordered table-advanced display">
								<thead>
								<tr>									
									<th style="width: 7%;"><?php echo __("ID"); ?></th>
									<th style="width: 13%;"><?php echo __("Nome"); ?></th>
									<th style="width: 10%;"><?php echo __("Email"); ?></th>
									<th style="width: 10%;"><?php echo __("Telefone"); ?></th>
									<th style="width: 10%;"><?php echo __("Cargo"); ?></th>
                                    <th style="width: 13%;"><?php echo __("Endereço"); ?></th>
                                    <th style="width: 14%;"><?php echo __("Vagas"); ?></th>
									<th style="width: 7%;"><?php echo __("Coletado em"); ?></th>
									<th style="width: 7%;"><?php echo __("Aplicado em"); ?></th>
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
    function confirmar(obj)
    {
        let url = $(obj).data('url');
        let msn = "<?php echo __("Tem certeza que deseja deletar definitivamente o candidato?<br /><b>Atenção: Ao confirmar não será possível desfazer essa ação.</b>"); ?>";
        let titulo = "<?php echo __("Confirme"); ?>";
        confirm(msn, titulo, function(confirmed) {
            if (confirmed)
            {
                window.location = url;
            }
        });
    }
    function ExportarCandidato(tipo = "", file = "", posicao = 0, total = 0)
    {
        let url = GetUrlAcao("candidato","exportarcandidato");
        let data = {
            "tipo":tipo,
            "file":file,
            "posicao": posicao,
            "total": total,
        };
        data = $.extend( {}, data, {"FILTRO": $("#frmcandidato").serializeArray()} );
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
                let msn = '<?php echo __("Exportação de Candidato"); ?>';
                $('#divBarra .progress .progress-bar').css('width',porcente+'%').html(texto);
                $('#divBarra').css('display','block');
                $('#divloding').css('display','block');
                $('#divBarra h5').html(msn);
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
                        ExportarCandidato(tipo, data.file, data.posicao, data.total);
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
                let msn = "<?php echo __("Falha na de verificação de candidato");?>";
                $('#divloding').slideUp("slow");
                $('#divBarra').slideUp("slow");
                alert(msn);
            }
        });
    }
    function FecharExportarCandidato()
    {
        $('#filecandidato').val("");
        $('#divExportar').slideUp("slow");
    }
    function FecharImportarCandidato()
    {
        $('#divImportar').slideUp("slow");
        document.getElementById('filecandidato').files = null;
        $('filecandidato').val('');
    }
    function AbrirImportarCandidato()
    {
        $('#divImportar').slideDown("slow");
    }
    function EnviarExcel(){
        let property = document.getElementById('filecandidato').files[0];
        if(Vazio(property))
        {
            alert("<?php echo __("Você deve selecionar o arquivo com os dados de importação de Candidatos");?>");
            return;
        }
        let file_name = property.name;
        let file_extension = file_name.split('.').pop().toLowerCase();
        let urlfile = GetUrlAcao("candidato","enviarexcel");
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
                    msn = "<?php echo __("Arquivo foi enviado com sucesso.<br/>Aguarde a finalização do processo de importação de Candidato.");?>";
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
        let url = GetUrlAcao("candidato","importacaoexcel");
        let idvaga = $("#vaga").val();
        let novo = $("#novo").val();
        let importarnovos = $("#importarnovos:checked").val();
        let data = {
            "file":file,
            "idvaga": idvaga,
            "novo":novo,
            "importarnovos":importarnovos,
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
                let msn = '<?php echo __("Importação de Candidato"); ?>';
                if(Vazio(aux))
                    aux = 1;
                porcente = Math.ceil((posicao/aux) * 100);
                $('#divBarra .progress .progress-bar').css('width',porcente+'%').html(texto);
                $('#divBarra').css('display','block');
                $('#divloding').css('display','block');
                $('#divBarra h5').html(msn);
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
                        FecharImportarCandidato();
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
    function MontarVagas(dados)
    {
        if(Vazio(dados))
            return '';
        var modelo = '<span class="badge badge-orange"  data-id="{idvaga}"> {titulodavaga} </span> ';
        var html = ObjetoReplace(dados, modelo);
        return html;
    }

    $(document).ready(function() {
        var el_datatable = $('#candidato_tabela').DataTable({
            "language":{ "url": CDN_Url('datatables') },
            "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": GetDominio('index.php/candidato/listatabela/'),
                "data": function ( d ) {
                    return $.extend( {}, d, {"FILTRO": $('#frmcandidato').serializeArray()} );
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
                {"data": "idcandidato", render: $.fn.dataTable.render.number(',', '.', '')},
				{'data': 'nome',
                    "render": function ( data, type, row, meta ) {
                        let link = row['nome'];
                        
                        if(!Vazio(row['sexo']))
                        {
                            link += " ("+row['sexo']+")";
                        }
                        return link;
                    }
                },
				{'data': 'email'},
				{'data': 'telefone'},            
				{'data': 'cargo'},
				{'data': 'endereco',
                    "render": function ( data, type, row, meta ) {
                        let link = '';

                        if(!Vazio(row['cidade']))
                            link = row['cidade'];
                        if(!Vazio(row['estado']))
                        {
                            if(!Vazio(link))
                                link += ", ";
                            link += row['estado'];
                        }
                        if(!Vazio(row['pais']))
                        {
                            if(!Vazio(link))
                                link += " - ";
                            link += row['pais'];
                        }
                        return link;
                    }
                },
				{'data': 'vagas',
                    "render": function ( data, type, row, meta ) {
                        var texto = '';
                        texto = MontarVagas(data);
                        return texto;
                    }
                },
				{'data': 'datacoleta'},
				{'data': 'dataaplicacao'},
                {"data": "idcandidato",
                    "render": function ( data, type, row, meta ) {
                        let url = "";
                        let link = '';

                        url = GetDominio('index.php/candidato/editar/'+data);
                        link += '<a href="'+url+'" class="btn-tab-editar" title="Editar candidato"><i class="fa fa-edit"></i></a>';
                        url = GetDominio('index.php/candidato/excluir/'+data);
                        link += '<a href="javascript:;" class="btn-tab-excluir" title="Excluir candidato" onclick="confirmar(this)" data-url="'+url+'"><i class="ion ion-android-trash"></i></a>';
                        aux = row['linkedin'];
                        if(!Vazio(aux))
                        {                           
                            url = 'https://' + aux.replaceAll('https://','').replaceAll('http://','');
                            link += `<a href="${url}" class="btn-tab-excluir" title="Ver link ${aux}" target="_blank" ><i class="fa fa-linkedin-square"></i></a>`;
                        }
                        aux = row['linkedin_desatualizado'];
                        if(!Vazio(aux))
                        {
                            if(aux == "Sim")
                                link += `<a href="#" class="btn-tab-excluir" title="Linkedin desatualizado"><i class="fa fa-external-link"></i></a>`;
                            else
                                link += `<a href="#" class="btn-tab-excluir" title="Linkedin atualizado"><i class="fa fa-check-circle"></i></a>`;
                        }
                        if(row['favorito'] == "Sim")
                        {
                            link += '<a href="#" class="btn-tab-editar" title="Marcado como favorito"><i class="fa fa-star"></i></a>';
                        }
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
            $('#candidato_tabela_filter').css('display','none');
        } );
        $("#idcargo").select2({
            placeholder: '<?php echo __("-- Selecione --"); ?>',
            minimumInputLength: 1,
            language: {
                inputTooShort: function () {
                    return "Você deve inserir mais caracteres ...";
                }
            },
            multiple: true,
            width: '100%',
            ajax: {
                url: GetUrlAcao("api","buscarfiltrosdecargos"),
                dataType: 'json',
                data: function (params) {
                    var query = {
                        search: params.term
                    }
                    return query;
                },
                processResults: function(data) {
                    return { results: data };
                }
            },
            escapeMarkup: function(markup) { return markup; },
            templateResult: function(row) {
                if (row.loading) {
                    return row.text;
                }
                //console.log(row);
                var markup = "<table class='movie-result'><tr>";
                markup += "<td class='movie-info'><div class='movie-title'>" + row.text + "</div>";
                markup += "</td></tr></table>";
                return markup;
            },/*
                templateSelection: function(repo) {console.log(repo);
                    return $(repo.text);
                }*/
        });
        $("#nomeempresa").select2({
            placeholder: '<?php echo __("-- Selecione --"); ?>',
            minimumInputLength: 0,
            language: {
                inputTooShort: function () {
                    return "Você deve inserir mais caracteres ...";
                }
            },
            multiple: false,
            width: '100%',
            ajax: {
                url: GetUrlAcao("api","buscarfiltrosdenomeempresas"),
                dataType: 'json',
                data: function (params) {
                    var query = {
                        search: params.term
                    }
                    return query;
                },
                processResults: function(data) {
                    data.unshift({id:' ', text:'-- Todas --'});
                    return { results: data };
                }
            },
            escapeMarkup: function(markup) { return markup; },
            templateResult: function(row) {
                if (row.loading) {
                    return row.text;
                }
                //console.log(row);
                var markup = "<table class='movie-result'><tr>";
                markup += "<td class='movie-info'><div class='movie-title'>" + row.text + "</div>";
                markup += "</td></tr></table>";
                return markup;
            },/*
                templateSelection: function(repo) {console.log(repo);
                    return $(repo.text);
                }*/
        });
        $("#idvaga").select2({
            placeholder: '<?php echo __("-- Selecione --"); ?>',
            minimumInputLength: 0,
            language: {
                inputTooShort: function () {
                    return "Você deve inserir mais caracteres ...";
                }
            },
            multiple: false,
            width: '100%',
            ajax: {
                url: GetUrlAcao("api","buscarfiltrosdevagas"),
                dataType: 'json',
                data: function (params) {
                    var query = {
                        search: params.term,
                        nomeempresa:$("#nomeempresa").val()
                    }
                    return query;
                },
                processResults: function(data) {
                    data.unshift({id:'0', text:'-- Todas --'});
                    return { results: data };
                }
            },
            escapeMarkup: function(markup) { return markup; },
            templateResult: function(row) {
                if (row.loading) {
                    return row.text;
                }
                //console.log(row);
                var markup = "<table class='movie-result'><tr>";
                markup += "<td class='movie-info'><div class='movie-title'>" + row.text + "</div>";
                markup += "</td></tr></table>";
                return markup;
            },/*
                templateSelection: function(repo) {console.log(repo);
                    return $(repo.text);
                }*/
        });
        $("#vaga").select2({
            placeholder: '<?php echo __("-- Selecione --"); ?>',
            minimumInputLength: 0,
            language: {
                inputTooShort: function () {
                    return "Você deve inserir mais caracteres ...";
                }
            },
            multiple: false,
            width: '100%',
            ajax: {
                url: GetUrlAcao("api","buscarfiltrosdevagas"),
                dataType: 'json',
                data: function (params) {
                    var query = {
                        search: params.term
                    }
                    return query;
                },
                processResults: function(data) {
                    return { results: data };
                }
            },
            escapeMarkup: function(markup) { return markup; },
            templateResult: function(row) {
                if (row.loading) {
                    return row.text;
                }
                //console.log(row);
                var markup = "<table class='movie-result'><tr>";
                markup += "<td class='movie-info'><div class='movie-title'>" + row.text + "</div>";
                markup += "</td></tr></table>";
                return markup;
            },/*
                templateSelection: function(repo) {console.log(repo);
                    return $(repo.text);
                }*/
        });
        $("#frmcandidato #sexo").prepend("<option value=\"-1\">Indefinido</option>");        
        $("#frmcandidato #sexo").prepend("<option value=\"\">-- Todos --</option>");

        $("#frmcandidato #linkedin_desatualizado").prepend("<option value=\"-1\">Indefinido</option>");
        $("#frmcandidato #linkedin_desatualizado").prepend("<option value=\"\">-- Todos --</option>");
        
        $("#frmcandidato #favorito123").prepend("<option value=\"-1\">Candidatos não avaliados</option>");
        $("#frmcandidato #favorito123").prepend("<option value=\"\">-- Todos --</option>");

        $("#frmcandidato #idabordagem").prepend("<option value=\"-1\">Candidatos não abordados</option>");
        $("#frmcandidato #idabordagem").prepend("<option value=\"\">-- Todos --</option>");

        $("#frmcandidato #sexo").val("");
        $("#frmcandidato #linkedin_desatualizado").val("");
        $("#frmcandidato #favorito123").val("");
        $("#frmcandidato #idabordagem").val("");
        formatData('#datacoletainicio', pais);
        formatData('#datacoletafim', pais);
    });
</script>