# YCom Fast Forward für REDAXO 5

Das Addon liefert passende Fragmente für alle benötigten YCom-Funktionen sowie ein Modul. Es erstellt benötigte Kategorien und Artikel mit den empfohlenen Berechtigungen.

> **Achtung:** Es wird empfohlen, das Addon nicht bei bestehenden Projekten installieren, da es Konfigurationen überschreibt und neue Kategorien und Artikel anlegt.

## Installation

Bei der Installation über den REDAXO Installer werden folgende Schritte durchgeführt:

1. Modul "YCom Fast Forward" anlegen
2. Kategorie "Login" anlegen, mit den Artikeln "Login" und "Passwort vergessen"
3. Kategorie "Logout" anlegen
4. Modul "YCom Fast Forward" wird als Block den entsprechenden Kategorien und Artikeln hinzugefügt
5. Konfiguration der YCom-Einstellungen passend zu den erstellten Kategorien und Artikeln
6. Installation von passenden E-Mail-Templates
7. Es wird das Feld `lastname` in der Tabelle `rex_ycom_user` hinzugefügt (wird benötigt)

Die Struktur der Artikel sieht wie folgt aus:

```plaintext
Login
  - Login
  - Passwort vergessen
Mein Profil
    - Profil
    - Passwort ändern
    - 2FA
    - Nutzungsbedingungen
Logout
```

### Berechtigungen

Kategorien und Artikeln werden die empfohlenen / Benötigten Berechtigungen zugewiesen:

* Login: Für alle **nicht** eingeloggten Nutzer, egal welche Gruppe
* Logout: Für alle eingeloggten Nutzer, egal welche Gruppe
* OTP: Für alle eingeloggten Nutzer, egal welche Gruppe
* Profile: Für alle eingeloggten Nutzer, egal welche Gruppe
* Registrierung: Für alle **nicht** eingeloggten Nutzer
* Passwort vergessen (Formular): Für alle **nicht** eingeloggten Nutzer
* Passwort ändern: Für alle eingeloggten Nutzer, egal welche Gruppe
* Nutzungsbedingungen: Für alle eingeloggten Nutzer, egal welche Gruppe
* Gesperrter Artikel: Für alle eingeloggten Nutzer, egal welche Gruppe (wenn du eingeloggt bist, jedoch nicht die passenden Gruppenrechte hast)

### Module

Es wird ein Modul installiert, das das jeweilige Fragment lädt.

Jeder Block verfügt über eine Eingabe für Überschrift + Beschreibung zusätzlich zum jeweiligen YCom-Formular.

## Fragmente

Nach der Installation stehen folgende Optionen in den Einstellungen zur Verfügung:

1. Das Addon kommt mit passenden Formular-Fragmenten in PHP-Schreibweise.
2. Eine zusätzliche Backend-Einstellungsseite ermöglicht bspw. das Hinzufügen von Nutzungsbedingungen.

| Fragment | Beschreibung |
| --- | --- |
| `login.php` | Formular für den Login |
| `logout.php` | Formular für den Logout |
| `password-2fa-check.php` | Formular für die Überprüfung des Passworts und der 2FA |
| `password-2fa-setup.php` | Formular für die Einrichtung der 2FA |
| `password-change.php` | Formular für die Passwortänderung |
| `password-reset.php` | Formular für das Zurücksetzen des Passworts |
| `profile.php` | Formular für das Bearbeiten des eigenen Profils |
| `register.php` | Formular für die Registrierung |
| `terms_of_use.php` | Formular für die Nutzungsbedingungen |

### Fragmente überschrieben

Die Fragmente können beliebig abgewandelt werden, z. B. im eigenen Fragmente-Ordner des `project`-Addons.

Kopiere dazu die Module von `src/addons/ycom_fast_forward/fragments/ycom_fast_forward` nach `src/addons/project/fragments/ycom_fast_forward` und passe sie dort an.

## Einstellungen

Im REDAXO-Backend stehen folgende Einstellungen zur Verfügung:

