<?php

namespace App\Entity;

use App\Repository\DemoRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DemoRepository::class)]
class Demo
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $demo = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDemo(): ?string
    {
        return $this->demo;
    }

    public function setDemo(string $demo): self
    {
        $this->demo = $demo;

        return $this;
    }
}
