<?php

use App\Http\Renderer\ViewRenderer;

$viewRenderer = new ViewRenderer; ?>

<h3>Create Application</h3>

<?= $viewRenderer->partial('Applications/form')->getContent(); ?>


