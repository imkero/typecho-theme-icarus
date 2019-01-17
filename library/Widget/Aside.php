<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
class Icarus_Widget_Aside
{
    private $_isRight;
    
    private $_widgets = array();
    
    private static $_asideWidgets = array('Profile');

    public function __construct($isRight)
    {
        $this->_isRight = $isRight;
    }

    public function output()
    {
        
    }

    public function count()
    {
        return count($this->_widgets);
    }
}