    <div id="sum_box" class="row mbl">
        <div id="filtrocandidato" class="col-lg-12">
            <div class="portlet box prolet-primary">
                <div class="portlet-header">
                    <div class="caption ">
                        <i style="font-size: 17px; margin-top: 2px;" class="fa fa-comments"></i>
                        <?php echo __("Relatório de gestão produção vagas");?>
                    </div>
                    <div class="tools">
                        <i class="fa fa-chevron-up"></i>
                        <i class="fa fa-times"></i>
                    </div>
                </div>
                <div class="portlet-body">
                    <form id="frmvaga" action="<?php echo site_url(''); ?>" method="POST" class="form-horizontal">
                    <div class="form-body pal">
                        <div class="form-group">
                            <label for="idvaga" class="col-md-1 control-label"><?php echo __("Vaga"); ?></label>
                            <div class="col-md-8">
                                <select id="idvaga" name="idvaga" class="form-control">
                                </select>
                            </div>
                            <div class="col-md-2">
                                <button id="btn-pesquisa" type="button" class="btn btn-primary" onclick="Pesquisar();">
                                    <i class="fa fa-search"></i> <?php echo __("Pesquisa"); ?>
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
                </div>
            </div>
        </div>        
        <div class="col-lg-4">
            <div class="portlet box">
                <div class="portlet-header">
                    <div class="caption">
                        <i id="iCandidatos" style="font-size: 17px; margin-top: 2px;" class="fa fa-users"></i>
                        <?php echo __("Candidatos Marcados") ?>
                    </div>
                    <div class="tools">
                        <a class="bnt-excel" href="javascript:;" onclick="ExportarCandidatosMarcados(this)" ><i class="fa fa-file-excel-o"></i></a>
                        <i class="fa fa-chevron-up"></i>
                    </div>
                </div>
                <div class="portlet-body">
                    <div class="row mbm">
                        <div class="col-lg-12">
                            <div class="table-responsive">
                                <table id="Candidatos_tabela" class="table table-hover table-bordered table-advanced display dashbordGrupo">
                                    <thead>
                                    <tr>
                                        <th style="width: 15%;"></th>
                                        <th style="width: 23%;"><?php echo __("Candidatos com telefone"); ?></th>
                                        <th style="width: 32%;"><?php echo __("Candidatos só com e-mail e sem telefone") ?></th>
                                        <th style="width: 23%;"><?php echo __("Candidato com ID habu") ?></th>
                                        <th style="width: 8%;"><?php echo __("Total") ?></th>
                                    </tr>
                                    <tbody>
                                        <tr id="favorito">
                                            <td>Favoritos</td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                       <!-- <tr id="desconsiderado">
                                            <td>Desconsiderado</td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>-->
                                        <tr id="toptalent">
                                            <td>Top talent</td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                        <tr id="vazio">
                                            <td>&nbsp;</td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        <tr id="total">
                                            <td>Total</td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                    </tbody>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="portlet box">
                <div class="portlet-header">
                    <div class="caption">
                        <i id="iAvaliadosGeral" style="font-size: 17px; margin-top: 2px;" class="el el-check"></i>
                        <?php echo __("Candidatos Avaliados (Geral)") ?>
                    </div>
                    <div class="tools">
                        <a class="bnt-excel" href="javascript:;" onclick="ExportarCandidatosAvaliados(this)" data-tipo="" ><i class="fa fa-file-excel-o"></i></a>
                        <i class="fa fa-chevron-up"></i>
                    </div>
                </div>
                <div class="portlet-body">
                    <div class="row mbm">
                        <div class="col-lg-12">
                            <div class="table-responsive">
                                <table id="AvaliadosGeral_tabela" class="table table-hover table-bordered table-advanced display dashbordGrupo">
                                    <thead>
                                    <tr>
                                        <th style="width: 40%;"></th>
                                        <th style="width: 25%;"><?php echo __("Avaliados"); ?></th>
                                        <th style="width: 25%;"><?php echo __("Sem avaliação") ?></th>
                                        <th style="width: 10%;"><?php echo __("Total") ?></th>
                                    </tr>
                                    <tbody>
                                        <tr class="comtelefone">
                                            <td>Candidatos com telefone</td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                        <tr class="comemail">
                                            <td>Candidatos só com e-mail e sem telefone</td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                        <tr class="habu">
                                            <td>Candidato com ID habu</td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                        <tr class="totalAvaliados">
                                            <td>Total</td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                    </tbody>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="portlet box">
                <div class="portlet-header">
                    <div class="caption">
                        <i id="iAvaliadosFavoritos" style="font-size: 17px; margin-top: 2px;" class="el el-check"></i>
                        <?php echo __("Candidatos Avaliados (Favoritos)") ?>
                    </div>
                    <div class="tools">
                        <a class="bnt-excel" href="javascript:;" onclick="ExportarCandidatosAvaliados(this)" data-tipo="favoritos" ><i class="fa fa-file-excel-o"></i></a>
                        <i class="fa fa-chevron-up"></i>
                    </div>
                </div>
                <div class="portlet-body">
                    <div class="row mbm">
                        <div class="col-lg-12">
                            <div class="table-responsive">
                                <table id="AvaliadosFavoritos_tabela" class="table table-hover table-bordered table-advanced display dashbordGrupo">
                                    <thead>
                                    <tr>
                                        <th style="width: 40%;"></th>
                                        <th style="width: 25%;"><?php echo __("Avaliados"); ?></th>
                                        <th style="width: 25%;"><?php echo __("Sem avaliação") ?></th>
                                        <th style="width: 10%;"><?php echo __("Total") ?></th>
                                    </tr>
                                    <tbody>
                                        <tr class="comtelefone">
                                            <td>Candidatos com telefone</td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                        <tr class="comemail">
                                            <td>Candidatos só com e-mail e sem telefone</td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                        <tr class="habu">
                                            <td>Candidato com ID habu</td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                        <tr class="totalAvaliados">
                                            <td>Total</td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                    </tbody>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="portlet box">
                <div class="portlet-header">
                    <div class="caption">
                        <i id="iAvaliadosTopTalent" style="font-size: 17px; margin-top: 2px;" class="el el-check"></i>
                        <?php echo __("Candidatos Avaliados (Top Talent)") ?>
                    </div>
                    <div class="tools">
                        <a class="bnt-excel" href="javascript:;" onclick="ExportarCandidatosAvaliados(this)" data-tipo="toptalent" ><i class="fa fa-file-excel-o"></i></a>
                        <i class="fa fa-chevron-up"></i>
                    </div>
                </div>
                <div class="portlet-body">
                    <div class="row mbm">
                        <div class="col-lg-12">
                            <div class="table-responsive">
                                <table id="AvaliadosTopTalent_tabela" class="table table-hover table-bordered table-advanced display dashbordGrupo">
                                    <thead>
                                    <tr>
                                        <th style="width: 40%;"></th>
                                        <th style="width: 25%;"><?php echo __("Avaliados"); ?></th>
                                        <th style="width: 25%;"><?php echo __("Sem avaliação") ?></th>
                                        <th style="width: 10%;"><?php echo __("Total") ?></th>
                                    </tr>
                                    <tbody>
                                        <tr class="comtelefone">
                                            <td>Candidatos com telefone</td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                        <tr class="comemail">
                                            <td>Candidatos só com e-mail e sem telefone</td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                        <tr class="habu">
                                            <td>Candidato com ID habu</td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                        <tr class="totalAvaliados">
                                            <td>Total</td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                    </tbody>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="portlet box">
                <div class="portlet-header">
                    <div class="caption">
                        <i id="iCandidatosIdioma" style="font-size: 17px; margin-top: 2px;" class="el el-check"></i>
                        <?php echo __("Candidatos com Idiomas avaliados") ?>
                    </div>
                    <div class="tools">
                        <a class="bnt-excel" href="javascript:;" onclick="ExportarCandidatosIdiomas(this)" data-tipo="toptalent" ><i class="fa fa-file-excel-o"></i></a>
                        <i class="fa fa-chevron-up"></i>
                    </div>
                </div>
                <div class="portlet-body">
                    <div class="row mbm">
                        <div class="col-lg-12">
                            <div class="table-responsive">
                                <table id="CandidatosIdioma_tabela" class="table table-hover table-bordered table-advanced display dashbordGrupo">
                                    <thead>
                                    <tr>
                                        <th style="width: 80%;"></th>
                                        <th style="width: 20%;"><?php echo __("Total de candidatos") ?></th>
                                    </tr>
                                    <tbody>
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
                    <div class="caption">
                        <i id="icomtelefone" style="font-size: 17px; margin-top: 2px;" class="el el-phone-alt"></i>
                        <?php echo __("Candidatos com telefone (sem avaliação)") ?>
                    </div>
                    <div class="tools">
                        <a class="bnt-excel" href="javascript:;" onclick="ExportarCandidatosContatos(this, 'comtelefone')" ><i class="fa fa-file-excel-o"></i></a>
                        <i class="fa fa-chevron-up"></i>
                    </div>
                    <div id="dadoscomtelefone"></div>
                    <div id="Avaliadoscomtelefone"></div>
                </div>
                <div class="portlet-body">
                    <div class="row mbm">
                        <div class="col-lg-12">
                            <div class="table-responsive">
                                <table id="comtelefone_tabela" class="table table-hover table-bordered table-advanced display dashbord">
                                    <thead>
                                    <tr>
                                        <th style="width: 20%;"><?php echo __("Nome"); ?></th>
                                        <th style="width: 15%;"><?php echo __("Email"); ?></th>
                                        <th style="width: 13%;"><?php echo __("telefone") ?></th>
                                        <th style="width: 11%;"><?php echo __("Mandei whatsapp") ?></th>
                                        <th style="width: 11%;"><?php echo __("Mandei e-mail") ?></th>
                                        <th style="width: 18%;"><?php echo __("Tentativa de contato por telefone") ?></th>
                                        <th style="width: 12%;"><?php echo __("Conectei pelo linkedin") ?></th>
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
                    <div class="caption">
                        <i id="icomemail" style="font-size: 17px; margin-top: 2px;" class="fa fa-envelope-o"></i>
                        <?php echo __("Candidatos só com e-mail e sem telefone (sem avaliação)") ?>
                    </div>
                    <div class="tools">
                        <a class="bnt-excel" href="javascript:;" onclick="ExportarCandidatosContatos(this, 'comemail')" ><i class="fa fa-file-excel-o"></i></a>
                        <i class="fa fa-chevron-up"></i>
                    </div>
                    <div id="dadoscomemail"></div>
                    <div id="Avaliadoscomemail"></div>
                </div>
                <div class="portlet-body">
                    <div class="row mbm">
                        <div class="col-lg-12">
                            <div class="table-responsive">
                                <table id="comemail_tabela" class="table table-hover table-bordered table-advanced display dashbord">
                                    <thead>
                                    <tr>
                                        <th style="width: 20%;"><?php echo __("Nome"); ?></th>
                                        <th style="width: 15%;"><?php echo __("Email"); ?></th>
                                        <th style="width: 13%;"><?php echo __("telefone") ?></th>
                                        <th style="width: 11%;"><?php echo __("Mandei whatsapp") ?></th>
                                        <th style="width: 11%;"><?php echo __("Mandei e-mail") ?></th>
                                        <th style="width: 18%;"><?php echo __("Tentativa de contato por telefone") ?></th>
                                        <th style="width: 12%;"><?php echo __("Conectei pelo linkedin") ?></th>
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
    <script type="application/javascript">
    var listaAvaliacao = [
        {"filtro":"","nome":"Geral"},
        {"filtro":"favoritos","nome":"Favoritos"},
        {"filtro":"toptalent","nome":"TopTalent"}
    ];
    function Pesquisar()
    {
        let idvaga =  $('#idvaga').val();
        if(Vazio(idvaga))
        {
            $( "#sum_box > div" ).each(function( index ) {
                if($(this).get(0).id != "filtrocandidato")
                    $(this).fadeOut("slow");
            });
            return;
        }
        else
        {
            $( "#sum_box > div" ).each(function( index ) {
                if($(this).get(0).id != "filtrocandidato")
                    $(this).fadeIn("slow");
            }); 
        }

        CandidatosMarcados();
        CandidatosAvaliados(0);
        CriarComTelefone();
        CriarComEmail();
        CriarComIdiomas();
    }
    function PreencheLinha(lista = false, nome = "")
    {
        let indice = 0;
        let total = 0;
        if(Vazio(lista))
        {
            for( let i = 0; i < 3; i++)
            {
                indice = i + 2;
                $(`${nome} td:nth-of-type(${indice})`).html(0);
            }
            indice++;
            $(`${nome} td:nth-of-type(${indice})`).html(0);
        }
        else
        {
            for( let i = 0; i < lista.length; i++)
            {
                indice = i + 2;
                $(`${nome} td:nth-of-type(${indice})`).html(lista[i]);
                total += lista[i];
            }
            indice++;
            $(`${nome} td:nth-of-type(${indice})`).html(total);
        }
    }
    function CandidatosMarcados()
    {
        var url = GetUrlAcao("api","candidatosmarcados");
        var data = {
            "idvaga":$("#idvaga").val()
        };
        $.ajax({
            url: url,
            method:'POST',
            data:data,
            beforeSend:function(xhr){
                $('#iCandidatos').removeClass("fa fa-users").addClass('ion ion-loading-a');
            },
            success:function(data){
                if(data.sucesso)
                {
                    /*titulo = data.titulo;
                    msn = data.mensagem;
                    MsnSucesso(titulo, msn);*/
                    PreencheLinha(data.lista.favorito, "#favorito");
                    PreencheLinha(data.lista.desconsiderado, "#desconsiderado");
                    PreencheLinha(data.lista.toptalent, "#toptalent");
                    PreencheLinha(data.lista.total, "#total");
                    $('#iCandidatos').removeClass('ion ion-loading-a').addClass("fa fa-users");
                }
                else
                {
                    titulo = "Erro";
                    msn = data.erro;
                    MsnDanger(titulo, msn);
                    $('#iCandidatos').removeClass('ion ion-loading-a').addClass("fa fa-users");
                }
            },
            error: function(XHR, textStatus, errorThrown){                
                $('#iCandidatos').removeClass('ion ion-loading-a').addClass("fa fa-users");
                msn = "<?php echo __("Falha ao ler os dados dos candidatos marcados");?>";
                alert(msn);
            }
        });
    }
    function CandidatosAvaliados(index = 0)
    {
        var url = GetUrlAcao("api","candidatosavaliados");
        var data = {};
        var obj = listaAvaliacao[index];
        if(Vazio(obj))
            return;
        data = {
            "idvaga": $("#idvaga").val(),
            "tipo": obj.filtro
        };
        $.ajax({
            url: url,
            method:'POST',
            data:data,
            beforeSend:function(xhr){
                $(`#iAvaliados${obj.nome}`).removeClass("el el-check").addClass('ion ion-loading-a');
            },
            success:function(data){
                if(data.sucesso)
                {
                    /*titulo = data.titulo;
                    msn = data.mensagem;
                    MsnSucesso(titulo, msn);*/
                    PreencheLinha(data.lista.comemail, `#Avaliados${obj.nome}_tabela .comemail`);
                    PreencheLinha(data.lista.comtelefone, `#Avaliados${obj.nome}_tabela .comtelefone`);
                    PreencheLinha(data.lista.habu, `#Avaliados${obj.nome}_tabela .habu`);
                    PreencheLinha(data.lista.total, `#Avaliados${obj.nome}_tabela .totalAvaliados`);
                    $(`#iAvaliados${obj.nome}`).removeClass('ion ion-loading-a').addClass("el el-check");
                    index++;
                    CandidatosAvaliados(index);
                }
                else
                {
                    titulo = "Erro";
                    msn = data.erro;
                    MsnDanger(titulo, msn);
                    $(`#iAvaliados${obj.nome}`).removeClass('ion ion-loading-a').addClass("el el-check");
                }
            },
            error: function(XHR, textStatus, errorThrown){                
                $(`#iAvaliados${obj.nome}`).removeClass('ion ion-loading-a').addClass("el el-check");
                msn = "<?php echo __("Falha ao ler os dados dos candidatos marcados");?>";
                alert(msn);
            }
        });
    }
    function CriarComTelefone()
    {
        if(!Vazio(el_datatable))
       {
            el_datatable.ajax.reload();
            return;    
       }
       
       if($.fn.dataTable.isDataTable('#comtelefone_tabela'))
        {
            el_datatable = $('#comtelefone_tabela').DataTable();
            el_datatable.ajax.reload();
        }
        else
        {
            var el_datatable = $('#comtelefone_tabela').DataTable({
                "language":{ "url": CDN_Url('datatables') },
                "lengthMenu": [[25, 50, 100, 200, -1], [25, 50, 100, 200, "All"]],
                "processing": true,
                "serverSide": true,
                "ajax": {
                    "url": GetDominio('index.php/api/listatabela/'),
                    "data": function ( d ) {
                        return $.extend( {}, d, {"idvaga": $('#idvaga').val(), "tipo":"comtelefone"} );
                    },
                    "type": 'post',
                    "dataType": 'json',
                    "dataFilter": function(data){
                        var json = jQuery.parseJSON( data );
                        var texto = json.recordsFiltered+"/"+json.recordsTotal;
                        var total = json.recordsTotal - json.recordsFiltered;
                        $("#dadoscomtelefone").html(texto);
                        texto = `Sem ação realizada: <b>${total}</b>`;
                        $("#Avaliadoscomtelefone").html(texto);
                        return JSON.stringify( json );
                    }
                },
                columns: [
                    {"data": "nome"},            
                    {'data': 'email'},
                    {"data": "telefone"},
                    {"data": "mandei_whatsapp",
                        "render": function ( data, type, row, meta ) {
                            var link = '';
                            if(!Vazio(data))
                                link = '<i class="fa fa-check"></i>';
                            return link;
                        }
                    },
                    {"data": "mandei_email",
                        "render": function ( data, type, row, meta ) {
                            var link = '';
                            if(!Vazio(data))
                                link = '<i class="fa fa-check"></i>';
                            return link;
                        }
                    },{"data": "tentativa_de_contato_por_telefone",
                        "render": function ( data, type, row, meta ) {
                            var link = '';
                            if(!Vazio(data))
                                link = '<i class="fa fa-check"></i>';
                            return link;
                        }
                    },
                    {"data": "conectei_pelo_linkedin",
                        "render": function ( data, type, row, meta ) {
                            var link = '';
                            if(!Vazio(data))
                                link = '<i class="fa fa-check"></i>';
                            return link;
                        }
                    },
                ],
            });
        }
        el_datatable.on( 'draw', function () {
            $('#comtelefone_tabela_filter').css('display','none');
        });
    }
    function CriarComEmail()
    {
        if(!Vazio(el_datatable_comemail))
        {
            el_datatable_comemail.ajax.reload();
            return; 
        }
        
        if($.fn.dataTable.isDataTable('#comemail_tabela'))
        {
            el_datatable_comemail = $('#comemail_tabela').DataTable();
            el_datatable_comemail.ajax.reload();
        }
        else
        {
            var el_datatable_comemail = $('#comemail_tabela').DataTable({
                "language":{ "url": CDN_Url('datatables') },
                "lengthMenu": [[25, 50, 100, 200, -1], [25, 50, 100, 200, "All"]],
                "processing": true,
                "serverSide": true,
                "ajax": {
                    "url": GetDominio('index.php/api/listatabela/'),
                    "data": function ( d ) {
                        return $.extend( {}, d, {"idvaga": $('#idvaga').val(), "tipo":"comemail"} );
                    },
                    "type": 'post',
                    "dataType": 'json',
                    "dataFilter": function(data){
                        var json = jQuery.parseJSON( data );
                        var texto = json.recordsFiltered+"/"+json.recordsTotal;                        
                        var total = json.recordsTotal - json.recordsFiltered;
                        $("#dadoscomemail").html(texto);
                        texto = `Sem ação realizada: <b>${total}</b>`;
                        $("#Avaliadoscomemail").html(texto);
                        return JSON.stringify( json );
                    }
                },
                columns: [
                    {"data": "nome"},            
                    {'data': 'email'},
                    {"data": "telefone"},
                    {"data": "mandei_whatsapp",
                        "render": function ( data, type, row, meta ) {
                            var link = '';
                            if(!Vazio(data))
                                link = '<i class="fa fa-check"></i>';
                            return link;
                        }
                    },
                    {"data": "mandei_email",
                        "render": function ( data, type, row, meta ) {
                            var link = '';
                            if(!Vazio(data))
                                link = '<i class="fa fa-check"></i>';
                            return link;
                        }
                    },{"data": "tentativa_de_contato_por_telefone",
                        "render": function ( data, type, row, meta ) {
                            var link = '';
                            if(!Vazio(data))
                                link = '<i class="fa fa-check"></i>';
                            return link;
                        }
                    },
                    {"data": "conectei_pelo_linkedin",
                        "render": function ( data, type, row, meta ) {
                            var link = '';
                            if(!Vazio(data))
                                link = '<i class="fa fa-check"></i>';
                            return link;
                        }
                    },
                ],
            });
        }
        el_datatable_comemail.on( 'draw', function () {
            $('#comemail_tabela_filter').css('display','none');
        });
    
    
    }
    function CriarComIdiomas()
    {
        var url = GetUrlAcao("api","lercandidatoscomidiomas");
        var data = {
            "idvaga":$("#idvaga").val()
        };
        $.ajax({
            url: url,
            method:'POST',
            data:data,
            beforeSend:function(xhr){
                $('#iCandidatosIdioma').removeClass("fa fa-comments-o").addClass('ion ion-loading-a');
            },
            success:function(data){
                if(data.sucesso)
                {
                    /*titulo = data.titulo;
                    msn = data.mensagem;
                    MsnSucesso(titulo, msn);*/
                    MontarIdiomas(data.lista);
                    $('#iCandidatosIdioma').removeClass('ion ion-loading-a').addClass("fa fa-comments-o");
                }
                else
                {
                    titulo = "Erro";
                    msn = data.erro;
                    MsnDanger(titulo, msn);
                    $('#iCandidatosIdioma').removeClass('ion ion-loading-a').addClass("fa fa-comments-o");
                }
            },
            error: function(XHR, textStatus, errorThrown){                
                $('#iCandidatosIdioma').removeClass('ion ion-loading-a').addClass("fa fa-comments-o");
                msn = "<?php echo __("Falha ao ler os dados dos candidatos com idiomas");?>";
                alert(msn);
            }
        });
    }   
    function MontarIdiomas(lista = null)
    {
        let html = '';
        if(Vazio(lista))
        {
            html = ``; 
        }
        else
        {
            lista.forEach(item => {
                let total = FormatarNumero(item.total);
                html += `
                <tr class="divIdiomas">
                    <td>${item.idioma}</td>
                    <td>${total}</td>
                </tr>`;
            });
        }
        $('#CandidatosIdioma_tabela tbody').html(html);
    }
    function ExportarCandidatosContatos(obj = null, tipo = 'comemail')
    {
        var url = GetUrlAcao("api","exportarcandidatoscontatos");
        var data = {"idvaga": $('#idvaga').val(), "tipo":tipo};
        $.ajax({
            url: url,
            method:'POST',
            data:data,
            beforeSend:function(xhr){
                $(obj).find("i").removeClass("fa fa-file-excel-o").addClass('ion ion-loading-a');
            },
            success:function(data){
                if(data.sucesso)
                {
                    titulo = data.titulo;
                    msn = data.mensagem;
                    MsnSucesso(titulo, msn);
                    $(obj).find("i").removeClass('ion ion-loading-a').addClass("fa fa-file-excel-o");
                    window.open(data.url, "_blank");
                }
                else
                {
                    msn = data.erro;
                    alert(msn);
                    $(obj).find("i").removeClass('ion ion-loading-a').addClass("fa fa-file-excel-o");
                }
            },
            error: function(XHR, textStatus, errorThrown){
                $(obj).find("i").removeClass('ion ion-loading-a').addClass("fa fa-file-excel-o");
                msn = "<?php echo __("Falha na de verificação de setor");?>";
                alert(msn);
            }
        });
    }    
    function ExportarCandidatosMarcados(obj = null)
    {
        var url = GetUrlAcao("api","exportarcandidatosmarcados");
        var data = {"idvaga": $('#idvaga').val()};
        $.ajax({
            url: url,
            method:'POST',
            data:data,
            beforeSend:function(xhr){
                $(obj).find("i").removeClass("fa fa-file-excel-o").addClass('ion ion-loading-a');
            },
            success:function(data){
                if(data.sucesso)
                {
                    titulo = data.titulo;
                    msn = data.mensagem;
                    MsnSucesso(titulo, msn);
                    $(obj).find("i").removeClass('ion ion-loading-a').addClass("fa fa-file-excel-o");
                    window.open(data.url, "_blank");
                }
                else
                {
                    msn = data.erro;
                    alert(msn);
                    $(obj).find("i").removeClass('ion ion-loading-a').addClass("fa fa-file-excel-o");
                }
            },
            error: function(XHR, textStatus, errorThrown){
                $(obj).find("i").removeClass('ion ion-loading-a').addClass("fa fa-file-excel-o");
                msn = "<?php echo __("Falha na de verificação de setor");?>";
                alert(msn);
            }
        });
    }
    function ExportarCandidatosAvaliados(obj = null)
    {
        var url = GetUrlAcao("api","exportarcandidatosavaliados");
        var data = {};
        var tipo = $(obj).data("tipo");
        data = {"idvaga": $('#idvaga').val(), "tipo": tipo};
        $.ajax({
            url: url,
            method:'POST',
            data:data,
            beforeSend:function(xhr){
                $(obj).find("i").removeClass("fa fa-file-excel-o").addClass('ion ion-loading-a');
            },
            success:function(data){
                if(data.sucesso)
                {
                    titulo = data.titulo;
                    msn = data.mensagem;
                    MsnSucesso(titulo, msn);
                    $(obj).find("i").removeClass('ion ion-loading-a').addClass("fa fa-file-excel-o");
                    window.open(data.url, "_blank");
                }
                else
                {
                    msn = data.erro;
                    alert(msn);
                    $(obj).find("i").removeClass('ion ion-loading-a').addClass("fa fa-file-excel-o");
                }
            },
            error: function(XHR, textStatus, errorThrown){
                $(obj).find("i").removeClass('ion ion-loading-a').addClass("fa fa-file-excel-o");
                msn = "<?php echo __("Falha na de verificação de setor");?>";
                alert(msn);
            }
        });
    }
    function ExportarCandidatosIdiomas(obj = null)
    {
        var url = GetUrlAcao("api","exportarcandidatosidiomas");
        var data = {};
        data = {"idvaga": $('#idvaga').val()};
        $.ajax({
            url: url,
            method:'POST',
            data:data,
            beforeSend:function(xhr){
                $(obj).find("i").removeClass("fa fa-file-excel-o").addClass('ion ion-loading-a');
            },
            success:function(data){
                if(data.sucesso)
                {
                    titulo = data.titulo;
                    msn = data.mensagem;
                    MsnSucesso(titulo, msn);
                    $(obj).find("i").removeClass('ion ion-loading-a').addClass("fa fa-file-excel-o");
                    window.open(data.url, "_blank");
                }
                else
                {
                    msn = data.erro;
                    alert(msn);
                    $(obj).find("i").removeClass('ion ion-loading-a').addClass("fa fa-file-excel-o");
                }
            },
            error: function(XHR, textStatus, errorThrown){
                $(obj).find("i").removeClass('ion ion-loading-a').addClass("fa fa-file-excel-o");
                msn = "<?php echo __("Falha na exportação de idiomas");?>";
                alert(msn);
            }
        });
    }
    $(function () {        
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
                        nomeempresa:""
                    }
                    return query;
                },
                processResults: function(data) {
                    data.unshift({id:'-1', text:'-- Todas --'});
                    return { results: data };
                }
            },
            escapeMarkup: function(markup) { return markup; },
            templateResult: function(row) {
                if (row.loading) {
                    return row.text;
                }

                var markup = "<table class='movie-result'><tr>";
                markup += "<td class='movie-info'><div class='movie-title'>" + row.text + "</div>";
                markup += "</td></tr></table>";
                return markup;
            },/*
            templateSelection: function(repo) {
                return $(repo.text);
            }*/
        });
        Pesquisar();
    });
    </script>