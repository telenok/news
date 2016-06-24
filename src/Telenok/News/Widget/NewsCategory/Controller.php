<?php namespace Telenok\News\Widget\NewsCategory;

class Controller extends \App\Vendor\Telenok\Core\Abstraction\Widget\Controller {

    protected $key = 'news-category';
    protected $parent = 'news';
	protected $defaultFrontendView = "news::widget.product-category.widget-frontend";
    protected $newsCategoryUrl;
    protected $newsCategoryId; 

    public function setConfig($config = [])
    {
        parent::setConfig($config);

        if (($m = $this->getWidgetModel()) 
                && ($structure = $m->structure) 
                && ($this->newsCategoryId = array_get($structure, 'category_id'))) {}
        else 
        {
            $this->newsCategoryUrl = app('router')->getCurrentRoute()->getParameter('news_category_url_pattern');
        }

        return $this;
    }

    public function preProcess($model, $type, $input)
    { 
        $structure = $input->get('structure');

        $structure['category_id'] = (int)array_get($structure, 'category_id');

        $input->put('structure', $structure);

        return parent::preProcess($model, $type, $input);
    }

	public function getNotCachedContent()
	{
        $newsCategory = \Cache::remember(
            $this->getCacheKey('newsCategory'), 
            $this->getCacheTime(), 
            function()
            {   
                $model = app('\App\Vendor\Telenok\News\Model\NewsCategory');
            
                return $model::active()
                    ->active()
                    ->withPermission()
                    ->where(function($query)
                    {
                        $query->where($model->getTable() . '.url_pattern', $this->newsCategoryUrl);
                        $query->orWhere($model->getTable() . '.id', $this->newsCategoryId);
                    })
                    ->first();
            });

        return view($this->getFrontendView(), [
                    'controller' => $this, 
                    'category' => $newsCategory,
                ])->render();
	}

	public function getCacheKey($additional = '')
	{
        if ($key = parent::getCacheKey($additional))
        {
            return $key . ($this->newsCategory ? $this->newsCategory->getKey() : 0);
        }
        else
        {
            return false;
        }
	}
}