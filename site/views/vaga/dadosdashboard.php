<section class="container">
    <div class="telaestrutura">
        <div class="painelPrincipal">
            <div class="boasVindas cardEstrutura">
                <h2>Vamos avançar no seu cadastro da nova vaga!</h2>
                <p>Segmentamos o cadastro de uma nova vaga em 6 aspectos para facilitar para você. Todas as informações são importantes para a eficiência do nosso algoritmo de seleção.</p>
            </div>
            <div class="listaCards">
                <div class="cardsQuest cardEstrutura" data-url="dadosdacontratante" data-id="<?php echo $obj->idvaga; ?>" name="<?php echo $obj->CheckFase(1); ?>">
                    <h2>1. Dados do contratante</h2>
                    <div>
                        <img src="<?php echo base_url('assets/img/sistema/dados_contratante.png') ?>">
                        <span></span>
                    </div>
                </div>
                <div class="cardsQuest cardEstrutura" data-url="dadosdacandidato" data-id="<?php echo $obj->idvaga; ?>" name="<?php echo $obj->CheckFase(2); ?>">
                    <h2>2. Informações sobre a vaga</h2>
                    <div>
                        <img src="<?php echo base_url('assets/img/sistema/informacao_sobre_vaga.png') ?>">
                        <span></span>
                    </div>
                </div>
                <div class="cardsQuest cardEstrutura" data-url="dadosdacandidato" data-id="<?php echo $obj->idvaga; ?>" name="<?php echo $obj->CheckFase(3); ?>">
                    <h2>3. Perfil das empresas foco da busca</h2>
                    <div>
                        <img src="<?php echo base_url('assets/img/sistema/perfil_empresas.png') ?>">
                        <span></span>
                    </div>
                </div>
                <div class="cardsQuest cardEstrutura" data-url="dadosdavagasetor" data-id="<?php echo $obj->idvaga; ?>" name="<?php echo $obj->CheckFase(4); ?>">
                    <h2>4. Setores target</h2>
                    <div>
                        <img src="<?php echo base_url('assets/img/sistema/setores_target.png') ?>">
                        <span></span>
                    </div>
                </div>
                <div class="cardsQuest cardEstrutura" data-url="dadosdavagaempresa" data-id="<?php echo $obj->idvaga; ?>" name="<?php echo $obj->CheckFase(5); ?>">
                    <h2>5. Empresas target</h2>
                    <div>
                        <img src="<?php echo base_url('assets/img/sistema/perfil_empresas.png') ?>">
                        <span></span>
                    </div>
                </div>
                <div class="cardsQuest cardEstrutura" data-url="dadosdavagaempresaexcluir" data-id="<?php echo $obj->idvaga; ?>" name="<?php echo $obj->CheckFase(6); ?>">
                    <h2>6. Empresas para desconsiderar na busca</h2>
                    <div>
                        <img src="<?php echo base_url('assets/img/sistema/empresas_desconsiderar.png') ?>">
                        <span></span>
                    </div>
                </div>
            </div>
            <?php
            if($obj->TemUmfaseConcluido()):
            ?>
            <a href="<?php echo site_url('vaga/dadosdavagafinal/'.$obj->idvaga); ?>" class="btn-Finalizar-cadastro">
                <i class="far fa-play-circle"></i>
                Finalizar cadastro da vaga
            </a>
            <a href="<?php echo site_url('vaga/dadosdavagaresumo/'.$obj->idvaga); ?>" class="btn-Visualizar-Resumo">
                <i class="fa fa-th-list"></i>
                Visualizar resumo da vaga
            </a>
            <?php
            endif;
            ?>
        </div>
        <div class="textoAjuda cardEstrutura" style="height:auto;">
            <h2>Entendimento da demanda</h2>
            <p>Essa é a etapa que podemos entender melhor o seu negócio e a sua demanda de contratação. Para nós, esta é a etapa mais importante de todo o fluxo!<br/>
            Queremos aprender com você quais critérios, setores, empresas melhor funcionam na estratégia de contratação dessa vaga ou para a sua empresa.</p>
            <p>Todos esses aspectos poderão ser levados em conta na análise do algoritmo de seleção para apresentar a melhor lista de candidatos aderentes ao que você busca.</p>
            <p>Em caso de dúvidas no preenchimento deste formulário você pode nos contatar no <a href="mailto:ajuda@candidatoagora.com.br">ajuda@candidatoagora.com.br</a>. <br/>Retornaremos o contato em breve.</p>
        </div>
    </div>
</section>
<script>
$(function() {
    $(".listaCards .cardsQuest").click(function() {
        let url = $(this).data("url");
        let id = $(this).data("id");
        url = GetDominio('index.php/vaga/'+url+'/'+id);
        window.location.assign(url);
    });
});
</script>
