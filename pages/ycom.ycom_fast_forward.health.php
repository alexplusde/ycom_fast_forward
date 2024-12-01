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

$content .= '<div class="row">';
$content .= '<div class="col-md-3">';
$content .= '<div class="card">';
$content .= '<div class="card-header h4">Anzahl der Benutzer</div>';
$content .= '<div class="card-body">123</div>';
$content .= '</div>';
$content .= '</div>';

$content .= '<div class="col-md-3">';
$content .= '<div class="card">';
$content .= '<div class="card-header h4">Anzahl der Benutzer je Status</div>';
$content .= '<div class="card-body">Aktiv: 123<br>Inaktiv: 123<br>Gesperrt: 123</div>';
$content .= '</div>';
$content .= '</div>';

$content .= '<div class="col-md-3">';
$content .= '<div class="card">';
$content .= '<div class="card-header h4">Anzahl der Benutzer je Rolle / YCom-Gruppe</div>';
$content .= '<div class="card-body">Administrator: 123<br>Redakteur: 123<br>Autor: 123<br>Gast: 123</div>';
$content .= '</div>';
$content .= '</div>';

$content .= '<div class="col-md-3">';
$content .= '<div class="card">';
$content .= '<div class="card-header h4">Anzahl der Benutzer, die Nutzungsbedingungen akzeptiert haben</div>';
$content .= '<div class="card-body">123</div>';
$content .= '</div>';
$content .= '</div>';

$content .= '</div>';



$fragment = new rex_fragment();
$fragment->setVar('class', 'info', false);
$fragment->setVar('title', $addon->i18n('ycom_fast_forward.health.section.title'), false);
$fragment->setVar('body', $content, false);
echo $fragment->parse('core/page/section.php');
