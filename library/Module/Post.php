<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
class Icarus_Module_Post
{
    private $post;

    public function __construct($post)
    {
        $this->post = $post;
    }

    public static function config($form)
    {
        $form->packTitle('Post');
    }

    public static function tocEnabled()
    {
        return Icarus_Module::enabled('Toc');
    }

    public function getPrev()
    {
        $content = Typecho_Db::get()->fetchRow($this->post->select()->where('table.contents.created < ?', $this->post->created)
            ->where('table.contents.status = ?', 'publish')
            ->where('table.contents.type = ?', $this->post->type)
            ->where("table.contents.password IS NULL OR table.contents.password = ''")
            ->order('table.contents.created', Typecho_Db::SORT_DESC)
            ->limit(1));
        if ($content) 
            return $this->post->filter($content);
        else
            return NULL;
    }

    public function getNext()
    {
        $content = Typecho_Db::get()->fetchRow($this->post->select()->where('table.contents.created > ? AND table.contents.created < ?',
            $this->post->created, Icarus_Util::$options->time)
            ->where('table.contents.status = ?', 'publish')
            ->where('table.contents.type = ?', $this->post->type)
            ->where("table.contents.password IS NULL OR table.contents.password = ''")
            ->order('table.contents.created', Typecho_Db::SORT_ASC)
            ->limit(1));
        if ($content) 
            return $this->post->filter($content);
        else
            return NULL;
    }

    public function hasThumbnail()
    {
        return Icarus_Util::hasThumbnail($this->post);
    }

    public function getThumbnail()
    {
        return Icarus_Util::getThumbnail($this->post);
    }

    public static function output($post)
    {
        return (new Icarus_Module_Post($post))->doOutput();
    }

    public function doOutput()
    {
        $isContent = $this->post->is('single');
        $isPage = $this->post->is('page');
        $isPost = $this->post->is('post');
?>
<div class="card">
    <?php if ($this->hasThumbnail()): ?>
    <div class="card-image">
        <?php echo !$isContent ? ('<a href="' . $this->post->permalink . '"') : '<span '; ?> class="image is-7by1">
            <img class="thumbnail" src="<?php echo $this->getThumbnail(); ?>" alt="<?php $this->post->title(); ?>">
        <?php echo !$isContent ? '</a>' : '</span>' ?>
    </div>
    <?php endif; ?>
    <div class="card-content article">
        <?php if (!$isPage): ?>
        <div class="level article-meta is-size-7 is-uppercase is-mobile is-overflow-x-auto">
            <div class="level-left">
                <time class="level-item has-text-grey" datetime="<?php $this->post->date('c'); ?>"><?php $this->post->date(); ?></time>
                <?php if ($this->post->categories): ?>
                <div class="level-item">
                <?php $result = array();
                foreach ($this->post->categories as $category) {
                    $result[] = '<a class="has-link-grey" href="' . $category['permalink'] . '">'
                    . $category['name'] . '</a>';
                }
                echo implode('&nbsp;/&nbsp;', $result);
                ?>
                </div>
                <?php 
                endif; 
                // todo: read time
                ?>
            </div>
        </div>
        <?php endif; ?>
        <h1 class="title is-size-3 is-size-4-mobile has-text-weight-normal">
            <?php if (!$isContent): ?>
                <a class="has-link-black-ter" href="<?php $this->post->permalink(); ?>"><?php $this->post->title(); ?></a>
            <?php else: ?>
                <?php $this->post->title(); ?>
            <?php endif; ?>
        </h1>
        <div class="content">
            <?php $this->post->content(); ?>
        </div>
        <?php if ($isContent && $this->post->tags): ?>
        <div class="level is-size-7 is-uppercase">
            <div class="level-start">
                <div class="level-item">
                    <span class="is-size-6 has-text-grey has-mr-7">#</span>
                    <?php $result = array();
                    foreach ($this->post->tags as $tag) {
                        $result[] ='<a class="has-link-grey" href="' . $tag['permalink'] . '">'
                        . $tag['name'] . '</a>';
                    }
                    echo implode(' ', $result);
                    ?>
                </div>
            </div>
        </div>
        <?php endif; ?>
        <?php if (!$isContent): ?>
        <div class="level is-mobile">
            <div class="level-start">
                <div class="level-item">
                <a class="button is-size-7 is-light" href="<?php $this->post->permalink(); ?>#more"><?php _IcTp('article.more'); ?></a>
                </div>
            </div>
        </div>
        <?php endif; ?>
        <?php Icarus_Module::show('Share'); ?>
    </div>
</div>
<?php  
Icarus_Module::show('Donate');

if ($isPost):
    $prevPost = $this->getPrev();
    $nextPost = $this->getNext();
    if ($prevPost || $nextPost): 
?>
<div class="card card-transparent">
    <div class="level post-navigation is-flex-wrap is-mobile">
        <div class="level-start">
        <?php if ($prevPost): ?>
            <a class="level level-item has-link-grey article-nav-prev" href="<?php echo $prevPost['permalink']; ?>">
                <i class="level-item fas fa-chevron-left"></i>
                <span class="level-item"><?php echo $prevPost['title']; ?></span>
            </a>
        <?php endif;?> 
        </div>
        <div class="level-end">
        <?php if ($nextPost): ?>
            <a class="level level-item has-link-grey article-nav-next" href="<?php echo $nextPost['permalink']; ?>">
                <span class="level-item"><?php echo $nextPost['title']; ?></span>
                <i class="level-item fas fa-chevron-right"></i>
            </a>
        <?php endif; ?>
        </div>
    </div>
</div>
<?php
    endif;
endif; 
Icarus_Module::show('Comments');
    }
}