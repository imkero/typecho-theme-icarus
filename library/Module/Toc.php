<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
class Icarus_Module_Toc
{
    public static function config($form)
    {
        Icarus_Aside::basicConfig($form, 'Toc', Icarus_Aside::ENABLE, 'right', '0');
    }

    public static function output()
    {
        if (!(Icarus_Page::is('post') || Icarus_Page::is('single')))
            return;
?>
<div class="card widget">
    <div class="card-content">
        <div class="menu">
            <h3 class="menu-label">
                <?php _IcTp('general.toc'); ?>
            </h3>

        </div>
    </div>
</div>
<?php
    }
}