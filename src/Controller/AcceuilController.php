<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Description of AcceuilController
 *
 * @author jstan
 */
class AcceuilController {
    
    #[Route('/', name: 'acceuil')]
    public function index(): Response {
        return new Response('Hello world !');
    }
}
