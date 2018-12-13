<?php
/*
 * Add my new menu to the Admin Control Panel
 */

// Example
/*
function wp_first_shortcode(){
echo "Hello, This is your another shortcode!";
}
add_shortcode('first', 'wp_first_shortcode');

function form_creation(){
  ?>
  <form>
    First name: <input type="text" name="firstname"><br>
    Last name: <input type="text" name="lastname"><br>
   	Message: <textarea name="message"> Enter text here...</textarea>
 	</form>
 	<?php
 }
 add_shortcode('test', 'form_creation');
 */
 //Example - end

/* ---------------------------------------------------------------------------------------------------------------------*/
// Hook the 'admin_menu' action hook, run the function named 'mdp_Add_My_Admin_Link()'
    add_action( 'admin_menu', 'mcfp_ajax_fy_Add_My_Admin_Link' );
 
// Add a new top level menu link to the ACP
function mcfp_ajax_fy_Add_My_Admin_Link()
{
  // add_menu_page( $page_title, $menu_title, $capability, $menu_slug, $function = '', $icon_url = '', $position = null );
  add_menu_page(
        'My First Page', // Title of the page
        'Mytheme Contact Form Plugin - Ajax Froyo', // Text to show on the menu link
        'manage_options', // Capability requirement to see the link
        'includes/mcfp-ajax-fy-first-acp-page.php' // The 'slug' - file to display when clicking the link
    );
  // add_submenu_page( $parent_slug, $page_title, $menu_title, $capability, $menu_slug, $function = '' ); // demo
}


// error "has_cap was called with an argument… since version 2.0.0! ..." --> set $cabablity = "manage_options" --> done

function mcfp_ajax_fy_Add_My_Admin_Actions()
{
	//Add to Settings menu

	     // add_options_page( $page_title, $menu_title, $capability, $menu_slug, $function = '' );
	// add_options_page("Mytheme Contact Form Plugin Options", "Mytheme Contact Form Plugin", "manage_options", "Mytheme Contact Form Plugin", "mcptp_plugin_options");


       // or/and Add to Tools menu
  // add_management_page("Mytheme CPT Plugin Options", "Mytheme CPT Plugin", "manage_options", "Mytheme CPT Plugin", "mcptp_plugin_options");


}
// add_action('admin_menu', 'mcfp_Add_My_Admin_Actions');

function mcfp_ajax_fy_plugin_options() {
  // User Interface

}


function html_form_code_ajax_fy() 
{
?>
  <div id="respond">
  <!--   <php
      echo $response; 
    ?> -->
    <form name="ContactForm_" id="email-form" action="<?php the_permalink(); ?>" method="post">
      <div id="ajax-response"></div>
      <p>Các vùng có dấu (*) là bắt buộc, không được để trống.</p><br>
      <p><label id="name-label" for="cf-name" class="info">Name: <span>*</span> <br><input type="text" name="cf-name" value="Ví dụ: Nguyễn Văn A" id="_name"></label></p>
      <p><label id="email-label" for="cf-email" class="info">Email: <span>*</span> <br><input type="text" name="cf-email" id="_email"></label></p>
      <p><label id="message-label" for="cf-message" class="info">Message: <span>*</span> <br><textarea type="text" name="cf-message" id="_message"></textarea></label></p>
      <!-- <p><label for="message_human">Human Verification: <span>*</span> <br><input type="text" style="width: 60px;" name="message_human"> + 3 = 5</label></p> -->
      <!-- <input type="hidden" name="cf-submitted" value="1"> -->
      <!-- <p><input type="submit" id="_submit"></p> -->
    </form>

      <style>
        #respond {width: 60%; margin: 0 auto;}
        #name-label, #email-label, #message-label {font-size: 1.5rem;}
      </style>

    <div class="message_box" style="margin:10px 0px;">
  </div>

  <script>
      // jQuery(document).ready(function() {

      //     jQuery('#email-form').on('submit', function(e) {
      //         e.preventDefault();



      //         jQuery.ajax({
      //             type: jQuery(this).attr('method'),
      //             url: jQuery(this).attr('action'),
      //             data: jQuery(this).serialize(),
      //             success: function(data) {
      //                 jQuery('#ajax-response').html(data); 
      //             }
      //         });

      //     });

      // });
  </script>

  <script>
    jQuery(document).ready(function() {

       var name = jQuery('#_name').val();
       var email = jQuery('#_email').val();
       var message = jQuery('#_message').val();

       var delay = 2000;

       jQuery('#email-form').on('submit', function(e) {
          e.preventDefault();

          if(name == ''){
            jQuery('#_name').html("(required)");
            jQuery('.message_box').html('<span style="color:red;">We want to know your name!</span>');
            jQuery('#_name').focus();
            return false;
          }

          if(email == ''){
            jQuery('#_email').html("(required)");
            jQuery('.message_box').html('<span style="color:red;">We want to know your email!</span>');
            jQuery('#_email').focus();
            return false;
          }
          if( jQuery("#_email").val()!='' ){
            if( !isValidEmailAddress( jQuery("#_email").val() ) ){
              jQuery('.message_box').html(
              '<span style="color:red;">Provided email address is incorrect!</span>'
              );
              jQuery('#_email').focus();
              return false;
            }
          }

          if(message == ''){
            jQuery('#_message').html("(required)");
            jQuery('.message_box').html('<span style="color:red;">You forget to leave a message!</span>');
            jQuery('#_message').focus();
            return false;
          }

          jQuery.ajax({
            type: "POST",
            url: "deliver_mail_ajax.php",
            data: "name="+name+"&email="+email+"&message="+message, 
            beforeSend: function() {
               // jQuery('.message_box').html(
               // '<img src="Loader.gif" width="25" height="25"/>'
               // );
             },
            success: function(data) {
              setTimeout(function() {
                 jQuery('.message_box').html(data);
                 }, delay);
             }
            },
            error: function() {}
          // });
        });
     });

        //Email Validation Function 
        function isValidEmailAddress(emailAddress) {
            var pattern = /^([a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+(\.[a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+)*|"((([ \t]*\r\n)?[ \t]+)?([\x01-\x08\x0b\x0c\x0e-\x1f\x7f\x21\x23-\x5b\x5d-\x7e\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|\\[\x01-\x09\x0b\x0c\x0d-\x7f\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))*(([ \t]*\r\n)?[ \t]+)?")@(([a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.)+([a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.?$/i;
            // var pattern2 = /^(([^<>()\[\]\.,;:\s@\"]+(\.[^<>()\[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})$/i;
            return pattern.test(emailAddress);
        };
  </script>

<?php
}

// Main function
function cf_shortcode_ajax_fy() {
    ob_start();
    // validate_dn();
    html_form_code_ajax_fy();

    return ob_get_clean();
}
add_shortcode( 'sitepoint_contact_form_ajax_fy', 'cf_shortcode_ajax_fy' );




// [sitepoint_contact_form_ajax_fy]

 // Reduce the likelihood of  your messages being flagged as spam.
// add_action( 'init', 'fix_my_email_return_path' );
// function fix_my_email_return_path( $phpmailer ) {
//     $phpmailer->Sender = $phpmailer->From;
// }


// ----------------------------------

