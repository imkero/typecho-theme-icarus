<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
class Icarus_Widget_Aside
{
    const LEFT = 0;
    const RIGHT = 1;
    private $_position;
    
    private $_widgets = array();
    
    private static $_asideWidgets = array('Profile', 'Archive');

    public function __construct($position)
    {
        $this->_position = $position;
        $seqMap = array();
        foreach (self::$_asideWidgets as $widgetName)
        {
            if (Icarus_Widget::enabled($widgetName) && self::getWidgetPosition($widgetName) == $position)
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

    public function clear()
    {
        $this->_widgets = array();
    }
    
    public static function getWidgetPosition($name)
    {
        return Icarus_Config::get(strtolower($name) . '_position', 'left') == 'right' ? self::RIGHT : self::LEFT;
    }

    public static function getWidgetSeq($name)
    {
        return intval(Icarus_Config::get(strtolower($name) . '_seq', 0));
    }

    public static function printSideColumnClass()
    {
        switch (Icarus_Widget::getColumnCount()) {
            case 2:
                echo 'is-4-tablet is-4-desktop is-4-widescreen';
                break;
            case 3:
                echo 'is-4-tablet is-4-desktop is-3-widescreen';
                break;
        }
    }
    public function printVisibilityClass()
    {
        if (Icarus_Widget::getColumnCount() === 3 && $this->_position == self::RIGHT) {
            echo 'is-hidden-touch is-hidden-desktop-only';
        }
    }

    public function printOrderClass()
    {
        echo ($this->_position == self::RIGHT) ? 'has-order-3' : 'has-order-1';
    }

    public function printStickyClass()
    {
        self::printStickyClassByPos($this->_position);
    }

    public function printPosition()
    {
        echo $this->_position ? 'right' : 'left';
    }

    public static function printStickyClassByPos($position)
    {
        if (Icarus_Config::get(($position == self::RIGHT) ? 'aside_right_sticky' : 'aside_left_sticky', false))
        {
            echo 'is-sticky';
        }
    }

    public function output()
    {
        if ($this->count() == 0) 
            return;
?>
<aside class="column <?php $this->printSideColumnClass() ?> <?php $this->printVisibilityClass(); ?> <?php $this->printOrderClass(); ?> column-<?php $this->printPosition(); ?> <?php $this->printStickyClass(); ?>">
<?php
foreach ($this->_widgets as $widgetName) {
    Icarus_Widget::show($widgetName);
}
if (!$this->_position): 
?>
    <div class="column-right-shadow is-hidden-widescreen <?php $this->printStickyByPos(self::RIGHT); ?>">
<?php
foreach (Icarus_Widget::$widgetRight->_widgets as $widgetName) {
    Icarus_Widget::show($widgetName);
}
?>
    </div>
<?php endif; ?>
</aside>
<?php
    }

    public function count()
    {
        return count($this->_widgets);
    }

    public static function basicConfig($form, $widgetCfgName, $defaultEnable, $defaultPosition, $defaultIndex)
    {
        $form->packTitle($widgetCfgName);

        $form->makeRadio(
            $widgetCfgName . '_enable', 
            _IcT('setting.widget.enable.title'), 
            _IcT('setting.widget.enable.desc'), 
            array(
                '0' => _IcT('setting.widget.enable.options.0'),
                '1' => _IcT('setting.widget.enable.options.1'),
            ),
            $defaultEnable
        );

        $form->makeRadio(
            $widgetCfgName . '_position', 
            _IcT('setting.widget.position.title'), 
            _IcT('setting.widget.position.desc'), 
            array(
                'left' => _IcT('setting.widget.position.options.left'),
                'right' => _IcT('setting.widget.position.options.right'),
            ),
            $defaultPosition
        );

        $form->makeInput(
            $widgetCfgName . '_seq', 
            _IcT('setting.widget.seq.title'), 
            _IcT('setting.widget.seq.desc'),
            $defaultIndex
        );
    }

    public static function config($form)
    {
        $form->packTitle('aside');

        $form->packRadio('aside_left_sticky', array('0', '1'), '0');
        $form->packRadio('aside_right_sticky', array('0', '1'), '0');

        $form->packRadio('aside_left_post_hide', array('0', '1'), '0');
        $form->packRadio('aside_right_post_hide', array('0', '1'), '0');

        foreach (self::$_asideWidgets as $widgetName)
        {
            Icarus_Widget::load($widgetName);
            call_user_func(array('Icarus_Widget_' . $widgetName, 'config'), $form);
        }
    }
}