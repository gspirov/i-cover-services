<?php

use App\Model\DTO\Applications;
use App\Model\DTO\ServiceCountryResultRow;

/**
 * @var Applications $application
 * @var ServiceCountryResultRow[] $availableCountryServices
 */

?>

Add <b><?= htmlspecialchars($application->getTitle()); ?></b> services.

<form action="/application-services/add?applicationId=<?= $application->getId() ?>" method="post">
    <div class="row">
        <select name="services[]" multiple>
            <?php
                foreach ($availableCountryServices as $service) { ?>
                    <option value="<?= $service->getServiceCountryId(); ?>">
                        <?= htmlspecialchars($service->getService()); ?>
                    </option>
                <?php }
            ?>
        </select>
    </div>

    <br>

    <div class="row">
        <input type="submit" name="submit" value="Add">
    </div>
</form>



