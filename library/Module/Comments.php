<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
class Icarus_Module_Comments
{
    public static function config($form)
    {
        $form->packTitle('Comments');

        $form->packRadio('Comments/type', array('internal', 'custom'), 'internal');
        $form->packInput('Comments/default_avatar', 'identicon');
        
        $form->packTextarea('Comments/custom_content', '');

    }

    public static function output($widget)
    {
        switch (Icarus_Config::get('comments_type'))
        {
            case 'internal':
            default:
                self::outputInternal($widget);
                break;
            case 'custom':
                self::outputCustom($widget);
                break;
        }
    }

    public static function printCommentAuthor($comment, $autoLink = NULL, $noFollow = NULL)
    {
        $autoLink = (NULL === $autoLink) ? Icarus_Util::$options->commentsShowUrl : $autoLink;
        $noFollow = (NULL === $noFollow) ? Icarus_Util::$options->commentsUrlNofollow : $noFollow;

        if ($comment->url && $autoLink) {
            echo '<a href="' , $comment->url , '"' , ($noFollow ? ' rel="external nofollow noopener"' : ' rel="noopener"') , ' target="_blank">' , $comment->author , '</a>';
        } else {
            echo $comment->author;
        }
    }

    private static function outputInternal($widget)
    {
        $widget->comments()->to($comments);
        $options = Icarus_Util::$options;
        $user = Typecho_Widget::widget('Widget_User');
        if ($comments->have() || $widget->allow('comment')):
?>
<div class="card">
    <div class="card-content comment-container">
        <div class="field is-grouped">
            <div class="control"><h3 class="title is-5 has-text-weight-normal"><?php _IcTp('general.comments'); ?></h3></div>
            <div class="control"><span class="tag has-text-weight-normal"><?php $widget->commentsNum(_t('暂无'), _t('1 条'), _t('%d 条')); ?></span></div>
        </div>
        <div class="comment-list">
        <?php $comments->listComments(array('before' => '', 'after' => '')); ?>
        </div>
        <?php Icarus_Module::show('Paginator', $comments); ?>

        <?php if ($widget->allow('comment')): ?>
        <div id="<?php $widget->respondId(); ?>" class="respond">
            <form method="post" action="<?php $widget->commentUrl() ?>" id="comment-form" role="form">
                <div class="field is-grouped">
                    <div class="control"><h3 id="response" class="title is-5 has-text-weight-normal"><?php _IcTp('comments.do_comment_title'); ?></h3></div>
                    <div class="control cancel-comment-reply"><?php $comments->cancelReply(); ?></div>
                </div>
                <?php if ($user->hasLogin()): ?>
                <div class="field is-horizontal">
                    <div class="field-body">
                        <div class="field">
                        <p>
                            <span><?php _IcTp('comments.logined'); ?></span><a href="<?php $options->profileUrl(); ?>"><?php $user->screenName(); ?></a><span>.&nbsp;</span>
                            <a href="<?php $options->logoutUrl(); ?>"><?php _IcTp('general.logout'); ?> &raquo;</a>
                        </p>
                        </div>
                    </div>
                </div>
                <?php else: ?>
                <div class="field is-horizontal">
                    <div class="field-body">
                        <div class="field">
                        <p class="control is-expanded has-icons-left">
                            <input class="input" placeholder="<?php _IcTp('comments.input.name'); ?>" title="<?php _IcTp('comments.guide.name'); ?>" type="text" name="author" id="author" value="<?php $widget->remember('author'); ?>" required />
                            <span class="icon is-small is-left"><i class="fas fa-user"></i></span>
                        </p>
                        </div>
                        <div class="field">
                        <p class="control is-expanded has-icons-left">
                        <?php if ($options->commentsRequireMail): ?>
                            <input class="input" placeholder="<?php _IcTp('comments.input.email_required'); ?>" title="<?php _IcTp('comments.guide.email_required'); ?>" type="email" name="mail" id="mail" value="<?php $widget->remember('mail'); ?>" required />
                        <?php else: ?>
                            <input class="input" placeholder="<?php _IcTp('comments.input.email'); ?>" title="<?php _IcTp('comments.guide.email'); ?>" type="email" name="mail" id="mail" value="<?php $widget->remember('mail'); ?>" />
                        <?php endif; ?>
                            <span class="icon is-small is-left"><i class="fas fa-envelope"></i></span>
                        </p>
                        </div>
                        <div class="field">
                        <p class="control is-expanded has-icons-left">
                        <?php if ($options->commentsRequireURL): ?>
                            <input class="input" placeholder="<?php _IcTp('comments.input.url_required'); ?>" title="<?php _IcTp('comments.guide.url_required'); ?>" type="url" name="url" id="url" value="<?php $widget->remember('url'); ?>" required />
                        <?php else: ?>
                            <input class="input" placeholder="<?php _IcTp('comments.input.url'); ?>" title="<?php _IcTp('comments.guide.url'); ?>" type="url" name="url" id="url" value="<?php $widget->remember('url'); ?>" />
                        <?php endif; ?>
                            <span class="icon is-small is-left"><i class="fas fa-link"></i></span>
                        </p>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
                <div class="media">
                    <figure class="media-left">
                        <p class="image is-64x64">
                            <img id="comment-form-avatar" src="<?php echo Icarus_Util::getAvatar($user->mail ? $user->mail : $widget->remember('mail', TRUE), 128);?>" data-avatar-url-tpl="<?php echo Icarus_Util::getAvatar('{mail}', '{size}');?>">
                        </p>
                    </figure>
                    <div class="media-content">
                        <div class="field">
                        <p class="control">
                            <textarea placeholder="<?php _IcTp('comments.input.text'); ?>" rows="8" cols="50" name="text" id="textarea" class="textarea" required></textarea>
                        </p>
                        </div>
                        <div class="field">
                        <p class="control">
                            <button class="button" type="submit"><?php _IcTp('comments.do_comment'); ?></button>
                        </p>
                        </div>
                    </div>
                </div>
    	    </form>
        </div>
        <?php else: ?>
        <div class="respond">
            <h3 class="title is-5 has-text-weight-normal"><?php _IcTp('comments.disabled'); ?></h3>
        </div>
        <?php endif; ?>
    </div>
</div>
<?php
    endif;
    }

