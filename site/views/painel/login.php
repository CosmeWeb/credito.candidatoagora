<div class="page-form">
    <div class="area-form">
        <form action="#" class="form"  method="POST">
            <div class="cabeca top150">
                <img src="<?php echo URL_Imagem("sign/logotipo-candidato-agora.png") ?>">
                <h3><?php echo __("Insira os dados para acessar a sua conta."); ?></h3>
            </div>
            <div class="corpo-form">
                <div class="area-group">
                    <input type="text" placeholder="<?php echo __('E-mail'); ?>" autocomplete="off" name="email" id="email" value="<?php echo $email; ?>" >
                </div>
                <div class="area-group">
                    <input type="password" placeholder="<?php echo __('Senha'); ?>" autocomplete="off" name="senha" id="senha" value="<?php echo $senha; ?>">
                </div>
                <div class="area-group m60">
                    <label>
                        <input type="checkbox" name="manterconectado" id="manterconectado" value="Sim">&nbsp; <?php echo __("Manter conectado"); ?>
                    </label>
                    <a href='<?php echo site_url('painel/recuperarsenha/') ?>' class='btn-recuperarsenha'>
                        <?php echo __("Esqueci minha senha"); ?>
                    </a>
                </div>
                <div class="area-group m160">
                    <button type="button" class="botao btn-cinza" onclick="Logar(this)">
                        <?php echo __("Entrar"); ?> <i class="ion ion-loading-a" style="display:none;"></i>
                    </button>
                    <button type="button" class="botao btn-branco" onclick="NovoCadastro()">
                        <?php echo __("Criar conta"); ?>
                    </button>
                    <div class="erro-form">
                        <i class="fa"></i>
                        <span></span>
                        <a href="#" onclick="FecharErro()">X</a>
                    </div>
                </div>
                <a href='<?php echo site_url('painel/politicadeprivacidade/') ?>' target="_blank" class='btn-politica'>
                   <?php echo __("Política de Privacidade de Informação e Termo de Consentimento Responsável"); ?>
                </a>
            </div>
                
        </form>
    </div>
    <div class="img-form">
    </div>
</div>
<script>
function NovoCadastro()
{
    window.location.href = "<?php echo site_url('painel/cadastro/'); ?>"; 
}
function Logar(obj)
{
    var url = GetUrlAcao("api","loginsistema");

    var data = $(obj.form).serialize();

    $.ajax({
        url: url,
        method:'POST',
        data:data,
        beforeSend:function(xhr){
            $('button#btn-cinza i').css('display','block');
        },
        success:function(data){
            if(data.sucesso)
            {
                $('button#btn-cinza i').css('display','none');
                msn = data.mensagem;
                ExibeSucesso(msn);
                setTimeout(function(){location.href=data.link} , 1000); 
            }
            else
            {
                $('button#btn-cinza i').css('display','none');
                msn = data.erro;
                ExibeErro(msn);
            }
        },
        error: function(XHR, textStatus, errorThrown){
            $('button#btn-cinza i').css('display','none');
            msn = "<?php echo __("Falha ao fazer o login no sistema.");?>";
            alert(msn);
        }
    });
}
function MansagemMobile()
{
    msn = "<?php echo __("Recomendamos o uso do sistema em desktop para que você tenha uma melhor experiência na visualização dos dados.");?>";
    titulo = "<?php echo __("Atenção!");?>";
    alerta(msn, "warning", titulo);
}
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
    AjusteDeTela();
    $("body").css("overflow", "hidden");
    <?php
    if(isMobile()):
    ?>
    MansagemMobile();
    <?php
    endif;
    ?>
    $( window ).resize(function() {
        AjusteDeTela();
    });
});
</script>