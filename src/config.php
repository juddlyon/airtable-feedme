<?php
/**
 * Airtable Feed Me config
 *
 * This file exists only as a template for the Airtable Feed Me settings.
 * It does nothing on its own.
 *
 * Don't edit this file, instead copy it to 'craft/config' as 'airtable-feedme.php'
 * and make your changes there to override default settings.
 *
 * Once copied to 'craft/config', this file will be multi-environment aware as
 * well, so you can have different settings groups for each environment, just as
 * you do for 'general.php'
 */

use craft\helpers\App;

return [
    // Default timeout for API requests (in seconds)
    'timeout' => 30,
    
    // Whether to cache API responses
    'enableCache' => true,
    
    // Cache duration in seconds (default: 5 minutes)
    'cacheDuration' => 300,
    
    // Maximum number of retries for failed requests
    'maxRetries' => 3,
    
    // Delay between retries in milliseconds
    'retryDelay' => 1000,
    
    // Whether to log detailed debug information
    'debug' => false,
    
    // Rate limiting: maximum requests per second
    'rateLimit' => 5,
];