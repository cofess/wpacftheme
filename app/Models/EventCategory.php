<?php
namespace App\Models;

use \TypeRocket\Models\WPTerm;

class EventCategory extends WPTerm
{
    protected $taxonomy = 'event_category';
}