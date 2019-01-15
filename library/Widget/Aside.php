<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
class Icarus_Widget_Aside
{
    public static function output($isRight)
    {
        // dummy
        echo $isRight ? '<div>Right</div>' : '<div>Left</div>';
    }
}