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
  <form class="form form--add-lot container <?=$classname?>" action="add.php" method="post"> <!-- form--invalid -->
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
        <span class="form__error"><?=$error_text?></span>
      </div>
	  
	  <?php 
		$classname = isset($errors['Категория']) ? "form__item--invalid" : "";
		$error_text = isset($errors['Категория']) ? $errors['Категория'] : "";
		$value = isset($form_values['category']) ? $form_values['category'] : ""; 
	   ?>
      <div class="form__item" <?=$classname?>>
        <label for="category">Категория</label>
        <select id="category" name="category" >
			<option>Выберите категорию</option>
			<?php foreach( $categories as $category): ?>
				<option><?=$category?></option>
			<?php endforeach; ?>
		  </select>
        <span class="form__error"><?=$error_text?></span>
      </div>
    </div>
	
	<?php 
		$classname = isset($errors['Описание']) ? "form__item--invalid" : "";
		$error_text = isset($errors['Описание']) ? $errors['Описание'] : "";
		$value = isset($form_values['message']) ? $form_values['message'] : ""; 
	  ?>
    <div class="form__item form__item--wide <?=$classname?>">
      <label for="message">Описание</label>
      <textarea id="message" name="message" placeholder="Напишите описание лота" ></textarea>
      <span class="form__error"><?$error_text?></span>
    </div>
	
	<?php 
		$classname = isset($form_values['path']) ? "form__item--uploaded" : "" ;
		$error_text = isset($errors['Файл']) ? $errors['Файл'] : "";
		$gif_src = isset($form_values['message']) ? $form_values['message'] : ""; 
	  ?>
    <div class="form__item form__item--file <?=$classname?>"> <!-- form__item--uploaded -->
      <label>Изображение</label>
      <div class="preview">
        <button class="preview__remove" type="button">x</button>
        <div class="preview__img">
          <img src="<?$gif_src?>" width="113" height="113" alt="Изображение лота">
        </div>
      </div>
      <div class="form__input-file">
        <input class="visually-hidden" type="file" id="photo2" name="gif_img" value="">
        <label for="photo2">
          <span>+ Добавить</span>
        </label>
      </div>
    </div>
	
    <div class="form__container-three">
      <div class="form__item form__item--small">
        <label for="lot-rate">Начальная цена</label>
        <input id="lot-rate" type="number" name="lot-rate" placeholder="0" >
        <span class="form__error">Введите начальную цену</span>
      </div>
	  
      <div class="form__item form__item--small">
        <label for="lot-step">Шаг ставки</label>
        <input id="lot-step" type="number" name="lot-step" placeholder="0" >
        <span class="form__error">Введите шаг ставки</span>
      </div>
	  
      <div class="form__item">
        <label for="lot-date">Дата окончания торгов</label>
        <input class="form__input-date" id="lot-date" type="date" name="lot-date" >
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