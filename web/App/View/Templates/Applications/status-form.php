<?php

use App\Model\DTO\Applications;

/**
 * @var Applications $application
 */

$applicationStatuses = [
    Applications::STATUS_OPEN => 'Open',
    Applications::STATUS_CLOSED => 'Closed',
    Applications::STATUS_CANCELLED => 'Cancelled'
]; ?>

<h3>
    Application: <?= htmlspecialchars($application->getTitle()); ?>
</h3>

<hr>

<h4>Change Status</h4>

<form action="/applications/update-status?id=<?= $application->getId(); ?>" method="post">
    <div class="row">
        <label>
            <select name="status" required>
                <?php
                    foreach ($applicationStatuses as $value => $status) { ?>
                        <option value="<?= $value ?>" <?= $application->getStatus() === $value ? 'selected' : ''; ?>>
                            <?= $status; ?>
                        </option>
                    <?php }
                ?>
            </select>
        </label>
    </div>

    <br>

    <div class="row">
        <input type="submit" name="submit" value="Change">
    </div>
</form>
