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

Nach der Installation stehen folgende Optionen in den Einstellungen zur Verfügung:

1. Das Addon kommt mit passenden Formular-Fragmenten in PHP-Schreibweise.
2. Eine zusätzliche Backend-Einstellungsseite ermöglicht bspw. das Hinzufügen von Nutzungsbedingungen.

## Einstellungen

### Theme

Objektparameter für die YForm-Formulare, standardmäßig `bootstrap5,bootstrap`.

> Tipp: Nutze ein eigenes bootstrap5-Theme, um Bootstrap 5 zu verwenden.

### Nutzungsbedingungen

Hier können die Nutzungsbedingungen für die Registrierung und das Profil hinterlegt werden.

## Fragmente

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

Die Fragmente können beliebig abgewandelt werden, z. B. im eigenen Fragmente-Ordner des `project`-Addons.

Kopiere dazu die Module von `src/addons/ycom_fast_forward/fragments/ycom_fast_forward` nach `src/addons/project/fragments/ycom_fast_forward` und passe sie dort an.

## Autor

[Alexander Walther](https://github.com/alexplusde)

## Lizenz

MIT-License
