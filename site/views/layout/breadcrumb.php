<div class="logo">
    <a href="<?php echo site_url('vaga/dashboard') ?>" data-codigo="VisualVaga">
        <img src="<?php echo URL_Imagem("sistema/logosistema.png") ?>" alt="">
    </a>
</div>
<?php $this->load->view("layout/menu"); ?>
<div class="page-header pull-left">
    <div class="page-title"></div>
</div>
<ul>
    <li class="notificacao">
        <a href="<?php echo site_url("configuracao/notificacao") ?>"><i class="fa fa-bell"></i><ins></ins></a>
    </li>
    <li class="ceditos">
        <a href="<?php echo site_url("configuracao/addcreditos") ?>"><i>$</i><span><?php echo $this->gestao->GetTotalCredito(); ?></span></a>
        <a href="<?php echo site_url("configuracao/addcreditos") ?>" class="btn btn-green">
            <?php echo __("Adicionar"); ?>
        </a>
    </li>
    <li class="cliente">
        <span><?php echo $this->gestao->GetNomeUsuario(); ?></span>
        <a id="topmenu" href="#" onclick="AbrirTopoMenu()">
            <i class="el el-chevron-down"></i>
        </a>
        <ul class="menu">
            <li>
                <h5><?php echo $this->gestao->GetNomeEmpresa(); ?></h5>
            </li>
            <li id="link-notificacao">
                <a href="<?php echo site_url('configuracao/minhaconta') ?>"> Minha conta</a>            
            </li>
            <li id="link-notificacao">
                <a href="<?php echo site_url('configuracao/notificacao') ?>"> Notificações</a>            
            </li>
            <li id="link-add-credito">
                <a href="<?php echo site_url('configuracao/addcreditos') ?>"> Adicionar Credito</a>            
            </li>
            <li>
                <a class="limpa" href="#" onclick="Logout()"> Sair</a>
            </li>
        </ul>
        <img src="<?php echo URL_Imagem("sistema/icone-pessoa.jpg") ?>"/>
    </li>    
</ul>
