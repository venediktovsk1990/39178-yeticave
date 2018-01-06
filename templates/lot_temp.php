<nav class="nav">
			<ul class="nav__list container">
				<?php foreach( $categories as $category): ?>
					<li class="nav__item">
						<a href=""><?=$category['title']?></a>
					</li>
				<?php endforeach; ?>
			</ul>
</nav>


		<section class="lot-item container">
			<h2><?=$lot['title']?></h2>
			<div class="lot-item__content">
				<div class="lot-item__left">
					<div class="lot-item__image">
						<img src=<?=$lot['image'] ?> width="730" height="548" alt="Сноуборд">
					</div>
					<p class="lot-item__category">Категория: <span><?=$lot['category']?></span></p>
					<p class="lot-item__description"><?=$lot['subscribe']?></p>
				</div>


				<div class="lot-item__right" >
					<div class="lot-item__state">
						<div class="lot-item__timer timer">
							<?=howLongTimeForEndString( $lot['bidding_ending'] ) ?>
						</div>
						<div class="lot-item__cost-state">
							<div class="lot-item__rate">
								<span class="lot-item__amount">Текущая цена</span>
								<span class="lot-item__cost"><?=$lot['current_cost']?></span>
							</div>
							<div class="lot-item__min-cost">
								Мин. ставка <span><?=($lot['current_cost'] + $lot['step'])?></span>
							</div>
						</div>

						<?php if( $templateData['show'] ): ?>

							<form class="lot-item__form" action="lot.php" method="post"   >
								<p class="lot-item__form-item" >
									<label for="cost">Ваша ставка</label>
									<input id="cost" type="number" name="cost" placeholder=<?=($lot['current_cost'] + $lot['step'])?>  value="<?=$templateData['userBid'] ?>" >
									<input id="lotIndex" name="lotIndex" value="<?=$templateData['lotIndex'] ?>" type="hidden"  >
								</p>
								<button  type="submit" class="button"  >Сделать ставку</button>
							</form>
						<?php endif; ?>

					</div>



					<div class="history">
						<h3>История ставок (<span><?=count($bets)?></span>)</h3>
						<!-- заполните эту таблицу данными из массива $bets-->
						<table class="history__list">
							<?php foreach( $bets as $bet ): ?>
								<tr class="history__item">
									<td class="history__name"><?=$bet['name']; ?></td>
									<td class="history__price"><?=$bet['cost']; ?></td>
									<td class="history__time"><?=howLongTime($bet['bid_date']); ?> </td>
								</tr>
							<?php endforeach; ?>
						</table>
					</div>
				</div>
			</div>
		</section>
