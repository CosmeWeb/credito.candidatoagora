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
<body class="sidebar-collapsed header-static">
<div>
    <?php
        if ($this->gestao->isNotificacoes()):
            $this->load->view("layout/notificacoes");
        endif;
    ?>
    <!--BEGIN BACK TO TOP--><a id="totop" href="#"><i class="fa fa-angle-up"></i></a><!--END BACK TO TOP-->
    <!--BEGIN TOPBAR-->
    <div id="header-topbar-option-demo" class="page-header-topbar">
        <nav id="topbar" role="navigation" style="margin-bottom: 0; z-index: 2;" class="navbar navbar-default navbar-static-top">
            <?php
                $this->load->view("layout/top-menu");
            ?>
        </nav>
    </div>
    <!--END TOPBAR-->
    <div id="wrapper">
        <!--BEGIN SIDEBAR MENU-->
        <nav id="sidebar" role="navigation" class="navbar-default navbar-static-side">
            <?php
                 $this->load->view("layout/menu");
            ?>
        </nav>
        <!--END SIDEBAR MENU-->
        <!--BEGIN PAGE WRAPPER-->
        <div id="page-wrapper"><!--BEGIN TITLE & BREADCRUMB PAGE-->
            <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
                <?php
                 $this->load->view("layout/breadcrumb");
                ?>
            </div>
            <!--END TITLE & BREADCRUMB PAGE--><!--BEGIN CONTENT-->
            <div class="page-content">
                <?php
                    if (isset($page)):
                        $this->load->view($page);
                    endif;
                ?>
            </div>
            <!--END CONTENT--></div>
        <!--BEGIN FOOTER-->
        <div id="footer">
            <div class="copyright"><?php echo date("Y") ?> © &mu;Admin - Candidato Agora</div>
        </div>
        <!--END FOOTER--><!--END PAGE WRAPPER--></div>
</div>
<?php 
    $this->gestao->Rodape();
?>
</body>
</html>
