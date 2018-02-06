<?

/*ini_set('display_errors',1);
error_reporting(E_ALL);*/



if ( $_SERVER['REQUEST_URI'] == '/' ) $page = 'home';
else {

	$page = substr($_SERVER['REQUEST_URI'], 1);
	if ( !preg_match('/^[A-z0-9]{3,15}$/', $page) ) exit('error url');
}


require 'libs/rb.php';
R::setup( 'mysql:host=127.0.0.1;dbname=redbd',
        'root', '' );


session_start();


//Права доступа для пользователей
if ( file_exists('all/'.$page.'.php') ) include 'all/'.$page.'.php';

else if ( $_SESSION['id'] and file_exists('auth/'.$page.'.php') ) include 'auth/'.$page.'.php';

else if ( !$_SESSION['id'] and file_exists('guest/'.$page.'.php') ) include 'guest/'.$page.'.php';

else not_found();


//function dump ($luck) {
//    echo <pre>; print_r(luck) echo </pre>;
//    }

//Функция на вывод текста 
function message( $text ) {
	exit('{ "message" : "'.$text.'"}');
}


//Функуия на редирект
function go( $url ) {
	exit('{ "go" : "'.$url.'"}');
}

//Функция в доступе отказано 
function not_found() {
	exit('Страница 404');
}


//Функция для генирирования рандомного текста 
function random_str( $num = 30 ) {
	return substr(str_shuffle('0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, $num);
}


function email_valid() {
	if ( !filter_var( $_POST['email'], FILTER_VALIDATE_EMAIL))
		message('E-mail указан неверно');
}

function name_valid() {
    if ( !preg_match('/^[A-z0-9]{4,30}$/',$_POST['name']) )
		message('Не коректный логин');
	
	}


function password_valid() {
	if ( !preg_match('/^[A-z0-9]{2,30}$/', $_POST['password']) )
		message('Пароль указан неверно');
	$_POST['password'] = md5($_POST['password']);
}


function password2_valid() {
	if ( !preg_match('/^[A-z0-9]{2,30}$/', $_POST['password2']) )
		message('Повторный пароль введен неверно');
	$_POST['password2'] = md5($_POST['password2']);
}

//Функция на совпадение пароля 
function same_pass () {
    if ($_POST['password2'] != $_POST['password'])
        message('Пароли не совпадают');
}
//Функция для вотановления пароля 
function nosame_pass () {
    if ($_POST['password2'] == $_POST['password'])
        message('Новый пароль должен отличаться от предыдущего');
}



// Функция отправки сообщений 
function send_mail( $email, $title, $text ) {

mail($email, $title, '<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>'.$title.'</title>
</head>

<body style="margin:0">


<div style="margin:0; padding:0; font-size: 18px; font-family: Arial, sans-serif; font-weight: bold; text-align: center; background: #FCFCFD">


<div style="margin:0; background: #464E78; padding: 25px; color:#fff">'.$title.'</div>


<div style="padding:30px;">


<div style="background: #fff; border-radius: 10px; padding: 25px; border: 1px solid #EEEFF2">'.$text.'</div>

</div>

</div>

</body>
</html>', "From: admin@mysite.com\r\nMIME-Version: 1.0\r\nContent-Type: text/html; charset=UTF-8");

}


function top( $title ) {
echo '<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>'.$title.'</title>
<link rel="stylesheet" href="/style.css">
<link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
<script src="https://code.jquery.com/jquery-1.12.4.js" integrity="sha256-Qw82+bXyGq6MydymqBxNPYTaUXXq7c8v3CwiYwLLNXU=" crossorigin="anonymous"></script>
<script src="/script.js"></script>
</head>

<body>


<div class="wrapper">

<div class="menu">
';

if ($_SESSION['id'])
	echo '
<a href="/profile">Профайл</a>
<a href="/office">Кабинет</a>
<a href="/referral">Рефералы</a>
<a href="/logout">Выход</a>

';

else 
	echo '
<a href="/login">Вход</a>
<a href="/register">Регистрация</a>

';




echo'
</div>
<div class="content">
<div class="block">
';
}
















function bottom() {
echo '
</div>
</div>
</div>

</body>
</html>';
}






?>