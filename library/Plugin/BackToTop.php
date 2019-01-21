<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
class Icarus_Plugin_BackToTop
{
    public static function config($form)
    {
        Icarus_Plugin::basicConfig($form, 'BackToTop', Icarus_Plugin::ENABLE);
    }

    public static function header()
    {
        Icarus_Assets::printThemeCss('back-to-top.css');
    }

    public static function footer()
    {
?>
<a id="back-to-top" title="<?php _IcTp('back_to_top.title'); ?>" href="javascript:;">
    <i class="fas fa-chevron-up"></i>
</a>
<?php
        Icarus_Assets::printThemeJs('back-to-top.js', TRUE);
    }
}
