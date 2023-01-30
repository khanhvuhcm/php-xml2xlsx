<?php

namespace Core\View;

class View
{
    // Assuming the index.php file is hosted in `public/`,
    // then the views folder would be in public/../views
    public static $viewsDir = "../app/view";


    public static function render($viewName, $vars = [])
    {
        $loader = new \Twig\Loader\FilesystemLoader(self::$viewsDir);
        $twig = new \Twig\Environment($loader, [
            'cache' => '../twig_cache',
            'auto_reload' => true // This is important!
        ]);

        return $twig->render($viewName, $vars);

    }
}