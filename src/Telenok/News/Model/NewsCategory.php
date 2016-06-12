<?php namespace Telenok\News\Model;

class NewsCategory extends \App\Telenok\Core\Abstraction\Eloquent\Object\Model {

	protected $table = 'news_category';
    
    public function setUrlPatternAttribute($value)
    {
        $this->attributes['url_pattern'] = preg_replace("![^a-z0-9]+!i", "-", $value);
    }
}