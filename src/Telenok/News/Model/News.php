<?php namespace Telenok\News\Model;

class News extends \App\Vendor\Telenok\Core\Abstraction\Eloquent\Object\Model {

	protected $table = 'news';
    
    public function setUrlPatternAttribute($value)
    {
        $this->attributes['url_pattern'] = preg_replace("![^a-z0-9]+!i", "-", $value);
    }
}