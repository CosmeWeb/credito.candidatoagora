<?php
if(!empty($titulovaga)):
?>
<section id="titulovagacandidato">
    <h2 class="container"><?php echo $titulovaga; ?></h2>
</section>
<?php
endif;
?>
<section id="containercandidato" class="container">
    <div class="asideTitle">            
        <h2 id="tituloNum"></h2>
        <p id="tituloNumTotal"></p>
    </div>
    <div class="headerFilter">
        <div class="vertical-center-end" >
            <div class="asideExport">
                <div class="vertical-center-start">
                    <a class="btn" href="javascript:;" onclick="iniciarExportacao(this)">
                        Exportar a lista atual<i class="fas fa-file-excel"></i>
                    </a>
                </div>
            </div>
            <?php
                if($Acesso != "Cliente"):
            ?>
            <h5>Exibição: </h5>
            <input id="exibicao" name="exibicao" type="radio" value="lista">
            <label>Em lista</label>
            <input id="exibicao" name="exibicao" checked type="radio" value="pagina">
            <label>Em pagina</label>
            <?php
                endif;
            ?>
            <input id="finalizado" name="finalizado" type="hidden" value="false">
            <input id="posicao" name="posicao" type="hidden" value="0">
            <input id="idvaga" name="idvaga" type="hidden" value="<?php echo $idvaga; ?>">
            <input id="total" name="total" type="hidden" value="0">
            <input id="totalgeral" name="totalgeral" type="hidden" value="0">
            <input id="limite" name="limite" type="hidden" value="24">
            <input id="buscarInput" type="text" autocomplete="off" placeholder="Buscar por Nome ou Palavra-Chave">
            <button id="buscar" type="button"><i class="fas fa-search"></i></button>                
            <select id="classifica" type="text" autocomplete="off" class="classic safari_only">
                <option value="" disabled selected>Classificar por</option>
            </select>
            <!--<button id="reloadgrid" type="button" name="reloadgrid"><i class="fas fa-list"></i></button>-->
        </div>
    </div>  
    <div class="asideExitFilter">
        <ul>
            <li class="btnExitFilter" name="clear" onclick="RetirarFilterAll()">
                Limpar Filtros
                <a href="javascript:;">
                    <i class="fas fa-times"></i>
                </a>  
            </li>
        </ul>
    </div>
    <div class="asideMenuFilter style-2">
        <div class="filtersMenus preload-menu">
            <section class="titleMenuFilter">
                <span>Favoritos</span>
                <a class="up" href="javascript:;">                    
                    <i class="fas fa-chevron-up"></i>
                </a>
                <a class="limpar" href="javascript:;">                    
                    Limpar
                </a>
            </section>
            <section class="filterCheck style-1" style="height:12vh">
                <ul id="FilterFavorito">
                </ul>
            </section>
            <button type='button' class='btnCalcular' title="<?php echo __("Exibir lista de filtro com quantidade"); ?>" data-identifier='0' style="display:none;"><i class="fa fa-th-list"></i> Calcular</button>
            <button type='button' class='btnMore' data-identifier='0'>Ver mais <i class="fas fa-plus"></i></button>
        </div>
        <div class="filtersMenus preload-menu">
            <section class="titleMenuFilter">
                <span>Favoritos 123</span>
                <a class="up" href="javascript:;">                    
                    <i class="fas fa-chevron-up"></i>
                </a>
                <a class="limpar" href="javascript:;">                    
                    Limpar
                </a>
            </section>
            <section class="filterCheck style-1" style="height:13vh">
                <ul id="FilterFavoritogrupo">
                </ul>
            </section>
            <button type='button' class='btnCalcular' title="<?php echo __("Exibir lista de filtro com quantidade"); ?>" data-identifier='1' style="display:none;"><i class="fa fa-th-list"></i> Calcular</button>
            <button type='button' class='btnMore' data-identifier='1'>Ver mais <i class="fas fa-plus"></i></button>
        </div>
        <div class="filtersMenus preload-menu">
            <section class="titleMenuFilter">
                <span>Abordagem</span>
                <a class="up" href="javascript:;">                    
                    <i class="fas fa-chevron-up"></i>
                </a>
                <a class="limpar" href="javascript:;">                    
                    Limpar
                </a>
            </section>
            <section class="filterCheck style-1" style="height:13vh">
                <ul id="FilterAbordagem">
                </ul>
            </section>
            <button type='button' class='btnCalcular' title="<?php echo __("Exibir lista de filtro com quantidade"); ?>" data-identifier='2' style="display:none;"><i class="fa fa-th-list"></i> Calcular</button>
            <button type='button' class='btnMore' data-identifier='2'>Ver mais <i class="fas fa-plus"></i></button>
        </div>
        <div class="filtersMenus preload-menu">
            <section class="titleMenuFilter">
                <span>Recomendação TopTalent</span>
                <a class="up" href="javascript:;">                    
                    <i class="fas fa-chevron-up"></i>
                </a>
                <a class="limpar" href="javascript:;">                    
                    Limpar
                </a>
            </section>
            <section class="filterCheck style-1" style="height:11vh">
                <ul id="FilterToptalent">
                </ul>
            </section>
            <button type='button' class='btnCalcular' title="<?php echo __("Exibir lista de filtro com quantidade"); ?>" data-identifier='3' style="display:none;"><i class="fa fa-th-list"></i> Calcular</button>
            <button type='button' class='btnMore' data-identifier='3'>Ver mais <i class="fas fa-plus"></i></button>
        </div>        
        <div class="filtersMenus preload-menu">
            <section class="titleMenuFilter">
                <span>Interesse nessa vaga/empresa</span>
                <a class="up" href="javascript:;">                    
                    <i class="fas fa-chevron-up"></i>
                </a>
                <a class="limpar" href="javascript:;">                    
                    Limpar
                </a>
            </section>
            <section class="filterCheck style-1" style="height:12vh">
                <ul id="FilterInteresse">
                </ul>
            </section>
            <button type='button' class='btnCalcular' title="<?php echo __("Exibir lista de filtro com quantidade"); ?>" data-identifier='20' style="display:none;"><i class="fa fa-th-list"></i> Calcular</button>
            <button type='button' class='btnMore' data-identifier='20'>Ver mais <i class="fas fa-plus"></i></button>
        </div>
        <div class="filtersMenus preload-menu">
            <section class="titleMenuFilter">
                <span>Dados de contato</span>
                <a class="up" href="javascript:;">                    
                    <i class="fas fa-chevron-up"></i>
                </a>
                <a class="limpar" href="javascript:;">                    
                    Limpar
                </a>
            </section>
            <section class="filterCheck style-1" style="height:18vh;">
                <ul id="FilterContatos">
                </ul>
            </section>
            <button type='button' class='btnCalcular' title="<?php echo __("Exibir lista de filtro com quantidade"); ?>" data-identifier='4' style="display:none;"><i class="fa fa-th-list"></i> Calcular</button>
            <button type='button' class='btnMore' data-identifier='4'>Ver mais <i class="fas fa-plus"></i></button>
        </div>
        <div class="filtersMenus preload-menu">
            <section class="titleMenuFilter">
                <span>Data da aplicação</span>
                <a class="up" href="javascript:;">                    
                    <i class="fas fa-chevron-up"></i>
                </a>
                <a class="limpar" href="javascript:;">                    
                    Limpar
                </a>
            </section>
            <section class="filterCheck style-1" style="height:18vh">
                <ul id="FilterDataaplicacao">                    
                </ul>
            </section>
            <button type='button' class='btnCalcular' title="<?php echo __("Exibir lista de filtro com quantidade"); ?>" data-identifier='6' style="display:none;"><i class="fa fa-th-list"></i> Calcular</button>
            <button type='button' class='btnMore' data-identifier='6' style="display:none;">Ver mais <i class="fas fa-plus"></i></button>
        </div>
        <div class="filtersMenus preload-menu">
            <section class="titleMenuFilter">
                <span>Estado</span>
                <a class="up" href="javascript:;">
                    <i class="fas fa-chevron-up"></i>
                </a>
                <a class="limpar" href="javascript:;">
                    Limpar
                </a>
            </section>
            <section class="filterCheck style-1">
                <ul id="FilterEstado">
                </ul>
            </section>
            <button type='button' class='btnCalcular' title="<?php echo __("Exibir lista de filtro com quantidade"); ?>" data-identifier='7' style="display:none;"><i class="fa fa-th-list"></i> Calcular</button>
            <button type='button' class='btnMore' data-identifier='7'>Ver mais <i class="fas fa-plus"></i></button>
        </div>
        <div class="filtersMenus preload-menu">
            <section class="titleMenuFilter">
                <span>Cidade</span>
                <a class="up" href="javascript:;">
                    <i class="fas fa-chevron-up"></i>
                </a>
                <a class="limpar" href="javascript:;">
                    Limpar
                </a>
            </section>
            <section class="filterCheck style-1">
                <ul id="FilterCidade">
                </ul>
            </section>
            <button type='button' class='btnCalcular' title="<?php echo __("Exibir lista de filtro com quantidade"); ?>" data-identifier='8' style="display:none;"><i class="fa fa-th-list"></i> Calcular</button>
            <button type='button' class='btnMore' data-identifier='8'>Ver mais <i class="fas fa-plus"></i></button>
        </div>
        <div class="filtersMenus preload-menu">
            <section class="titleMenuFilter">
                <span>Área</span>
                <a class="up" href="javascript:;">
                    <i class="fas fa-chevron-up"></i>
                </a>
                <a class="limpar" href="javascript:;">
                    Limpar
                </a>
            </section>
            <section class="filterCheck style-1">
                <ul id="FilterArea">
                </ul>
            </section>
            <button type='button' class='btnCalcular' title="<?php echo __("Exibir lista de filtro com quantidade"); ?>" data-identifier='9' style="display:none;"><i class="fa fa-th-list"></i> Calcular</button>
            <button type='button' class='btnMore' data-identifier='9'>Ver mais <i class="fas fa-plus"></i></button>
        </div>
        <div class="filtersMenus preload-menu">
            <section class="titleMenuFilter">
                <span>Subárea</span>
                <a class="up" href="javascript:;">
                    <i class="fas fa-chevron-up"></i>
                </a>
                <a class="limpar" href="javascript:;">
                    Limpar
                </a>
            </section>
            <section class="filterCheck style-1">
                <ul id="FilterSubArea">
                </ul>
            </section>
            <button type='button' class='btnCalcular' title="<?php echo __("Exibir lista de filtro com quantidade"); ?>" data-identifier='10' style="display:none;"><i class="fa fa-th-list"></i> Calcular</button>
            <button type='button' class='btnMore' data-identifier='10'>Ver mais <i class="fas fa-plus"></i></button>
        </div>
        <div class="filtersMenus preload-menu">
            <section class="titleMenuFilter">
                <span>Nivel</span>
                <a class="up" href="javascript:;">
                    <i class="fas fa-chevron-up"></i>
                </a>
                <a class="limpar" href="javascript:;">
                    Limpar
                </a>
            </section>
            <section class="filterCheck style-1">
                <ul id="FilterNivel">
                </ul>
            </section>
            <button type='button' class='btnCalcular' title="<?php echo __("Exibir lista de filtro com quantidade"); ?>" data-identifier='11' style="display:none;"><i class="fa fa-th-list"></i> Calcular</button>
            <button type='button' class='btnMore' data-identifier='11'>Ver mais <i class="fas fa-plus"></i></button>
        </div>
        <div class="filtersMenus preload-menu">
            <section class="titleMenuFilter">
                <span>Perfis target definidos pelo cliente</span>
                <a class="up" href="javascript:;">                    
                    <i class="fas fa-chevron-up"></i>
                </a>
                <a class="limpar" href="javascript:;">                    
                    Limpar
                </a>
            </section>
            <section class="filterCheck style-1" style="height:16vh">
                <ul id="FilterPerfil">
                </ul>
            </section>
            <button type='button' class='btnCalcular' title="<?php echo __("Exibir lista de filtro com quantidade"); ?>" data-identifier='17' style="display:none;"><i class="fa fa-th-list"></i> Calcular</button>
            <button type='button' class='btnMore' data-identifier='17'>Ver mais <i class="fas fa-plus"></i></button>
        </div>
        <div class="filtersMenus preload-menu">
            <section class="titleMenuFilter">
                <span>Empresa atual</span>
                <a class="up" href="javascript:;">
                    <i class="fas fa-chevron-up"></i>
                </a>
                <a class="limpar" href="javascript:;">
                    Limpar
                </a>
            </section>
            <section class="filterCheck style-1" style="height:23rem">
                <ul id="FilterEmpresa">
                </ul>
            </section>
            <button type='button' class='btnCalcular' title="<?php echo __("Exibir lista de filtro com quantidade"); ?>" data-identifier='13' style="display:none;"><i class="fa fa-th-list"></i> Calcular</button>
            <button type='button' class='btnMore' data-identifier='13'>Ver mais <i class="fas fa-plus"></i></button>
        </div>
        <div class="filtersMenus preload-menu">
            <section class="titleMenuFilter">
                <span>Setor Atual</span>
                <a class="up" href="javascript:;">
                    <i class="fas fa-chevron-up"></i>
                </a>
                <a class="limpar" href="javascript:;">
                    Limpar
                </a>
            </section>
            <section class="filterCheck style-1">
                <ul id="FilterSetor">
                </ul>
            </section>
            <button type='button' class='btnCalcular' title="<?php echo __("Exibir lista de filtro com quantidade"); ?>" data-identifier='12' style="display:none;"><i class="fa fa-th-list"></i> Calcular</button>
            <button type='button' class='btnMore' data-identifier='12'>Ver mais <i class="fas fa-plus"></i></button>
        </div>
        <div class="filtersMenus preload-menu">
            <section class="titleMenuFilter">
                <span>Tamanho da empresa atual</span>
                <a class="up" href="javascript:;">
                    <i class="fas fa-chevron-up"></i>
                </a>
                <a class="limpar" href="javascript:;">
                    Limpar
                </a>
            </section>
            <section class="filterCheck style-1" style="height:23rem">
                <ul id="FilterTamanhoempresa">                    
                </ul>
            </section>
            <button type='button' class='btnCalcular' title="<?php echo __("Exibir lista de filtro com quantidade"); ?>" data-identifier='14' style="display:none;"><i class="fa fa-th-list"></i> Calcular</button>
            <button type='button' class='btnMore' data-identifier='14' style="display:none;">Ver mais <i class="fas fa-plus"></i></button>
        </div>
        <div class="filtersMenus preload-menu">
            <section class="titleMenuFilter">
                <span>Nacionalidade</span>
                <a class="up" href="javascript:;">
                    <i class="fas fa-chevron-up"></i>
                </a>
                <a class="limpar" href="javascript:;">
                    Limpar
                </a>
            </section>
            <section class="filterCheck style-1">
                <ul id="FilterNacionalidade">
                </ul>
            </section>
            <button type='button' class='btnCalcular' title="<?php echo __("Exibir lista de filtro com quantidade"); ?>" data-identifier='18' style="display:none;"><i class="fa fa-th-list"></i> Calcular</button>
            <button type='button' class='btnMore' data-identifier='18' style="display:none;">Ver mais <i class="fas fa-plus"></i></button>
        </div>
        <div class="filtersMenus preload-menu">
            <section class="titleMenuFilter">
                <span>Idiomas</span>
                <a class="up" href="javascript:;">
                    <i class="fas fa-chevron-up"></i>
                </a>
                <a class="limpar" href="javascript:;">
                    Limpar
                </a>
            </section>
            <section class="filterCheck style-1" style="height:19rem">
                <ul id="FilterIdiomas">
                </ul>
            </section>
            <button type='button' class='btnCalcular' title="<?php echo __("Exibir lista de filtro com quantidade"); ?>" data-identifier='19' style="display:none;"><i class="fa fa-th-list"></i> Calcular</button>
            <button type='button' class='btnMore' data-identifier='19' style="display:none;">Ver mais <i class="fas fa-plus"></i></button>
        </div>
        <div class="filtersMenus preload-menu">
            <section class="titleMenuFilter">
                <span>Carla responde (Bot)</span>
                <a class="up" href="javascript:;">
                    <i class="fas fa-chevron-up"></i>
                </a>
                <a class="limpar" href="javascript:;">
                    Limpar
                </a>
            </section>
            <section class="filterCheck style-1">
                <ul id="FilterBotResp">                      
                </ul>
            </section>
            <button type='button' class='btnCalcular' title="<?php echo __("Exibir lista de filtro com quantidade"); ?>" data-identifier='15' style="display:none;"><i class="fa fa-th-list"></i> Calcular</button>
            <button type='button' class='btnMore' data-identifier='15'>Ver mais <i class="fas fa-plus"></i></button>
        </div>
        <div class="filtersMenus preload-menu">
            <section class="titleMenuFilter">
                <span>Competências</span>
                <a class="up" href="javascript:;">
                    <i class="fas fa-chevron-up"></i>
                </a>
                <a class="limpar" href="javascript:;">
                    Limpar
                </a>
            </section>
            <section class="filterCheck style-1">
                <ul id="FilterCompetencia">
                </ul>
            </section>
            <button type='button' class='btnCalcular' title="<?php echo __("Exibir lista de filtro com quantidade"); ?>" data-identifier='16' style="display:none;"><i class="fa fa-th-list"></i> Calcular</button>
            <button type='button' class='btnMore' data-identifier='16'>Ver mais <i class="fas fa-plus"></i></button>
        </div>
        <div class="filtersMenus preload-menu">
            <section class="titleMenuFilter">
                <span>Gênero</span>
                <a class="up" href="javascript:;">                    
                    <i class="fas fa-chevron-up"></i>
                </a>
                <a class="limpar" href="javascript:;">                    
                    Limpar
                </a>
            </section>
            <section class="filterCheck style-1" style="height:18vh">
                <ul id="FilterSexo">                    
                </ul>
            </section>
            <button type='button' class='btnCalcular' title="<?php echo __("Exibir lista de filtro com quantidade"); ?>" data-identifier='5' style="display:none;"><i class="fa fa-th-list"></i> Calcular</button>
            <button type='button' class='btnMore' data-identifier='5' style="display:none;">Ver mais <i class="fas fa-plus"></i></button>
        </div>
        <div class="filtersMenus preload-menu">
            <section class="titleMenuFilter">
                <span>Avaliados</span>
                <a class="up" href="javascript:;">                    
                    <i class="fas fa-chevron-up"></i>
                </a>
                <a class="limpar" href="javascript:;">                    
                    Limpar
                </a>
            </section>
            <section class="filterCheck style-1" style="height:18vh; min-height: 210px;">
                <ul id="FilterAvaliados">                    
                </ul>
            </section>
            <button type='button' class='btnCalcular' title="<?php echo __("Exibir lista de filtro com quantidade"); ?>" data-identifier='21' style="display:none;"><i class="fa fa-th-list"></i> Calcular</button>
            <button type='button' class='btnMore' data-identifier='21' style="display:none;">Ver mais <i class="fas fa-plus"></i></button>
        </div>
        <div class="filtersMenus preload-menu">
            <section class="titleMenuFilter">
                <span>Ação Candidato</span>
                <a class="up" href="javascript:;">                    
                    <i class="fas fa-chevron-up"></i>
                </a>
                <a class="limpar" href="javascript:;">                    
                    Limpar
                </a>
            </section>
            <section class="filterCheck style-1" style="height:15vh; min-height: 120px;">
                <ul id="FilterAcaoCandidato">                    
                </ul>
            </section>
            <button type='button' class='btnCalcular' title="<?php echo __("Exibir lista de filtro com quantidade"); ?>" data-identifier='22' style="display:none;"><i class="fa fa-th-list"></i> Calcular</button>
            <button type='button' class='btnMore' data-identifier='22' style="display:none;">Ver mais <i class="fas fa-plus"></i></button>
        </div>
        <div class="filtersMenus preload-menu">
            <section class="titleMenuFilter">
                <span>Ação Linkedin</span>
                <a class="up" href="javascript:;">                    
                    <i class="fas fa-chevron-up"></i>
                </a>
                <a class="limpar" href="javascript:;">                    
                    Limpar
                </a>
            </section>
            <section class="filterCheck style-1" style="height:15vh; min-height: 120px;">
                <ul id="FilterAcaoLinkedin">                    
                </ul>
            </section>
            <button type='button' class='btnCalcular' title="<?php echo __("Exibir lista de filtro com quantidade"); ?>" data-identifier='23' style="display:none;"><i class="fa fa-th-list"></i> Calcular</button>
            <button type='button' class='btnMore' data-identifier='23' style="display:none;">Ver mais <i class="fas fa-plus"></i></button>
        </div>
    </div>
    <main id="main">
    </main>
