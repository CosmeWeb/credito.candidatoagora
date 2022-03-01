<!DOCTYPE html>
<html lang="pt-BR">
<head><title>Dashboard | Dashboard</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="cache-control" content="no-cache">
    <meta http-equiv="expires" content="Thu, 19 Nov 1900 08:52:00 GMT">
    <!--Loading bootstrap css-->
    <link type="text/css" href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,700italic,800italic,400,700,800">
    <link type="text/css" rel="stylesheet" href="http://fonts.googleapis.com/css?family=Oswald:400,700,300">
    <link type="text/css" rel="stylesheet" href="<?php $this->gestao->printLink(); ?>vendors/jquery-ui-1.10.4.custom/css/ui-lightness/jquery-ui-1.10.4.custom.css">
    <link type="text/css" rel="stylesheet" href="<?php $this->gestao->printLink(); ?>vendors/font-awesome/css/font-awesome.min.css">
    <link type="text/css" rel="stylesheet" href="<?php $this->gestao->printLink(); ?>vendors/bootstrap/css/bootstrap.min.css">
    <!--Loading style vendors-->
    <link type="text/css" rel="stylesheet" href="<?php $this->gestao->printLink(); ?>vendors/animate.css/animate.css">
    <link type="text/css" rel="stylesheet" href="<?php $this->gestao->printLink(); ?>vendors/iCheck/skins/all.css">
    <!--Loading style-->
    <link type="text/css" rel="stylesheet" href="<?php $this->gestao->printLink(); ?>assets/css/themes/style1/pink-blue.css" class="default-style">
    <link type="text/css" rel="stylesheet" href="<?php $this->gestao->printLink(); ?>assets/css/themes/style1/pink-blue.css" id="theme-change" class="style-change color-change">
    <link type="text/css" rel="stylesheet" href="<?php $this->gestao->printLink(); ?>assets/css/style-responsive.css">
    <link rel="shortcut icon" href="images/favicon.ico">
</head>
<body id="signin-page">
<div class="page-form">
    <form action="<?php echo site_url('painel/recuperarsenha/'); ?>" class="form"  method="POST">
        <div class="header-content"><h1><?php echo __("Recuperação de Senha"); ?></h1></div>
        <div class="body-content">
            <div class="form-group">
                <label for="inputUsername" class="control-label">Informe o seu e-mail registado no sistema <span class="require">*</span></label>
                <div class="input-icon right">
                    <i class="fa fa-envelope-o"></i>
                    <input type="text" placeholder="<?php echo __('Seu e-mail'); ?>" name="email" id="email" class="form-control" value="<?php echo $obj->FormGet('email'); ?>" >
                    <?php echo form_error('email', '<div class="alert alert-error msn-error">', '</div>'); ?>
                </div>
            </div>
            <div class="form-group pull-right">
                <button type="submit" class="btn btn-success"><?php echo __("Enviar"); ?>&nbsp;<i class="fa fa-chevron-circle-right"></i></button>
            </div>
            <div class="clearfix"></div>
    </form>
</div>
<script src="<?php $this->gestao->printLink(); ?>assets/js/jquery-1.10.2.min.js"></script>
<script src="<?php $this->gestao->printLink(); ?>assets/js/jquery-migrate-1.2.1.min.js"></script>
<script src="<?php $this->gestao->printLink(); ?>assets/js/jquery-ui.js"></script>
<!--loading bootstrap js-->
<script src="<?php $this->gestao->printLink(); ?>vendors/bootstrap/js/bootstrap.min.js"></script>
<script src="<?php $this->gestao->printLink(); ?>vendors/bootstrap-hover-dropdown/bootstrap-hover-dropdown.js"></script>
<script src="<?php $this->gestao->printLink(); ?>assets/js/html5shiv.js"></script>
<script src="<?php $this->gestao->printLink(); ?>assets/js/respond.min.js"></script>
<script src="<?php $this->gestao->printLink(); ?>vendors/iCheck/icheck.min.js"></script>
<script src="<?php $this->gestao->printLink(); ?>vendors/iCheck/custom.min.js"></script>
<script>//BEGIN CHECKBOX & RADIO
$('input[type="checkbox"]').iCheck({
    checkboxClass: 'icheckbox_minimal-grey',
    increaseArea: '20%' // optional
});
$('input[type="radio"]').iCheck({
    radioClass: 'iradio_minimal-grey',
    increaseArea: '20%' // optional
});
//END CHECKBOX & RADIO
</script>
</body>
</html>