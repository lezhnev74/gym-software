<?php
namespace Lezhnev74\GymSoftware\Domain\Data\VO;

use Lezhnev74\GymSoftware\Domain\Data\Exception\InvalidData;

class TrainingSession
{
    private $client;
    private $date_range;

    public function __construct(Client $client, DateRange $date_range)
    {
        $this->client = $client;
        $this->date_range = $date_range;
    }

    function getClient()
    {
        return $this->client;
    }

    function getDateRange()
    {
        return $this->getDateRange();
    }

}