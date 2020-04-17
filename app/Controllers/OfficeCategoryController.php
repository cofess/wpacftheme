<?php
namespace App\Controllers;

use \App\Models\OfficeCategory;
use \TypeRocket\Controllers\WPTermController;

class OfficeCategoryController extends WPTermController
{
    protected $modelClass = OfficeCategory::class;
}