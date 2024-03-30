<?php

namespace App\Models;

class OrioksRepository
{
    private $subjects;
    private $marks;
    private $control_events;

    public function __construct($subjects, $marks, $control_events)
    {
        $this->subjects = $subjects;
        $this->marks = $marks;
        $this->control_events = $control_events;
    }

    public function getSubjects()
    {
        return $this->subjects;
    }

    public function getMarks()
    {
        return $this->marks;
    }

    public function getControlEvents()
    {
        return $this->control_events;
    }
}
