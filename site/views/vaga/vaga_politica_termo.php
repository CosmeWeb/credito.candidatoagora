<div id="container">
    <form id="frmtermo" action="<?php echo site_url('vaga/dadosdacontratante') ?>" method="POST">
        <div class="tituloconteudo">
            <h1>Cadastro de nova vaga</h1>
            <svg id="progress-steps" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 884 38">
                <g id="step3" transform="translate(577.819)">
                    <g id="Ellipse" transform="translate(0.181)" fill="none" stroke="#a5a4bf" stroke-width="2">
                    <circle cx="19" cy="19" r="19" stroke="none"/>
                    <circle cx="19" cy="19" r="18" fill="none"/>
                    </g>
                    <text id="_3" data-name="3" transform="translate(19.181 24)" fill="#a5a4bf" stroke="rgba(0,0,0,0)" stroke-miterlimit="10" stroke-width="1" font-size="16" font-family="SourceSansPro-Bold, Source Sans Pro" font-weight="700"><tspan x="-4.256" y="0">3</tspan></text>
                </g>
                <g id="step3-2" data-name="step3" transform="translate(320.603)">
                    <g id="Ellipse-2" data-name="Ellipse" transform="translate(0.397)" fill="none" stroke="#a5a4bf" stroke-width="2">
                    <circle cx="19" cy="19" r="19" stroke="none"/>
                    <circle cx="19" cy="19" r="18" fill="none"/>
                    </g>
                    <text id="_2" data-name="2" transform="translate(19.397 24)" fill="#a5a4bf" stroke="rgba(0,0,0,0)" stroke-miterlimit="10" stroke-width="1" font-size="16" font-family="SourceSansPro-Bold, Source Sans Pro" font-weight="700"><tspan x="-4.256" y="0">2</tspan></text>
                </g>
                <g id="step3-3" data-name="step3" transform="translate(49.001)">
                    <g id="Ellipse-3" data-name="Ellipse" transform="translate(-0.001)" fill="none" stroke="#a5a4bf" stroke-width="2">
                    <circle cx="19" cy="19" r="19" stroke="none"/>
                    <circle cx="19" cy="19" r="18" fill="none"/>
                    </g>
                    <text id="_1" data-name="1" transform="translate(18.999 24)" fill="#a5a4bf" font-size="16" font-family="SourceSansPro-Bold, Source Sans Pro" font-weight="700"><tspan x="-4.256" y="0">1</tspan></text>
                </g>
                <g id="step4" transform="translate(846)">
                    <g id="Ellipse-4" data-name="Ellipse" fill="none" stroke="#a5a4bf" stroke-width="2">
                    <circle cx="19" cy="19" r="19" stroke="none"/>
                    <circle cx="19" cy="19" r="18" fill="none"/>
                    </g>
                    <text id="_4" data-name="4" transform="translate(19 24)" fill="#a5a4bf" stroke="rgba(0,0,0,0)" stroke-miterlimit="10" stroke-width="1" font-size="16" font-family="SourceSansPro-Bold, Source Sans Pro" font-weight="700"><tspan x="-4.256" y="0">4</tspan></text>
                </g>
                <rect id="Rectangle_1763" data-name="Rectangle 1763" width="234" height="2" transform="translate(87 18)" fill="#a5a4bf" opacity="0.5"/>
                <rect id="Rectangle_1767" data-name="Rectangle 1767" width="49" height="2" transform="translate(0 18)" fill="#116cdd"/>
                <rect id="Rectangle_1765" data-name="Rectangle 1765" width="219" height="2" transform="translate(359 18)" fill="#a5a4bf" opacity="0.5"/>
                <rect id="Rectangle_1766" data-name="Rectangle 1766" width="220" height="2" transform="translate(616 18)" fill="#a5a4bf" opacity="0.5"/>
            </svg>
        </div>
        <div id="termos_e_condicoes" class="corpoconteudo">
            <div class="texto">
                <h2>Termos e condi????es</h2>
                <p><b>Leia com aten????o</b>??as informa????es abaixo. Voc?? precisa se encaixar em??<b>todas</b>??elas.</p>
                <ul>
                    <li>
                        <i class="fa fa-check"></i>
                        <span>Sou um dos membros da equipe do RH/sele????o e estou ciente dos eventuais custos da utiliza????o desta plataforma.</span>
                    </li>
                    <li>
                        <i class="fa fa-check"></i>
                        <span>As informa????es fornecidas na abertura de nova vaga s??o de car??ter confidencial e de uso exclusivo para processar o algoritmo de sele????o desta plataforma.</span>
                    </li>
                    <li>
                        <i class="fa fa-check"></i>
                        <span>Sou respons??vel pela veracidade das informa????es fornecidas e qualquer altera????o, poder?? ser reprocessada e acarretar custos.</span>
                    </li>
                    <li>
                        <input id="declarado" name="declarado" type="checkbox" value="Sim">
                        <span>Declaro que li e tenho ci??ncia que me enquadro em todas as condi????es acima.</span>
                    </li>
                    <li>
                        <input id="autorizado" name="autorizado" type="checkbox" value="Sim">
                        <span>Autorizo o acesso e uso dos dados fornecidos para processar algoritmo de sele????o e apresentar os melhores candidatos.</span>
                    </li>
                </ul>
            </div>
        </div>
        <div id="termos_e_condicoesrodape" class="rodapeconteudo">
            <a href="#" onclick="EnviarPoliticaTermo()">Atendo ??s condi????es e desejo continuar</a>    
        </div>
    </form>
</div>