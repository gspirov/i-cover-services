<?php

use App\Model\DTO\Countries;

/**
 * @var Countries[] $countries
 */

?>

<hr>

<h3>Countries</h3>

<hr>

<a href="/countries/create">Create Country</a>

<table>
    <thead>
        <tr>
            <th>Name</th>
            <th>ISO2</th>
        </tr>
    </thead>
    <tbody>
        <?php
            if (!empty($countries)) {
                foreach ($countries as $country) { ?>
                    <td><?= htmlspecialchars($country->getName()); ?></td>
                    <td><?= htmlspecialchars($country->getIso2()); ?></td>
                <?php }
            } else { ?>
                <tr>
                    <td colspan="12">No results found.</td>
                </tr>
            <?php }
        ?>
    </tbody>
</table>
