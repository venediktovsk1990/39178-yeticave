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
	<form class="form container  <?=$classname?>" action="login.php" method="post" > <!-- form--invalid -->
		<h2>Вход</h2>

		<?php
			$classname = isset($errors['Ваш email']) ? "form__item--invalid" : "";
			$error_text = isset($errors['Ваш email']) ? $errors['Ваш email'] : "";
			$value = isset($form_data['email']) ? $form_data['email'] : "";
		?>
		<div class="form__item  <?=$classname?>"> <!-- form__item--invalid -->
		  <label for="email">E-mail*</label>
		  <input id="email" type="text" name="email" placeholder="Введите e-mail" value="<?=$value?>">
		  <span class="form__error"><?=$error_text?></span>
		</div>

		<?php
			$classname = isset($errors['Пароль']) ? "form__item--invalid" : "";
			$error_text = isset($errors['Пароль']) ? $errors['Пароль'] : "";
			$value = isset($form_data['password']) ? $form_data['password'] : "";
		?>
		<div class="form__item form__item--last <?=$classname?>">
		  <label for="password">Пароль*</label>
		  <input id="password" type="password" name="password" placeholder="Введите пароль" autocomplete="off" value="<?=$value?>">
		  <span class="form__error"><?=$error_text?></span>
		</div>
		<button type="submit" class="button">Войти</button>
  </form>
