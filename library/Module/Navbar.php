<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
class Icarus_Module_Navbar
{
    public static function config($form)
    {
        $form->packTitle('Navbar');

        $form->packTextarea('Navbar/menu', 
            sprintf(
                _IcT('setting.navbar.default_value'),
                Icarus_Util::$options->index,
                Icarus_Util::urlFor('page', array('slug' => 'archives')),
                Icarus_Util::urlFor('page', array('slug' => 'categories'))
            )
        );
        $form->packTextarea('Navbar/icons', "Download on GitHub,fab fa-github,http://github.com/ppoffice/hexo-theme-icarus");
    }

    private static function getMenu()
    {
        return Icarus_Util::parseMultilineData(Icarus_Config::get('navbar_menu'), 2);
    }

    private static function getIcons()
    {
        return Icarus_Util::parseMultilineData(Icarus_Config::get('navbar_icons'), 3);
    }

    private static function isCurLink($uri)
    {
        return Typecho_Request::getInstance()->getRequestUri() == $uri;
    }

    public static function output()
    {
?>
<nav class="navbar navbar-main">
    <div class="container">
        <div class="navbar-brand is-flex-center">
            <a class="navbar-item navbar-logo" href="<?php Icarus_Util::$options->index(); ?>">
            <?php if (Icarus_Config::tryGet('logo_img', $logo_img)): ?>
                <img src="<?php echo Icarus_Assets::getUrlForAssets($logo_img); ?>" alt="<?php Icarus_Util::$options->title(); ?>" height="28">
            <?php else: ?>
                <?php echo Icarus_Config::get('logo_text', Icarus_Util::$options->title); ?>
            <?php endif; ?>
            </a>
        </div>
        <div class="navbar-menu">
            <?php if (Icarus_Config::has('navbar_menu')): $menu = self::getMenu(); ?>
            <div class="navbar-start">
                <?php foreach ($menu as $menuItem): ?>
                <a class="navbar-item<?php if (self::isCurLink($menuItem[1])) { ?> is-active<?php } ?>"
                href="<?php echo $menuItem[1]; ?>"><?php echo $menuItem[0]; ?></a>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
            <div class="navbar-end">
            <?php if (Icarus_Config::has('navbar_icons')): $icons = self::getIcons(); ?>
                <?php foreach ($icons as $iconItem): ?>
                <a class="navbar-item" target="_blank" title="<?php echo $iconItem[0]; ?>" href="<?php echo $iconItem[2]; ?>">
                    <?php if (empty($iconItem[1])): ?>
                    <?php echo $iconItem[0]; ?>
                    <?php else: ?>
                    <i class="<?php echo $iconItem[1]; ?>"></i>
                    <?php endif; ?>
                </a>
                <?php endforeach; ?>
            <?php endif; ?>
            <?php if (Icarus_Module::enabled('Toc') && Icarus_Page::is('single')): ?>
                <a class="navbar-item is-hidden-tablet catalogue" title="<?php _IcTp('general.catalog'); ?>" href="javascript:;">
                    <i class="fas fa-list-ul"></i>
                </a>
            <?php endif; ?>
            <?php if (Icarus_Module::enabled('Search')): ?>
                <a class="navbar-item search" title="<?php _IcTp('search.title'); ?>" href="javascript:;">
                    <i class="fas fa-search"></i>
                </a>
            <?php endif; ?>
            </div>
        </div>
    </div>
</nav>
<?php
    }
}