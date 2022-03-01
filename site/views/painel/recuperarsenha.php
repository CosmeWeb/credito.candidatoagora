<div class="page-form">
    <div class="area-form">
        <form action="#" class="form"  method="POST">
            <div class="cabeca top150">
                <img src="<?php echo URL_Imagem("sign/logotipo-candidato-agora.png") ?>">
                <h3><?php echo __("Insira o seu e-mail e nós lhe enviaremos as<br/> instrução para alterar a sua senha."); ?></h3>
            </div>
            <div class="corpo-form">
                <div class="area-group">
                    <input type="text" placeholder="<?php echo __('E-mail'); ?>" name="email" id="email" value="<?php echo $email; ?>" >
                </div>
                <div class="area-group m160">
                    <button type="button" class="botao btn-cinza-enviar">
                        <?php echo __("Enviar"); ?>
                    </button>
                    <div class="erro-form">
                    </div>
                </div>
                <a href='<?php echo site_url('painel/politicadeprivacidade/') ?>' target="_blank" class='btn-politica'>
                   <?php echo __("Política de Privacidade de Informação e Termo de Consentimento Responsável"); ?>
                </a>
            </div>
                
        </form>
    </div>
    <div class="img-form-senha">
    </div>
</div>
<script>
function AjusteDeTela()
{
    let altura = window.innerHeight;
    let areaAltura = $("#corpo .page-form").outerHeight( true );
    let meio = 0;
    let aux = 0;
    if(altura > areaAltura)
    {
        meio = (altura - areaAltura) / 2;
        aux = parseInt($("#corpo .top150").css('margin-top'));
        aux += meio;
        $("#corpo .top150").css('margin-top', aux + "px");

        aux = parseInt($("#corpo .m160").css('margin-bottom'));
        aux += meio + 1;
        $("#corpo .m160").css('margin-bottom', aux + "px");
    }
}
$(function() {    
    $("body").css("overflow", "hidden");
    $( window ).resize(function() {
        AjusteDeTela();
    });
});
</script>