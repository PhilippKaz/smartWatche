<?php

namespace App\Entity;



use App\Controller\CategoryController;
use Doctrine\ORM\Mapping as ORM;

use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;


/**
 * @ORM\Entity(repositoryClass="App\Repository\VideoRepository")
 */
class Video
{
    // Определение полей, тип данных
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    public $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    public $title;

    /**
     * @ORM\Column(type="text")
     */
    public $description;

    /**
     * @ORM\Column(type="string", length=255)
     */
    public $cover;

    /**
     * @ORM\Column(type="string", length=25)
     */
    public $created;

    /**
     * @ORM\Column(type="string", length=255)
     */
    public $idd;


    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Category", inversedBy="videos")
     * @ORM\JoinColumn(nullable=false)
     */
    public $category;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Project", inversedBy="videos")
     * @ORM\JoinColumn(nullable=false)
     */
    public $project;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Videolist", mappedBy="video")
     */
    public $videolists;

    public function __construct() // Инициализация объектов перед их использованием
    {
        $this->videolists = new ArrayCollection();
    }

    public function __toString(){ // Переобразование в строку
        return $this->title;
    }

    // Геттеры и сеттеры

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getCover(): ?string
    {
        return $this->cover;
    }

    public function setCover(string $cover): self
    {
        $this->cover = $cover;

        return $this;
    }

    public function getCreated(): ?string
    {
        return $this->created;
    }

    public function setCreated(string $created): self
    {
        $this->created = $created;

        return $this;
    }

    public function getIdd(): ?string
    {
        return $this->idd;
    }

    public function setIdd(string $idd): self
    {
        $this->idd = $idd;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getProject(): ?Project
    {
        return $this->project;
    }

    public function setProject(?Project $project): self
    {
        $this->project = $project;

        return $this;
    }

    /**
     * @return Collection|Videolist[]
     */
    public function getVideolists(): Collection
    {
        return $this->videolists;
    }

    public function addVideolist(Videolist $videolist): self
    {
        if (!$this->videolists->contains($videolist)) {
            $this->videolists[] = $videolist;
            $videolist->setVideo($this);
        }

        return $this;
    }

    public function removeVideolist(Videolist $videolist): self
    {
        if ($this->videolists->contains($videolist)) {
            $this->videolists->removeElement($videolist);
            // set the owning side to null (unless already changed)
            if ($videolist->getVideo() === $this) {
                $videolist->setVideo(null);
            }
        }

        return $this;
    }
}
