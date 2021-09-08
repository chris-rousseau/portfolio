<?php

namespace App\Entity;

use App\Repository\TagsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TagsRepository::class)
 */
class Tags
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $name;

    /**
     * @ORM\ManyToMany(targetEntity=PortfolioProject::class, mappedBy="tags")
     */
    private $portfolioProjects;

    public function __construct()
    {
        $this->portfolioProjects = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection|PortfolioProject[]
     */
    public function getPortfolioProjects(): Collection
    {
        return $this->portfolioProjects;
    }

    public function addPortfolioProject(PortfolioProject $portfolioProject): self
    {
        if (!$this->portfolioProjects->contains($portfolioProject)) {
            $this->portfolioProjects[] = $portfolioProject;
            $portfolioProject->addTag($this);
        }

        return $this;
    }

    public function removePortfolioProject(PortfolioProject $portfolioProject): self
    {
        if ($this->portfolioProjects->removeElement($portfolioProject)) {
            $portfolioProject->removeTag($this);
        }

        return $this;
    }
}
