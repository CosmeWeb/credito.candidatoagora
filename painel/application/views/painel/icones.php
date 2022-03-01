<?php
defined('BASEPATH') OR exit('Nenhum acesso de script direto permitido');
?>
    <style type="text/css">

    ::selection { background-color: #f07746; color: #fff; }
    ::-moz-selection { background-color: #f07746; color: #fff; }

    a.icon {
        position: relative;
        float: left;
        color: #097d3d;
        background-color: transparent;
        font-weight: normal;
        text-decoration: none;
        font-size: xx-large;
        text-align: center;
        padding: 5px;
    }

    a.icon:hover {
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
    #container {
        position: relative;
        float: left;
        display: block;
        width: calc(100% - 20px);
        margin: 10px;
        border: 1px solid #d0d0d0;
        box-shadow: 0 0 8px #d0d0d0;
        border-radius: 4px;
    }

    #body {
        position: relative;
        float: left;
        display: block;
        width: calc(100% - 30px);
        margin: 0 15px 0 15px;
    }
    </style>

    <div id="container">
        <h1>Icone de sistema</h1>
        <div id="body">
            <?php 
            if(!empty($lista))
            {
                foreach ($lista as $key => $obj)
                {
            ?>
                    <a class="icon" href="javascript:;"><i class="<?php echo $obj;?>"></i></a>
	        <?php
                }
            }
           
            ?>
        </div>
    </div>
<script>
    function SetIcone(obj, codigo)
    {
        prompt("Copie o codigo do icone:", codigo);
    }
    $(function () {
        $( "#body a.icon" ).click(function() {
            var aux = $(this).find("i").attr('class');
            SetIcone(this, aux);
        });
    });
</script>