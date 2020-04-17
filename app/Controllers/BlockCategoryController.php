<?php
namespace App\Controllers;

use \App\Models\BlockCategory;
use \TypeRocket\Controllers\WPTermController;

class BlockCategoryController extends WPTermController
{
    protected $modelClass = BlockCategory::class;
}