<?php

namespace Tests\Unit;

use App\Models\Product;
use Tests\TestCase;

class ProductImageUrlTest extends TestCase
{
    public function test_image_url_points_uploaded_product_paths_to_public_storage(): void
    {
        $product = new Product(['image' => 'products/topi.jpg']);

        $this->assertSame(asset('storage/products/topi.jpg'), $product->image_url);
    }

    public function test_image_url_keeps_existing_public_storage_paths_valid(): void
    {
        $product = new Product(['image' => 'storage/products/topi.jpg']);

        $this->assertSame(asset('storage/products/topi.jpg'), $product->image_url);
    }

    public function test_image_url_keeps_external_urls_unchanged(): void
    {
        $product = new Product(['image' => 'https://example.com/products/topi.jpg']);

        $this->assertSame('https://example.com/products/topi.jpg', $product->image_url);
    }
}
