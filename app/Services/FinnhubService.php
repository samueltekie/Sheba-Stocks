<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class FinnhubService
{
    protected $client;
    protected $apiKey;

    public function __construct()
    {
        $this->client = new Client();
        $this->apiKey = env('FINNHUB_API_KEY'); // Ensure this is set in your .env file
    
        // Add this line to check if the API key is loaded
        \Log::info('Loaded Finnhub API Key: ' . $this->apiKey);
    }
    

    public function getStockData($symbol)
{
    $url = "https://finnhub.io/api/v1/quote?symbol={$symbol}&token={$this->apiKey}";

    try {
        // Check if the API key is correctly set
        if (!$this->apiKey) {
            \Log::error('Finnhub API key is missing');
            return ['error' => 'API key is missing'];
        }

        $response = $this->client->request('GET', $url);
        $data = json_decode($response->getBody(), true);

        // Log the raw response for debugging
        \Log::info('Finnhub API response', $data);

        return $data;

    } catch (\GuzzleHttp\Exception\RequestException $e) {
        \Log::error('Finnhub API Request Exception: ' . $e->getMessage());
        return ['error' => 'Failed to fetch stock data'];
    } catch (\Exception $e) {
        \Log::error('Unexpected error: ' . $e->getMessage());
        return ['error' => 'Unexpected error occurred'];
    }
}
}
