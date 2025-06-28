<?php

namespace juddlyon\airtablefeedme\models;

use craft\base\Model;

/**
 * Airtable Feed Me settings
 */
class Settings extends Model
{

    /**
     * @var int Request timeout in seconds
     */
    public int $timeout = 30;

    /**
     * @var bool Whether to cache API responses
     */
    public bool $enableCache = true;

    /**
     * @var int Cache duration in seconds
     */
    public int $cacheDuration = 300;

    /**
     * @var int Maximum number of retries for failed requests
     */
    public int $maxRetries = 3;

    /**
     * @var int Delay between retries in milliseconds
     */
    public int $retryDelay = 1000;

    /**
     * @var bool Whether to log detailed debug information
     */
    public bool $debug = false;

    /**
     * @var int Rate limit: maximum requests per second
     */
    public int $rateLimit = 5;

    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return [
            [['timeout', 'cacheDuration', 'maxRetries', 'retryDelay', 'rateLimit'], 'integer'],
            [['timeout'], 'default', 'value' => 30],
            [['cacheDuration'], 'default', 'value' => 300],
            [['maxRetries'], 'default', 'value' => 3],
            [['retryDelay'], 'default', 'value' => 1000],
            [['rateLimit'], 'default', 'value' => 5],
            [['enableCache', 'debug'], 'boolean'],
            [['enableCache'], 'default', 'value' => true],
            [['debug'], 'default', 'value' => false],
        ];
    }
}