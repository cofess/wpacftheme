<?php

/**
 * Heartbeat Frequency
 */
return function($value) 
{
    global $heartbeat_frequency;
    $heartbeat_frequency = $value;

    function perfmatters_heartbeat_frequency($settings) {
        global $heartbeat_frequency;
        $settings['interval'] = $heartbeat_frequency;
        return $settings;
    }
    
    add_filter('heartbeat_settings', 'perfmatters_heartbeat_frequency');
};
