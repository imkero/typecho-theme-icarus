<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
class Icarus_Module_Search
{
    public static function output()
    {

    }

    public static function config($form)
    {
        $form->packTitle('search');

        $form->packRadio('search_enable', array('0', '1'), '1');
        $form->packRadio('search_type', array('internal'), 'internal');
    }
}