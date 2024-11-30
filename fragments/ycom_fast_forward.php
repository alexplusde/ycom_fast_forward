<?php

/** @var rex_fragment $this */
$fragment_file = $this->getVar('file');

$fragment_path = rex_path::addon('ycom_fast_forward', 'fragments/ycom_fast_forward/' . $fragment_file);

if (file_exists($fragment_path)) {

    echo $this->subfragment($fragment_path);
}
