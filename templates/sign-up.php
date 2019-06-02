<form class="form container <?=!empty($errors) ? "form--invalid" : ""; ?>" action="sign-up.php" method="post" autocomplete="off" enctype="multipart/form-data"> 
    <h2>Регистрация нового аккаунта</h2>
    <div class="form__item <?=isset($errors['email']) ? "form__item--invalid" : ""; ?>"> 
        <label for="email">E-mail <sup>*</sup></label>
        <input id="email" type="text" name="email" placeholder="Введите e-mail" value="<?=esc($values['email'] ?? ""); ?>">
        <?php if (isset($errors['email'])) : ?> 
            <span class="form__error"><?=$errors['email']; ?></span>
        <?php endif;?>
    </div>
   
    <div class="form__item <?=isset($errors['password']) ? "form__item--invalid" : ""; ?>">
        <label for="password">Пароль <sup>*</sup></label>
        <input id="password" type="password" name="password" placeholder="Введите пароль" value="<?=esc($values['password'] ?? "");?>">
        <?php if (isset($errors['password'])) : ?> 
            <span class="form__error"><?=$errors['password']; ?></span>
        <?php endif;?>
    </div>
    <div class="form__item <?=isset($errors['name']) ? "form__item--invalid" : "";?>">
        <label for="name">Имя <sup>*</sup></label>
        <input id="name" type="text" name="name" placeholder="Введите имя" value="<?=esc($values['name'] ?? "");?>">
        <?php if (isset($errors['name'])) : ?> 
            <span class="form__error"><?=$errors['name']; ?></span>
        <?php endif;?>
    </div>
    <?php $value = esc($values['contacts'] ?? "");?>
    <div class="form__item <?=isset($errors['contacts']) ? "form__item--invalid" : ""; ?>">
        <label for="message">Контактные данные <sup>*</sup></label>
        <textarea id="message" name="contacts" placeholder="Напишите как с вами связаться" value="<?=$value;?>"><?=$value;?></textarea>
        <?php if (isset($errors['contacts'])) : ?> 
            <span class="form__error"><?=$errors['contacts']; ?></span>
        <?php endif;?>
    </div>
    <span class="form__error form__error--bottom">Пожалуйста, исправьте ошибки в форме.</span>
    <button type="submit" class="button">Зарегистрироваться</button>
    <a class="text-link" href="#">Уже есть аккаунт</a>
</form>