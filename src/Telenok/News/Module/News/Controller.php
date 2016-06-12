<?php namespace Telenok\News\Module\News;

class Controller extends \Telenok\Core\Abstraction\Presentation\TreeTabObject\Controller { 
    
    protected $key = 'news';
    protected $icon = 'fa fa-newspaper-o';
    protected $presentation = 'tree-tab-object';
    protected $modelListClass = '\App\Telenok\News\Model\News';
} 