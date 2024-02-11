<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\BookCategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BookCategoryRepository::class)]
#[ORM\Table(name: 'postgres:book_category')]
class BookCategory
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $title = null;

    #[ORM\Column(type: 'string', length: 255, unique: true)]
    private ?string $slug = null;

    #[ORM\ManyToMany(targetEntity: Book::class, inversedBy: 'categories')]
    #[ORM\JoinTable(name: 'book_book_category')]
    #[ORM\JoinColumn(name: 'book_id', referencedColumnName: 'id')]
    private Collection|null $books = null;

    public function __construct()
    {
        $this->books = new ArrayCollection();
    }

    public function getBooks(): ?string
    {
        return $this->books;
    }

    public function setBooks(?string $books): static
    {
        $this->books = $books;

        return $this;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(?int $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(?string $slug): static
    {
        $this->slug = $slug;

        return $this;
    }
}
