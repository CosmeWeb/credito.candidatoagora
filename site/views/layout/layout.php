<?php
defined('BASEPATH') OR exit('Nenhum acesso de script direto permitido');
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <title> <?php echo $this->gestao->GetTituloSite(); ?></title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="cache-control" content="no-cache">
    <meta http-equiv="expires" content="Thu, 19 Nov 1900 08:52:00 GMT">
    <?php 
      $this->gestao->Hard();
    ?>
</head>
<body class="sidebar-collapsed">    
    <div class="areaconteudo">
        <div class="desktop">
            <div class="title-breadcrumb">
                <?php $this->load->view("layout/breadcrumb"); ?>
            </div>
            <div class="page-content">
            <?php                
                if (isset($page)):
                    $this->load->view($page);
                endif;
            ?>
            </div>
        </div>
    </div>

    <!-- footer start -->
    <footer class="footer">
        
    </footer>
    <div id="modalcadastro">
        <div class="tela">
            <a class="close" href="javascript:;" onclick="CloseLista();">x</a>
            <h3>
                Você pode escolher apenas os setores target ou também empresas dentro dos setores já definidos.
            </h3>
            <div class="box-frm">
                <div class="box-empresa">
                    <div class="filtro">
                        <input id="filtroempresa" name="filtroempresa" type="text" value="" onkeyup="FiltroLista()" >
                        <button type="button" onclick="FiltroLista()">
                            <i class="fa fa-search"></i> Filtro de empresas
                        </button>
                    </div>
                </div>
                <div class="box-candidato">
                    <div id="contenersetores">
                    </div>
                </div>
            </div>
            <div class="caixa-btn">
                <a id="btn-add-empresa" class="ativo" href="javascript:;" onclick="SalvarListaDeEmpresas()">Adicionar empresas</a>
                <a id="btn-add-close" href="javascript:;" onclick="CloseLista()">Fechar</a>
            </div>
        </div>
    </div>    
    <div id="modalcontrato" style="display:none;">
        <div class="tela">
            <a class="close" href="javascript:;" onclick="CloseLista();">x</a>
            <h3>
            Dá uma olhada nos Termos & Condições antes de continuar
            </h3>
            <div class="box-frm">
                <div class="box-empresa">
                    <div class="filtro" style="display: none;">
                        <p>
                        Nos próximos minutos você irá responder algumas perguntas para que possamos entender um pouco mais do momento da sua empresa e alinhar expectativas do que faz mais sentido na seleção de candidatos para a posição que precisa contratar.
                        </p>
                    </div>
                </div>
                <div class="box-candidato">
                    <div id="contenercontrato">
                        <iframe src="<?php echo base_url('assets/doc/contrato-candidatoagora.pdf#view=FitH') ?>" frameborder="0"></iframe>
                    </div>
                </div>
            </div>
            <div class="caixa-btn">
                <a id="btn-add-close-left" href="javascript:;" onclick="CloseLista()">Fechar</a>
                <a id="btn-Acheitar_Condicoes" href="javascript:;" onclick="AcheitarCondicoes()">Atendo às condições e desejo continuar</a>
            </div>
        </div>
    </div>
    <!--/ footer end  -->
    <!-- JS here -->
    <?php 
        $this->gestao->Rodape();
    ?>
</body>
</html>