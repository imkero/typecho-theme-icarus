<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
class Icarus_Module_Search
{
    public static function config($form)
    {
        $form->packTitle('Search');

        $form->packRadio('Search/enable', array('0', '1'), '1');
        $form->packRadio('Search/type', array('internal'), 'internal');
    }

    public static function output()
    {

    }
}