<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
class Icarus_Module_Paginator
{
    public static function output($widget)
    {
        ob_start();
        $widget->pageNav('&laquo;', '&raquo;', 3, '...', array(
            'wrapTag' => 'ul',
            'wrapClass' => 'pagination-list',
            'currentClass' => 'is-current',
            'prevClass' => '',
            'nextClass' => ''
        ));
        $content = ob_get_contents();
        ob_end_clean();
        $content = str_replace(
            array(
                '<li class="is-current"><a href',
                '<li><a href',
                '<li><span',
            ),
            array(
                '<li><a class="pagination-link is-current" href',
                '<li><a class="pagination-link has-text-black-ter" href',
                '<li><span class="pagination-ellipsis has-text-black-ter"',
            ),
            $content
        );
        if (empty($content))
        {
            return;
        }   
?>
<div class="card card-transparent">
    <nav class="pagination is-centered" role="navigation" aria-label="pagination">
        <?php echo $content; ?>
    </nav>
</div>
<?php
    }
}
?>