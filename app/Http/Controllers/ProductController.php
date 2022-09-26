<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\ProductService;

class ProductController extends Controller
{
    //This controller responsible for products in the website
    private $productService;
    const LIMIT = 15;
    function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    /*
    Get biggest client discount products based on
    * $categoryId
    * $categoryLevel
        if $categoryLevel is 1 then the products of main category will returned
        else if $categoryLevel is 2 then the products of sub categories will returned
    */
    public function getBiggestClientDiscountProducts()
    {
        return $this->productService
            ->getBiggestClientDiscountProducts(
                request()->category_id,
                request()->category_level,
                request()->name,
                request()->effective_material,
                request()->pharmacological_form,
                request()->company_id,
                request()->supplier_id,
                request()->discount,
                request()->page_size
            );
    }

    public function getDealProducts()
    {
        return $this->productService->getDealProducts(self::LIMIT);
    }

    public function getMainWithSubCategories()
    {
        return $this->productService->getMainWithSubCategories();
    }
}
