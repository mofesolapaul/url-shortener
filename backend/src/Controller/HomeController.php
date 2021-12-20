<?php declare(strict_types=1);

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController
{
    #[Route('/')]
    public function index(): Response
    {
        return new Response('<h3>"Url Shortener" backend is up and running. Go to React app at http://localhost:8088</h3>');
    }
}
