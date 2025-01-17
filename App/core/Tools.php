<?php

declare(strict_types=1);

namespace App\core;

use Exception;
use PDO;

class Tools
{
    static function displayTemplates(string $template): string
    {
        ob_start();
        require(DIR_TEMPLATES . $template);
        return ob_get_clean();
    }

    /**
     * @return string
     * @throws Exception controleur absent
     */
    static function getControllerByPath(string $path): string
    {
        foreach (ROUTES as $route) {
            if ($route['path'] === ($path ?? '/')) {
                return $route['controller'];
            }
        }
        throw new Exception('Controleur non trouvé');
    }

    static function getControllerByServerPath(): string
    {
        foreach (ROUTES as $route) {
            if ($route['path'] === ($_SERVER['PATH_INFO'] ?? '/')) {
                return $route['controller'];
            }
        }
        throw new Exception('Controleur non trouvé');
    }

    static function getLink($path): string
    {
        foreach (ROUTES as $route) {
            if ($route['path'] === $path) {
                return '<a href=\'' . $route['path'] . '\'>' . $route['label'] . '</a>';
            }
        }
        throw new Exception('Controleur non trouvé');
    }

    static function getMenu(): void
    {
        echo '<div>';
        foreach (ROUTES as $route) {
            if ($route['isMenuItem']) {
                echo self::getLink($route['path']);
            }
        }
        echo '</div>';
    }

    static function getPDO() : PDO {
        $pdo = new PDO('mysql:host=localhost;port=3306;dbname=hanged', 'root', '');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        return $pdo;
    }
}