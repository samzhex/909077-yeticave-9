<section class="promo">
    <h2 class="promo__title">Нужен стафф для катки?</h2>
    <p class="promo__text">На нашем интернет-аукционе ты найдёшь самое эксклюзивное сноубордическое и горнолыжное снаряжение.</p>
    <ul class="promo__list">
    <?php foreach ($categories as $category): ?>
        <li class="promo__item promo__item--<?=esc($category['code']); ?>">
            <a class="promo__link" href="all-lots.php?category_id=<?=$category['id'];?>"><?=esc($category['title']);?></a>
        </li>
    <?php endforeach; ?>   
    </ul>
</section>
<section class="lots">
    <div class="lots__header">
        <h2>Открытые лоты</h2>
    </div>
    <ul class="lots__list">
    <?php foreach ($lots as $lot): ?>
        <li class="lots__item lot">
            <div class="lot__image">
                <img src="<?=esc($lot['picture']); ?>" width="350" height="260" alt="">
            </div>
            <div class="lot__info">
                <span class="lot__category"><?=esc($lot['category']); ?></span>
                <h3 class="lot__title"><a class="text-link" href="lot.php?id=<?=$lot['id'];?>"><?=esc($lot['title']); ?></a></h3>
                <div class="lot__state">
                    <div class="lot__rate">
                    <?php if (intval($lot['bets_count']) === 0) : ?>
                        <span class="lot__amount">Стартовая цена</span>
                        <span class="lot__cost"><?=format_price(esc($lot['price'])); ?><b class="rub">р</b></span>
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
    <?php endforeach; ?>
    </ul>
</section>