<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
class Icarus_Assets
{
    private static $_assetsBaseUrl;
    private static $_thirdPartySolution = array();
    private static $_availableSolutionName = array('Assets_JsDelivr', 'Assets_Custom');
    public static function init()
    {
        self::$_assetsBaseUrl = Typecho_Common::url('assets', Icarus_Util::$options->themeUrl);

        // dummy
        $defaultSolutionName = 'Assets_JsDelivr';
        self::loadThirdPartySolution($defaultSolutionName); 
        
        // dummy
        $overrideSolutionName = 'Assets_Custom';
        self::loadThirdPartySolution($overrideSolutionName); 
        
    }

    private static function loadThirdPartySolution($name)
    {
        if (!in_array($name, self::$_availableSolutionName))
            return;
        
        $solutionConfigFile = __ICARUS_ROOT__ . 'library/ThirdPartySolution/' . $name . '.php';
        if (file_exists($solutionConfigFile))
        {
            $solution = require $solutionConfigFile;
            self::$_thirdPartySolution = array_merge(self::$_thirdPartySolution, $solution);
        }
    }

    public static function getUrlForAssets($path)
    {
        if (Icarus_Util::isUrl($path))
            return $path;
        return Typecho_Common::url($path, self::$_assetsBaseUrl);
    }

    public static function printCssTag($cssUrl)
    {
        echo '<link rel="stylesheet" href="', $cssUrl , '" />', PHP_EOL;
    }

    public static function printJsTag($jsUrl, $defer = false)
    {
        if ($defer)
            echo '<script src="', $jsUrl, '"></script>', PHP_EOL;
        else
            echo '<script src="', $jsUrl, '" defer></script>', PHP_EOL;
    }

    public static function printThemeCss($name)
    {
        self::printCssTag(self::getUrlForAssets("css/" . $name));
    }

    public static function printThemeJs($name, $defer = false)
    {
        self::printJsTag(self::getUrlForAssets("js/" . $name), $defer);
    }
    
    public static function printThirdPartyCss($name)
    {
        if (array_key_exists($name, self::$_thirdPartySolution))
            self::printCssTag(self::$_thirdPartySolution[$name]);
    }

    public static function printThirdPartyJs($name, $defer = false)
    {
        if (array_key_exists($name, self::$_thirdPartySolution))
            self::printJsTag(self::$_thirdPartySolution[$name], $defer);
    }
}