<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
class Icarus_Module_Search
{
    public static function config($form)
    {
        $form->packTitle('Search');

        $form->packRadio('Search/enable', array('0', '1'), '1');
        $form->packRadio('Search/type', array('internal'), 'internal');
    }

    public static function output()
    {
        switch (Icarus_Config::get('search_type', 'internal'))
        {
            case 'internal':
            default:
                self::outputInternal();
                break;
        }
    }

    public static function header()
    {
        Icarus_Assets::printThemeCss('search.css');
    }

    private static function outputInternal()
    {
?>
<div class="searchbox">
    <div class="searchbox-container">
        <div class="searchbox-input-wrapper">
            <form class="search-form" method="post" action="<?php Icarus_Util::$options->siteUrl(); ?>" role="search">
                <input name="s" type="text" class="searchbox-input" placeholder="<?php _IcTp('search.placeholder'); ?>" />
                <span class="searchbox-close searchbox-selectable"><i class="fa fa-times-circle"></i></span>
            </form>
        </div>
    </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function () {
    (function ($) {
        $('.navbar-main .search').click(function () {
            $('.searchbox').toggleClass('show');
        });
        $('.searchbox .searchbox-mask').click(function () {
            $('.searchbox').removeClass('show');
        });
        $('.searchbox-close').click(function () {
            $('.searchbox').removeClass('show');
        });
    })(jQuery);
});
</script>
<?php
    }
}