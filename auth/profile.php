<? top('Редактировать') ?>

<h1>Сменить пароль</h1>
<p><input type="password" placeholder="Старый пароль" id="old_password"></p>
<p><input type="password" placeholder="Новый пароль" id="password"></p>
<p><button onclick="post_query('aform', 'edit', 'email.old_password.password.captcha')">Сохранить</button>

<?

//$edit =   R::getAssoc( 'SELECT id, password FROM users WHERE id=?',[$_SESSION[id]] );
//$edit =   R::getCell( 'SELECT reg_time FROM users WHERE id = ?', [$_SESSION[id]] );

echo '<pre>';
print_r($_SESSION);
echo '</pre>';
?>

<? bottom() ?>