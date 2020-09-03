<?php 
/*
* Plugin Name: Add Form Page Plugin
* Author: Fırat DEDE
* Description: This plugin adds a register form  to a page where admin or editor wants to add register form. The user just writes [fd_add_register_form] shortcode to add this form. 
* License:     GPL2
*/
?>
<head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>

<?php
register_activation_hook( __FILE__, "fd_after_activating_add_form_page" );


function fd_after_activating_add_form_page(){
  add_option( "fd_add_form_page_min_username_length",5 );
  add_option( "fd_add_form_page_max_username_length",12 );
  add_option( "fd_add_form_page_min_password_length",6 );
  add_option( "fd_add_form_page_max_password_length",12 );

}
add_action( "admin_menu", "fd_add_register_form_page", 10,1 );

function fd_add_register_form_page($context){
  add_menu_page( "Register Form Settings", "Register Form Settings", "edit_pages", "register-form-settings", "fd_content_of_register_form_settings");

}

function fd_content_of_register_form_settings(){

  $min_username_length=get_option( "fd_add_form_page_min_username_length",5);
  $max_username_length=get_option( "fd_add_form_page_max_username_length",12);
  $min_password_length=get_option( "fd_add_form_page_min_password_length",6 );
  $max_password_length=get_option( "fd_add_form_page_max_password_length",12 );
  if(isset($_POST["fd_register_form_submission"])){
    if(intval($_POST["fd_min_username_length"])<=intval($_POST["fd_max_username_length"]) &&
         intval($_POST["fd_min_password_length"])<= intval($_POST["fd_max_password_length"])
      )
    {
      update_option( "fd_add_form_page_min_username_length", intval($_POST["fd_min_username_length"]), true);
      update_option( "fd_add_form_page_max_username_length", intval($_POST["fd_max_username_length"]), true);
      update_option( "fd_add_form_page_min_password_length", intval($_POST["fd_min_password_length"]), true);
      update_option( "fd_add_form_page_max_password_length", intval($_POST["fd_max_password_length"]), true);

      $min_username_length=get_option( "fd_add_form_page_min_username_length",5);
      $max_username_length=get_option( "fd_add_form_page_max_username_length",12);
      $min_password_length=get_option( "fd_add_form_page_min_password_length",6 );
      $max_password_length=get_option( "fd_add_form_page_max_password_length",12 );
     ?>
      <script>
      jQuery(document).ready(function($){
        var error_description=document.getElementById("error_description");
        
        error_description.style.border="1px solid #ccd0d4";
        error_description.style.backgroundColor="white";
        error_description.style.fontSize="13px";
        error_description.style.margin="5px 0 15px";
        error_description.style.height="50px";
        error_description.style.borderLeftColor ="#46b450";
        error_description.style.borderLeftWidth="5px";
        error_description.innerHTML+="<p><strong >Update successfull</strong></p>";
        error_description.firstChild.style.margin="1em";


      })
      </script> 
      <?php
    }
    else {
       if(intval($_POST["fd_min_username_length"])>intval($_POST["fd_max_username_length"]))
       {
       ?>
       <script>
      jQuery(document).ready(function($){
        var error_description=document.getElementById("error_description");
        
        error_description.style.border="1px solid #ccd0d4";
        error_description.style.backgroundColor="white";
        error_description.style.fontSize="13px";
        error_description.style.margin="5px 0 15px";
        error_description.style.borderLeftColor ="red";
        error_description.style.borderLeftWidth="5px";
        error_description.innerHTML+="<p><strong >Error: Min Username Length cannot be bigger than Max Username Length</strong></p>";
        error_description.lastChild.style.margin="1em";


      })
      </script> 

       
       <?php
       }
       if( intval($_POST["fd_min_password_length"])> intval($_POST["fd_max_password_length"])){

        ?>
         <script>
      jQuery(document).ready(function($){
        var error_description=document.getElementById("error_description");
        
        error_description.style.border="1px solid #ccd0d4";
        error_description.style.backgroundColor="white";
        error_description.style.fontSize="13px";
        error_description.style.margin="5px 0 15px";
        error_description.style.borderLeftColor ="red";
        error_description.style.borderLeftWidth="5px";
        error_description.innerHTML+="<p><strong >Error: Min Password Length cannot be bigger than Max Password Length</strong></p>";
        error_description.lastChild.style.margin="1em";


      })
      </script>

        <?php
       }

    }
  }
  
  
  ?> 
  
  <style> 
  #fd_register_form_description {
    font-size: 16px;
    margin: 1em 4px;
  }
  #header_of_register_form_settings{
    margin: 1em 4px;
  }
  form table{
    border-collapse: separate;
    border-spacing:8px 20px;
  }
  form table td {
    padding: 15px 15px 0px 0px;
  } 
  #fd_register_form_submission{
    margin-left: 6px;
  }


  </style>
  <div id="error_description"></div>
  <h1 class="wp-heading-inline" id="header_of_register_form_settings">Register Form Settings</h2>
  <div class='wrap description' ><p id="fd_register_form_description"> This page allows you to change register form's settings.
    Note= You can add this form just writing [fd_add_register_form] to where you want to add. </p>  </div>
    <form method="POST" action="">
    <table  >
    <tr> <td class="first-coloumns">Min Username Length</td> <td class="second-coloumns">  
    <select id="fd_min_username_length" name="fd_min_username_length">
    <?php 
       for($i=5; $i<16; $i++) {
    ?>  
       <option <?php if ($min_username_length==$i) echo "selected"; ?>   value= "<?php  echo $i;  ?> " > <?php  echo $i;  ?> </option>
       <?php }
       ?>
    </select> 
    </td> </tr>
    <tr> <td class="first-coloumns">Max Username Length</td> <td class="second-coloumns"> 
    <select id="fd_max_username_length" name="fd_max_username_length">
    <?php 
       for($i=5; $i<16; $i++) {
    ?>  
       <option <?php if ($max_username_length==$i) echo "selected"; ?>   value= "<?php  echo $i;  ?> " > <?php  echo $i;  ?> </option>
       <?php }
       ?>
    </select> 
    </td> </tr>
    <tr> <td class="first-coloumns">Min Password Length</td> <td class="second-coloumns">
    <select id="fd_min_password_length" name="fd_min_password_length">
    <?php 
       for($i=5; $i<16; $i++) {
    ?>  
       <option <?php if ($min_password_length==$i) echo "selected"; ?>   value= "<?php  echo $i;  ?> " > <?php  echo $i;  ?> </option>
       <?php }
       ?>
    </select> 
    </td> </tr>
    <tr> <td class="first-coloumns">Max Password Length</td> <td class="second-coloumns">
    <select id="fd_max_password_length" name="fd_max_password_length">
    <?php 
       for($i=5; $i<16; $i++) {
    ?>  
       <option <?php if ($max_password_length==$i) echo "selected"; ?>   value= "<?php  echo $i;  ?> " > <?php  echo $i;  ?> </option>
       <?php }
       ?>
    </select> 
    </td> </tr>


    </table> <br>
    <input type="submit" class="button button-primary" name="fd_register_form_submission" id="fd_register_form_submission" value="Update" >
