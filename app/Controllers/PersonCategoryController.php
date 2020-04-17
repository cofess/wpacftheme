<?php
namespace App\Controllers;

use \App\Models\PersonCategory;
use \TypeRocket\Controllers\WPTermController;

class PersonCategoryController extends WPTermController
{
    protected $modelClass = PersonCategory::class;
}