<?php

namespace App\Controller;

use App\Exception\Application\ApplicationUnknownStatusException;
use App\Exception\Application\ApplicationValidationException;
use App\Exception\Entity\ApplicationNotFoundException;
use App\Exception\Http\BadRequestException;
use App\Http\AbstractController;
use App\Http\Request;
use App\Http\Response;
use App\Model\DTO\Applications;
use App\Model\Repository\ApplicationsRepository;
use App\Service\ApplicationService;
use Exception;
use JetBrains\PhpStorm\Pure;
use PDO;
use PDOException;

class ApplicationsController extends AbstractController
{
    /**
     * @var ApplicationsRepository $applicationsRepository
     */
    private ApplicationsRepository $applicationsRepository;

    /**
     * ApplicationsController constructor.
     * @param PDO $connection
     */
    #[Pure]
    public function __construct(PDO $connection)
    {
        parent::__construct($connection);
        $this->applicationsRepository = new ApplicationsRepository($connection);
    }

    /**
     * @return Response
     * @throws Exception
     */
    public function index(): Response
    {
        return $this->viewRenderer->render('Applications/index', [
            'applications' => $this->applicationsRepository->findAll()
        ]);
    }

    /**
     * @param Request $request
     * @return Response
     * @throws Exception
     */
    public function create(Request $request)
    {
        if ($request->isMethod(Request::METHOD_GET)) {
            return $this->viewRenderer->render('Applications/create');
        }

        if (!empty($request->getPost()['submit'])) {
            try {
                $applicationsService = new ApplicationService(
                    $request->getPost()['first_name'] ?? '',
                    $request->getPost()['last_name'] ?? '',
                    $request->getPost()['dob'] ?? '',
                    $request->getPost()['gender'] ?? '',
                    $request->getPost()['title'] ?? ''
                );

                $application = $applicationsService->create();

                $this->applicationsRepository->create($application);
                $this->redirect('applications', 'index');
            } catch (ApplicationValidationException $creationException) {
                $errors = $creationException->getErrors();
            } catch (PDOException $databaseException) {
                $errors = ['Failed saving application.'];
            }

            $this->redirect('applications', 'index');
        }
    }

    /**
     * @param Request $request
     * @return Response
     * @throws ApplicationNotFoundException
     * @throws Exception
     */
    public function edit(Request $request)
    {
        if (empty($applicationId = $request->getQuery()['id'])) {
            throw new BadRequestException('Application ID is mandatory.');
        }

        $application = $this->applicationsRepository->find($request->getQuery()['id']);

        if (!$application instanceof Applications) {
            throw new ApplicationNotFoundException;
        }

        if ($request->isMethod(Request::METHOD_GET)) {
            return $this->viewRenderer->render('Applications/edit', compact('application'));
        }

        if (!empty($request->getPost()['submit'])) {
            try {
                $applicationsService = new ApplicationService(
                    $request->getPost()['first_name'] ?? '',
                    $request->getPost()['last_name'] ?? '',
                    $request->getPost()['dob'] ?? '',
                    $request->getPost()['gender'] ?? '',
                    $request->getPost()['title'] ?? ''
                );

                $applicationChangeSet = $applicationsService->entityChangeSet($application);
                $this->applicationsRepository->update($application, $applicationChangeSet);
                $this->redirect('applications', 'index');
            } catch (ApplicationValidationException $validationException) {
                $errors = $validationException->getErrors();
                $this->redirect('applications', 'edit', ['id' => $application->getId()]);
            }
        }
    }

    /**
     * @param Request $request
     * @return Response
     * @throws ApplicationNotFoundException
     * @throws BadRequestException
     */
    public function updateStatus(Request $request)
    {
        if (empty($applicationId = $request->getQuery()['id'])) {
            throw new BadRequestException('Application ID is mandatory.');
        }

        $application = $this->applicationsRepository->find((int) $applicationId);

        if (!$application instanceof Applications) {
            throw new ApplicationNotFoundException;
        }

        if ($request->isMethod(Request::METHOD_GET)) {
            return $this->viewRenderer->render('Applications/status-form', compact('application'));
        }

        $post = $request->getPost();

        if (!empty($post['submit'])) {
            if (empty($status = $post['status'])) {
                $this->redirect('applications', 'update-status', ['id' => $application->getId()]);
                return;
            }

            try {
                ApplicationService::changeStatus($application, $status);
                $this->applicationsRepository->update($application, compact('status'));
                $this->redirect('applications', 'index');
                return;
            } catch (ApplicationUnknownStatusException $unknownStatusException) {
                $error = $unknownStatusException->getMessage();
            } catch (Exception $databaseException) {
                $error = 'Failed to update application\'s status.';
            }

            $this->redirect('applications', 'update-status', ['id' => $application->getId()]);
            return;
        }
    }
}