<?php

use App\Model\DTO\Applications;
use App\Model\DTO\ApplicationServicesResultRow;

/**
 * @var Applications $application
 * @var ApplicationServicesResultRow[] $applicationServices
 */

?>

Application <b><?= htmlspecialchars($application->getTitle()); ?></b> Services.

<table>
    <thead>
        <tr>
            <th>Applicant</th>
            <th>Service</th>
            <th>Country</th>
            <th>Requested User</th>
        </tr>
    </thead>
    <tbody>
        <?php
            if (!empty($applicationServices)) {
                foreach ($applicationServices as $applicationService) { ?>
                    <td><?= htmlspecialchars($applicationService->getApplicant()); ?></td>
                    <td><?= htmlspecialchars($applicationService->getService()); ?></td>
                    <td><?= htmlspecialchars($applicationService->getCountry()); ?></td>
                    <td><?= htmlspecialchars($applicationService->getRequestedUser()); ?></td>
                <?php }
            } else { ?>
                <tr>
                    <td colspan="12">No results found.</td>
                </tr>
            <?php }
        ?>
    </tbody>
</table>
