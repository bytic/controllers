<?php

declare(strict_types=1);

namespace Nip\Controllers\Tests\Fixtures\Controllers;

use Nip\Controllers\AbstractController;

/**
 * Example controller demonstrating Symfony-compatible patterns.
 */
class SymfonyStyleController extends AbstractController
{
    /**
     * Example: JSON API endpoint.
     */
    public function apiProducts()
    {
        $products = [
            ['id' => 1, 'name' => 'Product 1', 'price' => 99.99],
            ['id' => 2, 'name' => 'Product 2', 'price' => 149.99],
        ];

        return $this->json([
            'success' => true,
            'data' => $products,
        ]);
    }

    /**
     * Example: View rendering.
     */
    public function showProduct($id)
    {
        $product = $this->findProduct($id);

        if (!$product) {
            throw $this->createNotFoundException('Product not found');
        }

        return $this->render('products/show', [
            'product' => $product,
        ]);
    }

    /**
     * Example: Redirect with flash message.
     */
    public function createProduct()
    {
        // ... save product logic ...

        $this->addFlash('success', 'Product created successfully!');

        return $this->redirectToRoute('products');
    }

    /**
     * Example: Security check.
     */
    public function deleteProduct($id)
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'Only admins can delete products');

        // ... delete logic ...

        return $this->redirectResponse('/products');
    }

    /**
     * Example: File download.
     */
    public function downloadInvoice($id)
    {
        // In production, resolve the actual file path from your storage
        $invoicePath = $this->getInvoiceStoragePath() . "/invoice-{$id}.pdf";

        return $this->file($invoicePath, "invoice-{$id}.pdf");
    }

    /**
     * Dummy method for example - replace with actual storage path resolution.
     */
    private function getInvoiceStoragePath()
    {
        return '/var/www/storage/invoices';
    }

    /**
     * Dummy method for example.
     */
    private function findProduct($id)
    {
        return ['id' => $id, 'name' => 'Sample Product'];
    }
}
