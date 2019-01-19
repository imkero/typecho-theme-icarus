<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
class Icarus_Module_Category
{
    public static function output()
    {
?>
<div class="card widget">
    <div class="card-content">
        <div class="menu">
        <h3 class="menu-label">
            <?php _IcTp('general.categories'); ?>
        </h3>
<?php 
Typecho_Widget::widget('Widget_Metas_Category_List')->listCategories('wrapTag=ul&wrapClass=menu-list');
?>        
        </div>
    </div>
</div>
<?php
    }
    
    public static function config($form)
    {
        Icarus_Aside::basicConfig($form, 'category', '1', 'left', '1');
    }
}

function treeViewCategories($widget, $categoryOptions)
{
?>
<li>
    <a class="level is-marginless" href="<?php echo $widget->permalink; ?>">
        <span class="level-start">
            <span class="level-item"><?php echo $widget->name; ?></span>
        </span>
        <span class="level-end">
            <span class="level-item tag"><?php echo intval($widget->count); ?></span>
        </span>
    </a>
<?php
if ($widget->children) {
    $this->treeViewCategories();
}
?>
</li>
<?php
}