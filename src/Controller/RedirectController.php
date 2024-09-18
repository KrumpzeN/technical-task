<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Annotation\Route;

class RedirectController extends AbstractController
{
    #[Route('/', name: 'homepage', methods: ['GET'])]
    public function redirectToCryptoList(): RedirectResponse
    {
        return $this->redirectToRoute('api_crypto_currencies_list');
    }
}
