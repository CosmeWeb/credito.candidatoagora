//#region Cabeçario
$(function() {
    //BEGIN MENU SIDEBAR
    $('#sidebar')
        .css('min-height', '100%');
    $('#side-menu')
        .metisMenu();
    $(window)
        .on("load resize", function() {
            if ($(this)
                .width() < 768) {
                $('body')
                    .removeClass();
                $('div.sidebar-collapse')
                    .addClass('collapse');
			$(".cardsVagas").addClass("sidebar-aberto-cards")

            } else {
                $('body')
                    .addClass($.cookie('menu_style') + ' ' + $.cookie('header'));
                $('div.sidebar-collapse')
                    .removeClass('collapse');
                $('div.sidebar-collapse')
                    .css('height', 'auto');
                    $(".cardsVagas").removeClass("sidebar-aberto-cards")

            }
            if ($('#sidebar')
                .height() > $('#page-wrapper')
                .height()) {
                $('#wrapper')
                    .css('min-height', $('#sidebar')
                        .height());
            }
        });

    $('#news-ticker-close')
        .click(function(e) {
            $('.news-ticker')
                .remove();
            $('.quick-sidebar')
                .css('top', '50px');
        });
    //END NEWS TICKER TOPBAR
    //BEGIN TOPBAR DROPDOWN
    $('.dropdown-slimscroll')
        .slimScroll({
            "height": '250px',
            "wheelStep": 30
        });
    //END TOPBAR DROPDOWN
    //BEGIN CHECKBOX & RADIO
    if ($('#demo-checkbox-radio')
        .length <= 0) {
        $('input[type="checkbox"]:not(".switch")')
            .iCheck({
                checkboxClass: 'icheckbox_minimal-grey',
                increaseArea: '20%' // optional
            });
        $('input[type="radio"]:not(".switch")')
            .iCheck({
                radioClass: 'iradio_minimal-grey',
                increaseArea: '20%' // optional
            });
    }
    //END CHECKBOX & RADIO

    //BEGIN TOOTLIP
    $("[data-toggle='tooltip'], [data-hover='tooltip']")
        .tooltip();
    //END TOOLTIP

    //BEGIN POPOVER
    $("[data-toggle='popover'], [data-hover='popover']")
        .popover();
    //END POPOVER

    //BEGIN THEME SETTING
    $('#theme-setting > a.btn-theme-setting')
        .click(function() {
            if ($('#theme-setting')
                .css('right') < '0') {
                $('#theme-setting')
                    .css('right', '0');
            } else {
                $('#theme-setting')
                    .css('right', '-250px');
            }
        });

    // Begin Change Theme Color
    var list_menu = $('.dropdown-theme-setting > li > select#list-menu');
    var list_style = $('.dropdown-theme-setting > li > select#list-style');
    var list_header = $('.dropdown-theme-setting > li > select#list-header');
    var list_color = $('.dropdown-theme-setting > li > ul#list-color > li');

    // FUNCTION CHANGE URL STYLE ON HEAD TAG
    var setTheme = function(menu_style, style, header, color) {
            var op = {
                expires: 365,
                path: '/'
            };
            $.cookie('menu_style', menu_style, op);
            $.cookie('style', style, op);
            $.cookie('header', header, op);
            $.cookie('color', color, op);

            $('body')
                .removeClass();
            $('body')
                .addClass(menu_style + ' ' + header);
            // Set slimscroll when sidebar fixed
            if ($.cookie('header') == 'header-fixed') {
                if ($('body')
                    .hasClass('sidebar-collapsed')) {
                    $('#side-menu')
                        .attr('style', '')
                        .parent('.slimScrollDiv')
                        .replaceWith($('#side-menu'));
                } else {
                    setTimeout(function() {
                        $('#side-menu')
                            .slimScroll({
                                "height": $(window)
                                    .height() - 100,
                                'width': '250px',
                                'wheelStep': 30
                            });
                        $('#side-menu')
                            .focus();
                    }, 500)
                }
            } else {
                $('#side-menu')
                    .attr('style', '')
                    .parent('.slimScrollDiv')
                    .replaceWith($('#side-menu'));
            }
            var link = GetDominio('assets/css/themes/' + style + '/' + color + '.css');
            $('#theme-change')
                .attr('href', link);
        }
        // INITIALIZE THEME FROM COOKIE
        // --NOTES: HAVE TO SET VALUE FOR STYLE & COLOR BEFORE AND AFTER ACTIVE THEME
        // Check cookie when window reload and set value for each option(menu,style,color)
    if ($.cookie('style')) {
        // FIX SIDEBAR IN HORIZONTAL AND RIGHT
        if ($('body')
            .hasClass('clear-cookie')) {
            $.removeCookie('menu_style');
        } else {
            list_menu.find('option')
                .each(function() {
                    if ($(this)
                        .attr('value') == $.cookie('menu_style')) {
                        $(this)
                            .attr('selected', 'selected');
                    }
                });

            list_style.find('option')
                .each(function() {
                    if ($(this)
                        .attr('value') == $.cookie('style')) {
                        $(this)
                            .attr('selected', 'selected');
                    }
                });

            list_header.find('option')
                .each(function() {
                    if ($(this)
                        .attr('value') == $.cookie('header')) {
                        $(this)
                            .attr('selected', 'selected');
                    }
                });

            list_color.removeClass("active");
            list_color.each(function() {
                if ($(this)
                    .attr('data-color') == $.cookie('color')) {
                    $(this)
                        .addClass('active');
                }
            });
            setTheme($.cookie('menu_style'), $.cookie('style'), $.cookie('header'), $.cookie('color'));
        }
    };

    // SELECT MENU STYLE EVENT
    list_menu.on('change', function() {
        list_color.each(function() {
            if ($(this)
                .hasClass('active')) {
                color_active = $(this)
                    .attr('data-color');
            }
        });
        // No Menu style 3 fixed
        if (($.cookie('header') == 'header-fixed') && ($(this)
                .val() == 'sidebar-icons')) {
            setTheme($(this)
                .val(), list_style.val(), 'header-static', color_active);
            return;
        }
        setTheme($(this)
            .val(), list_style.val(), list_header.val(), color_active);
    });
    // SELECT STYLE EVENT
    list_style.on('change', function() {
        list_color.each(function() {
            if ($(this)
                .hasClass('active')) {
                color_active = $(this)
                    .attr('data-color');
            }
        });
        setTheme(list_menu.val(), $(this)
            .val(), list_header.val(), color_active);
    });

    // SELECT HEADER EVENT
    list_header.on('change', function() {
        list_color.each(function() {
            if ($(this)
                .hasClass('active')) {
                color_active = $(this)
                    .attr('data-color');
            }
        });
        // No Menu style 3 fixed
        if (($.cookie('menu_style') == 'sidebar-icons') && ($(this)
                .val() == 'header-fixed')) {
            return;
        }
        setTheme(list_menu.val(), list_style.val(), $(this)
            .val(), color_active);
    });
    // LI CLICK EVENT
    list_color.on('click', function() {
        list_color.removeClass('active');
        $(this)
            .addClass('active');
        setTheme(list_menu.val(), list_style.val(), list_header.val(), $(this)
            .attr('data-color'));
    });
    // End Change Theme Color
    //END THEME SETTING

    //BEGIN FULL SCREEN
    $('.btn-fullscreen')
        .click(function() {

            if (!document.fullscreenElement && // alternative standard method
                !document.mozFullScreenElement && !document.webkitFullscreenElement && !document.msFullscreenElement) { // current working methods
                if (document.documentElement.requestFullscreen) {
                    document.documentElement.requestFullscreen();
                } else if (document.documentElement.msRequestFullscreen) {
                    document.documentElement.msRequestFullscreen();
                } else if (document.documentElement.mozRequestFullScreen) {
                    document.documentElement.mozRequestFullScreen();
                } else if (document.documentElement.webkitRequestFullscreen) {
                    document.documentElement.webkitRequestFullscreen(Element.ALLOW_KEYBOARD_INPUT);
                }
            } else {
                if (document.exitFullscreen) {
                    document.exitFullscreen();
                } else if (document.msExitFullscreen) {
                    document.msExitFullscreen();
                } else if (document.mozCancelFullScreen) {
                    document.mozCancelFullScreen();
                } else if (document.webkitExitFullscreen) {
                    document.webkitExitFullscreen();
                }
            }
        });
    //END FULL SCREEN

    //BEGIN PORTLET
    $(".portlet")
        .each(function(index, element) {
            var me = $(this);
            $(">.portlet-header>.tools>i", me)
                .click(function(e) {
                    if ($(this)
                        .hasClass('fa-chevron-up')) {
                        $(">.portlet-body", me)
                            .slideUp('fast');
                        $(this)
                            .removeClass('fa-chevron-up')
                            .addClass('fa-chevron-down');
                    } else if ($(this)
                        .hasClass('fa-chevron-down')) {
                        $(">.portlet-body", me)
                            .slideDown('fast');
                        $(this)
                            .removeClass('fa-chevron-down')
                            .addClass('fa-chevron-up');
                    } else if ($(this)
                        .hasClass('fa-cog')) {
                        //Show modal
                    } else if ($(this)
                        .hasClass('fa-refresh')) {
                        //$(">.portlet-body", me).hide();
                        $(">.portlet-body", me)
                            .addClass('wait');

                        setTimeout(function() {
                            //$(">.portlet-body>div", me).show();
                            $(">.portlet-body", me)
                                .removeClass('wait');
                        }, 1000);
                    } else if ($(this)
                        .hasClass('fa-times')) {
                        me.remove();
                    }
                });
        });
    //END PORTLET

    //BEGIN BACK TO TOP
    $(window)
        .scroll(function() {
            if ($(this)
                .scrollTop() < 200) {
                $('#totop')
                    .fadeOut();
            } else {
                $('#totop')
                    .fadeIn();
            }
        });
    $('#totop')
        .on('click', function() {
            $('html, body')
                .animate({
                    scrollTop: 0
                }, 'fast');
            return false;
        });
    //END BACK TO TOP

    //BEGIN CHECKBOX TABLE
    $('.checkall')
        .on('ifChecked ifUnchecked', function(event) {
            if (event.type == 'ifChecked') {
                $(this)
                    .closest('table')
                    .find('input[type=checkbox]')
                    .iCheck('check');
            } else {
                $(this)
                    .closest('table')
                    .find('input[type=checkbox]')
                    .iCheck('uncheck');
            }
        });
    //ONLY FOR USER_PROFILE PAGE
    $('.checkall-email')
        .on('ifChecked ifUnchecked', function(event) {
            if (event.type == 'ifChecked') {
                $(this)
                    .closest('.tab-pane')
                    .find('input[type=checkbox]')
                    .iCheck('check');
            } else {
                $(this)
                    .closest('.tab-pane')
                    .find('input[type=checkbox]')
                    .iCheck('uncheck');
            }
        });
    //END CHECKBOX TABLE

    $('.option-demo')
        .hover(function() {
            $(this)
                .append("<div class='demo-layout animated fadeInUp'><i class='fa fa-magic mrs'></i>Demo</div>");
        }, function() {
            $('.demo-layout')
                .remove();
        });
    $('#header-topbar-page .demo-layout')
        .live('click', function() {
            var HtmlOption = $(this)
                .parent()
                .detach();
            $('#header-topbar-option-demo')
                .html(HtmlOption)
                .addClass('animated flash')
                .one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function() {
                    $(this)
                        .removeClass('animated flash');
                });
            $('#header-topbar-option-demo')
                .find('.demo-layout')
                .remove();
            return false;
        });
    $('#title-breadcrumb-page .demo-layout')
        .live('click', function() {
            var HtmlOption = $(this)
                .parent()
                .html();
            $('#title-breadcrumb-option-demo')
                .html(HtmlOption)
                .addClass('animated flash')
                .one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function() {
                    $(this)
                        .removeClass('animated flash');
                });
            $('#title-breadcrumb-option-demo')
                .find('.demo-layout')
                .remove();
            return false;
        });
    // CALL FUNCTION RESPONSIVE TABS
    fakewaffle.responsiveTabs(['xs', 'sm']);

    // BEGIN SEARCH FORM ON TOPBAR
    $('#topbar-search')
        .on('click', function(e) {
            $(this)
                .addClass('open');
            $(this)
                .find('.form-control')
                .focus();

            $('#topbar-search .form-control')
                .on('blur', function(e) {
                    $(this)
                        .closest('#topbar-search')
                        .removeClass('open');
                    $(this)
                        .unbind('blur');
                });
        });
    // END SEARCH FORM ON TOPBAR
    moment.locale('pt-br');
    $.datepicker.regional['pt-BR'] = {
        closeText: 'Fechar',
        prevText: '&#x3c;Anterior',
        nextText: 'Pr&oacute;ximo&#x3e;',
        currentText: 'Hoje',
        monthNames: ['Janeiro', 'Fevereiro', 'Mar&ccedil;o', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'],
        monthNamesShort: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
        dayNames: ['Domingo', 'Segunda-feira', 'Ter&ccedil;a-feira', 'Quarta-feira', 'Quinta-feira', 'Sexta-feira', 'Sabado'],
        dayNamesShort: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sab'],
        dayNamesMin: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sab'],
        weekHeader: 'Sm',
        dateFormat: 'dd/mm/yy',
        firstDay: 0,
        isRTL: false,
        showMonthAfterYear: false,
        yearSuffix: ''
    };
    $.datepicker.setDefaults($.datepicker.regional['pt-BR']);
});
window.alert = function(msn, tipo, titulo) {
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
};
window.confirm = function(msn, titulo, funcSim, funcNao) {
    if (Vazio(titulo)) {
        titulo = 'Pergunta';
    }
    if (Vazio(funcSim)) {
       funcSim = '';
    }
    if (Vazio(funcNao)) {
        funcNao = '';
    }
    var box = Lobibox.confirm({
        title: titulo,
        msg: msn,
        callback: function($this, type, ev) {
            if (type === 'no') {
                if (Vazio(funcNao)) {
                    return;
                }
                if (typeOf(funcNao) == "function")
                    funcNao(type);
                else
                    eval(funcNao);
            } else if (type === 'yes') {
                if (Vazio(funcSim)) {
                    return;
                }
                if (typeOf(funcSim) == "function")
                    funcSim(type);
                else
                    eval(funcSim);
            } else if (type === 'ok') {
                if (Vazio(funcSim)) {
                    return;
                }
                if (typeOf(funcSim) == "function")
                    funcSim(type);
                else
                    eval(funcSim);
            } else if (type === 'cancel') {
                if (Vazio(funcSim)) {
                    return;
                }
                if (typeOf(funcNao) == "function")
                    funcNao(type);
                else
                    eval(funcNao);
            }
        }
    });
    return true;
};
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

