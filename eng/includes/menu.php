<div class="menu">
					<ul>
						<li><a href="/">Главная</a></li>
						<li><a href="/about">О Нас</a></li>
						<li><a href="/news">Новости</a></li>
						<li><a href="/monitor">Мониторинги</a></li>
						<li><a href="/faq">FAQ</a></li>
						<li><a href="/contacts">Контакты</a></li>

                        <?php

if(!$login) {
?>

	<li><a class="reg" href="/registration">Регистрация</a></li>
						<li><a class="reg" href="/login">Авторизация</a></li>
<?php
} else {

?>

<li><a class="reg" href="/deposit">Кабинет</a></li>
						<li><a class="reg" href="/exit.php">Выход</a></li>

<?php

}

?>


											</ul>
				</div>