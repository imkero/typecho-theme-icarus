<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
class Icarus_Plugin_Animejs
{
    public static function config($form)
    {
        Icarus_Plugin::basicConfig($form, 'Animejs', Icarus_Plugin::ENABLE);
    }

    public static function header()
    {
?>
<style>body>.footer,body>.navbar,body>.section{opacity:0}</style>
<?php
    }

    public static function footer()
    {
        Icarus_Assets::printThemeJs('animation.js');
    }
}
