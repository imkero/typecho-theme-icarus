<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<!DOCTYPE HTML>
<html <?php Icarus_Page::printHtmlLang(); ?>>
<head>
    <meta charset="<?php $this->options->charset(); ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="renderer" content="webkit">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title><?php Icarus_Page::printPageTitle(); ?></title>
    
    <?php 
    Icarus_Assets::printThirdPartyCss('bulma');
    Icarus_Assets::printThemeCss('style.css');
    $this->header(); 
    Icarus_Page::printHeader();
    ?>
</head>
<body class="<?php Icarus_Page::printBodyColumnClass(); ?>">
    <?php $this->need('component/navbar.php'); ?>
    <section class="section">
        <div class="container">
            <div class="columns">
                <div class="column <?php Icarus_Page::printContainerColumnClass(); ?> has-order-2 column-main">
    
