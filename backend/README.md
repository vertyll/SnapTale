# SnapTale-API
## Link: https://snaptale.vertyll.usermd.net/

## Założenia projektu 

Aplikacja internetowa, jest to API dla aplikacji SnapTale

## Stos technologiczny

### Back-end:
- Laravel
- PHP
- MySQL

### Uwierzytelnianie:
- uwierzytelnianie za pomocą sesji

### Inne:
- Laravel Sanctum jako system do uwierzytelniania

### Dodatkowe narzędzia:
- intervention/image jako biblioteka przetwarzania obrazów PHP

## Zdjęcia poglądowe aplikacji SnapTale korzystającej z tego API

![Widok projektu](https://raw.githubusercontent.com/vertyll/SnapTale/main/screenshots/snaptale4.png)
![Widok projektu](https://raw.githubusercontent.com/vertyll/SnapTale/main/screenshots/snaptale2.png)
![Widok projektu](https://raw.githubusercontent.com/vertyll/SnapTale/main/screenshots/snaptale5.png)
![Widok projektu](https://raw.githubusercontent.com/vertyll/SnapTale/main/screenshots/snaptale1.png)
![Widok projektu](https://raw.githubusercontent.com/vertyll/SnapTale/main/screenshots/snaptale3.png)

## Informacje dodatkowe

Aplikacja łączy się z aplikacją SnapTale, która również jest dostępna w repozytrium na GitHub.

## Instrukcja instalacji projektu

Pobieramy projekt na lokalne środowisko

Instalujemy zależności:

```bash
composer install 

cp .env.example .env 

php artisan cache:clear

composer dump-autoload

php artisan key:generate

composer require laravel/breeze --dev

php artisan serve
```

Tworzymy bazę danych. Upewniamy się że DB_DATABASE w pliku .env jest taka sama i uruchamiamy migrację

```bash
php artisan migrate
```
