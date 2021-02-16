<?php

use App\Model\DTO\Services;

/**
 * @var Services|null $service
 */

?>

<form action="/services/create" method="post">
    <div class="row">
        <label>
            Name:
            <input type="text" name="name" required>
        </label>
    </div>

    <div class="row">
        <label>
            Description:
            <textarea name="description" rows="4" cols="50"></textarea>
        </label>
    </div>

    <div class="row">
        Is Available?
        <label>
            <input type="checkbox" name="is_available">
        </label>
    </div>

    <div class="row">
        <input type="submit" name="submit" value="Submit">
    </div>
</form>
