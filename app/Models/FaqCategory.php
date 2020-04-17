<?php
namespace App\Models;

use \TypeRocket\Models\WPTerm;

class FaqCategory extends WPTerm
{
    protected $taxonomy = 'faq_category';
}