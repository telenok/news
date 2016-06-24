<?php namespace Telenok\News\Widget\NewsList;

class Controller extends \App\Vendor\Telenok\Core\Abstraction\Widget\Controller {

    protected $key = 'news-list';
    protected $parent = 'news';
	protected $defaultFrontendView = "news::widget.news-list.widget-frontend";

    protected $perPage = 30;
    protected $categoryIds = [];
    protected $page = 0;
    protected $ignorePage = false;
    protected $newsCategoryUrlPattern;
    protected $closureQuery;

    public function setConfig($config = [])
    {
        parent::setConfig($config);
        
        if ($m = $this->getWidgetModel())
        {
            $structure = $m->structure;

            $this->perPage = array_get($structure, 'per_page')?:$this->perPage;
            $this->categoryIds = (array)array_get($structure, 'category_ids');
            $this->ignorePage = (bool)array_get($structure, 'ignore_page', $this->ignorePage);
        }
        else 
        {
            $this->perPage = (int)$this->getConfig('per_page', $this->perPage)?:$this->perPage;
            $this->categoryIds = (array)$this->getConfig('category_ids', $this->categoryIds);
            $this->ignorePage = (bool)$this->getConfig('ignore_page', $this->ignorePage);
            $this->closureQuery = $this->getConfig('closure_query', $this->closureQuery);
        }

        $this->page = $this->getRequest()->get('p', $this->page);
        $this->newsCategoryUrlPattern = app('router')->getCurrentRoute()->getParameter('news_category_url_pattern');
        
        return $this;
    }

    public function getPage()
    {
        return $this->page;
    }

    public function getPerPage()
    {
        return $this->perPage;
    }

    public function getCategoryIds()
    {
        return $this->categoryIds;
    }

    public function getIgnorePage()
    {
        return $this->ignorePage;
    }

    public function getNewsCategoryUrlPattern()
    {
        return $this->newsCategoryUrlPattern;
    }

    public function preProcess($model, $type, $input)
    { 
        $structure = $input->get('structure');

        $structure['per_page'] = (int)array_get($structure, 'per_page');
        $structure['category_ids'] = (array)array_get($structure, 'category_ids');
        $structure['ignore_page'] = (bool)array_get($structure, 'ignore_page');

        $input->put('structure', $structure);
        
        return parent::preProcess($model, $type, $input);
    }

	public function getCacheKey($additional = '')
	{
        if ($key = parent::getCacheKey($additional))
        {
            return $key 
                    . implode('', $this->getCategoryIds())
                    . $this->getNewsCategoryUrlPattern()
                    . $this->getPerPage()
                    . $this->getPage()
                    . $this->getIgnorePage();
        }
        else
        {
            return false;
        }
	}

	public function getNotCachedContent()
	{
        $news = \Cache::remember(
            $this->getCacheKey('newsCategory'), 
            $this->getCacheTime(), 
            function()
            {
                $newsModel = app('\App\Vendor\Telenok\News\Model\News');

                $query = $newsModel->withPermission()->with('newsShowInNewsCategory');

                $query->whereHas('newsLanguageLanguage', function($query)
                {
                    $query->where('locale', config('app.locale'));
                    $query->orWhereNull('locale');
                });

                
                if ($catIds = $this->getCategoryIds())
                {
                    $newsCategoryModel = app('\App\Vendor\Telenok\News\Model\NewsCategory');

                    $categoryIds = $newsCategoryModel->withPermission()
                            ->active()
                            ->whereIn($newsCategoryModel->getTable() . '.id', $catIds)
                            ->lists('id');

                    $query->whereHas('newsNewsCategory', function($query) use ($newsCategoryModel, $categoryIds)
                    {
                        $query->whereIn($newsCategoryModel->getTable() . '.id', $categoryIds);
                    });
                }
                else if ($catUrl = $this->getNewsCategoryUrlPattern())
                {
                    $query->whereHas('newsNewsCategory', function($query) use ($catUrl, $newsModel)
                    {
                        $query->where($newsModel->getTable() . '.url_pattern', $catUrl);
                    });
                }

                $query->orderBy($newsModel->getTable() . '.active_at_start');

                if (($cl = $this->closureQuery) instanceof \Closure)
                {
                    $cl($query, $this);
                }

                return $query->skip($this->getPage() * $this->getPerPage())
                            ->take($this->getPerPage())
                            ->get();
            });

        return view($this->getFrontendView(), [
                        'controller' => $this, 
                        'news' => $news,
                    ])->render();
	}
}