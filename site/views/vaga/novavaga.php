<section class="container">
    <div class="telaestrutura">
        <div class="painelPrincipal">
            <form id="frmtermo" action="<?php echo site_url('vaga/dadosdavagaexpectativa') ?>" method="POST">
                <div class="boasVendas cardEstrutura">
                    <h2>Olá! Vamos cadastrar uma nova vaga</h2>
                    <p>Nos próximos minutos você irá responder algumas perguntas para que possamos entender um pouco mais do momento da sua empresa e alinhar expectativas do que faz mais sentido na seleção de candidatos para a posição que precisa contratar.</p>
                </div>
                <div class="termosCondicoes cardEstrutura">
                    <h2>Termos e condições</h2>
                    <p><b>Leia com atenção</b> as informações abaixo. Você precisa se encaixar em <b>todas</b> elas</p>
                    <div class="info">
                        <i class="fa fa-check"></i>
                        <span>Sou um dos membros da equipe do RH/seleção e estou ciente dos eventuais custos da utilização desta plataforma.</span>
                    </div>
                    <div class="info">
                        <i class="fa fa-check"></i>
                        <span>As informações fornecidas na abertura de nova vaga são de carater confidencial e de uso exclusivo para processar o algoritimo de seleção desta plataforma.</span>
                    </div>
                    <div class="info">
                        <i class="fa fa-check"></i>
                        <span>Sou responsável pela veracidade das informações fornecidas e qualquer alteração, poderá ser reprocessada e acarretar custos.</span>
                    </div>
                    <div class="termosAprovar">
                        <div class="checkbox">
                            <input type="checkbox" id="declarado" name="declarado" value="Sim">
                            <label for="declarado"><span>Declaro que li e tenho ciência que me enquadro em todas as condições acima.</span></label>
                        </div>
                        <div class="checkbox">
                            <input type="checkbox" id="autorizado" name="autorizado" value="Sim">
                            <label for="autorizado"><span>Autorizo o acesso e uso dos dados fornecidos para processar algoritimo de seleção e apresentar os melhores candidatos.</span></label>
                        </div>
                    </div>
                    <div class="termosrodape">
                        <a href="#" class="buttonTerm">Atendo às condições e desejo continuar</a>
                    </div>
                </div>
            </form>
        </div>
        <div class="textoAjuda cardEstrutura">
            <h2>Transparência é tudo</h2>
            <p>Para seguir com o uso da plataforma você precisa estar de acordo com nossos termos e condições. Prezamos pela transparência como um dos nossos principais valores. </p>
            <p>Em caso de dúvidas no preenchimento deste formulário você pode nos contatar no <a href="mailto:ajuda@candidatoagora.com.br">ajuda@candidatoagora.com.br</a>.<br/>Retornaremos o contato em breve.</p>
        </div>
    </div>
</section>
<script>
function ShowListaContrato()
{
    $("#modalcontrato").css("display","block");
    AjustaModal();
    $('html, body').animate({ scrollTop: 0 }, 800);
}
function CloseLista()
{
    $("#modalcontrato").css("display","none");
}
function AcheitarCondicoes()
{
    $("#modalcontrato").css("display","none");
	$("#frmtermo").get(0).submit();
}
function AjustaModal()
{
    let altura = $("#modalcontrato .tela").outerHeight( true );
    let alturabody = $("body").outerHeight( true );
    altura += 50;
    if(altura > alturabody)
        $("#modalcontrato").css("height", altura+"px");
    else
        $("#modalcontrato").css("height", "100%");
    console.log(altura);
}
$(function() {
    $('a.buttonTerm').on('click', function (e) {
        // prevenir comportamento normal do link
        e = e || window.event;
        e.preventDefault();
        let declarado = $("#frmtermo #declarado:checked").length;
        let autorizado = $("#frmtermo #autorizado:checked").length;
        let msn = "";
        if(Vazio(declarado))
        {
            msn = "Você deve declarar que têm ciência de todos termos e condições para avançar no cadastro da vaga";
            alerta(msn, "warning", "Atenção!");
            return false;
        }
        if(Vazio(autorizado))
        {
            msn = "Para prosseguir você precisa estar de acordo com todas as condições de uso.";
            alerta(msn, "warning", "Atenção!");
            return false;
        }
        ShowListaContrato();
        return false;
    });
});
</script>