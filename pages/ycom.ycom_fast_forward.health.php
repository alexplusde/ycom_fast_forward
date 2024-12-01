<?php

$addon = rex_addon::get('ycom_fast_forward');

/* Titel ausgeben */
echo rex_view::title(rex_i18n::msg('ycom_fast_forward.title'));

// To-Do: Status-Bericht über YCom-Benutzer-Datenbank
// 1. Anzahl der Benutzer
// 2. Anzahl der Benutzer je Status (aktiv, inaktiv, gesperrt)
// 3. Anzahl der Benutzer je Rolle / YCom-Gruppe (z.B. Administrator, Redakteur, Autor, Gast)
// 4. Anzahl der Benutzer, die Nutzungsbedingungen akzeptiert haben

$content = '';

$total_ycom_user = rex_ycom_user::query()->find()->count();

$content .= '<div class="row">';
$content .= '<div class="col-md-2">';
$content .= '<div class="card">';
$content .= '<div class="card-header h4">Benutzer insgesamt</div>';
$content .= '<div class="card-body"><span class="h1">'.$total_ycom_user.'</span></div>';
$content .= '</div>';
$content .= '</div>';

$status_options = explode(",",'translate:ycom_account_inactive_termination=-3,translate:ycom_account_inactive_logins=-2,translate:ycom_account_inactive=-1,translate:ycom_account_requested=0,translate:ycom_account_confirm=1,translate:ycom_account_active=2');

$status = [];
foreach ($status_options as $option) {
    $option = explode('=', $option);
    $label = substr($option[0], 10);
    $status[$option[1]] = rex_i18n::msg($label);
    $status[$option[1]] .= ': '.rex_ycom_user::query()->where('status', $option[1])->count();
}
$status_string = implode('<br>', $status);

$content .= '<div class="col-md-4">';
$content .= '<div class="card">';
$content .= '<div class="card-header h4">Benutzer je Status</div>';
$content .= '<div class="card-body">'.$status_string.'</div>';
$content .= '</div>';
$content .= '</div>';

$groups = rex_ycom_group::query()->find();
$group_count = [];
foreach ($groups as $group) {
    $group_count[$group->getName()] = rex_ycom_user::query()->where('ycom_groups', $group->getId())->count();
}
$group_string = '';
foreach ($group_count as $group_name => $count) {
    $group_string .= $group_name.': '.$count.'<br>';
}

$content .= '<div class="col-md-3">';
$content .= '<div class="card">';
$content .= '<div class="card-header h4">Benutzer je Rolle / YCom-Gruppe</div>';
$content .= '<div class="card-body">'.$group_string.'</div>';
$content .= '</div>';
$content .= '</div>';

$total_ycom_user_accepted_terms = rex_ycom_user::query()->where('termsofuse_accepted', 1)->count();

$content .= '<div class="col-md-3">';
$content .= '<div class="card">';
$content .= '<div class="card-header h4">Nutzungsbedingungen akzeptiert</div>';
$content .= '<div class="card-body">'.$total_ycom_user_accepted_terms.'</div>';
$content .= '</div>';
$content .= '</div>';

$content .= '</div>';



$fragment = new rex_fragment();
$fragment->setVar('class', 'info', false);
$fragment->setVar('title', $addon->i18n('ycom_fast_forward.health.section.title'), false);
$fragment->setVar('body', $content, false);
echo $fragment->parse('core/page/section.php');
