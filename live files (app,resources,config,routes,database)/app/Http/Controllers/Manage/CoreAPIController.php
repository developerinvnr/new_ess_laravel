<?php

namespace App\Http\Controllers\Manage;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class CoreAPIController extends Controller
{
    public function get_core_apis()
    {
        $api_list = DB::table('core_apis')->get();
        return view('manage.basic.master.core.core_apis', compact('api_list'));
    }

    public function sync()
    {
        try {
            // Retrieve the API key and base URL
            $apiData = DB::table('core_api_setup')->first();
            $apiKey = $apiData->api_key;
            $baseUrl = $apiData->base_url;

            // Make the GET request with the correct headers
            $response = Http::withHeaders([
                'api-key' => $apiKey, // Setting the 'api-key' header as required
                'Accept' => 'application/json',
            ])->get("$baseUrl/api/project/apis");

            // Check if the response is successful
            if ($response->failed()) {
                // Handle unsuccessful responses
                Log::error('API sync failed', ['status' => $response->status(), 'response' => $response->body()]);
                return response()->json(['status' => 400, 'msg' => 'Failed to synchronize APIs.']);
            }

            // Parse the JSON response
            $data = $response->json();

            // Validate the structure of the response
            if (!isset($data['api_list']) || !is_array($data['api_list'])) {
                Log::error('Invalid API response structure', ['response' => $data]);
                return response()->json(['status' => 400, 'msg' => 'Unexpected API response format.']);
            }

            // Prepare data for batch insertion
            $apiRecords = array_map(function ($value) {
                return [
                    'api_id' => $value['id'] ?? null,
                    'api_name' => $value['api_name'] ?? '',
                    'api_end_point' => $value['api_end_point'] ?? '',
                    'description' => $value['description'] ?? '',
                    'parameters' => $value['parameters']
                ];
            }, $data['api_list']);

            // Use a transaction to ensure atomic operation

            DB::table('core_apis')->truncate();
            DB::table('core_apis')->insert($apiRecords); // Batch insert for performance


            return response()->json(['status' => 200, 'msg' => 'API synchronized successfully.']);
        } catch (\Illuminate\Database\QueryException $e) {
            // Handle database-specific exceptions
            Log::error('Database error during API sync', ['error' => $e->getMessage()]);
            return response()->json(['status' => 500, 'msg' => 'Database error occurred.']);
        }
    }

    public function importAPISData(Request $request)
    {
        $apiEndPoints = $request->input('api_end_points');
        $CoreAPI = DB::table('core_api_setup')->first();
        $apiKey = $CoreAPI->api_key;
        $baseUrl = $CoreAPI->base_url;
        foreach ($apiEndPoints as $api) {
            $apiData = DB::table('core_apis')->where('api_end_point', $api)->value('parameters');
            $parameter = $apiData;
            
            if ($parameter) {
                $tableName = 'core_' . rtrim($parameter, '_id') . 's';
                $ids = DB::table($tableName)->pluck('id');
    
                if ($ids->isEmpty()) {
                    return response()->json(['status' => 400, 'msg' => "No records found in table $tableName"], 400);
                }
    
                foreach ($ids as $id) {
                    $response = Http::withHeaders([
                        'api-key' => $apiKey,
                        'Accept' => 'application/json'
                    ])->get("$baseUrl/api/$api", [$parameter => $id]);
    
                    $this->processApiResponse($response->body(), $response->status(), $api, $parameter, $id);
                }
            } else {
                $response = Http::withHeaders([
                    'api-key' => $apiKey,
                    'Accept' => 'application/json'
                ])->get("$baseUrl/api/$api");
    
                $this->processApiResponse($response->body(), $response->status(), $api);
            }
        }
    }

    private function processApiResponse($response, $httpStatus, $api, $parameter = null, $id = null)
    {
        // Check if the request was successful
        if ($httpStatus != 200) {
            $errorMsg = $parameter && $id ? "$parameter=$id" : "No parameter";
            Log::error("API sync failed for $api with $errorMsg: HTTP Status $httpStatus. Response: $response");
            return response()->json(['status' => 400, 'msg' => 'Failed to synchronize APIs.'], 400);
        }
    
        // Decode the JSON response
        $data = json_decode($response, true);
    
        // Validate the structure of the response
        if (!isset($data['list']) || !is_array($data['list'])) {
            $errorMsg = $parameter && $id ? "$parameter=$id" : "No parameter";
            Log::error("Invalid API response structure for $api with $errorMsg. Response: " . json_encode($data));
            return response()->json(['status' => 400, 'msg' => 'Unexpected API response format.'], 400);
        }
    
        // Extract column names from the first item
        $columns = array_keys($data['list'][0]);
        $tableName = "core_$api";
    
        // Dynamically create a table if it doesn't exist
        $createTableQuery = "CREATE TABLE IF NOT EXISTS $tableName (";
        foreach ($columns as $column) {
            $createTableQuery .= "`$column` VARCHAR(255),"; // Assuming all fields as VARCHAR(255), adjust as needed
        }
        $createTableQuery .= "PRIMARY KEY (`id`))"; // Assuming an `id` field as the primary key
        
        DB::statement($createTableQuery);
    
        // Prepare insert or update queries
        foreach ($data['list'] as $item) {
            $columns = implode(",", array_keys($item)); // Get column names
            $values = implode("','", array_map(fn($value) => addslashes($value), array_values($item))); // Escape values
    
            // Construct the INSERT INTO ... ON DUPLICATE KEY UPDATE query
            $updateQueryParts = [];
            foreach ($item as $column => $value) {
                $escapedValue = addslashes($value);
                $updateQueryParts[] = "`$column` = '$escapedValue'";
            }
            $updateQuery = implode(", ", $updateQueryParts);
    
            $insertQuery = "INSERT INTO $tableName ($columns) VALUES ('$values') 
                            ON DUPLICATE KEY UPDATE $updateQuery";
    
            DB::statement($insertQuery);
        }
    
        return response()->json(['status' => 200, 'msg' => "APIs synchronized successfully" . ($parameter && $id ? " for $parameter=$id" : "")]);
    }
}
