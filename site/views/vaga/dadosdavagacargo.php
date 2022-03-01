<div id="container">
    <form id="frmvaga" action="<?php echo site_url('vaga/dadosdacontratante') ?>" method="POST">
        <input id="idvaga" name="idvaga" type="hidden" value="<?php echo $obj->idvaga; ?>">
        <input id="fasecadastro" name="fasecadastro" type="hidden" value="4">
        <div class="tituloconteudo">
            <h1>Cadastro de nova vaga</h1>
            <svg id="progress-steps" xmlns="http://www.w3.org/2000/svg" width="884" height="38" viewBox="0 0 884 38">
                <g id="Group_453" data-name="Group 453" transform="translate(-617 -100)">
                    <g transform="translate(617 100)">
                    <g id="step3" transform="translate(577.819)">
                        <g id="Ellipse" transform="translate(0.181)" fill="#116cdd" stroke="#116cdd" stroke-width="2">
                        <circle cx="19" cy="19" r="19" stroke="none"/>
                        <circle cx="19" cy="19" r="18" fill="none"/>
                        </g>
                        <text id="_3" data-name="3" transform="translate(19.181 24)" fill="#fff" stroke="rgba(0,0,0,0)" stroke-miterlimit="10" stroke-width="1" font-size="16" font-family="SourceSansPro-Bold, Source Sans Pro" font-weight="700"><tspan x="-4.256" y="0">3</tspan></text>
                    </g>
                    <g id="step3-2" data-name="step3" transform="translate(320.603)">
                        <g id="Ellipse-2" data-name="Ellipse" transform="translate(0.397)" fill="none" stroke="#116cdd" stroke-width="2">
                        <circle cx="19" cy="19" r="19" stroke="none"/>
                        <circle cx="19" cy="19" r="18" fill="none"/>
                        </g>
                        <text id="_2" data-name="2" transform="translate(19.397 24)" fill="#116cdd" stroke="rgba(0,0,0,0)" stroke-miterlimit="10" stroke-width="1" font-size="16" font-family="SourceSansPro-Bold, Source Sans Pro" font-weight="700"><tspan x="-4.256" y="0">2</tspan></text>
                    </g>
                    <g id="step3-3" data-name="step3" transform="translate(49.001)">
                        <g id="Ellipse-3" data-name="Ellipse" transform="translate(-0.001)" fill="none" stroke="#116cdd" stroke-width="2">
                        <circle cx="19" cy="19" r="19" stroke="none"/>
                        <circle cx="19" cy="19" r="18" fill="none"/>
                        </g>
                        <text id="_1" data-name="1" transform="translate(18.999 24)" fill="#116cdd" font-size="16" font-family="SourceSansPro-Bold, Source Sans Pro" font-weight="700"><tspan x="-4.256" y="0">1</tspan></text>
                    </g>
                    <g id="step4" transform="translate(846)">
                        <g id="Ellipse-4" data-name="Ellipse" fill="none" stroke="#a5a4bf" stroke-width="2">
                        <circle cx="19" cy="19" r="19" stroke="none"/>
                        <circle cx="19" cy="19" r="18" fill="none"/>
                        </g>
                        <text id="_4" data-name="4" transform="translate(19 24)" fill="#a5a4bf" stroke="rgba(0,0,0,0)" stroke-miterlimit="10" stroke-width="1" font-size="16" font-family="SourceSansPro-Bold, Source Sans Pro" font-weight="700"><tspan x="-4.256" y="0">4</tspan></text>
                    </g>
                    <rect id="Rectangle_1763" data-name="Rectangle 1763" width="234" height="2" transform="translate(87 18)" fill="#116cdd"/>
                    <rect id="Rectangle_1767" data-name="Rectangle 1767" width="49" height="2" transform="translate(0 18)" fill="#116cdd"/>
                    <rect id="Rectangle_1765" data-name="Rectangle 1765" width="219" height="2" transform="translate(359 18)" fill="#116cdd"/>
                    <rect id="Rectangle_1766" data-name="Rectangle 1766" width="220" height="2" transform="translate(616 18)" fill="#a5a4bf" opacity="0.5"/>
                    </g>
                    <g id="progress-completed" transform="translate(666 100)">
                    <g id="Ellipse-5" data-name="Ellipse" fill="#f0f0f7" stroke="#116cdd" stroke-width="2">
                        <circle cx="19" cy="19" r="19" stroke="none"/>
                        <circle cx="19" cy="19" r="18" fill="none"/>
                    </g>
                    <path id="Path_294" data-name="Path 294" d="M1187.471,717.879l4.9,4.833,8.407-8.4" transform="translate(-1175 -698)" fill="none" stroke="#116cdd" stroke-width="2"/>
                    </g>
                    <g id="progress-completed-2" data-name="progress-completed" transform="translate(938 100)">
                    <g id="Ellipse-6" data-name="Ellipse" fill="#f0f0f7" stroke="#116cdd" stroke-width="2">
                        <circle cx="19" cy="19" r="19" stroke="none"/>
                        <circle cx="19" cy="19" r="18" fill="none"/>
                    </g>
                    <path id="Path_294-2" data-name="Path 294" d="M1187.471,717.879l4.9,4.833,8.407-8.4" transform="translate(-1175 -698)" fill="none" stroke="#116cdd" stroke-width="2"/>
                    </g>
                </g>
            </svg>
        </div>
        <div id="dadosform" class="corpoconteudo">
            <div class="texto">
                <h2>Informações sobre a vaga</h2>
                <div class="cubo">
                    <div class="caixa full">
                        <label for="nomecargo">Selecionar cargos mais próximos (correlatos) existentes no mercado</label>
                        <div class="info" style="top: -20px;">
                            <i class="fa fa-info-circle"></i>
                            <span>
                                Digite o nome do cargo correlatos existentes no mercado e clique em adicionar para incluir o cargo na lista de cargos.
                                <ins></ins>
                            </span>
                        </div>
                        <div class="lista" id="areacargo" style="display: none;">
                        </div>
                        <input class="add" id="nomecargo" name="nomecargo" type="text" value="">
                        <button class="add" type="button" onclick="AdicionarCargoCorrelato()" title="Adicionar cargo">
                            <i class="fa fa-plus-circle"></i>
                        </button>
                    </div>
                    <div class="caixa">
                        <label for="linhadereporte">Linha de reporte</label>
                        <div class="info">
                            <i class="fa fa-info-circle"></i>
                            <span>
                                Para qual nível essa posição irá reportar.
                                <ins></ins>
                            </span>
                        </div>
                        <select id="linhadereporte" name="linhadereporte">
                            <?php echo $obj->GerarOpcoesLinhadereporte($obj->linhadereporte, __("-- Selecione --")); ?>
                        </select>
                    </div>
                    <div class="caixa">
                        <label for="faixaderemuneracaoinicial">Faixa de remuneração mensal</label>
                        <div class="info">
                            <i class="fa fa-info-circle"></i>
                            <span>
                                Faixa de remuneração mensal
                                <ins></ins>
                            </span>
                        </div>
                        <div class="caixabaixa">
                            <span>Inicial: R$</span>
                            <input id="faixaderemuneracaoinicial" name="faixaderemuneracaoinicial" type="text" value="<?php echo $obj->faixaderemuneracaoinicial; ?>">
                        </div>
                        <div class="caixabaixa ES">
                            <span>Final: R$</span>
                            <input id="faixaderemuneracaofim" name="faixaderemuneracaofim" type="text" value="<?php echo $obj->faixaderemuneracaofim; ?>">
                        </div>
                    </div>
                </div>
                <div class="cubo  ES">
                    <div class="caixa">
                        <label for="descricaodavaga">Descrição da vaga</label>
                        <div class="info">
                            <i class="fa fa-info-circle"></i>
                            <span>
                                informe a descrição da vaga.
                                <ins></ins>
                            </span>
                        </div>
                        <textarea id="descricaodavaga" name="descricaodavaga"><?php echo $obj->descricaodavaga; ?></textarea>
                    </div>
                </div>
                <h2>
                    <span style="float: left; position: relative;">
                        Local do trabalho
                    </span>
                    <div class="remoto">
                        <input id="remoto" name="remoto" type="checkbox" value="Sim" <?php echo $obj->FormGetRadio("remoto","Sim"); ?>>
                        <samp>Esta vaga é remota</samp>
                    </div>
                </h2>
                <div class="caixa meio-20">
                    <label for="idestado">Estado</label>
                    <div class="info">
                        <i class="fa fa-info-circle"></i>
                        <span>
                            Selecione o estado da vaga.
                            <ins></ins>
                        </span>
                    </div>
                    <select id="idestado" name="idestado">
                        <?php echo $obj->GerarOpcoesEstados($obj->idestado, __("-- Selecione --")); ?>
                    </select>
                </div>
                <div class="caixa meio-40">
                    <label for="idcidade">Cidade</label>
                    <div class="info">
                        <i class="fa fa-info-circle"></i>
                        <span>
                            Selecione a cidade da vaga.
                            <ins></ins>
                        </span>
                    </div>
                    <select id="idcidade" name="idcidade">
                        <?php echo $obj->GerarOpcoesCidades($obj->idcidade, __("-- Selecione --")); ?>
                    </select>
                </div>
                <div class="caixa meio-40 ES">
                    <label for="raiodepesquisa">Candidatos no raio de:</label>
                    <div class="info">
                        <i class="fa fa-info-circle"></i>
                        <span>
                            Selecione um raio de pesquisa em torno da cidade selecionada.
                            <ins></ins>
                        </span>
                    </div>
                    <select id="raiodepesquisa" name="raiodepesquisa">
                        <?php echo $obj->GerarOpcoesRaiodepesquisa($obj->raiodepesquisa, __("-- Selecione --")); ?>
                    </select>
                </div>
                <h4>
                    Mobilidade: Considerar candidatos fora do raio de atuação do local de trabalho?
                    <div class="info">
                        <i class="fa fa-info-circle"></i>
                        <span>
                            Considerar a mobilidade do candidatos fora do raio de atuação do local de trabalho.
                            <ins></ins>
                        </span>
                    </div>
                </h4>
                <ul class="mb-40">
                    <li class="meio">
                        <input id="mobilidade1" name="mobilidade" type="radio" value="Apenas no raio do local de trabalho" <?php echo $obj->FormGetRadio("mobilidade","Apenas no raio do local de trabalho"); ?>>
                        <span>
                            Apenas no raio do local de trabalho
                        </span>
                    </li>
                    <li class="meio">
                        <input id="mobilidade3" name="mobilidade" type="radio" value="De todo o Brasil, mas desde que o(a) candidato(a) teve/tenha algum vínculo pessoal com a cidade/Estado do local de trabalho" <?php echo $obj->FormGetRadio("mobilidade","De todo o Brasil, mas desde que o(a) candidato(a) teve/tenha algum vínculo pessoal com a cidade/Estado do local de trabalho"); ?>>
                        <span>
                            De todo o Brasil, mas desde que o(a) candidato(a) teve/tenha algum vínculo pessoal com a cidade/Estado do local de trabalho
                        </span>
                    </li>
                    <li class="meio">
                        <input id="mobilidade2" name="mobilidade" type="radio" value="De todo o Estado do local de trabalho" <?php echo $obj->FormGetRadio("mobilidade","De todo o Estado do local de trabalho"); ?>>
                        <span>
                            De todo o Estado do local de trabalho
                        </span>
                    </li>
                    <li class="meio">
                        <input id="mobilidade4" name="mobilidade" type="radio" value="De todo o Brasil, pois a empresa considera mobilidade total" <?php echo $obj->FormGetRadio("mobilidade","De todo o Brasil, pois a empresa considera mobilidade total"); ?>>
                        <span>
                            De todo o Brasil, pois a empresa considera mobilidade total
                        </span>
                    </li>
                </ul>
            </div>
        </div>
        <div id="dadosformrodape" class="rodapeconteudo">
            <div class="area-btn">
                <a href="javascript:;" class="btn-Voltar" onclick="Voltar()">Voltar</a>
                <a href="javascript:;" class="btn-Avancar" onclick="SalvarVaga()">Avançar</a>
            </div>
        </div>
    </form>
