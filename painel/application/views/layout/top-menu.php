<div class="navbar-header">
    <button type="button" data-toggle="collapse" data-target=".sidebar-collapse" class="navbar-toggle">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
    </button>
    <a id="logo" href="index.html" class="navbar-brand">
        <span class="fa fa-rocket"></span>
        <span class="logo-text"><?php echo $this->gestao->GetConfig('nomesistema','Captador'); ?></span>
        <span style="display: none" class="logo-text-icon"><?php echo $this->gestao->GetConfig('sigladosistema','ALG'); ?></span>
    </a>
</div>
<div class="topbar-main">
    <a id="menu-toggle" href="#" class="hidden-xs"><i class="fa fa-bars"></i></a>
    <form id="topbar-search" action="#" method="GET" class="hidden-xs">
        <div class="input-group">
            <input type="text" placeholder="Search..." class="form-control" />
            <span class="input-group-btn"><a href="javascript:;" class="btn submit"><i class="fa fa-search"></i></a></span>
        </div>
    </form>
    <ul class="nav navbar navbar-top-links navbar-right mbn">
        <li class="dropdown">
            <a data-hover="dropdown" href="#" class="dropdown-toggle">
                <i class="phoca-flag <?php $this->gestao->GetFlagAtivo();?>"></i>
            </a>
            <ul class="dropdown-menu dropdown-alerts">
                <li>
                    <p><?php _e("Escolha o seu idioma"); ?></p>
                </li>
                <li>
                    <div class="dropdown-slimscroll">
                        <ul>
                            <?php $this->gestao->ListadeIdiomas();?>
                        </ul>
                    </div>
                </li>
                <li class="last"><div id="google_translate_element"></div></li>
            </ul>
        </li>
        <li class="dropdown topbar-user">
            <a data-hover="dropdown" href="#" class="dropdown-toggle"><img src="<?php echo GetColaborador()->GetAvatar(); ?>" alt="" class="img-responsive img-circle" />&nbsp;<span class="hidden-xs"><?php echo $this->session->userdata('nome'); ?></span>&nbsp;<span class="caret"></span></a>
            <ul class="dropdown-menu dropdown-user pull-right">
                <li>
                    <a href="<?php echo site_url('colaborador/editar/'.$this->session->userdata('idcolaborador')) ?>">
                    <i class="fa fa-user"></i><?php echo __("Meu Perfil"); ?></a>
                </li>
                <li class="divider"></li>
                <li><a href="<?php echo site_url('painel/logout') ?>"><i class="fa fa-key"></i><?php echo __("Sair"); ?></a></li>
            </ul>
        </li>
        <li class="dropdown hidden-xs">
            <!--BEGIN THEME SETTING-->
            <a id="theme-setting" href="javascript:;" data-hover="dropdown" data-step="1" data-intro="&lt;b&gt;Header&lt;/b&gt;, &lt;b&gt;sidebar&lt;/b&gt;, &lt;b&gt;border style&lt;/b&gt; and &lt;b&gt;color&lt;/b&gt;, all of them can change for you to create the best" data-position="left" class="dropdown-toggle"><i class="fa fa-cogs"></i></a>
            <ul class="dropdown-menu dropdown-theme-setting pull-right">
                <li>
                    <h4 class="mtn"><?php echo __("Estilos de tema");?></h4>
                    <select id="list-style" class="form-control">
                        <option value="style1"><?php echo __("Estilo quadrado");?></option>
                        <option value="style2"><?php echo __("Estilo arredondado");?></option>
                        <option value="style3"><?php echo __("Estilo de borda plana");?></option>
                    </select>
                </li>
                <li>
                    <h4 class="mtn"><?php echo __("Estilos de Menu");?></h4>
                    <select id="list-menu" class="form-control">
                        <option value="sidebar-default"><?php echo __("Estilo 1");?></option>
                        <option value="sidebar-colors"><?php echo __("Estilo 2");?></option>
                        <option value="sidebar-icons"><?php echo __("Estilo 3");?></option>
                        <option value="sidebar-collapsed"><?php echo __("Estilo 4");?></option>
                    </select>
                </li>
                <li>
                    <h4 class="mtn"><?php echo __("Cabeçario & Sidebar");?></h4>
                    <select id="list-header" class="form-control">
                        <option value="header-static"><?php echo __("Estático");?></option>
                        <option value="header-fixed"><?php echo __("Fixo");?></option>
                    </select>
                </li>
                <li>
                    <h4 class="mtn"><?php echo __("Cores do tema");?></h4>
                    <ul id="list-color" class="list-unstyled list-inline">
                        <li data-color="green-dark" data-hover="tooltip" title="Green - Dark" class="green-dark"></li>
                        <li data-color="red-dark" data-hover="tooltip" title="Red - Dark" class="red-dark"></li>
                        <li data-color="pink-dark" data-hover="tooltip" title="Pink - Dark" class="pink-dark"></li>
                        <li data-color="blue-dark" data-hover="tooltip" title="Blue - Dark" class="blue-dark"></li>
                        <li data-color="yellow-dark" data-hover="tooltip" title="Yellow - Dark" class="yellow-dark"></li>
                        <li data-color="green-grey" data-hover="tooltip" title="Green - Grey" class="green-grey"></li>
                        <li data-color="red-grey" data-hover="tooltip" title="Red - Grey" class="red-grey"></li>
                        <li data-color="pink-grey" data-hover="tooltip" title="Pink - Grey" class="pink-grey"></li>
                        <li data-color="blue-grey" data-hover="tooltip" title="Blue - Grey" class="blue-grey"></li>
                        <li data-color="yellow-grey" data-hover="tooltip" title="Yellow - Grey" class="yellow-grey"></li>
                        <li data-color="yellow-green" data-hover="tooltip" title="Yellow - Green" class="yellow-green"></li>
                        <li data-color="orange-grey" data-hover="tooltip" title="Orange - Grey" class="orange-grey"></li>
                        <li data-color="pink-blue" data-hover="tooltip" title="Pink - Blue" class="pink-blue"></li>
                        <li data-color="pink-violet" data-hover="tooltip" title="Pink - Violet" class="pink-violet active"></li>
                        <li data-color="orange-violet" data-hover="tooltip" title="Orange - Violet" class="orange-violet"></li>
                        <li data-color="pink-green" data-hover="tooltip" title="Pink - Green" class="pink-green"></li>
                        <li data-color="pink-brown" data-hover="tooltip" title="Pink - Brown" class="pink-brown"></li>
                        <li data-color="orange-blue" data-hover="tooltip" title="Orange - Blue" class="orange-blue"></li>
                        <li data-color="yellow-blue" data-hover="tooltip" title="Yellow - Blue" class="yellow-blue"></li>
                        <li data-color="green-blue" data-hover="tooltip" title="Green - Blue" class="green-blue"></li>
                    </ul>
                </li>
            </ul>
            <!--END THEME SETTING-->
        </li>
    </ul>
</div>
