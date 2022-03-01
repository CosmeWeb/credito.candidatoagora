<div class="page-form">
    <div class="area-form">
        <form action="#" class="form"  method="POST">
            <div class="cabeca top100">
                <img src="<?php echo URL_Imagem("sign/logotipo-candidato-agora.png") ?>">
                <h3><?php echo __("Preencha os campos para criar a sua conta."); ?></h3>
            </div>
            <div class="corpo-form">
            <div class="area-group">
                    <input type="text" placeholder="<?php echo __('Empresa'); ?>" name="empresa" id="empresa" value="<?php echo $empresa; ?>" >
                </div>
                <div class="area-group">
                    <input type="text" placeholder="<?php echo __('Nome'); ?>" name="nome" id="nome" value="<?php echo $nome; ?>" >
                </div>
                <div class="area-group">
                    <input type="text" placeholder="<?php echo __('E-mail'); ?>" name="email" id="email" value="<?php echo $email; ?>" >
                </div>
                <div class="area-group">
                    <input type="password" placeholder="<?php echo __('Senha'); ?>" name="senha" id="senha" value="<?php echo $senha; ?>">
                </div>
                <div class="area-group">
                    <input type="password" placeholder="<?php echo __('Confirmar senha'); ?>" name="confirmarsenha" id="confirmarsenha" value="<?php echo $confirmarsenha; ?>">
                </div>
                <div class="area-group m60">
                    <label class="w100">
                        <input type="checkbox" name="concordo" id="concordo" value="Sim">&nbsp; Eu concordo com a <a href='<?php echo site_url('painel/politicadeprivacidade/') ?>' target="_blank" class='btn-politica-inline'>Política de Privacidade de Informação</a> e <a href='<?php echo site_url('painel/politicadeprivacidade/') ?>' target="_blank" class='btn-politica-inline'>Termo de Consentimento</a> Responsável
                    </label>
                </div>
                <div class="area-group m160">
                    <button type="button" class="botao btn-prosseguir" onclick="CadastroCliente(this)">
                        <?php echo __("Prosseguir"); ?> <i class="ion ion-loading-a" style="display:none;"></i>
                    </button>
                    <div class="erro-form">
                        <i class="fa"></i>
                        <span></span>
                        <a href="#" onclick="FecharErro()">X</a>
                    </div>
                </div>
                
            </div>
                
        </form>
    </div>
    <div class="img-form-cadastro">
    </div>
</div>
<script>
function CadastroCliente(obj)
{
    var url = GetUrlAcao("api","salvardadoscliente");

    var data = $(obj.form).serialize();

    $.ajax({
        url: url,
        method:'POST',
        data:data,
        beforeSend:function(xhr){
            $('button#btn-prosseguir i').css('display','block');
        },
        success:function(data){
            if(data.sucesso)
            {
                $('button#btn-prosseguir i').css('display','none');
                msn = data.mensagem;
                ExibeSucesso(msn);
                setTimeout(function(){location.href=data.link} , 5000); 
            }
            else
            {
                $('button#btn-prosseguir i').css('display','none');
                msn = data.erro;
                ExibeErro(msn);
            }
        },
        error: function(XHR, textStatus, errorThrown){
            $('button#btn-prosseguir i').css('display','none');
            msn = "<?php echo __("Falha ao salvas os dados do cliente.");?>";
            alert(msn);
        }
    });
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
    $( window ).resize(function() {
        AjusteDeTela();
    });
});
</script>