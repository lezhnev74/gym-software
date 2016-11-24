<?php
namespace Lezhnev74\GymSoftware\Domain\Data\Room;

use Carbon\Carbon;
use Lezhnev74\GymSoftware\Domain\Data\Room\Exception\RoomIsOvercrowded;
use Lezhnev74\GymSoftware\Domain\Data\VO\Date;
use Lezhnev74\GymSoftware\Domain\Data\VO\DateRange;
use Lezhnev74\GymSoftware\Domain\Data\VO\TrainingSession;

class Room
{
    private $id;
    private $training_sessions = [];
    private $code; // code of the room, ie "room 6"
    private $capacity;

    public function __construct($id, $code, $capacity, array $training_sessions = [])
    {
        $this->id = $id;
        $this->code = $code;
        $this->capacity = $capacity;

        foreach ($training_sessions as $session) {
            $this->conductTrainingSession($session);
        }
    }

    /**
     * Get session that is being conducted at this moment
     *
     * @return mixed
     */
    public function getTrainingSessionsForDate(Date $date)
    {
        $current_sessions = [];
        foreach ($this->getTrainingSessions() as $session) {
            if ($session->getDateRange()->isInRange($date)) {
                $current_sessions[] = $session;
            }
        }

        return $current_sessions;
    }

    public function conductTrainingSession(TrainingSession $session)
    {
        $this->validateCapacity($session);

        $this->training_sessions[] = $session;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return array
     */
    public function getTrainingSessions()
    {
        return $this->training_sessions;
    }

    /**
     * @return mixed
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @return mixed
     */
    public function getCapacity()
    {
        return $this->capacity;
    }

    private function validateCapacity(TrainingSession $session)
    {
        // protect room from being overcrowded
        $now = new Date(Carbon::now());
        if ($this->capacity == count($this->getTrainingSessionsForDate($now))) {
            throw new RoomIsOvercrowded();
        }
    }

    /**
     * Return float from 0 to 1 which indicates how much of work load room had on given date
     *
     * @param DateRange $date
     */
    public function calculatePerformanceForDate(DateRange $dateRange)
    {
        $full_load_hours = 8; // 8 hours means room was loaded at it fullest
        $full_load_capacity = $full_load_hours * $this->getCapacity();

        // detect how many hours was conducted on that date
        $total_hours_spent = 0;
        foreach ($this->getTrainingSessions() as $conducted_training) {
            if ($conducted_training->getDateRange()->isIntersectsWith($dateRange)) {
                $total_hours_spent += $conducted_training->getDateRange()->getHours();
            }
        }

        if (!$total_hours_spent) {
            return 0.0;
        }
        return round($total_hours_spent / $full_load_capacity, 2);
    }
}