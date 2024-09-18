<?php

namespace App\Controller;

use App\Entity\CryptoCurrency;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Serializer\SerializerInterface;

class CryptoCurrencyController extends AbstractController
{
    

    #[Route('/api/crypto-currency/{symbol}', name: 'api_crypto_currency_show', methods: ['GET'])]
    public function show(string $symbol, EntityManagerInterface $em, SerializerInterface $si, \Twig\Environment $twig): Response
    {
        $crypto = $em->getRepository(CryptoCurrency::class)->findOneBy(['symbol' => $symbol]);

        if (!$crypto) {
            return new Response($twig->render('error.html.twig', ['message' => 'Currency not found']), 404);
        }

        $cryptoData = $si->normalize($crypto, 'json');

        return new Response($twig->render('crypto_currency/show.html.twig', [
            'crypto' => $cryptoData
        ]));
    }

    #[Route('/api/crypto-currency', name: 'api_crypto_currency_min_max', methods: ['GET'])]
    public function filter(Request $request, EntityManagerInterface $em, SerializerInterface $si, \Twig\Environment $twig): Response
    {
        $min = $request->query->get('min');
        $max = $request->query->get('max');

        $repo = $em->getRepository(CryptoCurrency::class);
        $queryBuilder = $repo->createQueryBuilder('c');

        if ($min || $max) {
            if ($min && $max) {
                $queryBuilder->where('c.currentPrice BETWEEN :min AND :max')
                    ->setParameter('min', $min)
                    ->setParameter('max', $max);
            } elseif ($min) {
                $queryBuilder->where('c.currentPrice >= :min')
                    ->setParameter('min', $min);
            } elseif ($max) {
                $queryBuilder->where('c.currentPrice <= :max')
                    ->setParameter('max', $max);
            }

            $cryptos = $queryBuilder->getQuery()->getResult();

            $formattedCryptos = array_map(function (CryptoCurrency $crypto) {
                return [
                    'name' => $crypto->getName(),
                    'symbol' => $crypto->getSymbol(),
                    'current_price' => $crypto->getCurrentPrice(),
                    'total_volume' => $crypto->getTotalVolume(),
                    'ath' => $crypto->getAth(),
                    'ath_date' => $crypto->getAthDate()->format('Y-m-d H:i:s'),
                    'atl' => $crypto->getAtl(),
                    'atl_date' => $crypto->getAtlDate()->format('Y-m-d H:i:s'),
                    'last_updated' => $crypto->getUpdatedAt()->format('Y-m-d H:i:s'),
                ];
            }, $cryptos);

            $cryptoData = $si->normalize($formattedCryptos, 'json');

            return $this->render('crypto_currency/filter.html.twig', [
                'cryptos' => $cryptoData,
                'min' => $min ?? '',
                'max' => $max ?? '',
                'message' => null,
            ]);
        }

        return $this->render('crypto_currency/filter.html.twig', [
            'cryptos' => [],
            'min' => $min ?? '',
            'max' => $max ?? '',
            'message' => 'You need to enter parameters to filter the cryptocurrencies.',
        ]);
    }

    #[Route('/api/crypto-currencies', name: 'api_crypto_currencies_list', methods: ['GET'])]
    public function listAll(EntityManagerInterface $em, SerializerInterface $si, \Twig\Environment $twig): Response
    {
        $cryptos = $em->getRepository(CryptoCurrency::class)->findAll();

        $formattedCryptos = array_map(function (CryptoCurrency $crypto) {
            return [
                'name' => $crypto->getName(),
                'symbol' => $crypto->getSymbol(),
                'current_price' => $crypto->getCurrentPrice(),
                'total_volume' => $crypto->getTotalVolume(),
                'ath' => $crypto->getAth(),
                'ath_date' => $crypto->getAthDate()->format('Y-m-d H:i:s'),
                'atl' => $crypto->getAtl(),
                'atl_date' => $crypto->getAtlDate()->format('Y-m-d H:i:s'),
                'last_updated' => $crypto->getUpdatedAt()->format('Y-m-d H:i:s'),
            ];
        }, $cryptos);

        $cryptoData = $si->normalize($formattedCryptos, 'json');

        return new Response($twig->render('crypto_currency/list.html.twig', [
            'cryptos' => $cryptoData
        ]));
    }


}