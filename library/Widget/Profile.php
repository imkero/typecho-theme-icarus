<?php
class Icarus_Widget_Profile
{
    public static function config($form)
    {
        Icarus_Widget_Aside::basicConfig($form, 'profile', '1', 'left', '0');
        $form->packInput('profile_author', Typecho_Widget::widget('Widget_User')->screenName);
        $form->packInput('profile_author_title', '');
        $form->packInput('profile_location', '');
        $form->packInput('profile_avatar', 'img/avatar.png');
        $form->packInput('profile_gravatar', '');
        $form->packInput('profile_follow_link', 'https://github.com/');
        $form->packTextarea('profile_social_link', "GitHub,fa-github,https://github.com/\nTwitter,fa-twitter,https://twitter.com/,Facebook,fa-facebook,https://facebook.com/");
    }

    private static function printAvatarUrl()
    {
        $avatar = Icarus_Config::get('profile_avatar');
        if (Icarus_Config::tryGet('profile_gravatar', $gravatarEmail))
        {
            echo Icarus_Util::getAvatar($gravatarEmail, 128);
        }
        else
        {
            echo Icarus_Assets::getUrlForAssets(
                Icarus_Config::get('profile_avatar', 'img/avatar.png'));
        }
    }

    private static function getSocialLinks()
    {
        return Icarus_Util::parseMultilineData(Icarus_Config::get('profile_social_link'), 3);
    }

    public static function output()
    {
?>
<div class="card widget">
    <div class="card-content">
        <nav class="level">
            <div class="level-item has-text-centered">
                <div>
                    <img class="image is-128x128 has-mb-6 profile-avatar" 
                        src="<?php self::printAvatarUrl(); ?>" 
                        alt="<?php echo Icarus_Config::get('profile_author'); ?>" />
                    <?php if (Icarus_Config::tryGet('profile_author', $profileAuthor)): ?>
                    <p class="is-size-4 is-block">
                        <?php echo $profileAuthor; ?>
                    </p>
                    <?php endif; ?>
                    <?php if (Icarus_Config::tryGet('profile_author_title', $profileAuthorTitle)): ?>
                    <p class="is-size-6 is-block">
                        <?php echo $profileAuthorTitle; ?>
                    </p>
                    <?php endif; ?>
                    <?php if (Icarus_Config::tryGet('profile_location', $profileLocation)): ?>
                    <p class="is-size-6 is-flex is-flex-center has-text-grey">
                        <i class="fas fa-map-marker-alt has-mr-7"></i>
                        <span><?php echo $profileLocation ?></span>
                    </p>
                    <?php endif; ?>
                </div>
            </div>
        </nav>
        <nav class="level is-mobile">
            <div class="level-item has-text-centered is-marginless">
                <div>
                    <p class="heading">
                        <?php _IcTp('general.posts'); ?>
                    </p>
                    <p class="title has-text-weight-normal">
                        <?php echo Icarus_Util::stat()->publishedPostsNum(); ?>
                    </p>
                </div>
            </div>
            <div class="level-item has-text-centered is-marginless">
                <div>
                    <p class="heading">
                        <?php _IcTp('general.categories'); ?>
                    </p>
                    <p class="title has-text-weight-normal">
                        <?php echo Icarus_Util::stat()->categoriesNum(); ?>
                    </p>
                </div>
            </div>
        </nav>
        <?php if (Icarus_Config::tryGet('profile_follow_link', $profileFollowLink)): ?>
        <div class="level">
            <a class="level-item button is-link is-rounded" href="<?php echo $profileFollowLink; ?>">
                <?php _IcTp('profile.follow'); ?></a>
        </div>
        <?php endif; ?>
        <?php $socialLinks = self::getSocialLinks(); ?>
        <?php if (!empty($socialLinks)): ?>
        <div class="level is-mobile">
            <?php foreach ($socialLinks as $socialLink): ?>
            <a class="level-item button is-white is-marginless" target="_blank"
                title="<?php echo $socialLink[0]; ?>" href="<?php echo $socialLink[2]; ?>">
                <?php if (empty($socialLink[1])): ?>
                <?php echo $socialLink[0]; ?>
                <?php else: ?>
                <i class="fab <?php echo $socialLink[1]; ?>"></i>
                <?php endif; ?>
            </a>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
    </div>
</div>
<?php
    }
}