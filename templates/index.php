<section class="promo">
        <h2 class="promo__title">����� ����� ��� �����?</h2>
        <p class="promo__text">�� ����� ��������-�������� �� ������ ����� ������������ ��������������� � ����������� ����������.</p>
        <ul class="promo__list">
			<?php foreach( $categories as $valueCat):  ?>
				<li class="promo__item promo__item--boards">
					<a class="promo__link" href="all-lots.html"> <?=$valueCat; ?></a>
				</li>
			<?php endforeach; ?>
        </ul>
    </section>
    <section class="lots">
        <div class="lots__header">
            <h2>�������� ����</h2>
        </div>
        <ul class="lots__list">
			<?php foreach( $lots as $lot ):  ?>
				<li class="lots__item lot">
					<div class="lot__image">
						<img src=<?=$lot['img'] ?> width="350" height="260" alt="��������">
					</div>
					<div class="lot__info">
						<span class="lot__category"><?=$lot['category']; ?></span>
						<h3 class="lot__title"><a class="text-link" href="lot.html"> <?=$lot['name']; ?> </a></h3>
						<div class="lot__state">
							<div class="lot__rate">
								<span class="lot__amount">��������� ����</span>
								<span class="lot__cost"> <?=$lot['cost']; ?> <b class="rub">�</b></span>
							</div>
							<div class="lot__timer timer">
								<?=$lot_time_remaining;?>
							</div>
						</div>
					</div>
				</li>
				
			<?php endforeach; ?>
        </ul>
    </section>