</section>
<a id="topcandidato" href="#containercandidato">
    <i class="fas fa-arrow-up"></i>
</a>

<div id="modal-candidato" class="modal fade">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="padding: 5px 10px; display: block;">
                <button type="button" data-dismiss="modal" aria-hidden="true" class="close"><i class="fa fa-close"></i></button>
                <h4 class="modal-title" style="font-size: 24px;"><?php echo __("Retorno do invite do linkedin") ?></h4>
            </div>
            <div class="modal-body">
                <form id="frmdadoscandidato" class="horizontal-form" method="GET">
                    <div class="row" id="areadadoscandidato">
                        <div class="col-md-12">
                            <div class="pageloader">
                                <i class="ion ion-looping"></i>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-danger"><i class="fa fa-remove"></i> <?php echo __("Fechar") ?></button>&nbsp;
                <button id="btnOKcolunasCandidato" type="button" class="btn btn-primary" onclick="SalvarRetornoInviteLKD(this)"><i class="fa fa-save"></i> <?php echo __("Salvar") ?></button>
            </div>
        </div>
    </div>
</div>
<div id="modal-exportar-candidato" class="modal fade">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="padding: 5px 10px; display: block;">
                <button type="button" data-dismiss="modal" aria-hidden="true" class="close"><i class="fa fa-close"></i></button>
                <h4 class="modal-title" style="font-size: 24px;"><?php echo __("Exportar candidato") ?></h4>
            </div>
            <div class="modal-body">
                <form id="frmexportar" class="horizontal-form" method="GET">
                    <div class="row" id="areaexportar">
                        <div class="col-md-12">
                            <div class="progress">
                            <div class="progress-bar progress-bar-striped bg-success" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-danger"><i class="fa fa-remove"></i> <?php echo __("Fechar") ?></button>
            </div>
        </div>
    </div>
</div>
<div id="modal-abordagem" class="modal fade">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="padding: 5px 10px; display: block;">
                <button type="button" data-dismiss="modal" aria-hidden="true" class="close"><i class="fa fa-close"></i></button>
                <h4 class="modal-title" style="font-size: 24px;"><?php echo __("Marcar a abordagem ao candidato") ?></h4>
            </div>
            <div class="modal-body">
                <form id="frmdadosabordagem" class="horizontal-form" method="GET">
                    <div class="row" id="areadadosabordagem">
                        <div class="col-md-12">
                            <div class="pageloader">
                                <i class="ion ion-looping"></i>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-danger"><i class="fa fa-remove"></i> <?php echo __("Fechar") ?></button>&nbsp;
                <button id="btnDesmacarCandidato" type="button" class="btn btn-info" onclick="MarcarAbordagem(this,false)"><i class="fa fa-save"></i> <?php echo __("Desmarcar") ?></button>&nbsp;
                <button id="btnOKcolunasCandidato" type="button" class="btn btn-primary" onclick="MarcarAbordagem(this,true)"><i class="fa fa-save"></i> <?php echo __("Salvar") ?></button>
            </div>
        </div>
    </div>
