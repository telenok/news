<?php

namespace Telenok\News\Widget\News;

class Controller extends \App\Telenok\Core\Abstraction\Widget\Controller {

    protected $key = 'news';
    protected $parent = 'news';
    protected $defaultFrontendView = "news::widget.news.widget-frontend";
    protected $newsUrlPattern;
    protected $newsUrlId;

    public function setConfig($config = [])
    {
        parent::setConfig($config);

        if (($m = $this->getWidgetModel()) && ($structure = $m->structure) && ($this->newsUrlId = array_get($structure, 'news_id')))
        {
            
        }
        else
        {
            $this->newsUrlId = app('router')->getCurrentRoute()->getParameter('news_id');
            $this->newsUrlPattern = app('router')->getCurrentRoute()->getParameter('news_url_pattern');
        }

        return $this;
    }

    public function preProcess($model, $type, $input)
    {
        $structure = $input->get('structure');

        $structure['news_id'] = (int) array_get($structure, 'news_id');

        $input->put('structure', $structure);

        return parent::preProcess($model, $type, $input);
    }

    public function getNotCachedContent()
    {
        $news = \Cache::remember(
                $this->getCacheKey('news'), $this->getCacheTime(), function()
                {
                    $model = app('\App\Telenok\News\Model\News');

                    return $model
                        ->active()
                        ->with('newsShowInNewsCategory')
                        ->withPermission()
                        ->where(function($query) use ($model)
                        {
                            $query->where($model->getTable() . '.url_pattern', $this->newsUrlPattern);
                            $query->orWhere($model->getTable() . '.id', $this->newsUrlId);
                        })
                        ->first();
                });

        return view($this->getFrontendView(), [
                    'controller' => $this,
                    'news' => $news,
                ])->render();
    }

    public function getCacheKey($additional = '')
    {
        if ($key = parent::getCacheKey($additional))
        {
            return $key . ($this->newsUrlId ? : 0);
        }
        else
        {
            return false;
        }
    }
}
