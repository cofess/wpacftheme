<?php
namespace App\Controllers;

use \App\Models\FaqCategory;
use \TypeRocket\Controllers\WPTermController;

class FaqCategoryController extends WPTermController
{
    protected $modelClass = FaqCategory::class;
}