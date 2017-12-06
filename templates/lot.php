<nav class="nav">
			<ul class="nav__list container">
				<li class="nav__item">
					<a href="">Доски и лыжи</a>
				</li>
				<li class="nav__item">
					<a href="">Крепления</a>
				</li>
				<li class="nav__item">
					<a href="">Ботинки</a>
				</li>
				<li class="nav__item">
					<a href="">Одежда</a>
				</li>
				<li class="nav__item">
					<a href="">Инструменты</a>
				</li>
				<li class="nav__item">
					<a href="">Разное</a>
				</li>
			</ul>
		</nav>
	
	
		<section class="lot-item container">
			<h2><?=$lot['name']?></h2>
			<div class="lot-item__content">
				<div class="lot-item__left">
					<div class="lot-item__image">
						<img src=<?=$lot['img'] ?> width="730" height="548" alt="Сноуборд">
					</div>
					<p class="lot-item__category">Категория: <span><?=$lot['category']?></span></p>
					<p class="lot-item__description">Легкий маневренный сноуборд, готовый дать жару в любом парке, растопив
						снег
						мощным щелчкоми четкими дугами. Стекловолокно Bi-Ax, уложенное в двух направлениях, наделяет этот
						снаряд
						отличной гибкостью и отзывчивостью, а симметричная геометрия в сочетании с классическим прогибом
						кэмбер
						позволит уверенно держать высокие скорости. А если к концу катального дня сил совсем не останется,
						просто
						посмотрите на Вашу доску и улыбнитесь, крутая графика от Шона Кливера еще никого не оставляла
						равнодушным.</p>
				</div>
				
				
				<div class="lot-item__right" >
					<div class="lot-item__state">
						<div class="lot-item__timer timer">
							10:54:12
						</div>
						<div class="lot-item__cost-state">
							<div class="lot-item__rate">
								<span class="lot-item__amount">Текущая цена</span>
								<span class="lot-item__cost"><?=$lot['cost']?></span>
							</div>
							<div class="lot-item__min-cost">
								Мин. ставка <span>12 000 р</span>
							</div>
						</div>

						<?php if( !$template_data['disabled'] && $template_data['is_auth'] ): ?>
							
							<form class="lot-item__form" action="lot.php" method="post"   >
								<p class="lot-item__form-item" >
									<label for="cost">Ваша ставка</label>
									<input id="cost" type="number" name="cost" placeholder="12 000 "  > 
									<input id="lotIndex" name="lot_index" value="<?=$template_data['lot_index'] ?>" type="hidden" name="cost" placeholder="12 000">
								</p>
								<button  type="submit" class="button"  >Сделать ставку</button>
							</form>
						<?php endif; ?>
						
					</div>
					
					
					
					<div class="history">
						<h3>История ставок (<span>4</span>)</h3>
						<!-- заполните эту таблицу данными из массива $bets-->
						<table class="history__list">
							<?php foreach( $bets as $bet ): ?>
								<tr class="history__item">
									<td class="history__name"><?=$bet['name']; ?></td>
									<td class="history__price"><?=$bet['price']; ?></td>
									<td class="history__time"><?=howLongTime($bet['ts']); ?> </td>
								</tr>
							<?php endforeach; ?>	
						</table>
					</div>
				</div>
			</div>
		</section>