<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit;
/*//const services = has_config('donate') ? get_config('donate') : []; ?>
<?php if (!$services.length > 0) { ?>
<div class="card">
    <div class="card-content">
        <h3 class="menu-label has-text-centered"><?php= __('donate.title') ?></h3>
        <div class="buttons is-centered">
            <?php for (let service of services) {
                const type = get_config_from_obj(service, 'type');
                if (type !== null) { ?>
                <?php echo partial('donate/' + type, { type, service }) ?>
                <?php }
            } ?>
        </div>
    </div>
</div>
<?php }*/ ?>