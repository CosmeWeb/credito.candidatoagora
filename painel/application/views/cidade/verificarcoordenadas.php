<div class="col-lg-12">
	<div class="panel panel-primary">
		<div class="panel-heading"><?php echo __("Verificar coordenadas geograficas da cidades."); ?></div>
		<div class="panel-body pan">
			<form id="frmcoordenadascidade" action="#" method="POST" class="form-horizontal geracao">
				<div class="form-body pal">
					<div class="form-group">
						<div id="flat-skin" class="row skin skin-flat">
                            <div class="col-md-8">
                                <fieldset>
                                    <legend>Processamento das coordenadas geograficas da cidades </legend>
                                    <ul>
                                        <li>
                                            <input type="radio" id="processandorealizado" checked name="processando" value="realizado" class="switch"> 
                                            Processar somente as cidades que já foram processados
                                        </li>
										<li>
                                            <input type="radio" id="processandoparcial" checked name="processando" value="parcial" class="switch"> 
                                            Processar somente as cidades que não foram processados
                                        </li>
                                        <li>
                                            <input type="radio" id="processandocompleto" name="processando" value="completo" class="switch">
                                            Processar todas as cidades da base de dados
                                        </li>
                                    </ul>
                                </fieldset>
                            </div>
                            <div class="col-md-12">
                                <div class="col-md-8 col-lg-offset-2">
                                    <div class="alert alert-info" id="lblmsm" style="display: none">
                                    </div>
                                </div>
                            </div>
							<div class="col-md-12">
								<div id="Geracurriculo" class="progress progress-striped active" style="clear: both; margin-top: 20px; background-color: #b7b5b5; display: none;">
									<div id="processo" role="progressbar" aria-valuetransitiongoal="100" class="progress-bar progress-bar-danger" aria-valuenow="100" style="width: 0%;"><?php echo __("0% Carregando das cidades..."); ?></div>
								</div>
							</div>
						</div>
					</div>
                    <div class="form-actions none-bg">
                        <div class="col-md-12">
                            <button type="button" class="btn btn-danger" style="float: right;" onclick="goBack();"><i class="fa fa-caret-square-o-left"></i> <?php echo __("Voltar"); ?></button>&nbsp
                            <button type="button" class="btn btn-danger" style="float: right; margin-right: 20px;" onclick="IniciarAssociarCoordenadas();"><i class="fa fa-map-marker"></i> <?php echo __("Processar Coordenadas"); ?></button>&nbsp
                        </div>
                    </div>
                </div>
			</form>
		</div>
	</div>
