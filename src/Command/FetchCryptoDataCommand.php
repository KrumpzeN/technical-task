<?php

namespace App\Command;

use App\Entity\CryptoCurrency;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Contracts\HttpClient\HttpClientInterface;

#[AsCommand(
    name: 'fetch:crypto-data',
    description: 'Fetches the data from crypto API',
)]
class FetchCryptoDataCommand extends Command
{

    private $entityManager;
    private $httpClient;

    public function __construct(EntityManagerInterface $entityManager, HttpClientInterface $httpClient)
    {
        $this->entityManager = $entityManager;
        $this->httpClient = $httpClient;
        
        parent::__construct();
    }

    protected function configure(): void
    {}

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $url = 'https://api.coingecko.com/api/v3/coins/markets?vs_currency=usd&order=market_cap_desc&per_page=50&page=1&sparkline=false';

        $response = $this->httpClient->request('GET', $url);
        $cryptos = $response->toArray();

        foreach($cryptos as $cryptoData){
            $crypto = new CryptoCurrency();
            $crypto->setName($cryptoData['name']);
            $crypto->setSymbol($cryptoData['symbol']);
            $crypto->setCurrentPrice($cryptoData['current_price']);
            $crypto->setTotalVolume($cryptoData['total_volume']);
            $crypto->setAth($cryptoData['ath']);
            $crypto->setAthDate(new \DateTime($cryptoData['ath_date']));
            $crypto->setAtl($cryptoData['atl']);
            $crypto->setAtlDate(new \DateTime($cryptoData['atl_date']));
            $crypto->setUpdatedAt(new \DateTime($cryptoData['last_updated']));

            $this->entityManager->persist($crypto);
        }

        $this->entityManager->flush();

        $output->writeln('Data fetched successfully');


        return Command::SUCCESS;
    }
}
