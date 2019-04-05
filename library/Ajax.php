<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit;

class Icarus_Ajax
{
    public static function handle()
    {
        $security = Helper::security();
        $request = Typecho_Request::getInstance();
        $notice = Typecho_Widget::widget('Widget_Notice');

        if ($request->isPost() && isset($request->icarus_action))
        {
            ob_clean();
            $security->protect();

            switch ($request->icarus_action)
            {
                case 'backup_save':
                    $result = Icarus_Backup::save();
                    $msgId = 'setting.backup.result.save';
                break;
                case 'backup_delete':
                    $result = Icarus_Backup::delete();
                    $msgId = 'setting.backup.result.delete';
                break;
                case 'backup_restore':
                    $result = Icarus_Backup::restore();
                    $msgId = 'setting.backup.result.restore';
                break;
                default:
                    $notice->set(_IcT($msgId), $result ? 'success' : 'error');
                    Icarus_Util::jsonResponse(array(
                        'action' => 'refresh'
                    ));
                    exit;
                break;
            }
            
            $notice->set(_IcT($msgId . '.' . $result), $result == 0 ? 'success' : 'error');
            Icarus_Util::jsonResponse(array(
                'action' => 'refresh'
            ));
            exit;
        }
    }
}
