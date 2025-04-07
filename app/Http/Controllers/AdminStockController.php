<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminStockController extends Controller
{
    public function index()
    {
        // Get symbols from config
        $symbols = config('stocks.symbols');
        return view('admin.stocks.index', compact('symbols'));
    }

    public function store(Request $request)
    {
        // Add a new symbol to the config file
        $newSymbol = $request->input('symbol');

        // Get the current symbols from the config
        $symbols = config('stocks.symbols');
        
        // Check if the symbol already exists
        if (!in_array($newSymbol, $symbols)) {
            // Add the new symbol to the array
            $symbols[] = $newSymbol;
            
            // Update the config file with the new symbol array
            $this->updateSymbolsConfig($symbols);
        }

        return redirect()->route('admin.stocks.index')->with('success', 'Stock symbol added successfully');
    }

    public function destroy($symbol)
    {
        // Get current symbols from the config file
        $symbols = config('stocks.symbols');
        
        // Check if the symbol exists
        if (($key = array_search($symbol, $symbols)) !== false) {
            // Remove the symbol from the array
            unset($symbols[$key]);
            
            // Reindex the array to fix any gaps
            $symbols = array_values($symbols);
            
            // Update the config file with the new array
            $this->updateSymbolsConfig($symbols);
        }

        return redirect()->route('admin.stocks.index')->with('success', 'Stock symbol removed successfully');
    }

    // Helper function to update the config file
    private function updateSymbolsConfig(array $symbols)
    {
        // Path to the config file
        $configPath = config_path('stocks.php');
        
        // Prepare the PHP code to write to the config file
        $configCode = "<?php\nreturn [\n    'symbols' => " . var_export($symbols, true) . ",\n];";
        
        // Write the updated array to the config file
        file_put_contents($configPath, $configCode);
    }
}
