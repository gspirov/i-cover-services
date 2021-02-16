<?php

namespace App\Service;

use App\Exception\Application\ApplicationUnknownStatusException;
use App\Exception\Application\ApplicationValidationException;
use App\Model\DTO\Applications;
use DateTime;
use DateTimeInterface;
use Exception;

class ApplicationService
{
    const POSSIBLE_GENDER_OPTIONS = ['male', 'female'];

    /**
     * @var DateTimeInterface $validatedDateOfBirth
     */
    private DateTimeInterface $validatedDateOfBirth;

    /**
     * CreateApplicationService constructor.
     * @param string $firstName
     * @param string $lastName
     * @param string $dateOfBirth
     * @param string $gender
     * @param string $title
     * @throws ApplicationValidationException
     */
    public function __construct(
        private string $firstName,
        private string $lastName,
        private string $dateOfBirth,
        private string $gender,
        private string $title
    ) {
        if (!empty($validationErrors = $this->validate())) {
            throw new ApplicationValidationException($validationErrors);
        }
    }

    /**
     * Return collection of error messages if any specific validation rule is affected.
     * @return array
     */
    public function validate(): array
    {
        $errors = [];

        if (strlen($this->firstName) < 6) {
            $errors['first_name'] = 'First name should contains at least 6 characters.';
        }

        if (strlen($this->lastName) < 6) {
            $errors['last_name'] = 'Last name should contains at least 6 characters.';
        }

        $this->validatedDateOfBirth = DateTime::createFromFormat('Y-d-m', $this->dateOfBirth);

        if (!$this->validatedDateOfBirth instanceof DateTime) {
            $errors['dateOfBirth'] = sprintf('Invalid date of birth: %s', $this->dateOfBirth);
        }

        if (array_search($this->gender, self::POSSIBLE_GENDER_OPTIONS) === false) {
            $errors['gender'] = sprintf(
                'Invalid gender, possible options are: %s',
                implode(', ', self::POSSIBLE_GENDER_OPTIONS)
            );
        }

        if (strlen($this->title) < 5) {
            $errors['title'] = 'We need something more specific with at least 5 characters for title.';
        }

        return $errors;
    }

    /**
     * @return Applications
     * @throws Exception
     */
    public function create(): Applications
    {
        $application = new Applications;

        $application->setFirstName($this->firstName)
                    ->setLastName($this->lastName)
                    ->setDateOfBirth($this->validatedDateOfBirth)
                    ->setGender($this->gender)
                    ->setTitle($this->title);

        return $application;
    }

    /**
     * @param Applications $application
     * @param string $status
     * @return bool
     * @throws ApplicationUnknownStatusException
     */
    public static function changeStatus(Applications $application, string $status): bool
    {
        $applicationPossibleStatuses = [
            Applications::STATUS_OPEN,
            Applications::STATUS_CLOSED,
            Applications::STATUS_CANCELLED
        ];

        if (array_search($status, $applicationPossibleStatuses) === false) {
            throw new ApplicationUnknownStatusException($status);
        }

        $application->setStatus($status);
        return true;
    }

    /**
     * @param Applications $application
     * @return array
     */
    public function entityChangeSet(Applications $application): array
    {
        return array_diff(
            [
                'first_name' => $this->firstName,
                'last_name' => $this->lastName,
                'dob' => $this->validatedDateOfBirth->format('Y-m-d'),
                'gender' => $this->gender,
                'title' => $this->title
            ],
            [
                'first_name' => $application->getFirstName(),
                'last_name' => $application->getLastName(),
                'dob' => $application->getDateOfBirth()->format('Y-m-d'),
                'gender' => $application->getGender(),
                'title' => $application->getTitle()
            ],
        );
    }
}