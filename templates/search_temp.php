<nav class="nav">
   <ul class="nav__list container">
     <?php foreach( $categories as $category): ?>
         <li class="nav__item">
         <a href=""><?=$category['title']?></a>
         </li>
     <?php endforeach; ?>
 </ul>
 </nav>

  <div class="container">
    <section class="lots">
      <h2>Результаты поиска по запросу «<span><?=$searchKey?></span>»</h2>
      <ul class="lots__list">

        <?php if( count($lots) > 0 ) :?>
          <?php foreach( $lots as $lot ):
              $lotTimeRemaining= howLongTimeForEndString( $lot['bidding_ending'] );
            ?>
            <li class="lots__item lot">
              <div class="lot__image">
                <img src="<?=$lot['image']?>" width="350" height="260" alt="<?=$lot['title']?>">
              </div>
              <div class="lot__info">
                <span class="lot__category"><?=$lot['category']?></span>
                <h3 class="lot__title"><a class="text-link" href=<?=sprintf("\"lot.php?lotIndex=%d\"", $lot['id']);?> "><?=$lot['title']?></a></h3>
                <div class="lot__state">
                  <div class="lot__rate">
                    <span class="lot__amount">Стартовая цена</span>
                    <span class="lot__cost"><?=$lot['cost']?><b class="rub">р</b></span>
                  </div>
                  <div class="lot__timer timer">
                    <?=$lotTimeRemaining?>
                  </div>
                </div>
              </div>
            </li>
            <?php endforeach; ?>
        <?php else :?>
          <h1>Ничего не найдено по вашему запросу</h1>
          <<?php endif; ?>

      </ul>
    </section>



    <ul class="pagination-list">
        <li class="pagination-item pagination-item-prev">
          <?php if( $pageIndex == 1) : ?>
            <a href="#">
              Назад
            </a>
          <?php else: ?>
            <a href="index.php?page=<?=($pageIndex-1)?>">
              Назад
            </a>
          <?php endif; ?>
        </li>

        <?php  for( $i = 1; $i<=$pageCount; $i++): ?>
          <?php $class = ($i == $pageIndex ? "pagination-item-active" : ""); ?>
          <li class="pagination-item  <?=$class?>">
            <a href="index.php?page=<?=$i?>" >
              <?=$i?>
            </a>
          </li>
        <?php endfor; ?>
        <li class="pagination-item pagination-item-next">
        <?php if( $pageIndex == $pageCount ) : ?>
            <a href="#">
              Вперед
            </a>
          <?php else: ?>
            <a href="index.php?page=<?=($pageIndex+1)?>">
              Вперед
            </a>
          <?php endif;?>
        </li>
    </ul>
  </div>
