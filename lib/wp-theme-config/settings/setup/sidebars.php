<?php

return function ($sidebars)
{
    foreach( $sidebars as $sidebar ){
        register_sidebar($sidebar);
    }
    // register_sidebars(count($sidebars), array('name'=>'Sidebar %d'));
};