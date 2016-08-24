<div class="formLogin" id="f_login">
    <a href="?action=show" id="closeFormLogin">X</a>
    <form action="?action=checkIn" method="POST">
        <label for="f_login">Введите логин</label>
        <input type="text" id="f_login" name="login" placeholder="E-mail"/>

        <label for="f_password">Введите пароль</label>
        <input type="password" id="f_password" name="passw" placeholder="Password"/>

        <input type="submit" value="Вход">
        <input type="reset" value="Сброс"/>
    </form>

    <div class="madUser">
        <small><a href="?action=reg">Зарегистрироваться /</a>
            <a href="?action=forgetPass"> Забыли пароль?</a></small>
    </div>
</div>
