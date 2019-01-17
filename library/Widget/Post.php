<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
class Icarus_Widget_Post
{
    private $post;

    public function __construct($post)
    {
        $this->post = $post;
    }

    public static function config($form)
    {
        $form->packTitle('post');

        $form->packRadio('post_toc', array('0', '1'), 0);
    }

    public static function tocEnabled()
    {
        // dummy
        return true;
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
        // dummy
        return true;
    }

    public function getThumbnail()
    {
        // dummy
        return 'http://ppoffice.github.io/hexo-theme-icarus/gallery/preview.png';
    }

    public static function output($post)
    {
        return (new Icarus_Widget_Post($post))->doOutput();
    }

    public function doOutput()
    {
        $isIndex = $this->post->is('index');
?>
<div class="card">
    <?php if ($this->hasThumbnail()): ?>
    <div class="card-image">
        <?php echo $isIndex ? ('<a href="' . $this->post->permalink . '"') : '<span '; ?> class="image is-7by1">
            <img class="thumbnail" src="<?php echo $this->getThumbnail(); ?>" alt="<?php $this->post->title(); ?>">
        <?php echo $isIndex ? '</a>' : '</span>' ?>
    </div>
    <?php endif; ?>
    <div class="card-content article">
        <?php if (!$this->post->is('single')): ?>
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
            <?php if ($isIndex): ?>
                <a class="has-link-black-ter" href="<?php $this->post->permalink(); ?>"><?php $this->post->title(); ?></a>
            <?php else: ?>
                <?php $this->post->title(); ?>
            <?php endif; ?>
        </h1>
        <div class="content">
            <?php $this->post->content(); ?>
        </div>
        <?php if (!$isIndex && $this->post->tags): ?>
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
        <?php if ($isIndex): ?>
        <div class="level is-mobile">
            <div class="level-start">
                <div class="level-item">
                <a class="button is-size-7 is-light" href="<?php $this->post->permalink(); ?>#more"><?php _IcTp('article.more'); ?></a>
                </div>
            </div>
        </div>
        <?php endif; ?>
        <?php Icarus_Widget::show('Share'); ?>
        
    </div>
</div>

<?php  Icarus_Widget::show('Donate'); ?>

<?php
$prevPost = $this->getPrev();
$nextPost = $this->getNext();

if (!$isIndex && ($prevPost || $nextPost)): 
?>
<div class="card card-transparent">
    <div class="level post-navigation is-flex-wrap is-mobile">
        <?php if ($prevPost): ?>
        <div class="level-start">
            <a class="level level-item has-link-grey article-nav-prev" href="<?php echo $prevPost['permalink']; ?>">
                <i class="level-item fas fa-chevron-left"></i>
                <span class="level-item"><?php echo $prevPost['title']; ?></span>
            </a>
        </div>
        <?php 
        endif; 
        if ($nextPost):
        ?>
        <div class="level-end">
            <a class="level level-item has-link-grey article-nav-next" href=<?php echo $nextPost['permalink']; ?>">
                <span class="level-item"><?php echo $nextPost['title']; ?></span>
                <i class="level-item fas fa-chevron-right"></i>
            </a>
        </div>
        <?php endif; ?>
    </div>
</div>
<?php
endif; 
Icarus_Widget::show('Comments');
    }
}