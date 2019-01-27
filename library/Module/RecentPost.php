<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
class Icarus_Module_RecentPost
{
    public static function config($form)
    {
        Icarus_Aside::basicConfig($form, 'RecentPost', Icarus_Aside::ENABLE, 'right', '1');
        
        $form->packInput('RecentPost/limit', '5', 'w-20');
        $form->packRadio('RecentPost/thumbnail', array('0', '1'), '1');
    }

    private static function getLimit()
    {
        $limit = intval(Icarus_Config::get('recent_post_limit', 5));
        if ($limit <= 0)
            $limit = 5;
        return $limit;
    }

    public static function output()
    {
        $posts = Typecho_Widget::widget('Widget_Contents_Post_Recent', 'pageSize=' . self::getLimit());
        if ($posts->length == 0)
            return;
        $thumbnailEnabled = !!Icarus_Config::get('recent_post_thumbnail', true);

?>
<div class="card widget">
    <div class="card-content">
        <h3 class="menu-label">
            <?php _IcTp('recent_post.title'); ?>
        </h3>
<?php while ($posts->next()): ?>
<div class="media">
    <?php if ($thumbnailEnabled): ?>
    <a href="<?php $posts->permalink(); ?>" class="media-left">
        <p class="image is-64x64">
            <img class="thumbnail" src="<?php echo Icarus_Content::getThumbnail($posts); ?>" alt="<?php $posts->title(); ?>">
        </p>
    </a>
    <?php endif; ?>
    <div class="media-content">
        <div class="content">
            <div><time class="has-text-grey is-size-7 is-uppercase" datetime="<?php $posts->date('c'); ?>"><?php $posts->date(); ?></time></div>
            <a href="<?php $posts->permalink(); ?>" class="has-link-black-ter is-size-6"><?php $posts->title(); ?></a>
            <?php if ($posts->categories): ?>
            <p class="is-size-7 is-uppercase">
            <?php 
            $category = $posts->categories[0];
            $directory = Typecho_Widget::widget('Widget_Metas_Category_List')->getAllParents($category['mid']);
            $directory[] = $category;
    
            if ($directory) {
                $result = array();
    
                foreach ($directory as $category) {
                    $result[] = '<a class="has-link-grey" href="' . $category['permalink'] . '">'
                    . $category['name'] . '</a>';
                }
    
                echo implode('&nbsp;/&nbsp;', $result);
            }
            ?>
            </p>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php endwhile;?>
    </div>
</div>
<?php
    }
}