<?php

use App\Model\DTO\Applications;

/**
 * @var Applications[] $applications
 */

?>

<hr>

<h3>Applications</h3>

<a href="/applications/create">
    Create Application
</a>

<table>
    <thead>
        <tr>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Date Of Birth</th>
            <th>Gender</th>
            <th>Title</th>
            <th>Status</th>
            <th>Created At</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php
            if (!empty($applications)) {
                foreach ($applications as $application) { ?>
                    <tr>
                        <td><?= htmlspecialchars($application->getFirstName()); ?></td>
                        <td><?= htmlspecialchars($application->getLastName()); ?></td>
                        <td><?= htmlspecialchars($application->getDateOfBirth()->format('Y-m-d')); ?></td>
                        <td><?= htmlspecialchars(ucfirst($application->getGender())); ?></td>
                        <td><?= htmlspecialchars($application->getTitle()); ?></td>
                        <td><?= htmlspecialchars($application->getStatus()); ?></td>
                        <td><?= htmlspecialchars($application->getCreatedAt()->format('Y-m-d H:i:s')); ?></td>
                        <td>
                            |
                            <a href="/applications/edit?id=<?= $application->getId(); ?>">
                                Edit
                            </a>

                            |

                            <a href="/applications/update-status?id=<?= $application->getId(); ?>">
                                Update Status
                            </a>

                            |

                            <a href="/application-services/index?applicationId=<?= $application->getId() ?>">
                                View Services
                            </a>

                            |

                            <a href="/application-services/add?applicationId=<?= $application->getId(); ?>">
                                Add Country Services
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
