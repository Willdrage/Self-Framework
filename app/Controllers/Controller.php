<?php

namespace App\Controllers;


class Controller{

    /**
     * Loads a view file and makes provided data available to it.
     *
     * @param string $view The name of the view file to load (without extension).
     * @param array $data Optional associative array of data to extract and make available in the view.
     *
     * @return void
     */
    protected function view(string $view, array $data = []){
        $viewPath= ROOT."resources/views/".$view.".view.php";
        $replacement= require ROOT.'config/template.php';
        $template=file_get_contents($viewPath);
        
        $template= preg_replace_callback('/@include\s*\(\s*[\'"](.+?)[\'"]\s*\)/', function($matches){
            $file= APP_ROOT."resources/views/".$matches[1].".view.php";
            if (file_exists($file)) {
                return file_get_contents($file);
            }
            return "Include not found";
        }, $template);
        

        foreach ($replacement as $key=>$value){
            $template= preg_replace($key,$value,$template);
        }

        extract($data);
        
        $tmpFile = tempnam(sys_get_temp_dir(), 'view_');

        file_put_contents($tmpFile, $template);        

        include $tmpFile;
        unlink($tmpFile);
    }

    /**
     * Redirects the client to a specified URL.
     *
     * @param string $url The name of the view file to redirect to (without extension).
     * 
     * @return void
     */
    protected function redirect(string $url){
        $test=APP_ROOT.ltrim($url,'/');
        header('Location: '.APP_ROOT.ltrim($url,'/'));
        exit;
    }

    protected function json($data, int $status = 200, array $headers= []){
        http_response_code($status);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }
    /**    
     * Get the connected user if exist
     */
    protected function auth(){
        return $_SESSION['user'] ?? null;
    }

    /**
     * Prints debug information about one or more variables without stopping script execution.
     *
     * @param mixed $var One or more variables to be dumped.
     * @return void
     */
    protected function dump(...$vars): void{
        echo "<div style='background:#111; color:#eee; padding:20px; font-family:Consolas, monospace;'>";

        foreach ($vars as $var) {
            echo "<div style='background:#222; padding:10px; margin-bottom:5px; border-radius:6px;'>";
            echo "<pre style='margin:0; color:#0f0; font-size:14px;'>";
            print_r($var);
            echo "</pre>";
            echo "</div>";
        }

        echo "</div>";
    }

    /**
     * Prints debug information about one or more variables and stops script execution.
     *
     * @param mixed $var One or more variables to be dumped.
     * @return void
     */
    protected function dd(...$vars): void {
        $this->dump(...$vars);
        exit;
    }
}