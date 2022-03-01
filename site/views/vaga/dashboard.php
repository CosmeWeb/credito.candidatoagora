<div id="container">
    <div id="dashboard" class="corpoconteudo">
        
        <div class="headerFilter">   
            <div class="asiderTitle">
                <h2 data-identifier='counter'></h2>
            </div>
            <div style="text-align: end;width: 86%;" id='header-filter-content'>
                <a href="#" data-toggle="modal" data-target="#Acharcandidatos" class="btn buttonNovaVaga"><span>Criar uma nova vaga</span><i class="fas fa-plus"></i></a>
                <input type="text" autocomplete="off" placeholder="Buscar por Nome ou Palavra-chave" name="search" id='search'>
                <button type="button" class=" btn buttonSearch"><i class="fas fa-search"></i></button>
                <select type="text" autocomplete="off" class="classic safari_only classificacao" style='margin-right: 1.4em'>
                    <option value="" selected>Classificações</option>
                </select>
                <!--<select type="text" autocomplete="off" class="classic safari_only status">
                    <option value="" selected>Status: Todos</option>
                </select>-->
            </div>
        </div>
        <main class="listaVaga" data-state="Good" data-splitting="grid">
        </main>
    </div>
</div>

<div id="OcultarPreload" style="display: none;">
<!--
    <div class="cardsVagas dummy preload" name="process">
    </div>
-->
</div>
<div id="Acharcandidatos" class="modal fade" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Criar uma nova vaga</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>Para permitir criar nova vaga adquira planos de assinatura do Candidato Agora</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">Fechar</button>
      </div>
    </div>
  </div>
</div>
<script>

