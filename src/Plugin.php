<?php

declare(strict_types=1);

namespace Erikgreasy\WpFramework;

abstract class Plugin
{
    protected string $templateDirName = '/templates';
    protected string $tempalteDir;

    public function __construct()
    {
        $rc = new \ReflectionClass(get_class($this));

        $this->templateDir = dirname($rc->getFileName()) . $this->templateDirName;

        $view = View::getInstance();
        $view->pushTemplateDir($this->templateDir, $rc->getShortName());
    }
}
