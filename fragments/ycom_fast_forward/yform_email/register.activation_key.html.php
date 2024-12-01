<?php

/** @var rex_fragment $this */

$clang_id = rex_clang::getCurrentId();

$activation_key = $this->getVar('activation_key');
$email = $this->getVar('email');
$confirm_article_id = 999; // Hier die Artikel-ID der Bestätigungsseite eintragen
$confirm_url = rex_getUrl($confirm_article_id,'',array('rex_ycom_activation_key'=>$activation_key,'rex_ycom_id'=>$email));
?>

<h1>Bitte bestätigen Sie Ihre E-Mail-Adresse</h1>

<p>Bitte klicken Sie diesen Link, um die Anmeldung zu bestätigen:</p>

<a class="btn" href="<?php echo $confirm_url; ?>"><?php echo $confirm_url; ?></a>
