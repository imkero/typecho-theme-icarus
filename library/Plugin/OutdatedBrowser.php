<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
class Icarus_Plugin_OutdatedBrowser
{
    public static function config($form)
    {
        Icarus_Plugin::basicConfig($form, 'OutdatedBrowser', Icarus_Plugin::ENABLE);
    }

    public static function header()
    {
        Icarus_Assets::cdn('css', 'outdated-browser', '1.1.5', 'outdatedbrowser.min.css');
    }

    public static function footer()
    {
        Icarus_Assets::cdn('js+defer', 'outdated-browser', '1.1.5', 'outdatedbrowser.min.js');
?>
<div id="outdated"></div>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        outdatedBrowser({
            bgColor: '#f25648',
            color: '#ffffff',
            lowerThan: 'flex'
        });
    });
</script>
<?php
    }
}
