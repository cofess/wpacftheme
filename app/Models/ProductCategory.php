<?php
namespace App\Models;

use \TypeRocket\Models\WPTerm;

class ProductCategory extends WPTerm
{
    protected $taxonomy = 'product_category';
}