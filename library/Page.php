<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
class Icarus_Page
{
    public static function init()
    {
        self::descMetaPatch();
    }

    private static function descMetaPatch()
    {
        $widget = Icarus_Util::$widget;
        if ($widget->is('single')) {
            if (!Icarus_Util::isEmpty($widget->fields->custom_excerpt)) {
                $excerpt = strip_tags($widget->markdown($widget->fields->custom_excerpt));
                $widget->setDescription($excerpt);
            }
        }
    }

    public static function printPageTitle()
    {
        Icarus_Util::$widget->archiveTitle(array(
            'category' => _IcT('title.category'),
            'search' => _IcT('title.search'),
            'tag' => _IcT('title.tag'),
            'author' => _IcT('title.author'),
            'date' => _IcT('title.date')
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
        // favicon
        Icarus_Config::callback('head_favicon', function ($faviconUrl) {
            echo '<link rel="icon" href="', Icarus_Assets::getUrlForAssets($faviconUrl), '" />', PHP_EOL;
        });
        
        // search
        Icarus_Module::load('Search');
        Icarus_Module_Search::header();

        // custom head content
        echo Icarus_Config::get('head_extend');

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
        $form->packTextarea('Head/extend', '');

        $form->packTitle('Logo');

        $form->packInput('Logo/text', '');
        $form->packInput('Logo/img', 'img/logo.svg');

        $form->packTitle('Footer');

        $form->packTextarea('Footer/links', 'Attribution-NonCommercial 4.0 International (CC BY-NC 4.0),fab fa-creative-commons|fab fa-creative-commons-by|fab fa-creative-commons-nc,https://creativecommons.org/licenses/by-nc/4.0/');
        $form->packTextarea('Footer/content_left', '');
        $form->packTextarea('Footer/scripts', '');
    }

    public static function getFooterLinks()
    {
        $result = Icarus_Util::parseMultilineData(Icarus_Config::get('footer_links'), 3);
        if (!empty($result)) {
            foreach ($result as $k => $link) {
                $result[$k][1] = empty($link[1]) ? null : explode('|', $link[1]);
            }
        }
        return $result;
    }
}
