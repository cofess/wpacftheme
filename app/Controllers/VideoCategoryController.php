<?php
namespace App\Controllers;

use \App\Models\VideoCategory;
use \TypeRocket\Controllers\WPTermController;

class VideoCategoryController extends WPTermController
{
    protected $modelClass = VideoCategory::class;
}