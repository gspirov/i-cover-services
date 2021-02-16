<?php

use App\Http\Renderer\ViewRenderer;

$viewRenderer = new ViewRenderer; ?>

<h3>Create Service</h3>

<?= $viewRenderer->partial('Services/form')->getContent(); ?>