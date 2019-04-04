<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
class Icarus_Aside
{
    const LEFT = 0;
    const RIGHT = 1;

    const ENABLE = '1';
    const DISABLE = '0';

    private $_position;
    private $_widgets = array();
    
    private static $_asideWidgets = array(
        'Profile', 
        'Category', 
        'Link', 
        'RecentPost', 
        'Archive', 
        'Tag', 
        'Toc'
    );

    public static $asideLeft = NULL;
    public static $asideRight = NULL;

    public static function init()
    {
        self::$asideLeft = new self(self::LEFT);
        self::$asideRight = new self(self::RIGHT);
    }

    public static function config($form)
    {
        $form->packTitle('Aside');

        $form->packRadio('Aside/left_sticky', array('0', '1'), '0');
        $form->packRadio('Aside/right_sticky', array('0', '1'), '0');

        $form->packRadio('Aside/left_post_hide', array('0', '1'), '0');
        $form->packRadio('Aside/right_post_hide', array('0', '1'), '0');

        $form->packCheckbox('Aside/non_post_hide_widget', self::$_asideWidgets);
        $form->packCheckbox('Aside/post_hide_widget', self::$_asideWidgets);
    }

    public function __construct($position)
    {
        $this->_position = $position;
        if (Icarus_Util::$widget->is('post'))
        {
            switch ($position)
            {
                case self::LEFT:
                    if (Icarus_Config::get('aside_left_post_hide', false)) {
                        return;
                    }
                    break;
                case self::RIGHT:
                    if (Icarus_Config::get('aside_right_post_hide', false)) {
                        return;
                    }
                    break;
            }
        }
        $seqMap = array();
        $hiddenWidgets = Icarus_Util::$widget->is('post') ? Icarus_Config::get('aside_post_hide_widget') : Icarus_Config::get('aside_non_post_hide_widget');
        
        if (!is_array($hiddenWidgets))
            $hiddenWidgets = array();

        // categories / tags page patch
        if (Icarus_Util::$widget->is('page', 'categories') && !in_array('Category', $hiddenWidgets))
        {
            $hiddenWidgets[] = 'Category';
        }
        if (Icarus_Util::$widget->is('page', 'tags') && !in_array('Tag', $hiddenWidgets))
        {
            $hiddenWidgets[] = 'Tag';
        }
        
        foreach (self::$_asideWidgets as $widgetName)
        {
            if (Icarus_Module::enabled($widgetName) && self::getWidgetPosition($widgetName) == $position && !in_array($widgetName, $hiddenWidgets))
            {
                $this->_widgets[] = $widgetName;
                $seqMap[$widgetName] = self::getWidgetSeq($widgetName);
            }
        }

        usort($this->_widgets, function($a, $b) use($seqMap){
            $seqA = $seqMap[$a];
            $seqB = $seqMap[$b];
            if ($seqA == $seqB)
            {
                return strcmp($a, $b);
            }
            return $seqA < $seqB ? -1 : 1;
        });
    }

    public static function getColumnCount()
    {
        return 1 + (self::$asideLeft->count() > 0) 
                 + (self::$asideRight->count() > 0);
    }

    public function clear()
    {
        $this->_widgets = array();
    }
    
    public static function getWidgetPosition($name)
    {
        return Icarus_Config::get(Icarus_Util::parseName($name) . '_position', 'left') == 'right' ? self::RIGHT : self::LEFT;
    }

    public static function getWidgetSeq($name)
    {
        return intval(Icarus_Config::get(Icarus_Util::parseName($name) . '_seq', 0));
    }

    public static function printSideColumnClass()
    {
        switch (self::getColumnCount()) {
            case 2:
                echo ' is-4-tablet is-4-desktop is-4-widescreen';
                break;
            case 3:
                echo ' is-4-tablet is-4-desktop is-3-widescreen';
                break;
        }
    }
    public function printVisibilityClass()
    {
        //if (self::getColumnCount() === 3 && $this->_position == self::RIGHT) {
        //    echo ' is-hidden-touch is-hidden-desktop-only';
        //}
    }

    public function printOrderClass()
    {
        echo ($this->_position == self::RIGHT) ? ' has-order-3' : ' has-order-1';
    }

    public function printStickyClass()
    {
        self::printStickyClassByPos($this->_position);
    }

    public function printPosition()
    {
        echo ($this->_position == self::RIGHT) ? ' column-right' : ' column-left';
    }

    public static function printStickyClassByPos($position)
    {
        if (Icarus_Config::get(($position == self::RIGHT) ? 'aside_right_sticky' : 'aside_left_sticky', false))
        {
            echo ' is-sticky';
        }
    }

    public function output()
    {
        if ($this->count() == 0) 
            return;
?>
<aside class="column<?php $this->printSideColumnClass() ?><?php $this->printVisibilityClass(); ?><?php $this->printOrderClass(); ?><?php $this->printPosition(); ?><?php $this->printStickyClass(); ?>">
<?php
foreach ($this->_widgets as $widgetName) {
    Icarus_Module::show($widgetName);
}
?>
</aside>
<?php
    }

    public function count()
    {
        return count($this->_widgets);
    }

    public static function basicConfig($form, $widgetName, $defaultEnable, $defaultPosition, $defaultIndex)
    {
        $widgetCfgName = Icarus_Util::parseName($widgetName);
        
        $form->packTitle($widgetName);

        $form->makeRadio(
            $widgetCfgName . '_enable', 
            _IcT('setting.aside_common.enable.title'), 
            _IcT('setting.aside_common.enable.desc'), 
            array(
                '0' => _IcT('setting.aside_common.enable.options.0'),
                '1' => _IcT('setting.aside_common.enable.options.1'),
            ),
            $defaultEnable
        );

        $form->makeRadio(
            $widgetCfgName . '_position', 
            _IcT('setting.aside_common.position.title'), 
            _IcT('setting.aside_common.position.desc'), 
            array(
                'left' => _IcT('setting.aside_common.position.options.left'),
                'right' => _IcT('setting.aside_common.position.options.right'),
            ),
            $defaultPosition
        );

        $form->makeIntInput(
            $widgetCfgName . '_seq', 
            _IcT('setting.aside_common.seq.title'), 
            _IcT('setting.aside_common.seq.desc'),
            $defaultIndex,
            'w-20'
        );
    }
}