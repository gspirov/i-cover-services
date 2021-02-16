<?php

namespace App\Controller;

use App\Exception\Entity\ServiceNotFoundException;
use App\Exception\Http\BadRequestException;
use App\Exception\Service\ServiceValidationException;
use App\Http\AbstractController;
use App\Http\Request;
use App\Http\Response;
use App\Model\DTO\ServiceCountries;
use App\Model\DTO\Services;
use App\Model\Repository\CountriesRepository;
use App\Model\Repository\ServiceCountriesRepository;
use App\Model\Repository\ServicesRepository;
use App\Service\ServicesCountryService;
use App\Service\ServicesService;
use Exception;
use JetBrains\PhpStorm\Pure;
use PDO;
use Throwable;

class ServicesController extends AbstractController
{
    /**
     * @var ServicesRepository $servicesRepository
     */
    private ServicesRepository $servicesRepository;

    /**
     * @var CountriesRepository $countriesRepository
     */
    private CountriesRepository $countriesRepository;

    /**
     * @var ServiceCountriesRepository $serviceCountriesRepository
     */
    private ServiceCountriesRepository $serviceCountriesRepository;

    /**
     * ServicesController constructor.
     * @param PDO $connection
     */
    #[Pure]
    public function __construct(PDO $connection)
    {
        parent::__construct($connection);
        $this->servicesRepository = new ServicesRepository($connection);
        $this->countriesRepository = new CountriesRepository($connection);
        $this->serviceCountriesRepository = new ServiceCountriesRepository($connection);
    }

    /**
     * @return Response
     * @throws Exception
     */
    public function index(): Response
    {
        $services = $this->servicesRepository->findAll();
        return $this->viewRenderer->render('Services/index', compact('services'));
    }

    /**
     * @param Request $request
     * @return Response
     * @throws Exception
     */
    public function create(Request $request)
    {
        if ($request->isMethod(Request::METHOD_GET)) {
            return $this->viewRenderer->render('Services/create');
        }

        $post = $request->getPost();

        if (!empty($post['submit'])) {
            try {
                $servicesService = new ServicesService(
                    $post['name'] ?? '',
                    $post['description'] ?? '',
                    (bool)$post['is_available'] ?? false
                );

                $service = $servicesService->create();
                $this->servicesRepository->create($service);
                $this->redirect('services', 'index');
            } catch (ServiceValidationException $serviceValidationException) {
                $errors = $serviceValidationException->getErrors();
            }
        }
    }

    /**
     * @param Request $request
     * @return Response
     * @throws BadRequestException
     * @throws ServiceNotFoundException
     */
    public function addCountries(Request $request)
    {
        if (empty($serviceId = $request->getQuery()['serviceId'])) {
            throw new BadRequestException('Service ID is mandatory.');
        }

        $service = $this->servicesRepository->find((int) $serviceId);

        if (!$service instanceof Services) {
            throw new ServiceNotFoundException;
        }

        $countries = $this->countriesRepository->findAll();
        $alreadyLinkedCountriesToServices = $this->serviceCountriesRepository->findAllByService($service);

        if ($request->isMethod(Request::METHOD_GET)) {
            return $this->viewRenderer->render(
                'Services/add-countries',
                compact('service', 'countries', 'alreadyLinkedCountriesToServices')
            );
        }

        $post = $request->getPost();

        if (!empty($post['submit'])) {
            $servicesCountryService = new ServicesCountryService(
                $post['countries'] ?? [],
                array_map(function (ServiceCountries $serviceCountry) {
                    return $serviceCountry->getCountryId();
                }, $alreadyLinkedCountriesToServices)
            );

            $this->connection->beginTransaction();

            try {
                $this->serviceCountriesRepository->deleteAllCountriesByService($service);

                if (!empty($servicesCountryService->forInsert())) {
                    $this->serviceCountriesRepository->linkServiceToCountries($service, $servicesCountryService->forInsert());
                }

                $this->connection->commit();

                $this->redirect('services', 'index');
                return;
            } catch (Throwable $exception) {
                $error = 'Failed to link countries to service.';
                $this->connection->rollBack();
            }
        }
    }
}