<section class="container">
    <div class="telaestrutura">
        <div class="painelPrincipal">
            <div class="cardconteudo">
                <form id="frmvaga" action="<?php echo site_url('vaga/dadosdacontratante') ?>" method="POST">
                    <input id="idvaga" name="idvaga" type="hidden" value="<?php echo $obj->idvaga; ?>">
                    <input id="idcliente" name="idcliente" type="hidden" value="<?php echo $obj->idcliente; ?>">
                    <input id="declarado" name="declarado" type="hidden" value="<?php echo $obj->declarado; ?>">
                    <input id="autorizado" name="autorizado" type="hidden" value="<?php echo $obj->autorizado; ?>">
                    <input id="tempocontratacao" name="tempocontratacao" type="hidden" value="<?php echo $obj->tempocontratacao; ?>">
                    <input id="fasecadastro" name="fasecadastro" type="hidden" value="1">
                    <div id="dadosform" class="corpoconteudo">
                        <div class="texto">
                            <h2>Personalize a sua experiência!</h2>
                            <div class="caixa">
                                <p>Você deu o primeiro passo para abrir uma nova vaga. A ideia é reduzir o trabalho transacional e aumentar a eficiência do tempo do time de recrutamento interno na fase de triagem e seleção, tornando o processo mais inteligente.</p>
                            </div>
                            <div class="caixa">
                            <input id="titulodavaga" name="titulodavaga" type="text" placeholder="Digite o título da vaga" value="<?php echo $obj->titulodavaga; ?>">
                            </div>
                            <div class="caixa">
                                <p>A gente sabe o quanto é importante a gestão do seu tempo. Por isso, queremos saber: quando você pretende contratar o candidato para esta vaga?</p>
                            </div>
                            <div class="caixa caixaicone">                                
                                <a href="javascript:;" class="quadro <?php echo $obj->CheckTempoContratacao('Em até 30 dias', false); ?>" data-val="Em até 30 dias">
                                    <img src="<?php echo base_url('assets/img/sistema/ummes_novo.png') ?>"/>
                                    <span>
                                    Em até 30 dias
                                    </span>
                                </a>
                                <a href="javascript:;" class="quadro <?php echo $obj->CheckTempoContratacao('Em até 3 meses', false); ?>" data-val="Em até 3 meses">
                                    <img src="<?php echo base_url('assets/img/sistema/tresmeses_novo.png') ?>"/>
                                    <span>
                                    Em até 3 meses
                                    </span>
                                </a>
                                <a href="javascript:;" class="quadro <?php echo $obj->CheckTempoContratacao('Não tenho previsão', false); ?>" data-val="Não tenho previsão">
                                    <img src="<?php echo base_url('assets/img/sistema/semmeses_novo.png') ?>"/>
                                    <span>
                                    Não tenho previsão
                                    </span>
                                </a>
                            </div>
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
            <h2>Otimize o seu processo de busca!</h2>
            <p>Quanto mais completa e objetiva forem as suas respostas a seguir, maior a probabilidade do nosso algoritmo de seleção encontrar candidatos alinhados com o que você busca.</p>
            <p>Vamos juntos nessa!</p>
            <p>Em caso de dúvidas no preenchimento deste formulário você pode nos contatar no <a href="mailto:ajuda@candidatoagora.com.br">ajuda@candidatoagora.com.br</a>. <br/>Retornaremos o contato em breve.</p>
        </div>
    </div>
</section>
<script>
    $(function() {
        $(".caixa a.quadro").click(function() {
            let valor = $(this).data("val");
            $(".caixa a.ativo").removeClass("ativo");
            $("#frmvaga #tempocontratacao").val(valor);
            $( this ).addClass("ativo");
        });
    });
</script>


