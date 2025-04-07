<?php

namespace App\Http\Controllers;

use App\Models\Wallet;
use App\Models\Transaction; // Ensure you import the Transaction model
use App\Services\FinnhubService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Stock;
class StockController extends Controller
{
    protected $finnhub;

    public function __construct(FinnhubService $finnhub)
    {
        $this->finnhub = $finnhub;
    }

    public function fetchRealTimeData($symbol)
    {
        $data = $this->finnhub->getStockData($symbol);

        if ($data) {
            return response()->json($data);
        } else {
            return response()->json(['error' => 'Stock data not found'], 404);
        }
    }

    public function showStockList()
{
    $user = Auth::user();

    if (!$user) {
        return redirect()->route('login');
    }

    $symbols = config('stocks.symbols');
    $stocksData = [];

    foreach ($symbols as $symbol) {
        $data = $this->finnhub->getStockData($symbol);

        // Log the full response for debugging
        \Log::info("API Response for $symbol: ", $data);

        // Check if data is valid and contains the required keys
        if ($data && array_key_exists('c', $data) && array_key_exists('h', $data) && array_key_exists('l', $data) && array_key_exists('o', $data) && array_key_exists('t', $data)) {
            $stocksData[] = [
                'symbol' => $symbol,
                'price' => $data['c'],   // Current price
                'high' => $data['h'],    // Day high price
                'low' => $data['l'],     // Day low price
                'open' => $data['o'],    // Opening price
                'timestamp' => date('Y-m-d H:i:s', $data['t']), // Timestamp
            ];
        } else {
            // Log an error if the data structure is unexpected
            \Log::error("Unexpected API response structure for $symbol: ", $data ?? []);

            // Add fallback data with 'N/A'
            $stocksData[] = [
                'symbol' => $symbol,
                'price' => 'N/A',
                'high' => 'N/A',
                'low' => 'N/A',
                'open' => 'N/A',
                'timestamp' => 'N/A',
            ];
        }
    }

    return view('stocks.list', compact('user', 'stocksData'));
}
    public function buyStock(Request $request)
{
    $request->validate([
        'symbol' => 'required|string',
        'quantity' => 'required|integer|min:1',
    ]);

    // Fetch real-time stock price
    $data = $this->finnhub->getStockData($request->input('symbol'));
    
    if (!$data) {
        return redirect()->back()->with('error', 'Stock data not found.');
    }

    $price = $data['c']; // Current price
    $totalCost = $price * $request->input('quantity');

    // Get the user's wallet
    $wallet = Wallet::where('user_id', auth()->id())->firstOrFail();

    // Check if the user has sufficient balance
    if ($wallet->available_balance >= $totalCost) {
        // Deduct the total cost from the wallet
        $wallet->available_balance -= $totalCost;
        $wallet->invested_amount += $totalCost;
        $wallet->save();

        // Record the transaction
        Transaction::create([
            'user_id' => auth()->id(),
            'wallet_id' => $wallet->id,
            'type' => 'stock_purchase',
            'amount' => -$totalCost, // Store as negative since it's a deduction
            'details' => "Purchased {$request->input('quantity')} shares of {$request->input('symbol')} at \${$price} each."
        ]);

        return redirect()->route('stocks.show', $request->input('symbol'))->with('success', "You bought {$request->input('quantity')} shares of {$request->input('symbol')} for \${$totalCost}.");
    }

    return redirect()->back()->with('error', 'Insufficient balance for this purchase.');
}

    public function show($symbol)
    {
        // Fetch stock data using the Finnhub service
        $data = $this->finnhub->getStockData($symbol);

        if (!$data) {
            return redirect()->route('stocks.list')->with('error', 'Stock not found.');
        }

        return view('stocks.show', [
            'symbol' => $symbol,
            'price' => $data['c'],  // Current price
            'stock' => [
                'high' => $data['h'],   // Day high price
                'low' => $data['l'],    // Day low price
                'open' => $data['o'],   // Opening price
                'timestamp' => date('Y-m-d H:i:s', $data['t']), // Timestamp (optional)
            ]
        ]);
    }
    public function fetchStockData(Request $request)
    {
        $symbol = $request->input('symbol');
        $timeframe = $request->input('timeframe', '1d'); // Default to 1 day

        // Fetch data from the FinnhubService based on timeframe
        $data = $this->finnhub->getStockDataForTimeframe($symbol, $timeframe);

        if (!$data) {
            return response()->json(['error' => 'Stock data not found'], 404);
        }

        // Extract data
        $prices = array_column($data['candles'], 'close'); // Closing prices
        $dates = array_map(function($timestamp) {
            return date('Y-m-d H:i', $timestamp);
        }, array_column($data['candles'], 'timestamp'));

        return response()->json(['prices' => $prices, 'dates' => $dates]);
    }
    /*public function index()
    {
        $stocks = Stock::paginate(10);
        return view('admin.stocks.index', compact('stocks'));
    }

    public function create()
    {
        return view('admin.stocks.create');
    }

    public function store(Request $request)
    {
        $stock = new Stock();
        $stock->name = $request->input('name');
        $stock->symbol = $request->input('symbol');
        $stock->company = $request->input('company');
        
        // Handle file upload
        if ($request->hasFile('logo')) {
            $path = $request->file('logo')->store('logos', 'public');
            $stock->logo = $path;
        }

        $stock->save();

        return redirect()->route('admin.stocks.index')->with('success', 'Stock added successfully');
    }

    public function edit($id)
    {
        $stock = Stock::find($id);
        return view('admin.stocks.edit', compact('stock'));
    }

    public function update(Request $request, $id)
    {
        $stock = Stock::find($id);
        $stock->name = $request->input('name');
        $stock->symbol = $request->input('symbol');
        $stock->company = $request->input('company');
        
        // Handle file upload
        if ($request->hasFile('logo')) {
            $path = $request->file('logo')->store('logos', 'public');
            $stock->logo = $path;
        }

        $stock->save();

        return redirect()->route('admin.stocks.index')->with('success', 'Stock updated successfully');
    }

    public function destroy($id)
    {
        $stock = Stock::find($id);
        $stock->delete();

        return redirect()->route('admin.stocks.index')->with('success', 'Stock deleted successfully');
    }*/

}