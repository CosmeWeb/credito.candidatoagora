<div class="news-ticker bg-orange">
    <div class="container">
        <ul id="news-ticker-content" class="list-unstyled mbn">
        <?php
        	$listaAux = $this->gestao->GetNotificacoes();
        	foreach ($listaAux as $key => $value)
        	{
        	?>
            <li><a href='#' ><?php echo $value; ?></a></li>
        <?php
        	}
        ?>
        </ul>
        <a id="news-ticker-close" href="javascript:;"><i class="fa fa-times"></i></a></div>
</div>
