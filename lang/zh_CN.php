<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
return array(
    'general' => array(
        'enable' => '启用',
        'disable' => '不启用',
        'catalog' => '目录',
    ),
    'search' => array(
        'search' => '搜索',
    ),
    'article' => array(
        'more' => '阅读更多',
    ),
    'setting' => array(
        'general' => array(
            'title' => '基本',
            'desc' => '<ul><li>资源文件的相对路径是指相对于 ' . __TYPECHO_THEME_DIR__ . '/%s/assets/ 目录的相对路径。</li></ul>',
        ),
        'head' => array(
            'title' => '页头',
            'favicon' => array(
                'title' => 'Favicon',
                'desc' => 'Favicon 图标的相对路径或 URL。',
            ),
        ),
        'navbar' => array(
            'title' => '导航栏',
            'menu' => array(
                'title' => '菜单',
                'desc' => '导航栏菜单链接。一行一个，格式：链接文字,链接URL',
            ),
            'icon' => array(
                'title' => '图标',
                'desc' => '导航栏右上角图标链接。一行一个，格式：链接文字,链接图标,链接URL<br />链接图标请参考 <a href="https://fontawesome.com/icons?d=gallery&m=free" rel="noopener noreferrer" target="_blank">Font Awesome Icons</a>',
            ),
        ),
        'logo' => array(
            'title' => 'Logo',
            'desc' => '博客的 Logo，显示在导航栏最左侧以及页脚左侧。',
            'text' => array(
                'title' => 'Logo 文字',
                'desc' => '留空则显示站点名称。',
            ),
            'img' => array(
                'title' => 'Logo 图片（优先显示）',
                'desc' => 'Logo 图片的相对路径或 URL。',
            ),
        ),
        'post' => array(
            'title' => '文章 & 独立页面',
            'toc' => array(
                'title' => '文章目录开关',
                'options' => array(
                    '0' => '@general.disable',
                    '1' => '@general.enable',
                ),
                'desc' => '是否显示文章目录（TOC），需要启用 TOC Widget。'
            ),
        ),
        'search' => array(
            'title' => '搜索',
            'enable' => array(
                'title' => '站内搜索开关',
                'options' => array(
                    '0' => '@general.disable',
                    '1' => '@general.enable',
                ),
            ),
            'type' => array(
                'title' => '搜索引擎',
                'options' => array(
                    'internal' => '内置搜索',
                ),
            ),
        ),
    ),
);