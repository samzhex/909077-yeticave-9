<section class="promo">
    <h2 class="promo__title">Нужен стафф для катки?</h2>
    <p class="promo__text">На нашем интернет-аукционе ты найдёшь самое эксклюзивное сноубордическое и горнолыжное снаряжение.</p>
    <ul class="promo__list">
    <?php foreach ($categories as $category): ?>
        <li class="promo__item promo__item--<?=esc($category['code']); ?>">
            <a class="promo__link" href="pages/all-lots.html"><?=esc($category['title']);?></a>
        </li>
    <?php endforeach; ?>   
    </ul>
</section>
<section class="lots">
    <div class="lots__header">
        <h2>Открытые лоты</h2>
    </div>
    <ul class="lots__list">
    <?php foreach ($items as $val): ?>
        <li class="lots__item lot">
            <div class="lot__image">
                <img src="<?=esc($val['picture']); ?>" width="350" height="260" alt="">
            </div>
            <div class="lot__info">
                <span class="lot__category"><?=esc($val['category']); ?></span>
                <h3 class="lot__title"><a class="text-link" href="lot.php?id=<?=$val['id'];?>"><?=esc($val['title']); ?></a></h3>
                <div class="lot__state">
                    <div class="lot__rate">
                        <span class="lot__amount">Стартовая цена</span>
                        <span class="lot__cost"><?=format_price(esc($val['price'])); ?><b class="rub">р</b></span>
                    </div>
                    <div class="lot__timer timer <?=show_breakpoint($val['dt_end'], $secs_in_hour) ? 'timer--finishing' : '' ?>">
                        <?=format_time_diff($val['dt_end']); ?>
                    </div>
                </div>
            </div>
        </li>
    <?php endforeach; ?>
    </ul>
</section>