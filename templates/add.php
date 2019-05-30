<?php $classname = isset($errors) ? "form--invalid" : ""; ?>
<form class="form form--add-lot container <?=$classname; ?>" action="add.php" method="post" enctype="multipart/form-data">
      <h2>Добавление лота</h2>
      <div class="form__container-two">
      <?php $classname = isset($errors['title']) ? "form__item--invalid" : "";
      $value = isset($lot['title']) ? $lot['title'] : ""; ?>
        <div class="form__item <?= $classname; ?>">
          <label for="lot-name">Наименование <sup>*</sup></label>
          <input id="lot-name" type="text" name="lot-name" placeholder="Введите наименование лота" value="<?=$value; ?>">
          <?php if (isset($errors['title'])) : ?> 
            <span class="form__error"><?=$errors['title']; ?></span>
          <?php endif; ?>
        </div>
        <?php $classname = isset($errors['category']) ? "form__item--invalid" : ""; ?>
        <div class="form__item <?=$classname; ?>">
          <label for="category">Категория <sup>*</sup></label>
          <select id="category" name="category">
            <option>Выберите категорию</option>
            <?php foreach ($categories as $category) : ?>
                <option value="<?=$category['id']?>"><?=$category['title']; ?></option>
            <?php endforeach;?>
          </select>
          <?php if (isset($errors['category'])) : ?> 
            <span class="form__error"><?=$errors['category']; ?></span>
        <?php endif; ?>
        </div>
      </div>
      <?php $classname = isset($errors['description']) ? "form__item--invalid" : "" ;
      $value = isset($lot['description']) ? $lot['description'] : ""; ?>
      <div class="form__item form__item--wide <?=$classname; ?>">
        <label for="message">Описание <sup>*</sup></label>
        <textarea id="message" name="message" placeholder="Напишите описание лота" value="<?=$value;?>"></textarea>
        <?php if (isset($errors['description'])) : ?>
            <span class="form__error"><?=$errors['description']; ?></span>
        <?php endif; ?>
      </div>
      <?php $classname = isset($errors['picture']) ? "form__item--invalid" : "" ;
      $value = isset($lot['picture']) ? $lot['picture'] : ""; ?>
      <div class="form__item form__item--file <?=$classname;?>">
        <label>Изображение <sup>*</sup></label>
        <div class="form__input-file">
          <input class="visually-hidden" type="file" id="lot-img" value="<?=$value;?>">
          <label for="lot-img">
            Добавить
          </label>
        </div>
      </div>
      <div class="form__container-three">
      <?php $classname = isset($errors['price']) ? "form__item--invalid" : "" ;
      $value = isset($lot['price']) ? $lot['price'] : ""; ?>
        <div class="form__item form__item--small <?=$classname;?>">
          <label for="lot-rate">Начальная цена <sup>*</sup></label>
          <input id="lot-rate" type="text" name="lot-rate" placeholder="0" value="<?=$value;?>">
          <?php if (isset($errors['price'])) : ?>
            <span class="form__error"><?=$errors['price'];?></span>
          <?php endif; ?>
        </div>
        <?php $classname = isset($errors['step']) ? "form__item--invalid" : "" ;
        $value = isset($lot['step']) ? $lot['step'] : ""; ?>
        <div class="form__item form__item--small <?=$classname;?>">
          <label for="lot-step">Шаг ставки <sup>*</sup></label>
          <input id="lot-step" type="text" name="lot-step" placeholder="0" value="<?=$value;?>">
          <?php if (isset($errors['price'])) : ?>
            <span class="form__error"><?=$errors['step'];?></span>
          <?php endif; ?>
        </div>
        <?php $classname = isset($errors['dt_end']) ? "form__item--invalid" : "" ;
        $value = isset($lot['dt_end']) ? $lot['dt_end'] : ""; ?>
        <div class="form__item <?=$classname;?>">
          <label for="lot-date">Дата окончания торгов <sup>*</sup></label>
          <input class="form__input-date" id="lot-date" type="text" name="lot-date" placeholder="Введите дату в формате ГГГГ-ММ-ДД" value="<?=$value;?>">
          <?php if (isset($errors['dt_end'])) : ?>
            <span class="form__error"><?=$errors['dt_end'];?></span>
          <?php endif; ?>
        </div>
      </div>
      <span class="form__error form__error--bottom">Пожалуйста, исправьте ошибки в форме.</span>
      <button type="submit" class="button">Добавить лот</button>
</form>