<form class="form form--add-lot container <?=isset($errors) ? "form--invalid" : ""; ?>" action="add.php" method="post" enctype="multipart/form-data">
      <h2>Добавление лота</h2>
      <div class="form__container-two">
        <div class="form__item <?=isset($errors['title']) ? "form__item--invalid" : "";  ?>">
          <label for="lot-name">Наименование <sup>*</sup></label>
          <input id="lot-name" type="text" name="title" placeholder="Введите наименование лота" value="<?=esc($lot['title'] ?? ""); ?>">
          <?php if (isset($errors['title'])) : ?> 
            <span class="form__error"><?=$errors['title']; ?></span>
          <?php endif; ?>
        </div>
        <div class="form__item <?=isset($errors['category']) ? "form__item--invalid" : ""; ?>">
          <label for="category">Категория <sup>*</sup></label>
          <select id="category" name="category">
            <option>Выберите категорию</option>
            <?php foreach ($categories as $category) : ?>
                <option value="<?=$category['id']?>"<?=(isset($lot['category']) && intval($lot['category']) === $category['id']) ? 'selected="selected"' : ''; ?>><?=$category['title']; ?></option>
            <?php endforeach; ?>      
          </select>
          <?php if (isset($errors['category'])) : ?> 
            <span class="form__error"><?=$errors['category']; ?></span>
        <?php endif; ?>
        </div>
      </div>
      <?php $value = esc($lot['description'] ?? ""); ?>
      <div class="form__item form__item--wide <?=isset($errors['description']) ? "form__item--invalid" : "" ; ?>">
        <label for="message">Описание <sup>*</sup></label>
        <textarea id="message" name="description" placeholder="Напишите описание лота" value="<?=$value; ?>"><?=$value;?></textarea>
        <?php if (isset($errors['description'])) : ?>
            <span class="form__error"><?=$errors['description']; ?></span>
        <?php endif; ?>
      </div>
      <div class="form__item form__item--file <?=isset($errors['lot-img']) ? "form__item--invalid" : "" ; ?>">
        <label>Изображение <sup>*</sup></label>
        <div class="form__input-file">
          <input class="visually-hidden" type="file" id="lot-img" name="lot-img" value="<?=esc($lot['lot-img'] ?? "");?>">
          <label for="lot-img">
            Добавить
          </label>
        </div>
        <?php if (isset($errors['lot-img'])) : ?>
            <span class="form__error"><?=$errors['lot-img']; ?></span>
        <?php endif; ?>
      </div>
      <div class="form__container-three">
        <div class="form__item form__item--small <?=isset($errors['lot-rate']) ? "form__item--invalid" : "" ; ?>">
          <label for="lot-rate">Начальная цена <sup>*</sup></label>
          <input id="lot-rate" type="text" name="lot-rate" placeholder="0" value="<?=esc($lot['lot-rate'] ?? "");?>">
          <?php if (isset($errors['lot-rate'])) : ?>
            <span class="form__error"><?=$errors['lot-rate'];?></span>
          <?php endif; ?>
        </div>
        <div class="form__item form__item--small <?=isset($errors['lot-step']) ? "form__item--invalid" : "" ; ?>">
          <label for="lot-step">Шаг ставки <sup>*</sup></label>
          <input id="lot-step" type="text" name="lot-step" placeholder="0" value="<?=esc($lot['lot-step'] ?? "");?>">
          <?php if (isset($errors['lot-step'])) : ?>
            <span class="form__error"><?=$errors['lot-step'];?></span>
          <?php endif; ?>
        </div>
      
        <div class="form__item <?=isset($errors['lot-date']) ? "form__item--invalid" : "" ;?>">
          <label for="lot-date">Дата окончания торгов <sup>*</sup></label>
          <input class="form__input-date" id="lot-date" type="text" name="lot-date" placeholder="Введите дату в формате ГГГГ-ММ-ДД" value="<?=esc($lot['lot-date'] ?? "");?>">
          <?php if (isset($errors['lot-date'])) : ?>
            <span class="form__error"><?=$errors['lot-date'];?></span>
          <?php endif; ?>
        </div>
      </div>
      <span class="form__error form__error--bottom"><?=$error;?></span>
      <button type="submit" class="button">Добавить лот</button>
</form>