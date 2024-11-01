<?php
/*
Plugin Name: What's New Popup Generator
Plugin URI: https://global-s-h.com/whats_pop/en/
Description: This plugin will popup what's new section. You can make ten lines by your own and also adding links. What's new button can be created inside the admin page. The popup window and the button can change the style and color. 
Author: Kazuki Yanamoto
Version: 1.0.2
License: GPLv2 or later
Text Domain: whats-new-popup-generator
Domain Path: /languages/
*/

class Whatspopup
{
    public $textdomain = 'whats-new-popup-generator';
    public $plugins_url = '';

    public function __construct()
    {
        // プラグインが有効化された時
        if (function_exists('register_activation_hook')) {
            register_activation_hook(__FILE__, array($this, 'activationHook'));
        }
        //無効化
        if (function_exists('register_deactivation_hook')) {
            register_deactivation_hook(__FILE__, array($this, 'deactivationHook'));
        }
        //アンインストール
        if (function_exists('register_uninstall_hook')) {
            register_uninstall_hook(__FILE__, array($this, 'uninstallHook'));
        }

        //header()のフック (style/jQueryのリンク)
        	add_action('wp_head', array($this, 'filter_header'));
			add_action('wp_enqueue_scripts', array($this, 'popup_css_add'));

       //footer()のフッック
        add_filter('wp_footer', array($this, 'filter_footer'));

        //init
        add_action('init', array($this, 'init'));

        //ローカライズ
        add_action('init', array($this, 'load_textdomain'));

        //管理画面について
        add_action('admin_menu', array($this, 'popup_admin_menu'));

		//カラーピッカー
		add_action( 'admin_enqueue_scripts', array($this, 'admin_scripts'));
		
		//ショートコード
		add_shortcode('Pop_Whatsnew', array($this, 'pop_whatsnew_btn'));

    }


    /**
     * init
     */
     public function init()
     {
         $this->plugins_url = untrailingslashit(plugins_url('', __FILE__));
     }


    /***
     * ローカライズ
    ***/
    public function load_textdomain()
    {
        load_plugin_textdomain($this->textdomain, false, dirname(plugin_basename(__FILE__)) . '/languages/');
    }


    /**
     * プラグインが有効化された時
     *
     */
    public function activationHook()
    {
        //オプションを初期値

        //ボタン名
        if (! get_option('popup_plugin_value_subject')) {
            update_option('popup_plugin_value_subject', __('What`s New', $this->textdomain));
        }

        //ボタン横幅
        if (! get_option('popup_plugin_value_width')) {
            update_option('popup_plugin_value_width', '170');
        }

		//ボタン最大幅
        if (! get_option('popup_plugin_value_maxwidth')) {
            update_option('popup_plugin_value_maxwidth', false);
        }
 
        //ボタン パディング
        if (! get_option('popup_plugin_value_padding')) {
            update_option('popup_plugin_value_padding', '10');
        }

        //ボタン バック色
        if (! get_option('popup_plugin_value_btncolor')) {
            update_option('popup_plugin_value_btncolor', '#ffffff');
        }

        //ボタン 文字色
        if (! get_option('popup_plugin_value_namecolor')) {
            update_option('popup_plugin_value_namecolor', '#6f6e6e');
        }
        
         //ボタン タグ
        if (! get_option('popup_plugin_value_tag')) {
            update_option('popup_plugin_value_tag', '<a class="popup_information_box" href="pop_void">(Put img or text here)</a>');
        }

        //ボタン ショートコード
        if (! get_option('popup_plugin_value_shortcode')) {
            update_option('popup_plugin_value_shortcode', '[Pop_Whatsnew]');
        }

        //What`s バックの色
        if (! get_option('popup_plugin_value_whatscolor')) {
            update_option('popup_plugin_value_whatscolor', '#000000');
        }
        
        //What`s ターゲットリンク
        if (! get_option('popup_plugin_value_tag')) {
            update_option('popup_plugin_value_tag', false);
        }

    }


    /***
     * 無効化時に実行
    ***/
    public function deactivationHook()
    {
        delete_option('popup_plugin_value_subject');
        delete_option('popup_plugin_value_width');
		delete_option('popup_plugin_value_maxwidth');
        delete_option('popup_plugin_value_padding');
        delete_option('popup_plugin_value_btncolor');
		delete_option('popup_plugin_value_namecolor');
		delete_option('popup_plugin_value_whatscolor');
		delete_option('popup_plugin_value_tab');
		delete_option('popup_plugin_value_tag');

		for ($i = 1; $i <= 10; $i++){
			delete_option('popup_plugin_value_title'.$i, $popup_plugin_value_title[$i]);
			delete_option('popup_plugin_value_link'.$i, $popup_plugin_value_link[$i]);
			delete_option('popup_plugin_value_tab'.$i, $popup_plugin_value_tab[$i]);
		}
    }