    private static function outputCustom($widget)
    {
        $identifier = $widget->getArchiveType() . '-' . $widget->getArchiveSlug();
?>
<div class="card">
    <div class="card-content comment-container">
        <?php echo str_replace('{identifier}', $identifier, Icarus_Config::get('comments_custom_content', '')); ?>
    </div>
</div>
<?php
    }
}

function threadedComments($comments, $options)
{
?>
<div class="media comment">
    <figure class="media-left">
        <p class="image is-48x48">
        <img src="<?php echo Icarus_Util::getAvatar($comments->mail, 96); ?>">
        </p>
    </figure>
    <div class="media-content" id="<?php $comments->theId(); ?>">
        <div class="content">
            <div class="comment-header">
                <span class="comment-author"><?php Icarus_Module_Comments::printCommentAuthor($comments); ?></span>
                <?php if ($comments->authorId && $comments->authorId == $comments->ownerId): ?>
                <span class="tag is-info"><?php _IcTp('comments.is_author'); ?></span>
                <?php endif; ?>
                <?php if ('waiting' == $comments->status): ?>
                <span class="tag is-warning"><?php _IcTp('comments.is_waiting'); ?></span>
                <?php endif; ?>
            </div>
            <div class="comment-content"><?php $comments->content(); ?></div>
            <div class="comment-meta"><?php $comments->reply('回复'); ?> · <time itemprop="commentTime" datetime="<?php $comments->date('c'); ?>"><?php $comments->date(Icarus_Util::$options->commentDateFormat);?></time></div>
        </div>
        <?php if ($comments->children): ?>
        <div class="comment-children">
            <?php $comments->threadedComments(); ?>
        </div>
        <?php endif; ?>
    </div>
</div>
<?php
}