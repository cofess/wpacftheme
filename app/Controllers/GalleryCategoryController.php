<?php
namespace App\Controllers;

use \App\Models\GalleryCategory;
use \TypeRocket\Controllers\WPTermController;

class GalleryCategoryController extends WPTermController
{
    protected $modelClass = GalleryCategory::class;
}