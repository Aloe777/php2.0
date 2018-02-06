<?

if ($_POST['login_f'])
{

    email_valid();
	password_valid();
    
    $user = R::findOne("users", "email=?", [$_POST["email"]]);
if (!$user) {
    message('Аккаунт с таким E-mail адресом не найден ');
}
if ($user->password !== $_POST["password"]) {
    message('Не правильно введен пароль ');
}

 $user =  R::getRow('SELECT id FROM users WHERE email = ? ',array
    ($_POST['email'] ));

foreach ($user as $key => $value) 
    $_SESSION[$key] = $value;

 
    
 go('profile');
 
  }



else if ($_POST['register_f']) {
  email_valid();
  name_valid();    
  password_valid();
  password2_valid();
  same_pass ();

    if ( R::count('users', "email = ?", array( $_POST['email'] ) ) > 0 )
    message('Этот E-mail занят');
    
    if ( R::count('users', "name = ?", array( $_POST['name'] ) ) > 0 )
    message('Этот Login занят');
	



      $code = random_str(5);
    
     $_SESSION['confirm'] = array(
	 	'type' => 'register',
	 	'email' => $_POST['email'],
	 	'name' => $_POST['name'],
	 	'password' => $_POST['password'],
	 	'code' => $code,
	 	);

  

    
send_mail($_POST['email'], 'Регистрация', "Код подтверждения регистрации: $code ");


go('confirm');
    
}



else if ($_POST['confirm_f']) {
    
    if ( $_SESSION['confirm']['type'] == 'register') {
        
        if ( $_SESSION['confirm']['code'] != $_POST['code'] )
				message('Код подтверждения регистрации указан неверно');
        
        $users = R::dispense('users'); 
    $users -> email  = $_SESSION['confirm']['email'];
    $users -> name = $_SESSION['confirm']['name'];
    $users -> password = $_SESSION['confirm']['password'];
    $users -> reg_time = R :: isoDateTime () ;
	R::store($users);
        
        unset($_SESSION['confirm']);

			go('login');
    }
     
   else if ( $_SESSION['confirm']['type'] == 'recovery') {
        
        
        $newpass = random_str(10);
       
       
$kod = R::getAll('UPDATE `users` SET `password` = ? WHERE `email` = ?', array(
     md5($newpass),
    $_SESSION['confirm']['email'],
 
)); 
   unset($_SESSION['confirm']);
   

	
       message ("Ваш новый пароль: $newpass");
go('login');	
    }

else not_found();

}




else if ($_POST['recovery_f']) {
     email_valid();
    
if ( R::count('users', "email = ?", array( $_POST['email'] ) ) == 0 )
    message('Аккаунт не найден ');
    
     $code = random_str(5);
    
     $_SESSION['confirm'] = array(
	 	'type' => 'recovery',
	 	'email' => $_POST['email'],
	 	'code' => $code,
	 	);
    

send_mail($_POST['email'], 'Восстановление пароля', "Код подтверждения восстановление пароля: $code ");


go('confirm');

}


?>

