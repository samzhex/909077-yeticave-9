<div class="container">
      <section class="lots">
        <?php if(isset($lots)) : ?>
        <h2>Результаты поиска по запросу «<span><?=$search;?></span>»</h2>
        <ul class="lots__list">
        <?php foreach($lots as $lot) : ?>
          <li class="lots__item lot">
            <div class="lot__image">
              <img src="../<?=esc($lot['picture']);?>" width="350" height="260" alt="Сноуборд">
            </div>
            <div class="lot__info">
              <span class="lot__category"><?=esc($lot['category']);?></span>
              <h3 class="lot__title"><a class="text-link" href="lot.php?id=<?=$lot['id'];?>"><?=esc($lot['title']);?></a></h3>
              <div class="lot__state">
                <div class="lot__rate">
                <?php if ($lot['bets_count'] === 0) : ?>
                  <span class="lot__amount">Стартовая цена</span>
                  <span class="lot__cost"><?=esc($lot['price']);?><b class="rub">р</b></span>
                <?php else : ?>
                  <span class="lot__amount"><?=$lot['bets_count'] . ' ' . get_noun_plural_form($lot['bets_count'], 'ставка', 'ставки', 'ставок');?></span>
                  <span class="lot__cost"><?=esc($lot['bid_price']);?><b class="rub">р</b></span>
                <?php endif;?>
                </div>
                <div class="lot__timer timer <?=show_breakpoint($lot['dt_end'], $secs_in_hour) ? 'timer--finishing' : '' ?>">
                  <?=format_time_diff($lot['dt_end']); ?>
                </div>
              </div>
            </div>
          </li>
        <?php endforeach;?>
        </ul>
      <?php else : ?>
        <h2>Ничего не найдено по вашему запросу</h2>
      <?php endif;?>
      </section>
      <?php if(count($lots) > 9) :?>
      <ul class="pagination-list">
        <li class="pagination-item pagination-item-prev"><a>Назад</a></li>
        <li class="pagination-item pagination-item-active"><a>1</a></li>
        <li class="pagination-item"><a href="#">2</a></li>
        <li class="pagination-item"><a href="#">3</a></li>
        <li class="pagination-item"><a href="#">4</a></li>
        <li class="pagination-item pagination-item-next"><a href="#">Вперед</a></li>
      </ul>
      <?php endif;?>
    </div>