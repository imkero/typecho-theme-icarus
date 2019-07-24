<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
class Icarus_Assets
{
    private static $_assetsBaseUrl;
    private static $_cdnProviders = array(
        'assets' => array(
            'jsdelivr' => array(
                '_tpl' => 'https://cdn.jsdelivr.net/npm/{package}@{version}/{file}',
                '_alias' => array(
                    'pace' => 'pace-js',
                    'clipboard.js' => 'clipboard',
                    'moment.js' => 'moment',
                    'outdated-browser' => 'outdatedbrowser'
                ),
                'highlight.js' => 'https://cdn.jsdelivr.net/gh/highlightjs/cdn-release@{version}/build/{file}',
                'lightgallery' => 'https://cdn.jsdelivr.net/npm/{package}@{version}/dist/{file}',
                'justifiedGallery' => 'https://cdn.jsdelivr.net/npm/{package}@{version}/dist/{file}',
                'clipboard' => 'https://cdn.jsdelivr.net/npm/{package}@{version}/dist/{file}',
                'jquery' => 'https://cdn.jsdelivr.net/npm/{package}@{version}/dist/{file}',
                'mathjax' => 'https://cdn.jsdelivr.net/npm/{package}@{version}/unpacked/{file}',
                'outdatedbrowser' => 'https://cdn.jsdelivr.net/npm/{package}@{version}/outdatedbrowser/{file}',
                'moment' => 'https://cdn.jsdelivr.net/npm/{package}@{version}/min/{file}',
            ),
            'cdnjs' => array(
                '_tpl' => 'https://cdnjs.cloudflare.com/ajax/libs/{package}/{version}/{file}',
            ),
            'loli' => array(
                '_tpl' => 'https://cdnjs.loli.net/ajax/libs/{package}/{version}/{file}',
            ),
        ),
        'icon' => array(
            'fontawesome' => 'https://use.fontawesome.com/releases/v5.4.1/css/all.css',
            'jsdelivr' => 'https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@5.4.1/css/all.min.css',
            'cdnjs' => 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.4.1/css/all.min.css', 
            'loli' => 'https://cdnjs.loli.net/ajax/libs/font-awesome/5.4.1/css/all.min.css',
        ),
        'font' => array(
            'google' => 'https://fonts.googleapis.com/{type}?family={fontname}',
            'loli' => 'https://fonts.loli.net/{type}?family={fontname}',
        ),
        'gravatar' => array(
            'gravatar' => 'https://secure.gravatar.com/avatar',
            'v2ex' => 'https://cdn.v2ex.com/gravatar',
            'loli' => 'https://gravatar.loli.net/avatar',
        ),
    );
    private static $_assetsCdnUrl = array();

    const DEFAULT_ASSETS_CDN = 'jsdelivr';
    const DEFAULT_ICON_CDN = 'fontawesome';
    const DEFAULT_FONT_CDN = 'google';
    const DEFAULT_GRAVATAR_CDN = 'gravatar';

    public static function config($form)
    {
        $form->packTitle('Assets');
        $form->packInput('Assets/theme_assets_base', '');
        $form->packRadio('Assets/public_assets', array_keys(self::$_cdnProviders['assets']), self::DEFAULT_ASSETS_CDN);
        $form->packRadio('Assets/public_icon', array_keys(self::$_cdnProviders['icon']), self::DEFAULT_ICON_CDN);
        $form->packRadio('Assets/public_font', array_keys(self::$_cdnProviders['font']), self::DEFAULT_FONT_CDN);
        $form->packRadio('Assets/public_gravatar', array_keys(self::$_cdnProviders['gravatar']), self::DEFAULT_GRAVATAR_CDN);
    }

    public static function init()
    {
        self::$_assetsBaseUrl = Icarus_Config::get(
            'assets_theme_assets_base',
            Typecho_Common::url('assets', Icarus_Util::$options->themeUrl)
        );  

        self::loadAssetsCDNConfig(
            'assets', 
            Icarus_Config::get('assets_public_assets'), 
            self::DEFAULT_ASSETS_CDN
        );
        self::loadAssetsCDNConfig(
            'icon', 
            Icarus_Config::get('assets_public_icon'), 
            self::DEFAULT_ICON_CDN
        );
        self::loadAssetsCDNConfig(
            'font', 
            Icarus_Config::get('assets_public_font'), 
            self::DEFAULT_FONT_CDN
        );
        self::loadAssetsCDNConfig(
            'gravatar', 
            Icarus_Config::get('assets_public_gravatar'), 
            self::DEFAULT_GRAVATAR_CDN
        );
    }

