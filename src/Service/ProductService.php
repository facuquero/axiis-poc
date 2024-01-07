<?php

namespace App\Service;


use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Doctrine\ORM\EntityManagerInterface;
use App\DTO\ProductDTO;
use App\Entity\Product;
use Psr\Log\LoggerInterface;

class ProductService
{
    private ValidatorInterface $validator;
    private LoggerInterface $logger;

    public function __construct(ValidatorInterface $validator, LoggerInterface $logger)
    {
        $this->validator = $validator;
        $this->logger = $logger;
    }

    public function validateProductData(array $data): ?Product
    {
        $requiredFields = ['SKU', 'name', 'description'];

        foreach ($requiredFields as $field) {
            if (!isset($data[$field])) {
                throw new BadRequestHttpException("El campo '$field' es requerido.");
            }
        }

        $productDTO = new ProductDTO(
            $data['SKU'],
            $data['name'],
            $data['description']
        );

        $errors = $this->validator->validate($productDTO);

        if (count($errors) > 0) {
            foreach ($errors as $error) {
                $this->logger->error('Validation Error: ' . $error->getMessage());
                throw new BadRequestHttpException('ValidationError: ' . $error->getMessage());
            }
        }

        return $productDTO->toEntity();
    }

}
