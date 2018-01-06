 <nav class="nav">
    <ul class="nav__list container">
			<?php foreach( $categories as $category): ?>
					<li class="nav__item">
					<a href=""><?=$category['title']?></a>
					</li>
			<?php endforeach; ?>
	</ul>
  </nav>

  <?php
		$classname = isset($errors) ? "form--invalid" : "";
	?>
<form class="form container <?=$classname?>" action="sign-up.php" method="post" enctype="multipart/form-data" > <!-- form--invalid -->
    <h2>Регистрация нового аккаунта</h2>

	<?php
		$classname = isset($errors['email']) ? "form__item--invalid" : "";
		$value = isset($formValues['email']) ? $formValues['email'] : "";
	?>
    <div class="form__item" <?=$classname ?>> <!-- form__item--invalid -->
      <label for="email">E-mail*</label>
      <input id="email" type="text" name="email" placeholder="Введите e-mail" value="<?=$value ?>" >
      <span class="form__error">Введите e-mail</span>
    </div>

	<?php
		$classname = isset($errors['Пароль']) ? "form__item--invalid" : "";
		$value = isset($formValues['password']) ? $formValues['password'] : "";
	?>

    <div class="form__item" <?=$classname ?>>
      <label for="password">Пароль*</label>
      <input id="password" type="password" autocomplete="off" name="password" placeholder="Введите пароль" value="<?=$value ?>" >
      <span class="form__error">Введите пароль</span>
    </div>

	 <?php
  		$classname = isset($errors['Имя']) ? "form__item--invalid" : "";
  		$value = isset($formValues['name']) ? $formValues['name'] : "";
	  ?>

    <div class="form__item <?=$classname ?>">
      <label for="name">Имя*</label>
      <input id="name" type="text" name="name" placeholder="Введите имя" value="<?=$value ?>">
      <span class="form__error">Введите имя</span>
    </div>

	 <?php
  		$classname = isset($errors['Контактные данные']) ? "form__item--invalid" : "";
  		$value = isset($formValues['message']) ? $formValues['message'] : "";
	  ?>
    <div class="form__item <?=$classname ?>">
      <label for="message">Контактные данные*</label>
      <textarea id="message" name="message" placeholder="Напишите как с вами связаться" ><?=$value ?></textarea>
      <span class="form__error">Напишите как с вами связаться</span>
    </div>

	<?php
  		//$classname = isset($errors['Контактные данные']) ? "form__item--invalid" : "";
      $classname = isset($formValues['path']) ? "form__item--uploaded" : "" ;
  		$imgSrc = isset($formValues['path']) ? $formValues['path'] : "";
	  ?>
    <div class="form__item form__item--file form__item--last <?=$classname ?>">
      <label>Аватар</label>
      <div class="preview">
        <button class="preview__remove" type="button">x</button>
        <div class="preview__img">
          <img src="<?=$imgSrc ?>" width="113" height="113" alt="Ваш аватар">
        </div>
      </div>

      <div class="form__input-file">
	  <input type="hidden" name="MAX_FILE_SIZE" value="3000000" />
        <input class="visually-hidden" type="file" id="photo2" name="photo2" value="">
        <label for="photo2">
          <span>+ Добавить</span>
        </label>
      </div>
    </div>

    <span class="form__error form__error--bottom">Пожалуйста, исправьте ошибки в форме.<br>
      <?php if( isset( $errors ) ):  ?>
           <?php foreach( $errors as $field=>$message): ?>

              <?=sprintf("<br>%s %s", $field, $message)?>

            <? endforeach; ?>
      <? endif; ?>
    </span>



    <button type="submit" class="button">Зарегистрироваться</button>
    <a class="text-link" href="#">Уже есть аккаунт</a>
  </form>
