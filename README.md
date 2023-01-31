# Requirements
1. PHP version 7.4
2. Composer
3. Php GD extension
4. Php ZIP extension

# Setup & run
1. Clone the repo
2. Go to working directory
2. run `sh setup.sh` to install php GD, php ZIP and composer install, and start the server at http://localhost:8000
# Usage
- Command for start the server: `php -S localhost:8000 -t public`
- `public/index.php` is the entry point for the app. All requests are sent here.
- Routes are registered in `app/routes.php`, the router takes care of assigning different actions for each route.
- Controllers are placed in `app/controller/`.
- Models are places in `app/model/`.
- Views are stored in `app/view/` and are rendered with the [Twig template engine.](https://twig.symfony.com/doc/3.x/)

- You may use `DB::query()` to make secure queries to the DB after you call `DB::connect()`

- Sample input (xml file) and output (xlsx file) are in `public/download`