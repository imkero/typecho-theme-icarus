<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
class Icarus_Widget_Navbar
{
    public static function config($form)
    {
        $form->packTitle('logo');

        $form->packInput('logo_text', '');
        $form->packInput('logo_img', '');

        $form->packTitle('navbar');

        $form->packTextarea('navbar_menu');
        $form->packTextarea('navbar_icon');
    }

    private static function getMenu()
    {
        $result = array();
        $menu = Icarus_Config::get('navbar_menu');
        if (!empty($menu))
        {
            $menu = explode("\n", $menu);
            foreach ($menu as $menuItem)
            {
                $menuItem = trim($menuItem);
                if (!empty($menuItem))
                {
                    $menuItem = explode(',', $menuItem, 2);
                    if (count($menuItem) == 2)
                    {
                        $result[] = $menuItem;
                    }
                }
            }
        }
        return $result;
    }

    private static function getIcon()
    {
        $result = array();
        $icon = Icarus_Config::get('navbar_icon');
        if (!empty($icon))
        {
            $icon = explode("\n", $icon);
            foreach ($icon as $iconItem)
            {
                $iconItem = trim($iconItem);
                if (!empty($iconItem))
                {
                    $iconItem = explode(',', $iconItem, 3);
                    if (count($iconItem) == 3)
                    {
                        $result[] = $iconItem;
                    }
                }
            }
        }
        return $result;
    }

    private static function isCurLink($uri)
    {
        return Icarus_Util::request()->getRequestUri() == $uri;
    }

    public static function output()
    {
        Icarus_Widget::load('Post');
?>
<nav class="navbar navbar-main">
    <div class="container">
        <div class="navbar-brand is-flex-center">
            <a class="navbar-item navbar-logo" href="<?php Icarus_Util::$options->index(); ?>">
            <?php if (Icarus_Config::tryGet('logo_img', $logo_img)): ?>
                <img src="<?php echo $logo_img; ?>" alt="<?php Icarus_Util::$options->title(); ?>" height="28">
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
            <?php if (Icarus_Config::has('navbar_icon')): $icon = self::getIcon(); ?>
                <?php foreach ($icon as $iconItem): ?>
                <a class="navbar-item" target="_blank" title="<?php echo $iconItem[0]; ?>" href="<?php echo $iconItem[2]; ?>">
                    <?php if (empty($iconItem[1])): ?>
                    <?php echo $iconItem[0]; ?>
                    <?php else: ?>
                    <i class="fab <?php echo $iconItem[1]; ?>"></i>
                    <?php endif; ?>
                </a>
                <?php endforeach; ?>
            <?php endif; ?>
            <?php if (Icarus_Config::get('post_toc') == true && Icarus_Widget_Post::tocEnabled() && (Icarus_Page::is('archive') || Icarus_Page::is('single'))): ?>
                <a class="navbar-item is-hidden-tablet catalogue" title="<?php _IcTp('general.catalog'); ?>" href="javascript:;">
                    <i class="fas fa-list-ul"></i>
                </a>
            <?php endif; ?>
            <?php if (Icarus_Widget::enabled('Search')): ?>
                <a class="navbar-item search" title="<?php _IcTp('search.search'); ?>" href="javascript:;">
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