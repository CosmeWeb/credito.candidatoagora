<div class="page-header pull-left">
    <div class="page-title"><?php echo $this->gestao->GetDashboard(); ?></div>
</div>
<ol class="breadcrumb page-breadcrumb">
    <?php
	    $ativocrumb = $this->gestao->GetBreadcrumbs("ativo");
	    if(!empty($ativocrumb)):
    ?>
    <li><i class="ion ion-monitor"></i>&nbsp;<a href="<?php echo site_url() ?>">Painel</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i></li>
	<?php
		else:
	?>
    <li><i class="ion ion-monitor"></i>&nbsp;<a href="<?php echo site_url() ?>">Painel</a></li>
    <?php
	    endif;
        $linkcrumb = $this->gestao->GetBreadcrumbs("url");
        if(!empty($linkcrumb)):
	        $titulocrumb = $this->gestao->GetBreadcrumbs("titulo");
    ?>
    <li><a href="<?php echo $linkcrumb; ?>"><?php echo $titulocrumb; ?></a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i></li>
    <?php
        endif;
	    if(!empty($ativocrumb)):
    ?>
    <li class="active"><?php echo $ativocrumb; ?></li>
    <?php
	    endif;
    ?>
</ol>
<div class="clearfix"></div>
