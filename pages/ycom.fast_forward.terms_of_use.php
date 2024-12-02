<?php

use Alexplusde\YComFastForward\YComFastForward;

echo rex_view::title(rex_i18n::msg('ycom_fast_forward.title'));

$addon = rex_addon::get('ycom_fast_forward');

if(rex_post('reset', 'string') == 'reset') {
    YComFastForward::resetYComUserTermsOfUseAccepted();
    echo rex_view::success($addon->i18n('ycom_fast_forward.terms_of_use.reset_success'));
}

/** Bootstrap 3 Anker als Button */
$content = '
<p>' . $addon->i18n('ycom_fast_forward.terms_of_use.reset_info') . '</p>
<a href="' . rex_getUrl(rex_article::getCurrentId(), rex_clang::getCurrentId(), ['func' => 'edit', 'page' => 'ycom_fast_forward/terms_of_use']) . '" class="btn btn-danger">' . $addon->i18n('ycom_fast_forward.terms_of_use.reset_button') . '</a>';



$fragment = new rex_fragment();
$fragment->setVar('class', 'danger', false);
$fragment->setVar('title', $addon->i18n('ycom_fast_forward.terms_of_use.section.title'), false);
$fragment->setVar('body', $content, false);
echo $fragment->parse('core/page/section.php');
