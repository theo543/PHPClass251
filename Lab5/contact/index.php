<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<title>Formular contact</title>
	<script src="https://www.google.com/recaptcha/api.js" async defer></script>
	<link rel="stylesheet" href="style.css">
</head>

<body>
	<div class="content">
		<h1>Formular contact</h1>
		<p>Te rugam sa ne transmiti informatiile de mai jos:</p>
		<div id="message">
			<form action="verify_recaptcha.php" method="post">
				<label>
					Nume:
					<input type="text" id="name" name="name" class="required" aria-required="true" required>
				</label>
				<label>
					Email:
					<input type="text" id="email" name="email" class="required email" aria-required="true" required>
				</label>
				<label>
					Telefon:
					<input type="text" id="phone" name="phone" class="required phone" aria-required="true" required>
				</label>
				<label>
					Mesaj:
					<textarea id="comment-content" name="content"></textarea>
				</label>
				<div class="g-recaptcha" <?php { require(dirname(__FILE__) . "/recaptcha_keys.secret.php"); echo "data-sitekey=" . $RECAPTCHA_SITE_KEY; } ?>></div>
				<button class="btn btn-info" type="submit" name="submit">
					SUBMIT
				</button>
			</form>
		</div>
	</div>
</body>

</html>