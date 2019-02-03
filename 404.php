<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit;

Icarus_Aside::$asideLeft->clear();
Icarus_Aside::$asideRight->clear();

$this->need('component/header.php');

?>

<div class="card">
    <div class="card-content">
        <p class="title has-text-weight-normal"><?php _IcTp('404.title'); ?></p>
        <p class="subtitle"><?php _IcTp('404.desc'); ?></p>
    </div>
    <div class="card-footer">
        <?php if (!empty($jump)): ?>
        <p class="card-footer-item">
            <span><a href="<?php echo $jumpTarget; ?>" id="icarus-jump-guide"><?php echo $jump; ?></a></span>
        </p>
        <?php endif; ?>
        <p class="card-footer-item">
            <span><a href="/">回到首页</a></span>
        </p>
    </div>
</div>

<?php
$this->need('component/footer.php');
