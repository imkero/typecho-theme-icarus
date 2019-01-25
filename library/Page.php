<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
class Icarus_Page
{
    public static function printPageTitle()
    {
        // todo: i18n
        Icarus_Util::$widget->archiveTitle(array(
            'category' => _t('分类 %s 下的文章'),
            'search' => _t('包含关键字 %s 的文章'),
            'tag' => _t('标签 %s 下的文章'),
            'author' => _t('%s 发布的文章')
        ), '', ' - ');
        Icarus_Util::$options->title();
    }
    
    public static function printHtmlLang()
    {
        $lang = Icarus_Util::$options->lang;
        if (empty($lang))
            $lang = 'zh-CN';
        else
            $lang = str_replace('_', '-', $lang);

        echo 'lang="', $lang, '"';
    }

    public static function printHeader()
    {
        Icarus_Config::callback('head_favicon', function ($faviconUrl)
        {
            echo '<link rel="icon" href="', Icarus_Assets::getUrlForAssets($faviconUrl),'" />', PHP_EOL;
        });

        // todo: open graph
    }

    public static function printBodyColumnClass()
    {
        echo 'is-', Icarus_Aside::getColumnCount(), '-column';
    }

    public static function printContainerColumnClass()
    {
        switch (Icarus_Aside::getColumnCount()) {
            case 1:
                echo 'is-12';
                break;
            case 2:
                echo 'is-8-tablet is-8-desktop is-8-widescreen';
                break;
            case 3:
                echo 'is-8-tablet is-8-desktop is-6-widescreen';
                break;
        }
    }

    public static function is($archiveType, $archiveSlug = NULL)
    {
        return Icarus_Util::$widget->is($archiveType, $archiveSlug);
    }

    public static function config($form)
    {
        $form->packTitle('Head');

        $form->packInput('Head/favicon', 'img/favicon.svg');

        $form->packTitle('Logo');

        $form->packInput('Logo/text', '');
        $form->packInput('Logo/img', 'img/logo.svg');

        $form->packTitle('Footer');

        $form->packTextarea('Footer/links', '');
        $form->packTextarea('Footer/content_left', '');
        $form->packTextarea('Footer/scripts', '');
    }

    public static function getFooterLinks()
    {
        $result = Icarus_Util::parseMultilineData(Icarus_Config::get('footer_links'), 3);
        if (!empty($result))
        {
            foreach ($result as $k => $link)
            {
                $result[$k][1] = empty($link[1]) ? NULL : explode('|', $link[1]);
            }
        }
        return $result;
    }
}