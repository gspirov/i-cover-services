<?php

namespace App\Controller;

use App\Exception\Entity\ApplicationNotFoundException;
use App\Exception\Http\BadRequestException;
use App\Http\AbstractController;
use App\Http\Request;
use App\Http\Response;
use App\Model\DTO\Applications;
use App\Model\Repository\ApplicationServicesRepository;
use App\Model\Repository\ApplicationsRepository;
use JetBrains\PhpStorm\Pure;
use PDO;

class ApplicationServicesController extends AbstractController
{
    /**
     * @var ApplicationsRepository $applicationsRepository
     */
    private ApplicationsRepository $applicationsRepository;

    /**
     * @var ApplicationServicesRepository $applicationServicesRepository
     */
    private ApplicationServicesRepository $applicationServicesRepository;

    /**
     * ApplicationServicesController constructor.
     * @param PDO $connection
     */
    #[Pure]
    public function __construct(PDO $connection)
    {
        parent::__construct($connection);
        $this->applicationsRepository = new ApplicationsRepository($connection);
        $this->applicationServicesRepository = new ApplicationServicesRepository($connection);
    }

    /**
     * @param Request $request
     * @return Response
     * @throws ApplicationNotFoundException
     * @throws BadRequestException
     */
    public function index(Request $request)
    {
        if (empty($applicationId = $request->getQuery()['applicationId'])) {
            throw new BadRequestException('Application ID is mandatory.');
        }

        $application = $this->applicationsRepository->find($applicationId);

        if (!$application instanceof Applications) {
            throw new ApplicationNotFoundException;
        }

        return $this->viewRenderer->render('Application-Services/index', [
            'application' => $application,
            'applicationServices' => $this->applicationServicesRepository->findAllByApplication($application)
        ]);
    }

    /**
     * @param Request $request
     * @return Response
     * @throws ApplicationNotFoundException
     * @throws BadRequestException
     */
    public function add(Request $request)
    {
        if (empty($applicationId = $request->getQuery()['applicationId'])) {
            throw new BadRequestException('Application ID is mandatory.');
        }

        $application = $this->applicationsRepository->find($applicationId);

        if (!$application instanceof Applications) {
            throw new ApplicationNotFoundException;
        }

        $availableCountryServices = $this->applicationServicesRepository->fetchAvailableApplicationCountryServices(
            $application
        );

        if ($request->isMethod(Request::METHOD_GET)) {
            return $this->viewRenderer->render(
                'Application-Services/add',
                compact('application', 'availableCountryServices')
            );
        }

        $post = $request->getPost();

        if (!empty($post['submit'])) {
        }
    }
}