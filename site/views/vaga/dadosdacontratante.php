<section class="container">
    <div class="tituloconteudo">
        <h1><?php echo $obj->titulodavaga; ?></h1>
        <svg id="progress-steps" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 705 26">
            <defs>
                <linearGradient id="linear-gradient" x1="1" y1="1" x2="0" y2="1" gradientUnits="objectBoundingBox">
                <stop offset="0" stop-color="#116cdd"/>
                <stop offset="1" stop-color="#116cdd" stop-opacity="0"/>
                </linearGradient>
            </defs>
            <g id="step3" transform="translate(420.819 -6)">
                <g id="Ellipse" transform="translate(6.181 6)" fill="none" stroke="#a5a4bf" stroke-width="2">
                <circle cx="13" cy="13" r="13" stroke="none"/>
                <circle cx="13" cy="13" r="12" fill="none"/>
                </g>
                <text id="_4" data-name="4" transform="translate(19.181 24)" fill="#a5a4bf" stroke="rgba(0,0,0,0)" stroke-miterlimit="10" stroke-width="1" font-size="16" font-family="SourceSansPro-Bold, Source Sans Pro" font-weight="700"><tspan x="-4.256" y="0">4</tspan></text>
            </g>
            <g id="step3-2" data-name="step3" transform="translate(164.819 -6)">
                <g id="Ellipse-2" data-name="Ellipse" transform="translate(136.181 6)" fill="none" stroke="#a5a4bf" stroke-width="2">
                <circle cx="13" cy="13" r="13" stroke="none"/>
                <circle cx="13" cy="13" r="12" fill="none"/>
                </g>
                <text id="_3" data-name="3" transform="translate(149.181 24)" fill="#a5a4bf" stroke="rgba(0,0,0,0)" stroke-miterlimit="10" stroke-width="1" font-size="16" font-family="SourceSansPro-Bold, Source Sans Pro" font-weight="700"><tspan x="-4.256" y="0">3</tspan></text>
            </g>
            <g id="step3-3" data-name="step3" transform="translate(503.819 -6)">
                <g id="Ellipse-3" data-name="Ellipse" transform="translate(49.181 6)" fill="none" stroke="#a5a4bf" stroke-width="2">
                <circle cx="13" cy="13" r="13" stroke="none"/>
                <circle cx="13" cy="13" r="12" fill="none"/>
                </g>
                <text id="_5" data-name="5" transform="translate(62.181 24)" fill="#a5a4bf" stroke="rgba(0,0,0,0)" stroke-miterlimit="10" stroke-width="1" font-size="16" font-family="SourceSansPro-Bold, Source Sans Pro" font-weight="700"><tspan x="-4.256" y="0">5</tspan></text>
            </g>
            <g id="step3-4" data-name="step3" transform="translate(168.603 -6)">
                <g id="Ellipse-4" data-name="Ellipse" transform="translate(6.397 6)" fill="none" stroke="#a5a4bf" stroke-width="2">
                <circle cx="13" cy="13" r="13" stroke="none"/>
                <circle cx="13" cy="13" r="12" fill="none"/>
                </g>
                <text id="_2" data-name="2" transform="translate(19.397 24)" fill="#a5a4bf" stroke="rgba(0,0,0,0)" stroke-miterlimit="10" stroke-width="1" font-size="16" font-family="SourceSansPro-Bold, Source Sans Pro" font-weight="700"><tspan x="-4.256" y="0">2</tspan></text>
            </g>
            <g id="step3-5" data-name="step3" transform="translate(43.001 -6)">
                <g id="Ellipse-5" data-name="Ellipse" transform="translate(5.999 6)" fill="#116cdd" stroke="#116cdd" stroke-width="2">
                <circle cx="13" cy="13" r="13" stroke="none"/>
                <circle cx="13" cy="13" r="12" fill="none"/>
                </g>
                <text id="_1" data-name="1" transform="translate(18.999 24)" fill="#fff" font-size="16" font-family="SourceSansPro-Bold, Source Sans Pro" font-weight="700"><tspan x="-4.256" y="0">1</tspan></text>
            </g>
            <g id="step4" transform="translate(673 -6)">
                <g id="Ellipse-6" data-name="Ellipse" transform="translate(6 6)" fill="none" stroke="#a5a4bf" stroke-width="2">
                <circle cx="13" cy="13" r="13" stroke="none"/>
                <circle cx="13" cy="13" r="12" fill="none"/>
                </g>
                <text id="_6" data-name="6" transform="translate(19 24)" fill="#a5a4bf" stroke="rgba(0,0,0,0)" stroke-miterlimit="10" stroke-width="1" font-size="16" font-family="SourceSansPro-Bold, Source Sans Pro" font-weight="700"><tspan x="-4.256" y="0">6</tspan></text>
            </g>
            <rect id="Rectangle_1763" data-name="Rectangle 1763" width="100" height="2" transform="translate(75 12)" fill="#a5a4bf" opacity="0.5"/>
            <rect id="Rectangle_1767" data-name="Rectangle 1767" width="49" height="2" transform="translate(0 12)" fill="url(#linear-gradient)"/>
            <rect id="Rectangle_1765" data-name="Rectangle 1765" width="100" height="2" transform="translate(327 12)" fill="#a5a4bf" opacity="0.5"/>
            <rect id="Rectangle_2042" data-name="Rectangle 2042" width="100" height="2" transform="translate(201 12)" fill="#a5a4bf" opacity="0.5"/>
            <rect id="Rectangle_1766" data-name="Rectangle 1766" width="100" height="2" transform="translate(453 12)" fill="#a5a4bf" opacity="0.5"/>
            <rect id="Rectangle_2043" data-name="Rectangle 2043" width="100" height="2" transform="translate(579 12)" fill="#a5a4bf" opacity="0.5"/>
        </svg>
    </div>
    <div class="telaestrutura">
        <div class="painelPrincipal">
            <div class="cardconteudo">
                <form id="frmvaga" action="<?php echo site_url('vaga/dadosdacontratante') ?>" method="POST">
                    <input id="idvaga" name="idvaga" type="hidden" value="<?php echo $obj->idvaga; ?>">
                    <input id="idcliente" name="idcliente" type="hidden" value="<?php echo $obj->idcliente; ?>">
                    <input id="fasecadastro" name="fasecadastro" type="hidden" value="2">
                    <div id="dadosform" class="corpoconteudo">
                        <div class="texto">
                            <h2>Dados da empresa contratante</h2>
                            <div class="caixa meio">
                                <label for="empresacontratante">Nome da empresa contratante</label>
                                <div class="info">
                                    <i class="fa fa-info-circle"></i>
                                    <span>
                                        Informe o nome da empresa contratante.
                                        <ins></ins>
                                    </span>
                                </div>
                                <input id="empresacontratante" name="empresacontratante" type="text" value="<?php echo $obj->empresacontratante; ?>">
                            </div>
                            <div class="caixa meio ES">
                                <label for="idsetor">Setor de atuação</label>
                                <div class="info">
                                    <i class="fa fa-info-circle"></i>
                                    <span>
                                        O setor de atuação da empresa ajuda a direcionar o algoritmo para gerar candidatos aderentes.
                                        <ins></ins>
                                    </span>
                                </div>
                                <select id="idsetor" name="idsetor">
                                    <?php echo $obj->GerarOpcoesSetores($obj->idsetor, __("-- Selecione --")); ?>
                                </select>
                            </div>
                            <div class="caixa meio">
                                <label for="idtamanho">Quantidade de funcionários</label>
                                <div class="info">
                                    <i class="fa fa-info-circle"></i>
                                    <span>
                                        Com base no tamanho da empresa o algoritmo ajuda a identificar candidatos alinhados a estrutura.
                                        <ins></ins>
                                    </span>
                                </div>
                                <select id="idtamanho" name="idtamanho">
                                    <?php echo $obj->GerarOpcoesTamanhos($obj->idtamanho, __("-- Selecione --")); ?>
                                </select>
                            </div>
                            <div class="caixa meio ES">
                                <label for="idfaturamento">Atual nível de faturamento anual</label>
                                <div class="info">
                                    <i class="fa fa-info-circle"></i>
                                    <span>
                                        Com base no faturamento da empresa o algoritmo ajuda a identificar candidatos alinhados a estrutura.
                                        <ins></ins>
                                    </span>
                                </div>
                                <select id="idfaturamento" name="idfaturamento">
                                    <?php echo $obj->GerarOpcoesFaturamentos($obj->idfaturamento, __("-- Selecione --")); ?>
                                </select>
                            </div>
                            <h4>
                                Como você entende o momento atual da sua empresa?
                                <div class="info">
                                    <i class="fa fa-info-circle"></i>
                                    <span>
                                        O momento atual da empresa é importante para alinhar expectativas com o que o candidato busca como próximo passo de carreira.
                                        <ins></ins>
                                    </span>
                                </div>
                            </h4>
                            <ul>
                                <li class="meio">
                                    <input id="momentoatualempresa1" name="momentoatualempresa" type="radio" <?php echo $obj->FormGetRadio("momentoatualempresa","Manutenção"); ?> value="Manutenção">
                                    <span>
                                        <b>Manutenção:</b> a empresa busca crescer no seu mercado principal, utilizando mesmos canais. 
                                    </span>
                                </li>
                                <li class="meio">
                                    <input id="momentoatualempresa2" name="momentoatualempresa" type="radio" <?php echo $obj->FormGetRadio("momentoatualempresa","Crescimento"); ?> value="Crescimento">
                                    <span>
                                        <b>Crescimento:</b> a empresa busca crescer e ganhar competitividade ampliando oferta de soluções e canais.
                                    </span>
                                </li>
                                <li class="meio">
                                    <input id="momentoatualempresa3" name="momentoatualempresa" type="radio" <?php echo $obj->FormGetRadio("momentoatualempresa","Startup"); ?> value="Startup">
                                    <span>
                                        <b>Startup:</b> a empresa ainda é considerada uma startup, e busca validação e posicionamento do seu produto no mercado.
                                    </span>
                                </li>
                                <li class="meio">
                                    <input id="momentoatualempresa4" name="momentoatualempresa" type="radio" <?php echo $obj->FormGetRadio("momentoatualempresa","Startup fase de expansão/captação"); ?> value="Startup fase de expansão/captação">
                                    <span>
                                        <b>Startup fase de expansão / captação:</b> a empresa é uma scale-up, tem produto validado, busca expandir negócio seja com capital próprio ou rodada de investimento.
                                    </span>
                                </li>
                                <li class="meio">
                                    <input id="momentoatualempresa5" name="momentoatualempresa" type="radio" <?php echo $obj->FormGetRadio("momentoatualempresa","Recém investida"); ?> value="Recém investida">
                                    <span>
                                        <b>Recém investida:</b> a empresa passou recentemente por rodada de investimento.
                                    </span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </form>
            </div>
            <div id="dadosformrodape" class="rodapeconteudo">
                <div class="area-btn">
                    <a href="javascript:;" class="btn-Voltar" onclick="Voltar()">Voltar</a>
                    <a href="javascript:;" class="btn-Avancar" onclick="SalvarVaga()">Salvar e Avançar</a>
                </div>
            </div>
        </div>
        <div class="textoAjuda cardEstrutura">
            <h2>Perfil do contratante</h2>
            <p>Queremos conhecer melhor o momento atual da sua empresa.</p>
            <p>Todos esses aspectos poderão ser levados em conta na análise do algoritmo de seleção para apresentar a melhor lista de candidatos aderentes ao que você busca.</p>
            <p>Em caso de dúvidas no preenchimento deste formulário você pode nos contatar no <a href="mailto:ajuda@candidatoagora.com.br">ajuda@candidatoagora.com.br</a>. <br/>Retornaremos o contato em breve.</p>
        </div>
    </div>
</section>