<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 22/11/16
 * Time: 23:08
 */

namespace Lezhnev74\GymSoftware\Domain\Data\VO;


class Report
{
    private $date_range;
    private $rooms = [];

    public function __construct(DateRange $date_range, array $rooms)
    {
        $this->date_range = $date_range;
        $this->rooms = $rooms;
    }

    public function getTotalSessions()
    {
        //
        // iterate over all rooms and get it's training sessions for the same date range
        //
        $sessions = [];
        foreach ($this->getRooms() as $room) {
            foreach ($room->getTrainingSessions() as $session) {
                if ($session->getDateRange()->isInRange($this->getDateRange())) {
                    $sessions[] = $session;
                }
            }
        }

        return $sessions;
    }

    public function getRooms()
    {
        return $this->rooms;
    }

    public function getDateRange()
    {
        return $this->date_range;
    }
}