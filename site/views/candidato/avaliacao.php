<section class="container">
    <div class="tituloconteudo">
        <h1><?php echo __("AVALIAÇÃO DO CANDIDATO"); ?></h1>        
    </div>
    <div class="telaestrutura" style="grid-template-columns:1fr">
        <div class="painelPrincipal">
            <div class="cardconteudo">
                <form id="frmcandidato" method="POST">
                    <input id="idavaliacao" name="idavaliacao" type="hidden" value="<?php echo $obj->idavaliacao; ?>">
                    <input id="idcandidato" name="idcandidato" type="hidden" value="<?php echo $obj->idcandidato; ?>">
                    <input id="idcliente" name="idcliente" type="hidden" value="<?php echo $obj->idcliente; ?>">
                    <div id="dadosform" class="corpoconteudo">
                        <div class="texto">
                            <div class="caixa full">
                                <?php if(!empty($candidato->nome)): ?>
                                <label><strong>Nome do candidato:</strong> <?php echo $candidato->nome; ?></label>
                                <?php endif; ?><!--
                                <?php if(!empty($candidato->email)): ?>
                                <label><strong>E-mail do candidato:</strong> <?php echo $candidato->email; ?></label>
                                <?php endif; ?>-->
                                <?php if(!empty($candidato->linkedin)): ?>
                                <label><strong>Linkedin do candidato:</strong> <a href="<?php echo $candidato->GetLinkedin(); ?>" target="_blank"><?php echo $candidato->linkedin; ?></a></label>
                                <?php endif; ?>
                                <a href="javascript:;" class="demarcarTodos" title="Desmarca todos os chebox marcados."><i class="el el-remove-circle"></i> Limpar todos marcados</a>
                                <a href="javascript:;" class="deletaravaliacao" title="Deletar esta avaliação."><i class="fas fa-trash-alt"></i> Deletar avaliação</a>
                            </div>
                            <div class="caixa" style="width:100%;margin: 0px;">
                                <ul>
                                    <li>
                                        <input id="linkedindesatualizado1" name="linkedindesatualizado" <?php echo SetChecked($obj->linkedindesatualizado, 'Sim'); ?> type="checkbox" value="Sim" style="margin-top: 0px;">
                                        <span style="font-weight: 700;">Linkedin do candidato está desatualizado</span>
                                    </li>
                                </ul>
                            </div>
                            <div class="caixa meio">
                                <label for="finalista1">Candidato é finalista: </label>
                                <div class="info">
                                    <i class="fa fa-info-circle"></i>
                                    <span>
                                        marcar o candidato como finalista.
                                        <ins></ins>
                                    </span>
                                </div>
                                <ul>
                                    <li class="meio">
                                        <input id="finalista1" name="finalista" <?php echo SetChecked($obj->finalista, 'Sim'); ?> type="radio" value="Sim">
                                        <span>Sim</span>
                                    </li>
                                    <li class="meio">
                                        <input id="finalista2" name="finalista" <?php echo SetChecked($obj->finalista, 'Não'); ?> type="radio" value="Não">
                                        <span>Não</span>
                                    </li>
                                </ul>
                            </div>
                            <div class="caixa meio">
                                <label for="placement1">Candidato foi placement: </label>
                                <div class="info">
                                    <i class="fa fa-info-circle"></i>
                                    <span>
                                        Marcar se o candidato é placement da consultoria.
                                        <ins></ins>
                                    </span>
                                </div>
                                <ul>
                                    <li class="meio">
                                        <input id="placement1" name="placement" <?php echo SetChecked($obj->placement, 'Sim'); ?> type="radio" value="Sim">
                                        <span>Sim</span>
                                    </li>
                                    <li class="meio">
                                        <input id="placement2" name="placement" <?php echo SetChecked($obj->placement, 'Não'); ?> type="radio" value="Não">
                                        <span>Não</span>
                                    </li>
                                </ul>
                            </div>
                            <div class="caixa">
                                <label for="inglesdeclarado">Nível de fluência declarado Inglês: </label>
                                <div class="info">
                                    <i class="fa fa-info-circle"></i>
                                    <span>
                                        Verificar qual a situação do Inglês do candidato.
                                        <ins></ins>
                                    </span>
                                </div>
                                <ul>
                                    <li class="umquinto">
                                        <input id="inglesdeclarado1" name="inglesdeclarado" <?php echo SetChecked($obj->inglesdeclarado, 'Fluente'); ?> type="radio" value="Fluente">
                                        <span>Fluente</span>
                                    </li>
                                    <li class="umquinto">
                                        <input id="inglesdeclarado2" name="inglesdeclarado" <?php echo SetChecked($obj->inglesdeclarado, 'Avançado'); ?> type="radio" value="Avançado">
                                        <span>Avançado</span>
                                    </li>
                                    <li class="umquinto">
                                        <input id="inglesdeclarado3" name="inglesdeclarado" <?php echo SetChecked($obj->inglesdeclarado, 'Intermediário'); ?> type="radio" value="Intermediário">
                                        <span>Intermediário</span>
                                    </li>
                                    <li class="umquinto">
                                        <input id="inglesdeclarado4" name="inglesdeclarado" <?php echo SetChecked($obj->inglesdeclarado, 'Básico'); ?> type="radio" value="Básico">
                                        <span>Básico</span>
                                    </li>
                                    <li class="umquinto">
                                        <input id="inglesdeclarado5" name="inglesdeclarado" <?php echo SetChecked($obj->inglesdeclarado, 'Sem Inglês'); ?> type="radio" value="Sem Inglês">
                                        <span>Não fala inglês</span>
                                    </li>
                                </ul>
                            </div>
                            <div class="caixa">
                                <label for="tipodecontratacao">Situação do telefone: </label>
                                <div class="info">
                                    <i class="fa fa-info-circle"></i>
                                    <span>
                                        Verificar qual a situação do telefone do candidato.
                                        <ins></ins>
                                    </span>
                                </div>
                                <ul>
                                    <li class="umquarto">
                                        <input id="situacaotelefone1" name="situacaotelefone" <?php echo SetChecked($obj->situacaotelefone, 'Telefone correto'); ?> type="radio" value="Telefone correto">
                                        <span>Telefone correto</span>
                                    </li>
                                    <li class="umquarto">
                                        <input id="situacaotelefone1" name="situacaotelefone" <?php echo SetChecked($obj->situacaotelefone, 'Telefone não pertence a pessoa'); ?> type="radio" value="Telefone não pertence a pessoa">
                                        <span>Telefone não pertence a pessoa</span>
                                    </li>
                                    <li class="umquarto">
                                        <input id="situacaotelefone2" name="situacaotelefone" <?php echo SetChecked($obj->situacaotelefone, 'Telefone inexistente/incompleto'); ?> type="radio" value="Telefone inexistente/incompleto">
                                        <span>Telefone inexistente/incompleto</span>
                                    </li>
                                </ul>
                            </div>
                            <div class="caixa">
                                <label for="interessemercado">Interesse em nova posição no mercado: </label>
                                <div class="info">
                                    <i class="fa fa-info-circle"></i>
                                    <span>
                                        Verificar se o candidato tem interesse em nova posição no mercado.
                                        <ins></ins>
                                    </span>
                                </div>
                                <ul>
                                    <li class="umquarto">
                                        <input id="interessemercado1" name="interessemercado" <?php echo SetChecked($obj->interessemercado, 'Sim (estou buscando)'); ?> type="radio" value="Sim (estou buscando)">
                                        <span>Sim (“estou buscando”)</span>
                                    </li>
                                    <li class="umquarto">
                                        <input id="interessemercado2" name="interessemercado" <?php echo SetChecked($obj->interessemercado, 'Depende (até considero avaliar)'); ?> type="radio" value="Depende (até considero avaliar)">
                                        <span>Depende (“até considero avaliar”)</span>
                                    </li>
                                    <li class="umquarto" style="width: 16%;">
                                        <input id="interessemercado3" name="interessemercado" <?php echo SetChecked($obj->interessemercado, 'Sem interesse'); ?> type="radio" value="Sem interesse">
                                        <span>Sem interesse</span>
                                    </li>
                                    <li class="umquarto" style="width: 34%;">
                                        <input id="interessemercado3" name="interessemercado" <?php echo SetChecked($obj->interessemercado, 'Sem resposta até o momento (mandei msg sem retorno)'); ?> type="radio" value="Sem resposta até o momento (mandei msg sem retorno)">
                                        <span>Sem resposta até o momento (“mandei msg sem retorno”)</span>
                                    </li>
                                </ul>
                            </div>
                            <div class="caixa umquarto" style="width:35%;">
                                <label for="tipodecontratacao">Tipo de contratação: </label>
                                <div class="info">
                                    <i class="fa fa-info-circle"></i>
                                    <span>
                                        Verificar qual o tipo de contratação atual do candidato.
                                        <ins></ins>
                                    </span>
                                </div>
                                <ul>
                                    <li class="meio">
                                        <input id="tipodecontratacao1" name="tipodecontratacao" <?php echo SetChecked($obj->tipodecontratacao, 'Contratação CLT'); ?> type="radio" value="Contratação CLT">
                                        <span>Contratação CLT</span>
                                    </li>
                                    <li class="meio">
                                        <input id="tipodecontratacao2" name="tipodecontratacao" <?php echo SetChecked($obj->tipodecontratacao, 'Contratação PJ'); ?> type="radio" value="Contratação PJ">
                                        <span>Contratação PJ</span>
                                    </li>
                                </ul>
                            </div>
                            <div class="caixa meio" style="width:29%;">
                                <label for="salariofixomensal">Salário fixo mensal R$:</label>
                                <div class="info">
                                    <i class="fa fa-info-circle"></i>
                                    <span>Verificar qual o salário fixo mensal atual do candidato.<ins></ins></span>
                                </div>
                                <input id="salariofixomensal" name="salariofixomensal" type="text" value="<?php echo $obj->salariofixomensal; ?>">
                            </div>
                            <div class="caixa meio" style="width:29%;">
                                <label for="bonusrealizadoanual">Bonus realizado anual R$:</label>
                                <div class="info">
                                    <i class="fa fa-info-circle"></i>
                                    <span>
                                        Verificar qual o bonus realizado anual atual do candidato.
                                        <ins></ins>
                                    </span>
                                </div>
                                <input id="bonusrealizadoanual" name="bonusrealizadoanual" type="text" value="<?php echo $obj->bonusrealizadoanual; ?>">
                            </div>
                            <div class="caixa ">
                                <table class="tabela_competecia">
                                    <tr>
                                        <th>Competência</th>
                                        <!--<th>Não identificado/Não avaliado</th>-->
                                        <th>1</th>
                                        <th>2</th>
                                        <th>3</th>
                                    </tr>
                                    <?php
                                    if(!empty($lista)):
                                        foreach($lista as $competencia):
                                    ?>
                                    <tr>
                                        <td>
                                            <span><?php echo $competencia->titulo; ?></span>
                                            <samp><?php echo $competencia->descricao; ?></samp>
                                        </td>
                                        <!--<td>
                                        <input type="radio" id="marcadoNao<?php echo $competencia->idavaliacaocompetencia; ?>" name="marcado<?php echo $competencia->idavaliacaocompetencia; ?>" value="Não identificado/Não avaliado" <?php echo SetChecked($competencia->marcado, 'Não identificado/Não avaliado'); ?>></td>-->
                                        <td>
                                        <input type="hidden" id="idavaliacaocompetencia<?php echo $competencia->idavaliacaocompetencia; ?>" name="idavaliacaocompetencia[]" value="<?php echo $competencia->idavaliacaocompetencia; ?>">
                                        <input type="hidden" id="idavaliacaomarcado<?php echo $competencia->idavaliacaocompetencia; ?>" name="idavaliacaomarcado[]" value="<?php echo $competencia->idavaliacaomarcado; ?>">
                                        <input type="radio" id="marcado1<?php echo $competencia->idavaliacaocompetencia; ?>" name="marcado<?php echo $competencia->idavaliacaocompetencia; ?>" value="1" <?php echo SetChecked($competencia->marcado, '1'); ?>></td>
                                        <td><input type="radio" id="marcado2<?php echo $competencia->idavaliacaocompetencia; ?>" name="marcado<?php echo $competencia->idavaliacaocompetencia; ?>" value="2" <?php echo SetChecked($competencia->marcado, '2'); ?>></td>
                                        <td><input type="radio" id="marcado3<?php echo $competencia->idavaliacaocompetencia; ?>"<?php echo $competencia->idavaliacaocompetencia; ?> name="marcado<?php echo $competencia->idavaliacaocompetencia; ?>" value="3" <?php echo SetChecked($competencia->marcado, '3'); ?>></td>
                                    </tr>
                                    <?php
                                        endforeach;
                                    else:
                                    ?>
                                    <tr>
                                        <td colspan="5">
                                            Nenhuma competência foi localizada no momento.
                                        </td>
                                    </tr>
                                    <?php
                                    endif;
                                    ?>
                                </table>                                
                            </div>
                            <div class="caixa">
                                <label for="interessemercado">Preferência formato de mobilidade: </label>
                                <div class="info">
                                    <i class="fa fa-info-circle"></i>
                                    <span>
                                        Verificar se o candidato tem preferência formato de mobilidade.
                                        <ins></ins>
                                    </span>
                                </div>
                                <ul>
                                    <li class="umquarto">
                                        <input id="preferenciamobilidade1" name="preferenciamobilidade" <?php echo SetChecked($obj->preferenciamobilidade, '100% presencial'); ?> type="radio" value="100% presencial">
                                        <span>100% presencial</span>
                                    </li>
                                    <li class="umquarto">
                                        <input id="preferenciamobilidade2" name="preferenciamobilidade" <?php echo SetChecked($obj->preferenciamobilidade, 'Hibrido presencial/remoto'); ?> type="radio" value="Hibrido presencial/remoto">
                                        <span>Hibrido presencial/remoto</span>
                                    </li>
                                    <li class="umquarto">
                                        <input id="preferenciamobilidade3" name="preferenciamobilidade" <?php echo SetChecked($obj->preferenciamobilidade, '100% remoto'); ?> type="radio" value="100% remoto">
                                        <span>100% remoto</span>
                                    </li>
                                </ul>
                            </div>
                            <div class="caixa">
                                <label for="motivacaoparamudanca">Motivação para mudança: remuneração, busca de conhecimento, facilidade logística, desenvolvimento pessoal, momento pessoal, novo emprego</label>
                                <div class="info">
                                    <i class="fa fa-info-circle"></i>
                                    <span>
                                        informe as motivações para mudanção.
                                        <ins></ins>
                                    </span>
                                </div>
                                <textarea id="motivacaoparamudanca" name="motivacaoparamudanca" style="min-height: 80px;"><?php echo $obj->motivacaoparamudanca; ?></textarea>
                            </div>
                            <div class="caixa">
                                <label for="observacao">Observação:</label>
                                <div class="info">
                                    <i class="fa fa-info-circle"></i>
                                    <span>
                                        informe as observações sobre o candidato.
                                        <ins></ins>
                                    </span>
                                </div>
                                <textarea id="observacao" name="observacao" style="min-height: 80px;"><?php echo $obj->observacao; ?></textarea>
                            </div>
                            <div class="caixa terco">
                                <label for="perfiltecnicocomportamental1">Candidato com perfil técnico/comportamental: </label>
                                <div class="info">
                                    <i class="fa fa-info-circle"></i>
                                    <span>
                                        marcar o candidato se possui perfil técnico/comportamental.
                                        <ins></ins>
                                    </span>
                                </div>
                                <ul>
                                    <li class="meio">
                                        <input id="perfiltecnicocomportamental1" name="perfiltecnicocomportamental" <?php echo SetChecked($obj->perfiltecnicocomportamental, 'Sim'); ?> type="radio" value="Sim">
                                        <span>Sim</span>
                                    </li>
                                    <li class="meio">
                                        <input id="perfiltecnicocomportamental2" name="perfiltecnicocomportamental" <?php echo SetChecked($obj->perfiltecnicocomportamental, 'Não'); ?> type="radio" value="Não">
                                        <span>Não</span>
                                    </li>
                                </ul>
                            </div>
                            <?php
                            if(!empty($obj->idavaliacao)):
                            ?>
                            <div class="caixa terco">
                                <label for="cliente">Nome do último avaliador:</label>
                                <div class="info">
                                    <i class="fa fa-info-circle"></i>
                                    <span>
                                        Nome do último avaliador deste candidato.
                                        <ins></ins>
                                    </span>
                                </div>
                                <input id="cliente" name="cliente" type="text" readonly="readonly" value="<?php echo $obj->cliente; ?>">
                            </div>
                            <div class="caixa terco">
                                <label for="cadastradoem">Avaliação realizada em:</label>
                                <div class="info">
                                    <i class="fa fa-info-circle"></i>
                                    <span>
                                        Data da última avaliação do candidato.
                                        <ins></ins>
                                    </span>
                                </div>
                                <input id="cadastradoem" name="cadastradoem" type="text" readonly="readonly" value="<?php echo $obj->cadastradoem; ?>">
                            </div>
                            <?php
                            endif;
                            ?>
                        </div>
                    </div>
                </form>
            </div>
            <div id="dadosformrodape" class="rodapeconteudo">
                <div class="area-btn">
                    <a href="javascript:;" class="btn-Voltar" onclick="window.close()">Fechar</a>
                    <a href="javascript:;" class="btn-Avancar" onclick="SalvarAvaliacao()">Salvar</a>
                </div>
            </div>
        </div>
        <div class="textoAjuda cardEstrutura" style="display:none">
            <h2>Quais empresas os candidatos devem ter trabalhado?</h2>
            <p>É possível você mesmo selecionar a lista de empresas target que devemos priorizar a busca de candidatos ou deixar que selecionamos tudo para você! Com a ajuda dos nossos especialistas em seleção iremos definir as empresas dos setores já selecionados ou empresas que entendemos ter aderência ao seu negócio.</p>
            <p><b>Dica:</b> o menos é mais. Priorize o que realmente importa para você. Caso tenhamos poucos candidatos das empresas target iremos também considerar candidatos dos setores selecionados.</p>
            <p>Em caso de dúvidas no preenchimento deste formulário você pode nos contatar no <a href="mailto:ajuda@candidatoagora.com.br">ajuda@candidatoagora.com.br</a>. <br/>Retornaremos o contato em breve.</p>
        </div>
    </div>
