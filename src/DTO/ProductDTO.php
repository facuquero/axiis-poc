<?php

namespace App\DTO;

use App\Entity\Product;
use Symfony\Component\Validator\Constraints as Assert;

class ProductDTO
{
    /**
     * @Assert\NotBlank(message="El SKU no puede estar en blanco.")
     * @Assert\Length(max=50, maxMessage="El SKU no puede tener más de {{ limit }} caracteres.")
     */
    public ?string $sku = null;

    /**
     * @Assert\NotBlank(message="El nombre no puede estar en blanco.")
     * @Assert\Length(max=250, maxMessage="El nombre no puede tener más de {{ limit }} caracteres.")
     */
    public ?string $name = null;

    /**
     * @Assert\Length(max=500, maxMessage="La descripción no puede tener más de {{ limit }} caracteres.")
     */
    public ?string $description = null;

    // Puedes añadir más propiedades según sea necesario para tu DTO

    public function __construct(?string $sku = null, ?string $name = null, ?string $description = null)
    {
        $this->sku = $sku;
        $this->name = $name;
        $this->description = $description;
    }

    public function toEntity(): Product
    {
        $product = new Product();

        $product->setSKU($this->sku);
        $product->setName($this->name);
        $product->setDescription($this->description);

        return $product;
    }
}