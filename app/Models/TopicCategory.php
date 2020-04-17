<?php
namespace App\Models;

use \TypeRocket\Models\WPTerm;

class TopicCategory extends WPTerm
{
    protected $taxonomy = 'topic_category';
}