<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit;

class Icarus_Form_Element_Text extends Typecho_Widget_Helper_Form_Element_Text
{
    public function value($value)
    {
        if (!is_null($value))
            return parent::value($value);
        else
            return $this;
    }
}

class Icarus_Form_Element_Textarea extends Typecho_Widget_Helper_Form_Element_Textarea
{
    public function value($value)
    {
        if (!is_null($value))
            return parent::value($value);
        else
            return $this;
    }
}

class Icarus_Form_Element_Radio extends Typecho_Widget_Helper_Form_Element_Radio
{
    public function value($value)
    {
        if (!is_null($value))
            return parent::value($value);
        else
            return $this;
    }
}

class Icarus_Form_Element_Checkbox extends Typecho_Widget_Helper_Form_Element_Checkbox
{
}

class Icarus_Form_VersionField extends Typecho_Widget_Helper_Form_Element_Hidden
{
    public function __construct()
    {
        parent::__construct(Icarus_Config::prefixKey('config_version'), NULL, __ICARUS_CFG_VERSION__);
    }

    public function value($value)
    {
        return parent::value(__ICARUS_CFG_VERSION__);
    }
}

class Icarus_Form_ConfigBackup extends Typecho_Widget_Helper_Form_Element
{
    public function __construct()
    {
        parent::__construct('icarus_backup', NULL, NULL, '主题设置备份', NULL);
    }

    /**
     * 初始化当前输入项
     *
     * @access public
     * @param string $name 表单元素名称
     * @param array $options 选择项
     * @return Typecho_Widget_Helper_Layout
     */
    public function input($name = NULL, array $options = NULL)
    {
        $backupExist = intval(Icarus_Backup::exist());
        $security = Helper::security();

        $backupStatusText = new Typecho_Widget_Helper_Layout('p');
        $backupStatusText->html(_IcT('setting.backup.status.' . $backupExist));
        $this->container($backupStatusText);

        $saveBackupButton = new Typecho_Widget_Helper_Layout(
            'button',
            array(
                'class' => 'btn primary btn-xs icarus-backup-action',
                'data-url' => $security->getAdminUrl('options-theme.php?icarus_action=backup_save')
            )
        );
        $saveBackupButton->html(_IcT('setting.backup.action.save'));
        $this->container($saveBackupButton);

        if ($backupExist) {
            $deleteBackupButton = new Typecho_Widget_Helper_Layout(
                'button',
                array(
                    'class' => 'btn btn-warn btn-xs icarus-backup-action',
                    'data-url' => $security->getAdminUrl('options-theme.php?icarus_action=backup_delete')
                )
            );
            $deleteBackupButton->html(_IcT('setting.backup.action.delete'));
            $this->container($deleteBackupButton);

            $restoreBackupButton = new Typecho_Widget_Helper_Layout(
                'button',
                array(
                    'class' => 'btn btn-xs icarus-backup-action',
                    'data-url' => $security->getAdminUrl('options-theme.php?icarus_action=backup_restore')
                )
            );
            $restoreBackupButton->html(_IcT('setting.backup.action.restore'));
            $this->container($restoreBackupButton);
        }

        $script = new Typecho_Widget_Helper_Layout('script');
        $script->html(self::BACKUP_SCRIPT);
        $this->container($script);
            
        return NULL;
    }

    /**
     * 设置表单元素值
     *
     * @access protected
     * @param mixed $value 表单元素值
     * @return void
     */
    protected function _value($value)
    {
    }

    const BACKUP_SCRIPT = <<<SCRIPT
document.addEventListener('DOMContentLoaded', function () {
    $('.icarus-backup-action').click(function () {
        $.post(
            $(this).data('url'), 
            null,
            function (result) {
                console.log(result);
                switch (result.action) {
                    case "refresh":
                        document.location.reload();
                    break;
                }
            }
        );
        
        return false;
    });
});
SCRIPT;
}
