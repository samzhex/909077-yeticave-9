<section class="rates container">
      <h2>Мои ставки</h2>
      <table class="rates__list">
        <?php foreach($my_bets as $bet) : ?>
        <tr class="rates__item <?=$bet['winner_id'] === $user_id ? 'rates__item--win' : '';?> ">
          <td class="rates__info">
            <div class="rates__img">
              <img src="../<?=esc($bet['picture']);?>" width="54" height="40" alt="Сноуборд">
            </div>
            <div>
              <h3 class="rates__title"><a href="lot.php?id=<?=$bet['id'];?>"><?=esc($bet['title']);?></a></h3>
              <?php if ($bet['winner_id'] === $user_id) : ?>
                <p><?=esc($bet['contacts']);?></p>
              <?php endif;?>
            </div>
          </td>
          <td class="rates__category">
            <?=esc($bet['category']);?>
          </td>
          <td class="rates__timer">
            <div class="timer <?= $bet['winner_id'] === $user_id ? 'timer--win' : ($bet['winner_id'] !== $user_id && show_breakpoint($bet['dt_end'], $secs_in_hour) ? 'timer--finishing'  : '' );?>"><?=($bet['winner_id'] === $user_id) ? 'Ставка выиграла' : format_time_diff($bet['dt_end']); ?></div>
          </td>
          <td class="rates__price">
            <?=esc($bet['price']);?>
          </td>
          <td class="rates__time">
            <?=$time=remaining_time($bet['dt_bet'], $secs_in_hour, 86400);?>
          </td>
        </tr>
        <?php endforeach; ?>
        
      </table>
    </section>