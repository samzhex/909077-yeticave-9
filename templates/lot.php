<section class="lot-item container">
    <h2><?=esc($lot['title']); ?></h2>
    <div class="lot-item__content">
    <div class="lot-item__left">
        <div class="lot-item__image">
        <img src="../<?=esc($lot['picture']);?>" width="730" height="548" alt="Сноуборд">
        </div>
        <p class="lot-item__category">Категория: <span><?=esc($lot['category']);?></span></p>
        <p class="lot-item__description"><?=esc($lot['description']);?></p>
    </div>
    <div class="lot-item__right <?=(!isset($_SESSION['user'])) ? "visually-hidden" : "";?>">
        <div class="lot-item__state">
        <div class="lot-item__timer timer <?=show_breakpoint($lot['dt_end'], $secs_in_hour) ? 'timer--finishing' : '' ?>">
            <?=format_time_diff($lot['dt_end']); ?>
        </div>
        <div class="lot-item__cost-state">
            <div class="lot-item__rate">
            <span class="lot-item__amount">Текущая цена</span>
            <span class="lot-item__cost"><?=isset($lot['bid_price']) ? esc($lot['bid_price']) : esc($lot['price']);?></span>
            </div>
            <div class="lot-item__min-cost">
            Мин. ставка <span><?=esc($lot['min_bet']);?> р</span>
            </div>
        </div>
        <form class="lot-item__form" action="lot.php?id=<?=$lot['id']; ?>" method="post" autocomplete="off">
            <p class="lot-item__form-item form__item <?=isset($error) ? "form__item--invalid" : "";  ?>">
            <label for="cost">Ваша ставка</label>
            <input id="cost" type="text" name="cost" placeholder="12 000" value="<?=esc($my_bet['cost'] ?? ""); ?>">
            <?php if (isset($error)) : ?>
                <span class="form__error"><?=$error;?></span>
            <?php endif;?>
            </p>
            <button type="submit" class="button">Сделать ставку</button>
        </form>
        </div>
        <div class="history">
        <h3>История ставок (<span><?=count($bets);?></span>)</h3>
        <table class="history__list">
            <?php foreach($bets as $bet) : ?>
                <tr class="history__item">
                <td class="history__name"><?=esc($bet['name']);?></td>
                <td class="history__price"><?=format_price(esc($bet['price']));?> р</td>
                <td class="history__time"><?=$time=remaining_time($bet['dt_bet']);?></td>
                </tr>
            <?php endforeach;?>
        </table>
        </div>
    </div>
    </div>
</section>