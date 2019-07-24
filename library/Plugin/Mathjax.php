<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
class Icarus_Plugin_Mathjax
{
    public static function config($form)
    {
        Icarus_Plugin::basicConfig($form, 'Mathjax', Icarus_Plugin::DISABLE);
    }

    public static function footer()
    {
        Icarus_Assets::cdn('js+defer', 'mathjax', '2.7.5', 'MathJax.js?config=TeX-MML-AM_CHTML');
        Icarus_Assets::printThemeJs('mathjax.js', TRUE);
    }
}
