 <nav class="nav">
    <ul class="nav__list container">
      <li class="nav__item">
        <a href="all-lots.html">Доски и лыжи</a>
      </li>
      <li class="nav__item">
        <a href="all-lots.html">Крепления</a>
      </li>
      <li class="nav__item">
        <a href="all-lots.html">Ботинки</a>
      </li>
      <li class="nav__item">
        <a href="all-lots.html">Одежда</a>
      </li>
      <li class="nav__item">
        <a href="all-lots.html">Инструменты</a>
      </li>
      <li class="nav__item">
        <a href="all-lots.html">Разное</a>
      </li>
    </ul>
  </nav>
  <section class="rates container">
    <h2>Мои ставки</h2>
    <table class="rates__list">
	
		<?php foreach( $my_lots as $key=>$lot ) : 
			$lot_index = $lot['index'];
			$bit_time = $lot['time'];
			$cost = $lot['cost'];
		
		?>
		  <tr class="rates__item">
			<td class="rates__info">
			  <div class="rates__img">
				<img src="<?=$lots[$lot_index]['img']?>" width="54" height="40" alt="<?=$lots[$lot_index]['name']?>">
			  </div>
			  <h3 class="rates__title"><a href="lot.html"><?=$lots[$lot_index]['name']?></a></h3>
			</td>
			<td class="rates__category">
			  <?=$lots[$lot_index]['category']?>
			</td>
			<td class="rates__timer">
			  <div class="timer timer--finishing">07:13:34</div>
			</td>
			<td class="rates__price">
			  <?=$cost?> р
			</td>
			<td class="rates__time">
			  <?=howLongTime($bit_time); ?>
			</td>
		  </tr>
	  <?php endforeach; ?>
	  
	  
      
    </table>
  </section>