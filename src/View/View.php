<?php

namespace Bitrock\View;
use Bitrock\LetsEnv;
use Bitrock\Models\Singleton;

class View extends Singleton
{
    public CONST VIEW_DIR = 'VIEW_DIR';

    /**
     * @param string $viewName - название view
     * @param array $params - массив значений, которые будут преобразованы в переменные
     */
    public function render(string $viewName, $params = []): string
    {
        if (empty($viewName)) return false;

        if (!empty($params)) extract($params);
        ob_start();
        require(LetsEnv::getInstance()->getEnv(static::VIEW_DIR) . $viewName);
        return ob_get_clean();
    }

    public static function preHook()
    {
        $letsEnv = LetsEnv::getInstance();
        return !empty($letsEnv->getEnv(static::VIEW_DIR))
            && is_dir($letsEnv->getEnv(static::VIEW_DIR));
    }
}