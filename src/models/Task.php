<?php

class Task {
    private $id;
    private $projectId;
    private $title;
    private $color;
    private $status;

    public function __construct($id, $projectId, $title, $color, $status)
    {
        $this->id = $id;
        $this->projectId = $projectId;
        $this->title = $title;
        $this->color = $color;
        $this->status = $status;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getProjectId()
    {
        return $this->projectId;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function getColor()
    {
        return $this->color;
    }

    public function getStatus()
    {
        return $this->status;
    }
}