</section>
<script>
    function SalvarAvaliacao()
    {
        try
        {
            var url = GetUrlAcao("api","salvaravaliacao");
            var data = $("#frmcandidato").serialize();
            let aux = null;
            /*
            <?php
            if(!empty($lista)):
                foreach($lista as $competencia):
            ?>
            aux = $("input[name='marcado<?php echo $competencia->idavaliacaocompetencia; ?>']");
            if(!Vazio(aux))
            {
                aux = $("input[name='marcado<?php echo $competencia->idavaliacaocompetencia; ?>']:checked");
                if(Vazio(aux))
                {
                    msn = "Você deve marcar a competência do item \"<?php echo $competencia->titulo; ?>\".";
                    titulo = "Atenção!";
                    alerta(msn, "error", titulo);
                    $("input[name='marcado<?php echo $competencia->idavaliacaocompetencia; ?>']").get(0).focus();
                    return;
                }
            }
            
            <?php
                endforeach;
            endif;
            ?>*/
            aux = $("input[name='interessemercado']");
            if(!Vazio(aux))
            {
                aux = $("input[name='interessemercado']:checked");
                if(Vazio(aux))
                {
                    msn = "É obrigatório marcar se o candidato tem interesse em nova posição no mercado.";
                    titulo = "Atenção!";
                    alerta(msn, "error", titulo);
                    $("input[name='interessemercado']").get(0).focus();
                    return;
                }
            }
            /*
            aux = $("input[name='tipodecontratacao']");
            if(!Vazio(aux))
            {
                aux = $("input[name='tipodecontratacao']:checked");
                if(Vazio(aux))
                {
                    msn = "É obrigatório marcar o tipo de contratação atual do candidato.";
                    titulo = "Atenção!";
                    alerta(msn, "error", titulo);
                    $("input[name='tipodecontratacao']").get(0).focus();
                    return;
                }
            }
            aux = $("#salariofixomensal");
            if(!Vazio(aux))
            {
                if(Vazio(aux.val()))
                {
                    msn = "Você deve informar o salário fixo mensal atual do candidato.";
                    titulo = "Atenção!";
                    alerta(msn, "error", titulo);
                    aux.get(0).focus();
                    return;
                }
            }
            aux = $("#bonusrealizadoanual");
            if(!Vazio(aux))
            {
                if(Vazio(aux.val()))
                {
                    msn = "Você deve informar o bonus realizado anual atual do candidato.";
                    titulo = "Atenção!";
                    alerta(msn, "error", titulo);
                    aux.get(0).focus();
                    return;
                }
            }*/
            $.ajax({
                url: url,
                method:'POST',
                data:data,
                success:function(data){
                    if(data.sucesso)
                    {
                        msn = data.mensagem;
                        titulo = data.titulo;
                        MsnSucesso(titulo, msn);
                        setTimeout(function(){window.close();} , 3000); 
                    }
                    else
                    {
                        msn = data.erro;
                        alerta(msn, "error", "Erro ao se desconectar");
                    }
                },
                error: function(XHR, textStatus, errorThrown){
                    msn = "Falha ao salvar os dados da vaga.";
                    alerta(msn, "error", "Erro");
                }
            });
        }
        catch(ex)
        {
            console.log(ex);
        }
    }
    function ApagarAvaliacao()
    {
        try
        {
            var url = GetUrlAcao("api","deletaravaliacao");
            var data = $("#frmcandidato").serialize();
            $.ajax({
                url: url,
                method:'POST',
                data:data,
                success:function(data){
                    if(data.sucesso)
                    {
                        msn = data.mensagem;
                        titulo = data.titulo;
                        MsnSucesso(titulo, msn);
                        $("#frmcandidato input[type='radio']:checked").each(function() {
                            $(this).get(0).checked = false;
                        });
                        $("#frmcandidato textarea, #frmcandidato input[type='text'], #frmcandidato input[name^='idavaliacaomarcado']").each(function() {
                            $(this).val("");
                        });
                        $("#frmcandidato #idavaliacao").val("0");
                        $("#frmcandidato #cliente, #frmcandidato #cadastradoem").each(function() {
                            $(this).parent().css("display","none");
                        });
                        $("a.deletaravaliacao").css("display","none");
                    }
                    else
                    {
                        msn = data.erro;
                        alerta(msn, "error", "Erro ao se desconectar");
                    }
                },
                error: function(XHR, textStatus, errorThrown){
                    msn = "Falha ao salvar os dados da vaga.";
                    alerta(msn, "error", "Erro");
                }
            });            
        }
        catch(ex)
        {
            console.log(ex);
        }
    }
    $(function() {
        let id = $("#frmcandidato #idavaliacao").val();
        formatDecimal("#salariofixomensal", "pt-br");
        formatDecimal("#bonusrealizadoanual", "pt-br");
        if(Vazio(id))
        {
            $("a.deletaravaliacao").css("display","none");
        }
        else
        {
            $("a.deletaravaliacao").css("display","block");
        }
        
        $("a.demarcarTodos").click(function() {
            $("#frmcandidato input[type='radio']:checked").each(function() {
                $(this).get(0).checked = false;
            });
        });
        $("a.deletaravaliacao").click(function() {
            let msn = "<?php echo __("Tem certeza que deseja deletar definitivamente esta avaliação?\\nAtenção: Ao confirmar não será possível desfazer essa ação."); ?>";
            let titulo = "<?php echo __("Confirme"); ?>";
            if(confirm(msn, titulo))
            {
                 ApagarAvaliacao();
            }
        });
    });
</script>

