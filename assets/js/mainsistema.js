//#region padrão
var bloqueio_ctrl_C = false;
$(function() {
	$( "body" ).delegate("a, button, input[type='button']", "click", function() {
		let codigo = $(this).data("codigo");
		let idvaga = $(this).data("vaga");
		let idcandidato = $(this).data("candidato");
		let url = GetUrlAcao("api","registraracesso");
		if(Vazio(codigo))
			return;
		if(Vazio(idvaga))
			idvaga = 0;
		if(Vazio(idcandidato))
			idcandidato = 0;

		var data = {
			"codigo":codigo,
			"idvaga": idvaga,
			"idcandidato": idcandidato
		};

		$.ajax({
			url: url,
			method:'POST',
			data:data,
			success:function(data){
				if(data.sucesso)
				{
					msn = data.mensagem;
					console.log(msn);
				}
				else
				{
					msn = data.erro;
					console.log(msn);
				}
			},
			error: function(XHR, textStatus, errorThrown){
				msn = "Falha ao registrar acesso.";
				console.log(msn);
			}
		});
	});
    //BEGIN MENU SIDEBAR
});
String.prototype.replaceAll = String.prototype.replaceAll || function(needle, replacement)
{
	return this.split(needle).join(replacement);
};
String.prototype.reverse=function()
{
	return this.split("").reverse().join("");
};
$.fn.serializeObject = function() {
    var o = {};
    var a = this.serializeArray();
    $.each(a, function() {
        if (o[this.name]) {
            if (!o[this.name].push) {
                o[this.name] = [o[this.name]];
            }
            o[this.name].push(this.value || '');
        } else {
            o[this.name] = this.value || '';
        }
    });
    return o;
};
//#endregion
// #region Funções Padrão
function strip_tags(str)
{
	str = str.toString();
	return str.replace(/<\/?[^>]+>/gi, '');
}
function TypeOf(obj)
{
    if (obj == null)
        return "undefined";
    var tipo = typeof(obj);
    if (tipo == "object")
    {
        if((obj.context)&&(obj.selector))
            return "jquery";
        if (obj.length)
            return "array";
        else
            return "object";
    }
    else
    {
        if (tipo == null)
            return "undefined";
        else
            return typeof(obj);
    }
}
function Vazio(valor)
{
    try
    {
        var tipo = TypeOf(valor);
        if (tipo == "undefined")
            return true;
        if ((tipo == "number") || (tipo == "boolean"))
        {
            if (Boolean(valor))
                return false;
        }
        if (tipo == "string")
        {
            valor = valor.trim();
            if ((valor != "0") && (valor.length > 0))
                return false;
        }
        if(tipo == "object")
        {
            return false;
        }
        if(tipo == "array")
        {
            return false;
        }
        if(tipo == "function")
        {
            return false;
        }
        if(tipo == "jquery")
        {
            if ((valor !== false) && (valor.length > 0))
                return false;
        }
        return true;
    }
    catch (ex)
    {
        return Excecao(ex);
    }
}
function ObjetoReplace(obj,caixa)
{
	try
	{
		var tipo = typeOf(obj);
		var chave = null;
		if(tipo == "undefined")
			return caixa;
		if(tipo == "object")
		{
			for(var chave in obj )
			{
				if(typeOf(obj[chave]) == "undefined")
                    obj[chave] = "";
                caixa = caixa.replaceAll("{"+chave+"}", obj[chave]);
			}
			return caixa;
		}
		if(tipo == "array")
		{
			var lista = "";
			for(chave in obj )
				lista += ObjetoReplace(obj[chave],caixa);
			return lista;
		}
	}
	catch (ex)
	{
		return ex;
	}
}
function SetIdioma(idioma)
{
	var op = {expires:365, path: '/'};
   $.cookie('lang',idioma, op);
   URL = document.URL;
   window.location.reload();console.log(window.location);
}
function LerDominio()
{
	var url = window.location.origin;
	var host = window.location.host;
	if((host == "wash-pc")||(host == "localhost"))
	{
		parte = window.location.pathname.split('/');
		url += "/"+parte[1];
	}
	
	return url;
}
function GetDominio(link)
{
	var url = LerDominio()+"/" + link;
	return url;
}
function GetURL(link)
{
	var url = GetDominio("painel/index.php/api/" + link);
	return url;
}
function GetUrlAcao(metado, acao)
{
    var url = GetDominio("painel/index.php/"+metado+"/" + acao);
    return url;
}
function GetNumero(texto)
{
	if(Vazio(texto))
		return 0;
	texto = texto.replace(/([^0-9])/g,'');
	var num = parseInt(texto);
	return num;
}
 var SPMaskBehavior = function (val) {
	  return val.replace(/\D/g, '').length === 11 ? '(00) 00000-0000' : '(00) 0000-00009';
	},
	spOptions = {
	  onKeyPress: function(val, e, field, options) {
		  field.mask(SPMaskBehavior.apply({}, arguments), options);
		}
	};