function SetIdioma(idioma) {
    var op = {
        expires: 365,
        path: '/'
    };
    $.cookie('lang', idioma, op);
    URL = document.URL;
    window.location.reload();
    console.log(window.location);
}
function LerDominioRaiz() {
    var url = window.location.origin;
    var host = window.location.host;
    if ((host == "wash-pc") || (host == "localhost")) {
        parte = window.location.pathname.split('/');
        url += "/" + parte[1];
    }
    return url;
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
var SPMaskBehavior = function(val) {
        return val.replace(/\D/g, '')
            .length === 11 ? '(00) 00000-0000' : '(00) 0000-00009';
    },
    spOptions = {
        onKeyPress: function(val, e, field, options) {
            field.mask(SPMaskBehavior.apply({}, arguments), options);
        }
    };
function formatFoneBR(obj) {
    $(obj)
        .mask(SPMaskBehavior, spOptions);
}
function formatFoneInternacional(obj, pais) {
    if (pais == "pt-br") {
        formatFoneBR(obj);
        return;
    }
    if (pais == "en") {
        $(obj)
            .mask("(000) 000-0000");
        return;
    }
    if (pais == "fr") {
        $(obj)
            .mask("0 00 00 00 00");
        return;
    }
    if (pais == "ar") {
        $(obj)
            .mask("0 00 0000-0000");
        return;
    }
    if (pais == "de") {
        $(obj)
            .mask("000 00000000");
        return;
    }
    if (pais == "it") {
        $(obj)
            .mask("000 000 0000");
        return;
    }
    if (pais == "es") {
        $(obj)
            .mask("000 00 00 00");
        return;
    }
}
function formatDecimal(obj, pais, isDecimal) {
    decOptions = {
        onKeyPress: function(val, e, field, options) {
            num = field.val()
                .replace(/\D/g, '');
            num = parseFloat(num);
            if (num == e.key)
                field.val(num);
        },
        reverse: true,
        clearIfNotMatch: true
    };
    if (typeOf(isDecimal) == "undefined")
        isDecimal = true;
    if (pais == "pt-br") {
        if (Vazio(isDecimal))
            $(obj)
            .mask("###.###.###", decOptions);
        else
            $(obj)
            .mask("###.###.###,00", decOptions);
        return;
    }
    if (pais == "en") {
        if (Vazio(isDecimal))
            $(obj)
            .mask("###,###,###", decOptions);
        else
            $(obj)
            .mask("###,###,###.00", decOptions);
        return;
    }
    if (pais == "fr") {
        if (Vazio(isDecimal))
            $(obj)
            .mask("###.###.###", decOptions);
        else
            $(obj)
            .mask("###.###.###,00", decOptions);
        return;
    }
    if (pais == "ar") {
        if (Vazio(isDecimal))
            $(obj)
            .mask("###.###.###", decOptions);
        else
            $(obj)
            .mask("###.###.###,00", decOptions);
        return;
    }
    if (pais == "de") {
        if (Vazio(isDecimal))
            $(obj)
            .mask("###,###,###", decOptions);
        else
            $(obj)
            .mask("###,###,###.00", decOptions);
        return;
    }
    if (pais == "it") {
        if (Vazio(isDecimal))
            $(obj)
            .mask("###.###.###", decOptions);
        else
            $(obj)
            .mask("###.###.###,00", decOptions);
        return;
    }
    if (pais == "es") {
        if (Vazio(isDecimal))
            $(obj)
            .mask("###.###.###", decOptions);
        else
            $(obj)
            .mask("###.###.###,00", decOptions);
        return;
    }
    if (Vazio(isDecimal))
        $(obj)
        .mask("###.###.###", decOptions);
    else
        $(obj)
        .mask("###.###.###,00", decOptions);
}
function formatData(obj, pais) {
    var mascara = "99/99/9999";
    if (pais == "pt-br") {
        mascara = "99/99/9999";
    }
    if (pais == "en") {
        mascara = "9999-99-99";
    }
    if (pais == "fr") {
        mascara = "99/99/9999";
    }
    if (pais == "ar") {
        mascara = "99/99/9999";
    }
    if (pais == "de") {
        mascara = "99/99/9999";
    }
    if (pais == "it") {
        mascara = "99/99/9999";
    }
    if (pais == "es") {
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

function CancelarForm(msn) {
    if (Vazio(msn)) {
        msn = "Você deseja sair desta página?";
    }
    window.confirm(msn, "Atenção", function() {
        window.history.back();
    })
}
function MsnSucesso(titulo, msn) {
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

function MsnDanger(titulo, msn) {
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

function MsnInfo(titulo, msn) {
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

function MsnWarning(titulo, msn) {
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
function ExibeAjuda(nome) {
    $(nome).modal();
}
function ExibePainel(obj, nome) {
    var display = $(nome).css("display")
    if (display == "none") {
        $(nome).slideDown("slow");
        $(obj).removeClass().addClass("fa fa-chevron-down");
    } else {
        $(nome).slideUp("slow");
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
    try {
        ctrl.value = null;
    } catch (ex) {}
    if (Vazio(ctrl))
        return;
    if (ctrl.value) {
        ctrl.parentNode.replaceChild(ctrl.cloneNode(true), ctrl);
    }
}
function CDN_Url(tipo) {
    try {
        if (Vazio(tipo))
            return "";
        const url_Cdn = {
            datatables() {
                return "//cdn.datatables.net/plug-ins/1.10.20/i18n/Portuguese-Brasil.json";
            }
        };
        let myFunction = null;
        myFunction = url_Cdn[tipo];
        if (!Vazio(myFunction)) {
            return myFunction();
        }
        return "";
    }
    catch (ex)
    {
        console.log(ex);
        return "";
    }
}
function eMoney(numero = 0)
{    
    return new Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL' }).format(numero);
}
function FormatarNumero(numero = 0)
{    
    return new Intl.NumberFormat('pt-BR').format(numero);
}
function geraStringAleatoria(tamanho) {
    var stringAleatoria = '';
    var caracteres = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
    for (var i = 0; i < tamanho; i++) {
        stringAleatoria += caracteres.charAt(Math.floor(Math.random() * caracteres.length));
    }
    return stringAleatoria;
}
function fallbackCopyTextToClipboard(obj = null, text = "")
{
    if(Vazio(obj))
    {
        console.log('sem o texto area');
        return;
    }
    obj.focus();
    obj.select();

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
}
function copyTextToClipboard(obj = null, text = "")
{
    if (!navigator.clipboard)
    {
        obj = $(obj).get(0);
        fallbackCopyTextToClipboard(obj, text);
        return;
    }
    navigator.clipboard.writeText(text).then(function() {
        console.log('Async: Copying to clipboard was successful!');
    },
    function(err) {
        console.error('Async: Could not copy text: ', err);
    });
}
//#endregion