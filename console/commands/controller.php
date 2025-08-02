<?php

require_once __DIR__ . '/../help.php';

function makeController($name, $type) {
    if (in_array($name,['help','-h','--help'])){
        showControllerHelp();
        exit;
    }
    
    $pathParts= explode('/', $name);
    $controller = ucfirst(array_pop($pathParts));

    $path= implode('/', array_map('ucfirst',$pathParts));
    $namespace= "App\\Controllers".($path ? "\\".str_replace('/','\\',$path) : "");
    $directory = "app/Controllers". ($path ? "/$path" : "");
    if (!is_dir($directory)){
        mkdir($directory,0777,true);
    }

    $filename = "{$directory}/{$controller}.php";
    $useStatement = $path ? "use App\\Controllers\\Controller;" : "";

    //Controller
    if($type==='controller'){
    $template = <<<PHP
<?php

namespace {$namespace};
{$useStatement}

class {$controller} extends Controller {
    public function index() {
        // TODO: Add logic for the index action
    }
}
PHP;
    };

    //resource controller
    if($type==='resource'){
$template= <<<PHP
<?php

namespace {$namespace};
{$useStatement}

class {$controller} extends Controller{
    /**
     * Display a listing of the resource
     */
    function index()
        {

        }

    /**
     * Display the specified resource
     */
    function show(string \$id)
        {

        }

    /**
     * Show the form for creating a new resource
     */
    function create()   
        {

        }

    /**
     * Store a newly created resource in storage
     */
    function store(string \$id)
        {

        }

    /**
     * Show the form for editing the specified resource
     */
    function edit(string \$id)
        {

        }

    /**
     * Update the specified resource in storage
     */
    function update(string \$id)
        {

        }

    /**
     * Remove the specified resource from storage
     */
    function delete(string \$id)
        {

        }
}

PHP;
    };

    createFiles($filename,$template,$type);
} 