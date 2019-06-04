<form class="form container <?=isset($errors) ? "form--invalid" : ""; ?>" action="login.php" method="post"> <!-- form--invalid -->
    <h2>Вход</h2>
    <span class="form__error form__error--bottom"><?=$errors['err'];?></span>
    <div class="form__item <?=isset($errors['email']) ? "form__item--invalid" : "";?>"> 
        <label for="email">E-mail <sup>*</sup></label>
        <input id="email" type="text" name="email" placeholder="Введите e-mail" value=<?=esc($form['email'] ?? "");?>>
        <?php if (isset($errors)) : ?> 
            <span class="form__error"><?=$errors['email'];?></span>
        <?php endif;?>
    </div>
    <div class="form__item form__item--last <?=isset($errors['password']) ? "form__item--invalid" : ""; ?>">
        <label for="password">Пароль <sup>*</sup></label>
        <input id="password" type="password" name="password" placeholder="Введите пароль" value=<?=esc($form['password'] ?? "");?>>
        <?php if (isset($errors)) : ?>
            <span class="form__error"><?=$errors['password'];?></span>
        <?php endif;?>
    </div>
    <button type="submit" class="button">Войти</button>
</form>