    private static function loadAssetsCDNConfig($type, $cdnName, $defaultCDNName)
    {
        if (!array_key_exists($type, self::$_cdnProviders))
            return;

        $cdn = self::$_cdnProviders[$type];

        if (is_null($cdnName) || !array_key_exists($cdnName, $cdn))
            $cdnName = $defaultCDNName;

        self::$_assetsCdnUrl = array_merge(
            self::$_assetsCdnUrl, 
            is_array($cdn[$cdnName]) ? $cdn[$cdnName] : array($type => $cdn[$cdnName]));
    }

    public static function getUrlForAssets($path)
    {
        if (Icarus_Util::isUrl($path))
            return $path;
        return Typecho_Common::url($path, self::$_assetsBaseUrl);
    }

    public static function printCssTag($cssUrl)
    {
        echo '<link rel="stylesheet" href="', $cssUrl, '" >', PHP_EOL;
    }

    public static function printJsTag($jsUrl, $defer = FALSE, $async = FALSE)
    {
        echo '<script src="', $jsUrl, '"';
        
        if ($defer)
            echo ' defer';
        
        if ($async)
            echo ' async';

        echo '></script>', PHP_EOL;
    }

    public static function printThemeCss($name)
    {
        self::printCssTag(self::getUrlForAssets("css/" . $name));
    }

    public static function printThemeJs($name, $defer = FALSE, $async = FALSE)
    {
        self::printJsTag(self::getUrlForAssets("js/" . $name), $defer, $async);
    }

    public static function getCdnUrl($name, $version, $file)
    {
        if (array_key_exists('_alias', self::$_assetsCdnUrl)) {
            $alias = self::$_assetsCdnUrl['_alias'];
            if (array_key_exists($name, $alias)) {
                $name = $alias[$name];
            }
        }
        if (array_key_exists($name, self::$_assetsCdnUrl)) {
            $cdnUrl = self::$_assetsCdnUrl[$name];
        } else if (array_key_exists('_tpl', self::$_assetsCdnUrl)) {
            $cdnUrl = self::$_assetsCdnUrl['_tpl'];
        } else {
            return;
        }
        return str_replace(array('{package}', '{version}', '{file}'), array($name, $version, $file), $cdnUrl);
    }

    public static function getFontCdnUrl($fontname, $type = 'css')
    {
        if (!array_key_exists('font', self::$_assetsCdnUrl))
            return;
        $cdnUrl = self::$_assetsCdnUrl['font'];
        return str_replace(array('{fontname}', '{type}'), array($fontname, $type), $cdnUrl);
    }

    public static function getIconCdnUrl()
    {
        if (!array_key_exists('icon', self::$_assetsCdnUrl))
            return;
        return self::$_assetsCdnUrl['icon'];
    }

    public static function getGravatarUrl()
    {
        if (!array_key_exists('gravatar', self::$_assetsCdnUrl))
            return;
        return self::$_assetsCdnUrl['gravatar'];
    }

    public static function cdn($cssJs, $type)
    {
        $args = func_get_args();

        $config = explode('+', $cssJs);
        $defer = in_array('defer', $config);
        $async = in_array('async', $config);
        $cssJs = $config[0];
        
        $funcName = '';
        switch ($type)
        {
            case 'font':
                array_splice($args, 0, 2);
                $funcName = 'getFontCdnUrl';
                if (count($args) == 1)
                {
                    array_push($args, $cssJs);
                }
                break;
            case 'icon':
                array_splice($args, 0, 2);
                $funcName = 'getIconCdnUrl';
                break;
            default:
                array_splice($args, 0, 1);
                $funcName = 'getCdnUrl';
                break;
        }
        $url = call_user_func_array(array('Icarus_Assets', $funcName), $args);
        if (empty($url))
        {
            return;
        }
        if ($cssJs == 'js')
        {
            self::printJsTag($url, $defer, $async);
        }
        else
        {
            self::printCssTag($url);
        }
    }
}