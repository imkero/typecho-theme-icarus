<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit;

$this->need('component/header.php');
?>
<div class="card">
    <div class="card-content">
        <nav class="breadcrumb" aria-label="breadcrumbs">
        <ul>
            <li><a href="#">Type</a></li>
            <li><a href="#">Parent Name</a></li>
            <li class="is-active"><a href="#" aria-current="page">Child Name</a></li>
        </ul>
        </nav>
    </div>
</div>
<?php
Icarus_Module::load('Single');
$post = new Icarus_Module_Single($this);
while ($this->next()) 
{
	$post->doOutput();
}

Icarus_Module::show('Paginator', $this);

$this->need('component/footer.php');

