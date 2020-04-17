<?php
namespace App\Controllers;

use \App\Models\ProductCategory;
use \TypeRocket\Controllers\WPTermController;

class ProductCategoryController extends WPTermController
{
    protected $modelClass = ProductCategory::class;
}