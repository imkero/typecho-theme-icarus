<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
return array(
    'general' => array(
        'enable' => '启用',
        'disable' => '不启用',
        'catalog' => '目录',
        'posts' => '文章',
        'categories' => '分类',
        'archives' => '归档',
        'tags' => '标签',
        'toc' => '文章目录',
    ),
    'search' => array(
        'title' => '搜索',
    ),
    'article' => array(
        'more' => '阅读更多',
    ),
    'profile' => array(
        'follow' => '关注我',
        'run_days' => '天数',
    ),
    'archive' => array(
        'date_format' => 'Y年 n月',
    ),
    'link' => array(
        'title' => '链接',
    ),
    'recentpost' => array(
        'title' => '最新文章',
    ),
    'setting' => array(
        'general' => array(
            'title' => '基本',
            'desc' => '<ul><li>资源文件的相对路径是指相对于 <code> %s/assets/</code> 目录的相对路径。</li></ul>',
            'install_time' => array(
                'title' => '站点建立日期',
                'desc' => '用于计算站点运行时间，显示 Copyright 年份等。格式：2018-12-31',
            ), 
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
                'desc' => '导航栏菜单链接。一行一个，格式：<code>链接文字,链接URL</code>',
            ),
            'icons' => array(
                'title' => '图标',
                'desc' => '导航栏右上角图标链接。一行一个，格式：<code>链接文字,链接图标,链接URL</code><br />链接图标请参考 <a href="https://fontawesome.com/icons?d=gallery&m=free" rel="noopener noreferrer" target="_blank">Font Awesome Icons</a>',
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
        'aside_common' => array(
            'enable' => array(
                'title' => 'Widget 开关',
                'desc' => '只有启用的 Widget 才会显示在页面中。',
                'options' => array(
                    '0' => '@general.disable',
                    '1' => '@general.enable',
                ),
            ),
            'seq' => array(
                'title' => '顺序',
                'desc' => '输入一个整数以指定本 Widget 在一列中显示的先后顺序，数字越小位置越靠前。',
            ),
            'position' => array(
                'title' => '位置',
                'desc' => '指定本 Widget 显示在左边栏还是右边栏。',
                'options' => array(
                    'left' => '左',
                    'right' => '右',
                ),
            ),
        ),
        'profile' => array(
            'title' => '简介 Widget',
            'desc' => '显示头像、昵称、社交网络链接、博客基本信息等。',
            'author' => array(
                'title' => '作者昵称',
                'desc' => '留空则不显示。',
            ),
            'author_title' => array(
                'title' => '作者头衔',
                'desc' => '实际上是作者昵称的下一行。留空则不显示。',
            ),
            'location' => array(
                'title' => '作者坐标',
                'desc' => '实际上是作者头衔的下一行。留空则不显示。',
            ),
            'avatar' => array(
                'title' => '头像 URL',
                'desc' => '头像图片的相对路径或 URL。留空则显示主题默认头像。',
            ),
            'gravatar' => array(
                'title' => '调用 Gravatar 头像',
                'desc' => '填写你的邮箱，调用 Gravatar 显示邮箱对应的头像。优先于本地头像显示。',
            ),
            'follow_link' => array(
                'title' => '「关注我」按钮链接',
                'desc' => '留空则不显示「关注我」按钮。',
            ),
            'social_links' => array(
                'title' => '社交网络链接',
                'desc' => '留空则不显示。水平排列，一行一个，格式：<code>链接文字,链接图标,链接URL</code><br />链接图标请参考 <a href="https://fontawesome.com/icons?d=gallery&m=free" rel="noopener noreferrer" target="_blank">Font Awesome Icons</a>',
            ),
        ),
        'aside' => array(
            'title' => '侧边栏',
            'left_sticky' => array(
                'title' => '左边栏固定',
                'desc' => '固定左边栏，使其不随页面滚动。',
                'options' => array(
                    '0' => '@general.disable',
                    '1' => '@general.enable',
                ),
            ),
            'right_sticky' => array(
                'title' => '右边栏固定',
                'desc' => '固定右边栏，使其不随页面滚动。',
                'options' => array(
                    '0' => '@general.disable',
                    '1' => '@general.enable',
                ),
            ),
            'left_post_hide' => array(
                'title' => '左边栏文章页隐藏',
                'desc' => '在文章和独立页面隐藏左边栏。',
                'options' => array(
                    '0' => '@general.disable',
                    '1' => '@general.enable',
                ),
            ),
            'right_post_hide' => array(
                'title' => '右边栏文章页隐藏',
                'desc' => '在文章和独立页面隐藏右边栏。',
                'options' => array(
                    '0' => '@general.disable',
                    '1' => '@general.enable',
                ),
            ),
        ),
        'archive' => array(
            'title' => '归档 Widget',
            'desc' => '显示按月份列出的归档链接。',
        ),
        'category' => array(
            'title' => '分类 Widget',
            'desc' => '列出各个分类及其子分类。',
        ),
        'link' => array(
            'title' => '链接 Widget',
            'desc' => '显示指定链接。',
            'links' => array(
                'title' => '链接',
                'desc' => '显示在 Widget 中的链接。一行一个，格式：<code>链接文字,链接URL</code>',
            ),
        ),
        'recentpost' => array(
            'title' => '最新文章 Widget',
            'desc' => '列出指定数目的最新文章。文章数目请在 <a href="./options-reading.php">阅读设置</a> 中指定。',
        ),
        'tag' => array(
            'title' => '标签 Widget',
            'limit' => array(
                'title' => '数目',
                'desc' => '最多显示的标签数。为0则显示所有标签。负数或为空默认为显示20个。',
            ),
        ),
        'toc' => array(
            'title' => 'TOC Widget',
            'desc' => 'Table of Contents：文章目录',
        ),
        'footer' => array(
            'title' => '页脚',
            'links' => array(
                'title' => '链接',
                'desc' => '显示在页脚的链接。一行一个，格式：<code>链接文字,链接图标,链接URL</code>',
            ),
        ),
    ),
);