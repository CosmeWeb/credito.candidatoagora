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
<body>
    <section id="corpo">
        <?php
            if (isset($page)):
                $this->load->view($page);
            endif;
        ?>
    </section>
    <!-- JS here -->
    <?php 
        $this->gestao->Rodape();
    ?>
</body>
</html>