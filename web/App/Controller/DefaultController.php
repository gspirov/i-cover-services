<?php

namespace App\Controller;

use App\Http\AbstractController;
use App\Http\Request;
use App\Http\Response;
use Exception;

class DefaultController extends AbstractController
{
    /**
     * @param Request $request
     * @return Response
     * @throws Exception
     */
    public function index(Request $request): Response
    {
        return $this->viewRenderer->render('Default/index');
    }
}