<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
class Icarus_Module_Toc
{
    private static $_toc;

    public static function config($form)
    {
        Icarus_Aside::basicConfig($form, 'Toc', Icarus_Aside::ENABLE, 'right', '0');
    }

    public static function output()
    {
        if (!(Icarus_Page::is('post') || Icarus_Page::is('single')))
            return;
        if (!is_array(self::$_toc) || count(self::$_toc) <= 1)
            return;
?>
<div class="card widget" id="toc">
    <div class="card-content">
        <div class="menu">
            <h3 class="menu-label">
                <?php _IcTp('general.toc'); ?>
            </h3>
<?php self::treeViewOutput(0); ?>
        </div>
    </div>
</div>
<?php
    }

    private static function treeViewOutput($index)
    {
        if (!isset(self::$_toc[$index]))
            return;

        if (empty(self::$_toc[$index]['children']))
            return;
?>
<ul class="menu-list">
<?php 
foreach (self::$_toc[$index]['children'] as $k): 
$item = self::$_toc[$k];
?>
<li>
<?php if (isset($item['id'])): ?>
    <a class="is-flex" href="#<?php echo $item['id']; ?>">
        <span class="has-mr-6"><?php echo $item['index']; ?>.</span>
        <span><?php echo $item['title']; ?></span>
    </a>
<?php 
endif;
self::treeViewOutput($k);
?>
</li>
<?php endforeach; ?>
</ul>
<?php
    }

    public static function generate($content)
    {
        self::$_toc = array(
            0 => array(
                'parent' => null, 
                'children' => array(), 
            ),
        );

        $tocNumStack = array();

        $content = preg_replace_callback(
            '/<h([2-6])(|\s[^>]*)>(.*?)<\/h\1>/i', 
            function ($matches) use(&$tocNumStack) {
                $tocIndex = count(self::$_toc) - 1;
                $depthCounter = count($tocNumStack);
                
                $depth = intval($matches[1]) - 1;
                $title = trim(strip_tags($matches[3]));

                if ($depthCounter < $depth)
                {
                    for (; $depthCounter < $depth - 1; $depthCounter++)
                    {
                        $newIndex = count(self::$_toc);
                        self::$_toc[] = array(
                            'parent' => $tocIndex,
                            'children' => array(),
                        );
                        self::$_toc[$tocIndex]['children'][] = $newIndex;
                        $tocIndex = $newIndex;
                        $tocNumStack[] = 1;
                    }
                    if (count($tocNumStack) < $depth)
                    {
                        $tocNumStack[] = 0;
                    }
                }
                else
                {
                    array_splice($tocNumStack, $depth);
                    for (; $depthCounter >= $depth; $depthCounter--)
                    {
                        $tocIndex = self::$_toc[$tocIndex]['parent'];
                    }
                }

                $newIndex = count(self::$_toc);
                $tocNumStack[$depth - 1]++;
                $id = preg_replace(
                    '/\s+/', 
                    '-', 
                    implode('-', $tocNumStack) . '-' . $title
                );
                self::$_toc[] = array(
                    'parent' => $tocIndex,
                    'children' => array(),
                    'id' => $id,
                    'title' => $title,
                    'index' => $tocNumStack[$depth - 1],
                );
                self::$_toc[$tocIndex]['children'][] = $newIndex;
                $tocIndex = $newIndex;
                
                return "<h{$matches[1]} id=\"{$id}\"{$matches[2]}>{$matches[3]}</h{$matches[1]}>";
            },
            $content
        );
        return $content;
    }
}