<div class="menu">
					<ul>
						<li><a href="/">�������</a></li>
						<li><a href="/about">� ���</a></li>
						<li><a href="/news">�������</a></li>
						<li><a href="/monitor">�����������</a></li>
						<li><a href="/faq">FAQ</a></li>
						<li><a href="/contacts">��������</a></li>

                        <?php

if(!$login) {
?>

	<li><a class="reg" href="/registration">�����������</a></li>
						<li><a class="reg" href="/login">�����������</a></li>
<?php
} else {

?>

<li><a class="reg" href="/deposit">�������</a></li>
						<li><a class="reg" href="/exit.php">�����</a></li>

<?php

}

?>


											</ul>
				</div>