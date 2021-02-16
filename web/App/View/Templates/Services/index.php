<?php

use App\Model\DTO\Services;

/**
 * @var Services[] $services
 */

?>

<hr>

<h3>Services</h3>

<a href="/services/create">
    Create Service
</a>

<table>
    <thead>
        <tr>
            <th>Name</th>
            <th>Description</th>
            <th>Is Available?</th>
            <th>Created At</th>
            <th>Updated At</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php
            if (!empty($services)) {
                foreach ($services as $service) { ?>
                    <tr>
                        <td><?= htmlspecialchars($service->getName()); ?></td>
                        <td><?= htmlspecialchars($service->getDescription()); ?></td>
                        <td><?= $service->isAvailable() ? 'Yes' : 'No'; ?></td>
                        <td><?= $service->getCreatedAt()->format('Y-m-d H:i:s'); ?></td>
                        <td><?= $service->getUpdatedAt() instanceof DateTimeInterface
                                ? $service->getUpdatedAt()->format('Y-m-d H:i:s')
                                : 'N/A'; ?>
                        </td>
                        <td>
                            <a href="/services/add-countries?serviceId=<?= $service->getId(); ?>">
                                Add Countries
                            </a>
                        </td>
                    </tr>
                <?php }
            } else { ?>
                <tr>
                    <td colspan="12">No results found.</td>
                </tr>
            <?php }
        ?>
    </tbody>
</table>
