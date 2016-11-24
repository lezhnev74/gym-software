<?php
namespace Lezhnev74\GymSoftware\Domain\Data\Room;

use Carbon\Carbon;
use Lezhnev74\GymSoftware\Domain\Data\Room\Exception\RoomIsOvercrowded;
use Lezhnev74\GymSoftware\Domain\Data\VO\Date;
use Lezhnev74\GymSoftware\Domain\Data\VO\TrainingSession;

class Room
{
    private $id;
    private $training_sessions = [];
    private $code; // code of the room, ie "room 6"
    private $capacity;

    public function __construct($id, $code, $capacity, array $training_sessions)
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
    public function getCurrentSessions()
    {
        $date = new Date(Carbon::now());
        $current_sessions = [];
        foreach ($this->getTrainingSessions() as $session) {
            if ($session->getDataRange()->isInRange($date)) {
                $current_sessions[] = $session;
            }
        }

        return $current_sessions;
    }

    public function conductTrainingSession(TrainingSession $session)
    {
        // protect room from being overcrowded
        if ($this->capacity == count($this->getTrainingSessions())) {
            throw new RoomIsOvercrowded();
        }

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


}