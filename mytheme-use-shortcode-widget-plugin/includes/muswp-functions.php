<?php

// Enable PHP in widgets
add_filter('widget_text','allow_use_shortcode_or_php_in_widget',100);

function allow_use_shortcode_or_php_in_widget($html)
{
	 if(strpos($html,"<"."?php")!==false){
          ob_start();
          eval("?".">".$html);
          $html=ob_get_contents();
          ob_end_clean();
     }
     return $html;
}
add_action( 'init', 'allow_use_shortcode_or_php_in_widget' ); // important to activate plugin


// Enable shortcodes in widgets
add_filter('widget_text', 'do_shortcode');