</form>
  <?php
}

function afp_register_auto_login(){
  if(is_user_logged_in()&&!in_array("administrator",wp_get_current_user()->roles))
  {
    return;
     
    ?>
     
    <?php
  }
  
  $user_name=$password=$confirm_password=$email="";
  if(isset($_POST["afp_sign_up"])){ 
    $user_name=sanitize_user( $_POST["afp_username"] );
    $password=fd_filter_password($_POST["afp_password"]);
    $confirm_password=fd_filter_password($_POST["afp_confirm_password"]);
    $email=sanitize_email($_POST["afp_email"]);
    $check_user_name=$check_password=$check_confirm_password=$check_email=true;
    
    
    if(strlen($user_name)<get_option( "fd_add_form_page_min_username_length",5)){
      $check_user_name=false;
     
      ?>
      <script> 
      $(document).ready(function(){
        
      document.getElementById('afp_username_required').innerHTML='At a least <?php echo get_option( "fd_add_form_page_min_username_length",5); ?> characters required ';
      document.getElementById('afp_username_required').style.color='red';

      })
      
      
      </script>
      <?php
    }
   else if (!preg_match("/^[a-zA-Z0-9 ]*$/",$user_name)){
    $check_user_name=false;
          ?>
        <script> 
      $(document).ready(function(){
        
      document.getElementById('afp_username_required').innerHTML="Only letters  white space and numbers allowed";
      document.getElementById('afp_username_required').style.color='red';

      })
      
      
      </script>



          <?php
    }
    else if(get_user_by( "login", $user_name)!=false){
      $check_user_name=false;
      echo " <script> 
      $(document).ready(function(){
      document.getElementById('afp_username_required').innerHTML='User already exists';
      document.getElementById('afp_username_required').style.color='red';

      })
      
      
      </script>";

    }
    else if(strlen($user_name)>get_option( "fd_add_form_page_max_username_length",12)){
      $max_username_length=get_option( "fd_add_form_page_max_username_length",12);
      $check_user_name=false;
      echo " <script> 
      $(document).ready(function(){
        
      document.getElementById('afp_username_required').innerHTML='At most $max_username_length characters allowed';
      document.getElementById('afp_username_required').style.color='red';

      })
      
      
      </script>";

      

    }
    
    if(strlen($password)< get_option( "fd_add_form_page_min_password_length",6 )){
      $min_password_length=get_option( "fd_add_form_page_min_password_length",6 );
      $check_password=false;
      echo " <script> 
      $(document).ready(function(){
      
      document.getElementById('afp_password_required').innerHTML='At a least $min_password_length characters required';
      document.getElementById('afp_password_required').style.color='red';

      })
      
      
      </script>";

    }
    else if (!preg_match("/^[a-zA-Z0-9 ]*$/",$password)){
      $check_password=false;
      echo " <script> 
      $(document).ready(function(){
      
      document.getElementById('afp_password_required').innerHTML='Only letters  white spaces and numbers allowed';
      document.getElementById('afp_password_required').style.color='red';

      })
      
      
      </script>";


    }
    else if(strlen($password)>get_option( "fd_add_form_page_max_password_length",12 )){
      $check_password=false;
      $max_password_length=get_option( "fd_add_form_page_max_password_length",12 );
      echo " <script> 
      $(document).ready(function(){
      
      document.getElementById('afp_password_required').innerHTML='At most $max_password_length characters allowed';
      document.getElementById('afp_password_required').style.color='red';

      })
      
      
      </script>";

    }
    if($password!=$confirm_password){
      $check_confirm_password=false;
      echo " <script> 
      $(document).ready(function(){
      
      document.getElementById('afp_confirm_password_required').innerHTML='Passwords are not matched';
      document.getElementById('afp_confirm_password_required').style.color='red';

      })
      
      
      </script>";
      
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $check_email=false;
      echo " <script> 
      $(document).ready(function(){
      
      document.getElementById('afp_email_required').innerHTML='Invalid email format';
      document.getElementById('afp_email_required').style.color='red';

      })
      
      
      </script>";
    }
    else if(get_user_by("email",$email)!=false){
      $check_email=false;
      echo " <script> 
      $(document).ready(function(){
      
      document.getElementById('afp_email_required').innerHTML='Email already used';
      document.getElementById('afp_email_required').style.color='red';

      })
      
      
      </script>";


    }
    if($check_user_name&&$check_password&&$check_confirm_password&&$check_email){
       wp_create_user($user_name,$password , $email );
       wp_set_current_user( null, $user_name );
       wp_signon( array("user_login"=>$user_name,"user_password"=> $password,"remember"=>true),'' );
       wp_redirect( home_url());
        exit;
       
    }

     }
     ?>
     <?php
}
 

 add_action("init","afp_register_auto_login",10,0); 
 
 

 function fd_filter_password($p){
   
    $p = trim($p);
    $p = stripslashes($p);
    $p = htmlspecialchars($p);
    return $p;
   
   
    
 }

 add_shortcode( "fd_add_register_form", "fd_add_form_page_to_a_page" );
 
 function fd_add_form_page_to_a_page(){
   global $post;
   if(is_user_logged_in()&&!in_array("administrator",wp_get_current_user()->roles))
   {
    ?>
    <script>
    window.location="<?php echo home_url();  ?>";
    
     </script>
    <?php

    return;

   }
   
 
  
  
    $name=$email="";
    
    if(isset($_POST["afp_sign_up"]))
    {
     $name=sanitize_user($_POST["afp_username"]);
     $email=sanitize_email($_POST["afp_email"]);
    }

  ?>
 
  <style>
   .afp_form{
      font-size: 24px;
    }
    #afp_password{
      
      
      
    }
    #afp_username{
      
     

    }
    .afp_span_element{
      font-size: 18px;
      float: right;
      
      
      
    }
    label{
      display: inline-block;
    }
   
    </style>
    
         
    <form method='post' action='' >
    <label for='afp_username' class='afp_form'> Username: <br>   </label> 
    <input type='text' name='afp_username' id='afp_username'      
     value="<?php echo $name; ?>"
     
     
     />   <span id="afp_username_required" class='afp_span_element'>*required</span>          <br>
    <label for='afp_password' class='afp_form' > Password: <br>  </label> 
    <input type='password' name='afp_password'id='afp_password' 
     value=""
    />  <span id="afp_password_required" class='afp_span_element'>*required</span> 
    <label for='afp_confirm_password' class='afp_form'>  Confirm Password: </label> <br>
    <input type='password' id='afp_confirm_password' name='afp_confirm_password'  
     value=""
    /> <span id="afp_confirm_password_required" class='afp_span_element'>*required</span> 
    <label for='afp_email' class='afp_form'> E-mail: <br> </label>
    <input type='text' name='afp_email' id='afp_email' 
     value="<?php echo $email;?> "
     
     /> <span id="afp_email_required" class='afp_span_element'>*required</span>  <br>
    <input type='submit' name='afp_sign_up' value='Sign Up' >
    
    </form>
     <?php
  } 
    
  add_action( "init", "fd_hide_pages", 10,0);

  function fd_hide_pages(){
    if(is_user_logged_in()&&!in_array("administrator",wp_get_current_user()->roles)){ 
      $pages=get_pages(  );
      foreach($pages as $page){
        if(has_shortcode( $page->post_content, "fd_add_register_form" )){
          ?>
           <script>
           jQuery(document).ready(function($){
           
           $(".page-item-<?php echo $page->ID; ?>").remove();
           })
           </script>
          <?php
        }
      }
    } 



  }

  register_deactivation_hook( __FILE__,"fd_after_deactivating_add_form_page" );

  function fd_after_deactivating_add_form_page()
  {
    delete_option( "fd_add_form_page_min_username_length" );
    delete_option( "fd_add_form_page_max_username_length" );
    delete_option( "fd_add_form_page_min_password_length");
    delete_option( "fd_add_form_page_max_password_length" );
  }

