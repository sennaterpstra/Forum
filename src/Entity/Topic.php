<?php

namespace App\Entity;

use App\Repository\TopicRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TopicRepository::class)
 */
class Topic
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="blob", nullable=true)
     */
    private $picture;

    /**
     * @ORM\Column(type="integer")
     */
    private $created_at;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $amountofposts;

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

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getPicture()
    {
        return $this->picture;
    }

    public function setPicture($picture): self
    {
        $this->picture = $picture;

        return $this;
    }

    public function getCreatedAt(): ?int
    {
        return $this->created_at;
    }

    public function setCreatedAt(int $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getAmountofposts(): ?int
    {
        return $this->amountofposts;
    }

    public function setAmountofposts(?int $amountofposts): self
    {
        $this->amountofposts = $amountofposts;

        return $this;
    }

    /**
     * Generates the magic method
     *
     */
    public function __toString(){
        // to show the name of the Category in the select
        return $this->title;
        // to show the id of the Category in the select
        // return $this->id;
    }
}
