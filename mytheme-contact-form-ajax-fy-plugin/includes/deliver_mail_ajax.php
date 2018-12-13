 <?php

 //response messages
    // $not_human       = "Human verification incorrect.";
    $missing_content = "Please supply all information.";
    $email_invalid   = "Email Address Invalid.";
    // $message_unsent  = "Message was not sent. Try Again.";
    // $message_sent    = "Thanks! Your message has been sent."; 
    // $message_sent    = "Thanks for contacting me, expect a response soon.";
     
    //user posted variables

    // $human = $_POST['message_human'];


    $response = "";

    //function to generate response
    function my_contact_form_generate_response($type, $reminder){

        global $response;

        if($type == "success") $response = "<div class='success'>{".$reminder."}</div>";
        else $response = "<div class='error'>{".$reminder."}</div>";

    }

      // sanitize form values
   

    // get the blog administrator's email address
    $to = get_option( 'admin_email' ); // good with Yahoo mail

    if(!isset($_POST['cf-name']) || !isset($_POST['cf-email'])) {}
    else
    {
      if(isset($_POST['cf-name']) && isset($_POST['cf-email'])) { 
        $name    = sanitize_text_field( $_POST['cf-name'] );
        $email    = sanitize_text_field( $_POST['cf-email'] ); 

        $headers = "";
        // Always set content-type when sending HTML email
        // $headers .= "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        // $headers = "From: $name <$email>" . "\r\n";
        $headers .= "From: ".$name." <".$email."> \r\n";

        if(!isset($_POST['cf-message'])) {/* skip */}
          else
          {
            if(isset($_POST['cf-message'])) { $message    = sanitize_text_field( $_POST['cf-message'] ); }
          }
        }
    }

    // if(!isset($_POST['cf-subject'])) {/* skip */}
    // else
    // {
    //   if(isset($_POST['cf-subject'])) { $subject    = sanitize_text_field( $_POST['cf-subject'] ); }
    // }

  // if(isset( $_POST['cf-submitted'])){

    if(!isset($_POST['cf-email'])) {}
    else
    {
      if(isset($_POST['cf-email'])) { 
          $email    = sanitize_text_field( $_POST['cf-email'] );
          //validate email
          if(!filter_var($email, FILTER_VALIDATE_EMAIL))
            my_contact_form_generate_response("error", $email_invalid);
          else //email is valid
          {
            //validate presence of name and message
              if(empty($name) || empty($message)){
                  my_contact_form_generate_response("error", $missing_content);
                  echo '<p style="margin: 0 auto; width: 60%;">lack of input</p>';
              }
              else
              {            
                  $subject = "Someone sent a message from ".get_bloginfo('name');

                 //send email
                  $all_content = 'Sent from: ['.$name.'] < '.$email.' >'."\n\n";
                  $all_content .= 'Message: '."\n".$message."\n\n";
                  $all_content .= '---'."\n";
                  $all_content .= 'Contact Form of website: '.get_bloginfo('wpurl');
                  // $all_content .= "";
                     // If email has been process for sending, display a success message
                  // if ( wp_mail( $to, $subject, $message, $headers ) ) {
                  if ( wp_mail( $to, $subject, $all_content, $headers ) ) { // if send successfully
                      echo '<div>';
                      echo '<span id="thank">Thanks for contacting me, we will give a response soon.</p>';
                      echo '</div>';

                      echo '<style>';
                      echo 'span#thank{margin: 0 auto; width: 60%;}';
                      echo '</style>';

                  } else {
                      echo '<div class="container">';
                      echo '<span id="execuse" style="color:red; font-weight: bold;">An unexpected error occurred</span>';
                      echo '</div>';
                  }
              } 
              // end SEND  
          }
      }
    }