</div>
<script>
var Total_ = 0;
var Posicao_ = 0;
function goBack() {
    window.history.back()
}
function GetTotalCoordenadasCidade(obj)
{
    var url = GetUrlAcao("cidade","totalcoordenadascidades");
    var data = $(obj.form).serialize();
    $.ajax({
        url: url,
        method:'POST',
        data:data,
        success: function (data) {
            if(Vazio(data))
            {
                MsnDanger("Erro", "Ocorreu um erro desconhecido.");
                return;
            }
            if(data.sucesso)
            {
                $("#lblmsm").removeClass().addClass(data.class).slideDown("slow");
                $("#lblmsm").html(data.mensagem);
                MsnSucesso("Verificação", data.mensagem);
            }
            else
            {
                alert(data.erro);
            }
            return;
        },
        fail: function (jqXHR, status, errorThrown) {
            throw Error('JSONFixture could not be loaded: ' + url + ' (status: ' + status + ', message: ' + errorThrown.message + ')')
        }
    });
}
function IniciarAssociarCoordenadas()
{
	$("#Geracurriculo").css("display","block");
	$("#processo").html("<?php echo __("0% das coordenadas das cidades foram processadas..."); ?>");
	$("#processo").css("width","0%");
    AssociarCoordenadas(false, 0, 0);
}
function IniciarBarraCoordenadas(posicao = 0, total = 0)
{
	Total_ = total;
    Posicao_ = posicao;
}
function ShowBarraCoordenadas(index = 1)
{
	let aux = Total_;
    let porcente = 0;
    let posicao = Posicao_ + index;
    let texto = "<?php echo __("% das coordenadas das cidades foram processadas..."); ?>";
    Posicao_ = posicao;
    if(Vazio(aux))
        aux = 1;
    porcente = Math.ceil((posicao/aux) * 100);
    texto = porcente + texto;
    $("#Geracurriculo").css("display","block");
    $('#processo').css('width',porcente+'%').html(texto);
}
function FecharCurriculos()
{
	$("#processo").css("width","100%");
	$("#processo").html("<?php echo __("100% Processamento finalizado."); ?>");
	MsnSucesso("Sucesso", "<?php echo __("Processamento de associação das coordenadas das cidades foi finalizada."); ?>");
	$("#Geracurriculo").delay(2000).fadeOut();
    $("#lblmsm").html("<?php echo __("<b>Finalizado</b> Associação das coordenadas das cidades foi realizada com sucesso."); ?>");
}
function AssociarCoordenadas(lista = false, posicao = 0, total = 0)
{
    var url = GetUrlAcao("cidade","associarcoordenadas");
    var processando = $("input[name='processando']:checked").val();
    var data = {
        "processando":processando,
        "posicao":posicao,
        "total":total,
        "cidades":lista
    };
    if((Vazio(posicao))&&(!Vazio(total)))
    {
        IniciarBarraCoordenadas(posicao, total);
    }
	$.ajax({
        url: url,
        method:'POST',
        data:data,
		success: function (data) {
			if(Vazio(data))
			{
				MsnDanger("Erro", "Ocorreu um erro desconhecido.");
				return;
			}
			if(data.sucesso)
			{
                MsnSucesso(data.titulo, data.mensagem);
			    if(data.finalizado)
                {
                    FecharCurriculos();
                }
                else
                {
                    BuscarCoordenadas(data.cidades, 0, data.posicao, data.total);
                }
			}
			else
			{
				alert(data.erro);
			}
			return;
		},
		fail: function (jqXHR, status, errorThrown) {
			throw Error('JSONFixture could not be loaded: ' + url + ' (status: ' + status + ', message: ' + errorThrown.message + ')')
		}
	});
}
function BuscarCoordenadas(lista = false, index = 0, posicao = 0, total = 0)
{   
    if(Vazio(lista))
    {
        AssociarCoordenadas(lista, posicao, total);
        return;
    }
	if(lista.length <= index)
    {
        AssociarCoordenadas(lista, posicao, total);
        return;
    }
    LerCoordenadas(lista, index, posicao, total);
}
function LerCoordenadas(lista = false, index = 0, posicao = 0, total = 0)
{   
    //let url = "https://maps.googleapis.com/maps/api/place/textsearch/json";
    let url = "http://form3.candidatoagora.com.br/painel/index.php/cidade/emulador/";
    let data = null;
    let cidade = null;
    if(Vazio(lista))
    {
        BuscarCoordenadas(lista, index + 1, posicao, total);
        return;
    }
	if(lista.length <= index)
    {
        BuscarCoordenadas(lista, index + 1, posicao, total);
        return;
    }
    if(Vazio(lista[index]))
    {
        FecharCurriculos();
        return;
    }
    cidade = lista[index];
    data = {
        key:"AIzaSyAniOxGrlXfMDh6Lp6BCTW9xPwQZDEnTH4",
        query:cidade.buscar,
        cidade:cidade.cidade
    }
    $.ajax({
        url: url,
        method:'GET',
        data:data,
        success: function (data) {
            if(!Vazio(data.results[0]))
            {
                let resultado = data.results[0];
                if(cidade.cidade.toLowerCase() == resultado.name.toLowerCase())
                {
                    let posicao = resultado.geometry.location;
                    let northeast = resultado.geometry.viewport.northeast;
                    let southwest = resultado.geometry.viewport.southwest;
                    lista[index].latitude = posicao.lat;
                    lista[index].longitude = posicao.lng;
                    lista[index].northeast_lat = northeast.lat;
                    lista[index].northeast_lng = northeast.lng;
                    lista[index].southwest_lat = southwest.lat;
                    lista[index].southwest_lng = southwest.lng;
                    lista[index].atualizado = true;
                }
            }
            ShowBarraCoordenadas();
            BuscarCoordenadas(lista, index + 1, posicao, total);
            return;
        },
        fail: function (jqXHR, status, errorThrown) {
            throw Error('JSONFixture could not be loaded: ' + url + ' (status: ' + status + ', message: ' + errorThrown.message + ')')
        }
    });
}
$(function () {
    $( "#frmcoordenadascidade input" ).change(function() {
        GetTotalCoordenadasCidade(this);
    });
    GetTotalCoordenadasCidade($( "#processandoparcial" ).get(0));
});
</script>