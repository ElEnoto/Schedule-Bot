<?php
namespace Otus;

class View
{
    public string $name;
    public string $title;
    public array $content;
    public static string $error = '';
    public function __construct($name, $title, $content){
        $this->name = $name;
        $this->title = $title;
        $this->content = $content;
    }
    public function template():void
    {
        require_once 'Views/template.php';
        exit();
    }
    public static function authenticate():void
    {
        require_once 'Views/authenticate.php';
        exit();
    }
    public function show_events():void
    {
        require_once 'Views/show_events.php';
        exit();
    }
}



