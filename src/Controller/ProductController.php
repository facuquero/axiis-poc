<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Service\ProductService;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\ProductRepository;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Response;

class ProductController extends AbstractController

{
    /**
     * @Route("/products", name="index_products", methods={"GET", "OPTIONS"})
     */

    public function index(ProductRepository $productRepository): Response
    {
        $products = $productRepository->findAll();

        return $this->render('products.html.twig', [
            'products' => $products,
        ]);
    }

    /**
     * @Route("/api/products/list", name="get_all_products", methods={"GET", "OPTIONS"})
     */
    public function getAllProducts(ProductRepository $productRepository): JsonResponse
    {
        $products = $productRepository->findAll();

        return $this->json([
            'message' => 'All products retrieved successfully!',
            'products' => $products,
        ]);
    }

    /**
     * @Route("/api/products", name="create_products", methods={"POST", "OPTIONS"})
     */
    public function createProducts(Request $request, EntityManagerInterface $entityManager, ProductService $productService, LoggerInterface $logger): JsonResponse
    {
        $requestArray = json_decode($request->getContent(), true);
        $errorCount = 0;
        $productsCreated = 0;

        foreach ($requestArray as $data) {
            $product = $productService->validateProductData($data);
            if ($product !== null) {
                try {
                    $entityManager->persist($product);
                    $entityManager->flush();
                    $productsCreated++;
                } catch (\Throwable $th) {
                    $errorCount++;
                    $logger->error('Validation Error: SKU Already Exists: ' . $product->getSku());
                }
            }
        }

        return $this->json([
            'message' => 'Products created successfully!',
            'products_created' => $productsCreated,
            'products_with_error' => $errorCount,
        ]);
    }

    /**
     * @Route("/api/products/upsert", name="upsert_products", methods={"POST", "OPTIONS"})
     */
    public function updateProducts (
        Request $request, 
        ProductService $productService, 
        ProductRepository $productRepository
        ): JsonResponse 
    {
        $requestArray = json_decode($request->getContent(), true);
        $errorCount = 0;
        $productsCreated = 0;

        foreach ($requestArray as $data) {
            $product = $productService->validateProductData($data);
            if ($product !== null) {
                    $k = $productRepository->upsertProductBySku($product);
                    $productsCreated++;
 
            }
        }

        return $this->json([
            'message' => 'Products updated successfully!',
            'products_created' => $productsCreated,
            'products_with_error' => $errorCount,
        ]);
    }

}
