<?php
if ($_POST['edit_f']) {
password_valid();

$edit =   R::getCell( 'SELECT password FROM users WHERE id = ?', [$_SESSION[id]] );

 if ( $_POST['old_password'] and md5($_POST['old_password']) !== $edit ) {
    message('Не правильно введен пароль ');
}
 if ( $_POST['password'] and md5($_POST['password']) !== $edit ) {
    
    R::exec( 'UPDATE users SET password=? WHERE id=?',
        [$_POST['password'],
        $_SESSION[id]
        ]);
}


message('Пароль успешно изменен!');
}

?>

