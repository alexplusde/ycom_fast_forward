<?php

echo rex_view::title(rex_i18n::msg('ycom_fast_forward.title'));

$file = rex_file::get($this->getPath('README.md'));

$parsedown = new Parsedown();
$content = $parsedown->text($file);

$fragment = new rex_fragment();
$fragment->setVar('content', $content, false);
$content = $fragment->parse('core/page/docs.php');

$fragment = new rex_fragment();
$fragment->setVar('title', "Dokumentation");
$fragment->setVar('body', $content, false);
echo $fragment->parse('core/page/section.php');
