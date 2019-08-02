<?php
/**
 * Port of Ruipeng Zhang's Hexo theme Icarus to Typecho.
 * 
 * @package Icarus
 * @author Ruipeng Zhang & KeNorizon
 * @version 1.1.4
 * @link https://github.com/KeNorizon/typecho-theme-icarus
 */

if (!defined('__TYPECHO_ROOT_DIR__')) exit;

$this->need('component/header.php');

Icarus_Module::load('Single');
$post = new Icarus_Module_Single($this);
while ($this->next()) 
{
	$post->doOutput();
}

Icarus_Module::show('Paginator', $this);

$this->need('component/footer.php');