| Einstellung                         | Einstellungsschlüssel          | Beschreibung                                                                   |
|-------------------------------------|--------------------------------|--------------------------------------------------------------------------------|
| Standard-Status für neue Nutzer     | `ycom_user_default_status`     | Auswahl des Standard-Status für neue Nutzer                                    |
| YForm Theme                         | `yform_theme`                  | Textfeld zur Eingabe des Objparams für das gewünschte YForm Theme              |
| Nutzungsbedingungen erforderlich    | `terms_of_use_required`        | Auswahl, ob Nutzungsbedingungen zugestimmt werden muss oder nicht              |
| Standard YCom Gruppe bei Registrierung | `default_ycom_group_id`     | Auswahl der passenden YCom-Gruppe bei Registrierung                            |
| Passwortregeln                      | `password_rules`               | Textfeld zur Eingabe der Passwortregeln                                        |
| Nutzungsbedingungen                 | `terms_of_use`                 | Textfeld zur Eingabe der Nutzungsbedingungen                                   |
| WYSIWYG-Editor-Attribute            | `editor`                       | WYSIWYG-Editor-Attribute für die Nutzungsbedingungen                           |
| Mailer-Profil                       | `mailer_profile_id`            | Auswahl des gewünschten Mailer-Profils, wenn das Addon installiert ist         |

## E-Mail-Templates

Das Addon enthält auch E-Mail-Templates, die für die Registrierung, das Zurücksetzen des Passworts und die 2FA verwendet werden.

| Template | Aufgabe / Zweck |
| --- | --- |
| `ycom_fast_forward.access_request` | E-Mail für das Zurücksetzen des Passworts |
| `ycom_fast_forward.access_request` | E-Mail für die Registrierung |
| `ycom_otp_code_template` | E-Mail für die 2FA |

## Einwilligung Nutzungsbedingungen an YCom-Benutzern zurücksetzen

Wenn du die Nutzungsbedingungen änderst, kannst du die Einwilligung der Nutzungsbedingungen für alle Benutzer mit einem Klick zurücksetzen. Alle Nutzer müssen dann erneut den Nutzungsbedingungen zustimmen.

![blaupause test_redaxo_index php_page=ycom_ycom_fast_forward_terms_of_use (2)](https://github.com/user-attachments/assets/4cf968e0-caa4-429b-8b17-d30ddfff646c)

## Health-Seite

Das Addon enthält eine Health-Seite, die die Installation überprüft und bei Bedarf Warnungen ausgibt.

Aktuell werden folgende Informationen ausgegeben:

1. Anzahl der YCom-Benutzer
2. Anzahl Benutzer je YCom-Gruppe
3. Anzahl der Benutzer je Status (aktiv, inaktiv, gesperrt)

Weitere nützliche Prüfungen sind gerne gesehen und willkommen.

![blaupause test_redaxo_index php_page=ycom_ycom_fast_forward_health (1)](https://github.com/user-attachments/assets/494efba7-a231-4fd1-8659-a0b3a33acc75)

## Login-Token-Management

YCom kennnt standardmäßig den Activation Key, um sich direkt einloggen zu können. Diese Funktion kann hilfreich sein, um einen direkten Login per Mail zu ermöglichen, ohne dass der Benutzer ein Passwort eingeben muss.

Allerdings kann YCom nicht mehr als einen Activation Key speichern. Auch werden die Aktivierungsschlüssel nach Verwendung nicht automatisch invalidiert.

YCom Fast Forward bietet eine Möglichkeit, eigene Login-Token zu verwalten. Es können beliebig viele Login-Token erstellt und gelöscht werden. Nutzer sind nach der Verwendung des Login-Token automatisch eingeloggt.

### Schlüssel erstellen

```php

// Login-Token erstellen

use Alexplusde\YComFastForward\LoginToken;

$loginToken = LoginToken::create($userId);
```

### Nutzer einloggen

```php

use Alexplusde\YComFastForward\LoginToken;

$loginToken = LoginToken::getByKey($key);

if ($loginToken) {
    $loginToken->login(); // Leitet den Benutzer weiter zur definierten YCom-Seite
}
```

### Multi-Login (Konzeptionsphase)

YCom Fast Forward bietet auch die Möglichkeit, mehrere Login-Token für einen Benutzer zu erstellen, wenn dieser in mehreren Domains derselben REDAXO-Installation eingeloggt sein soll.

Folgender Prozess wird dabei ausgelöst:

1. Der Nutzer loggt sich erfolgreich auf Domain A ein.
2. Nach erfolgreichem Login wird einmalig ein API-Aufruf per JavaScript ausgelöst, der einen Login-Token für Domain B bis X erstellt.
3. Das JavaScript ruft die API auf Domain B bis X auf und verwendet dabei die generierten Login-Token.
4. Der Nutzer wird dadurch auf Domain B bis X eingeloggt, ohne ein Passwort eingeben zu müssen.

To-Do: Ein Logout auf einer beliebigen Domain soll ebenfalls alle anderen Domains ausloggen.

## Autor

[Alexander Walther](https://github.com/alexplusde)

## Lizenz

MIT-License
