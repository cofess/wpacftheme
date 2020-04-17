<?php
namespace App\Controllers;

use \App\Models\ProductBrand;
use \TypeRocket\Controllers\WPTermController;

class ProductBrandController extends WPTermController
{
    protected $modelClass = ProductBrand::class;
}