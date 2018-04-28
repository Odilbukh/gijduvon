<?php


do_send($_POST);
		
function do_send($data){

if(isset($data['email'])) {
     
    // EDIT THE 2 LINES BELOW AS REQUIRED
    $email_to = "gijduvinres@gmail.com";
    $email_subject = "Забронировать Стол";
    
	$error="";
    $chekindate = $data['chekindate']; // required
    $persons = $data['persons']; // required
    $first_name = $data['first_name']; // required
    $last_name = $data['last_name']; // required
    $email_from = $data['email']; // required
    $telephone = $data['telephone']; // not required
    $message = $data['message']; // not required
     
    $error_message = "";
    $email_exp = '/^[A-Za-z0-9._%-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$/';
  if(!preg_match($email_exp,$email_from)) {
    $error_message .= 'Введенный вами адрес электронной почты недействителен.<br />';
  }
    $string_exp = "/^[A-Za-z .'-]+$/";
  if(!preg_match($string_exp,$first_name)) {
    $error_message .= 'Имя, которое вы ввели, не является действительным.<br />';
  }
  if(!preg_match($string_exp,$last_name)) {
    $error_message .= 'Введенное вами Фамилия не является действительным.<br />';
  }
  if(strlen($chekindate) < 1) {
    $error_message .= 'Дата и время бронирования, которые вы указали, не являются действительными.<br />';
  }

  if(strlen($persons) < 1) {
    $error_message .= 'Введенная вами количество лий не представляется действительной.<br />';
  }
	

 if(strlen($telephone) < 3) {
    $error_message .= 'Введенный вами номер телефона не действителен.<br />';
  }

  	$ac_er=false;	
  

  if(strlen($error_message) > 0) {
	$valid="false"; 
	$msg=$error_message; 
	$return_json = '{"valid":"' . $valid . '","msg":"' . $msg . '"}';
	echo $return_json;
	
  } else {
    send_mail($email_to, $email_subject, $first_name, $last_name, $email_from, $chekindate, $persons, $telephone, $message);
	$valid="true"; 
	$msg="Message was send succesfully"; 
	$return_json = '{"valid":"' . $valid . '","msg":"' . $msg . '"}';
	echo $return_json;
  }

} 
} 

function clean_string($string) {
      $bad = array("content-type","bcc:","to:","cc:","href");
      return str_replace($bad,"",$string);
}
     
function send_mail($email_to, $email_subject, $first_name, $last_name, $email_from, $chekindate, $persons,  $telephone,  $message){
    $email_message = "Form details below.\n\n";
      
    $email_message .= "First Name: ".clean_string($first_name)."\n";
    $email_message .= "Last Name: ".clean_string($last_name)."\n";
    $email_message .= "Email: ".clean_string($email_from)."\n";
    $email_message .= "Telephone: ".clean_string($telephone)."\n";
    $email_message .= "Chekindate: ".clean_string($chekindate)."\n";
    $email_message .= "Persons: ".clean_string($persons)."\n";
	$email_message .= "Message: ".clean_string($message)."\n";
    

     
	// create email headers
	$headers = 'From: '.$email_from."\r\n".
	'Reply-To: '.$email_from."\r\n" .
	'X-Mailer: PHP/' . phpversion();
	@mail($email_to, $email_subject, $email_message, $headers); 
}




?>
 