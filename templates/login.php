<?php $classname = isset($errors) ? "form--invalid" : ""; ?>
<form class="form container <?=$classname;?>" action="login.php" method="post"> <!-- form--invalid -->
    <h2>Вход</h2>
    <?php $classname = isset($errors['email']) ? "form__item--invalid" : ""; ?>
    <div class="form__item <?=$classname;?>"> 
        <label for="email">E-mail <sup>*</sup></label>
        <input id="email" type="text" name="email" placeholder="Введите e-mail" value=<?=esc($form['email'] ?? "");?>>
        <span class="form__error"><?=$errors['email'];?></span>
    </div>
    <?php $classname = isset($errors['password']) ? "form__item--invalid" : ""; ?>
    <div class="form__item form__item--last">
        <label for="password">Пароль <sup>*</sup></label>
        <input id="password" type="password" name="password" placeholder="Введите пароль" value=<?=esc($form['password'] ?? "");?>>
        <span class="form__error"><?=$errors['password'];?></span>
    </div>
    <button type="submit" class="button">Войти</button>
</form>