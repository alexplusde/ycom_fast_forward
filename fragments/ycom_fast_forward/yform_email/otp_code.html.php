<?php

/** @var rex_fragment $this */

$clang_id = rex_clang::getCurrentId();

?>
<p>Ihr Einmal-Passwort lautet: <?php echo $this->getVar('otp_code'); ?></p>