</div>
<div id="OcultarCargoCorrelato" style="display: none;">
<!--
<div class="bola" id="Cargo{cont}">
    <input id="idcargocorrelato{cont}" name="idcargocorrelato[]" type="hidden" value="{idcargocorrelato}">
    <input id="cargo{cont}" name="cargo[]" type="hidden" value="{cargo}">
    <span>{cargo}</span>
    <a href="javascript:;" class="btn-close" onclick="DeletarCargoCorrelato(this, {idcargocorrelato})"><i class="fa fa-remove"></i></a>
</div>
-->
</div>
<script>
    var templatecargocorrelato = null;
    function GetTemplateCargoCorrelato()
    {    
		if(Vazio(templatecargocorrelato))
        {
            templatecargocorrelato = $("#OcultarCargoCorrelato").html();
        }
        return templatecargocorrelato;
    }
    function AdicionarCargoCorrelato(cargo = null)
    {      
        let obj = $("#areacargo div:last-of-type");
        let id = 0;
        if(Vazio(obj))
        {
            id = 0;
        }
        else
        {
            id = obj.attr('id');
            id = GetNumero(id);
            id++;
		}
		if(Vazio(cargo))
        {
            let nome = $("#nomecargo").val();
            if(Vazio(nome))
            {
                return;
            }
            cargo = {
                "idcargocorrelato":0,
                "idvaga": 0,
                "cargo": nome
            };
            $("#nomecargo").val("");
        }
        obj = $("#areacargo");  
        let caixa = GetTemplateCargoCorrelato();
        if(Vazio(obj))
        {
            return;
        }
        obj.css("display","block");
        caixa = caixa.replaceAll("{cont}", id);
        caixa = caixa.replaceAll("<!--", "");
		caixa = caixa.replaceAll("-->", "");
		caixa = caixa.replaceAll("{idcargocorrelato}", cargo.idcargocorrelato);
        caixa = caixa.replaceAll("{cargo}", cargo.cargo);
        obj.append(caixa);
    }
    function CarregarMaisCargo(posicao = 0, total = 0)
    {
        let url = GetUrlAcao("api","carregarmaiscargoscorrelato");
        let data = null;
        data = {
            "posicao": posicao,
            "total": total,
            "idvaga": $("#idvaga").val(),
        }    
        $.ajax({
            url: url,
            method:'POST',
            data:data,
            success:function(data){
                if(data.sucesso)
                {
                    if(!Vazio(data.lista))
                    {
                        for( let i = 0; i < data.lista.length; i++)
                        {
                            AdicionarCargoCorrelato(data.lista[i]);
                        }
                    }
                    if(!data.finalizar)
                    {
                        CarregarMaisCargo(data.posicao, data.total);
                    }
                }
                else
                {
                    console.log(data);
                    /*msn = data.erro;
                    titulo = data.titulo;
                    MsnDanger(titulo, msn);*/
                }
            },
            error: function(XHR, textStatus, errorThrown){
                msn = "Falha ao buscar lista de cargo correlato.";
                MsnDanger("Erro", msn);
            }
        });
    }
    function DeletarCargoCorrelato(obj, idcargocorrelato)
    {
        let url = GetUrlAcao("api","deletecargocorrelato");
        let data = null;
        if(Vazio(idcargocorrelato))
        {
            $(obj).parent().remove();
            return;
        }
        if(!confirm("<?php echo __("Tem certeza que deseja deletar esta cargo correlato da sua vaga?"); ?>"))
        {
            return;
        }
        data = {
            "idcargocorrelato":idcargocorrelato
        }    
        $.ajax({
            url: url,
            method:'POST',
            data:data,
            success:function(data){
                if(data.sucesso)
                {
                    $(obj).parent().remove();
                    msn = data.mensagem;
                    titulo = data.titulo;
                    MsnSucesso(titulo, msn);
                }
                else
                {
                    msn = data.erro;
                    titulo = data.titulo;
                    MsnDanger(titulo, msn);
                }
            },
            error: function(XHR, textStatus, errorThrown){
                msn = "Falha ao deletar esta cargo correlato da sua vaga.";
                MsnDanger("Erro", msn);
            }
        });
    }
    $(function() {
        formatDecimal($("#faixaderemuneracaoinicial").get(0), "pt-br", true);
        formatDecimal($("#faixaderemuneracaofim").get(0), "pt-br", true);
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
        $("#idestado").change(function() {
            let url = GetUrlAcao("api","listacidades");
            let data = null;
            let idestado = $(this).val();
            let msn = "";
            if(Vazio(idestado))
            {
                return;
            }
            data = {
                "idestado":idestado
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
                        $("#idcidade").html(html);
                    }
                    else
                    {
                        let html = '<option value=""><?php echo __("-- Selecione --"); ?></option>';
                        $("#idcidade").html(html);
                    }
                },
                error: function(XHR, textStatus, errorThrown){
                    msn = "Falha ao buscar lista de cidade.";
                    MsnDanger("Erro", msn);
                }
            });
        });        
        CarregarMaisCargo();
    });
</script>