</div>
<script>
    let url = "";
    let idCliente = "<?php print $idCliente; ?>";
    let acesso = "<?php echo (empty($Acesso))?'Cliente': $Acesso; ?>";
    let filtersParam = [];
    let carregandocandidato = false;
    let limitEstado = 5;
    let limitCidade = 5;
    var idEstados  = [];

    $(document).ready(function() {
        url = GetDominio('painel/index.php/');
        filtersParam = [
            {
                "filter": "Favorito",
                "label": "Favorito",
                "url": "/lerlistafavoritos",
                "limite": 5,
                "posicao": 0,
                "total": 0,
                "ativo": true,
                "fieldId": "favorito",
                "fieldValue": "texto",
                "fieldSecondValue": "sem",
                "isCheck": false,
                "filtradoPorIndice": -1,
                "AtualizarIndice": -1,
                "NaoDisponivel": false,
                "NaoDisponivelMarcado": 0,
                "CalcularBtn": 0,
                "CalcularAtivo": 0,
                "filtrosMarcados": []
            },
            {
                "filter": "Favoritogrupo",
                "label": "Favorito 123",
                "url": "/lerlistafavoritosgrupo",
                "limite": 5,
                "posicao": 0,
                "total": 0,
                "ativo": true,
                "fieldId": "favoritogrupo",
                "fieldValue": "texto",
                "fieldSecondValue": "sem",
                "isCheck": false,
                "filtradoPorIndice": -1,
                "AtualizarIndice": -1,
                "NaoDisponivel": false,
                "NaoDisponivelMarcado": 0,
                "CalcularBtn": 0,
                "CalcularAtivo": 0,
                "filtrosMarcados": []
            },
            {
                "filter": "Abordagem",
                "label": "Abordagem",
                "url": "/lerlistaabordagem",
                "limite": 5,
                "posicao": 0,
                "total": 0,
                "ativo": true,
                "fieldId": "abordagem",
                "fieldValue": "texto",
                "fieldSecondValue": "sem",
                "isCheck": false,
                "filtradoPorIndice": -1,
                "AtualizarIndice": -1,
                "NaoDisponivel": false,
                "NaoDisponivelMarcado": 0,
                "CalcularBtn": 0,
                "CalcularAtivo": 0,
                "filtrosMarcados": []
            },
            {
                "filter": "Toptalent",
                "label": "Toptalent",
                "url": "/lerfiltrotoptalent",
                "limite": 5,
                "posicao": 0,
                "total": 0,
                "ativo": true,
                "fieldId": "toptalent",
                "fieldValue": "texto",
                "fieldSecondValue": "sem",
                "isCheck": true,
                "filtradoPorIndice": -1,
                "AtualizarIndice": -1,
                "NaoDisponivel": false,
                "NaoDisponivelMarcado": 0,
                "CalcularBtn": 0,
                "CalcularAtivo": 0,
                "filtrosMarcados": []
            },
            {
                "filter": "Contatos",
                "label": "Contatos",
                "url": "/lerfiltrocontatos",
                "limite": 5,
                "posicao": 0,
                "total": 0,
                "ativo": true,
                "fieldId": "contatos",
                "fieldValue": "texto",
                "fieldSecondValue": "sem",
                "isCheck": true,
                "filtradoPorIndice": -1,
                "AtualizarIndice": -1,
                "NaoDisponivel": false,
                "NaoDisponivelMarcado": 0,
                "CalcularBtn": 0,
                "CalcularAtivo": 0,
                "filtrosMarcados": []
            },
            {
                "filter": "Sexo",
                "label": "Sexo",
                "url": "/lerlistasexo",
                "limite": 5,
                "posicao": 0,
                "total": 0,
                "ativo": true,
                "fieldId": "sexo",
                "fieldValue": "texto",
                "fieldSecondValue": "sem",
                "isCheck": false,
                "filtradoPorIndice": -1,
                "AtualizarIndice": -1,
                "NaoDisponivel": true,
                "NaoDisponivelMarcado": 0,
                "CalcularBtn": 0,
                "CalcularAtivo": 0,
                "filtrosMarcados": []
            },
            {
                "filter": "Dataaplicacao",
                "label": "Dataaplicacao",
                "url": "/lerfiltrodatadaaplicacao",
                "limite": 5,
                "posicao": 0,
                "total": 0,
                "ativo": true,
                "fieldId": "dataaplicacao",
                "fieldValue": "texto",
                "fieldSecondValue": "sem",
                "isCheck": true,
                "filtradoPorIndice": -1,
                "AtualizarIndice": -1,
                "NaoDisponivel": true,
                "NaoDisponivelMarcado": 0,
                "CalcularBtn": 0,
                "CalcularAtivo": 0,
                "filtrosMarcados": []
            },
            {
                "filter": "Estado",
                "label": "Estado",
                "url": "/lerlistaestados",
                "limite": 5,
                "posicao": 0,
                "total": 0,
                "ativo": true,
                "fieldId": "idestado",
                "fieldValue": "estado",
                "fieldSecondValue": "sem",
                "isCheck": true,
                "filtradoPorIndice": -1,
                "AtualizarIndice": -1,
                "NaoDisponivel": true,
                "NaoDisponivelMarcado": 0,
                "CalcularBtn": 0,
                "CalcularAtivo": 0,
                "filtrosMarcados": []
            },
            {
                "filter": "Cidade",
                "label": "Cidade",
                "url": "/lerlistacidades",
                "limite": 5,
                "posicao": 0,
                "total": 0,
                "ativo": true,
                "fieldId": "idcidade",
                "fieldValue": "cidade",
                "fieldSecondValue": "uf",
                "isCheck": true,
                "filtradoPorIndice": 4,
                "AtualizarIndice": -1,
                "NaoDisponivel": true,
                "NaoDisponivelMarcado": 0,
                "CalcularBtn": 1,
                "CalcularAtivo": 0,
                "filtrosMarcados": []
            },
            {
                "filter": "Area",
                "label": "Área",
                "url": "/lerlistaareas",
                "limite": 5,
                "posicao": 0,
                "total": 0,
                "ativo": true,
                "fieldId": "idarea",
                "fieldValue": "area",
                "fieldSecondValue": "sem",
                "isCheck": true,
                "filtradoPorIndice": -1,
                "AtualizarIndice": 7,
                "NaoDisponivel": true,
                "NaoDisponivelMarcado": 0,
                "CalcularBtn": 0,
                "CalcularAtivo": 0,
                "filtrosMarcados": []
            },
            {
                "filter": "SubArea",
                "label": "Subárea",
                "url": "/lerlistasubareas",
                "limite": 5,
                "posicao": 0,
                "total": 0,
                "ativo": true,
                "fieldId": "idsubarea",
                "fieldValue": "subarea",
                "fieldSecondValue": "sem",
                "isCheck": true,
                "filtradoPorIndice": 6,
                "AtualizarIndice": -1,
                "NaoDisponivel": true,
                "NaoDisponivelMarcado": 0,
                "CalcularBtn": 0,
                "CalcularAtivo": 0,
                "filtrosMarcados": []
            },
            {
                "filter": "Nivel",
                "label": "Nível",
                "url": "/lerlistaniveis",
                "limite": 5,
                "posicao": 0,
                "total": 0,
                "ativo": true,
                "fieldId": "idnivel",
                "fieldValue": "nivel",
                "fieldSecondValue": "sem",
                "isCheck": true,
                "filtradoPorIndice": -1,
                "AtualizarIndice": -1,
                "NaoDisponivel": true,
                "NaoDisponivelMarcado": 0,
                "CalcularBtn": 1,
                "CalcularAtivo": 0,
                "filtrosMarcados": []
            },
            {
                "filter": "Setor",
                "label": "Setor",
                "url": "/lerlistasetores",
                "limite": 5,
                "posicao": 0,
                "total": 0,
                "ativo": true,
                "fieldId": "idsetor",
                "fieldValue": "setor",
                "fieldSecondValue": "sem",
                "isCheck": true,
                "filtradoPorIndice": -1,
                "AtualizarIndice": -1,
                "NaoDisponivel": false,
                "NaoDisponivelMarcado": 0,
                "CalcularBtn": 1,
                "CalcularAtivo": 0,
                "filtrosMarcados": []
            },
            {
                "filter": "Empresa",
                "label": "Empresa",
                "url": "/lerlistaempresas",
                "limite": 10,
                "posicao": 0,
                "total": 0,
                "ativo": true,
                "fieldId": "idempresacargo",
                "fieldValue": "empresa",
                "fieldSecondValue": "sem",
                "isCheck": true,
                "filtradoPorIndice": -1,
                "AtualizarIndice": -1,
                "NaoDisponivel": false,
                "NaoDisponivelMarcado": 0,
                "CalcularBtn": 1,
                "CalcularAtivo": 0,
                "filtrosMarcados": []
            },
            {
                "filter": "Tamanhoempresa",
                "label": "Tamanhoempresa",
                "url": "/lerfiltrotamanhoempresas",
                "limite": 10,
                "posicao": 0,
                "total": 0,
                "ativo": true,
                "fieldId": "idtamanho",
                "fieldValue": "tamanho",
                "fieldSecondValue": "sem",
                "isCheck": true,
                "filtradoPorIndice": -1,
                "AtualizarIndice": -1,
                "NaoDisponivel": true,
                "NaoDisponivelMarcado": 0,
                "CalcularBtn": 1,
                "CalcularAtivo": 0,
                "filtrosMarcados": []
            },
            {
                "filter": "BotResp",
                "label": "Carla responde (Bot)",
                "url": "/lerlistabots",
                "limite": 5,
                "posicao": 0,
                "total": 0,
                "ativo": true,
                "fieldId": "tipobot",
                "fieldValue": "tipobot",
                "fieldSecondValue": "sem",
                "isCheck": true,
                "filtradoPorIndice": -1,
                "AtualizarIndice": -1,
                "NaoDisponivel": false,
                "NaoDisponivelMarcado": 0,
                "CalcularBtn": 0,
                "CalcularAtivo": 0,
                "filtrosMarcados": []
            },
            {
                "filter": "Competencia",
                "label": "Competência",
                "url": "/lerlistacompetencias",
                "limite": 5,
                "posicao": 0,
                "total": 0,
                "ativo": true,
                "fieldId": "idcompetencia",
                "fieldValue": "competencia",
                "fieldSecondValue": "sem",
                "isCheck": true,
                "filtradoPorIndice": -1,
                "AtualizarIndice": -1,
                "NaoDisponivel": false,
                "NaoDisponivelMarcado": 0,
                "CalcularBtn": 0,
                "CalcularAtivo": 0,
                "filtrosMarcados": []
            },
            {
                "filter": "Perfil",
                "label": "Perfil",
                "url": "/lerlistaperfis",
                "limite": 5,
                "posicao": 0,
                "total": 0,
                "ativo": true,
                "fieldId": "perfil",
                "fieldValue": "texto",
                "fieldSecondValue": "sem",
                "isCheck": true,
                "filtradoPorIndice": -1,
                "AtualizarIndice": -1,
                "NaoDisponivel": false,
                "NaoDisponivelMarcado": 0,
                "CalcularBtn": 0,
                "CalcularAtivo": 0,
                "filtrosMarcados": []
            },
            {
                "filter": "Nacionalidade",
                "label": "Nacionalidade",
                "url": "/lerfiltronacionalidade",
                "limite": 5,
                "posicao": 0,
                "total": 0,
                "ativo": true,
                "fieldId": "idnacionalidade",
                "fieldValue": "nacionalidade",
                "fieldSecondValue": "sem",
                "isCheck": true,
                "filtradoPorIndice": -1,
                "AtualizarIndice": -1,
                "NaoDisponivel": true,
                "NaoDisponivelMarcado": 0,
                "CalcularBtn": 1,
                "CalcularAtivo": 0,
                "filtrosMarcados": []
            },
            {
                "filter": "Idiomas",
                "label": "Idiomas",
                "url": "/lerfiltroidioma",
                "limite": 10,
                "posicao": 0,
                "total": 0,
                "ativo": true,
                "fieldId": "ididioma",
                "fieldValue": "idioma",
                "fieldSecondValue": "sem",
                "isCheck": true,
                "filtradoPorIndice": -1,
                "AtualizarIndice": -1,
                "NaoDisponivel": true,
                "NaoDisponivelMarcado": 0,
                "CalcularBtn": 0,
                "CalcularAtivo": 0,
                "filtrosMarcados": []
            },
            {
                "filter": "Interesse",
                "label": "Interesse",
                "url": "/lerlistainteresses",
                "limite": 5,
                "posicao": 0,
                "total": 0,
                "ativo": true,
                "fieldId": "interesse",
                "fieldValue": "texto",
                "fieldSecondValue": "sem",
                "isCheck": false,
                "filtradoPorIndice": -1,
                "AtualizarIndice": -1,
                "NaoDisponivel": false,
                "NaoDisponivelMarcado": 0,
                "CalcularBtn": 0,
                "CalcularAtivo": 0,
                "filtrosMarcados": []
            },
            {
                "filter": "Avaliados",
                "label": "Avaliados",
                "url": "/lerlistaavaliados",
                "limite": 5,
                "posicao": 0,
                "total": 0,
                "ativo": true,
                "fieldId": "avaliados",
                "fieldValue": "texto",
                "fieldSecondValue": "sem",
                "isCheck": false,
                "filtradoPorIndice": -1,
                "AtualizarIndice": -1,
                "NaoDisponivel": false,
                "NaoDisponivelMarcado": 0,
                "CalcularBtn": 0,
                "CalcularAtivo": 0,
                "filtrosMarcados": []
            },
            {
                "filter": "AcaoCandidato",
                "label": "Ação Candidato",
                "url": "/lerlistacandidatocontato",
                "limite": 5,
                "posicao": 0,
                "total": 0,
                "ativo": true,
                "fieldId": "acaocandidato",
                "fieldValue": "texto",
                "fieldSecondValue": "sem",
                "isCheck": true,
                "filtradoPorIndice": -1,
                "AtualizarIndice": -1,
                "NaoDisponivel": false,
                "NaoDisponivelMarcado": 0,
                "CalcularBtn": 0,
                "CalcularAtivo": 0,
                "filtrosMarcados": []
            },
            {
                "filter": "AcaoLinkedin",
                "label": "Ação Linkedin",
                "url": "/lerlistaacaolinkedin",
                "limite": 5,
                "posicao": 0,
                "total": 0,
                "ativo": true,
                "fieldId": "acaolinkedin",
                "fieldValue": "texto",
                "fieldSecondValue": "sem",
                "isCheck": true,
                "filtradoPorIndice": -1,
                "AtualizarIndice": -1,
                "NaoDisponivel": false,
                "NaoDisponivelMarcado": 0,
                "CalcularBtn": 0,
                "CalcularAtivo": 0,
                "filtrosMarcados": []
            }
        ];
        //console.log(filtersParam);
        getListFilters(idCliente, filtersParam);
        getClassificacao(idCliente);
        getListCandidatos(idCliente);
        SetaTipoExibicao();
        
        $("#buscar").click(function(){    
            SetaPesquisa();
            getListCandidatos(idCliente);
        });
        $("#classifica").change(function(){  
            SetaPesquisa();
            getListCandidatos(idCliente);
        });
        $("input[id='exibicao']").change(function(){
            SetaTipoExibicao();
            SetaPesquisa();
            getListCandidatos(idCliente);
        });
        $(".asideMenuFilter .filtersMenus .titleMenuFilter a.up").click(function(){ 
            let obj = $(this).parent().parent();
            let caixa = obj.find("section.filterCheck");
            let btn = obj.find(".btnMore");
            if(!Vazio(caixa))
            {
                if(caixa.css("display") == "none")
                {
                    caixa.css("display","block");
                    btn.css("display","block");
                    $(this).find("i").removeClass("fa-chevron-down").addClass("fa-chevron-up");
                }
                else
                {
                    caixa.css("display","none");
                    btn.css("display","none");
                    $(this).find("i").removeClass("fa-chevron-up").addClass("fa-chevron-down");
                }
            }
        });    
        $(".asideMenuFilter .filtersMenus .titleMenuFilter a.limpar").click(function(){ 
            let obj = $(this).parent().parent();
            let caixa = obj.find("section.filterCheck ul");
            let nome = caixa.get(0).id;
            if(Vazio(nome))
                return;
            $('#'+nome+' li label').each(function( index ) {
                let check = $(this).parent().find('input[type="checkbox"]');
                let cheched = check.get(0).checked;
                if(!Vazio(cheched))
                {
                    $(this).trigger( "click" );
                    check.get(0).checked = false;
                }
            });
            console.log(caixa);
        });
        $('#reloadgrid').click(function(){
            if($(".listaCand").hasClass("listaCandBloco")) {
                $('.listaCand').removeClass('listaCandBloco');
                $('#reloadgrid').html('');
                $('#reloadgrid').append('<i class="fas fa-list"></i>');
                $('.iconBlocos').remove();
            }else{
                $('.listaCand').addClass('listaCandBloco');
                $('#reloadgrid').html('');
                $('#reloadgrid').append('<i class="fas fa-th-large"></i>');
                $('.dadosCand > form >  .grupo:first-child').prepend('<div class="iconBlocos"><i class="fas fa-briefcase"></i><i class="far fa-address-card"></i></div>');
            }
        });
        $(window).scroll(function() {
            if ( $(this).scrollTop() > 600 ) {
                $('#topcandidato').addClass('show');
            } else {
                $('#topcandidato').removeClass('show');
            }
        });
        
        bloqueio_ctrl_C = false;
        SetabloquearCopia();
    });

    function iniciarExportacao(obj = null)
    {
        $('#modal-exportar-candidato').modal('show');
        html = `<div class="col-md-12">
                    <div class="progress">
                    <div class="progress-bar progress-bar-striped bg-success" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>`;
        $('#areaexportar').html(html);
        ExportarCandidato("", 0, 0);
    }
    function ExportarCandidato(file = "", posicao = 0, total = 0)
    {
        let url = GetUrlAcao("api","exportarcandidato");
        data = montaFilters(idCliente);
        data["file"] = file;
        data["posicao"] = posicao;
        data["total"] = total;
        
        $.ajax({
            url: url,
            method:'POST',
            data:data,
            beforeSend:function(xhr){
                let aux = total;
                if(Vazio(aux))
                    aux = 1;
                let porcente = Math.round((posicao / aux) * 100);
                let texto = posicao+' / '+total;
                $('#areaexportar .progress .progress-bar').css('width', porcente+'%').html(texto);
                $('#areaexportar .progress .progress-bar').attr("aria-valuenow", porcente);
            },
            success:function(data){
                if(data.sucesso)
                {
                    titulo = data.titulo;
                    msn = data.mensagem;
                    MsnSucesso(titulo, msn);
                    if(data.finalizado)
                    {
                        let texto = `${data.total}/${data.total} Exportação de candidatos finalizada.`;
                        $('#areaexportar .progress .progress-bar').css('width', '100%').html(texto);
                        html = `<div class="col-md-12">
                                <a id="downExpotar" href="${data.url}" target="_blank" class="btn btn-green pull-right">
                                    <i class="fas fa-cloud-download-alt"></i> <?php echo __("Download da exportação") ?>
                                </a>
                                <span style="font-size: 18px;"> <?php echo __("Caso o documento não seja baixado automaticamente, clique aqui"); ?></span>
                                </div>`;
                        $('#areaexportar').html(html);
                        window.open(data.url, "_blank");
                    }
                    else
                    {
                        ExportarCandidato(data.file, data.posicao, data.total);
                    }
                }
                else
                {
                    msn = data.erro;
                    alert(msn);
                }
            },
            error: function(XHR, textStatus, errorThrown){
                let msn = "<?php echo __("Falha na exportação de candidatos");?>";
                alert(msn);
            }
        });
    }
    function SetaTipoExibicao()
    {
        if(getTipoExibicao() == "lista")
        {
            $(window).scroll(function() {
                let altura = $(this).scrollTop() + $(this).height() + 20;
                let heigth = $(document).height();
                if ( altura >= heigth) {
                    // a rolagem chegou ao fim, fazer algo aqui. 
                    if(Vazio(carregandocandidato))
                    {
                        carregandocandidato = true;
                        getListCandidatos(idCliente);
                    }
                }
            });
        }
        else
        {
            
            $("body").keydown(function(e) {
                                    
                if((e.which == 39)||(e.keyCode == 39)) {
                    $(".grupodirecao a[data-direcao='proximo']").trigger('click');
                }
                if((e.which == 37)||(e.keyCode == 37)) {
                    $(".grupodirecao a[data-direcao='voltar']").trigger('click');
                }
            });
        }
    }
    function highlight(mask = "", texto = "")
    {
        return texto.replace(new RegExp(mask + '(?!([^<]+)?<)', 'gi'), '<mask>$&</mask>' );
    }
    //Retorna o Header dos cards
    function getHeaderCard(element) {  
        let local = "";
        let Novo = "";
        let Nome = "";
        let copia = "";
        let empresaAtual = "";
        let buscar = $(".headerFilter #buscarInput").val();
        if((!Vazio(element.cidade))&&(!Vazio(element.uf)))
        {
            local = `${element.cidade} - ${element.uf}`;
        }
        else if((!Vazio(element.cidade))&&(!Vazio(element.estado)))
        {
            local = `${element.cidade} - ${element.estado}`;
        }
        else if(!Vazio(element.cidade))
        {
            local = `${element.cidade}`;
        }
        else if(!Vazio(element.uf))
        {
            local = `${element.uf}`;
        }
        else if(!Vazio(element.estado))
        {
            local = `${element.estado}`;
        }
        if(!Vazio(element.novo))
        {
            if(element.novo == "Sim")
            {
                Novo = ` <span></span>`;
            }
        }
        if(!Vazio(buscar))
        {
            Nome = highlight(buscar, element.nome);
        }
        else
        {
            Nome = element.nome;
        }
        if(Vazio(Nome))
        {
            Nome = "Nome não foi divulgado";
        }
        if(acesso == "Cliente")
        {
            card2 = " carduser2";
            Novo = '';
        }
        else
        {
            card2 = "";
            if(!Vazio(element.cargos))
            {
                element.cargos.forEach(item => {
                    if(Vazio(empresaAtual))
                    {
                        if (item.atual == 'Sim')
                        {
                            empresaAtual = item.empresa;
                        }
                        else
                        {
                            empresaAtual = item.empresa;
                        }
                    }
                });
            }
            else
            {
                empresaAtual = "";
            }
            copiar = ` onclick="CopiarNomeEmpresa('${element.nome}', '${empresaAtual}');"`;
            copiar = `<a href="javascript:;" ${copiar} title="Copiar nome e empresa atual" class="btn-copiar"><i class="far fa-copy"></i></a>`;
        }
        var conteudoHeader = `
                    <div class="listaCand${card2}">
                    <section class="tituloCand">
                    <h3>${Nome}${Novo}${copiar}</h3>
                    <div><i class="fas fa-map-marker-alt"></i> ${local}</div>
                    </section>`;
        return conteudoHeader;
    };

    //Retorna os buttons dos cards e suas acoes
    function getButtonsCard(element) {
        var linkedin = element.linkedin;
        var telefone = element.telefone;
        var email = element.email;
        var idvaga = $("#idvaga").val();
        var linkFavorito = "";
        var linkFavoritogrupo = "";
        var delete_btn = "";
        var whatsapp = "";
        var linkToptalent = element.toptalent;
        var linkPlacement = element.placement;
        var linkFinalista = element.finalista;
        var linkAbordagem = element.abordagem;
        var Avaliador_btn = "";
        var NotasAvaliacao_btn = "";
        var ValorSalario_btn = "";
        var perfiltecnico_btn = "";
        var linkPDF_btn = "";
        var linkInteresse = "";
        var linkDesconsiderado = "";
        var linkCandidatoExtensao = "";
        var linkRetornoinvitelkd = "";
        var linkLinkedinDesatualizado = "";
        var corRetornoinvitelkd = "";
        
        if(Vazio(linkedin))
        {
            linkedin = "";
        }
        else
        {
            if(acesso != "Cliente")
            {
                aux = linkedin.replace('https://','').replace('http://','');
                linkedin = `<a href="https://${aux}" target="_blank" data-codigo="VisualLKD" data-vaga="${idvaga}" data-candidato="${element.idcandidato}" ><i class="fab fa-linkedin-in"></i></a>`;
            }
            else
            {
                linkedin = `<a href="javascript:;" onclick="PropupCandidato(this, ${element.idcandidato}, ${idvaga})" data-codigo="VisualEdit" data-vaga="${idvaga}" data-candidato="${element.idcandidato}"><i class="fab fa-linkedin-in"></i></a>`;
            }
        }
        if(Vazio(telefone))
        {
            telefone = "";
            whatsapp = "";
        }
        else
        {
            telefone = `<a href="javascript:;" onclick="PropupCandidato(this, ${element.idcandidato}, ${idvaga})" data-codigo="VisualEdit" data-vaga="${idvaga}" data-candidato="${element.idcandidato}"><i class="fas fa-phone-volume"></i></a>`;
        }
        if(Vazio(email))
        {
            email = "";
        }
        else
        {
            email = `<a href="javascript:;" onclick="PropupCandidato(this, ${element.idcandidato}, ${idvaga})" data-codigo="VisualEdit" data-vaga="${idvaga}" data-candidato="${element.idcandidato}"><i class="far fa-envelope"></i></a>`;
        }
        if(!Vazio(idvaga))
        {
            if(acesso != "Cliente")
            {
                let tituloGrupo1 = "Marcar candidato com favorito 1";
                let tituloGrupo2 = "Marcar candidato com favorito 2";
                let tituloGrupo3 = "Marcar candidato com favorito 2";
                let marcadoGrupo1 = "0";
                let marcadoGrupo2 = "0";
                let marcadoGrupo3 = "0";
                let onclick = `href="javascript:;" onclick="MarcarFavoritoGrupo(this, ${element.idcandidato}, ${idvaga})" class="btn-grupo"`;
                if(element.favoritogrupo == "Favorito 1")
                {
                    tituloGrupo1 = "Desmarcar candidato com favorito 1";
                    marcadoGrupo1 = "1";
                }
                else if(element.favoritogrupo == "Favorito 2")
                {
                    tituloGrupo2 = "Desmarcar candidato com favorito 2";
                    marcadoGrupo2 = "1";
                }
                else if(element.favoritogrupo == "Favorito 3")
                {
                    tituloGrupo3 = "Desmarcar candidato com favorito 3";
                    marcadoGrupo3 = "1";
                }

                linkFavoritogrupo = `
                <a ${onclick} data-marcado="${marcadoGrupo1}" data-tipo="Favorito 1" title="${tituloGrupo1}">
                    &#x278A;
                </a>
                <a ${onclick} data-marcado="${marcadoGrupo2}" data-tipo="Favorito 2" title="${tituloGrupo2}">
                    &#x278B;
                </a>
                <a ${onclick} data-marcado="${marcadoGrupo3}" data-tipo="Favorito 3" title="${tituloGrupo3}">
                    &#x278C;
                </a>`;
                if(element.favorito == "Sim")
                    linkFavorito = `<a href="javascript:;" onclick="MarcarFavorito(this, ${element.idcandidato}, ${idvaga})" data-marcado="1" title="Desmarcar candidato com favorito"><i class="fas fa-heart yellow"></i></a>`;
                else
                    linkFavorito = `<a href="javascript:;" onclick="MarcarFavorito(this, ${element.idcandidato}, ${idvaga})" data-marcado="0"  title="Marcar candidato com favorito"><i class="far fa-heart"></i></a>`;
                if(element.desconsiderado == "Sim")
                    linkDesconsiderado = `<a href="javascript:;" onclick="MarcarDesconsiderado(this, ${element.idcandidato}, ${idvaga})" data-marcado="1" title="Reconsiderar candidato para esta vaga"><i class="far fa-thumbs-up"></i></a>`;
                else
                    linkDesconsiderado = `<a href="javascript:;" onclick="MarcarDesconsiderado(this, ${element.idcandidato}, ${idvaga})" data-marcado="0" title="Desconsiderar o candidato para esta vaga"><i class="far fa-thumbs-down"></i></a>`;
                if(element.interesse == "Sim")
                    linkInteresse = `<a href="javascript:;" title="Candidato tem interesse nesta vaga"><i class="far fa-handshake"></i></a>`;
                else
                    linkInteresse = ``;
                if(!Vazio(linkToptalent))
                {
                    if(linkToptalent == "Sim")
                        delete_btn += `<a href="javascript:;" title="Desmarcar candidato com toptalent" onclick="MarcarToptalent(this, ${element.idcandidato}, ${idvaga})" data-toptalent="Não"><i class="fas fa-user-times"></i></a>`;
                    else
                        delete_btn += `<a href="javascript:;" title="Marcar candidato com toptalent" onclick="MarcarToptalent(this, ${element.idcandidato}, ${idvaga})" data-toptalent="Sim"><i class="fas fa-user-check"></i></a>`;
                }
                delete_btn += `<a href="javascript:;" title="Deletar Candidato" onclick="DeleteCandidato(this, ${element.idcandidato}, ${idvaga})"><i class="fas fa-times-circle"></i></a>`;
                linkCandidatoExtensao = `<a href="javascript:;" onclick="PropupCandidatoExtensao(this, ${element.idcandidato}, ${idvaga})" data-codigo="VisualEdit" data-vaga="${idvaga}" data-candidato="${element.idcandidato}"><i class="far fa-edit"></i></a>`;
                if(!Vazio(element.retornoinvitelkd))
                {
                    corRetornoinvitelkd = ` style="color: #34b503;"`;
                }
                linkRetornoinvitelkd = `<a href="javascript:;" onclick="EditarRetornoInviteLKD(this, ${element.idcandidato}, ${idvaga})" data-codigo="VisualEdit" data-vaga="${idvaga}" data-candidato="${element.idcandidato}" title="Editar retorno invite no linkedin"><i class="fa fa-upload"${corRetornoinvitelkd}></i></a>`;
                if(element.linkedin_desatualizado == "Sim")
                    linkLinkedinDesatualizado = `<a href="javascript:;" onclick="MarcarLinkedinDesatualizado(this, ${element.idcandidato}, ${idvaga})" data-marcado="1" title="Desmarcar candidato como linkedin desatualizado"><i class="el el-check"></i></a>`;
                else
                    linkLinkedinDesatualizado = `<a href="javascript:;" onclick="MarcarLinkedinDesatualizado(this, ${element.idcandidato}, ${idvaga})" data-marcado="0"  title="Marcar candidato como linkedin desatualizado"><i class="el el-check-empty"></i></a>`;
            }
            if(acesso == "Avaliador")
            {
                if(Vazio(element.idavaliacao))
                {
                    Avaliador_btn = `<a href="javascript:;" title="Avaliar Candidato" onclick="Avaliavar(this, ${element.idcandidato})"><i class="fas fa-chalkboard-teacher"></i></a>`;
                }
                else
                {
                    Avaliador_btn = `<a href="javascript:;" title="Reavaliar Candidato" onclick="Avaliavar(this, ${element.idcandidato})"><i class="fas fa-chalkboard-teacher verde"></i></a>`;
                }
            }
        }
        if(!Vazio(linkToptalent))
        {
            if(linkToptalent == "Sim")
                linkToptalent = `<a id="linkTopTalent${element.idcandidato}" href="javascript:;" title="Candidato TopTalent"><i class="fa fa-star green"></i></a>`;
            else
                linkToptalent = "";
        }
        else
            linkToptalent = "";
        
        if(!Vazio(linkPlacement))
        {
            if(linkPlacement == "Sim")
                linkPlacement = `<a id="linkPlacement${element.idcandidato}" href="javascript:;" title="Candidato placement"><i class="icone_placement"></i></a>`;
            else
                linkPlacement = "";
        }
        else
            linkToptalent = "";
        if(!Vazio(linkFinalista))
        {
            if(linkFinalista == "Sim")
                linkFinalista = `<a id="linkTopTalent${element.idcandidato}" href="javascript:;" title="Candidato é um finalista"><i class="fa fa-user-plus "></i></a>`;
            else
                linkFinalista = "";
        }
        else
            linkFinalista = "";
        
        if(!Vazio(linkAbordagem))
        {
            if(linkAbordagem == "Associado")
            {
                linkAbordagem = `<a id="linkAbordagem${element.idcandidato}" href="javascript:;" title="Candidato é Associado" onclick="PropUpMarcarAbordagem(this, ${element.idcandidato}, ${idvaga})" data-tipo="Associado"><i class="fas fa-user-plus  btn-Associado"></i></a>`;
            }
            else if(linkAbordagem == "Researcher")
            {
                linkAbordagem = `<a id="linkAbordagem${element.idcandidato}" href="javascript:;" title="Candidato é Researcher" onclick="PropUpMarcarAbordagem(this, ${element.idcandidato}, ${idvaga})" data-tipo="Researcher"><i class="fas fa-user-times  btn-Researcher"></i></a>`;
            }
            else
            {
                linkAbordagem = `<a id="linkAbordagem${element.idcandidato}" href="javascript:;" title="Candidato não foi abordado" onclick="PropUpMarcarAbordagem(this, ${element.idcandidato}, ${idvaga})" data-tipo=""><i class="fas fa-user-cog"></i></a>`;
            }
        }
        else
        {
            linkAbordagem = `<a id="linkAbordagem${element.idcandidato}" href="javascript:;" title="Candidato não foi abordado" onclick="PropUpMarcarAbordagem(this, ${element.idcandidato}, ${idvaga})" data-tipo=""><i class="fas fa-user-cog"></i></a>`;
        }
        if(element.interessemercado == "Sem interesse")
        {
            NotasAvaliacao_btn = `<div class="sem_interesse"  title="Candidato sem interesse"><i class="fas fa-user-slash"></i></div>`;
        }
        else
        {
            if(!Vazio(element.notasavaliacao))
            {
                let lista = '';
                element.notasavaliacao.forEach(item => { 
                    if(Vazio(item.valor))
                    {
                        return;
                    }
                    if(Vazio(lista))
                        lista += `<span title="${item.titulo}">${item.valor}</span>`;
                    else
                        lista += `<b>/</b><span title="${item.titulo}">${item.valor}</span>`;
                });
                    
                if(!Vazio(lista))
                {
                    NotasAvaliacao_btn = `<div class="listaAvaliacoes">${lista}</div>`;
                }
            }
        }
        if(!Vazio(element.salariofixomensal))
        {
            aux = new Intl.NumberFormat('pt-BR', { minimumFractionDigits: 2 }).format(element.salariofixomensal);
            ValorSalario_btn = `<div class="salariofixo" title="Valor do salário fixo mensal do candidato">R$ ${aux}</div>`;
        }
        if(!Vazio(element.perfiltecnicocomportamental))
        {
            if(element.perfiltecnicocomportamental == "Sim")
                perfiltecnico_btn = `<div class="perfiltecnico" title="Tem perfil técnico comportamental"><i class="fas fa-users"></i></div>`;
            else
                perfiltecnico_btn = `<div class="naoperfiltecnico" title="Não tem perfil técnico comportamental"><i class="fas fa-users-slash"></i></div>`;
        }
        if(acesso != "Cliente")
        {
            if(!Vazio(element.pdf))
            {
                linkPDF_btn = `<a href="javascript:;" title="Desmarcar candidato com toptalent" onclick="MarcarToptalent(this, ${element.idcandidato})" data-link="${element.pdf}"><i class="far fa-file-pdf"></i></a>`;
            }
        }
        var conteudoButtons = `<section class="buttonCand">
                            ${linkFavoritogrupo}
                            ${linkToptalent}
                            ${NotasAvaliacao_btn}
                            ${ValorSalario_btn}
                            ${perfiltecnico_btn}
                            ${linkPlacement}
                            ${linkFinalista}
                            ${linkAbordagem}
                            ${Avaliador_btn}
                            ${linkLinkedinDesatualizado}
                            ${linkRetornoinvitelkd}
                            ${linkInteresse}
                            ${linkedin}
                            ${telefone}
                            ${email}
                            ${linkFavorito}
                            ${linkDesconsiderado}
                            ${linkCandidatoExtensao}
                            ${linkPDF_btn}
                            ${delete_btn}
                            </section>`;
        return conteudoButtons;
    };

    //Retorna todo o corpo dos cards
    function getBodyCard(element) {
        var data = new Date()
        var day  = data.getDate();
        var month = data.getMonth() + 1;
        var year  = data.getFullYear();
        var dataaplicacao = '';
        var idiomas = '';
        var perfil = '';
        var buscar = $(".headerFilter #buscarInput").val();

        // Tratamento para as empresas atuais e anteriores
        var empresaAtual, empresaAnt = ''
        
        if(!Vazio(element.cargos))
        {
            element.cargos.forEach(item => {
                let anotexto = '';
                let descricao = '';
                let empresa = '';
                let cargo = '';
                if((item.inicio <= 1970)||(item.inicio > year))
                    item.inicio = 0;
                if((item.termino <= 1970)||(item.termino > year))
                    item.termino = 0;
                if((!Vazio(item.inicio))&&(!Vazio(item.termino)))
                    anotexto = `${item.inicio} - ${item.termino}`;
                else if(!Vazio(item.inicio))
                    anotexto = `${item.inicio} - Atual`;
                if(acesso != "Cliente")
                {    
                    if(!Vazio(item.descricao))
                    {
                        if(!Vazio(buscar))
                        {
                            item.descricao = highlight(buscar, item.descricao);
                        }
                        nomeClasse = "ativo Avaliador";
                        vermais_btn = '<a class="vermais" href="javascript:;" onclick="VerMais(this)" data-mais="1">Ver menos</a>';
                        parte = item.descricao
                        descricao = `
                            <div class="descricao ${nomeClasse}">
                                <strong>${parte}</strong>
                                ${vermais_btn}
                            </div>`; 
                    }
                }
                if(!Vazio(buscar))
                {
                    empresa = highlight(buscar, item.empresa);
                    cargo = highlight(buscar, item.cargo);
                }
                else
                {
                    empresa = item.empresa;
                    cargo = item.cargo;
                }

                if (item.atual == 'Sim'){
                    empresaAtual = `
                    <div class="campo">
                        <div class="inputtext" id="empAtual_${element.idcandidato}_${item.idcandidatocargo}_${item.idcargo}">${empresa}</div>
                        <div class="inputtext" id="empCargo_${element.idcandidato}_${item.idcandidatocargo}_${item.idcargo}">${cargo}</div>
                        <div class="inputtext" id="empAnoAtua_${element.idcandidato}_${item.idcandidatocargo}_${item.idcargo}">${anotexto}</div>
                    </div>${descricao}`;
                }else{
                    empresaAnt+= `
                    <div class="campo">
                        <div class="inputtext" id="empAnt_${element.idcandidato}_${item.idcandidatocargo}_${item.idcargo}">${empresa}</div>
                        <div class="inputtext" id="empCargo_${element.idcandidato}_${item.idcandidatocargo}_${item.idcargo}">${cargo}</div>
                        <div class="inputtext" id="empAnoAnt_${element.idcandidato}_${item.idcandidatocargo}_${item.idcargo}">${anotexto}</div>
                    </div>${descricao}`;
                }
            });
        }

        if(!empresaAtual){
            empresaAtual=``;
        }
        if(acesso != "Cliente")
        {
            //Tratamento para as competencias
            competencias = '';
            if(element.competencias){
                element.competencias.forEach(item => {
                    competencias += `<li>${item.competencia}</li>`;
                });
            }else{
                competencias = '';
            }
            //Tratamento para as idiomas
            sexo = '';
            if(element.sexo){
                sexo = `<li>${element.sexo}</li>`;
            }
            //Tratamento para a Perfis target definidos pelo cliente
            perfil = '';
            if(!Vazio(element.perfil))
            {
                perfil += `<li>${element.perfil}</li>`;
            }
            //Tratamento para os bots audios
            audiosBots = '';
            if(element.bots){
                element.bots.forEach(item => {
                    audiosBots += `
                    <div class="campo">
                        <label for="empresa1">${item.tipo}</label>
                        <audio src="${item.audio}" controls>
                            <p>Seu nevegador não suporta o elemento audio.</p>
                        </audio>
                    </div>`;
                });
            }else{
                audiosBots = '';
            }

            //Tratamento para as vagas
            vagasAssociadas = '';
            if(element.vagas){
                element.vagas.forEach(item => {
                    vagasAssociadas += `
                    <div class="campo">
                        <label>${item.titulodavaga}</label>
                        <label>#${item.codigovaga}</label>
                    </div>`;
                });
            }else{
                vagasAssociadas = '';
            }
        }
        else
        {
            competencias = '';
            sexo = '';
            perfil = '';
            audiosBots = '';
            vagasAssociadas = '';
        }
        
        //Tratamento para a data de aplicação
        dataaplicacao = '';
        if(!Vazio(element.dataaplicacao))
        {
            let aux = element.dataaplicacao;
            let data = new Date(aux);
            let now = new Date();
            let diff = 0;
            let days = 0;
            
            diff = Math.abs(now.getTime() - data.getTime());
            days = Math.ceil(diff / (1000 * 60 * 60 * 24));
            if(days <= 30)
            {
                aux = "Até 30 dias";
            }
            else if(days <= 90)
            {
                aux = "De 30 até 90 dias";
            }
            else if(days <= 180)
            {
                aux = "De 90 até 180 dias";
            }
            else
            {
                aux = "Mais de 180 dias";
            }
            dataaplicacao += `<li>${aux}</li>`;
        }
        //Tratamento para as idiomas
        idiomas = '';
        if(element.idiomas){
            element.idiomas.forEach(item => {
                idiomas += `<li>${item.idioma}</li>`;
            });
        }
        else
        {
            idiomas += `<li>Não disponível</li>`;
        }
        //Tratamento para as certificados
        certificados = '';
        if(element.certificados){
            element.certificados.forEach(item => {
                certificados += `
                    <div class="campo">
                        <div class="inputtext" id="certificado_${element.idcandidato}_${item.idcertificado}">${item.certificado}</div>
                        <div class="inputtext" id="emissor_${element.idcandidato}_${item.idcertificado}">${item.emissor}</div>
                        <div class="inputtext" id="emitido_${element.idcandidato}_${item.idcertificado}">${item.emitido}</div>
                    </div>`;
            });
        }
        if(!Vazio(empresaAtual))
        {            
            if(acesso != "Cliente")
            {
                nomeClasse = "Avaliador";
            }
            else
            {
                nomeClasse = "";
            }
            empresaAtual = `
                <div class="grupo">
                    <div class="titulo" style="min-height: 5rem;">
                        <label for="empresa1">Experiência profissional</label>
                    </div>
                    <div class="corpo ${nomeClasse}">
                        ${empresaAtual}
                    </div>
                </div>`;
        }
        if(!Vazio(empresaAnt))
        {
            if(!Vazio(empresaAtual))
            {
                label = "";
            }
            else
            {
                label = "Experiência profissional";
            }
            if(acesso != "Cliente")
            {
                classeAcesso = " corpo_acesso Avaliador";
            }
            else
            {
                classeAcesso = "";
            }
            if(acesso == "Avaliador")
            {
                classeAcesso = " corpo_acesso Avaliador";
            }
            empresaAnt = `
                <!--Historico de empresas-->
                <div class="grupo">
                    <div class="titulo topo" style="min-height: 5rem;">
                        <label for="empresa2">${label}</label>
                    </div>
                    <div class="corpoList style-1${classeAcesso}">
                        ${empresaAnt}
                    </div>
                </div>`;
        }
        if(!Vazio(competencias))
        {
            competencias = `
                <div class="grupo"><!--Competencias-->
                    <div class="titulo" style="min-height: 5rem;">
                        <label for="Comp">Competências</label>
                    </div>
                    <div class="corpoComp">
                        <ul>
                            ${competencias}
                        </ul>
                    </div>
                </div>`;
        }
        if(!Vazio(dataaplicacao))
        {
            dataaplicacao = `
                <div class="grupo"><!--Data de aplicação-->
                    <div class="titulo" style="min-height:4rem;">
                        <label for="Comp">Data de aplicação</label>
                    </div>
                    <div class="corpoComp">
                        <ul>
                            ${dataaplicacao}
                        </ul>
                    </div>
                </div>`;
        }
        if(!Vazio(sexo))
        {
            sexo = `
                <div class="grupo"><!--idiomas-->
                    <div class="titulo" style="min-height:3rem;">
                        <label for="Comp">Gênero</label>
                    </div>
                    <div class="corpoComp">
                        <ul>
                            ${sexo}
                        </ul>
                    </div>
                </div>`;
        }
        if(!Vazio(idiomas))
        {
            idiomas = `
                <div class="grupo"><!--idiomas-->
                    <div class="titulo" style="min-height:4rem;">
                        <label for="Comp">Idiomas</label>
                    </div>
                    <div class="corpoComp">
                        <ul>
                            ${idiomas}
                        </ul>
                    </div>
                </div>`;
        }
        if(!Vazio(certificados))
        {
            certificados = `
                <div class="grupo grupocertificados"><!--Licenças e certificados-->
                    <div class="titulo" style="min-height:4rem;">
                        <label for="Comp">Licenças e certificados</label>
                    </div>
                    <div class="corpo">
                        ${certificados}
                    </div>
                </div>`;
        }
        if(!Vazio(perfil))
        {
            perfil = `
                <div class="grupo"><!--Data de aplicação-->
                    <div class="titulo" style="min-height:4rem;">
                        <label for="Comp">Perfis target definidos pelo cliente</label>
                    </div>
                    <div class="corpoComp">
                        <ul>
                            ${perfil}
                        </ul>
                    </div>
                </div>`;
        }
        if(!Vazio(audiosBots))
        {
            audiosBots = `
                <div class="grupo"><!--Bot audios-->
                    <div class="titulo" style="min-height: 5rem;">
                        <label for="Comp">Carla responde (Bot)</label>
                    </div>
                    <div class="corpoAudios">
                        ${audiosBots}
                    </div>
                </div>`;
        }
        if(!Vazio(vagasAssociadas))
        {
            vagasAssociadas = `
            <div class="grupo" style="margin-bottom: 1rem;"><!--Bot audios-->
                    <div class="titulo" style="min-height: 7rem;">
                        <label for="Comp">Vagas Associadas</label>
                    </div>
                    <div class="corpoVagas">
                        ${vagasAssociadas}
                    </div>
                </div>`;
        }
        var counteudoBody = `<section class="dadosCand">
            <form id="dadosCandForm${element.idcandidato}">
                ${empresaAtual}
                ${empresaAnt}
                ${dataaplicacao}
                ${sexo}
                ${idiomas}
                ${certificados}
                ${perfil}
                ${competencias}
                ${audiosBots}
                ${vagasAssociadas}
            </form>
        </section>`;
        return counteudoBody;
    };
    //Retorna todo o corpo dos cards
    function getDetalhesCard(element) {
        var data = new Date()
        var day  = data.getDate();
        var month = data.getMonth() + 1;
        var year  = data.getFullYear();
        var idvaga = $("#idvaga").val();
        var vaga = null;
        var informacoes = "";

        contatos = '';
        if(!Vazio(element.email))
        {
            aux = element.email;
            contatos += `
            <div>
                <span>E-mail</span>
                <a href="maito:${aux}" target="_blank" data-codigo="ClickEmail" data-vaga="${idvaga}" data-candidato="${element.idcandidato}">${element.email}</a>
            </div>`;
        }
        if(!Vazio(element.telefone))
        {
            aux = element.telefone.replace(/([^0-9])/g,'');
            whatsapp = TelefoneWhatsapp(element.telefone);
            aux = ``;
            aux = `https://api.whatsapp.com/send?phone=${whatsapp}&amp;text=${aux}`;

            whatsapp = `<a class="btn_whats" href="${aux}" target="_blank" data-codigo="VisualEdit" data-vaga="${idvaga}" data-candidato="${element.idcandidato}"><i class="fab fa-whatsapp-square"></i></a>`;
            contatos += `
            <div>
                <span>Telefone</span>
                <a href="tel:${aux}" target="_blank" data-codigo="ClickTel" data-vaga="${idvaga}" data-candidato="${element.idcandidato}">${element.telefone}</a>
                ${whatsapp}
            </div>`;
        }
        if(!Vazio(element.linkedin))
        {
            aux = element.linkedin.replace('https://','').replace('http://','');
            contatos += `
            <div>
                <span>URL Linkedin</span>
                <a href="https://${aux}" target="_blank" data-codigo="VisualLKD" data-vaga="${idvaga}" data-candidato="${element.idcandidato}">${aux}</a>
            </div>`;
        }
        if(!Vazio(element.twitter))
        {
            aux = element.twitter.replace('https://','').replace('http://','');
            contatos += `
            <div>
                <span>Twitter</span>
                <a href="https://${aux}" target="_blank" data-codigo="VisualTwitter" data-vaga="${idvaga}" data-candidato="${element.idcandidato}">${aux}</a>
            </div>`;
        }
        if(!Vazio(element.perfil))
        {
            aux = element.perfil;
            contatos += `
            <div>
                <span>Perfil</span>
                <samp>${aux}</samp>
            </div>`;
        }
        if(!Vazio(element.contatos))
        {
            let listagemcontatos = "";
            element.contatos.forEach(item => {
                let trocar = '';
                if(Vazio(item.idcliente))
                {
                    listagemcontatos += `
                        <a href="javascript:;" class="candidatocontato" onclick="MarcarContato(this)" data-idcandidatocontato="${item.idcandidatocontato}" data-idcandidato="${element.idcandidato}" data-idvaga="${element.idvaga}" data-tipo="${item.tipo}" data-idcliente="${item.idcliente}">
                            <i class="far fa-square"></i>
                            <samp>${item.tipo}</samp>
                            <samp></samp>
                            <samp></samp>
                        </a>`;
                }
                else
                {
                    if(item.idcliente != idCliente)
                    {
                        trocar = ' (trocar)';
                    }
                    listagemcontatos += `
                        <a href="javascript:;" class="candidatocontato" onclick="MarcarContato(this)" data-idcandidatocontato="${item.idcandidatocontato}" data-idcandidato="${element.idcandidato}" data-idvaga="${element.idvaga}" data-tipo="${item.tipo}" data-idcliente="${item.idcliente}">
                            <i class="fas fa-check-square"></i>
                            <samp>${item.tipo}</samp>
                            <samp> - ${item.cliente}, em ${item.cadastradoem}</samp>
                            <samp>${trocar}</samp>
                        </a>`;
                }
            });
            if(!Vazio(listagemcontatos))
            {
                contatos += listagemcontatos;
            }
        }
        if(!Vazio(contatos))
        {
            contatos = `
            <div class="links">
                ${contatos}
            </div>`;
        }
        
        vagasEficiencias = '';
        vagasHitoricos = '';
        dadosvaga = '';
        dadosvagaExtensao = '';
        if(acesso != "Cliente")
        {
            if(!Vazio(element.dadosempresa))
            {
                if(!Vazio(element.dadosempresa.nacionalidade))
                {
                    aux = element.dadosempresa.nacionalidade;
                    informacoes += `
                    <div>
                        <span>Perfil da empresa: </span>
                        <samp>${aux}</samp>
                    </div>`;
                }
                if(!Vazio(element.dadosempresa.setor))
                {
                    aux = element.dadosempresa.setor;
                    informacoes += `
                    <div>
                        <span>Setor: </span>
                        <samp>${aux}</samp>
                    </div>`;
                }
                if(!Vazio(element.dadosempresa.tamanho))
                {
                    aux = element.dadosempresa.tamanho;
                    informacoes += `
                    <div>
                        <span>Tamanho da empresa: </span>
                        <samp>${aux}</samp>
                    </div>`;
                }
                if(!Vazio(informacoes))
                {
                    informacoes = `
                    <div class="links">
                        <h5>Características da empresa atual</h5>
                        ${informacoes}
                    </div>`;
                }
            }
            if(element.assessments){
                element.assessments.forEach(item => {
                    vagasEficiencias += `
                    <li>
                        <a href="${item.link}">${item.titulo}</a>
                    </li>`;
                });
            }
            if(element.vagas){
                if(Vazio(idvaga))
                {
                    vaga = element.vagas[0];
                }
                element.vagas.forEach(item => {
                    if(idvaga == item.idvaga)
                    {
                        vaga = item;
                    }
                    vagasHitoricos += `
                    <li>
                        <i class="fas fa-angellist"></i>
                        <span>${item.cadastradoem} &bull; #${item.codigovaga}</span>
                        <h5>${item.titulodavaga}</h5>
                    </li>`;
                });
            }
            if(!Vazio(vaga))
            {
                classe = '';
                if(vaga.status == 'Cadastro incompleto da vaga') {
                    classe = 'cadastro-incompleto';
                }else if(vaga.status == 'Aguardando análise') {
                    classe = 'aguardando-analise';
                }else if(vaga.status == 'Candidatos disponíveis' ){
                    classe = 'candidatos-disponiveis';
                }else if((vaga.status == 'Concluido')||(vaga.status == 'Concluído')) {
                    classe = 'concluido';
                }else if(vaga.status == 'Cancelado pelo cliente') {
                    classe = 'cancelado-pelo-cliente';
                }
                dadosvaga = `
                <div class="dadosvaga">
                    <div class="captil">
                        <span>${vaga.cadastradoem}</span>
                        <a href="javascript:;" onclick="CloseDetalhesCandidato(this, ${element.idcandidato}, ${vaga.idvaga})">
                            <i class="far fa-times-circle"></i>
                        </a>
                        <span>#${vaga.codigovaga}</span>
                    </div>
                    <h3>
                        ${vaga.titulodavaga}
                    </h3>
                    <div class="status ${classe}">
                        <i class="fas fa-circle"></i>
                        ${vaga.status}
                    </div>
                    <button type="button" class="btn-destacar-candidato" data-id="${element.idcandidato}" data-idvaga="${vaga.idvaga}">
                        <i class="fas fa-star"></i>
                        Destacar Candidato
                    </button>
                    <button type="button" class="btn-remover-candidato" data-id="${element.idcandidato}" data-idvaga="${vaga.idvaga}">
                        <i class="fas fa-times"></i>
                        Remover Candidato dessa vaga
                    </button>
                    <button type="button" class="btn-contratar-candidato" data-id="${element.idcandidato}" data-idvaga="${vaga.idvaga}">
                        <i class="fas fa-check"></i>
                        Contratar Candidato
                    </button>
                </div>`;
                dadosvagaExtensao = `
                <div class="dadosvaga">
                    <div class="captil">
                        <a href="javascript:;" onclick="CloseDetalhesCandidatoExtensao(this, ${element.idcandidato}, ${vaga.idvaga})">
                            <i class="far fa-times-circle"></i>
                        </a>
                    </div>
                </div>`;
            }
        }
        if(!Vazio(vagasEficiencias))
        {
            vagasEficiencias = `
            <div class="eficiencia">
                <div class="captil">
                    <label for="Comp">Assessment</label>
                </div>
                <ul class="lista">
                    ${vagasEficiencias}
                </ul>
            </div>`;
        }
        if(!Vazio(vagasHitoricos))
        {
            vagasHitoricos = `
            <ul class="historicovaga">
                ${vagasHitoricos}
            </ul>`;
        }
        if(acesso != "Cliente")
        {
            var counteudoBody = `<section class="DetalhesCand">
                <div id="detalhesCard${element.idcandidato}" class="caixa">
                    <div class="info">
                        ${contatos}
                        ${vagasEficiencias}
                    </div>
                    <div class="acao">
                        ${dadosvaga}
                        ${vagasHitoricos}
                    </div>
                </div>
            </section>`;
            counteudoBody += `<section class="DetalhesCandExtensao">
                <div id="detalhesCardExtensao${element.idcandidato}" class="caixa">
                    <div class="info">
                        ${informacoes}
                    </div>
                    <div class="acao">
                        ${dadosvagaExtensao}
                    </div>
                </div>
            </section>`;
        }
        else
        {
            var counteudoBody = `<section class="DetalhesCand">
                <div id="detalhesCard${element.idcandidato}" class="caixa">
                    <div class="info">
                        Para ter acesso aos dados de contato dos profissionais adquira os planos de assinatura do Candidato Agora
                    </div>
                </div>
            </section>`;
        }
        return counteudoBody;
    };
    function putCheckboxFilters(element, tipo, id, value, secondValue, marcado = []){

        var idHtml = '';
        var total = element.total;
        var strTotal = '';
        var label = '';
        var labelCidadeEstado = '';
        var checked = '';
        var lista = ['FilterBotResp','AcaoCandidato','Avaliados']
        if (lista.includes(tipo)) {
            idHtml = eval("element."+id).replace(/\ /g, '_');   
        }
        else
        {
            idHtml = eval("element."+id);
        }
        if(!Vazio(total))
        {
            strTotal = new Intl.NumberFormat('pt-BR', { maximumSignificantDigits: 3 }).format(total);
            strTotal = ` (${strTotal})`;
        }
        if(!Vazio(marcado))
        {
            marcado.forEach(item => {
            if (item == idHtml){
                checked = ' checked';
            }
            });
        }
        label = `${eval("element."+value)}${eval("element."+secondValue) == '' || eval("element."+secondValue)===undefined? '' :', ' + eval("element."+secondValue)}`;
        conteudoFilter = `
        <li>
            <div class="checkbox">
                <input type="checkbox" id="${tipo}Checkbox${idHtml}"${checked} name="" value="${idHtml}">
                <label id="LblCheckbox${id}${idHtml}" onclick="checkout(this, '${idHtml}', '${id}', '${label}')" for="${tipo}Checkbox${idHtml}"><span>${label}${strTotal}</span></label>
            </div>
        </li>`;
        $('#Filter'+tipo).append(conteudoFilter);
    };
    function putCheckboxNaoDisponivel(item = null){

        var idHtml = item.label;
        var tipo = item.filter;
        var label = '';
        
        label = `N/D (Não Disponível)`;
        conteudoFilter = `
        <li>
            <div class="checkbox">
                <input type="checkbox" id="${tipo}CheckboxNaoDisponivel" name="" value="-1">
                <label id="LblCheckboxNaoDisponivel" onclick="checkoutNaoDisponivel(this, '${tipo}', '${idHtml} | ${label}')" for="${tipo}CheckboxNaoDisponivel"><span>${label}</span></label>
            </div>
        </li>`;
        $('#Filter'+tipo).append(conteudoFilter);
    };
    function DirecaoCandidato(obj = null){
        let total = parseInt($(obj).data("total"));
        let posicao = parseInt($(obj).data("posicao"));
        let direcao = $(obj).data("direcao");
        let titulo = '';
        let mensagem = '';
        $("#finalizado").val('false');
        if(direcao == "primeiro")
        {
            if((Vazio(posicao))||(posicao <= 0))
            {
                return;
            }
            posicao = 0;
        }
        else if(direcao == "voltar")
        {
            if((Vazio(posicao))||(posicao <= 0))
            {
                return;
            }
            posicao-= 2;
        }
        else if(direcao == "proximo")
        {
            if(((Vazio(posicao))||(posicao >= total)) && (posicao != 0))
            {
                return;
            }
        }
        else if(direcao == "ultimo")
        {            
            if(((Vazio(posicao))||(posicao >= total)) && (posicao != 0))
            {
                return;
            }
            posicao = (total - 1);
        }
        else
        {
            titulo = `Erro`;
            mensagem = `Ocorreu um erro inesperado ao navegar entre os candidatos`;
            MsnInfo(titulo, mensagem);
            return;
        }
        $("#posicao").val(posicao);
        setaTopo();
        getListCandidatos(idCliente);
    };
    function setaTopo(){
        let altura = 0;
        altura += $('.desktop div.title-breadcrumb').outerHeight(true);
        altura += $('#titulovagacandidato').outerHeight(true);
        altura += parseInt($('#containercandidato').css('padding-top'));
        altura += $('div.headerFilter').outerHeight(true);
        altura += $('div.asideExitFilter').outerHeight(true);
        console.log(altura, $('#containercandidato').css('padding-top'));
        $(document).scrollTop(altura);
        return;
    };
    function getDirecao(posicao = 0, total = 0){
        let label = '';
        let disablePrimeiro = '';
        let disableUltimo = '';
        if(Vazio(total))
        {
            return label;
        }
        if(posicao <= 1)
        {
            disablePrimeiro = ' disabled';
        }
        if(posicao >= total)
        {
            disableUltimo = ' disabled';
        }
        label = `
        <div class="grupodirecao">
            <div>
                <a href="javascript:void(0);" onclick="DirecaoCandidato(this)" ${disablePrimeiro} title="Ir para o primeiro candidato" data-posicao="${posicao}" data-total="${total}" data-direcao="primeiro">
                    <i class="fas fa-angle-double-left"></i>
                </a>
                <a href="javascript:void(0);" onclick="DirecaoCandidato(this)" ${disablePrimeiro} title="Voltar um candidato" data-posicao="${posicao}" data-total="${total}" data-direcao="voltar">
                    <i class="fas fa-angle-left"></i>
                </a>
                <label>${posicao}</label>
                <a href="javascript:void(0);" onclick="DirecaoCandidato(this)" ${disableUltimo} title="Ir para o próximo candidato" data-posicao="${posicao}" data-total="${total}" data-direcao="proximo">
                    <i class="fas fa-angle-right"></i>
                </a>
                <a href="javascript:void(0);" onclick="DirecaoCandidato(this)" ${disableUltimo} title="Ir para o último candidato" data-posicao="${posicao}" data-total="${total}" data-direcao="ultimo">
                    <i class="fas fa-angle-double-right"></i>
                </a>
            </div>
        </div>`;
        return label;
    };
    function getListCandidatos(idCliente = 0) {
        var dados = {};
        var conteudo = '';
        var finalizado = $("#finalizado").val();
        if(finalizado == "true")
            return;
        dados = montaFilters(idCliente);
        carregando(true);

        caminho = url + 'api/lerlistacandidatos/';
        $.ajax({
            url: caminho,
            data: dados,
            type: 'post',
            dataType: 'json',
            contentType: 'application/x-www-form-urlencoded',
            success: function (data) {
            },
        }).done(function(data) {
            carregando(false);
            if (data != null && data.sucesso && data.lista){
                data.lista.forEach(element => {
                    conteudo = '';
                    conteudo += getHeaderCard(element);
                    conteudo += getButtonsCard(element);
                    conteudo += getBodyCard(element);
                    conteudo += getDetalhesCard(element);

                    conteudo += '</div>';
                    if(getTipoExibicao() == "lista")
                    {
                        $('#main').append(conteudo);
                    }
                    else
                    {
                        conteudo += getDirecao(data.posicao, data.total);
                        $('#main').html(conteudo);
                    }
                });
                let total = new Intl.NumberFormat('pt-BR', { }).format(data.total);
                let totalgeral = new Intl.NumberFormat('pt-BR', { }).format(data.totalgeral);
                $('#tituloNum').append(total+" Candidatos");
                $('#tituloNumTotal').append(" Total de "+totalgeral+" canditatos");
                $('#total').val(data.total);
                $('#totalgeral').val(data.totalgeral);
                $('#posicao').val(data.posicao);
                $('#finalizado').val(data.finalizado);
            }
            else
            {
                MsnSemCandidato();
            }
            carregandocandidato = false;
        });
    };
    function getListFilters(idcliente = 0, parametros = null, getnext = true) {
        let item = null;
        if(parametros.length != undefined) {
            item = parametros[0];
        }
        else
        {
            item = parametros;
        }
        getOnlyOneFilter(idcliente, item, getnext);      
    };    
    function getClassificacao(idCliente) {
        var dados = [];
        var conteudo = '';
        dados = {"idcliente":idCliente};
        caminho = url + 'api/leropcaoclassificacaocandidatos/';

        $.ajax({
            url: caminho,
            type: 'get',
            dataType: 'json',
            contentType: 'application/x-www-form-urlencoded',
            success: function (data) {
           },
        }).done(function(data) {
            for (let i = 0; i < data.opcoes.length; i++) {
                $("#classifica").append("<option value='"+data.opcoes[i].valor+"'>"+data.opcoes[i].texto+"</option>")

            }
        });

    };
    function getTipoExibicao()
    {
        let retorno = "lista";
        if(acesso != "Cliente")
        {            
            exibicao = $("#exibicao:checked").val();
            if(exibicao == "lista")
            {
                return retorno;
            }
            else
            {
                return "pagina";
            }
        }
        else
        {
            return retorno;
        }
    }
    function getOnlyOneFilter(idcliente = 0, item = null, getnext = true)
    {
        var dados = [];
        var idvaga = $("#idvaga").val();
        var limite = 0;
        var calcular = 0;
        var caminho = "";
        filtro = getFiltersParam(item.filtradoPorIndice);
        if(!Vazio(item.NaoDisponivel))
        {
            limite = item.limite - 1;
        }
        else
        {
            limite = item.limite; 
        }
        calcular = item.CalcularAtivo;
        if (item.ativo){
            caminho = url + 'api'+item.url+'/';

            dados = {
                "idcliente": idcliente,
                'limite': limite,
                'calcular': calcular,
                'posicao': item.posicao,
                'total': item.total,
                'idvaga': idvaga
            };
            if(!Vazio(filtro))
            {
                dados[filtro.fieldId] = filtro.filtrosMarcados;
            }
            $.ajax({
                url: caminho,
                type: 'post',
                dataType: 'json',
                contentType: 'application/x-www-form-urlencoded',
                success: function (data) {
                },
                data: dados
            }).done(function(data) {
                if (data != null && data.sucesso && data.lista){
                    $("#Filter"+item.filter).parent().parent().css("display","block");
                    let btn = $("#Filter"+item.filter).parent().parent().find("button.btnMore");
                    let btnCalc = $("#Filter"+item.filter).parent().parent().find("button.btnCalcular");
                    if(!Vazio(data.finalizado))
                    {
                        btn.css("display","none");
                    }
                    else
                    {
                        btn.css("display","block");
                        btn.html("Ver mais <i class=\"fas fa-plus\"></i>");
                    }
                    if(Vazio(item.CalcularBtn))
                    {
                        btnCalc.css("display","none");
                    }
                    else
                    {
                        btnCalc.css("display","block");
                    }console.log(filtersParam[13]);
                    item.total = data.total;
                    item.posicao = data.posicao;console.log(filtersParam[13]);
                    if(!Vazio(item.NaoDisponivel))
                    {
                        putCheckboxNaoDisponivel(item);
                    }
                    data.lista.forEach(element => {
                        putCheckboxFilters(element, item.filter, item.fieldId, item.fieldValue, item.fieldSecondValue, item.filtrosMarcados);
                    });
                }
                else
                {
                    $("#Filter"+item.filter).parent().parent().css("display","none");
                }
                if(getnext)
                {
                    proximo = getNextFilterParam(item);
                    if(!Vazio(proximo))
                    {
                        getOnlyOneFilter(idcliente, proximo);
                    }
                }
            });
        }
    }
    function montaFilters(idCliente = 0) {
        filtro = {
            "idcliente":idCliente,
            "setorcargo":"Todos",
            "empresacargo":"Todos"
        };

        var valor = $("#buscarInput").val();
        if(!Vazio(valor)) {
            filtro['buscar'] = valor;
        }
        valor = $("#posicao").val();
        if(!Vazio(valor)) {
            filtro['posicao'] = valor;
        }
        valor = $("#total").val();
        if(!Vazio(valor)) {
            filtro['total'] = valor;
        }
        valor = $("#totalgeral").val();
        if(!Vazio(valor)) {
            filtro['totalgeral'] = valor;
        }
        if(getTipoExibicao() == "lista")
        {            
            valor = $("#limite").val();
            if(!Vazio(valor)) {
                filtro['limite'] = valor;
            }
        }
        else
        {
            filtro['limite'] = 1;
        }
        valor = $("#idvaga").val();
        if(!Vazio(valor)) {
            filtro['idvaga'] = valor;
        }

        filtersParam.forEach(item => {
            filtro[item.fieldId] = item.filtrosMarcados;
            if(!Vazio(item.NaoDisponivel))
            {
                if(!Vazio(item.NaoDisponivelMarcado))
                {
                    filtro[item.fieldId+"naodisponivel"] = item.NaoDisponivelMarcado;
                }
            }
        });

        var classifica = $("#classifica option:selected").val();
        if (classifica) {
            filtro['classificacao']= classifica;
        }
        return filtro;

        // "filter": "Competencia",
        //         "url": "/lerlistacompetencias",
        //         "limite": 1000,
        //         "ativo": true,
        //         "fieldId": "idcompetencia",
        //         "fieldValue": "competencia",
        //         "fieldSecondValue": "sem",
        //         "filtrosMarcados": []
    };
    function checkout(obj, id, filtro, label) {
        filtersParam.forEach(item => {
            if (item.fieldId == filtro) {
                if(!Vazio(item.isCheck))
                {
                    if (item.filtrosMarcados.indexOf(id) > -1){
                        item.filtrosMarcados.splice( $.inArray(id,item.filtrosMarcados) ,1 );
                        putLabelFilters(id, item, label, true);
                    }
                    else
                    {
                        aux = id.replaceAll("_"," ");
                        item.filtrosMarcados.push(aux);
                        putLabelFilters(id, item, label, false);
                    }
                }
                else
                {
                    let check = $("#" + item.filter + "Checkbox" + id);
                    if(check.get(0).checked == false)
                    {
                        aux = id.replaceAll("_"," ");
                        item.filtrosMarcados = [aux];
                        putLabelFilters(id, item, label, false);     
                    }
                    else
                    {
                        item.filtrosMarcados = [];
                        putLabelFilters(id, item, label, true);
                    }
                    $('#Filter'+item.filter+' li input[type="checkbox"]').each(function( index ) {
                        if(this.id != check.get(0).id)
                        {
                            $(this).get(0).checked = false;
                            putLabelFilters($(this).val(), item, label, true);
                        }
                    });
                }
            }
        });
        SetaPesquisa();
        getListCandidatos(idCliente);
    };
    function checkoutNaoDisponivel(obj, tipo, label) {
        filtersParam.forEach(item => {
            if (item.filter == tipo) {
                if(!Vazio(item.NaoDisponivelMarcado))
                {
                    item.NaoDisponivelMarcado = 0;
                    putLabelNaoDisponivel( tipo, label, true);
                }
                else
                {
                    item.NaoDisponivelMarcado = 1;
                    putLabelNaoDisponivel( tipo, label, false);
                }
            }
        });
        SetaPesquisa();
        getListCandidatos(idCliente);
    };
    function putLabelFilters(id = 0, item, label = "", retirar = false){
        let filtro = getFiltersParam(item.AtualizarIndice);
        let nome = '';
        let tipo = item.fieldId;
        let aux = new String(id);
        aux = aux.replaceAll(" ","_");
        if(!Vazio(filtro))
        {
            nome = '#Filter'+filtro.filter;
            $(nome).empty();
            filtro.filtrosMarcados = [];
            filtro.posicao = 0;
            getOnlyOneFilter(idCliente, filtro, false);
        }
        if(retirar)
        {
            nome = `#lbl${tipo}${aux}`;
            $(nome).remove();
        }
        else
        {
            conteudoFilter = `
            <li id="lbl${tipo}${aux}" class="btnExitFilter">
                ${label}
                <a href="javascript:;" onclick="RetirarFilter('${id}', '${tipo}')">
                    <i class="fas fa-times"></i>
                </a>
            </li>`;
            $('.btnExitFilter[name="clear"]').before($(conteudoFilter));
        }
    };
    function putLabelNaoDisponivel(filtro = "", label = "", retirar = false){
        let nome = '';
        nome = `${filtro}lblNaoDisponivel`;
        if(retirar)
        {
            $("#" + nome).remove();
        }
        else
        {
            conteudoFilter = `
            <li id="${nome}" class="btnExitFilter">
                ${label}
                <a href="javascript:;" onclick="RetirarFilterNaoDisponivel('${filtro}')">
                    <i class="fas fa-times"></i>
                </a>
            </li>`;
            $('.btnExitFilter[name="clear"]').before($(conteudoFilter));
        }
    };
    function getFiltersParam(indice = -1){
        if(Vazio(indice))
        {
            return null;
        }
        if(indice < 0)
        {
            return null;
        }
        if(indice >= filtersParam.length)
        {
            return null;
        }
        return filtersParam[indice];
    };
    function getNextFilterParam(obj = null){
        let indice = -1;
        if(Vazio(obj))
        {
            return null;
        }
        filtersParam.forEach((item, index) => {
            if(item.fieldId == obj.fieldId)
            {
                indice = index + 1;
                return;
            }
        });
        
        return getFiltersParam(indice);
    };
    function RetirarFilter(id = 0, tipo = ""){
        let nome = '';
        let label =  new String(id);
        label = label.replaceAll(" ","_");
        nome = `#LblCheckbox${tipo}${label}`;
        $(nome).trigger( "click" );
        $(nome).parent().find('input[type="checkbox"]').get(0).checked = false;        
    };
    function RetirarFilterNaoDisponivel(tipo = ""){
        var nome = '';
        filtersParam.forEach(item => {
            if (item.filter == tipo) {
                if(!Vazio(item.NaoDisponivelMarcado))
                {
                    item.NaoDisponivelMarcado = 0;
                    putLabelNaoDisponivel( tipo, "", true);
                }
            }
        });
        SetaPesquisa();
        getListCandidatos(idCliente);        
    };
    function RetirarFilterAll(){
        idcidade = [];

        filtersParam.forEach(item => {
            if (item.filtrosMarcados.length > 0) {
                item.filtrosMarcados = [];
            }
            if(!Vazio(item.NaoDisponivel))
            {
                item.NaoDisponivelMarcado = 0;
            }
        });
        $( ".asideExitFilter ul li[id^='lbl'], .asideExitFilter ul li[id*='lblNaoDisponivel']" ).each(function( index ) {
            $( this ).remove();
        });
        $( ".asideMenuFilter input[type='checkbox']" ).each(function( index ) {
            this.checked = false;
        });
        SetaPesquisa();
        getListCandidatos(idCliente);
    };
    function MarcarFavorito(obj, idcandidato = 0, idvaga = 0 ){
        var dados = {};
        var conteudo = '';
        var desmarcar = $(obj).data("marcado");
        dados = {
            "idcandidato": idcandidato,
            "idvaga":idvaga,
            "idcliente":idCliente,
            "desmarcar":desmarcar
        };
        caminho = url + 'api/marcarcandidato/';
        $.ajax({
            url: caminho,
            type: 'post',
            dataType: 'json',
            contentType: 'application/x-www-form-urlencoded',
            success: function (data) {
            },
            data: dados
        }).done(function(data) {
            if (data != null && data.sucesso)
            {
                //MsnInfo(data.titulo, data.mensagem);
                if(Vazio(desmarcar))
                {
                    $(obj).find("i").addClass("yellow").removeClass("far").addClass("fas");
                    $(obj).data("marcado","1");
                    $(obj).attr("title", "Desmarcar candidato como favorito");
                }
                else
                {
                    $(obj).find("i").removeClass("yellow").removeClass("fas").addClass("far");
                    $(obj).data("marcado","0");
                    $(obj).attr("title", "Marcar candidato como favorito");
                }
                filtro = getFiltersParam(0);
                if(!Vazio(filtro))
                {
                    $('#Filter'+filtro.filter).empty();
                    filtro.posicao = 0;
                    filtro.total = 0;
                    getOnlyOneFilter(idCliente, filtro, false);
                }
            }
        });
    };
    function MarcarFavoritoGrupo(obj, idcandidato = 0, idvaga = 0 ){
        var dados = {};
        var conteudo = '';
        var desmarcar = $(obj).data("marcado");
        var tipo = $(obj).data("tipo");
        dados = {
            "idcandidato": idcandidato,
            "idvaga":idvaga,
            "idcliente":idCliente,
            "desmarcar":desmarcar,
            "tipo":tipo
        };
        caminho = url + 'api/marcarcandidatofavoritogrupo/';
        $.ajax({
            url: caminho,
            type: 'post',
            dataType: 'json',
            contentType: 'application/x-www-form-urlencoded',
            success: function (data) {
            },
            data: dados
        }).done(function(data) {
            if (data != null && data.sucesso)
            {
                //MsnInfo(data.titulo, data.mensagem);
                let num = $(obj).data("tipo").replace(/([^0-9])/g,'');
                $('.listaCand .buttonCand a.btn-grupo[data-marcado="1"]').each(function( index ) {
                    $(this).data("marcado","0");
                    $(this).attr("data-marcado","0");
                });
                if(Vazio(desmarcar))
                {
                    $(obj).data("marcado","1");
                    $(obj).attr("data-marcado","1");
                    $(obj).attr("title", "Desmarcar candidato como favorito "+ num);
                }
                else
                {
                    $(obj).data("marcado","0");
                    $(obj).attr("data-marcado","0");
                    $(obj).attr("title", "Marcar candidato como favorito "+ num);
                }
                filtro = getFiltersParam(1);
                if(!Vazio(filtro))
                {
                    $('#Filter'+filtro.filter).empty();
                    filtro.posicao = 0;
                    filtro.total = 0;
                    getOnlyOneFilter(idCliente, filtro, false);
                }
            }
        });
    };
    function MarcarLinkedinDesatualizado(obj, idcandidato = 0, idvaga = 0 ){
        var dados = {};
        var conteudo = '';
        var desmarcar = $(obj).data("marcado");
        dados = {
            "idcandidato": idcandidato,
            "idvaga":idvaga,
            "idcliente":idCliente,
            "desmarcar":desmarcar
        };
        caminho = url + 'api/marcarlinkedindesatualizado/';
        $.ajax({
            url: caminho,
            type: 'post',
            dataType: 'json',
            contentType: 'application/x-www-form-urlencoded',
            success: function (data) {
            },
            data: dados
        }).done(function(data) {
            if (data != null && data.sucesso)
            {
                //MsnInfo(data.titulo, data.mensagem);
                if(Vazio(desmarcar))
                {
                    $(obj).find("i").removeClass("el el-check-empty").addClass("el el-check");
                    $(obj).data("marcado","1");
                    $(obj).attr("title", "Desmarcar candidato como linkedin desatualizado");
                }
                else
                {
                    $(obj).find("i").removeClass("el el-check").addClass("el el-check-empty");
                    $(obj).data("marcado","0");
                    $(obj).attr("title", "Marcar candidato como linkedin desatualizado");
                }
                filtro = getFiltersParam(23);
                if(!Vazio(filtro))
                {
                    $('#Filter'+filtro.filter).empty();
                    filtro.posicao = 0;
                    filtro.total = 0;
                    getOnlyOneFilter(idCliente, filtro, false);
                }
            }
        });
    };
    function MarcarContato(obj){
        let dados = {};
        let desmarcar = $(obj).data("marcado");
        let idcliente = $(obj).data("idcliente");
        let deletar = "";
        if(!Vazio(idcliente))
        {
            if(idcliente == idCliente)
            {
                deletar = "Deletar";
            }
        }
        dados = {
            "idcandidatocontato": $(obj).data("idcandidatocontato"),
            "idcliente": idCliente,
            "idvaga":$(obj).data("idvaga"),
            "idcandidato":$(obj).data("idcandidato"),
            "tipo":$(obj).data("tipo"),
            "deletar":deletar
        };
        caminho = url + 'api/marcarcontato/';
        $.ajax({
            url: caminho,
            type: 'post',
            dataType: 'json',
            contentType: 'application/x-www-form-urlencoded',
            success: function (data) {
            },
            data: dados
        }).done(function(data) {
            if (data != null && data.sucesso){                
                if(!Vazio(data.idcliente))
                {
                    $(obj).find("i").removeClass("far fa-square").addClass("fas fa-check-square");
                    $(obj).find("samp:nth-of-type(2)").html(` - ${data.cliente}, em ${data.cadastradoem}`);
                    $(obj).find("samp:nth-of-type(3)").html(``);
                    $(obj).data("idcandidatocontato", data.idcandidatocontato);
                    $(obj).data("idcliente", data.idcliente);
                }
                else
                {
                    $(obj).find("i").removeClass("fas fa-check-square").addClass("far fa-square");
                    $(obj).find("samp:nth-of-type(2)").html(``);
                    $(obj).find("samp:nth-of-type(3)").html(``);
                    $(obj).data("idcandidatocontato", data.idcandidatocontato);
                    $(obj).data("idcliente", data.idcliente);
                }
            }
        });
    };
    function MarcarDesconsiderado(obj, idcandidato = 0, idvaga = 0){
        var dados = {};
        var conteudo = '';
        var desmarcar = $(obj).data("marcado");
        dados = {
            "idcandidato": idcandidato,
            "idvaga":idvaga,
            "idcliente":idCliente,
            "desmarcar":desmarcar
        };
        caminho = url + 'api/marcardesconsiderado/';
        $.ajax({
            url: caminho,
            type: 'post',
            dataType: 'json',
            contentType: 'application/x-www-form-urlencoded',
            success: function (data) {
            },
            data: dados
        }).done(function(data) {
            if (data != null && data.sucesso){
                //MsnInfo(data.titulo, data.mensagem);
                if(Vazio(desmarcar))
                {
                    $(obj).find("i").removeClass("far fa-thumbs-up").addClass("far fa-thumbs-down");
                    $(obj).data("marcado","1");
                    $(obj).parent().parent().remove();
                    $(obj).attr("title", "Reconsiderar candidato para esta vaga");
                }
                else
                {
                    $(obj).find("i").removeClass("far fa-thumbs-down").addClass("far fa-thumbs-up");
                    $(obj).data("marcado","0");
                    $(obj).parent().parent().remove();
                    $(obj).attr("title", "Desconsiderar o candidato para esta vaga");
                }
                if(getTipoExibicao() == "pagina")
                {
                    let buttom = $('a[data-direcao="proximo"]');
                    let inputTotal = $("#total");
                    let total = parseInt(inputTotal.val()) - 1;
                    let aux = 0;
                    inputTotal.val(total);
                    if(buttom.data("posicao") == buttom.data("total"))
                    {
                        $('a[data-direcao="primeiro"]').trigger("click");
                    }
                    else
                    {
                        aux = parseInt(buttom.data("posicao")) - 1;
                        
                        buttom.data("posicao", aux);
                        buttom.trigger("click");
                    }
                }
                filtro = getFiltersParam(0);
                if(!Vazio(filtro))
                {
                    $('#Filter'+filtro.filter).empty();
                    filtro.posicao = 0;
                    filtro.total = 0;
                    getOnlyOneFilter(idCliente, filtro, false);
                }
            }
        });
    };
    function PropupCandidato(obj = null, idcandidato = 0, idvaga = 0){
        if(Vazio(obj))
            return;
        let card = $(obj).parent().parent();
        if(card.hasClass("ViewsDetalhes"))
        {
            card.removeClass("ViewsDetalhesExtensao");
            card.removeClass("ViewsDetalhes");
            bloqueio_ctrl_C = false;
        }
        else
        {
            card.removeClass("ViewsDetalhesExtensao");
            card.addClass("ViewsDetalhes");
            bloqueio_ctrl_C = false;
        }
    };
    function PropupCandidatoExtensao(obj = null, idcandidato = 0, idvaga = 0){
        if(Vazio(obj))
            return;
        let card = $(obj).parent().parent();
        if(card.hasClass("ViewsDetalhesExtensao"))
        {
            card.removeClass("ViewsDetalhes");
            card.removeClass("ViewsDetalhesExtensao");
            bloqueio_ctrl_C = false;
        }
        else
        {
            card.removeClass("ViewsDetalhes");
            card.addClass("ViewsDetalhesExtensao");
            bloqueio_ctrl_C = false;
        }
    };
    function EditarRetornoInviteLKD(obj = null, idcandidato = 0, idvaga = 0){
        if(Vazio(obj))
            return;        
        $('#modal-candidato').modal('show');
        dados = {
            "idcandidato": idcandidato,
            "idvaga":idvaga,
            "idcliente":idCliente
        };
        caminho = url + 'api/buscarretornoinvitelkd/';
        $.ajax({
            url: caminho,
            type: 'post',
            dataType: 'json',
            contentType: 'application/x-www-form-urlencoded',
            success: function (data) {
            },
            data: dados
        }).done(function(data) {
            if (data != null && data.sucesso){
                //MsnInfo(data.titulo, data.mensagem);
                if(data.obj)
                {
                    let html = '';
                    html = `
                        <input id="idcandidato" name="idcandidato" type="hidden" value="${data.obj.idcandidato}">
                        <div class="col-md-12">
                            <div class="form-group mbn">
                                <label for="retornoinvitelkd" class="col-md-12 control-label" style="font-size: 16px;margin: 8px 0px;"><?php echo __("Informe os dados do retorno invite linkedin"); ?></label>
                                <div class="col-md-12">
                                    <textarea id="retornoinvitelkd" name="retornoinvitelkd" rows="5" class="form-control">${data.obj.retornoinvitelkd}</textarea>
                                </div>
                            </div>
                        </div>
                    `;
                    $("#areadadoscandidato").html(html);
                }
                else
                {
                    MsnDanger("Erro", "Ocorreu um erro desconhecido");
                }
            }
            else
            {
                MsnDanger("Erro", data.erro);
            }
        });
    };
    function SalvarRetornoInviteLKD(obj = null){
        if(Vazio(obj))
            return;
        dados = $("#frmdadoscandidato").serialize();
        caminho = url + 'api/salvarretornoinvitelkd/';
        $.ajax({
            url: caminho,
            type: 'post',
            dataType: 'json',
            contentType: 'application/x-www-form-urlencoded',
            success: function (data) {
            },
            beforeSend:function(xhr){
                $(obj).find('i').removeClass('fa fa-save').addClass('ion ion-looping');
            },
            data: dados
        }).done(function(data) {
            $(obj).find('i').removeClass('ion ion-looping').addClass('fa fa-save');
            if (data != null && data.sucesso){
                //MsnInfo(data.titulo, data.mensagem);
                let html = '';
                html = `
                    <div class="col-md-12">
                        <div class="pageloader">
                            <i class="ion ion-looping"></i>
                        </div>
                    </div>
                `;
                $("#areadadoscandidato").html(html);
                $('#modal-candidato').modal('hide');
            }
            else
            {
                MsnDanger("Erro", data.erro);
            }
        });
    };
    function CloseDetalhesCandidatoExtensao(obj = null, idcandidato = 0, idvaga = 0){
        if(Vazio(obj))
            return;
        let card = $(obj).parent().parent().parent().parent().parent().parent();
        if(card.hasClass("ViewsDetalhesExtensao"))
        {
            card.removeClass("ViewsDetalhes");
            card.removeClass("ViewsDetalhesExtensao");
            bloqueio_ctrl_C = false;
        }
        else
        {
            card.removeClass("ViewsDetalhes");
            card.addClass("ViewsDetalhesExtensao");
            bloqueio_ctrl_C = false;
        }
    };
    function CloseDetalhesCandidato(obj = null, idcandidato = 0, idvaga = 0){
        if(Vazio(obj))
            return;
        let card = $(obj).parent().parent().parent().parent().parent().parent();
        if(card.hasClass("ViewsDetalhes"))
        {
            card.removeClass("ViewsDetalhesExtensao");
            card.removeClass("ViewsDetalhes");
            bloqueio_ctrl_C = false;
        }
        else
        {
            card.removeClass("ViewsDetalhesExtensao");
            card.addClass("ViewsDetalhes");
            bloqueio_ctrl_C = false;
        }
    };
    function carregando(enable) {
        let posicao = $("#posicao").val();
        $("#SemCandidato").remove();     
        if (Vazio(posicao)) {
            $("#main").empty();
            $("#tituloNum").empty();
            $("#tituloNumTotal").empty();
            $(".filtersMenus").addClass("preload-menu");
        }
        else
        {
            $("#tituloNum").empty();
            $("#tituloNumTotal").empty();
        }

        if (enable)
        {
            html = "<div class='listaCand preload-start preload' style='background: rgb(231, 229, 247); box-shadow: none;'></div>";
            for(let i = 0; i < 4; i++)
            {
                $("#main").append(html);
            }
        }
        else
        {
            $(".filtersMenus").removeClass("preload-menu");
            $(".preload").remove();
        }     
    };
    //Monta mensagem Sem candidato
    function MsnSemCandidato() {                
        var conteudoMsm = `
            <div id="SemCandidato">
            <span>Nenhum canditato foi localizado no momento</span>
            </div>`;
        SetaPesquisa();
        $("#main").empty();
        $("#tituloNum").empty();
        $("#tituloNumTotal").empty();
        $('#main').append(conteudoMsm);
        $('#tituloNum').append("0 Candidatos");
        $('#tituloNumTotal').append("Nenhum canditato foi localizado no momento");
        return;
    };
    function SetaPesquisa() {
        $("#posicao").val(0);
        $("#total").val(0);
        $('#finalizado').val("false");
    };
    function DeleteCandidato(obj, idcandidato = 0, idvaga = 0){
        var dados = {};
        let msn = "<?php echo __("Tem certeza que deseja deletar definitivamente este candidato"); ?>";
        if(!confirm(msn))
            return;
        dados = {
            "idcandidato": idcandidato,
            "idvaga":idvaga
        };
        caminho = url + 'api/deletecandidato/';
        $.ajax({
            url: caminho,
            type: 'post',
            dataType: 'json',
            contentType: 'application/x-www-form-urlencoded',
            success: function (data) {
            },
            data: dados
        }).done(function(data) {
            let pai = null;
            if (data != null && data.sucesso){
                MsnSucesso(data.titulo, data.mensagem);
                pai = $(obj).parent().parent();
                pai.remove();
            }
            else
            {
                MsnDanger(data.titulo, data.mensagem);
            }
        });
    };
    function MarcarToptalent(obj, idcandidato = 0, idvaga = 0){
        var dados = {};
        var toptalent = $(obj).data("toptalent");
        dados = {
            "idcandidato": idcandidato,
            "idvaga":idvaga,
            "idcliente":idCliente,
            "toptalent":toptalent
        };
        caminho = url + 'api/marcartoptalent/';
        $.ajax({
            url: caminho,
            type: 'post',
            dataType: 'json',
            contentType: 'application/x-www-form-urlencoded',
            success: function (data) {
            },
            data: dados
        }).done(function(data) {
            let pai = null;
            if(!Vazio(data) && data.sucesso)
            {
                let html = "";
                MsnSucesso(data.titulo, data.mensagem);
                pai = $(obj).parent();
                if(toptalent != "Sim")
                {
                    link = pai.find("#linkTopTalent"+idcandidato);
                    if(!Vazio(link))
                    {
                        link.remove();
                    }
                    $(obj).find("i").removeClass("fa-user-times").addClass("fa-user-check");
                    $(obj).data("toptalent", "Sim");
                    $(obj).attr("title", "Marcar candidato com toptalent");
                }
                else
                {
                    html = `<a id="linkTopTalent${idcandidato}" href="javascript:;" title="Candidato TopTalent"><i class="fa fa-star green"></i></a>`;
                    pai.prepend(html);
                    $(obj).find("i").removeClass("fa-user-check").addClass("fa-user-times");
                    $(obj).data("toptalent", "Não");
                    $(obj).attr("title", "Desmarcar candidato com toptalent");
                }
                html = `Perfil TopTalent CA (${data.total})`;
                $("#LblCheckboxtoptalentSim span").html(html);
            }
            else
            {
                MsnDanger(data.titulo, data.mensagem);
            }
        });
    };
    function Avaliavar(obj, idcandidato = 0){
        var url = "<?php echo site_url("candidato/avaliacao/") ?>" + idcandidato;
        window.open(url, "_blank");
    };
    function VerMais(obj){
        var ativo = $(obj).data("mais");
        if(Vazio(ativo))
        {
            $(obj).data("mais","1");
            $(obj).html("Ver menos");
            $(obj).parent().addClass("ativo");
        }
        else
        {
            $(obj).data("mais","0");
            $(obj).html("Ver mais");
            $(obj).parent().removeClass("ativo");
        }
    };
    function CopiarNomeEmpresa(nome = "", empresa = ""){
        let aux = "";
        nome = nome.trim();
        empresa = empresa.trim();
        $aux = `${nome} ${empresa}`;
        copiarMensagem($aux);
    };
    function PropUpMarcarAbordagem(obj = null, idcandidato = 0, idvaga = 0)
    {
        let html = '';
        if(Vazio(obj))
            return;
        let marcadoAssociado = "";
        let marcadoResearcher = "";
        let tipo = $(obj).data("tipo");
        if(tipo == "Associado")
        {
            marcadoAssociado = "checked";
            $("#btnDesmacarCandidato").css("display","block");
        }
        else if(tipo == "Researcher")
        {
            marcadoResearcher = "checked";
            $("#btnDesmacarCandidato").css("display","block");
        }
        else
        {
            $("#btnDesmacarCandidato").css("display","none");
        }
        $('#modal-abordagem').modal('show');
        html = `
            <input id="idcandidatoabordagem" name="idcandidatoabordagem" type="hidden" value="${idcandidato}">
            <input id="idvagaabordagem" name="idvagaabordagem" type="hidden" value="${idvaga}">
            <div class="col-md-12">
                <div class="form-group mbn">
                    <label for="tipoabordagem" class="col-md-12 control-label" style="font-size: 16px;margin: 8px 0px;">
                    <?php echo __("Marque o tipo da abordagem ao candidato"); ?>
                    </label>
                    <ul class="col-md-12">
                        <li>
                            <input id="tipoabordagemAssociado" name="tipoabordagem" type="radio" ${marcadoAssociado} value="Associado">
                            <label for="tipoabordagemAssociado" style="font-size: 15px; margin: -3px 0px 5px 4px;">
                            <?php echo __("Associado"); ?>
                            </label>
                        </li>
                        <li>
                            <input id="tipoabordagemResearcher" name="tipoabordagem" type="radio" ${marcadoResearcher} value="Researcher">
                            <label for="tipoabordagemResearcher" style="font-size: 15px; margin: -3px 0px 5px 4px;">
                            <?php echo __("Researcher"); ?>
                            </label>
                        </li>
                    </ul>
                </div>
            </div>
        `;
        $("#areadadosabordagem").html(html);
    };
    function MarcarAbordagem(obj, marcar = true){
        var dados = {};
        var tipo = $("input[name='tipoabordagem']:checked").val();
        if(marcar)
        {
            if(Vazio(tipo))
            {
                alert('<?php echo __("Você deve selecionar a opção de abordagem.") ?>');
                return;
            }
        }
        if(marcar)
        {
            dados = {
                "idcandidato": $("#idcandidatoabordagem").val(),
                "idvaga": $("#idvagaabordagem").val(),
                "tipo": tipo,
                "marcar":1
            };
        }
        else
        {
            dados = {
                "idcandidato": $("#idcandidatoabordagem").val(),
                "idvaga": $("#idvagaabordagem").val(),
                "tipo": "",
                "marcar":0
            };
        }
        caminho = url + 'api/marcarabordagem/';
        $.ajax({
            url: caminho,
            type: 'post',
            dataType: 'json',
            contentType: 'application/x-www-form-urlencoded',
            success: function (data) {
            },
            data: dados
        }).done(function(data) {
            let pai = null;
            if(!Vazio(data) && data.sucesso)
            {
                let html = "";
                let obj = $(`#linkAbordagem${data.idcandidato}`);
                MsnSucesso(data.titulo, data.mensagem);
                if(data.tipo == "Associado")
                {
                    $(obj).find("i").removeClass("fa-user-times fa-user-cog btn-Researcher").addClass("fa-user-plus btn-Associado");
                }
                else if(data.tipo == "Researcher")
                {
                    $(obj).find("i").removeClass("fa-user-plus fa-user-cog btn-Associado").addClass("fa-user-times btn-Researcher");
                }
                else
                {
                    $(obj).find("i").removeClass("fa-user-times fa-user-plus btn-Associado btn-Researcher").addClass("fa-user-cog");
                }
                $(obj).data("tipo", data.tipo);
                $(obj).attr("title", data.msn);console.log(obj);
                html = `
                    <div class="col-md-12">
                        <div class="pageloader">
                            <i class="ion ion-looping"></i>
                        </div>
                    </div>`;
                $("#areadadosabordagem").html(html);
                $('#modal-abordagem').modal('hide');
                filtro = getFiltersParam(2);
                if(!Vazio(filtro))
                {
                    $('#Filter'+filtro.filter).empty();
                    filtro.posicao = 0;
                    filtro.total = 0;
                    getOnlyOneFilter(idCliente, filtro, false);
                }
            }
            else
            {
                MsnDanger(data.titulo, data.mensagem);
            }
        });
    };
    
    /*
    function MarcarDesconsiderado(obj, idcandidato = 0, idvaga = 0){
        var dados = {};
        var conteudo = '';
        var desmarcar = $(obj).data("marcado");
        dados = {
            "idcandidato": idcandidato,
            "idvaga":idvaga,
            "idcliente":idCliente,
            "desmarcar":desmarcar
        };
        caminho = url + 'api/marcardesconsiderado/';
        $.ajax({
            url: caminho,
            type: 'post',
            dataType: 'json',
            contentType: 'application/x-www-form-urlencoded',
            success: function (data) {
            },
            data: dados
        }).done(function(data) {
            if (data != null && data.sucesso){
                //MsnInfo(data.titulo, data.mensagem);
                if(Vazio(desmarcar))
                {
                    $(obj).find("i").removeClass("far fa-thumbs-up").addClass("far fa-thumbs-down");
                    $(obj).data("marcado","1");
                    $(obj).parent().parent().remove();
                    $(obj).attr("title", "Reconsiderar candidato para esta vaga");
                }
                else
                {
                    $(obj).find("i").removeClass("far fa-thumbs-down").addClass("far fa-thumbs-up");
                    $(obj).data("marcado","0");
                    $(obj).parent().parent().remove();
                    $(obj).attr("title", "Desconsiderar o candidato para esta vaga");
                }
                if(getTipoExibicao() == "pagina")
                {
                    let buttom = $('a[data-direcao="proximo"]');
                    let inputTotal = $("#total");
                    let total = parseInt(inputTotal.val()) - 1;
                    let aux = 0;
                    inputTotal.val(total);
                    if(buttom.data("posicao") == buttom.data("total"))
                    {
                        $('a[data-direcao="primeiro"]').trigger("click");
                    }
                    else
                    {
                        aux = parseInt(buttom.data("posicao")) - 1;
                        
                        buttom.data("posicao", aux);
                        buttom.trigger("click");
                    }
                }
                filtro = getFiltersParam(0);
                if(!Vazio(filtro))
                {
                    $('#Filter'+filtro.filter).empty();
                    filtro.posicao = 0;
                    filtro.total = 0;
                    getOnlyOneFilter(idCliente, filtro, false);
                }
            }
        });
    };*/
    $(".btnMore").on("click", function(){
        let filtro = $(this).data('identifier');
        let parametros = filtersParam[filtro];
        
        $(this).text("Carregando...");
        getListFilters(idCliente, parametros, false);
    });
    $(".btnCalcular").on("click", function(){
        let filtro = $(this).data('identifier');
        let parametros = null;
        let calcularAtivo = filtersParam[filtro].CalcularAtivo;
        if(Vazio(calcularAtivo))
        {
            filtersParam[filtro].CalcularAtivo = 1;
            $(this).html(`<i class="el el-th"></i> Calculando`);
        }
        else
        {
            filtersParam[filtro].CalcularAtivo = 0;
            $(this).html(`<i class="fa fa-th-list"></i> Calcular`);
        }

        filtersParam[filtro].posicao = 0;
        parametros = filtersParam[filtro];
        console.log(parametros, "#Filter" + parametros.filter);
        $("#Filter" + parametros.filter).html("");
        getListFilters(idCliente, parametros, false);
    });
</script>