    /***
     * アンインストール時
    ***/
    public function uninstallHook()
    {
        delete_option('popup_plugin_value_subject');
        delete_option('popup_plugin_value_width');
		delete_option('popup_plugin_value_maxwidth');
        delete_option('popup_plugin_value_padding');
        delete_option('popup_plugin_value_btncolor');
		delete_option('popup_plugin_value_namecolor');
		delete_option('popup_plugin_value_whatscolor');
		delete_option('popup_plugin_value_tab');
		delete_option('popup_plugin_value_tag');

		for ($i = 1; $i <= 10; $i++){
			delete_option('popup_plugin_value_title'.$i, $popup_plugin_value_title[$i]);
			delete_option('popup_plugin_value_link'.$i, $popup_plugin_value_link[$i]);
			delete_option('popup_plugin_value_tab'.$i, $popup_plugin_value_tab[$i]);
		}
    }


    /***
     * style/jQueryのリンク
    ***/
	public function popup_css_add(){
		wp_enqueue_script( 'jquery' );
		wp_enqueue_style( 'popup-link-css',plugins_url('/css/popup_style.css',__FILE__), array());
	}


    /***
     * カラーピッカー
    ***/
	public function admin_scripts( $hook ) {

	        //wpcolor-pickerの指定
	        wp_enqueue_style( 'wp-color-picker' );

	        //外部JSファイルの指定
	        wp_enqueue_script( 'colorpicker_script',plugins_url( '/js/pop_colorPicker.js', __FILE__ ),array( 'wp-color-picker' ), false, true );
		}


    /***
     * 管理画面
    ***/
    public function popup_admin_menu()
    {
        add_options_page(
            'Popup_generator', 
            __('What`s Popup setting', $this->textdomain), 'manage_options', 'Pop_up_Generator', array($this, 'popup_edit_setting'));
    }


    /***
     * 管理画面を表示
    ***/
    public function popup_edit_setting()
    {
        // Include the settings page
        include(sprintf("%s/manage/admin.php", dirname(__FILE__)));
    }


	/***
     * ショートコード
    ***/
	public function pop_whatsnew_btn() {
		
		echo '<div class="popup_information_box" style="cursor:pointer;border: solid #a4a4a4 1px; padding:';
			echo get_option('popup_plugin_value_padding');
		echo 'px; width:';

			if (get_option('popup_plugin_value_maxwidth') == true){
				echo '100%';
			}else{
				echo get_option('popup_plugin_value_width'); 
			}	

		echo 'px;text-align:center;color:';
			echo get_option('popup_plugin_value_namecolor'); 
		echo ';background-color:';
			echo get_option('popup_plugin_value_btncolor');
		echo ';">';
			echo get_option('popup_plugin_value_subject');
		echo '</div>';
	}
	
	
    /***
     * head部分にjquery
    ***/
	public function filter_header()
	{

		//リンクをvoidする
	?>
		<script type="text/javascript">
		jQuery(function($){
		    $('a[href="pop_void"]').click(function(){
		        return false;
		    })
		});
		</script>
		
		
		<?php // アラートバックのカラー ?>
		<script type="text/javascript">
			jQuery(function($){
				$('.popup_contents-overlay').css('background-color', '<?php echo esc_js(get_option('popup_plugin_value_whatscolor')); ?>');
			});
		</script>


		<script type="text/javascript">
			jQuery(function($){
				$('.popup_information_box').click(function(){	
					// ブラウザ全体を暗くする
					$('.popup_contents-overlay, .popup_information_whats').fadeIn();
				});
				
				$('.popup_contents-overlay,.popup_information_close').click(function(){	
					// ブラウザ全体を戻す
					$('.popup_contents-overlay, .popup_information_whats').fadeOut();
				});	
			});
		</script>
				
			<?php
	}


    /***
    * footerの処理
    ***/
    public function filter_footer()
    {
		echo '<div class="popup_contents-overlay"></div>';
		echo '<div class="popup_information_whats"></div>';


		echo '<!-- information -->
			<div class="popup_information_whats">
				<div class="popup_information_close"><p><a href="javascript:void(0);">Close</a></p></div>

				<div class="popup_information_word">
					<div class="popup_information_line">';
					    
						$i = 0;
						for ($i = 1; $i <= 10; $i++){

							if (get_option('popup_plugin_value_link'.$i)){
				            	echo '
				            	<a href="';
								echo get_option('popup_plugin_value_link'.$i);
							} 

								if (get_option('popup_plugin_value_link'.$i) && get_option('popup_plugin_value_tab'.$i)== true){
									echo '" target="_blank">';
								}else if(get_option('popup_plugin_value_link'.$i) && get_option('popup_plugin_value_tab'.$i)== false){
									echo '">';
								}
								echo get_option('popup_plugin_value_title'.$i);

							if (get_option('popup_plugin_value_link'.$i)){
								echo '</a>';
							}
							if (get_option('popup_plugin_value_title'.$i)){
								echo '<div class="popup_info_whats_line"></div>';
							}
						}
			echo '</div>
			</div>
		</div><!-- information -->';
    }
}
$Whatspopup = new Whatspopup();
