<?php
namespace App\Controllers;

use \App\Models\GlossaryCategory;
use \TypeRocket\Controllers\WPTermController;

class GlossaryCategoryController extends WPTermController
{
    protected $modelClass = GlossaryCategory::class;
}