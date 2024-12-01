<?php
/** @var rex_fragment $this */

use Alexplusde\YComFastForward\YComFastForward;

?>
<?= rex::getServerName() ?>

<?= $this->subfragment('ycom_fast_forward/yform_email/' . $this->getVar('file', '')) ?>

<?= YComFastForward::getEmailFooter() ?>
