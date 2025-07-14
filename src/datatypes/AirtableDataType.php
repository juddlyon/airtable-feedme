<?php

namespace juddlyon\airtablefeedme\datatypes;

use Cake\Utility\Hash;
use Craft;
use craft\feedme\base\DataType;
use craft\feedme\base\DataTypeInterface;
use craft\feedme\Plugin as FeedMe;
use craft\helpers\Json as JsonHelper;
use juddlyon\airtablefeedme\AirtableFeedMe;

/**
 * Airtable data type with automatic pagination support
 *
 * @author Judd Lyon <jl@juddlyon.com>
 * @since 1.0.0
 */
class AirtableDataType extends DataType implements DataTypeInterface
{
    /**
     * @var string
     */
    public static string $name = 'Airtable';

    /**
     * @inheritDoc
     */
    public function getFeed($url, $settings, bool $usePrimaryElement = true): array
    {
        $feedId = Hash::get($settings, 'id');
        $allRecords = [];
        $currentUrl = $url;
        
        // Get base request options from feed configuration
        $requestOptions = FeedMe::$plugin->service->getRequestOptions($feedId) ?: [];
        
        // Ensure headers array exists
        if (!isset($requestOptions['headers'])) {
            $requestOptions['headers'] = [];
        }
        
        // Get API key from plugin
        $apiKey = AirtableFeedMe::getInstance()->getApiKey();
        if (empty($apiKey)) {
            throw new \Exception('Airtable API key not configured. Please add it in the plugin settings or set the AIRTABLE_API_KEY environment variable.');
        }
        
        // Add Airtable authorization header
        $requestOptions['headers']['Authorization'] = 'Bearer ' . $apiKey;
        $requestOptions['headers']['Accept'] = 'application/json';
        
        do {
            // Create Guzzle client and make request with our options
            $client = FeedMe::$plugin->service->createGuzzleClient($feedId);
            
            try {
                $resp = $client->request('GET', $currentUrl, $requestOptions);
                $data = (string)$resp->getBody();
                $response = ['success' => true, 'data' => $data];
            } catch (\Exception $e) {
                $error = 'Unable to reach ' . $currentUrl . '. Message: ' . $e->getMessage();
                
                FeedMe::error($error);
                
                return ['success' => false, 'error' => $error];
            }
            
            // Handle the response
            if (!$response['success']) {
                $error = 'Unable to reach ' . $currentUrl . '. Message: ' . $response['error'];
                
                FeedMe::error($error);
                
                return ['success' => false, 'error' => $response['error']];
            }
            
            $data = $response['data'];
            
            // Parse the JSON response
            try {
                $parsedData = JsonHelper::decode($data);
            } catch (\Exception $e) {
                $error = 'Invalid JSON response: ' . $e->getMessage();
                
                FeedMe::error($error);
                
                return ['success' => false, 'error' => $error];
            }
            
            // Extract records from the current page
            if (isset($parsedData['records']) && is_array($parsedData['records'])) {
                $allRecords = array_merge($allRecords, $parsedData['records']);
            }
            
            // Check if there's another page
            $currentUrl = null;
            if (isset($parsedData['offset'])) {
                // Build next page URL with offset
                $urlParts = parse_url($url);
                $query = [];
                if (isset($urlParts['query'])) {
                    parse_str($urlParts['query'], $query);
                }
                $query['offset'] = $parsedData['offset'];
                
                $currentUrl = $urlParts['scheme'] . '://' . $urlParts['host'] . $urlParts['path'] . '?' . http_build_query($query);
            }
            
        } while ($currentUrl !== null);
        
        // Return all records in the expected format
        $finalData = ['records' => $allRecords];
        
        // For primary element detection, return raw array data
        // For actual feed processing, let Feed Me handle the data format
        if (!$usePrimaryElement) {
            // Return raw data so Feed Me can analyze structure for dropdown
            return ['success' => true, 'data' => $finalData];
        }
        
        // Look for and return only the items for primary element
        $primaryElement = Hash::get($settings, 'primaryElement');
        
        if ($primaryElement && $usePrimaryElement) {
            $array = FeedMe::$plugin->data->findPrimaryElement($primaryElement, $finalData);
        } else {
            $array = $finalData;
        }
        
        $this->feedData = $array;
        
        // Return processed data
        return ['success' => true, 'data' => $array];
    }
}