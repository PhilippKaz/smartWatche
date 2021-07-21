<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProjectRepository")
 */
class Project
{
    // Определение полей, тип данных
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    public $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    public $idd;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    public $title;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    public $updated_at;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    public $cover;



    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Category", inversedBy="projects")
     * @ORM\JoinColumn(nullable=false)
     */
    public $category;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Video", mappedBy="project")
     */
    public $video;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Video", mappedBy="project", orphanRemoval=true)
     */
    public $videos;

    public function __construct() // Инициализация объектов перед их использованием
    {
        $this->video = new ArrayCollection();
        $this->videos = new ArrayCollection();
    }

    public function __toString(){ // Переобразование в строку
        return $this->getUpdatedAt();
    }

    // Геттеры и сеттеры

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getIdd(): ?int
    {
        return $this->idd;
    }

    public function setIdd($idd)
    {
        $this->idd = $idd;
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

    public function getUpdatedAt(): string
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(string $updated_at): self
    {
        $this->updated_at = $updated_at;

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

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    /**
     * @return Collection|Video[]
     */
    public function getVideo(): Collection
    {
        return $this->video;
    }

    public function addVideo(Video $video): self
    {
        if (!$this->video->contains($video)) {
            $this->video[] = $video;
            $video->setProject($this);
        }

        return $this;
    }

    public function removeVideo(Video $video): self
    {
        if ($this->video->contains($video)) {
            $this->video->removeElement($video);
            // set the owning side to null (unless already changed)
            if ($video->getProject() === $this) {
                $video->setProject(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Video[]
     */
    public function getVideos(): Collection
    {
        return $this->videos;
    }

}