<?php
namespace App\Entity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 */
class User extends BaseUser
{
    // Определение полей, тип данных
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    public $id;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Videolist", mappedBy="user")
     */
    private $videolists;

    public function __construct() // Инициализация объектов перед их использованием
    {
        parent::__construct();
        $this->videolists = new ArrayCollection();
    }

    // Геттеры и сеттеры

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
            $videolist->setUser($this);
        }

        return $this;
    }

    public function removeVideolist(Videolist $videolist): self
    {
        if ($this->videolists->contains($videolist)) {
            $this->videolists->removeElement($videolist);
            // set the owning side to null (unless already changed)
            if ($videolist->getUser() === $this) {
                $videolist->setUser(null);
            }
        }

        return $this;
    }
}