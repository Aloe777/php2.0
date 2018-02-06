<? top('Регистрация') ?>

<h1>Регистрация</h1>

<p><input type="text" placeholder="E-mail" id="email"></p>
<p><input type="text" placeholder="login" id="name"></p>
<p><input type="password" placeholder="Пароль" id="password"></p>
<p><input type="password" placeholder="Повторный пароль" id="password2"></p>
<p><input type="text" placeholder="Столица Росии?" id="captcha"></p>
<p><button onclick="post_query('gform', 'register', 'email.name.password.password2.captcha')">Регистрация</button> </p>


<? bottom() ?>