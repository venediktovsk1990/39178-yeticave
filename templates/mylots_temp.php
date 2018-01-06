<nav class="nav">
     <ul class="nav__list container">
       <?php foreach( $categories as $category): ?>
         <li class="nav__item">
           <a href=""><?=$category['title']?></a>
         </li>
       <?php endforeach; ?>
     </ul>
</nav>

  <section class="rates container">
    <h2>Мои ставки</h2>
    <table class="rates__list">

		<?php foreach( $bids as $key=>$bid ) :
			$title = $bid['title'];
			$betTime = $bid['bid_date'];
			$cost = $bid['cost'];
			$finishTime = $bid['bidding_ending'];
			$categories = $bid['categories'];
			$img = $bid['image'];
		?>
		  <tr class="rates__item">
			<td class="rates__info">
			  <div class="rates__img">
				<img src="<?=$img?>" width="54" height="40" alt="<?=$title?>">
			  </div>
			  <h3 class="rates__title"><a href="lot.html"><?=$title?></a></h3>
			</td>
			<td class="rates__category">
			  <?=$categories?>
			</td>
			<td class="rates__timer">
			  <div class="timer timer--finishing"><?=howLongTimeForEndString($finishTime)?></div>
			</td>
			<td class="rates__price">
			  <?=$cost?> р
			</td>
			<td class="rates__time">
			  <?=howLongTime($betTime); ?>
			</td>
		  </tr>
	  <?php endforeach; ?>



    </table>
  </section>
