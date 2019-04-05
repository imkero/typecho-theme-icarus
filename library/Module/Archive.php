<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
class Icarus_Module_Archive
{
    public static function config($form)
    {
        Icarus_Aside::basicConfig($form, 'Archive', Icarus_Aside::ENABLE, 'right', '1');
    }

    public static function output()
    {
?>
<div class="card widget">
    <div class="card-content">
        <div class="menu">
        <h3 class="menu-label">
            <?php _IcTp('general.archives'); ?>
        </h3>
        <ul class="menu-list">
<?php 
$tpl = <<<TPL
<li>
    <a class="level is-marginless" href="{permalink}">
        <span class="level-start">
            <span class="level-item">{date}</span>
        </span>
        <span class="level-end">
            <span class="level-item tag">{count}</span>
        </span>
    </a>
</li>
TPL;
Typecho_Widget::widget(
    'Widget_Contents_Post_Date', 
    array(
        'type' => 'month',
        'format' => _IcT('archive.date_format')
    ))->parse($tpl);
?>        
        </ul>
        </div>
    </div>
</div>
<?php
    }
}