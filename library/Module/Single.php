<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
class Icarus_Module_Single
{
    private $_post;

    public function __construct($post)
    {
        $this->_post = $post;
    }

    private function getPrev()
    {
        $content = Typecho_Db::get()->fetchRow($this->_post->select()->where('table.contents.created < ?', $this->_post->created)
            ->where('table.contents.status = ?', 'publish')
            ->where('table.contents.type = ?', $this->_post->type)
            ->where("table.contents.password IS NULL OR table.contents.password = ''")
            ->order('table.contents.created', Typecho_Db::SORT_DESC)
            ->limit(1));
        if ($content) 
            return $this->_post->filter($content);
        else
            return NULL;
    }

    private function getNext()
    {
        $content = Typecho_Db::get()->fetchRow($this->_post->select()->where('table.contents.created > ? AND table.contents.created < ?',
            $this->_post->created, Icarus_Util::$options->time)
            ->where('table.contents.status = ?', 'publish')
            ->where('table.contents.type = ?', $this->_post->type)
            ->where("table.contents.password IS NULL OR table.contents.password = ''")
            ->order('table.contents.created', Typecho_Db::SORT_ASC)
            ->limit(1));
        if ($content) 
            return $this->_post->filter($content);
        else
            return NULL;
    }

    private function hasThumbnail()
    {
        return Icarus_Content::hasThumbnail($this->_post);
    }

    private function getThumbnail()
    {
        return Icarus_Content::getThumbnail($this->_post);
    }

    public static function output($post)
    {
        return (new Icarus_Module_Single($post))->doOutput();
    }

    private function printThumbnail($isContent)
    {
        if ($this->hasThumbnail()) {
?>
    <div class="card-image">
        <?php echo !$isContent ? ('<a href="' . $this->_post->permalink . '"') : '<span '; ?> class="image is-7by1">
            <img class="thumbnail" src="<?php echo $this->getThumbnail(); ?>" alt="<?php $this->_post->title(); ?>">
        <?php echo !$isContent ? '</a>' : '</span>' ?>
    </div>
<?php 
        }
    }

    private function printCategory()
    {
        if ($this->_post->categories) {
?>
    <div class="level-item">
        <?php 
        $category = $this->_post->categories[0];
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
        <?php 
        }
    }

    private function printTags()
    {
        if (!$this->_post->tags)
            return;
?>
        <div class="level is-size-7 is-uppercase">
            <div class="level-start">
                <div class="level-item">
                    <span class="is-size-6 has-text-grey has-mr-7">#</span>
                    <?php $result = array();
                    foreach ($this->_post->tags as $tag) {
                        $result[] ='<a class="has-link-grey" href="' . $tag['permalink'] . '">'
                        . $tag['name'] . '</a>';
                    }
                    echo implode(',&nbsp;', $result);
                    ?>
                </div>
            </div>
        </div>
<?php
    }

    private function printReadMore()
    {
?>
        <div class="level is-mobile">
            <div class="level-start">
                <div class="level-item">
                <a class="button is-size-7 is-light" href="<?php $this->_post->permalink(); ?>"><?php _IcTp('article.more'); ?></a>
                </div>
            </div>
        </div>
<?php
    }

    public function doOutput()
    {
        $isContent = $this->_post->is('single');
        $isPage = $this->_post->is('page');
        $isPost = $this->_post->is('post');
        
        if (!$isContent)
        {
            $this->doOutputList();
        }
        else if ($isPage)
        {
            $this->doOutputPage();
        }
        else
        {
            $this->doOutputPost();
        }
    }

    public function doOutputList()
    {
        $isContent = $this->_post->is('single');
        $isPage = $this->_post->is('page');
        $isPost = $this->_post->is('post');
?>
<div class="card">
    <?php $this->printThumbnail(FALSE); ?>
    <?php if (!!Icarus_Config::get('post_tiny_item', FALSE)): ?>
    <div class="card-content article article-item article-item-tiny">
        <h1 class="title is-size-3 is-size-4-mobile has-text-weight-normal">
            <a class="has-link-black-ter" href="<?php $this->_post->permalink(); ?>"><?php $this->_post->title(); ?></a>
        </h1>
        <div class="level article-meta is-size-7 is-uppercase is-mobile is-overflow-x-auto">
            <div class="level-left">
                <time class="level-item has-text-grey" datetime="<?php $this->_post->date('c'); ?>"><?php $this->_post->date(); ?></time>
                <?php $this->printCategory(); ?>
            </div>
            <?php $this->printReadMore(); ?>
        </div>
    </div>
    <?php else: ?>
    <div class="card-content article article-item">
        <div class="level article-meta is-size-7 is-uppercase is-mobile is-overflow-x-auto">
            <div class="level-left">
                <time class="level-item has-text-grey" datetime="<?php $this->_post->date('c'); ?>"><?php $this->_post->date(); ?></time>
                <?php $this->printCategory(); ?>
            </div>
        </div>
        <h1 class="title is-size-3 is-size-4-mobile has-text-weight-normal">
            <a class="has-link-black-ter" href="<?php $this->_post->permalink(); ?>"><?php $this->_post->title(); ?></a>
        </h1>
        <div class="content">
            <?php echo Icarus_Content::getExcerpt($this->_post); ?>
        </div>
        <?php $this->printReadMore(); ?>
    </div>
    <?php endif; ?>
</div>
<?php  
    }

    public function doOutputPage()
    {
?>
<div class="card">
    <?php $this->printThumbnail(TRUE); ?>
    <div class="card-content article article-single">
        <h1 class="title is-size-3 is-size-4-mobile has-text-weight-normal">
            <?php $this->_post->title(); ?>
        </h1>
        <div class="content">
        <?php 
            echo Icarus_Content::getContent($this->_post); 
        ?>
        </div>
        <?php $this->printTags(); ?>
    </div>
</div>
<?php  
        Icarus_Module::show('Donate');
        Icarus_Module::show('Comments', $this->_post);
    }

    public function doOutputPost()
    {
?>
<div class="card">
    <?php $this->printThumbnail(TRUE); ?>
    <div class="card-content article article-single">
        <div class="level article-meta is-size-7 is-uppercase is-mobile is-overflow-x-auto">
            <div class="level-left">
                <time class="level-item has-text-grey" datetime="<?php $this->_post->date('c'); ?>"><?php $this->_post->date(); ?></time>
                <?php $this->printCategory(); ?>
            </div>
        </div>
        <h1 class="title is-size-3 is-size-4-mobile has-text-weight-normal">
            <?php $this->_post->title(); ?>
        </h1>
        <div class="content">
        <?php 
            echo Icarus_Content::getContent($this->_post); 
        ?>
        </div>
        <?php 
            $this->printTags();    
        ?>
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
Icarus_Module::show('Comments', $this->_post);
    }
}