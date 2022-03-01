<?php
defined('BASEPATH') OR exit('Nenhum acesso de script direto permitido');
?>
<style type="text/css">

::selection { background-color: #f07746; color: #fff; }
::-moz-selection { background-color: #f07746; color: #fff; }

a {
    color: #dd4814;
    background-color: transparent;
    font-weight: normal;
    text-decoration: none;
}

a:hover {
    color: #97310e;
}

h1 {
    color: #fff;
    background-color: #dd4814;
    border-bottom: 1px solid #d0d0d0;
    font-size: 22px;
    font-weight: bold;
    margin: 0 0 14px 0;
    padding: 5px 15px;
    line-height: 40px;
}

h2 {
    color:#404040;
    margin:0;
    padding:0 0 10px 0;
}

code {
    font-family: Consolas, Monaco, Courier New, Courier, monospace;
    font-size: 13px;
    background-color: #f5f5f5;
    border: 1px solid #e3e3e3;
    border-radius: 4px;
    color: #002166;
    display: block;
    margin: 14px 0 14px 0;
    padding: 12px 10px 12px 10px;
}

#container {
    margin: 10px;
    border: 1px solid #d0d0d0;
    box-shadow: 0 0 8px #d0d0d0;
    border-radius: 4px;
}

p {
    margin: 0 0 10px;
    padding:0;
}

#body {
    margin: 0 15px 0 15px;
    min-height: 96px;
}
</style>

<div id="container">
    <h1>Teste de sistema</h1>
    <div id="body">
    <h1><?php _e('teste de tradução'); ?>!</h1>
        <div id="area">
        </div>
    </div>
</div>
<script>
function buscamarca()
{
    var url = "https://www.webmotors.com.br/carro/marcasativas?tipoAnuncio=novos-usados";
    $.ajax({
        type: 'GET',
        dataType: 'JSON',
        url: url,
        success: function (data) {
            if(Vazio(data))
            {
                alert("<?php echo __("Não foi possível excluir esta foto do veículo."); ?>");
                return;
            }
            if(data.Common)
            {
                for(x in data.Common)
                    console.log(data.Common[x]);
            }
            return;
        },
        fail: function (jqXHR, status, errorThrown) {
            throw Error('JSONFixture could not be loaded: ' + url + ' (status: ' + status + ', message: ' + errorThrown.message + ')')
        }
    });
}
$(function () {
    buscamarca();
}); 
</script>