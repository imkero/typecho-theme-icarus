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
        'year_tpl' => '%d年',
        'month_tpl' => '%d月',
        'author' => '作者',
        'search' => '搜索',
        'comments' => '评论',
        'logout' => '登出',
    ),
    'empty' => array(
        'category' => array(
            'title' => '这个分类下还没有文章 ;-)',
            'desc' => 'Empty category',
            'jump' => '查看其他分类',
        ),
        'tag' => array(
            'title' => '这个标签下还没有文章',
            'desc' => 'Empty Tag',
            'jump' => '查看其他标签',
        ),
        'search' => array(
            'title' => '找不到与这个关键词相关的文章',
            'desc' => 'Empty Search Result',
            'jump' => '再次搜索',
        ),
        'author' => array(
            'title' => '这位作者还没有文章',
            'desc' => 'Empty Tag',
        ),
        'date' => array(
            'title' => '这一段时间内没有文章发布',
            'desc' => 'Empty Archive',
            'jump' => '查看归档',
        ),
    ),
    '404' => array(
        'title' => '404 Not found.',
        'desc' => '页面未找到',
    ),
    'title' => array(
        'category' => '「%s」分类下的文章',
        'search' => '包含关键字「%s」的文章',
        'tag' => '「%s」标签下的文章',
        'author' => '%s 发布的文章',
        'date' => '%s发布的文章'
    ),
    'search' => array(
        'title' => '搜索',
        'placeholder' => '输入关键字搜索',
    ),
    'article' => array(
        'more' => '阅读全文',
    ),
    'profile' => array(
        'follow' => '关注我',
        'run_days' => '天数',
    ),
    'archive' => array(
        'date_format' => 'Y&\t\h\i\n\sp;年&\t\h\i\n\sp;n&\t\h\i\n\sp;月',
    ),
    'link' => array(
        'title' => '链接',
    ),
    'recent_post' => array(
        'title' => '最新文章',
    ),
    'back_to_top' => array(
        'title' => '返回顶部',
    ),
    'comments' => array(
        'do_comment_title' => '添加新评论',
        'do_comment' => '发表评论',
        'logined' => '登录身份：',
        'disabled' => '评论已关闭',
        'is_author' => '作者',
        'is_waiting' => '待审核',
        'num' => array(
            '0' => '暂无',
            '1' => '1 条',
            'more' => '%d 条',
        ),
        'input' => array(
            'name' => '昵称',
            'email' => '邮箱（可选）',
            'email_required' => '邮箱',
            'url' => '链接（可选）',
            'url_required' => '链接',
            'text' => '',
        ),
        'guide' => array(
            'name' => '填写您的昵称或姓名，将和您的评论一同显示。',
            'email' => '可选，保密。填写您的邮箱地址，用于显示 Gravatar 头像以及接收通知。',
            'email_required' => '必填，保密。填写您的邮箱地址，用于显示 Gravatar 头像以及接收通知。',
            'url' => '可选。可以填写您的博客或主页的链接。',
            'url_required' => '请填写您的博客或主页的链接。',
        ),
    ),
    'setting' => array(
        'general' => array(
            'title' => '基本',
            'desc' => '
<p><b>注意事项</b></p>
<ul class="icaurs-general-desc-list">
<li>资源文件的相对路径是指相对于 <code> %s/assets/</code> 目录的相对路径。</li>
<li>更换主题会导致本主题的设置项丢失，如有需要请使用<b>主题设置备份</b>功能。</li>
<li><b>归档页面</b>、<b>分类页面</b>和<b>标签页面</b>，需要手动<a href="%s">创建相应的独立页面</a>才能显示。</li>
</ul>
',
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
            'extend' => array(
                'title' => '&lt;head&gt; 标签内追加内容',
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
            'default_value' => "首页,%s\n归档,%s\n分类,%s",
        ),
        'logo' => array(
            'title' => 'Logo',
            'desc' => '站点的 Logo，显示在导航栏最左侧以及页脚左侧。',
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
            'title' => '文章',
            'excerpt_preserve_tags' => array(
                'title' => '摘要保留样式',
                'options' => array(
                    '0' => '不保留',
                    '1' => '保留',
                ),
                'desc' => '在文章列表中的摘要部分保留原文样式（段落、代码高亮等）',
            ),
            'excerpt_length' => array(
                'title' => '摘要长度',
                'desc' => '指定自动生成的摘要部分的最大长度。参数值为 <code>-1</code> 则不限制最大长度。<br />需要设置 <code>摘要保留样式</code> 为 <code>不保留</code>才能生效。<br />原文中已指定摘要部分时本参数将被忽略（即包含 <code>&lt;!--more--&gt;</code> 标签）',
            ),
            'tiny_item' => array(
                'title' => '简洁文章条目',
                'options' => array(
                    '0' => '不启用',
                    '1' => '启用',
                ),
                'desc' => '使用简洁风格的文章条目展示（隐藏摘要）。',
            ),
            'content_extend' => array(
                'title' => '文章末尾追加内容',
                'desc' => '在文章末尾追加指定内容。支持以下变量替换 <code>{author}</code> <code>{title}</code> <code>{url}</code> <code>{date}</code>',
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
        'plugin_common' => array(
            'enable' => array(
                'title' => '插件开关',
                'options' => array(
                    '0' => '@general.disable',
                    '1' => '@general.enable',
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
                'desc' => '位置上是作者昵称的下一行。留空则不显示。',
            ),
            'location' => array(
                'title' => '作者坐标',
                'desc' => '位置上是作者头衔的下一行。留空则不显示。',
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
                'title' => '固定左边栏',
                'desc' => '固定左边栏，使其不随页面滚动。',
                'options' => array(
                    '0' => '@general.disable',
                    '1' => '@general.enable',
                ),
            ),
            'right_sticky' => array(
                'title' => '固定右边栏',
                'desc' => '固定右边栏，使其不随页面滚动。',
                'options' => array(
                    '0' => '@general.disable',
                    '1' => '@general.enable',
                ),
            ),
            'left_post_hide' => array(
                'title' => '文章页隐藏左边栏',
                'desc' => '在文章和独立页面隐藏左边栏。',
                'options' => array(
                    '0' => '@general.disable',
                    '1' => '@general.enable',
                ),
            ),
            'right_post_hide' => array(
                'title' => '文章页隐藏右边栏',
                'desc' => '在文章和独立页面隐藏右边栏。',
                'options' => array(
                    '0' => '@general.disable',
                    '1' => '@general.enable',
                ),
            ),
            'non_post_hide_widget' => array(
                'title' => '非文章页面隐藏 Widget',
                'desc' => '指定在首页和独立页面隐藏部分 Widget。',
                'options' => array(
                    'Profile' => '@setting.profile.title', 
                    'Category' => '@setting.category.title', 
                    'Link' => '@setting.link.title', 
                    'RecentPost' => '@setting.recent_post.title', 
                    'Archive' => '@setting.archive.title', 
                    'Tag' => '@setting.tag.title', 
                    'Toc' => '@setting.toc.title'
                ),
            ),
            'post_hide_widget' => array(
                'title' => '文章页面隐藏 Widget',
                'desc' => '指定在文章页面隐藏部分 Widget。',
                'options' => array(
                    'Profile' => '@setting.profile.title', 
                    'Category' => '@setting.category.title', 
                    'Link' => '@setting.link.title', 
                    'RecentPost' => '@setting.recent_post.title', 
                    'Archive' => '@setting.archive.title', 
                    'Tag' => '@setting.tag.title', 
                    'Toc' => '@setting.toc.title'
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
        'recent_post' => array(
            'title' => '最新文章 Widget',
            'desc' => '列出指定数目的最新文章。',
            'limit' => array(
                'title' => '数目',
                'desc' => '最多显示的文章数。留空或非正数则默认为显示5篇。',
            ),
            'thumbnail' => array(
                'title' => '缩略图',
                'desc' => '在文章标题旁显示缩略图。',
                'options' => array(
                    '0' => '@general.disable',
                    '1' => '@general.enable',
                ),
            ),
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
                'desc' => '显示在页脚的链接。一行一个，格式：<code>链接文字,链接图标,链接URL</code><br />链接图标请参考 <a href="https://fontawesome.com/icons?d=gallery&m=free" rel="noopener noreferrer" target="_blank">Font Awesome Icons</a>',
            ),
            'content_left' => array(
                'title' => '页脚左侧追加内容',
                'desc' => '显示位置在 Copyright 以后。',
            ),
            'scripts' => array(
                'title' => '页末追加脚本',
                'desc' => '用于在页面末尾追加统计脚本等不可见内容。',
            ),
        ),
        'moment' => array(
            'title' => 'Moment 插件',
            'desc' => '将具体的时间（如：2018-12-31）转换为更人性化的显示格式（如：1小时前）',
        ),
        'animejs' => array(
            'title' => 'Animejs 插件',
            'desc' => '为页面添加动画效果。',
        ),
        'highlight' => array(
            'title' => 'highlight.js 插件',
            'desc' => '提供代码高亮功能。',
            'theme' => array(
                'title' => '主题名称',
                'desc' => '可以选用的主题名称请参考 <a href="https://highlightjs.org/static/demo/" rel="noreferrer noopener" target="_blank">highlight.js demo</a><br />默认主题：<code>atom-one-light</code>',
            ),
        ),
        'back_to_top' => array(
            'title' => '返回顶部插件',
            'desc' => '显示一个「返回顶部」按钮。',
        ),
        'clipboard'  => array(
            'title' => '剪贴板插件',
            'desc' => '在代码块上提供一个「复制」按钮。',
        ),
        'gallery' => array(
            'title' => 'Gallery 插件',
            'desc' => '利用 lightGallery 提供单张图片的灯箱效果，以及 Justified Gallery 实现图集显示。<br />图集调用方式：使用下述标签包围多张图片作为一个图集进行显示。<code>[gallery]</code><code>[/gallery]</code>',
        ),
        'mathjax' => array(
            'title' => 'Mathjax 插件',
            'desc' => '提供数学公式显示支持。修改 <code>assets/js/mathjax.js</code> 文件以进行具体配置。',
        ),
        'outdated_browser' => array(
            'title' => 'Outdated Browser 插件',
            'desc' => '向使用过时的浏览器的用户显示一个友好的提示。',
        ),
        'progressbar' => array(
            'title' => '进度条插件',
            'desc' => '在页面顶部显示一个加载进度条。',
        ),
        'comments' => array(
            'title' => '评论',
            'desc' => '文章、独立页面评论的相关设置',
            'type' => array(
                'title' => '评论系统',
                'desc' => '决定使用何种评论系统提供评论功能。',
                'options' => array(
                    'internal' => '内置评论',
                    'custom' => '自定义',
                ),
            ),
            'default_avatar' => array(
                'title' => '评论默认头像',
                'desc' => '指定当评论者没有设定 Gravatar 头像时显示的默认头像。<a href="https://cn.gravatar.com/site/implement/images/#default-image" rel="noopener noreferrer nofollow" target="_blank">参考</a>',
            ),
            'custom_content' => array(
                'title' => '自定义评论区代码',
                'desc' => '设定评论系统为 自定义 时，请将评论区相关代码填入此文本框内，<code>{identifier}</code> 将被替换为当前页面的标识符。',
            ),
        ),
        'assets' => array(
            'title' => '资源与 CDN',
            'desc' => '合理配置主题所需的资源文件的加载路径以提高页面加载速度。',
            'theme_assets_base' => array(
                'title' => '主题资源 CDN',
                'desc' => '留空则默认为主题目录下的 assets 目录。设置本设置项后请将主题目录下的 assets 目录内的文件复制到 CDN 的对应位置。',
            ),
            'public_assets' => array(
                'title' => '公共资源 CDN',
                'options' => array(
                    'jsdelivr' => 'JsDelivr',
                    'cdnjs' => 'cdnjs',
                    'loli' => 'loli.net',
                ),
            ),
            'public_icon' => array(
                'title' => '公共图标资源 CDN',
                'options' => array(
                    'fontawesome' => 'FontAwesome',
                    'jsdelivr' => 'JsDelivr',
                    'cdnjs' => 'cdnjs',
                    'loli' => 'loli.net',
                ),
            ),
            'public_font' => array(
                'title' => '公共字体资源 CDN',
                'options' => array(
                    'google' => 'Google Fonts',
                    'loli' => 'loli.net',
                ),
            ),
            'public_gravatar' => array(
                'title' => '公共 Gravatar CDN',
                'options' => array(
                    'v2ex' => 'V2EX',
                    'gravatar' => 'Gravatar',
                    'loli' => 'loli.net',
                ),
            ),
        ),
        'cfg_version_notice' => 'Icarus 主题已更新至版本 %s，请点击保存设置按钮使新的设置项生效。',
        'backup' => array(
            'status' => array(
                '0' => '备份状态：不存在',
                '1' => '备份状态：存在',
            ),
            'action' => array(
                'save' => '备份设置',
                'delete' => '删除备份',
                'restore' => '恢复备份',
            ),
            'result' => array(
                'save' => array(
                    '0' => '备份设置成功',
                    '1' => '备份设置失败：写入备份失败',
                ),
                'delete' => array(
                    '0' => '删除备份成功',
                    '1' => '删除备份失败：备份不存在',
                    '2' => '删除备份失败：未知错误',
                ),
                'restore' => array(
                    '0' => '恢复备份成功',
                    '1' => '恢复备份失败：备份不存在',
                    '2' => '恢复备份失败：写入设置时出错',
                ),
            ),
        ),
    ),
    'fields' => array(
        'thumbnail' => array(
            'title' => '缩略图 URL',
            'desc' => '文章缩略图的 URL。缩略图会显示在文章列表、文章正文页以及最新文章 Widget 中。',
        ),
        'excerpt' => array(
            'title' => '自定义文章摘要',
            'desc' => '填写此文本框则使用其中内容作为本文章的摘要。（支持 Markdown 解析）',
        ),
    ),
    'page_special' => array(
        'title' => 'Icarus 内置页面说明',
        'desc' => array(
            'archives' => '<p>归档页面展示要求：新建一个缩略名为 <code><a href="javascript:;" class="icarus-autofill-slug" data-title="归档" title="点击自动填入">archives</a></code> 的独立页面。</p>',
            'categories' => '<p>分类页面展示要求：新建一个缩略名为 <code><a href="javascript:;" class="icarus-autofill-slug" data-title="分类" title="点击自动填入">categories</a></code> 的独立页面。</p>',
            'tags' => '<p>标签页面展示要求：新建一个缩略名为 <code><a href="javascript:;" class="icarus-autofill-slug" data-title="标签" title="点击自动填入">tags</a></code> 的独立页面。</p>',
        ),
    ),
);