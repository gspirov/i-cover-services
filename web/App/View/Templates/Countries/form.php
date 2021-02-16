<?php

use App\Model\DTO\Countries;

/**
 * @var Countries|null $country
 */

?>

<form action="/countries/create" method="post">
    <div class="row">
        <label>
            Name:
            <input type="text" name="name" required>
        </label>
    </div>

    <div class="row">
        <label>
            ISO2:
            <input type="text" name="iso2" required>
        </label>
    </div>

    <div class="row">
        <input type="submit" name="submit" value="Save">
    </div>
</form>