$(function(){
    Dashboard.setup();
    bloqueio_ctrl_C = false;
    SetabloquearCopia();
});
function AbrirURL(obj)
{
    let url = $(obj).data("url");
    if(Vazio(url))
        return;
    window.open(url, "_blank");
    return false;
}
var Dashboard = {
    inRequest: false,
    setup: function() {
        var url = window.location.href;
        url = url.split('/index.php')[0] + '/painel/index.php/';
        const url_lista_vagas = url + 'api/lerlistavagas/';
        let limit = Dashboard.Listar.GetColuna() * 3;
        let start = 0;
        let total = 0;
        const url_list_status = url + 'api/leropcaoativovagas';
        const url_list_classificacoes = url + 'api/leropcaoclassificacaovagas';

        $.ajax({
            url: url_lista_vagas,
            type: 'post',
            data: {idcliente: Dashboard.Listar.idCliente, posicao: 0, limite: limit},
            dataType: 'json',
            contentType: 'application/x-www-form-urlencoded',
            success: function (data) {            
                if(!Vazio(data.sucesso)) {
                    $("[data-identifier=counter]").text(data.total + ' Vagas');
                    setTimeout(function(){
                        Dashboard.Listar.Unpreload();
                        Dashboard.Listar.PopularCards(data.lista);
                    }, 1000);                    
                }
            }
        }).done(function(data) {
            total = data.total;
            console.log(total);

            $(".buttonSearch").on("click", function(){
                $(".listaVaga .cardsOn").remove();
                start = 0
                Dashboard.Listar.Filtrar(url_lista_vagas, start);
            });

            $(".classificacao").on("change", function(){
                $(".listaVaga .cardsOn").remove();
                start = 0

                Dashboard.Listar.Filtrar(url_lista_vagas, start);
            });

            /*$(".status").on("change", function(){
                $(".listaVaga .cardsOn").remove();
                start = 0
                Dashboard.Listar.Filtrar(url_lista_vagas, start);
            });


            $.ajax({
                url: url_list_status,
                type: 'post',
                dataType: 'json',
                contentType: 'application/x-www-form-urlencoded',
                success: function (data) {
            },
            }).done(function(data) {
                for (let i = 0; i < data.opcoes.length; i++) {
                    $(".status").append("<option value='"+data.opcoes[i].valor+"'>"+data.opcoes[i].texto+"</option>");
                }
            });*/

            $.ajax({
                url: url_list_classificacoes,
                type: 'post',
                dataType: 'json',
                contentType: 'application/x-www-form-urlencoded',
                success: function (data) {
            },
            }).done(function(data) {
                for (let i = 0; i < data.opcoes.length; i++) {
                    $(".classificacao").append("<option value='"+data.opcoes[i].valor+"'>"+data.opcoes[i].texto+"</option>");
                }
            });

            $(window).scroll(function() {
                if($(window).scrollTop() + $(window).height() == $(document).height()) {
                    if(!Dashboard.inRequest) {
                        start = start + limit;
                        Dashboard.inRequest = true;
                        console.log(start, total)
                        if(start <= total) {
                            Dashboard.Listar.Filtrar(url_lista_vagas,start);
                        }else{
                            return false;
                        }
                    }
                }
            });
        }).fail(function( jqXHR, textStatus ) {
            console.log( jqXHR, textStatus );
            Dashboard.Listar.SemVagas(jqXHR.responseJSON.erro);
            Dashboard.inRequest = false;
            $(".preload").fadeOut(500);          
        });
    },
  Listar: {
    setup: function(url, url_lista_vagas,  limit, start) {
        Dashboard.Listar.ListarDados(url_lista_vagas, limit, start)
    },
    idCliente : '<?php print $idCliente; ?>',
    ListarDados: function(url_lista_vagas, limit, start, filter) {
        if(!filter) {
            filter = '';
        }
        $.ajax({
            url: url_lista_vagas+filter,
            type: 'post',
            data: {idcliente: this.idCliente, posicao: start, limite: limit},
            dataType: 'json',
            contentType: 'application/x-www-form-urlencoded',
            beforeSend:function(xhr){
                Dashboard.Listar.Preload();
            },
            success: function (data) {
                if(!Vazio(data.sucesso)) {
                    $("[data-identifier=counter]").text(data.total + ' Vagas');
                    setTimeout(function(){
                        Dashboard.Listar.Unpreload();
                        Dashboard.Listar.PopularCards(data.lista)
                        Dashboard.inRequest = false;
                    }, 1000);                    
                }
           }
        }).done(function(data) {   
        }).fail(function( jqXHR, textStatus ) {
            $(".preload").fadeOut(500);
            Dashboard.inRequest = false;
        });
    },
    PopularCards: function(tableDatas) {
        let linkDetalhes = GetDominio("index.php/vaga/dadosdavagaresumo/");
        let linkCandidatos = GetDominio("index.php/candidato/candidatos/");
        let auxDetalhes = '';
        let auxCandidatos = '';
        let divCards = '';
        Dashboard.Listar.LimparErroVagas();
        for (var i = 0; i < tableDatas.length; i++) {
            var Recomendados
            tData = tableDatas [i];
            classe = '';
            classePoint = '';
            classePontos = ' points-disable';
            if(tData.status == 'Cadastro incompleto da vaga') {
                classe = 'cadastro-incompleto';
            }else if(tData.status == 'Aguardando análise') {
                classe = 'aguardando-analise';
            }else if(tData.status == 'Candidatos disponíveis' ){
                classe = 'candidatos-disponiveis';
            }else if((tData.status == 'Concluido')||(tData.status == 'Concluído')) {
                classe = 'concluido';
            }else if(tData.status == 'Cancelado pelo cliente') {
                classe = 'cancelado-pelo-cliente';
            }
            localizar = "";
            if((!Vazio(tData.cidade))&&(!Vazio(tData.uf)))
                localizar = `${tData.cidade} - ${tData.uf}`;
            else
            {
                if(!Vazio(tData.cidade))
                    localizar = tData.cidade;
                if(!Vazio(tData.uf))
                    localizar = tData.uf;
            }
            
            auxDetalhes = '';
            //`<a  href="#" onclick="AbrirURL(this); return false;" data-url="${linkDetalhes}${tData.idvaga}" class="btnFirstList buttonCard" data-codigo="VisualResumoVaga" data-vaga="${tData.idvaga}"><i class="far fa-ey"></i>Detalhes da vaga</a>`;

            auxCandidatos = `<a href="#" onclick="AbrirURL(this); return false;" data-url="${linkCandidatos}${tData.idvaga}"  class="btnFirstList statusCard" data-codigo="VisualCandidatosVaga" data-vaga="${tData.idvaga}"><i class="fas fa-user-friends"></i>Ver lista de candidatos</a>`;

            divCards = `<div class="cardsVagas cardsOn dummy " name="${classe}" >`;
            divCards += `<section class="headerCard"> <span class="statusCard"> <i class="fas fa-circle"></i> <span></span> </span> <span> #${tData.codigovaga}</span> </section>`;
            divCards += `<section class="tituloCard"> <span>${tData.titulodavaga}</span> </section>`;
            
            divCards += `<section class="miniCard"> <div class="recomend"> <div class="iconeCard"><i class="far fa-user"></i></div> <div class="infoDados"> <span class="points${classePontos}"> <i class="fas fa-circle"></i> <i class="fas fa-circle"></i> <i class="fas fa-circle"></i> </span> <div class="infoDadosTitle"> <span class="infoNum${classePoint}">${tData.disponiveis}</span> <span class="infoText">Disponíveis</span> </div> <div class="infoButtons"> <button class="buttonMiniCards"><i class="far fa-eye"></i>Listar</button> <button class="buttonMiniCards"><i class="fas fa-file-excel"></i>Exportar</button> </div> </div> </div> <div class="selection"> <div class="iconeCard"><i class="far fa-star"></i></div> <div class="infoDados"> <span class="points ${classePontos}"> <i class="fas fa-circle"></i> <i class="fas fa-circle"></i> <i class="fas fa-circle"></i> </span> <div class="infoDadosTitle"> <span class="infoNum ${classePoint}">${tData.favoritos}</span> <span class="infoText">Favoritos</span> </div> <div class="infoButtons"> <button class="buttonMiniCards"><i class="far fa-eye"></i>Listar</button> <button class="buttonMiniCards"><i class="fas fa-file-excel"></i>Exportar</button> </div> </div> </div> <div class="contract"> <div class="iconeCard"><i class="fas fa-user-check"></i></div> <div class="infoDados"> <span class="points${classePontos}"> <i class="fas fa-circle"></i> <i class="fas fa-circle"></i> <i class="fas fa-circle"></i> </span> <div class="infoDadosTitle"> <span class="infoNum ${classePoint}">${tData.contratados}</span> <span class="infoText">Assessment</span> </div> <div class="infoButtons"> <button class="buttonMiniCards"><i class="far fa-eye"></i>Listar</button> <button class="buttonMiniCards"><i class="fas fa-file-excel"></i>Exportar</button> </div> </div> </div> </section>`;
            divCards += `<section class="listButtons"> ${auxCandidatos} ${auxDetalhes} </section></div>`;
        
            $(".listaVaga").append($(divCards));
        }
    },
    Filtrar: function(url_lista_vagas, start) {
        let inputSearch = $("#search").val();
        let classificar = $(".classificacao").val();
        let status      = $(".status").val();
        let urlQueryText = '?';
        let limit = Dashboard.Listar.GetColuna() * 3;

        if(inputSearch) {
            inputSearch = inputSearch.replace(/%/gi, "%25");
            urlQueryText += "&buscar="+inputSearch;
        }

        if(classificar) {
            classificar = classificar.replace(/%/gi, "%25");
            urlQueryText += "&classificacao="+classificar;
        }

        if(status) {
            status = status.replace(/%/gi, "%25");
            urlQueryText += "&ativos="+status
        }

        if(urlQueryText == '?') {
            urlQueryText = "";
        }
        Dashboard.Listar.ListarDados(url_lista_vagas, limit, start, urlQueryText);
    },
    SemVagas: function(msn = "") {
        let obj = $(".listaVaga #errovagas");
        let html = "";
        if(Vazio(msn))
        {
            msn = "ocorreu um erro desconhecido no sistema";
        }
        if(Vazio(obj))
        {
            html = `<div id="errovagas"><h2>${msn}</h2></div>`;
            $(".listaVaga").append(html);
        }
        else
        {
            obj.find("h2").html(msn);
        }
    },
    LimparErroVagas: function() {
        let obj = $(".listaVaga #errovagas");
        if(!Vazio(obj))
        {
            obj.remove();
        }
    },
    Preload: function() {
        let html = $("#OcultarPreload").html();
        let colunas = Dashboard.Listar.GetColuna();
        
        html = html.replaceAll("<!--", "").replaceAll("-->", "");
        for( let i = 0; i < colunas; i++)
        {
            $(".listaVaga").append($(html));
        }
    },
    Unpreload: function() {
        $(".preload").remove();
    },
    GetColuna: function() {
        let width = $("body.sidebar-collapsed").outerWidth(true);
        let colunas = 4;
        if(width > 1981)
            colunas = 6;
        else
        {
            if(width > 1930)
                colunas = 5;
            else
            {
                if(width > 1399)
                    colunas = 4;
                else
                {
                    if(width > 780)
                        colunas = 3;
                    else
                    {
                        if(width > 480)
                            colunas = 2;
                        else
                        {
                            colunas = 1;
                        } 
                    }
                }
            }
        }
        return colunas;
    }
  }
}
</script>