<?php
namespace App\Controllers;

use \App\Models\DownloadCategory;
use \TypeRocket\Controllers\WPTermController;

class DownloadCategoryController extends WPTermController
{
    protected $modelClass = DownloadCategory::class;
}