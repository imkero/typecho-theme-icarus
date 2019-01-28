<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
$this->need('component/header.php');

Typecho_Widget::widget('Widget_Contents_Post_Recent', 'pageSize=100000')->to($archives); 
$year = -1;
$yearCount = 0;

while ($archives->next()): 
$year_tmp = date('Y',$archives->created);
if ($year_tmp != $year):
    if ($year != -1):
?>
        </div>
    </div>
</div>
<?php
    endif;
    $year = $year_tmp;
?>
<div class="card widget">
    <div class="card-content">
        <h3 class="tag is-link">
        <?php _e('%d年', $year); ?>
        </h3>
        <div class="timeline">
<?php endif; ?>
            <article class="media">
                <?php if (Icarus_Content::hasThumbnail($archives)): ?>
                <a href="<?php $archives->permalink(); ?>" class="media-left">
                    <p class="image is-64x64">
                        <img class="thumbnail" src="<?php echo Icarus_Content::getThumbnail($archives); ?>" alt="<?php $archives->title(); ?>">
                    </p>
                </a>
                <?php endif; ?>
                <div class="media-content">
                    <div class="content">
                        <time class="has-text-grey is-size-7 is-block is-uppercase" datetime="<?php $archives->date('c'); ?>"><?php $archives->date(); ?></time>
                        <a href="<?php $archives->permalink(); ?>" class="has-link-black-ter is-size-6"><?php $archives->title(); ?></a>
                        <div class="level article-meta is-mobile">
                            <div class="level-left">
                                <?php if ($archives->categories): ?>
                                <div class="level-item is-size-7 is-uppercase">
                                <?php 
                                $category = $archives->categories[0];
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
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </article>
<?php 
endwhile;
if ($year != -1):
    ?>
        </div>
    </div>
</div>
<?php
endif;
$this->need('component/footer.php');
