<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TaskRepository")
 */
class Task
{
    const PRIORITY_LOW = 0;
    const PRIORITY_MEDIUM = 1;
    const PRIORITY_HIGH = 2;

    const STATUS_PENDING = 0;
    const STATUS_IN_PROGRESS = 1;
    const STATUS_DONE = 2;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $title;

    /**
     * @ORM\Column(type="integer")
     * @Assert\Choice({task::PRIORITY_LOW, task::PRIORITY_MEDIUM, task::PRIORITY_HIGH})
     */
    private $priority;

    /**
     * @ORM\Column(type="integer")
     * @Assert\Choice({task::STATUS_PENDING, task::STATUS_IN_PROGRESS, task::STATUS_DONE})
     */
    private $status;

    /**
     * @ORM\Column(type="date")
     * @Assert\GreaterThan("today")
     */
    private $deadline;

    /**
     * @ORM\Column(type="datetime")
     *
     */
    private $createdAt;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Category")
     * @ORM\JoinColumn(nullable=true)
     */
    private $category;

    public function getId()
    {
        return $this->id;
    }

    /**
     * @Assert\NotBlank()
     * @Assert\Length(
     *     max = 10
     * )
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title): void
    {
        $this->title = $title;
    }

    /**
     * @return mixed
     */
    public function getPriority()
    {
        return $this->priority;
    }

    public function getPriorityString()
    {
        switch ($this->getPriority()){
            case self:: PRIORITY_HIGH:
                return 'High';
            case self:: PRIORITY_MEDIUM:
                return 'Medium';
            case self:: PRIORITY_LOW;
                return 'Low';
        }
    }

    /**
     * @param mixed $priority
     */
    public function setPriority($priority): void
    {
        $this->priority = $priority;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    public function getStatusString()
    {
        switch ($this->getStatus()){
            case self:: STATUS_DONE:
                return 'Done';
            case self:: STATUS_IN_PROGRESS:
                return 'In Progress';
            case self:: STATUS_PENDING;
                return 'Pending';
        }
    }

    /**
     * @param mixed $status
     */
    public function setStatus($status): void
    {
        $this->status = $status;
    }

    /**
     * @return mixed
     */
    public function getDeadline()
    {
        return $this->deadline;
    }

    /**
     * @param mixed $deadline
     */
    public function setDeadline($deadline): void
    {
        $this->deadline = $deadline;
    }

    /**
     * @return mixed
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param mixed $createdAt
     */
    public function setCreatedAt($createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return mixed
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @param mixed $category
     */
    public function setCategory($category): void
    {
        $this->category = $category;
    }
}
