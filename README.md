<p align="center">
<img height="48" src="https://ppoffice.github.io/hexo-theme-icarus/images/logo.svg">
<br> 
A simple, delicate and modern theme | 一个简洁、精致、现代的 Typecho 主题
<br>
本主题为 <a href="https://github.com/ppoffice">Ruipeng Zhang</a> 的 Hexo 主题 <a href="https://github.com/ppoffice/hexo-theme-icarus/">Icarus</a> 的 Typecho 移植版本。
</p>

## 预览 Preview

![Icarus Preview](https://user-images.githubusercontent.com/32296555/55554465-6ca20d00-5715-11e9-852d-3072f1571854.png)

- Typecho Demo: [KeNorizon's Blog](https://blog.kenorizon.cn/)
- Hexo Demo (Original Theme): [hexo-theme-icarus](https://blog.zhangruipeng.me/hexo-theme-icarus/)
- [图片预览](https://github.com/KeNorizon/typecho-theme-icarus/wiki/%E5%9B%BE%E7%89%87%E9%A2%84%E8%A7%88)

## 安装 Installation

1. 从 GitHub 上获取本主题。

   获取途径如下：

   - 下载[最新发布版本](https://github.com/KeNorizon/typecho-theme-icarus/releases)（较稳定）
   - 下载[最新的 master 分支](https://github.com/KeNorizon/typecho-theme-icarus/archive/master.zip)（包含新的特性，不保证稳定性）

2. 将本主题压缩包解压到 Typecho 博客的 `usr/themes/icarus/` 目录下。
3. 前往 Typecho 控制台 - 网站外观 - 可以使用的外观 页面，启用 Icarus 主题。

## 更新 Upgrade

1. 重复 `安装` 步骤第1、2步。
2. 前往 Typecho 控制台 - 网站外观 - 设置外观 页面，(若有设置项更新提示，则）根据提示点击 `保存设置` 按钮以应用新版本的设置项。

## 特性 Feature

### 基于 Bulma 的外观
本主题使用基于 Flexbox 的 [Bulma CSS 框架](https://bulma.io/) 提供其外观。

### 常用 Widget 支持
本主题中的 Widget 指侧边栏中的各个小部件。支持 Widget 包括：
- 简介：显示包括头像、昵称、社交网络链接、博客信息等。
- 归档：按月份列出归档页面链接。
- 链接：用于放置一些链接。
- 分类/最新文章/标签：列出站点的最新文章/分类/标签。
- TOC：显示文章目录（只在文章页面显示）。

### Widget 自由布局
侧边栏 Widget 显示哪些、显示的顺序和左右位置均可自由设定，可以据此调整站点的总体外观。各个 Widget 通用的三个设置项说明如下：

- **开关**：通过设定开关以决定 Widget 是否显示。
- **顺序**：通过顺序数值的大小决定 Widget 排列的顺序。
- **位置**：允许指定 Widget 显示在左边栏还是右边栏。

#### 单栏 / 双栏 / 三栏切换
主题默认为三栏布局。若要切换为双栏，则需要在设置中将一侧的 Widget 关闭或移动到另一侧。若要切换为单栏，则需要关闭全部 Widget。

#### 首页 / 文章页侧边栏独立设置
通过设定在首页、文章页分别**隐藏**何种 Widget，可以为首页、文章页设定不同的侧边栏布局。

### 多国语言支持
暂时只有中文支持。将会追加英文翻译支持。

### 响应式布局
在手机、平板、桌面端均有良好的显示效果。

### 外部功能支持
以下功能通过开源组件提供支持。
- 代码高亮：[highlight.js](https://highlightjs.org/) 提供支持。可在设置中指定代码高亮使用的样式主题。
- 人性化时间转换：[Moment.js](https://momentjs.com/) 提供支持。将文章发布时间、评论发表时间转换为更易读的表达形式。
- 图片展示优化：[lightgallery](https://sachinchoolur.github.io/lightGallery/) 提供图片灯箱展示支持。[Justified Gallery](https://miromannino.github.io/Justified-Gallery/) 提供图集展示支持。
- 数学公式渲染：[Mathjax](https://www.mathjax.org/) 提供支持。

### 完善的主题设置页面
本主题设置项较多，设置页面按功能进行了划分，并提供了相应的描述。悬浮在右侧的目录可点击跳转到指定设置项。

提供了主题设置的备份功能，避免切换主题导致的设置项丢失。

### 可选的主题资源 CDN
暂只提供了 JsDelivr CDN 支持。将来会追加其他 CDN 选项。

### 页头 / 页脚 / 导航栏 / 评论区自定义
- 自定义第三方评论系统支持（需要自行填入第三方评论系统的调用代码）。
- 页头、页脚、head标签自定义内容追加支持。
- 导航栏、Social Icons、页脚 Icons 可自定义。
