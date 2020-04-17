<?php
namespace App\Controllers;

use \App\Models\EventCategory;
use \TypeRocket\Controllers\WPTermController;

class EventCategoryController extends WPTermController
{
    protected $modelClass = EventCategory::class;
}