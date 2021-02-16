<?php

use App\Model\DTO\Applications;

/**
 * @var Applications|null $application
 */

$isEdit = $application instanceof Applications;

$genderOptions = ['male' => 'Male', 'female' => 'Female']; ?>

<form action="/applications/<?= $isEdit ? 'edit?id=' . $application->getId() : 'create'; ?>" method="post">
    <div class="row">
        <label>
            First Name:
            <input type="text"
                   name="first_name"
                   required value
                   ="<?= $isEdit ? htmlspecialchars($application->getFirstName()) : ''; ?>"
            >
        </label>
    </div>

    <div class="row">
        <label>
            Last Name:
            <input type="text"
                   name="last_name"
                   required
                   value="<?= $isEdit ? htmlspecialchars($application->getLastName()) : ''; ?>"
            >
        </label>
    </div>

    <div class="row">
        <label>
            Date Of Birth:
            <input type="date"
                   name="dob"
                   required
                   value="<?= $isEdit ? htmlspecialchars($application->getDateOfBirth()->format('Y-d-m')) : ''; ?>"
            >
        </label>
    </div>

    <div class="row">
        <label>
            Gender:
            <select name="gender">
                <?php
                    foreach ($genderOptions as $value => $gender) { ?>
                        <option value="<?= $value ?>" <?= $isEdit && $application->getGender() === $value ? 'selected' : ''; ?>>
                            <?= $gender; ?>
                        </option>
                    <?php }
                ?>
            </select>
        </label>
    </div>

    <div class="row">
        <label>
            Title:
            <input type="text"
                   name="title"
                   required
                   value="<?= $isEdit ? htmlspecialchars($application->getTitle()) : ''; ?>"
            >
        </label>
    </div>

    <div class="row">
        <input type="submit" name="submit" value="Save">
    </div>
</form>
