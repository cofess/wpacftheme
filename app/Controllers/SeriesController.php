<?php
namespace App\Controllers;

use \App\Models\Series;
use \TypeRocket\Controllers\WPTermController;

class SeriesController extends WPTermController
{
    protected $modelClass = Series::class;
}