function TelefoneWhatsapp(val)
{
	let Whatsapp = val.replace(/\D/g, '');
	if(Whatsapp.length > 11)
	{
		return Whatsapp
	}
	else
	{
		if(Whatsapp.length === 11)
		{
			return "55"+Whatsapp
		}
		else
		{
			ddi = Whatsapp.substr(0,2);
			if(ddi == "55")
			{
				return Whatsapp
			}
			else
			{				
				return "55"+Whatsapp
			}
		}
	}
}
function formatFoneBR(obj) {
   $(obj).mask(SPMaskBehavior, spOptions);
}
function formatFoneInternacional(obj, pais) {

	if(pais == "pt-br")
	{
		formatFoneBR(obj);
		return;
	}
	if(pais == "en")
	{
		$(obj).mask("(000) 000-0000");
		return;
	}
	if(pais == "fr")
	{
		$(obj).mask("0 00 00 00 00");
		return;
	}
	if(pais == "ar")
	{
		$(obj).mask("0 00 0000-0000");
		return;
	}
	if(pais == "de")
	{
		$(obj).mask("000 00000000");
		return;
	}
	if(pais == "it")
	{
		$(obj).mask("000 000 0000");
		return;
	}
	if(pais == "es")
	{
		$(obj).mask("000 00 00 00");
		return;
	}

}
function formatDecimal(obj, pais, isDecimal)
{
    var decOptions = {
        onKeyPress: function(val, e, field, options) {
            num = field.val().replace(/\D/g, '');
            if(num.length == 1)
            {
                num = "0.0" + num;
                num = parseFloat(num);
            }
            else
            {
                if(num.length == 2)
                {
                    num = "0." + num;
                    num = parseFloat(num);
                }
                else
                {
                    num = field.val().replaceAll(".","").replaceAll(",",".");
                    num = parseFloat(num);
                }
            }
           // if(num < 1.00)
                field.val(new Intl.NumberFormat('pt-BR', { minimumFractionDigits: 2 }).format(num));
        },
        reverse: true,
        clearIfNotMatch: true
    };
    if(TypeOf(isDecimal) == "undefined")
        isDecimal = true;
    if(TypeOf(pais) == "undefined")
        pais = "pt-br";
    if(pais == "pt-br")
    {
        if(Vazio(isDecimal))
            $(obj).mask("###.###.###", decOptions);
        else
            $(obj).mask("###.###.###,##", decOptions);
        return;
    }
    if(pais == "en")
    {
        if(Vazio(isDecimal))
            $(obj).mask("###,###,###", decOptions);
        else
            $(obj).mask("###,###,###.00", decOptions);
        return;
    }
    if(pais == "fr")
    {
        if(Vazio(isDecimal))
            $(obj).mask("###.###.###", decOptions);
        else
            $(obj).mask("###.###.###,00", decOptions);
        return;
    }
    if(pais == "ar")
    {
        if(Vazio(isDecimal))
            $(obj).mask("###.###.###", decOptions);
        else
            $(obj).mask("###.###.###,00", decOptions);
        return;
    }
    if(pais == "de")
    {
        if(Vazio(isDecimal))
            $(obj).mask("###,###,###", decOptions);
        else
            $(obj).mask("###,###,###.00", decOptions);
        return;
    }
    if(pais == "it")
    {
        if(Vazio(isDecimal))
            $(obj).mask("###.###.###", decOptions);
        else
            $(obj).mask("###.###.###,00", decOptions);
        return;
    }
    if(pais == "es")
    {
        if(Vazio(isDecimal))
            $(obj).mask("###.###.###", decOptions);
        else
            $(obj).mask("###.###.###,00", decOptions);
        return;
    }
    if(Vazio(isDecimal))
        $(obj).mask("###.###.###", decOptions);
    else
        $(obj).mask("###.###.###,00", decOptions);
}
function formatData(obj, pais)
{
	var mascara = "99/99/9999";
	if(pais == "pt-br")
	{
		mascara = "99/99/9999";
	}
	if(pais == "en")
	{
		mascara = "9999-99-99";
	}
	if(pais == "fr")
	{
		mascara = "99/99/9999";
	}
	if(pais == "ar")
	{
		mascara = "99/99/9999";
	}
	if(pais == "de")
	{
		mascara = "99/99/9999";
	}
	if(pais == "it")
	{
		mascara = "99/99/9999";
	}
	if(pais == "es")
	{
		mascara = "99/99/9999";
	}
	$(obj).mask(mascara);
	$(obj).datepicker({
		format: mascara,
		startView: 3,
		language: pais,
		minViewMode: 0,
		pickTime: false
	});
}
function LimparForm(obj, dados)
{
	var nome = "#"+$(obj).attr("id");
	$( nome + " input" ).each(function( index, element )
	{
		if($(this).attr("type") != "hidden")
		{
			$(this).val("");
		}
	});
	$( nome + " select" ).each(function( index, element )
	{
		var $option = $(this).find('option:first-of-type').val();
		$(this).val($option);
	});
	if(!Vazio(dados))
	{
		if(typeOf(dados) == "object")
		{
			for(var chave in dados )
				$("#"+chave).val(dados[chave]);
		}
	}
}
function CancelarForm(msn)
{
	if(Vazio(msn))
	{
		msn = "Você deseja sair desta página?";
	}
	window.confirm(msn,"Atenção",function(){ window.history.back(); })
}
function MsnSucesso(titulo, msn)
{
   toastr.options = {
				  "closeButton": true,
				  "debug": false,
				  "positionClass": "toast-bottom-right",
				  "onclick": null,
				  "showDuration": "1000",
				  "hideDuration": "1000",
				  "timeOut": "5000",
				  "extendedTimeOut": "1000",
				  "showEasing": "swing",
				  "hideEasing": "linear",
				  "showMethod": "fadeIn",
				  "hideMethod": "fadeOut"
				}
	toastr.success(msn, titulo);
}
function MsnDanger(titulo, msn)
{
   toastr.options = {
				  "closeButton": true,
				  "debug": false,
				  "positionClass": "toast-bottom-right",
				  "onclick": null,
				  "showDuration": "1000",
				  "hideDuration": "1000",
				  "timeOut": "5000",
				  "extendedTimeOut": "1000",
				  "showEasing": "swing",
				  "hideEasing": "linear",
				  "showMethod": "fadeIn",
				  "hideMethod": "fadeOut"
				}
	toastr.error(msn, titulo);
}
function MsnInfo(titulo, msn)
{
   toastr.options = {
				  "closeButton": true,
				  "debug": false,
				  "positionClass": "toast-bottom-right",
				  "onclick": null,
				  "showDuration": "1000",
				  "hideDuration": "1000",
				  "timeOut": "5000",
				  "extendedTimeOut": "1000",
				  "showEasing": "swing",
				  "hideEasing": "linear",
				  "showMethod": "fadeIn",
				  "hideMethod": "fadeOut"
				}
	toastr.info(msn, titulo);
}
function MsnWarning(titulo, msn)
{
   toastr.options = {
				  "closeButton": true,
				  "debug": false,
				  "positionClass": "toast-bottom-right",
				  "onclick": null,
				  "showDuration": "1000",
				  "hideDuration": "1000",
				  "timeOut": "5000",
				  "extendedTimeOut": "1000",
				  "showEasing": "swing",
				  "hideEasing": "linear",
				  "showMethod": "fadeIn",
				  "hideMethod": "fadeOut"
				}
	toastr.warning(msn, titulo);
}
function AdicionarNovo(url)
{
    window.location = url;
}
function CarregaSelect(obj, data, valor)
{
    if(Vazio(obj))
        return;
	var modelo = '<option value="{valor}">{texto}</option>';
	var html = ObjetoReplace(data, modelo);
    if(typeOf(valor) == "undefined")
        valor = "";
    $(obj).html(html);
    $(obj).val(valor);
}
function LimparTexto(texto)
{
	var caracter = new Array('%','?','!','$','&','~','+','-',' ','#',"\'","[","\\","]","^","]","`",":",";","<","=",">",
        "@","/","(",")","*",'°');
    if(Vazio(texto))
        return "";
    texto = texto.toLowerCase();
    texto = texto.replace(/([áàâãª])/g,'a');
    texto = texto.replace(/([éèêë])/g,'e');
    texto = texto.replace(/([óòôõº])/g,'o');
    texto = texto.replace(/([ìíîï])/g,'i');
    texto = texto.replace(/([úùûü])/g,'u');
    texto = texto.replace(/([ç])/g,'c');

    for(var i = 0; i< caracter.length; i++)
        texto = texto.replace(caracter[i],'_');

    return  texto;
}
function ExibeAjuda(nome)
{
	$(nome).modal();
}
function ExibePainel(obj,nome)
{
    var display = $(nome).css("display")
    if(display == "none")
    {
        $(nome).slideDown( "slow" );
        $(obj).removeClass().addClass("fa fa-chevron-down");
    }
    else
    {
        $(nome).slideUp( "slow" );
        $(obj).removeClass().addClass("fa fa-chevron-up");
    }
}
function QueryStringToJSON(query) {
    var pairs = query.split('&');

    var result = {};
    pairs.forEach(function(pair) {
        pair = pair.split('=');
        result[pair[0]] = decodeURIComponent(pair[1] || '');
    });

    return JSON.parse(JSON.stringify(result));
}
function QueryStringToArray(query) {
    var pairs = query.split('&');

    var result = {};
    pairs.forEach(function(pair) {
        pair = pair.split('=');
        result[pair[0]] = decodeURIComponent(pair[1] || '');
    });

    return result;
}
function clearInputFile(ctrl) {
    try
	{
        ctrl.value = null;
    }
    catch(ex)
	{ }
	if(Vazio(ctrl))
		return;
    if (ctrl.value)
    {
        ctrl.parentNode.replaceChild(ctrl.cloneNode(true), ctrl);
    }
}
function CDN_Url(tipo)
{
    try
    {
    	if(Vazio(tipo))
    		return "";
    	const url_Cdn = {
            datatables(){
                return "//cdn.datatables.net/plug-ins/1.10.20/i18n/Portuguese-Brasil.json";
			}
		};
        let myFunction = null;
        myFunction = url_Cdn[tipo];
        if(!Vazio(myFunction))
        {
            return myFunction();
        }
        return "";
    }
    catch(ex)
    {
    	console.log(ex);
        return "";
	}
}
//#endregion
// #region Funções Sign
function ExibeErro(msn = "")
{
    try
    {
		$(".page-form .area-form .erro-form i").removeClass("fa-check-circle");
		$(".page-form .area-form .erro-form i").addClass("fa-times-circle");
		$(".page-form .area-form .erro-form").removeClass("sucesso");
		$(".page-form .area-form .erro-form span").html(msn);
    	$(".page-form .area-form .erro-form").slideDown("slow");
    }
    catch(ex)
    {
    	console.log(ex);
        return "";
	}
}
function ExibeSucesso(msn = "")
{
    try
    {
		$(".page-form .area-form .erro-form i").removeClass("fa-times-circle");
		$(".page-form .area-form .erro-form i").addClass("fa-check-circle");
		$(".page-form .area-form .erro-form").addClass("sucesso");
		$(".page-form .area-form .erro-form span").html(msn);
    	$(".page-form .area-form .erro-form").slideDown("slow");
    }
    catch(ex)
    {
    	console.log(ex);
        return "";
	}
}
function FecharErro()
{
    try
    {
    	$(".page-form .area-form .erro-form").slideUp("slow");
    }
    catch(ex)
    {
    	console.log(ex);
        return "";
	}
}
function AbrirTopoMenu()
{
	let aux = $(".cliente ul.menu").css("display");
	if(aux == 'none')
	{
		$(".cliente ul.menu").css("display","block");
	}
	else
	{
		$(".cliente ul.menu").css("display","none");
	}
}
function EnviarPoliticaTermo()
{
	let declarado = $("#frmtermo #declarado:checked").length;
	let autorizado = $("#frmtermo #autorizado:checked").length;
	let msn = "";
	if(Vazio(declarado))
	{
		msn = "Você deve declarar que têm ciência de todos termos e condições para avançar no cadastro da vaga";
		alerta(msn, "warning", "Atenção!");
		return;
	}
	if(Vazio(autorizado))
	{
		msn = "Para prosseguir você precisa estar de acordo com todas as condições de uso.";
		alerta(msn, "warning", "Atenção!");
		return;
	}
	$("#frmtermo").get(0).submit();
}
function alerta(msn, tipo, titulo)
{
    if (["success", "error", "warning", "info"].indexOf(tipo) == -1) {
        tipo = "info";
    }
    if (Vazio(titulo)) {
        titulo = 'Informação';
    }
    Lobibox.alert(tipo, {
        title: titulo,
        msg: msn
    });
}
function Logout()
{
    try
    {
    	var url = GetUrlAcao("api","logout");

		var data = {};

		$.ajax({
			url: url,
			method:'POST',
			data:data,
			success:function(data){
				if(data.sucesso)
				{
					msn = data.mensagem;
					alerta(msn, "success", "Sucesso");
					setTimeout(function(){location.href=data.link} , 1000); 
				}
				else
				{
					msn = data.erro;
					alerta(msn, "error", "Erro ao se desconectar");
				}
			},
			error: function(XHR, textStatus, errorThrown){
				msn = "Falha ao fazer o login no sistema.";
				alerta(msn, "error", "Erro");
			}
		});
    }
    catch(ex)
    {
    	console.log(ex);
	}
}
function Voltar(link = "")
{
    try
    {
		if(Vazio(link))
			window.history.back(-1);
		else
			location.href=link;

    }
    catch(ex)
    {
    	console.log(ex);
	}
}
function CopyMensagem(){	
	if(Vazio(bloqueio_ctrl_C))
		return;
	alert('Ação não permitida!');
    return false;
}
function bloquearCopia(Event){
    var Event = Event ? Event : window.event;
	var tecla = (Event.keyCode) ? Event.keyCode : Event.which;
	if(Vazio(bloqueio_ctrl_C))
		return;
	/*if(!Vazio($(".lobibox")))
		return;*/
    if(tecla == 17){
        CopyMensagem();
    }
}
function SetabloquearCopia(){
    document.onkeypress = bloquearCopia;
    document.onkeydown = bloquearCopia;
    document.oncontextmenu = CopyMensagem;
}
function SalvarVaga()
{
    try
    {
    	var url = GetUrlAcao("api","salvarvaga");
		var data = $("#frmvaga").serialize();
		let aux = $("input[name='nacionalidadeempresasprofissionaltrabalhou']");
		if(!Vazio(aux))
		{
			aux = $("input[name='nacionalidadeempresasprofissionaltrabalhou']:checked");
			if(Vazio(aux))
			{
				msn = "Você deve marcar a nacionalidade das empresas nas quais o profissional trabalhou.";
				titulo = "Atenção!";
				alerta(msn, "error", titulo);
				$("input[name='nacionalidadeempresasprofissionaltrabalhou']").get(0).focus();
				return;
			}
		}
		aux = $("input[name='melhores1000empresa']");
		if(!Vazio(aux))
		{
			aux = $("input[name='melhores1000empresa']:checked");
			if(Vazio(aux))
			{
				msn = "É obrigatório marcar se deve considerar apenas empresas listadas nas 1.000 maiores.";
				titulo = "Atenção!";
				alerta(msn, "error", titulo);
				$("input[name='melhores1000empresa']").get(0).focus();
				return;
			}
		}
		aux = $("input[name='listadaembolsa']");
		if(!Vazio(aux))
		{
			aux = $("input[name='listadaembolsa']:checked");
			if(Vazio(aux))
			{
				msn = "É obrigatório marcar se deve considerar apenas empresas listadas na bolsa.";
				titulo = "Atenção!";
				alerta(msn, "error", titulo);
				$("input[name='listadaembolsa']").get(0).focus();
				return;
			}
		}
		aux = $("input[name='gptw']");
		if(!Vazio(aux))
		{
			aux = $("input[name='gptw']:checked");
			if(Vazio(aux))
			{
				msn = "É obrigatório marcar se deve considerar apenas empresas premiadas pelo GPTW.";
				titulo = "Atenção!";
				alerta(msn, "error", titulo);
				$("input[name='gptw']").get(0).focus();
				return;
			}
		}
		aux = $("input[name='perfilinovacao']");
		if(!Vazio(aux))
		{
			aux = $("input[name='perfilinovacao']:checked");
			if(Vazio(aux))
			{
				msn = "É obrigatório marcar se deve considerar apenas empresas do prêmio inovação.";
				titulo = "Atenção!";
				alerta(msn, "error", titulo);
				$("input[name='perfilinovacao']").get(0).focus();
				return;
			}
		}
		aux = $("input[name='startup']");
		if(!Vazio(aux))
		{
			aux = $("input[name='startup']:checked");
			if(Vazio(aux))
			{
				msn = "É obrigatório marcar se deve considerar apenas startups.";
				titulo = "Atenção!";
				alerta(msn, "error", titulo);
				$("input[name='startup']").get(0).focus();
				return;
			}
		}
		aux = $("#empresacontratante");
		if(!Vazio(aux))
		{
			if(Vazio(aux.val()))
			{
				msn = "Você deve informar o nome da empresa contratante.";
				titulo = "Atenção!";
				alerta(msn, "error", titulo);
				aux.get(0).focus();
				return;
			}
		}
		aux = $("#idsetor");
		if(!Vazio(aux))
		{
			if(Vazio(aux.val()))
			{
				msn = "Você deve selecionar a setor de atuação da sua empresa.";
				titulo = "Atenção!";
				alerta(msn, "error", titulo);
				aux.get(0).focus();
				return;
			}
		}
		aux = $("#idtamanho");
		if(!Vazio(aux))
		{
			if(Vazio(aux.val()))
			{
				msn = "Você deve selecionar a quantidade de funcionários da sua empresa.";
				titulo = "Atenção!";
				alerta(msn, "error", titulo);
				aux.get(0).focus();
				return;
			}
		}
		aux = $("#idfaturamento");
		if(!Vazio(aux))
		{
			if(Vazio(aux.val()))
			{
				msn = "Você deve selecionar o nível do faturamento anual da sua empresa.";
				titulo = "Atenção!";
				alerta(msn, "error", titulo);
				aux.get(0).focus();
				return;
			}
		}
		aux = $("input[name='momentoatualempresa']");
		if(!Vazio(aux))
		{
			aux = $("input[name='momentoatualempresa']:checked");
			if(Vazio(aux.length))
			{
				msn = "Você deve selecionar o momento atual da sua empresa.";
				titulo = "Atenção!";
				alerta(msn, "error", titulo);
				$("#momentoatualempresa1").get(0).focus();
				return;
			}
		}
		aux = $("#titulodavaga");
		if(!Vazio(aux))
		{
			if(Vazio(aux.val()))
			{
				msn = "Você deve informar título da vaga que você está contratando.";
				titulo = "Atenção!";
				alerta(msn, "error", titulo);
				aux.get(0).focus();
				return;
			}
		}
		aux = $("#idarea");
		if(!Vazio(aux))
		{
			if(Vazio(aux.val()))
			{
				msn = "Você deve selecionar a área de atuação desta vaga.";
				titulo = "Atenção!";
				alerta(msn, "error", titulo);
				aux.get(0).focus();
				return;
			}
		}
		aux = $("#idnivel");
		if(!Vazio(aux))
		{
			if(Vazio(aux.val()))
			{
				msn = "Você deve selecionar o nível hierárquico desta vaga.";
				titulo = "Atenção!";
				alerta(msn, "error", titulo);
				aux.get(0).focus();
				return;
			}
		}
		aux = $("#idsubarea");
		if(!Vazio(aux))
		{
			if(Vazio(aux.val()))
			{
				msn = "Você deve selecionar a subárea de atuação desta vaga.";
				titulo = "Atenção!";
				alerta(msn, "error", titulo);
				aux.get(0).focus();
				return;
			}
		}
		/*aux = $("#areacargo.lista");
		if(!Vazio(aux))
		{
			html = aux.html();
			if(Vazio(html))
			{
				msn = "Você deve adicionar cargos correlatos existentes no mercado.";
				titulo = "Atenção!";
				alerta(msn, "error", titulo);
				aux.get(0).focus();
				return;
			}
		}*/
		aux = $("#linhadereporte");
		if(!Vazio(aux))
		{
			if(Vazio(aux.val()))
			{
				msn = "Você deve selecionar para qual nível será o reporte da posição.";
				titulo = "Atenção!";
				alerta(msn, "error", titulo);
				aux.get(0).focus();
				return;
			}
		}
		aux = $("#faixaderemuneracaoinicial");
		if(!Vazio(aux))
		{
			if((Vazio(aux.val()))||(aux.val() == "0,00" ))
			{
				msn = "Você deve informar faixa de remuneração inícial.";
				titulo = "Atenção!";
				alerta(msn, "error", titulo);
				aux.get(0).focus();
				return;
			}
		}
		aux = $("#faixaderemuneracaofim");
		if(!Vazio(aux))
		{
			if((Vazio(aux.val()))||(aux.val() == "0,00" ))
			{
				msn = "Você deve informar faixa de remuneração final.";
				titulo = "Atenção!";
				alerta(msn, "error", titulo);
				aux.get(0).focus();
				return;
			}
		}
		aux = $("#descricaodavaga");
		if(!Vazio(aux))
		{
			if(Vazio(aux.val()))
			{
				msn = "Você deve informar a descrição da vaga.";
				titulo = "Atenção!";
				alerta(msn, "error", titulo);
				aux.get(0).focus();
				return;
			}
		}
		aux = $("#remoto:checked");
		if(Vazio(aux))
		{
			aux = $("#idestado");
			if(!Vazio(aux))
			{
				if(Vazio(aux.val()))
				{
					msn = "Você deve selecionar o estado da vaga.";
					titulo = "Atenção!";
					alerta(msn, "error", titulo);
					aux.get(0).focus();
					return;
				}
			}
			aux = $("#idcidade");
			if(!Vazio(aux))
			{
				if(Vazio(aux.val()))
				{
					msn = "Você deve selecionar a cidade da vaga.";
					titulo = "Atenção!";
					alerta(msn, "error", titulo);
					aux.get(0).focus();
					return;
				}
			}
			aux = $("#raiodepesquisa");
			if(!Vazio(aux))
			{
				if(Vazio(aux.val()))
				{
					msn = "Você deve selecionar um raio de pesquisa em torno da cidade selecionada";
					titulo = "Atenção!";
					alerta(msn, "error", titulo);
					aux.get(0).focus();
					return;
				}
			}
			aux = $("input[name='mobilidade']");
			if(!Vazio(aux))
			{
				aux = $("input[name='mobilidade']:checked");
				if(Vazio(aux.length))
				{
					msn = "É obrigatório marcar a mobilidade do candidato.";
					titulo = "Atenção!";
					alerta(msn, "error", titulo);
					$("#mobilidade1").get(0).focus();
					return;
				}
			}
		}
		aux = $("input[name='incluirempresasforatarget']");
		if(!Vazio(aux))
		{
			aux = $("input[name='incluirempresasforatarget']:checked");
			if(Vazio(aux.length))
			{
				msn = "É obrigatório marcar se deve considerar outras empresas fora das empresas acima selecionadas.";
				titulo = "Atenção!";
				alerta(msn, "error", titulo);
				$("#incluirempresasforatargetsim").get(0).focus();
				return;
			}
		}
		aux = $("input[name='excluirprofissionaisjatrabalhouempresa']");
		if(!Vazio(aux))
		{
			aux = $("input[name='excluirprofissionaisjatrabalhouempresa']:checked");
			if(Vazio(aux.length))
			{
				msn = "É obrigatório marcar se deve excluir candidatos que já tenham trabalhado na empresa contratante no passado";
				titulo = "Atenção!";
				alerta(msn, "error", titulo);
				$("#excluirprofissionaisjatrabalhouempresasim").get(0).focus();
				return;
			}
		}
		aux = $("#contenerempresas.incluir");
		if(!Vazio(aux))
		{
			aux = $("#contenerempresas.incluir div.bola");
			if(aux.length == 0)
			{
				msn = "Você deve marcar no mínimo uma empresa target para incluir na busca";
				titulo = "Atenção!";
				alerta(msn, "error", titulo);
				aux.get(0).focus();
				return;
			}
		}
		/*aux = $("#contenerempresas.excluir");
		if(!Vazio(aux))
		{
			aux = $("#contenerempresas.excluir div.bola");
			if(aux.length == 0)
			{
				msn = "Você deve marcar no mínimo uma empresa para excluir na busca";
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
					setTimeout(function(){location.href=data.link} , 1000); 
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
function fallbackCopyTextToClipboard(text) {
	var textArea = document.createElement("textarea");
	textArea.value = text;
	
	// Avoid scrolling to bottom
	textArea.style.top = "0";
	textArea.style.left = "0";
	textArea.style.position = "fixed";
  
	document.body.appendChild(textArea);
	textArea.focus();
	textArea.select();
  
	try
	{
	  var successful = document.execCommand('copy');
	  var msg = successful ? 'successful' : 'unsuccessful';
	  console.log('Fallback: Copying text command was ' + msg);
	}
	catch (err)
	{
	  console.error('Fallback: Oops, unable to copy', err);
	}
  
	document.body.removeChild(textArea);
}
function copiarMensagem(texto = "")
{
	if (!navigator.clipboard)
	{
		fallbackCopyTextToClipboard(text);
		return;
	}
	navigator.clipboard.writeText(texto)
      .then(() => console.log('Async writeText successful, "' + texto + '" written'))
      .catch((err) => console.log('Async writeText failed with error: "' + err + '"'));
}
//#endregion