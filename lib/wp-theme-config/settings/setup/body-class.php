<?php

return function ($options)
{
    add_filter( 'body_class', function( $classes ) use( $options ){
        foreach($options as $class){
            $classes[] = $class; 
        }
        return $classes;  
    } );
};