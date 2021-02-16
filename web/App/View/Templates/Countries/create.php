<?php

use App\Http\Renderer\ViewRenderer;

$viewRenderer = new ViewRenderer; ?>

<h3>Create Country</h3>

<?= $viewRenderer->partial('Countries/form')->getContent(); ?>
