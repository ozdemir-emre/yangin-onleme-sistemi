<!DOCTYPE html>
<html lang="tr">
<head>
  <title>Giriş</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<link href="APP/css/login.css" rel="stylesheet"/>

<body>
    <div class="container">
	<div class="screen">
		<div class="screen__content">
			<form class="login" action="" method="post" autocomplete="off">
				<div class="login__field">
					<i class="login__icon fas fa-user"></i>
					<input type="text" name="baglan[kul]" class="login__input" placeholder="Kullanıcı Adı">
				</div>
				<div class="login__field">
					<i class="login__icon fas fa-lock"></i>
					<input type="password" name="baglan[sif]" class="login__input" placeholder="Şifre">
				</div>
				<button class="button login__submit">
					<span class="button__text">Giriş Yap</span>
					<i class="button__icon fas fa-chevron-right"></i>
				</button>				
			</form>
			
		</div>
		<div class="screen__background">
			<span class="screen__background__shape screen__background__shape4"></span>
			<span class="screen__background__shape screen__background__shape3"></span>		
			<span class="screen__background__shape screen__background__shape2"></span>
			<span class="screen__background__shape screen__background__shape1"></span>
		</div>		
	</div>
</div>


<?php
if ($_POST[baglan])
{
   baglan($_POST[baglan]);
}
?>


</body>
</html>