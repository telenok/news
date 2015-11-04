<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SeedNews extends Migration {

	public function up()
	{
        try
        {
            // Off permission validator
            \App\Telenok\Core\Model\System\Setting::where('code', 'app.acl.enabled')
                    ->update(['value' => 0]);
            
            (new \App\Telenok\Core\Model\Object\Type())->storeOrUpdate(
                    [
                        'title' => ['ru' => "Новость", 'en' => "News"], 
                        'title_list' => ['ru' => "Новость", 'en' => "News"],
						'code' => 'news',
						'active' => 1,
						'class_model' => '\App\Telenok\News\Model\News',
						'class_controller' => '\App\Telenok\News\Module\News\Controller',
                    ]
            );
            
            (new \App\Telenok\Core\Model\Object\Type())->storeOrUpdate(
                    [
                        'title' => ['ru' => "Категория новости", 'en' => "News category"], 
                        'title_list' => ['ru' => "Категория новости", 'en' => "News category"],
						'code' => 'news_category',
						'active' => 1,
						'class_model' => '\App\Telenok\News\Model\NewsCategory',
						'class_controller' => '\App\Telenok\News\Module\NewsCategory\Controller',
                    ]
            );
        }
        finally
        {
            // On permission validator
            \App\Telenok\Core\Model\System\Setting::where('code', 'app.acl.enabled')
                    ->update(['value' => 1]);
        }
    }
}
