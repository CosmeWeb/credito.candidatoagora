<!DOCTYPE html>
<html>
<head>
<link href="<?php echo $links; ?>assets/css/main_rastreio.css" rel="stylesheet">
<link href="<?php echo $links; ?>vendors/fonte/font-awesome-4.3.0/css/font-awesome.min.css" rel="stylesheet">
<link href="<?php echo $links; ?>vendors/fonte/elusive-icons-2.0.0/css/elusive-icons.min.css" rel="stylesheet">
<link href="<?php echo $links; ?>vendors/fonte/ionic/css/ionic.css" rel="stylesheet">
<script src="<?php echo $links; ?>assets/js/jquery-1.10.2.min.js"></script>
<script src="<?php echo $links; ?>assets/js/jquery-migrate-1.2.1.min.js"></script>
<script src="<?php echo $links; ?>vendors/jquery-ui-1.11.4.custom/jquery-ui.min.js"></script>
<script src="<?php echo $links; ?>assets/js/mainprint.js"></script>
</head>
<body>
    <div class="corpo">
        <table class="cabecario">
            <tr>
                <td style="width: 20%;">
                    <img   src="<?php echo base_url('assets/images/avatar/logosistema.jpg'); ?>"/>
                </td>
                <td style="width: 2%;">
                    &nbsp;
                </td>
                <td style="width:78%;">
                    <table class="cabpainel">
                        <tr><td class="titulo"><h3><b>Relatório acesso dos clientes</b></h3></td></tr>
                        <tr><td class="titulo">
                            <b class="h3">Período:</b>
                            <label>Inicio</label>
                            <input type="date" name="inicio" id="inicio" value="">
                            <label>Final</label>
                            <input type="date" name="final" id="final" value="">
                        </td></tr>
                        <tr><td class="titulo"><h3 style="position: relative;width: 60%;float: left;"><b>Emitido em:</b> <?php echo date("d/m/Y"); ?></h3>
                        <button type="button" onclick="Pesquisar();"><i class="fa fa-search"></i> Pesquisa</button>
                    </td></tr>
                    </table>
                </td>
            </tr>
        </table>
        <table class="painel">
            <tr>
                <td class="titulo">Histórico de tempo estimado de acesso dos clientes</td>
            </tr>
        </table>
        <div class="loading">
        <i class="ion ion-loading-b"></i> pesquisando...
        </div>
        <div class="paineltab">
            <?php
            for($i = 0; $i < 27; $i++): 
            ?>
            <div class="caixa">
                <div class="empresa">
                    VLG Investimentos
                </div>
                <div class="cliente">
                    <b>Cliente: </b>Claudia
                </div>
                <div class="ultimoacesso">
                    <span>Total de acesso</span><samp>5h:23m</samp>
                </div>
                <div class="acesso">
                    <span>24/02/2021</span><samp>1h:23m</samp>
                </div>
                <div class="acesso">
                    <span>25/02/2021</span><samp>3h:23m</samp>
                </div>
                <div class="acesso">
                    <span>26/02/2021</span><samp>4h:23m</samp>
                </div>
                <div class="acesso">
                    <span>27/02/2021</span><samp>2h:33m</samp>
                </div>
                <div class="acesso">
                    <span>30/02/2021</span><samp>1h:23m</samp>
                </div>
            </div>
            <?php
            endfor;
            ?>
        </div>
    </div>
</body>
</html>
<script>
    var pais = '<?php echo $this->gestao->GetPaisPadrao(); ?>';
    
    function AdicionarCaixas(lista = null, posicao = 0)
    {        
        let html = '';
        let nome = '.paineltab';
        if(Vazio(lista))
            return;
        lista.forEach(item => {
            let acesso = "";
            if(!Vazio(item.dias))
            {
                item.dias.forEach(dia => {
                    acesso = `<div class="acesso">
                        <span>${dia.dia}</span><samp>${dia.tempototal}</samp>
                    </div>`+acesso;
                });
            }
            if(Vazio(item.empresa))
                item.empresa = 'Empresa não declarada';
            html += `<div class="caixa">
                <div class="empresa">
                ${item.empresa}
                </div>
                <div class="cliente">
                    <b>Cliente: </b>${item.nome}
                </div>
                <div class="ultimoacesso">
                    <span>Total de acesso</span><samp>${item.tempototal}</samp>
                </div>
                ${acesso}
            </div>`;
        });
        if(Vazio(posicao))
        {
            $(nome).html(html);
        }
        else
        {
            $(nome).append(html);
        }
        return;
    };
    function Pesquisar(posicao = 0, total = 0){

        let url = GetUrlAcao("rastreio","listacockpitrastreio");

        let data = {
            "posicao": posicao,
            "total": total,
           // "idcliente": 14,
            "inicio": $("#inicio").val(),
            "final": $("#final").val(),
        };        
        $.ajax({
            url: url,
            method:'POST',
            data:data,
            beforeSend:function(xhr){
                $(".loading").css("display","block");
                if(Vazio(posicao))
                    $(".paineltab").css("display","none");
            },
            success:function(data){
                if(data.sucesso)
                {
                    AdicionarCaixas(data.lista, posicao);
                    if(data.finalizado == true)
                    {
                        if($(".paineltab").css("display") == "none")
                            $(".paineltab").css("display","flex");
                        $(".loading").css("display","none");
                    }
                    else
                    {
                        $(".paineltab").css("display","flex");
                        Pesquisar(data.posicao, data.total);
                    }
                }
                else
                {
                    let msn = data.erro;
                    alert(msn);
                }
            },
            error: function(XHR, textStatus, errorThrown){
                let msn = "<?php echo __("Falha na importação dos dados.");?>";
                alert(msn);
            }
        });
    }
    $(document).ready(function() {
        Pesquisar();
    });
</script>