<?php

/***
 * 管理画面
***/

?>

<div class="wrap"><br/>
	<h1>What`s New Popup Generator <font size="2">v1.0.2</font></h1>

<?php
	 /***
	   *Saveされた時の処理
	 ***/

 	 $popup_save = $_POST['popup_save'];
     $popup_save = wp_kses($popup_save, array());
		
		if ( isset( $popup_save )){

		   //nonceチェック
	       if ( isset( $_POST['_wpnonce'] ) && $_POST['_wpnonce'] ) {
	            if ( check_admin_referer( 'WPpopup_plugin', '_wpnonce' ) ) {

		        	//POST取得(btn)

			        $popup_plugin_value_subject = $_POST['popup_plugin_value_subject'];
			        $popup_plugin_value_subject = wp_kses($popup_plugin_value_subject, array());

			        $popup_plugin_value_width = $_POST['popup_plugin_value_width'];
					$popup_plugin_value_width = (int) $popup_plugin_value_width;
			        $popup_plugin_value_width = wp_kses($popup_plugin_value_width, array());

			        $popup_plugin_value_maxwidth = $_POST['popup_plugin_value_maxwidth'];
			        $popup_plugin_value_maxwidth = wp_kses($popup_plugin_value_maxwidth, array());

			        $popup_plugin_value_padding = $_POST['popup_plugin_value_padding'];
					$popup_plugin_value_padding = (int) $popup_plugin_value_padding;
			        $popup_plugin_value_padding = wp_kses($popup_plugin_value_padding, array());

			        $popup_plugin_value_btncolor = $_POST['popup_plugin_value_btncolor'];
			        $popup_plugin_value_btncolor = wp_kses($popup_plugin_value_btncolor, array());

			        $popup_plugin_value_namecolor = $_POST['popup_plugin_value_namecolor'];
			        $popup_plugin_value_namecolor = wp_kses($popup_plugin_value_namecolor, array());

			        $popup_plugin_value_whatscolor = $_POST['popup_plugin_value_whatscolor'];
			        $popup_plugin_value_whatscolor = wp_kses($popup_plugin_value_whatscolor, array());


					//POST取得(information)

					for ($i = 1; $i <= 10; $i++){

						$post_title = array();
						$post_title[$i] = $_POST['popup_plugin_value_title'.$i];
				        $popup_plugin_value_title[$i] = wp_kses($post_title[$i], array());

						$post_link[$i] = $_POST['popup_plugin_value_link'.$i];
				        $popup_plugin_value_link[$i] = wp_kses($post_link[$i], array());

						$popup_tab[$i] = $_POST['popup_plugin_value_tab'.$i];
				        $popup_plugin_value_tab[$i] = wp_kses($popup_tab[$i], array());
					}


					//データベース登録
					update_option('popup_plugin_value_subject', $popup_plugin_value_subject);
					update_option('popup_plugin_value_width', $popup_plugin_value_width);
					update_option('popup_plugin_value_maxwidth', $popup_plugin_value_maxwidth);
					update_option('popup_plugin_value_padding', $popup_plugin_value_padding);
					update_option('popup_plugin_value_btncolor', $popup_plugin_value_btncolor);
					update_option('popup_plugin_value_namecolor', $popup_plugin_value_namecolor);
					update_option('popup_plugin_value_whatscolor', $popup_plugin_value_whatscolor);

					//データベース登録(information)
					for ($i = 1; $i <= 10; $i++){
						update_option('popup_plugin_value_title'.$i, $popup_plugin_value_title[$i]);
						update_option('popup_plugin_value_link'.$i, $popup_plugin_value_link[$i]);
						update_option('popup_plugin_value_tab'.$i, $popup_plugin_value_tab[$i]);
					}
				
				}
			}
		}


	/***
	 * データを取得
	***/
	//登録データ
	$popup_plugin_value_subject = get_option('popup_plugin_value_subject');
	$popup_plugin_value_width = get_option('popup_plugin_value_width');
	$popup_plugin_value_maxwidth = get_option('popup_plugin_value_maxwidth');
	$popup_plugin_value_padding = get_option('popup_plugin_value_padding');
	$popup_plugin_value_btncolor = get_option('popup_plugin_value_btncolor');
	$popup_plugin_value_namecolor = get_option('popup_plugin_value_namecolor');
	$popup_plugin_value_whatscolor = get_option('popup_plugin_value_whatscolor');
	$popup_plugin_value_tag = get_option('popup_plugin_value_tag');
	$popup_plugin_value_shortcode = get_option('popup_plugin_value_shortcode');

	//登録データ(information)
	for ($i = 1; $i <= 10; $i++){
		$popup_plugin_value_title[$i] = get_option('popup_plugin_value_title'.$i);
		$popup_plugin_value_link[$i] = get_option('popup_plugin_value_link'.$i);
		$popup_plugin_value_tab[$i] = get_option('popup_plugin_value_tab'.$i);
	}

?>

	<form method="post" id="popupion_copy_form" action="">
		<?php wp_nonce_field( 'WPpopup_plugin', '_wpnonce' ); ?>

		<fieldset class="options">
		<table class="form-table">		

			<tr valign="top"> 
				<td width="10%">
					<?php _e('Button Name', $this->textdomain );?>:<br><input name="popup_plugin_value_subject" type="text" value="<?php echo _e(esc_attr($popup_plugin_value_subject));?>" size="30"/>
				</td>


				<td>
					<?php _e('Button Preview', $this->textdomain );?>:
					<div style="font-family: helvetica, arial, 'hiragino kaku gothic pro', meiryo, 'ms pgothic', sans-serif; !important;
								font-size:15px !important;
								border: solid #a4a4a4 1px;
								padding:<?php echo $popup_plugin_value_padding; ?>px;
									width:<?php if ($popup_plugin_value_maxwidth == true){
											echo '100%';
												}else{
													echo $popup_plugin_value_width; 
												}?>px;
									text-align:center;
									color:<?php echo $popup_plugin_value_namecolor; ?>;
									background-color:<?php echo $popup_plugin_value_btncolor; ?>;">
												<?php echo $popup_plugin_value_subject; ?>
					</div>
				</td>
			</tr>


			<tr valign="top"> 
				<td width="10%">
					<?php _e('Width', $this->textdomain );?>:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(Make it 100%&nbsp;<input type="checkbox" name="popup_plugin_value_maxwidth" value="<?php echo esc_attr(popup_plugin_value_maxwidth); ?>" <?php if($popup_plugin_value_maxwidth == true) { echo('checked="checked"'); } ?> >)
					<input name="popup_plugin_value_width" type="text" value="<?php echo _e(esc_attr($popup_plugin_value_width));?>" size="30"/>
				</td>


				<td>	
					<?php _e('Padding (inside space)', $this->textdomain );?>:<br><input name="popup_plugin_value_padding" type="text" value="<?php echo _e(esc_attr($popup_plugin_value_padding));?>" size="30">
				</td>
			</tr>


			<tr valign="top"> 
				<td width="10%">
					<?php _e('Button Color', $this->textdomain );?>:<br><input type="text" name="popup_plugin_value_btncolor" value="<?php echo esc_attr($popup_plugin_value_btncolor); ?>" class="PopupColorPicker" >
				</td>


				<td>
					<?php _e('Button Name Color', $this->textdomain );?>:<br><input type="text" name="popup_plugin_value_namecolor" value="<?php echo esc_attr($popup_plugin_value_namecolor); ?>" class="PopupColorPicker" >
				</td>
			</tr>


			<tr valign="top"> 
				<td width="10%">
					<?php _e('Copy short code to put button', $this->textdomain );?>:<br><input name="popup_plugin_value_shortcode" type="text" value="<?php echo _e(esc_attr($popup_plugin_value_shortcode));?>" size="30">
				</td>


				<td>
					<?php _e('Copy link tag for your own btn', $this->textdomain );?>:<br><input name="popup_plugin_value_tag" type="text" value="<?php echo _e(esc_attr($popup_plugin_value_tag));?>" size="30">
				</td>
			</tr>


			<tr>
			    <td width="10%"><?php _e('Save this setting', $this->textdomain );?> :
					<input type="submit" name="popup_save" value="<?php _e(esc_attr('Save', $this->textdomain )); ?>">
				</td> 

				<td></td> 
		    </tr>


			<tr><td colspan="2"><hr></td></tr>


			<tr valign="top"> 
				<td width="10%">
					<?php _e('What`s new back color', $this->textdomain );?>:<br><input type="text" name="popup_plugin_value_whatscolor" value="<?php echo esc_attr($popup_plugin_value_whatscolor); ?>" class="PopupColorPicker" >
				</td>
			</tr>


			<?php $i=0; ?>
			<?php for ($i = 1; $i <= 10; $i++){;?>

				<tr valign="top"> 
						<td colspan="2">

							<?php _e('Title '.$i, $this->textdomain );?>:<br><input name="popup_plugin_value_title<?php echo $i; ?>" type="text" value="<?php echo _e(esc_attr($popup_plugin_value_title[$i]));?>" size="70"><br>
							<?php _e('(optional) Link for Title ' .$i, $this->textdomain );?>:<br>
							<input name="popup_plugin_value_link<?php echo $i; ?>" type="text" value="<?php echo _e(esc_attr($popup_plugin_value_link[$i]));?>" size="70" placeholder="http://">
							<br>
							(Open with different tab&nbsp;<input type="checkbox" name="popup_plugin_value_tab<?php echo $i; ?>" value="<?php echo esc_attr(popup_plugin_value_tab.$i); ?>" <?php if($popup_plugin_value_tab[$i] == true) { echo('checked="checked"'); } ?> >)<br>
						</td>
				</tr>


			<?php }; ?>


			<tr>
			    <td width="10%"><?php _e('Save this setting', $this->textdomain );?> :
					<input type="submit" name="popup_Copy_save" value="<?php _e(esc_attr('Save', $this->textdomain )); ?>" ></td> 

				<td></td> 
		    </tr>


		</table>
		</fieldset>
	</form>
	</table>

<br />
<br />

<?php _e('Please see the explanation of this plugin from here!', $this->textdomain );?>
<br />
<a href="https://global-s-h.com/wp_popup/en/" target="_blank">https://global-s-h.com/wp_popup/</a>

| <a href="https://global-s-h.com/wp_popup/en/" target="_blank"> <?php _e('Help page for troubles', $this->textdomain );?> </a> | <a href="https://global-s-h.com/wp_popup/en/index.php#donate" target="_blank"> <?php _e('Donate', $this->textdomain );?> </a> | 
<br /><br />
<iframe src="//www.facebook.com/plugins/likebox.php?href=https%3A%2F%2Fwww.facebook.com%2Fwebshakehands&amp;width=285&amp;height=65&amp;show_faces=false&amp;colorscheme=light&amp;stream=false&amp;show_border=false&amp;header=false&amp;" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:305px; height:65px;" allowTransparency="true"></iframe>

</div>
</body>