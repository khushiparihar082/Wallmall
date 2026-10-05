<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;
use PHPUnit\Framework\Constraint\StringContains;
use ReflectionMethod;

use function PHPUnit\Framework\stringContains;

class GeneratePostmanCollectionCI4 extends BaseCommand
{
    protected $group = 'Custom';
    protected $name = 'postman:generate';
    protected $description = 'Generate Postman collection from routes';
    protected $collectionname = "BackendApiCollection";
    protected $api_url_variable_name = "api_url";
    protected $params = [
        'collectionname' => [
            'description' => 'Postman collection (default: BackendApiCollection)',
            'default' => 'BackendApiCollection',
        ],
        'baseUrlVariable' => [
            'description' => 'Postman Url Global Variable (default: api_url)',
            'default' => 'api_url',
        ],
        'filename' => [
            'description' => 'Filename for the Postman collection (default: postman_collection.json)',
            'default' => 'postman_collection.json',
        ],
    ];
    // php spark postman:generate --collectionname HansaHandloom --baseUrlVariable api_url --filename mycollection.json
    public function run(array $params)
    {
        try {
            $this->collectionname = $params['collectionname'] ?? $this->collectionname;
            $this->api_url_variable_name = $params['baseUrlVariable'] ?? $this->api_url_variable_name;
            $fileName = $params['filename'] ?? 'postman_collection.json';
            $this->generatePostmanCollection($fileName);
        } catch (\Throwable $th) {
            CLI::write($th->getMessage(), 'red');
        }
    }

    public function generatePostmanCollection(string $fileName): void
    {
        $routes = service('routes');
        $methods = ['get', 'post', 'put', 'patch', 'delete'];

        // Initialize the Postman collection
        $postmanCollection = [
            'info' => [
                'name' => 'Your API Collection',
                '_postman_id' => uniqid(),
                'description' => 'Collection of API endpoints for your application',
                'schema' => 'https://schema.getpostman.com/json/collection/v2.1.0/collection.json'
            ],
            'item' => []
        ];
        $customRoutes = [];
        foreach ($methods as $method) {
            $routes->setHTTPVerb($method);
            $allRoutes[$method] = $routes->getRoutes();
        }
        foreach ($allRoutes as $key => $http_method) {
            foreach ($http_method as $urlKey => $classKey) {
                // Your ControllerFunctionPath
                $ControllerFunctionPath = $classKey;

                // Split the ControllerFunctionPath into class and method
                if (is_object($ControllerFunctionPath)) {
                    continue;
                }
                list($controllerClass, $method) = explode("::", $ControllerFunctionPath);

                // Remove leading backslash if present
                $controllerClass = ltrim($controllerClass, "\\");

                // Use reflection to get the comment of the method


                // Get the comment
                try {
                    $reflectionMethod = new ReflectionMethod($controllerClass, $method);
                    $comment = $reflectionMethod->getDocComment();
                } catch (\Throwable $th) {
                    //throw $th;
                }

                // Inside the loop where you extract routes
                if (is_string($classKey)) {
                    $folders = explode('/', $urlKey);
                    $folderCount = count($folders);
                    $class_method = explode('::', $classKey);
                    $functionName = end($class_method);

                    // Use reflection to get the comment of the method
                    try {
                        $reflectionMethod = new ReflectionMethod($controllerClass, $method);
                        $comment = $reflectionMethod->getDocComment();
                    } catch (\ReflectionException $e) {
                        $comment = ''; // Handle error if method not found
                    }

                    $nestedArray = &$customRoutes; // Start with the root array reference

                    // Dynamically construct the nested arrays based on the folder count
                    for ($i = 0; $i < $folderCount - 1; $i++) {
                        if (!isset($nestedArray[$folders[$i]])) {
                            $nestedArray[$folders[$i]] = [];
                        }
                        $nestedArray = &$nestedArray[$folders[$i]]; // Move to the next level
                    }

                    // Add the route information to the appropriate nested array
                    $nestedArray[] = [
                        'method' => $key,
                        'url' => $urlKey,
                        'class' => $classKey,
                        'functionName' => $functionName,
                        'folderCount' => $folderCount,
                        'functionComment' => $comment // Add function comment here
                    ];
                }
            }
        }
        $collection = [
            'info' => [
                '_postman_id' => uniqid(),
                'name' => $this->collectionname,
                'schema' => 'https://schema.getpostman.com/json/collection/v2.1.0/collection.json',
            ],
            'item' => [],
        ];
        // Iterate through the data and create collection items
        $groupItem['item'] = [];
        // dd($customRoutes);
        foreach ($customRoutes as $groupName => $endpoints) {
            $pattern = '/api/i';
            if (preg_match($pattern, $groupName)) {
                $collection['item'][] = $this->itemFolderProcess($endpoints, $groupName);
            }
        }
        // Convert the collection to JSON
        $collectionJson = json_encode($collection, JSON_PRETTY_PRINT);
        file_put_contents($fileName, $collectionJson);
        CLI::write('Postman collection generated successfully!', 'green');
    }
    public function itemFolderProcess(&$item, $groupName = '')
    {
        $result = [
            'name' => $groupName,
            'item' => []
        ];

        foreach ($item as $key => $value) {
            if (!is_int($key)) {
                // If the value is an array, recursively process it
                $result['item'][] = $this->itemFolderProcess($value, $key);
            } else {
                // If the value is not an array, it should represent an endpoint
                $result['item'][] = $this->itemEndPointResponse($value);
            }
        }

        return $result;
    }
    public function itemEndPointResponse(&$item)
    {
        $uncommented = $item['functionComment'];

        $uncommented = str_replace("/**", "", $item['functionComment']);
        $uncommented = str_replace("**/", "", $item['functionComment']);
        $uncommented = str_replace("*/", "", $item['functionComment']);
        $uncommented = str_replace("*", "", $item['functionComment']);


        $item['functionComment'] = $item['functionComment'] . $uncommented;

        return [
            "name" => $item['functionName'],
            "request" => [
                "method" => $item['method'],
                "header" => [],
                "body" => [
                    "mode" => "raw",
                    "raw" => $item['functionComment'], // Use function comment here          
                    "options" => [
                        "raw" => [
                            "language" => "json"
                        ]
                    ]
                ],
                "url" => [
                    "raw" => "{{" . $this->api_url_variable_name . "}}" . $item['url'],
                    "host" => [
                        "{{" . $this->api_url_variable_name . "}}"
                    ],
                    "path" => explode('/', $item['url'])
                ]
            ],
        ];
    }
}
