<div class="sidebar-collapse menu-scroll">
    <ul id="side-menu" class="nav">
        <li class="user-panel">
            <div class="thumb">
            <img src="<?php echo GetColaborador()->GetAvatar(); ?>" alt="" class="img-circle"/>
            </div>
            <div class="info"><p><?php echo $this->session->userdata('nome'); ?></p>
                <ul class="list-inline list-unstyled">
                <li><a href="<?php echo site_url('colaborador/editar/'.$this->session->userdata('idcolaborador')) ?>" data-hover="tooltip" title="Profile"><i class="fa fa-user"></i></a></li>
                <li><a href="<?php echo site_url('painel/logout') ?>" data-hover="tooltip" title="Logout"><i class="fa fa-sign-out"></i></a></li>
                </ul>
            </div>
            <div class="clearfix"></div>
        </li>
        <li<?php echo $this->gestao->MenuModulo('painel') ?>>
            <a href="<?php echo site_url('') ?>">
                <i class="fa fa-area-chart fa-fw">
                    <div class="icon-bg bg-orange"></div>
                </i>
                <span class="menu-title"><?php echo __("Painel"); ?></span>
            </a>
        </li>
	    <?php
		    if(TemAcesso(array('Administrador'))):
	    ?>
        <li<?php echo $this->gestao->MenuModulo(array('colaborador')) ?>>
            <a href="#">
                <i class="fa fa-group fa-fw"><div class="icon-bg bg-pink"></div></i>
                <span class="menu-title"><?php echo __("colaboradores"); ?></span>
                <span class="fa arrow"></span>
            </a>
            <ul class="nav nav-second-level">
                <li<?php echo $this->gestao->Menufuncao('colaborador', 'editar') ?>>
                    <a href="<?php echo site_url('colaborador/editar/0') ?>">
                        <i class="fa fa-user-plus"></i>
                        <span class="submenu-title"><?php echo __("Novo colaborador"); ?></span>
                    </a>
                </li>
                <li<?php echo $this->gestao->Menufuncao('colaborador', 'listar') ?>>
                    <a href="<?php echo site_url('colaborador/listar') ?>">
                        <i class="fa fa-th-list"></i>
                        <span class="submenu-title"><?php echo __("Listar"); ?></span>
                    </a>
                </li>
            </ul>
        </li>
        <?php
            endif;
        ?>
	    <?php
		    if(TemAcesso(array('Administrador'))):
	    ?>
        <li<?php echo $this->gestao->MenuModulo(array('configuracao', 'cargo'=>array('gerartermos','gerarsubarea'))); ?>>
            <a href="#">
                <i class="fa fa-cog fa-fw"><div class="icon-bg bg-pink"></div></i>
                <span class="menu-title"><?php echo __("Configurações"); ?></span>
                <span class="fa arrow"></span>
            </a>
            <ul class="nav nav-second-level">
                <li<?php echo $this->gestao->Menufuncao('configuracao', 'listar') ?>>
                    <a href="<?php echo site_url('configuracao/listar') ?>">
                        <i class="fa fa-gears"></i>
                        <span class="submenu-title"><?php echo __("Configurações do sistema"); ?></span>
                    </a>
                </li>
            </ul>
        </li>
        <?php
            endif;
        ?>        
	    <?php
		    if(TemAcesso(array('Administrador'))):
	    ?>
        <li<?php echo $this->gestao->MenuModulo(array('pais','estado','cidade')) ?>>
            <a href="#">
                <i class="ion ion-android-earth fa-fw"><div class="icon-bg bg-pink"></div></i>
                <span class="menu-title"><?php echo __("Cidade"); ?></span>
                <span class="fa arrow"></span>
            </a>
            <ul class="nav nav-second-level">
                <li<?php echo $this->gestao->Menufuncao('pais', 'listar') ?>>
                    <a href="<?php echo site_url('pais/listar') ?>">
                        <i class="fa fa-th-list"></i>
                        <span class="submenu-title"><?php echo __("Lista de Pais"); ?></span>
                    </a>
                </li>
                <li<?php echo $this->gestao->Menufuncao('pais', 'editar') ?>>
                    <a href="<?php echo site_url('pais/editar/0') ?>">
                        <i class="el el-globe"></i>
                        <span class="submenu-title"><?php echo __("Novo pais"); ?></span>
                    </a>
                </li>
                <li<?php echo $this->gestao->Menufuncao('estado', 'listar') ?>>
                    <a href="<?php echo site_url('estado/listar') ?>">
                        <i class="fa fa-th-list"></i>
                        <span class="submenu-title"><?php echo __("Lista de Estado"); ?></span>
                    </a>
                </li>
                <li<?php echo $this->gestao->Menufuncao('estado', 'editar') ?>>
                    <a href="<?php echo site_url('estado/editar/0') ?>">
                        <i class="el el-globe"></i>
                        <span class="submenu-title"><?php echo __("Novo Estado"); ?></span>
                    </a>
                </li>
                <li<?php echo $this->gestao->Menufuncao('cidade', array('listar','verificarcoordenadas')) ?>>
                    <a href="<?php echo site_url('cidade/listar') ?>">
                        <i class="fa fa-th-list"></i>
                        <span class="submenu-title"><?php echo __("Lista de Cidade"); ?></span>
                    </a>
                </li>
                <li<?php echo $this->gestao->Menufuncao('cidade', 'editar') ?>>
                    <a href="<?php echo site_url('cidade/editar/0') ?>">
                        <i class="el el-globe"></i>
                        <span class="submenu-title"><?php echo __("Nova Cidade"); ?></span>
                    </a>
                </li>
            </ul>
        </li>
        <?php
            endif;
        ?>               
	    <?php
		    if(TemAcesso(array('Administrador'))):
	    ?>
        <li<?php echo $this->gestao->MenuModulo(array('setor','area','subarea','nivel','nacionalidade','tamanho','cargo','empresa')) ?>>
            <a href="#">
                <i class="fa fa-gears fa-fw"><div class="icon-bg bg-pink"></div></i>
                <span class="menu-title"><?php echo __("Gestão"); ?></span>
                <span class="fa arrow"></span>
            </a>
            <ul class="nav nav-second-level">
                <li<?php echo $this->gestao->Menufuncao('setor', array('listar', 'editar')) ?>>
                    <a href="<?php echo site_url('setor/listar') ?>">
                        <i class="fa fa-th-list"></i>
                        <span class="submenu-title"><?php echo __("Lista de Setores"); ?></span>
                    </a>
                </li>
                <li<?php echo $this->gestao->Menufuncao('area', array('listar', 'editar')) ?>>
                    <a href="<?php echo site_url('area/listar') ?>">
                        <i class="fa fa-th-list"></i>
                        <span class="submenu-title"><?php echo __("Lista de Áreas"); ?></span>
                    </a>
                </li>
                <li<?php echo $this->gestao->Menufuncao('subarea', array('listar', 'editar')) ?>>
                    <a href="<?php echo site_url('subarea/listar') ?>">
                        <i class="fa fa-th-list"></i>
                        <span class="submenu-title"><?php echo __("Lista de Subárea"); ?></span>
                    </a>
                </li>
                <li<?php echo $this->gestao->Menufuncao('nivel', array('listar', 'editar')) ?>>
                    <a href="<?php echo site_url('nivel/listar') ?>">
                        <i class="fa fa-th-list"></i>
                        <span class="submenu-title"><?php echo __("Lista de Níveis"); ?></span>
                    </a>
                </li>
                <li<?php echo $this->gestao->Menufuncao('nacionalidade', array('listar', 'editar')) ?>>
                    <a href="<?php echo site_url('nacionalidade/listar') ?>">
                        <i class="fa fa-th-list"></i>
                        <span class="submenu-title"><?php echo __("Lista de Nacionalidade"); ?></span>
                    </a>
                </li>
                <li<?php echo $this->gestao->Menufuncao('tamanho', array('listar', 'editar')) ?>>
                    <a href="<?php echo site_url('tamanho/listar') ?>">
                        <i class="fa fa-th-list"></i>
                        <span class="submenu-title"><?php echo __("Lista de tamanho"); ?></span>
                    </a>
                </li>
                <li<?php echo $this->gestao->Menufuncao('cargo', array('listar', 'editar')) ?>>
                    <a href="<?php echo site_url('cargo/listar') ?>">
                        <i class="fa fa-th-list"></i>
                        <span class="submenu-title"><?php echo __("Lista de Cargos"); ?></span>
                    </a>
                </li>
                <li<?php echo $this->gestao->Menufuncao('instituicao', array('listar', 'editar')) ?>>
                    <a href="<?php echo site_url('instituicao/listar') ?>">
                        <i class="fa fa-th-list"></i>
                        <span class="submenu-title"><?php echo __("Lista de Instituições"); ?></span>
                    </a>
                </li>
                <li<?php echo $this->gestao->Menufuncao('curso', array('listar', 'editar')) ?>>
                    <a href="<?php echo site_url('curso/listar') ?>">
                        <i class="fa fa-th-list"></i>
                        <span class="submenu-title"><?php echo __("Lista de Cursos"); ?></span>
                    </a>
                </li>
                <li<?php echo $this->gestao->Menufuncao('empresa', array('listar', 'editar')) ?>>
                    <a href="<?php echo site_url('empresa/listar') ?>">
                        <i class="fa fa-th-list"></i>
                        <span class="submenu-title"><?php echo __("Lista de Empresas"); ?></span>
                    </a>
                </li>
                <li<?php echo $this->gestao->Menufuncao('faturamento', array('listar', 'editar')) ?>>
                    <a href="<?php echo site_url('faturamento/listar') ?>">
                        <i class="fa fa-th-list"></i>
                        <span class="submenu-title"><?php echo __("Lista de Faturamentos"); ?></span>
                    </a>
                </li>
                <li<?php echo $this->gestao->Menufuncao('competencia', array('listar', 'editar')) ?>>
                    <a href="<?php echo site_url('competencia/listar') ?>">
                        <i class="fa fa-th-list"></i>
                        <span class="submenu-title"><?php echo __("Lista de Competências"); ?></span>
                    </a>
                </li>
            </ul>
        </li>
        <?php
            endif;
        ?>
        <?php
		    if(TemAcesso(array('Administrador','Coordenador'))):
	    ?>
        <li<?php echo $this->gestao->MenuModulo(array('candidato')) ?>>
            <a href="#">
                <i class="fa fa-users fa-fw"><div class="icon-bg bg-pink"></div></i>
                <span class="menu-title"><?php echo __("Candidatos"); ?></span>
                <span class="fa arrow"></span>
            </a>
            <ul class="nav nav-second-level">
                <li<?php echo $this->gestao->Menufuncao('candidato', 'listar') ?>>
                    <a href="<?php echo site_url('candidato/listar') ?>">
                        <i class="fa fa-th-list"></i>
                        <span class="submenu-title"><?php echo __("Lista de Candidatos"); ?></span>
                    </a>
                </li>
                <li<?php echo $this->gestao->Menufuncao('candidato', 'editar') ?>>
                    <a href="<?php echo site_url('candidato/editar/0') ?>">
                        <i class="ion ion-clipboard"></i>
                        <span class="submenu-title"><?php echo __("Novo Candidato"); ?></span>
                    </a>
                </li>
            </ul>
        </li>
        <?php
            endif;
        ?>
        <?php
		    if(TemAcesso(array('Administrador','Coordenador'))):
	    ?>
        <li<?php echo $this->gestao->MenuModulo(array('cliente','rastreio')) ?>>
            <a href="#">
                <i class="ion ion-android-contacts fa-fw"><div class="icon-bg bg-pink"></div></i>
                <span class="menu-title"><?php echo __("Clientes"); ?></span>
                <span class="fa arrow"></span>
            </a>
            <ul class="nav nav-second-level">
                <li<?php echo $this->gestao->Menufuncao('cliente', 'listar') ?>>
                    <a href="<?php echo site_url('cliente/listar') ?>">
                        <i class="fa fa-th-list"></i>
                        <span class="submenu-title"><?php echo __("Lista de Clientes"); ?></span>
                    </a>
                </li>
                <li<?php echo $this->gestao->Menufuncao('cliente', 'editar') ?>>
                    <a href="<?php echo site_url('cliente/editar/0') ?>">
                        <i class="ion ion-clipboard"></i>
                        <span class="submenu-title"><?php echo __("Novo Cliente"); ?></span>
                    </a>
                </li>
                <li<?php echo $this->gestao->Menufuncao('cliente', 'alterarsenhacliente') ?>>
                    <a href="<?php echo site_url('cliente/alterarsenhacliente') ?>">
                        <i class="ion ion-clipboard"></i>
                        <span class="submenu-title"><?php echo __("Alterar Senha"); ?></span>
                    </a>
                </li>
                <li<?php echo $this->gestao->Menufuncao('rastreio', 'listar') ?>>
                    <a href="<?php echo site_url('rastreio/listar') ?>">
                        <i class="fa fa-th-list"></i>
                        <span class="submenu-title"><?php echo __("Rastreamento de Clientes"); ?></span>
                    </a>
                </li>
                <li<?php echo $this->gestao->Menufuncao('rastreio', 'cockpit') ?>>
                    <a href="<?php echo site_url('rastreio/cockpit') ?>">
                        <i class="fa fa-th-list"></i>
                        <span class="submenu-title"><?php echo __("Cockpit de Clientes"); ?></span>
                    </a>
                </li>
                <li<?php echo $this->gestao->Menufuncao('rastreio', 'cockpitrastreio') ?>>
                    <a href="<?php echo site_url('rastreio/cockpitrastreio') ?>" target="_blank">
                        <i class="fa fa-th-list"></i>
                        <span class="submenu-title"><?php echo __("Cockpit de Rastreamento"); ?></span>
                    </a>
                </li>
            </ul>
        </li>
        <?php
            endif;
        ?>
        <?php
		    if(TemAcesso(array('Administrador','Coordenador'))):
	    ?>
        <li<?php echo $this->gestao->MenuModulo(array('vaga')) ?>>
            <a href="#">
                <i class="el el-wrench-alt fa-fw"><div class="icon-bg bg-pink"></div></i>
                <span class="menu-title"><?php echo __("Vagas"); ?></span>
                <span class="fa arrow"></span>
            </a>
            <ul class="nav nav-second-level">
                <li<?php echo $this->gestao->Menufuncao('vaga', 'listar') ?>>
                    <a href="<?php echo site_url('vaga/listar') ?>">
                        <i class="fa fa-th-list"></i>
                        <span class="submenu-title"><?php echo __("Lista de Vagas"); ?></span>
                    </a>
                </li>
                <li<?php echo $this->gestao->Menufuncao('vaga', 'editar') ?>>
                    <a href="<?php echo site_url('vaga/editar/0') ?>">
                        <i class="ion ion-clipboard"></i>
                        <span class="submenu-title"><?php echo __("Nova Vaga"); ?></span>
                    </a>
                </li>
            </ul>
        </li>
        <?php
            endif;
        ?>
    </ul>
</div>