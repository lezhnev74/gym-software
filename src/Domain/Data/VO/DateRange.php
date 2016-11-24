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
class DateRange
{

    private $begin_date;
    private $end_date;


    public function __construct(Date $begin_date, Date $end_date)
    {
        if ($begin_date->getDate()->gte($end_date->getDate())) {
            throw new InvalidData("Begin date must be lower than end date");
        }

        $this->begin_date = $begin_date;
        $this->end_date = $end_date;
    }

    /**
     * @return Date
     */
    public function getBeginDate(): Date
    {
        return $this->begin_date;
    }

    /**
     * @return Date
     */
    public function getEndDate(): Date
    {
        return $this->end_date;
    }

    /**
     * @param Date $date
     * @return bool
     */
    public function isInRange(Date $date)
    {
        return
            $date->getDate()->lte($this->getEndDate()->getDate())
            &&
            $date->getDate()->gte($this->getBeginDate()->getDate());
    }

    /**
     * @param DateRange $dateRange
     * @return bool
     */
    public function isIntersectsWith(DateRange $dateRange)
    {
        return
            $dateRange->getBeginDate()->getDate()->lte($this->getEndDate()->getDate())
            &&
            $dateRange->getEndDate()->getDate()->gte($this->getBeginDate()->getDate());
    }

}