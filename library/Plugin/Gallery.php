<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
class Icarus_Plugin_Gallery
{
    public static function config($form)
    {
        Icarus_Plugin::basicConfig($form, 'Gallery', Icarus_Plugin::ENABLE);
    }

    public static function header()
    {
        Icarus_Assets::cdn('css', 'lightgallery', '1.6.8', 'dist/css/lightgallery.min.css');
        Icarus_Assets::cdn('css', 'justifiedGallery', '3.7.0', 'dist/css/justifiedGallery.min.css');
    }

    public static function footer()
    {
        Icarus_Assets::cdn('js+defer', 'lightgallery', '1.6.8', 'dist/js/lightgallery.min.js');
        Icarus_Assets::cdn('js+defer', 'justifiedGallery', '3.7.0', 'dist/js/jquery.justifiedGallery.min.js');
        Icarus_Assets::printThemeJs('gallery.js', TRUE);
    }
}
