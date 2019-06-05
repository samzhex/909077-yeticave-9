<section class="rates container">
      <h2>Мои ставки</h2>
      <table class="rates__list">
        <?php foreach($my_bets as $bet) : ?>
        <tr class="rates__item">
          <td class="rates__info">
            <div class="rates__img">
              <img src="../<?=$bet['picture'];?>" width="54" height="40" alt="Сноуборд">
            </div>
            <h3 class="rates__title"><a href="lot.php?id=<?=$bet['id'];?>"><?=$bet['title'];?></a></h3>
          </td>
          <td class="rates__category">
            <?=$bet['category'];?>
          </td>
          <td class="rates__timer">
            <div class="timer <?=show_breakpoint($bet['dt_end'], $secs_in_hour) ? 'timer--finishing' : '' ?>"><?=format_time_diff($bet['dt_end']); ?></div>
          </td>
          <td class="rates__price">
            <?=$bet['price'];?>
          </td>
          <td class="rates__time">
            <?=$time=remaining_time($bet['dt_bet'], $secs_in_hour, 86400);?>
          </td>
        </tr>
        <?php endforeach; ?>
        
      </table>
    </section>