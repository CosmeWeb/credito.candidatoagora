//#region Cabeçario

String.prototype.replaceAll = String.prototype.replaceAll || function(needle, replacement) {
    return this.split(needle)
        .join(replacement);
};
String.prototype.reverse = function() {
    return this.split("")
        .reverse()
        .join("");
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
//#region Funções Padrão
function strip_tags(str) {
    str = str.toString();
    return str.replace(/<\/?[^>]+>/gi, '');
}

function typeOf(obj) {
    if (obj == null)
        return "undefined";
    var tipo = typeof(obj);
    if (tipo == "object") {
        if ((obj.context) || (obj.selector))
            return "jquery";
        if (obj.length)
            return "array";
        else
            return "object";
    } else {
        if (tipo == null)
            return "undefined";
        else
            return typeof(obj);
    }
}
function Vazio(valor) {
    try {
        var tipo = typeOf(valor);
        if (tipo == "undefined")
            return true;
        if ((tipo == "number") || (tipo == "boolean")) {
            if (Boolean(valor))
                return false;
        }
        if (tipo == "string") {
            valor = valor.trim();
            if ((valor != "0") && (valor.length > 0))
                return false;
        }
        if (tipo == "object") {
            return false;
        }
        if (tipo == "array") {
            return false;
        }
        if (tipo == "function") {
            return false;
        }
        if (tipo == "jquery") {
            if ((valor !== false) && (valor.length > 0))
                return false;
        }
        return true;
   } catch (ex) {
        return ex;
   }
}
function ObjetoReplace(obj, caixa) {
    try {
        var tipo = typeOf(obj);
        var chave = null;
        if (tipo == "undefined")
            return caixa;
        if (tipo == "object") {
            for (var chave in obj) {
                if (typeOf(obj[chave]) == "undefined")
                    obj[chave] = "";
                caixa = caixa.replaceAll("{" + chave + "}", obj[chave]);
            }
            return caixa;
        }
        if (tipo == "array") {
            var lista = "";
            for (chave in obj)
                lista += ObjetoReplace(obj[chave], caixa);
            return lista;
        }
    } catch (ex) {
        return ex;
   }
}
function LerDominio() {
    var url = window.location.origin;
    var host = window.location.host;
    if ((host == "wash-pc") || (host == "localhost")) {
        parte = window.location.pathname.split('/');
        url += "/" + parte[1];
        if (parte[2] != "index.php")
            url += "/" + parte[2];
    } else {
        url += "/painel";
    }
    return url;
}
function GetDominio(link) {
    var url = LerDominio() + "/" + link;
    return url;
}
function GetURL(link) {
    var url = GetDominio("index.php/api/" + link);
    return url;
}
function GetUrlAcao(metado, acao) {
    var url = GetDominio("index.php/" + metado + "/" + acao);
    return url;
}
function GetNumero(texto) {
    if (Vazio(texto))
        return 0;
    texto = texto.replace(/([^0-9])/g, '');
    var num = parseInt(texto);
    return num;
}
function LimparForm(obj, dados) {
    var nome = "#" + $(obj)
        .attr("id");
    $(nome + " input")
        .each(function(index, element) {
            if ($(this)
                .attr("type") != "hidden") {
                $(this)
                    .val("");
            }
        });
    $(nome + " select")
        .each(function(index, element) {
            var $option = $(this)
                .find('option:first-of-type')
                .val();
            $(this)
                .val($option);
        });
    if (!Vazio(dados)) {
        if (typeOf(dados) == "object") {
            for (var chave in dados)
                $("#" + chave)
                .val(dados[chave]);
        }
    }
}
function AdicionarNovo(url) {
    window.location = url;
}
function CarregaSelect(obj, data, valor) {
    if (Vazio(obj))
        return;
    var modelo = '<option value="{valor}">{texto}</option>';
    var html = ObjetoReplace(data, modelo);
    if (typeOf(valor) == "undefined")
        valor = "";
    $(obj)
        .html(html);
    $(obj)
        .val(valor);
}
function LimparTexto(texto) {
    var caracter = new Array('%', '?', '!', '$', '&', '~', '+', '-', ' ', '#', "\'", "[", "\\", "]", "^", "]", "`", ":", ";", "<", "=", ">", "@", "/", "(", ")", "*", '°');
    if (Vazio(texto))
        return "";
    texto = texto.toLowerCase();
    texto = texto.replace(/([áàâãª])/g, 'a');
    texto = texto.replace(/([éèêë])/g, 'e');
    texto = texto.replace(/([óòôõº])/g, 'o');
    texto = texto.replace(/([ìíîï])/g, 'i');
    texto = texto.replace(/([úùûü])/g, 'u');
    texto = texto.replace(/([ç])/g, 'c');

    for (var i = 0; i < caracter.length; i++)
        texto = texto.replace(caracter[i], '_');
    return texto;
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
    try {
        ctrl.value = null;
    } catch (ex) {}
    if (Vazio(ctrl))
        return;
    if (ctrl.value) {
        ctrl.parentNode.replaceChild(ctrl.cloneNode(true), ctrl);
    }
}
//#endregion