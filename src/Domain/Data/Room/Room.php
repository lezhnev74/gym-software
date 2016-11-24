<?php
namespace Lezhnev74\GymSoftware\Domain\Data\Room;

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
        $this->training_sessions = $training_sessions;
        $this->code = $code;
        $this->capacity = $capacity;
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

    public function conductTrainingSession(TrainingSession $session)
    {
        $this->training_sessions[] = $session;
    }


}