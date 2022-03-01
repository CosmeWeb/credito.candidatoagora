<?php

defined('BASEPATH') OR exit('Nenhum acesso de script direto permitido');

class Gestao {
	
	protected $CI;
	public static $CSS = NULL;
	public static $JS = NULL;
	public static $ICON = NULL;
	public static $Notificacoes= NULL;
	public static $Breadcrumbs= NULL;
	public static $Titulo = NULL;
	public static $Dashboard = NULL;
	public static $_Versao = "1.0.1";
	public $versao = NULL;
	private $limitejs = 3;
	######################################################################################################
	public function __construct($params = array())
	{
		$this->CI =& get_instance();
		$this->Config = GetModelo("configuracao");
		$this->initialize($params);
		$this->versao = self::$_Versao;
		date_default_timezone_set('America/Sao_Paulo');
		log_message('info', 'Classe gestão Initializou');
	}
	######################################################################################################
	public function initialize(array $params = array())
	{
		if(!empty($params['css']))
		{
			$this->AddCSS($params['css']);
			unset($params['css']);
		}
		else
			$this->AddCSS();

		if(!empty($params['js']))
		{
			$this->AddJS($params['js']);
			unset($params['js']);
		}
		else
			$this->AddJS();

		if(!empty($params['icon']))
		{
			$this->AddICON($params['icon']);
			unset($params['icon']);
		}
		else
			$this->AddICON();
		foreach ($params as $key => $val)
		{
			$this->$key = $val;
		}
		return $this;
	}
	######################################################################################################
	public function AddNotificacoes( $params = "")
	{
		if(empty($params))
		{
			return;
		}
		if(is_array($params))
		{
			foreach ($params as $key => $val)
			{
				self::$Notificacoes[] = $val;
			}
		}
		elseif(is_string($params))
			self::$Notificacoes[] = $params;

		return;
	}
	######################################################################################################
	public function AddCSS( $params = "")
	{
		if(self::$CSS == NULL)
		{
			self::$CSS = self::cssPadrao();
		} 
		if(empty($params))
		{
			return;
		}
		if(is_array($params))
		{
			foreach ($params as $key => $val)
			{
				self::$CSS[] = $val;
			}
		}
		elseif(is_string($params))
			self::$CSS[] = $params;

		return;
	}
	######################################################################################################
	public function AddJS( $params = "")
	{
		if(self::$JS == NULL)
		{
			self::$JS = self::jsPadrao();
		} 
		if(empty($params))
		{
			return;
		}
		if(is_array($params))
		{
			foreach ($params as $key => $val)
			{
				self::$JS[] = $val;
			}
		}
		elseif(is_string($params))
			self::$JS[] = $params;

		return;
	}
	######################################################################################################
	public function AddICON( $params = "")
	{
		if(self::$ICON == NULL)
		{
			self::$ICON = self::iconPadrao();
		} 
		if(empty($params))
		{
			return;
		}
		if(is_array($params))
		{
			foreach ($params as $key => $val)
			{
				self::$ICON[] = $val;
			}
		}
		elseif(is_string($params))
			self::$ICON[] = $params;

		return;
	}
	######################################################################################################
	public function GetCSS()
	{
		if(self::$CSS == NULL)
		{
			return false;
		} 
		
		return self::$CSS;
	}
	######################################################################################################
	public function GetNotificacoes()
	{
		if(self::$Notificacoes == NULL)
		{
			return false;
		} 
		
		return self::$Notificacoes;
	}
	######################################################################################################
	public function isNotificacoes()
	{
		if(self::$Notificacoes == NULL)
		{
			return false;
		} 
		
		return true;
	}
	######################################################################################################
	public function GetJSTop()
	{
		if(self::$JS == NULL)
		{
			return false;
		}
		return array_slice(self::$JS, 0, $this->limitejs);
	}
	######################################################################################################
	public function GetJS()
	{
		if(self::$JS == NULL)
		{
			return false;
		}
		return array_slice(self::$JS, $this->limitejs);
	}
	######################################################################################################
	public function GetICON()
	{
		if(self::$ICON == NULL)
		{
			return false;
		} 
		
		return self::$ICON;
	}
	######################################################################################################
	public static function cssPadrao()
	{
		$versao = self::$_Versao;
		return array("https://fonts.googleapis.com/css?family=Open+Sans:400italic,400,300,700"
		,"https://fonts.googleapis.com/css?family=Oswald:400,700,300"
		,"vendors/fonte/font-awesome-4.3.0/css/font-awesome.min.css?versao={$versao}"
		,"vendors/fonte/elusive-icons-2.0.0/css/elusive-icons.min.css?versao={$versao}"
		,"vendors/fonte/ionic/css/ionic.css?versao={$versao}"
		,"vendors/jquery-ui-1.11.4.custom/jquery-ui.min.css?versao={$versao}"
		,"vendors/bootstrap/css/bootstrap.min.css?versao={$versao}"
		,"vendors/animate.css/animate.css?versao={$versao}"
		,"vendors/iCheck/skins/all.css?versao={$versao}"
		,"vendors/jquery-notific8/jquery.notific8.min.css?versao={$versao}"
		,"vendors/bootstrap-switch/css/bootstrap3/bootstrap-switch.min.css?versao={$versao}"
		,"vendors/DataTables/datatables.min.css?versao={$versao}"
		,"vendors/flags/flags.css?versao={$versao}"
		,"vendors/select2/css/select2.min.css?versao={$versao}"
		,"vendors/jquery-toastr/toastr.min.css?versao={$versao}"
		,array("assets/css/themes/style1/orange-blue.css?versao={$versao}" => array("class"=>"default-style"))
		,array("assets/css/themes/style1/orange-blue.css?versao={$versao}" => array("id"=>"theme-change", "class"=>"style-change color-change"))
		,"assets/css/style-responsive.css?versao={$versao}"
		,"assets/js/lobibox/css/lobibox.css?versao={$versao}"
		,"assets/css/main.css?versao={$versao}");
	}
	######################################################################################################
	public static function jsPadrao()
	{
		$versao = self::$_Versao;
		return array("assets/js/jquery-1.10.2.min.js?versao={$versao}",
		"assets/js/jquery-migrate-1.2.1.min.js?versao={$versao}",
		"vendors/jquery-ui-1.11.4.custom/jquery-ui.min.js?versao={$versao}",
		"vendors/bootstrap/js/bootstrap.min.js?versao={$versao}",
		"vendors/bootstrap-hover-dropdown/bootstrap-hover-dropdown.js?versao={$versao}",
		"assets/js/html5shiv.js?versao={$versao}",
		"assets/js/respond.min.js",
		"vendors/metisMenu/jquery.metisMenu.js?versao={$versao}",
		"vendors/slimScroll/jquery.slimscroll.js?versao={$versao}",
		"vendors/jquery-cookie/jquery.cookie.js?versao={$versao}",
		"vendors/iCheck/icheck.min.js?versao={$versao}",
		"vendors/iCheck/custom.min.js?versao={$versao}",
		"vendors/jquery-notific8/jquery.notific8.min.js?versao={$versao}",
		"vendors/jquery-highcharts/highcharts.js?versao={$versao}",
		"assets/js/jquery.menu.js?versao={$versao}",
		"vendors/holder/holder.js?versao={$versao}",
		"vendors/responsive-tabs/responsive-tabs.js?versao={$versao}",
		"vendors/jquery-news-ticker/jquery.newsTicker.min.js?versao={$versao}",
		"vendors/moment/moment.js?versao={$versao}",
		"vendors/moment/min/moment-with-locales.js?versao={$versao}",
		"vendors/DataTables/datatables.min.js?versao={$versao}",
		"vendors/ckeditor/ckeditor.js?versao={$versao}",
		"vendors/select2/js/select2.full.min.js?versao={$versao}",
		"vendors/jquery-toastr/toastr.min.js?versao={$versao}",
		"vendors/jquery-mask/jquery.mask.min.js?versao={$versao}",
		"vendors/bootstrap-switch/js/bootstrap-switch.min.js?versao={$versao}",
		"assets/js/lobibox/js/lobibox.js?versao={$versao}",
		"assets/js/lobibox/js/messageboxes.js?versao={$versao}",
		"assets/js/lobibox/js/notifications.js?versao={$versao}",
		"assets/js/main.js?versao={$versao}");
	}
	######################################################################################################
	public static function iconPadrao()
	{
		return array(
			array("assets/images/icons/favicon.ico" => array("rel"=>"shortcut icon"))
			,array("assets/images/icons/favicon.png" => array("rel"=>"apple-touch-icon"))
			,array("assets/images/icons/favicon-72x72.png" => array("rel"=>"apple-touch-icon", "sizes"=>"72x72"))			
			,array("assets/images/icons/favicon-114x114.png" => array("rel"=>"apple-touch-icon", "sizes"=>"114x114")));
	}	
	######################################################################################################
	public static function printHard($stylesheets = [], $isrel = true, $isjs = true)
	{		
		if(empty($stylesheets))
			return;
		foreach( $stylesheets as $css ):
			$propriedade = "";
			if(is_array($css))
			{
				foreach ($css as $key => $lista)
				{
					$link = $key;
					$propriedade = "";
					if($isrel)
					{
						if(!array_key_exists("rel", $lista))
							$lista['rel'] = 'stylesheet';
					}
					foreach ($lista as $chave => $valor)
					{
						$propriedade .= " {$chave}=\"{$valor}\"";
					}
				}
			}
			elseif(is_string($css))
			{
				$link = $css;
				if($isrel)
					$propriedade = ' rel="stylesheet"';
			}
			if((strpos($link,'http://')===false)&&(strpos($link,'https://')===false))
				$link = base_url( $link );

			if($isjs)
				echo '<script src="'.$link.'"'.$propriedade.'></script>'."\n";
			else 
				echo '<link href="' .$link.'"'. $propriedade. '>'."\n";
		endforeach;
	}
	######################################################################################################
	public static function printLink($link = "/")
	{
		echo base_url($link);
	}
	######################################################################################################
	public function Hard()
	{
		self::printHard($this->GetICON(),false,false);
		self::printHard($this->GetCSS(),true,false);
		self::printHard($this->GetJSTop(),false,true);
	}
	######################################################################################################
	public function Rodape()
	{
		self::printHard($this->GetJS(),false,true);
	}
	################################################################################################################
	public static function GetIcones()
	{
		$icones = array('fa fa-glass',
		'fa fa-music',
		'fa fa-search',
		'fa fa-envelope-o',
		'fa fa-heart',
		'fa fa-star',
		'fa fa-star-o',
		'fa fa-user',
		'fa fa-film',
		'fa fa-th-large',
		'fa fa-th',
		'fa fa-th-list',
		'fa fa-check',
		'fa fa-remove',
		'fa fa-close',
		'fa fa-times',
		'fa fa-search-plus',
		'fa fa-search-minus',
		'fa fa-power-off',
		'fa fa-signal',
		'fa fa-gear',
		'fa fa-cog',
		'fa fa-trash-o',
		'fa fa-home',
		'fa fa-file-o',
		'fa fa-clock-o',
		'fa fa-road',
		'fa fa-download',
		'fa fa-arrow-circle-o-down',
		'fa fa-arrow-circle-o-up',
		'fa fa-inbox',
		'fa fa-play-circle-o',
		'fa fa-rotate-right',
		'fa fa-repeat',
		'fa fa-refresh',
		'fa fa-list-alt',
		'fa fa-lock',
		'fa fa-flag',
		'fa fa-headphones',
		'fa fa-volume-off',
		'fa fa-volume-down',
		'fa fa-volume-up',
		'fa fa-qrcode',
		'fa fa-barcode',
		'fa fa-tag',
		'fa fa-tags',
		'fa fa-book',
		'fa fa-bookmark',
		'fa fa-print',
		'fa fa-camera',
		'fa fa-font',
		'fa fa-bold',
		'fa fa-italic',
		'fa fa-text-height',
		'fa fa-text-width',
		'fa fa-align-left',
		'fa fa-align-center',
		'fa fa-align-right',
		'fa fa-align-justify',
		'fa fa-list',
		'fa fa-dedent',
		'fa fa-outdent',
		'fa fa-indent',
		'fa fa-video-camera',
		'fa fa-photo',
		'fa fa-image',
		'fa fa-picture-o',
		'fa fa-pencil',
		'fa fa-map-marker',
		'fa fa-adjust',
		'fa fa-tint',
		'fa fa-edit',
		'fa fa-pencil-square-o',
		'fa fa-share-square-o',
		'fa fa-check-square-o',
		'fa fa-arrows',
		'fa fa-step-backward',
		'fa fa-fast-backward',
		'fa fa-backward',
		'fa fa-play',
		'fa fa-pause',
		'fa fa-stop',
		'fa fa-forward',
		'fa fa-fast-forward',
		'fa fa-step-forward',
		'fa fa-eject',
		'fa fa-chevron-left',
		'fa fa-chevron-right',
		'fa fa-plus-circle',
		'fa fa-minus-circle',
		'fa fa-times-circle',
		'fa fa-check-circle',
		'fa fa-question-circle',
		'fa fa-info-circle',
		'fa fa-crosshairs',
		'fa fa-times-circle-o',
		'fa fa-check-circle-o',
		'fa fa-ban',
		'fa fa-arrow-left',
		'fa fa-arrow-right',
		'fa fa-arrow-up',
		'fa fa-arrow-down',
		'fa fa-mail-forward',
		'fa fa-share',
		'fa fa-expand',
		'fa fa-compress',
		'fa fa-plus',
		'fa fa-minus',
		'fa fa-asterisk',
		'fa fa-exclamation-circle',
		'fa fa-gift',
		'fa fa-leaf',
		'fa fa-fire',
		'fa fa-eye',
		'fa fa-eye-slash',
		'fa fa-warning',
		'fa fa-exclamation-triangle',
		'fa fa-plane',
		'fa fa-calendar',
		'fa fa-random',
		'fa fa-comment',
		'fa fa-magnet',
		'fa fa-chevron-up',
		'fa fa-chevron-down',
		'fa fa-retweet',
		'fa fa-shopping-cart',
		'fa fa-folder',
		'fa fa-folder-open',
		'fa fa-arrows-v',
		'fa fa-arrows-h',
		'fa fa-bar-chart-o',
		'fa fa-bar-chart',
		'fa fa-twitter-square',
		'fa fa-facebook-square',
		'fa fa-camera-retro',
		'fa fa-key',
		'fa fa-gears',
		'fa fa-cogs',
		'fa fa-comments',
		'fa fa-thumbs-o-up',
		'fa fa-thumbs-o-down',
		'fa fa-star-half',
		'fa fa-heart-o',
		'fa fa-sign-out',
		'fa fa-linkedin-square',
		'fa fa-thumb-tack',
		'fa fa-external-link',
		'fa fa-sign-in',
		'fa fa-trophy',
		'fa fa-github-square',
		'fa fa-upload',
		'fa fa-lemon-o',
		'fa fa-phone',
		'fa fa-square-o',
		'fa fa-bookmark-o',
		'fa fa-phone-square',
		'fa fa-twitter',
		'fa fa-facebook-f',
		'fa fa-facebook',
		'fa fa-github',
		'fa fa-unlock',
		'fa fa-credit-card',
		'fa fa-rss',
		'fa fa-hdd-o',
		'fa fa-bullhorn',
		'fa fa-bell',
		'fa fa-certificate',
		'fa fa-hand-o-right',
		'fa fa-hand-o-left',
		'fa fa-hand-o-up',
		'fa fa-hand-o-down',
		'fa fa-arrow-circle-left',
		'fa fa-arrow-circle-right',
		'fa fa-arrow-circle-up',
		'fa fa-arrow-circle-down',
		'fa fa-globe',
		'fa fa-wrench',
		'fa fa-tasks',
		'fa fa-filter',
		'fa fa-briefcase',
		'fa fa-arrows-alt',
		'fa fa-group',
		'fa fa-users',
		'fa fa-chain',
		'fa fa-link',
		'fa fa-cloud',
		'fa fa-flask',
		'fa fa-cut',
		'fa fa-scissors',
		'fa fa-copy',
		'fa fa-files-o',
		'fa fa-paperclip',
		'fa fa-save',
		'fa fa-floppy-o',
		'fa fa-square',
		'fa fa-navicon',
		'fa fa-reorder',
		'fa fa-bars',
		'fa fa-list-ul',
		'fa fa-list-ol',
		'fa fa-strikethrough',
		'fa fa-underline',
		'fa fa-table',
		'fa fa-magic',
		'fa fa-truck',
		'fa fa-pinterest',
		'fa fa-pinterest-square',
		'fa fa-google-plus-square',
		'fa fa-google-plus',
		'fa fa-money',
		'fa fa-caret-down',
		'fa fa-caret-up',
		'fa fa-caret-left',
		'fa fa-caret-right',
		'fa fa-columns',
		'fa fa-unsorted',
		'fa fa-sort',
		'fa fa-sort-down',
		'fa fa-sort-desc',
		'fa fa-sort-up',
		'fa fa-sort-asc',
		'fa fa-envelope',
		'fa fa-linkedin',
		'fa fa-rotate-left',
		'fa fa-undo',
		'fa fa-legal',
		'fa fa-gavel',
		'fa fa-dashboard',
		'fa fa-tachometer',
		'fa fa-comment-o',
		'fa fa-comments-o',
		'fa fa-flash',
		'fa fa-bolt',
		'fa fa-sitemap',
		'fa fa-umbrella',
		'fa fa-paste',
		'fa fa-clipboard',
		'fa fa-lightbulb-o',
		'fa fa-exchange',
		'fa fa-cloud-download',
		'fa fa-cloud-upload',
		'fa fa-user-md',
		'fa fa-stethoscope',
		'fa fa-suitcase',
		'fa fa-bell-o',
		'fa fa-coffee',
		'fa fa-cutlery',
		'fa fa-file-text-o',
		'fa fa-building-o',
		'fa fa-hospital-o',
		'fa fa-ambulance',
		'fa fa-medkit',
		'fa fa-fighter-jet',
		'fa fa-beer',
		'fa fa-h-square',
		'fa fa-plus-square',
		'fa fa-angle-double-left',
		'fa fa-angle-double-right',
		'fa fa-angle-double-up',
		'fa fa-angle-double-down',
		'fa fa-angle-left',
		'fa fa-angle-right',
		'fa fa-angle-up',
		'fa fa-angle-down',
		'fa fa-desktop',
		'fa fa-laptop',
		'fa fa-tablet',
		'fa fa-mobile-phone',
		'fa fa-mobile',
		'fa fa-circle-o',
		'fa fa-quote-left',
		'fa fa-quote-right',
		'fa fa-spinner',
		'fa fa-circle',
		'fa fa-mail-reply',
		'fa fa-reply',
		'fa fa-github-alt',
		'fa fa-folder-o',
		'fa fa-folder-open-o',
		'fa fa-smile-o',
		'fa fa-frown-o',
		'fa fa-meh-o',
		'fa fa-gamepad',
		'fa fa-keyboard-o',
		'fa fa-flag-o',
		'fa fa-flag-checkered',
		'fa fa-terminal',
		'fa fa-code',
		'fa fa-mail-reply-all',
		'fa fa-reply-all',
		'fa fa-star-half-empty',
		'fa fa-star-half-full',
		'fa fa-star-half-o',
		'fa fa-location-arrow',
		'fa fa-crop',
		'fa fa-code-fork',
		'fa fa-unlink',
		'fa fa-chain-broken',
		'fa fa-question',
		'fa fa-info',
		'fa fa-exclamation',
		'fa fa-superscript',
		'fa fa-subscript',
		'fa fa-eraser',
		'fa fa-puzzle-piece',
		'fa fa-microphone',
		'fa fa-microphone-slash',
		'fa fa-shield',
		'fa fa-calendar-o',
		'fa fa-fire-extinguisher',
		'fa fa-rocket',
		'fa fa-maxcdn',
		'fa fa-chevron-circle-left',
		'fa fa-chevron-circle-right',
		'fa fa-chevron-circle-up',
		'fa fa-chevron-circle-down',
		'fa fa-html5',
		'fa fa-css3',
		'fa fa-anchor',
		'fa fa-unlock-alt',
		'fa fa-bullseye',
		'fa fa-ellipsis-h',
		'fa fa-ellipsis-v',
		'fa fa-rss-square',
		'fa fa-play-circle',
		'fa fa-ticket',
		'fa fa-minus-square',
		'fa fa-minus-square-o',
		'fa fa-level-up',
		'fa fa-level-down',
		'fa fa-check-square',
		'fa fa-pencil-square',
		'fa fa-external-link-square',
		'fa fa-share-square',
		'fa fa-compass',
		'fa fa-toggle-down',
		'fa fa-caret-square-o-down',
		'fa fa-toggle-up',
		'fa fa-caret-square-o-up',
		'fa fa-toggle-right',
		'fa fa-caret-square-o-right',
		'fa fa-euro',
		'fa fa-eur',
		'fa fa-gbp',
		'fa fa-dollar',
		'fa fa-usd',
		'fa fa-rupee',
		'fa fa-inr',
		'fa fa-cny',
		'fa fa-rmb',
		'fa fa-yen',
		'fa fa-jpy',
		'fa fa-ruble',
		'fa fa-rouble',
		'fa fa-rub',
		'fa fa-won',
		'fa fa-krw',
		'fa fa-bitcoin',
		'fa fa-btc',
		'fa fa-file',
		'fa fa-file-text',
		'fa fa-sort-alpha-asc',
		'fa fa-sort-alpha-desc',
		'fa fa-sort-amount-asc',
		'fa fa-sort-amount-desc',
		'fa fa-sort-numeric-asc',
		'fa fa-sort-numeric-desc',
		'fa fa-thumbs-up',
		'fa fa-thumbs-down',
		'fa fa-youtube-square',
		'fa fa-youtube',
		'fa fa-xing',
		'fa fa-xing-square',
		'fa fa-youtube-play',
		'fa fa-dropbox',
		'fa fa-stack-overflow',
		'fa fa-instagram',
		'fa fa-flickr',
		'fa fa-adn',
		'fa fa-bitbucket',
		'fa fa-bitbucket-square',
		'fa fa-tumblr',
		'fa fa-tumblr-square',
		'fa fa-long-arrow-down',
		'fa fa-long-arrow-up',
		'fa fa-long-arrow-left',
		'fa fa-long-arrow-right',
		'fa fa-apple',
		'fa fa-windows',
		'fa fa-android',
		'fa fa-linux',
		'fa fa-dribbble',
		'fa fa-skype',
		'fa fa-foursquare',
		'fa fa-trello',
		'fa fa-female',
		'fa fa-male',
		'fa fa-gittip',
		'fa fa-gratipay',
		'fa fa-sun-o',
		'fa fa-moon-o',
		'fa fa-archive',
		'fa fa-bug',
		'fa fa-vk',
		'fa fa-weibo',
		'fa fa-renren',
		'fa fa-pagelines',
		'fa fa-stack-exchange',
		'fa fa-arrow-circle-o-right',
		'fa fa-arrow-circle-o-left',
		'fa fa-toggle-left',
		'fa fa-caret-square-o-left',
		'fa fa-dot-circle-o',
		'fa fa-wheelchair',
		'fa fa-vimeo-square',
		'fa fa-turkish-lira',
		'fa fa-try',
		'fa fa-plus-square-o',
		'fa fa-space-shuttle',
		'fa fa-slack',
		'fa fa-envelope-square',
		'fa fa-wordpress',
		'fa fa-openid',
		'fa fa-institution',
		'fa fa-bank',
		'fa fa-university',
		'fa fa-mortar-board',
		'fa fa-graduation-cap',
		'fa fa-yahoo',
		'fa fa-google',
		'fa fa-reddit',
		'fa fa-reddit-square',
		'fa fa-stumbleupon-circle',
		'fa fa-stumbleupon',
		'fa fa-delicious',
		'fa fa-digg',
		'fa fa-pied-piper',
		'fa fa-pied-piper-alt',
		'fa fa-drupal',
		'fa fa-joomla',
		'fa fa-language',
		'fa fa-fax',
		'fa fa-building',
		'fa fa-child',
		'fa fa-paw',
		'fa fa-spoon',
		'fa fa-cube',
		'fa fa-cubes',
		'fa fa-behance',
		'fa fa-behance-square',
		'fa fa-steam',
		'fa fa-steam-square',
		'fa fa-recycle',
		'fa fa-automobile',
		'fa fa-car',
		'fa fa-cab',
		'fa fa-taxi',
		'fa fa-tree',
		'fa fa-spotify',
		'fa fa-deviantart',
		'fa fa-soundcloud',
		'fa fa-database',
		'fa fa-file-pdf-o',
		'fa fa-file-word-o',
		'fa fa-file-excel-o',
		'fa fa-file-powerpoint-o',
		'fa fa-file-photo-o',
		'fa fa-file-picture-o',
		'fa fa-file-image-o',
		'fa fa-file-zip-o',
		'fa fa-file-archive-o',
		'fa fa-file-sound-o',
		'fa fa-file-audio-o',
		'fa fa-file-movie-o',
		'fa fa-file-video-o',
		'fa fa-file-code-o',
		'fa fa-vine',
		'fa fa-codepen',
		'fa fa-jsfiddle',
		'fa fa-life-bouy',
		'fa fa-life-buoy',
		'fa fa-life-saver',
		'fa fa-support',
		'fa fa-life-ring',
		'fa fa-circle-o-notch',
		'fa fa-ra',
		'fa fa-rebel',
		'fa fa-ge',
		'fa fa-empire',
		'fa fa-git-square',
		'fa fa-git',
		'fa fa-hacker-news',
		'fa fa-tencent-weibo',
		'fa fa-qq',
		'fa fa-wechat',
		'fa fa-weixin',
		'fa fa-send',
		'fa fa-paper-plane',
		'fa fa-send-o',
		'fa fa-paper-plane-o',
		'fa fa-history',
		'fa fa-genderless',
		'fa fa-circle-thin',
		'fa fa-header',
		'fa fa-paragraph',
		'fa fa-sliders',
		'fa fa-share-alt',
		'fa fa-share-alt-square',
		'fa fa-bomb',
		'fa fa-soccer-ball-o',
		'fa fa-futbol-o',
		'fa fa-tty',
		'fa fa-binoculars',
		'fa fa-plug',
		'fa fa-slideshare',
		'fa fa-twitch',
		'fa fa-yelp',
		'fa fa-newspaper-o',
		'fa fa-wifi',
		'fa fa-calculator',
		'fa fa-paypal',
		'fa fa-google-wallet',
		'fa fa-cc-visa',
		'fa fa-cc-mastercard',
		'fa fa-cc-discover',
		'fa fa-cc-amex',
		'fa fa-cc-paypal',
		'fa fa-cc-stripe',
		'fa fa-bell-slash',
		'fa fa-bell-slash-o',
		'fa fa-trash',
		'fa fa-copyright',
		'fa fa-at',
		'fa fa-eyedropper',
		'fa fa-paint-brush',
		'fa fa-birthday-cake',
		'fa fa-area-chart',
		'fa fa-pie-chart',
		'fa fa-line-chart',
		'fa fa-lastfm',
		'fa fa-lastfm-square',
		'fa fa-toggle-off',
		'fa fa-toggle-on',
		'fa fa-bicycle',
		'fa fa-bus',
		'fa fa-ioxhost',
		'fa fa-angellist',
		'fa fa-cc',
		'fa fa-shekel',
		'fa fa-sheqel',
		'fa fa-ils',
		'fa fa-meanpath',
		'fa fa-buysellads',
		'fa fa-connectdevelop',
		'fa fa-dashcube',
		'fa fa-forumbee',
		'fa fa-leanpub',
		'fa fa-sellsy',
		'fa fa-shirtsinbulk',
		'fa fa-simplybuilt',
		'fa fa-skyatlas',
		'fa fa-cart-plus',
		'fa fa-cart-arrow-down',
		'fa fa-diamond',
		'fa fa-ship',
		'fa fa-user-secret',
		'fa fa-motorcycle',
		'fa fa-street-view',
		'fa fa-heartbeat',
		'fa fa-venus',
		'fa fa-mars',
		'fa fa-mercury',
		'fa fa-transgender',
		'fa fa-transgender-alt',
		'fa fa-venus-double',
		'fa fa-mars-double',
		'fa fa-venus-mars',
		'fa fa-mars-stroke',
		'fa fa-mars-stroke-v',
		'fa fa-mars-stroke-h',
		'fa fa-neuter',
		'fa fa-facebook-official',
		'fa fa-pinterest-p',
		'fa fa-whatsapp',
		'fa fa-server',
		'fa fa-user-plus',
		'fa fa-user-times',
		'fa fa-hotel',
		'fa fa-bed',
		'fa fa-viacoin',
		'fa fa-train',
		'fa fa-subway',
		'fa fa-medium',
		'el el-address-book-alt',
		'el el-address-book',
		'el el-adjust-alt',
		'el el-adjust',
		'el el-adult',
		'el el-align-center',
		'el el-align-justify',
		'el el-align-left',
		'el el-align-right',
		'el el-arrow-down',
		'el el-arrow-left',
		'el el-arrow-right',
		'el el-arrow-up',
		'el el-asl',
		'el el-asterisk',
		'el el-backward',
		'el el-ban-circle',
		'el el-barcode',
		'el el-behance',
		'el el-bell',
		'el el-blind',
		'el el-blogger',
		'el el-bold',
		'el el-book',
		'el el-bookmark-empty',
		'el el-bookmark',
		'el el-braille',
		'el el-briefcase',
		'el el-broom',
		'el el-brush',
		'el el-bulb',
		'el el-bullhorn',
		'el el-calendar-sign',
		'el el-calendar',
		'el el-camera',
		'el el-car',
		'el el-caret-down',
		'el el-caret-left',
		'el el-caret-right',
		'el el-caret-up',
		'el el-cc',
		'el el-certificate',
		'el el-check-empty',
		'el el-check',
		'el el-chevron-down',
		'el el-chevron-left',
		'el el-chevron-right',
		'el el-chevron-up',
		'el el-child',
		'el el-circle-arrow-down',
		'el el-circle-arrow-left',
		'el el-circle-arrow-right',
		'el el-circle-arrow-up',
		'el el-cloud-alt',
		'el el-cloud',
		'el el-cog-alt',
		'el el-cog',
		'el el-cogs',
		'el el-comment-alt',
		'el el-comment',
		'el el-compass-alt',
		'el el-compass',
		'el el-credit-card',
		'el el-css',
		'el el-dashboard',
		'el el-delicious',
		'el el-deviantart',
		'el el-digg',
		'el el-download-alt',
		'el el-download',
		'el el-dribbble',
		'el el-edit',
		'el el-eject',
		'el el-envelope-alt',
		'el el-envelope',
		'el el-error-alt',
		'el el-error',
		'el el-eur',
		'el el-exclamation-sign',
		'el el-eye-close',
		'el el-eye-open',
		'el el-facebook',
		'el el-facetime-video',
		'el el-fast-backward',
		'el el-fast-forward',
		'el el-female',
		'el el-file-alt',
		'el el-file-edit-alt',
		'el el-file-edit',
		'el el-file-new-alt',
		'el el-file-new',
		'el el-file',
		'el el-film',
		'el el-filter',
		'el el-fire',
		'el el-flag-alt',
		'el el-flag',
		'el el-flickr',
		'el el-folder-close',
		'el el-folder-open',
		'el el-folder-sign',
		'el el-folder',
		'el el-font',
		'el el-fontsize',
		'el el-fork',
		'el el-forward-alt',
		'el el-forward',
		'el el-foursquare',
		'el el-friendfeed-rect',
		'el el-friendfeed',
		'el el-fullscreen',
		'el el-gbp',
		'el el-gift',
		'el el-github-text',
		'el el-github',
		'el el-glass',
		'el el-glasses',
		'el el-globe-alt',
		'el el-globe',
		'el el-googleplus',
		'el el-graph-alt',
		'el el-graph',
		'el el-group-alt',
		'el el-group',
		'el el-guidedog',
		'el el-hand-down',
		'el el-hand-left',
		'el el-hand-right',
		'el el-hand-up',
		'el el-hdd',
		'el el-headphones',
		'el el-hearing-impaired',
		'el el-heart-alt',
		'el el-heart-empty',
		'el el-heart',
		'el el-home-alt',
		'el el-home',
		'el el-hourglass',
		'el el-idea-alt',
		'el el-idea',
		'el el-inbox-alt',
		'el el-inbox-box',
		'el el-inbox',
		'el el-indent-left',
		'el el-indent-right',
		'el el-info-circle',
		'el el-instagram',
		'el el-iphone-home',
		'el el-italic',
		'el el-key',
		'el el-laptop-alt',
		'el el-laptop',
		'el el-lastfm',
		'el el-leaf',
		'el el-lines',
		'el el-link',
		'el el-linkedin',
		'el el-list-alt',
		'el el-list',
		'el el-livejournal',
		'el el-lock-alt',
		'el el-lock',
		'el el-magic',
		'el el-magnet',
		'el el-male',
		'el el-map-marker-alt',
		'el el-map-marker',
		'el el-mic-alt',
		'el el-mic',
		'el el-minus-sign',
		'el el-minus',
		'el el-move',
		'el el-music',
		'el el-myspace',
		'el el-network',
		'el el-off',
		'el el-ok-circle',
		'el el-ok-sign',
		'el el-ok',
		'el el-opensource',
		'el el-paper-clip-alt',
		'el el-paper-clip',
		'el el-path',
		'el el-pause-alt',
		'el el-pause',
		'el el-pencil-alt',
		'el el-pencil',
		'el el-person',
		'el el-phone-alt',
		'el el-phone',
		'el el-photo-alt',
		'el el-photo',
		'el el-picasa',
		'el el-picture',
		'el el-pinterest',
		'el el-plane',
		'el el-play-alt',
		'el el-play-circle',
		'el el-play',
		'el el-plurk-alt',
		'el el-plurk',
		'el el-plus-sign',
		'el el-plus',
		'el el-podcast',
		'el el-print',
		'el el-puzzle',
		'el el-qrcode',
		'el el-question-sign',
		'el el-question',
		'el el-quote-alt',
		'el el-quote-right-alt',
		'el el-quote-right',
		'el el-quotes',
		'el el-random',
		'el el-record',
		'el el-reddit',
		'el el-redux',
		'el el-refresh',
		'el el-remove-circle',
		'el el-remove-sign',
		'el el-remove',
		'el el-repeat-alt',
		'el el-repeat',
		'el el-resize-full',
		'el el-resize-horizontal',
		'el el-resize-small',
		'el el-resize-vertical',
		'el el-return-key',
		'el el-retweet',
		'el el-reverse-alt',
		'el el-road',
		'el el-rss',
		'el el-scissors',
		'el el-screen-alt',
		'el el-screen',
		'el el-screenshot',
		'el el-search-alt',
		'el el-search',
		'el el-share-alt',
		'el el-share',
		'el el-shopping-cart-sign',
		'el el-shopping-cart',
		'el el-signal',
		'el el-skype',
		'el el-slideshare',
		'el el-smiley-alt',
		'el el-smiley',
		'el el-soundcloud',
		'el el-speaker',
		'el el-spotify',
		'el el-stackoverflow',
		'el el-star-alt',
		'el el-star-empty',
		'el el-star',
		'el el-step-backward',
		'el el-step-forward',
		'el el-stop-alt',
		'el el-stop',
		'el el-stumbleupon',
		'el el-tag',
		'el el-tags',
		'el el-tasks',
		'el el-text-height',
		'el el-text-width',
		'el el-th-large',
		'el el-th-list',
		'el el-th',
		'el el-thumbs-down',
		'el el-thumbs-up',
		'el el-time-alt',
		'el el-time',
		'el el-tint',
		'el el-torso',
		'el el-trash-alt',
		'el el-trash',
		'el el-tumblr',
		'el el-twitter',
		'el el-universal-access',
		'el el-unlock-alt',
		'el el-unlock',
		'el el-upload',
		'el el-usd',
		'el el-user',
		'el el-viadeo',
		'el el-video-alt',
		'el el-video-chat',
		'el el-video',
		'el el-view-mode',
		'el el-vimeo',
		'el el-vkontakte',
		'el el-volume-down',
		'el el-volume-off',
		'el el-volume-up',
		'el el-w3c',
		'el el-warning-sign',
		'el el-website-alt',
		'el el-website',
		'el el-wheelchair',
		'el el-wordpress',
		'el el-wrench-alt',
		'el el-wrench',
		'el el-youtube',
		'el el-zoom-in',
		'el el-zoom-out',
		'ion ion-alert',
		'ion ion-alert-circled',
		'ion ion-android-add',
		'ion ion-android-add-contact',
		'ion ion-android-alarm',
		'ion ion-android-archive',
		'ion ion-android-arrow-back',
		'ion ion-android-arrow-down-left',
		'ion ion-android-arrow-down-right',
		'ion ion-android-arrow-forward',
		'ion ion-android-arrow-up-left',
		'ion ion-android-arrow-up-right',
		'ion ion-android-battery',
		'ion ion-android-book',
		'ion ion-android-calendar',
		'ion ion-android-call',
		'ion ion-android-camera',
		'ion ion-android-chat',
		'ion ion-android-checkmark',
		'ion ion-android-clock',
		'ion ion-android-close',
		'ion ion-android-contact',
		'ion ion-android-contacts',
		'ion ion-android-data',
		'ion ion-android-developer',
		'ion ion-android-display',
		'ion ion-android-download',
		'ion ion-android-drawer',
		'ion ion-android-dropdown',
		'ion ion-android-earth',
		'ion ion-android-folder',
		'ion ion-android-forums',
		'ion ion-android-friends',
		'ion ion-android-hand',
		'ion ion-android-image',
		'ion ion-android-inbox',
		'ion ion-android-information',
		'ion ion-android-keypad',
		'ion ion-android-lightbulb',
		'ion ion-android-locate',
		'ion ion-android-location',
		'ion ion-android-mail',
		'ion ion-android-microphone',
		'ion ion-android-mixer',
		'ion ion-android-more',
		'ion ion-android-note',
		'ion ion-android-playstore',
		'ion ion-android-printer',
		'ion ion-android-promotion',
		'ion ion-android-reminder',
		'ion ion-android-remove',
		'ion ion-android-search',
		'ion ion-android-send',
		'ion ion-android-settings',
		'ion ion-android-share',
		'ion ion-android-social',
		'ion ion-android-social-user',
		'ion ion-android-sort',
		'ion ion-android-stair-drawer',
		'ion ion-android-star',
		'ion ion-android-stopwatch',
		'ion ion-android-storage',
		'ion ion-android-system-back',
		'ion ion-android-system-home',
		'ion ion-android-system-windows',
		'ion ion-android-timer',
		'ion ion-android-trash',
		'ion ion-android-user-menu',
		'ion ion-android-volume',
		'ion ion-android-wifi',
		'ion ion-aperture',
		'ion ion-archive',
		'ion ion-arrow-down-a',
		'ion ion-arrow-down-b',
		'ion ion-arrow-down-c',
		'ion ion-arrow-expand',
		'ion ion-arrow-graph-down-left',
		'ion ion-arrow-graph-down-right',
		'ion ion-arrow-graph-up-left',
		'ion ion-arrow-graph-up-right',
		'ion ion-arrow-left-a',
		'ion ion-arrow-left-b',
		'ion ion-arrow-left-c',
		'ion ion-arrow-move',
		'ion ion-arrow-resize',
		'ion ion-arrow-return-left',
		'ion ion-arrow-return-right',
		'ion ion-arrow-right-a',
		'ion ion-arrow-right-b',
		'ion ion-arrow-right-c',
		'ion ion-arrow-shrink',
		'ion ion-arrow-swap',
		'ion ion-arrow-up-a',
		'ion ion-arrow-up-b',
		'ion ion-arrow-up-c',
		'ion ion-asterisk',
		'ion ion-at',
		'ion ion-bag',
		'ion ion-battery-charging',
		'ion ion-battery-empty',
		'ion ion-battery-full',
		'ion ion-battery-half',
		'ion ion-battery-low',
		'ion ion-beaker',
		'ion ion-beer',
		'ion ion-bluetooth',
		'ion ion-bonfire',
		'ion ion-bookmark',
		'ion ion-briefcase',
		'ion ion-bug',
		'ion ion-calculator',
		'ion ion-calendar',
		'ion ion-camera',
		'ion ion-card',
		'ion ion-cash',
		'ion ion-chatbox',
		'ion ion-chatbox-working',
		'ion ion-chatboxes',
		'ion ion-chatbubble',
		'ion ion-chatbubble-working',
		'ion ion-chatbubbles',
		'ion ion-checkmark',
		'ion ion-checkmark-circled',
		'ion ion-checkmark-round',
		'ion ion-chevron-down',
		'ion ion-chevron-left',
		'ion ion-chevron-right',
		'ion ion-chevron-up',
		'ion ion-clipboard',
		'ion ion-clock',
		'ion ion-close',
		'ion ion-close-circled',
		'ion ion-close-round',
		'ion ion-closed-captioning',
		'ion ion-cloud',
		'ion ion-code',
		'ion ion-code-download',
		'ion ion-code-working',
		'ion ion-coffee',
		'ion ion-compass',
		'ion ion-compose',
		'ion ion-connection-bars',
		'ion ion-contrast',
		'ion ion-cube',
		'ion ion-disc',
		'ion ion-document',
		'ion ion-document-text',
		'ion ion-drag',
		'ion ion-earth',
		'ion ion-edit',
		'ion ion-egg',
		'ion ion-eject',
		'ion ion-email',
		'ion ion-eye',
		'ion ion-eye-disabled',
		'ion ion-female',
		'ion ion-filing',
		'ion ion-film-marker',
		'ion ion-fireball',
		'ion ion-flag',
		'ion ion-flame',
		'ion ion-flash',
		'ion ion-flash-off',
		'ion ion-flask',
		'ion ion-folder',
		'ion ion-fork',
		'ion ion-fork-repo',
		'ion ion-forward',
		'ion ion-funnel',
		'ion ion-game-controller-a',
		'ion ion-game-controller-b',
		'ion ion-gear-a',
		'ion ion-gear-b',
		'ion ion-grid',
		'ion ion-hammer',
		'ion ion-happy',
		'ion ion-headphone',
		'ion ion-heart',
		'ion ion-heart-broken',
		'ion ion-help',
		'ion ion-help-buoy',
		'ion ion-help-circled',
		'ion ion-home',
		'ion ion-icecream',
		'ion ion-icon-social-google-plus',
		'ion ion-icon-social-google-plus-outline',
		'ion ion-image',
		'ion ion-images',
		'ion ion-information',
		'ion ion-information-circled',
		'ion ion-ionic',
		'ion ion-ios7-alarm',
		'ion ion-ios7-alarm-outline',
		'ion ion-ios7-albums',
		'ion ion-ios7-albums-outline',
		'ion ion-ios7-americanfootball',
		'ion ion-ios7-americanfootball-outline',
		'ion ion-ios7-analytics',
		'ion ion-ios7-analytics-outline',
		'ion ion-ios7-arrow-back',
		'ion ion-ios7-arrow-down',
		'ion ion-ios7-arrow-forward',
		'ion ion-ios7-arrow-left',
		'ion ion-ios7-arrow-right',
		'ion ion-ios7-arrow-thin-down',
		'ion ion-ios7-arrow-thin-left',
		'ion ion-ios7-arrow-thin-right',
		'ion ion-ios7-arrow-thin-up',
		'ion ion-ios7-arrow-up',
		'ion ion-ios7-at',
		'ion ion-ios7-at-outline',
		'ion ion-ios7-barcode',
		'ion ion-ios7-barcode-outline',
		'ion ion-ios7-baseball',
		'ion ion-ios7-baseball-outline',
		'ion ion-ios7-basketball',
		'ion ion-ios7-basketball-outline',
		'ion ion-ios7-bell',
		'ion ion-ios7-bell-outline',
		'ion ion-ios7-bolt',
		'ion ion-ios7-bolt-outline',
		'ion ion-ios7-bookmarks',
		'ion ion-ios7-bookmarks-outline',
		'ion ion-ios7-box',
		'ion ion-ios7-box-outline',
		'ion ion-ios7-briefcase',
		'ion ion-ios7-briefcase-outline',
		'ion ion-ios7-browsers',
		'ion ion-ios7-browsers-outline',
		'ion ion-ios7-calculator',
		'ion ion-ios7-calculator-outline',
		'ion ion-ios7-calendar',
		'ion ion-ios7-calendar-outline',
		'ion ion-ios7-camera',
		'ion ion-ios7-camera-outline',
		'ion ion-ios7-cart',
		'ion ion-ios7-cart-outline',
		'ion ion-ios7-chatboxes',
		'ion ion-ios7-chatboxes-outline',
		'ion ion-ios7-chatbubble',
		'ion ion-ios7-chatbubble-outline',
		'ion ion-ios7-checkmark',
		'ion ion-ios7-checkmark-empty',
		'ion ion-ios7-checkmark-outline',
		'ion ion-ios7-circle-filled',
		'ion ion-ios7-circle-outline',
		'ion ion-ios7-clock',
		'ion ion-ios7-clock-outline',
		'ion ion-ios7-close',
		'ion ion-ios7-close-empty',
		'ion ion-ios7-close-outline',
		'ion ion-ios7-cloud',
		'ion ion-ios7-cloud-download',
		'ion ion-ios7-cloud-download-outline',
		'ion ion-ios7-cloud-outline',
		'ion ion-ios7-cloud-upload',
		'ion ion-ios7-cloud-upload-outline',
		'ion ion-ios7-cloudy',
		'ion ion-ios7-cloudy-night',
		'ion ion-ios7-cloudy-night-outline',
		'ion ion-ios7-cloudy-outline',
		'ion ion-ios7-cog',
		'ion ion-ios7-cog-outline',
		'ion ion-ios7-compose',
		'ion ion-ios7-compose-outline',
		'ion ion-ios7-contact',
		'ion ion-ios7-contact-outline',
		'ion ion-ios7-copy',
		'ion ion-ios7-copy-outline',
		'ion ion-ios7-download',
		'ion ion-ios7-download-outline',
		'ion ion-ios7-drag',
		'ion ion-ios7-email',
		'ion ion-ios7-email-outline',
		'ion ion-ios7-expand',
		'ion ion-ios7-eye',
		'ion ion-ios7-eye-outline',
		'ion ion-ios7-fastforward',
		'ion ion-ios7-fastforward-outline',
		'ion ion-ios7-filing',
		'ion ion-ios7-filing-outline',
		'ion ion-ios7-film',
		'ion ion-ios7-film-outline',
		'ion ion-ios7-flag',
		'ion ion-ios7-flag-outline',
		'ion ion-ios7-folder',
		'ion ion-ios7-folder-outline',
		'ion ion-ios7-football',
		'ion ion-ios7-football-outline',
		'ion ion-ios7-gear',
		'ion ion-ios7-gear-outline',
		'ion ion-ios7-glasses',
		'ion ion-ios7-glasses-outline',
		'ion ion-ios7-heart',
		'ion ion-ios7-heart-outline',
		'ion ion-ios7-help',
		'ion ion-ios7-help-empty',
		'ion ion-ios7-help-outline',
		'ion ion-ios7-home',
		'ion ion-ios7-home-outline',
		'ion ion-ios7-infinite',
		'ion ion-ios7-infinite-outline',
		'ion ion-ios7-information',
		'ion ion-ios7-information-empty',
		'ion ion-ios7-information-outline',
		'ion ion-ios7-ionic-outline',
		'ion ion-ios7-keypad',
		'ion ion-ios7-keypad-outline',
		'ion ion-ios7-lightbulb',
		'ion ion-ios7-lightbulb-outline',
		'ion ion-ios7-location',
		'ion ion-ios7-location-outline',
		'ion ion-ios7-locked',
		'ion ion-ios7-locked-outline',
		'ion ion-ios7-loop',
		'ion ion-ios7-loop-strong',
		'ion ion-ios7-medkit',
		'ion ion-ios7-medkit-outline',
		'ion ion-ios7-mic',
		'ion ion-ios7-mic-off',
		'ion ion-ios7-mic-outline',
		'ion ion-ios7-minus',
		'ion ion-ios7-minus-empty',
		'ion ion-ios7-minus-outline',
		'ion ion-ios7-monitor',
		'ion ion-ios7-monitor-outline',
		'ion ion-ios7-moon',
		'ion ion-ios7-moon-outline',
		'ion ion-ios7-more',
		'ion ion-ios7-more-outline',
		'ion ion-ios7-musical-note',
		'ion ion-ios7-musical-notes',
		'ion ion-ios7-navigate',
		'ion ion-ios7-navigate-outline',
		'ion ion-ios7-paper',
		'ion ion-ios7-paper-outline',
		'ion ion-ios7-paperplane',
		'ion ion-ios7-paperplane-outline',
		'ion ion-ios7-partlysunny',
		'ion ion-ios7-partlysunny-outline',
		'ion ion-ios7-pause',
		'ion ion-ios7-pause-outline',
		'ion ion-ios7-paw',
		'ion ion-ios7-paw-outline',
		'ion ion-ios7-people',
		'ion ion-ios7-people-outline',
		'ion ion-ios7-person',
		'ion ion-ios7-person-outline',
		'ion ion-ios7-personadd',
		'ion ion-ios7-personadd-outline',
		'ion ion-ios7-photos',
		'ion ion-ios7-photos-outline',
		'ion ion-ios7-pie',
		'ion ion-ios7-pie-outline',
		'ion ion-ios7-play',
		'ion ion-ios7-play-outline',
		'ion ion-ios7-plus',
		'ion ion-ios7-plus-empty',
		'ion ion-ios7-plus-outline',
		'ion ion-ios7-pricetag',
		'ion ion-ios7-pricetag-outline',
		'ion ion-ios7-pricetags',
		'ion ion-ios7-pricetags-outline',
		'ion ion-ios7-printer',
		'ion ion-ios7-printer-outline',
		'ion ion-ios7-pulse',
		'ion ion-ios7-pulse-strong',
		'ion ion-ios7-rainy',
		'ion ion-ios7-rainy-outline',
		'ion ion-ios7-recording',
		'ion ion-ios7-recording-outline',
		'ion ion-ios7-redo',
		'ion ion-ios7-redo-outline',
		'ion ion-ios7-refresh',
		'ion ion-ios7-refresh-empty',
		'ion ion-ios7-refresh-outline',
		'ion ion-ios7-reload',  'ion ion-ios7-reloading',
		'ion ion-ios7-reverse-camera',
		'ion ion-ios7-reverse-camera-outline',
		'ion ion-ios7-rewind',
		'ion ion-ios7-rewind-outline',
		'ion ion-ios7-search',
		'ion ion-ios7-search-strong',
		'ion ion-ios7-settings',
		'ion ion-ios7-settings-strong',
		'ion ion-ios7-shrink',
		'ion ion-ios7-skipbackward',
		'ion ion-ios7-skipbackward-outline',
		'ion ion-ios7-skipforward',
		'ion ion-ios7-skipforward-outline',
		'ion ion-ios7-snowy',
		'ion ion-ios7-speedometer',
		'ion ion-ios7-speedometer-outline',
		'ion ion-ios7-star',
		'ion ion-ios7-star-half',
		'ion ion-ios7-star-outline',
		'ion ion-ios7-stopwatch',
		'ion ion-ios7-stopwatch-outline',
		'ion ion-ios7-sunny',
		'ion ion-ios7-sunny-outline',
		'ion ion-ios7-telephone',
		'ion ion-ios7-telephone-outline',
		'ion ion-ios7-tennisball',
		'ion ion-ios7-tennisball-outline',
		'ion ion-ios7-thunderstorm',
		'ion ion-ios7-thunderstorm-outline',
		'ion ion-ios7-time',
		'ion ion-ios7-time-outline',
		'ion ion-ios7-timer',
		'ion ion-ios7-timer-outline',
		'ion ion-ios7-toggle',
		'ion ion-ios7-toggle-outline',
		'ion ion-ios7-trash',
		'ion ion-ios7-trash-outline',
		'ion ion-ios7-undo',
		'ion ion-ios7-undo-outline',
		'ion ion-ios7-unlocked',
		'ion ion-ios7-unlocked-outline',
		'ion ion-ios7-upload',
		'ion ion-ios7-upload-outline',
		'ion ion-ios7-videocam',
		'ion ion-ios7-videocam-outline',
		'ion ion-ios7-volume-high',
		'ion ion-ios7-volume-low',
		'ion ion-ios7-wineglass',
		'ion ion-ios7-wineglass-outline',
		'ion ion-ios7-world',
		'ion ion-ios7-world-outline',
		'ion ion-ipad',
		'ion ion-iphone',
		'ion ion-ipod',
		'ion ion-jet',
		'ion ion-key',
		'ion ion-knife',
		'ion ion-laptop',
		'ion ion-leaf',
		'ion ion-levels',
		'ion ion-lightbulb',
		'ion ion-link',
		'ion ion-load-a',  'ion ion-loading-a',
		'ion ion-load-b',  'ion ion-loading-b',
		'ion ion-load-c',  'ion ion-loading-c',
		'ion ion-load-d',  'ion ion-loading-d',
		'ion ion-location',
		'ion ion-locked',
		'ion ion-log-in',
		'ion ion-log-out',
		'ion ion-loop',  'ion ion-looping',
		'ion ion-magnet',
		'ion ion-male',
		'ion ion-man',
		'ion ion-map',
		'ion ion-medkit',
		'ion ion-merge',
		'ion ion-mic-a',
		'ion ion-mic-b',
		'ion ion-mic-c',
		'ion ion-minus',
		'ion ion-minus-circled',
		'ion ion-minus-round',
		'ion ion-model-s',
		'ion ion-monitor',
		'ion ion-more',
		'ion ion-mouse',
		'ion ion-music-note',
		'ion ion-navicon',
		'ion ion-navicon-round',
		'ion ion-navigate',
		'ion ion-network',
		'ion ion-no-smoking',
		'ion ion-nuclear',
		'ion ion-outlet',
		'ion ion-paper-airplane',
		'ion ion-paperclip',
		'ion ion-pause',
		'ion ion-person',
		'ion ion-person-add',
		'ion ion-person-stalker',
		'ion ion-pie-graph',
		'ion ion-pin',
		'ion ion-pinpoint',
		'ion ion-pizza',
		'ion ion-plane',
		'ion ion-planet',
		'ion ion-play',
		'ion ion-playstation',
		'ion ion-plus',
		'ion ion-plus-circled',
		'ion ion-plus-round',
		'ion ion-podium',
		'ion ion-pound',
		'ion ion-power',
		'ion ion-pricetag',
		'ion ion-pricetags',
		'ion ion-printer',
		'ion ion-pull-request',
		'ion ion-qr-scanner',
		'ion ion-quote',
		'ion ion-radio-waves',
		'ion ion-record',
		'ion ion-refresh', 'ion ion-refreshing',
		'ion ion-reply',
		'ion ion-reply-all',
		'ion ion-ribbon-a',
		'ion ion-ribbon-b',
		'ion ion-sad',
		'ion ion-scissors',
		'ion ion-search',
		'ion ion-settings',
		'ion ion-share',
		'ion ion-shuffle',
		'ion ion-skip-backward',
		'ion ion-skip-forward',
		'ion ion-social-android',
		'ion ion-social-android-outline',
		'ion ion-social-apple',
		'ion ion-social-apple-outline',
		'ion ion-social-bitcoin',
		'ion ion-social-bitcoin-outline',
		'ion ion-social-buffer',
		'ion ion-social-buffer-outline',
		'ion ion-social-designernews',
		'ion ion-social-designernews-outline',
		'ion ion-social-dribbble',
		'ion ion-social-dribbble-outline',
		'ion ion-social-dropbox',
		'ion ion-social-dropbox-outline',
		'ion ion-social-facebook',
		'ion ion-social-facebook-outline',
		'ion ion-social-foursquare',
		'ion ion-social-foursquare-outline',
		'ion ion-social-freebsd-devil',
		'ion ion-social-github',
		'ion ion-social-github-outline',
		'ion ion-social-google',
		'ion ion-social-google-outline',
		'ion ion-social-googleplus',
		'ion ion-social-googleplus-outline',
		'ion ion-social-hackernews',
		'ion ion-social-hackernews-outline',
		'ion ion-social-instagram',
		'ion ion-social-instagram-outline',
		'ion ion-social-linkedin',
		'ion ion-social-linkedin-outline',
		'ion ion-social-pinterest',
		'ion ion-social-pinterest-outline',
		'ion ion-social-reddit',
		'ion ion-social-reddit-outline',
		'ion ion-social-rss',
		'ion ion-social-rss-outline',
		'ion ion-social-skype',
		'ion ion-social-skype-outline',
		'ion ion-social-tumblr',
		'ion ion-social-tumblr-outline',
		'ion ion-social-tux',
		'ion ion-social-twitter',
		'ion ion-social-twitter-outline',
		'ion ion-social-usd',
		'ion ion-social-usd-outline',
		'ion ion-social-vimeo',
		'ion ion-social-vimeo-outline',
		'ion ion-social-windows',
		'ion ion-social-windows-outline',
		'ion ion-social-wordpress',
		'ion ion-social-wordpress-outline',
		'ion ion-social-yahoo',
		'ion ion-social-yahoo-outline',
		'ion ion-social-youtube',
		'ion ion-social-youtube-outline',
		'ion ion-speakerphone',
		'ion ion-speedometer',
		'ion ion-spoon',
		'ion ion-star',
		'ion ion-stats-bars',
		'ion ion-steam',
		'ion ion-stop',
		'ion ion-thermometer',
		'ion ion-thumbsdown',
		'ion ion-thumbsup',
		'ion ion-toggle',
		'ion ion-toggle-filled',
		'ion ion-trash-a',
		'ion ion-trash-b',
		'ion ion-trophy',
		'ion ion-umbrella',
		'ion ion-university',
		'ion ion-unlocked',
		'ion ion-upload',
		'ion ion-usb',
		'ion ion-videocamera',
		'ion ion-volume-high',
		'ion ion-volume-low',
		'ion ion-volume-medium',
		'ion ion-volume-mute',
		'ion ion-wand',
		'ion ion-waterdrop',
		'ion ion-wifi',
		'ion ion-wineglass',
		'ion ion-woman',
		'ion ion-wrench',
		'ion ion-xbox');

		return $icones;
	}
	################################################################################################################
	public function GetFlagAtivo()
	{
		$resultado = $this->CI->gettext->get_current();
		echo $resultado['flag'];
	}
	################################################################################################################
	public function ListadeIdiomas()
	{
		
		$resultados = $this->CI->gettext->languages();
		$ativo = $this->CI->gettext->get_current();
		$lista = "";
		foreach ($resultados as $key => $lang) {
			if($key == $ativo['folder'])
				$label = '<span class="pull-right text-muted small"> '. __('Ativo') .' </span>';
			else
				$label = '';
			$lista .= "<li><a href=\"javascript:;\" onclick=\"SetIdioma('{$lang['folder']}')\"><span class=\"label\"><i class=\"phoca-flag phoca-flagborda {$lang['flag']}\"></i></span> {$lang['name']} {$label}</a></li>";
		}
		echo $lista;
		return;
	}
	################################################################################################################
	public function Start()
	{
		$resultado = $this->CI->gettext->get_current();
		$this->CI->gettext->change($resultado['code']);
		return;
	}
	################################################################################################################
	public function GetPaisPadrao()
	{
		$pais = $this->CI->config->item('pais_padrao');
		if(empty($pais))
			$pais = "pt-br";
		
		return $pais;
	}
	################################################################################################################
	public function GetMoedaPadrao()
	{
		$moeda = $this->CI->config->item('moeda_padrao');
		if(empty($moeda))
			$moeda = "R$";
		
		return $moeda;
	}
	################################################################################################################
	public function &Request($dados = false)
	{
		if(empty($dados))
			$dados = $_REQUEST;
		if(is_array($dados))
		{
			foreach ($dados as $key => $value)
			{
				$valor = $this->CI->input->post_get($key);
				if(is_null($valor))
					$valor = Get($key, $value);
				$dados[$key] = $valor;
			}
		}
		elseif(is_string($dados))
		{
			$valor = $this->CI->input->post_get($dados);
			if(is_null($valor))
				$valor = Get($dados);
			$dados = $valor;
		}
		return $dados;
	}
	################################################################################################################
	public function GetLinkCurriculosNovos()
	{
		$link = "cadastradoinicio=".date("d/m/Y", DiaAdd(false, -30));
		return site_url("curriculo/listar/?{$link}");
	}
	################################################################################################################
	public function GetNumCurriculosNovos()
	{
		$obj = GetModelo("curriculo");
		$sql = "SELECT COUNT(*) as cont FROM curriculo WHERE cadastradoem >= ADDDATE(CURDATE(),INTERVAL -7 DAY)";
		return $obj->GetSqlCampo($sql, "cont", 0);
	}
	################################################################################################################
	public function GetLinkCurriculos()
	{
		$link = "cadastradoinicio=".date("d/m/Y", DiaAdd(false, -30));
		return site_url("curriculo/listar/?{$link}");
	}
	################################################################################################################
	public function GetNumCurriculos()
	{
		$obj = GetModelo("curriculo");
		$sql = "SELECT COUNT(*) as cont FROM curriculo";
		return $obj->GetSqlCampo($sql, "cont", 0);
	}
	################################################################################################################
	public function GetNomeSite()
	{
		$nome = $this->Config->GetConfig('nomesistema', "Captador");
		return $nome;
	}
	################################################################################################################
	public function GetBreadcrumbs($parte = "")
	{
		if(self::$Breadcrumbs == NULL)
		{
			return "";
		}
		if(empty($parte))
		{
			return self::$Breadcrumbs;
		}
		
		return self::$Breadcrumbs[$parte];
	}
	################################################################################################################
	public function SetBreadcrumbs($ativo = "", $url = "", $titulo = "")
	{
		self::$Breadcrumbs = array("ativo"=>$ativo,"url"=>$url, "titulo"=>$titulo);
		return;
	}
	################################################################################################################
	public function GetTituloSite()
	{
		if(self::$Titulo == NULL)
		{
			self::$Titulo = $this->Config->GetConfig('titulosite', $this->GetNomeSite());
		}
		if(empty(self::$Titulo))
			self::$Titulo = $this->GetNomeSite();
		return self::$Titulo;
	}
	################################################################################################################
	public function SetTituloSite($titulo = "")
	{
		if(empty($titulo))
			return;
		self::$Titulo = $titulo;
		return;
	}
	################################################################################################################
	public function SetConfig($nome = "", $valor = "")
	{
		if(empty($nome))
			return;
		if(empty($valor))
			return;
		$this->Config->SetConfig($nome, $valor);
		return;
	}
	################################################################################################################
	public function GetConfig($nome = "", $default = "")
	{
		if(empty($nome))
			return $default;
		return $this->Config->GetConfig($nome, $default);
	}
	################################################################################################################
	public function MenuModulo($nome = "")
	{
		$default = "";
		if(empty($nome))
			return $default;
		$class = $this->CI->router->class;
		if(is_string($nome))
			$nome = array($nome);
		foreach($nome as $key => $valor)
		{
			if(is_array($valor))
			{
				if(strcasecmp($class, $key) != 0)
				{
					continue;
				}
				$listauri = $this->CI->router->uri->rsegments;
				foreach($valor as $chave=>$value)
				{
					if(in_array($value, $listauri))
					{
						return ' class="active"';
					}
				}
			}
			else
			{
				if(strcasecmp($class, $valor) == 0)
				{
					return ' class="active"';
				}
			}
		}
		return $default;
	}
	################################################################################################################
	public function Menufuncao($modulo = "", $nome = "", $acao = "")
	{
		$default = "";
		if(empty($modulo))
			return $default;
		if(empty($nome))
			return $default;
		$aux = $this->MenuModulo($modulo);
		if(empty($aux))
			return $default;
		$class = $this->CI->router->method;
		$listauri = $this->CI->router->uri->rsegments;
		if(is_string($nome))
			$nome = array($nome);
		foreach ($nome as $key => $valor)
		{
			if(strcasecmp($class, $valor) == 0)
			{
				if(empty($acao))
					return ' class="active"';
				elseif(in_array($acao, $listauri))
				{
					return ' class="active"';
				}
			}
		}
		return $default;
	}
	################################################################################################################
	public function SetHardUpload()
	{
		$versao = self::$_Versao;
		$this->AddCSS("vendors/jquery-file-upload/css/jquery.fileupload-ui.css?versao={$versao}");
		$this->AddCSS("vendors/jquery-file-upload/css/jquery.fileupload.css?versao={$versao}");
		$this->AddCSS("vendors/slim/css/slim.min.css?versao={$versao}");
		$this->AddCSS("vendors/jquery-toastr/toastr.min.css?versao={$versao}");
		$this->AddJS("vendors/slim/js/slim.kickstart.min.js?versao={$versao}");
		$this->AddJS("vendors/jquery-toastr/toastr.min.js?versao={$versao}");
		$this->AddJS("vendors/jquery-file-upload/js/vendor/jquery.ui.widget.js?versao={$versao}");
		$this->AddJS("vendors/jquery-file-upload/js/jquery.iframe-transport.js?versao={$versao}");
		$this->AddJS("vendors/jquery-file-upload/js/jquery.fileupload.js?versao={$versao}");
		return true;
	}
	################################################################################################################
	public function GetView( $page, array $data = NULL)
	{
		$this->Start();
		$data['page'] = $page;
		$data['notificacoes'] = true;
		$this->CI->load->view( 'layout/layout', $data );
	}
	################################################################################################################
	public function GetDashboard()
	{
		if(self::$Dashboard == null )
			self::$Dashboard = __("Dashboard");
		return self::$Dashboard;
	}
	################################################################################################################
	public function AddDashboard($titulo = "")
	{
		self::$Dashboard = $titulo;
	}
}
