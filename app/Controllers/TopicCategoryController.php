<?php
namespace App\Controllers;

use \App\Models\TopicCategory;
use \TypeRocket\Controllers\WPTermController;

class TopicCategoryController extends WPTermController
{
    protected $modelClass = TopicCategory::class;
}