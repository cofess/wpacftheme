<?php
namespace App\Controllers;

use \App\Models\PortfolioCategory;
use \TypeRocket\Controllers\WPTermController;

class PortfolioCategoryController extends WPTermController
{
    protected $modelClass = PortfolioCategory::class;
}