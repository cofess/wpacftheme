<?php
namespace App\Controllers;

use \App\Models\KnowledgeCategory;
use \TypeRocket\Controllers\WPTermController;

class KnowledgeCategoryController extends WPTermController
{
    protected $modelClass = KnowledgeCategory::class;
}