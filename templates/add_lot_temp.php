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
  
  
	<?php
		$classname = isset($errors) ? "form--invalid" : "";
	?>
  <form class="form form--add-lot container <?=$classname?>" action="add.php" method="post" enctype="multipart/form-data" > <!-- form--invalid -->
    <h2>Добавление лота</h2>
    <div class="form__container-two">
	
	   <?php 
		$classname = isset($errors['Название']) ? "form__item--invalid" : "";
		$error_text = isset($errors['Название']) ? $errors['Название'] : "";
		$value = isset($form_values['lot-name']) ? $form_values['lot-name'] : ""; 
	   ?>
      <div class="form__item <?=$classname ?> "> <!-- form__item--invalid -->
        <label for="lot-name">Наименование</label>
        <input id="lot-name" type="text" name="lot-name" placeholder="Введите наименование лота" value="<?=$value ?>" >
        <span class="form__error">Введите наименование лота</span>
      </div>
	  
	  <?php 
		$classname = isset($errors['Категория']) ? "form__item--invalid" : "";
		$error_text = isset($errors['Категория']) ? $errors['Категория'] : "";
	   ?>
      <div class="form__item <?=$classname?> ">
        <label for="category">Категория</label>
        <select id="category" name="category" >
			<option>Выберите категорию</option>
			<?php foreach( $categories as $category): ?>
				<?php $selected = $form_values['category'] == $category['title'] ? "selected" : ""; ?>
				<option <?=$selected?> ><?=$category['title']?></option>
			<?php endforeach; ?>
		  </select>
        <span class="form__error">Выберите категорию</span>
      </div>
    </div>
	
	<?php 
		$classname = isset($errors['Описание']) ? "form__item--invalid" : "";
		$error_text = isset($errors['Описание']) ? $errors['Описание'] : "";
		$value = isset($form_values['message']) ? $form_values['message'] : ""; 
	  ?>
    <div class="form__item form__item--wide <?=$classname?>">
      <label for="message">Описание</label>
      <textarea id="message" name="message" placeholder="Напишите описание лота" ><?=$value ?></textarea>
      <span class="form__error">Напишите описание лота</span>
    </div>
	
	<?php 
		$classname = isset($form_values['path']) ? "form__item--uploaded" : "" ;
		$error_text = isset($errors['Файл']) ? $errors['Файл'] : "";
		$jpg_src = isset($form_values['path']) ? $form_values['path'] : ""; 
	  ?>
    <div class="form__item form__item--file <?=$classname?>"> <!-- form__item--uploaded -->
      <label>Изображение</label>
      <div class="preview">
        <button class="preview__remove" type="button">x</button>
        <div class="preview__img">
          <img src="<?=$jpg_src?>" width="113" height="113" alt="Изображение лота">
        </div>
      </div>
      <div class="form__input-file">
        <input class="visually-hidden" type="file" id="photo2" name="img" value="">
        <label for="photo2">
          <span>+ Добавить</span>
        </label>
      </div>
    </div>
	
	
	<?php 
		$classname = isset($errors['Начальная цена']) ? "form__item--invalid" : "";
		$error_text = isset($errors['Начальная цена']) ? $errors['Начальная цена'] : "";
		$value = isset($form_values['lot-rate']) ? $form_values['lot-rate'] : ""; 
	  ?>
    <div class="form__container-three">
      <div class="form__item form__item--small <?=$classname?> ">
        <label for="lot-rate">Начальная цена</label>
        <input id="lot-rate" type="number" name="lot-rate" placeholder="0" value="<?=$value?>" >
        <span class="form__error">Введите начальную цену</span>
      </div>
	  
	  
	  <?php 
		$classname = isset($errors['Шаг ставки']) ? "form__item--invalid" : "";
		$error_text = isset($errors['Шаг ставки']) ? $errors['Шаг ставки'] : "";
		$value = isset($form_values['lot-step']) ? $form_values['lot-step'] : ""; 
	  ?>
      <div class="form__item form__item--small <?=$classname?> ">
        <label for="lot-step">Шаг ставки</label>
        <input id="lot-step" type="number" name="lot-step" placeholder="0" value="<?=$value?>" >
        <span class="form__error">Введите шаг ставки</span>
      </div>
	  
	  
	  <?php 
		$classname = isset($errors['Дата окончания торгов']) ? "form__item--invalid" : "";
		$error_text = isset($errors['Дата окончания торгов']) ? $errors['Дата окончания торгов'] : "";
		$value = isset($form_values['lot-date']) ? $form_values['lot-date'] : ""; 
	  ?>
      <div class="form__item <?=$classname?> ">
        <label for="lot-date">Дата окончания торгов</label>
        <input class="form__input-date" id="lot-date" type="date" name="lot-date" value="<?=$value?>" >
        <span class="form__error">Введите дату завершения торгов</span>
      </div>
    </div>
	
	<?php if( isset($errors) ):  ?>
		<span class="form__error form__error--bottom">Пожалуйста, исправьте ошибки в форме.</span>
		<?php foreach( $errors as $field=>$message ) : ?>
			<span class="form__error form__error--bottom"><?=sprintf("%s %s", $field, $message)?></span>
		<? endforeach;?>
	<?php endif;?>
	
	
    <button type="submit" class="button">Добавить лот</button>
  </form>