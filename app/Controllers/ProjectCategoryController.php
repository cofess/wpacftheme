<?php
namespace App\Controllers;

use \App\Models\ProjectCategory;
use \TypeRocket\Controllers\WPTermController;

class ProjectCategoryController extends WPTermController
{
    protected $modelClass = ProjectCategory::class;
}