<div class="col-lg-12">
	<div class="panel panel-blue">
		<div class="panel-heading"><?php echo __("Formulário de Cidade"); ?></div>
		<div class="panel-body pan">
			<form id="frmcidade" action="<?php echo site_url('cidade/editar/'.$obj->idcidade); ?>" method="POST" class="form-horizontal">
				<div class="form-body pal">

					<input id="idcidade" name="idcidade" type="hidden" placeholder="" value="<?php echo $obj->FormGet('idcidade'); ?>">
					<div class="form-group">
						<label for="idpais" class="col-md-1 control-label"><?php echo __("País"); ?></label>
						<div class="col-md-3">
							<select id="idpais" name="idpais" class="form-control">
								<?php echo $obj->GerarOpcoesPais($obj->FormGet('idpais')); ?>
							</select>
						</div>
						<label for="idestado" class="col-md-1 control-label"><?php echo __("Estado"); ?>
						<span class="require">*</span></label>
						<div class="col-md-5">
							<select id="idestado" name="idestado" class="form-control">
								<?php echo $obj->GerarOpcoesEstado($obj->FormGet('idestado')); ?>
							</select>
							<?php echo form_error('idestado', '<div class="alert alert-error msn-error">', '</div>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="cidade" class="col-md-1 control-label"><?php echo __("Cidade"); ?>
						<span class="require">*</span></label>
						<div class="col-md-3">
							<div class="input-icon">
							<i class="ion ion-android-earth"></i>
							<input id="cidade" name="cidade" type="text" value="<?php echo $obj->FormGet('cidade'); ?>" class="form-control">
							<?php echo form_error('cidade', '<div class="alert alert-error msn-error">', '</div>'); ?>
							</div>
						</div>
						<label for="latitude" class="col-md-1 control-label"><?php echo __("Latitude"); ?></label>
						<div class="col-md-2">
							<div class="input-icon">
							<i class="el el-map-marker"></i>
							<input id="latitude" name="latitude" type="text" value="<?php echo $obj->FormGet('latitude'); ?>" class="form-control">
							</div>
						</div>
						<label for="longitude" class="col-md-1 control-label"><?php echo __("Longitude"); ?></label>
						<div class="col-md-2">
							<div class="input-icon">
							<i class="el el-map-marker"></i>
							<input id="longitude" name="longitude" type="text" value="<?php echo $obj->FormGet('longitude'); ?>" class="form-control">
							</div>
						</div>
					</div>
					<div class="form-group">
						<label for="northeast_lat" class="col-md-1 control-label"><?php echo __("NO Longitude"); ?></label>
						<div class="col-md-2">
							<div class="input-icon">
							<i class="el el-map-marker"></i>
							<input id="northeast_lat" name="northeast_lat" type="text" value="<?php echo $obj->FormGet('northeast_lat'); ?>" class="form-control">
							</div>
						</div>
						<label for="northeast_lng" class="col-md-1 control-label"><?php echo __("NO Latitude"); ?></label>
						<div class="col-md-2">
							<div class="input-icon">
							<i class="el el-map-marker"></i>
							<input id="northeast_lng" name="northeast_lng" type="text" value="<?php echo $obj->FormGet('northeast_lng'); ?>" class="form-control">
							</div>
						</div>
						<label for="southwest_lat" class="col-md-1 control-label"><?php echo __("SE Longitude"); ?></label>
						<div class="col-md-2">
							<div class="input-icon">
							<i class="el el-map-marker"></i>
							<input id="southwest_lat" name="southwest_lat" type="text" value="<?php echo $obj->FormGet('southwest_lat'); ?>" class="form-control">
							</div>
						</div>
						<label for="southwest_lng" class="col-md-1 control-label"><?php echo __("SE Latitude"); ?></label>
						<div class="col-md-2">
							<div class="input-icon">
							<i class="el el-map-marker"></i>
							<input id="southwest_lng" name="southwest_lng" type="text" value="<?php echo $obj->FormGet('southwest_lng'); ?>" class="form-control">
							</div>
						</div>
					</div>
				</div>
				<div class="form-actions none-bg">
					<div class="col-md-offset-3 col-md-9">
						<button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> <?php echo __("Salvar"); ?></button>
						&nbsp;
						<button type="button" class="btn btn-green" onclick="VerMapa();"><i class="fa fa-times"></i> <?php echo __("Ver Mapa"); ?></button>&nbsp;
						<button type="button" class="btn btn-green" onclick="window.history.back();"><i class="fa fa-times"></i> <?php echo __("Cancelar"); ?></button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
<script>
    function BuscarEstados(obj){

        let url = GetUrlAcao("estado","buscarestados");

        let data = {
            "search":"",
            "idpais": $(obj).val(),
        };

        $.ajax({
            url: url,
            method:'POST',
            data:data,
            success:function(data){
				let html = "";
                if(data.sucesso)
                {
					if(!Vazio(data.resultados))
					{
						for(let i = 0; i < data.resultados.length; i++)
						{
							html +=`<option value="${data.resultados[i].id}">${data.resultados[i].text}</option>`;
						}
					}
					else
					{
						html = '<option value="0">-- Selecione --</option>';
						$('idestado').html(html);
					}
				}
				else
				{
					html = '<option value="0">-- Selecione --</option>';
					$('idestado').html(html);
				}
            },
            error: function(XHR, textStatus, errorThrown){
                msn = "<?php echo __("Falha na importação dos dados.");?>";
                alert(msn);
            }
        });
    }
	function VerMapa(){
		let url = 'https://www.google.com.br/maps/place/{endereco}';

		let cidade = $("#cidade").val();
		let estado = "";
		let pais = "";
		let endereco = cidade;
		console.log($( "#idestado option:selected" ));
		$( "#idestado option:selected" ).each(function() {
			estado = $( this ).text();console.log(this);
   		});
		$( "#idpais option:selected" ).each(function() {
			pais = $( this ).text();
   		});
		if(!Vazio(estado))
			endereco += ", " + estado;
		if(!Vazio(pais))
			endereco += ", " + pais;
		endereco = encodeURI(endereco);
		url = url.replaceAll('{endereco}', endereco);
		window.open(url, "_blank");
	}
    $(document).ready(function() {
        $("#idpais").change(function(){
            BuscarEstados(this);
        });
    });
</script>