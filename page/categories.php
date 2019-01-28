<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit;

$this->need('component/header.php');

Icarus_Module::show('Category');

$this->need('component/footer.php');
