<?php

namespace App\Controller;

use App\Exception\Countries\CountryValidationException;
use App\Http\AbstractController;
use App\Http\Request;
use App\Http\Response;
use App\Model\Repository\CountriesRepository;
use App\Service\CountriesService;
use JetBrains\PhpStorm\Pure;
use PDO;

class CountriesController extends AbstractController
{
    /**
     * @var CountriesRepository $countriesRepository
     */
    private CountriesRepository $countriesRepository;

    /**
     * CountriesController constructor.
     * @param PDO $connection
     */
    #[Pure]
    public function __construct(PDO $connection)
    {
        parent::__construct($connection);
        $this->countriesRepository = new CountriesRepository($connection);
    }

    public function index(): Response
    {
        $countries = $this->countriesRepository->findAll();
        return $this->viewRenderer->render('Countries/index', compact('countries'));
    }

    public function create(Request $request)
    {
        if ($request->isMethod(Request::METHOD_GET)) {
            return $this->viewRenderer->render('Countries/create');
        }

        $post = $request->getPost();

        if (!empty($post['submit'])) {
            try {
                $countriesService = new CountriesService(
                    $post['name'] ?? '',
                    $post['iso2'] ?? ''
                );

                $country = $countriesService->create();
                $this->countriesRepository->create($country);
                $this->redirect('countries', 'index');
                return;
            } catch (CountryValidationException $countryValidationException) {
                $errors = $countryValidationException->getErrors();
            }
        }
    }

    public function update()
    {
        return $this->viewRenderer->render('Countries/update');
    }
}