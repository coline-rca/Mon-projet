<?php

namespace App\Entity;

use App\Entity\Category;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
#[Vich\Uploadable]
class Product
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 45)]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\Column]
    private ?float $price = null;

    #[ORM\Column(nullable: true)]
    private ?int $stock = null;

    #[Vich\UploadableField(mapping: 'products', fileNameProperty: 'imageName1')]
    private ?File $imageFile1 = null;

    #[ORM\Column(nullable: true)]
    private ?string $imageName1 = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updatedAt1 = null;

    #[Vich\UploadableField(mapping: 'products', fileNameProperty: 'imageName2')]
    private ?File $imageFile2 = null;

    #[ORM\Column(nullable: true)]
    private ?string $imageName2 = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updatedAt2 = null;

    #[Vich\UploadableField(mapping: 'products', fileNameProperty: 'imageName3')]
    private ?File $imageFile3 = null;

    #[ORM\Column(nullable: true)]
    private ?string $imageName3 = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updatedAt3 = null;

    #[ORM\Column(nullable: true)]
    private ?float $note = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $comment = null;

    #[ORM\ManyToOne(inversedBy: 'products')]
    private ?Size $size = null;

    #[ORM\ManyToOne(inversedBy: 'products')]
    private ?Category $category = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\ManyToMany(targetEntity: Order::class, mappedBy: 'product')]
    private Collection $orders;

    public function __construct()
    {
        $this->orders = new ArrayCollection();
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getStock(): ?int
    {
        return $this->stock;
    }

    public function setStock(?int $stock): self
    {
        $this->stock = $stock;

        return $this;
    }

    public function setImageFile1(?File $imageFile1 = null): void
    {
        $this->imageFile1 = $imageFile1;

        if (null !== $imageFile1) {
            $this->updatedAt1 = new \DateTimeImmutable();
        }
    }

    public function getImageFile1(): ?File
    {
        return $this->imageFile1;
    }

    public function setImageName1(?string $imageName1): void
    {
        $this->imageName1 = $imageName1;
    }

    public function getImageName1(): ?string
    {
        return $this->imageName1;
    }

    public function setImageFile2(?File $imageFile2 = null): void
    {
        $this->imageFile2 = $imageFile2;

        if (null !== $imageFile2) {
            $this->updatedAt2 = new \DateTimeImmutable();
        }
    }

    public function getImageFile2(): ?File
    {
        return $this->imageFile2;
    }

    public function setImageName2(?string $imageName2): void
    {
        $this->imageName2 = $imageName2;
    }

    public function getImageName2(): ?string
    {
        return $this->imageName2;
    }

    public function setImageFile3(?File $imageFile3 = null): void
    {
        $this->imageFile3 = $imageFile3;

        if (null !== $imageFile3) {
            $this->updatedAt3 = new \DateTimeImmutable();
        }
    }

    public function getImageFile3(): ?File
    {
        return $this->imageFile3;
    }

    public function setImageName3(?string $imageName3): void
    {
        $this->imageName3 = $imageName3;
    }

    public function getImageName3(): ?string
    {
        return $this->imageName3;
    }

    public function getNote(): ?float
    {
        return $this->note;
    }

    public function setNote(?float $note): self
    {
        $this->note = $note;

        return $this;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(?string $comment): self
    {
        $this->comment = $comment;

        return $this;
    }

    public function getSize(): ?Size
    {
        return $this->size;
    }

    public function setSize(?Size $size): self
    {
        $this->size = $size;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): static
    {
        $this->category = $category;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeImmutable $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * @return Collection<int, Order>
     */
    public function getOrders(): Collection
    {
        return $this->orders;
    }

    public function addOrder(Order $order): static
    {
        if (!$this->orders->contains($order)) {
            $this->orders->add($order);
            $order->addProduct($this);
        }

        return $this;
    }

    public function removeOrder(Order $order): static
    {
        if ($this->orders->removeElement($order)) {
            $order->removeProduct($this);
        }

        return $this;
    }
}
