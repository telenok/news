<?php namespace Telenok\News\Module\NewsCategory;

class Controller extends \Telenok\Core\Abstraction\Presentation\TreeTabObject\Controller { 
    
    protected $key = 'news-category';
    protected $icon = 'fa fa-newspaper-o';
    protected $presentation = 'tree-tab-object';
    protected $modelListClass = '\App\Vendor\Telenok\News\Model\NewsCategory';
}