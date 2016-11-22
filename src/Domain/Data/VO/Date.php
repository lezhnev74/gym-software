<?php

namespace Lezhnev74\GymSoftware\Domain\Data\VO;

use Carbon\Carbon;
use Lezhnev74\GymSoftware\Domain\Data\Exception\InvalidData;

/**
 * Class Date
 *
 * Base it on Carbon instance (which is based on immutable DateTime instance)
 *
 */
class Date
{

    private $date;

    function __construct(Carbon $date)
    {
        $this->date = $date;
    }

    /**
     * @return Carbon
     */
    public function getDate()
    {
        return $this->date;
    }

}