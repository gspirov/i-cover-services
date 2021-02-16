<?php

use App\Model\DTO\Countries;
use App\Model\DTO\ServiceCountries;
use App\Model\DTO\Services;

/**
 * @var Services $service
 * @var Countries[] $countries
 * @var ServiceCountries[] $alreadyLinkedCountriesToServices
 */

?>

Add <b><?= htmlspecialchars($service->getName()); ?></b> into countries.

<hr>

<?php
    if (!empty($countries)) {
        if (empty($alreadyLinkedCountriesToServices)) {
            $linkedCountryIdsToService = [];
        } else {
            $linkedCountryIdsToService = array_map(function (ServiceCountries $serviceCountry) {
                return $serviceCountry->getCountryId();
            }, $alreadyLinkedCountriesToServices);
        } ?>

        <form action="/services/add-countries?serviceId=<?= $service->getId() ?>" method="post">
            <div class="row">
                <select name="countries[]" multiple>
                    <?php
                    foreach ($countries as $country) { ?>
                        <option value="<?= htmlspecialchars($country->getId()) ?>"
                                <?= in_array($country->getId(), $linkedCountryIdsToService) ? 'selected' : ''; ?>>
                            <?= htmlspecialchars($country->getName()); ?>
                        </option>
                    <?php }
                    ?>
                </select>
            </div>

            <div class="row">
                <input type="submit" name="submit" value="Save">
            </div>
        </form>
    <?php } else {
        echo 'No available countries.';
    }
?>