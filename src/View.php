<?php

declare(strict_types=1);

namespace Erikgreasy\WpFramework;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class View
{
    private FilesystemLoader $loader;
    private Environment $twig;
    private static ?View $instance = null;

    private function __construct()
    {
        $this->loader = new FilesystemLoader(__DIR__ . '/../templates');

        $wpUploadDir = wp_get_upload_dir()['basedir'] . '/wp-framwork/twig';

        $this->twig = new Environment($this->loader, [
            'cache' => $wpUploadDir,
        ]);
    }

    public static function getInstance(): View
    {
        if (self::$instance == null) {
            self::$instance = new View();
        }

        return self::$instance;
    }

    /**
     * Add new template directory too look at when loading view files. The namespace
     * is recommended to use to prevent problems in the future.
     */
    public function pushTemplateDir(string $templateDirPath, ?string $namespace = null): void
    {
        if (!$namespace) {
            $namespace = FilesystemLoader::MAIN_NAMESPACE;
        }

        $this->loader->addPath($templateDirPath, $namespace);
    }

    /**
     * Output the view on the screen.
     */
    public function make(string $template, array $vars = []): void
    {
        echo $this->twig->render($template, $vars);
    }
}
