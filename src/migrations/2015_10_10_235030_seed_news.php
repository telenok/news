<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SeedNews extends Migration {

	public function up()
	{
        try
        {
            // Off permission validator
            \App\Vendor\Telenok\Core\Model\System\Setting::where('code', 'app.acl.enabled')
                    ->update(['value' => 0]);

            // Create Obkect Type News
            $typeNews = (new \App\Vendor\Telenok\Core\Model\Object\Type())->storeOrUpdate(
                    [
                        'title' => ['ru' => "Новость", 'en' => "News"], 
                        'title_list' => ['ru' => "Новость", 'en' => "News"],
						'code' => 'news',
						'active' => 1,
						'class_model' => '\App\Vendor\Telenok\News\Model\News',
						'class_controller' => '\App\Vendor\Telenok\News\Module\News\Controller',
                    ]
            );

            // Create Object Type NewsCategory
            $typeNewsCategory = (new \App\Vendor\Telenok\Core\Model\Object\Type())->storeOrUpdate(
                [
                    'title' => ['ru' => "Категория новости", 'en' => "News category"], 
                    'title_list' => ['ru' => "Категория новости", 'en' => "News category"],
                    'code' => 'news_category',
                    'active' => 1,
                    'treeable' => 1,
                    'multilanguage' => 1,
                    'class_model' => '\App\Vendor\Telenok\News\Model\NewsCategory',
                    'class_controller' => '\App\Vendor\Telenok\News\Module\NewsCategory\Controller',
                ]
            );

            // Folder News
            $folderNews = (new \App\Vendor\Telenok\Core\Model\System\Folder())->storeOrUpdate([
                'title' => ['en' => 'News', 'ru' => 'Новости'],
                'active' => 1,
                'code' => 'news',
            ])->makeRoot();

            // Move to folder
            $typeNews->makeLastChildOf($folderNews);
            $typeNewsCategory->makeLastChildOf($folderNews);

            
            // Type News
            (new \App\Vendor\Telenok\Core\Model\Object\Field())->storeOrUpdate([
                'title' => ['en' => 'Url', 'ru' => 'Url'],
                'title_list' => ['en' => 'Url', 'ru' => 'Url'],
                'key' => 'string',
                'code' => 'url_pattern',
                'active' => 1,
                'field_object_type' => 'news',
                'field_object_tab' => 'main',
                'multilanguage' => 0,
                'show_in_form' => 1,
                'show_in_list' => 1,
                'allow_search' => 1,
                'allow_create' => 1,
                'allow_update' => 1,
                'field_order' => 6,
                'string_unique' => 1,
            ]);

            (new \App\Vendor\Telenok\Core\Model\Object\Field())->storeOrUpdate([
                'title' => ['en' => 'Announcement', 'ru' => 'Анонс'],
                'title_list' => ['en' => 'Announcement', 'ru' => 'Анонс'],
                'key' => 'text',
                'code' => 'content_short',
                'active' => 1,
                'field_object_type' => 'news',
                'field_object_tab' => 'main',
                'multilanguage' => 0,
                'show_in_form' => 1,
                'show_in_list' => 1,
                'allow_search' => 1,
                'allow_create' => 1,
                'allow_update' => 1,
                'field_order' => 7,
                'text_rte' => 1,
            ]);

            (new \App\Vendor\Telenok\Core\Model\Object\Field())->storeOrUpdate([
                'title' => ['en' => 'Content', 'ru' => 'Содержание'],
                'title_list' => ['en' => 'Content', 'ru' => 'Содержание'],
                'key' => 'text',
                'code' => 'content',
                'active' => 1,
                'field_object_type' => 'news',
                'field_object_tab' => 'main',
                'multilanguage' => 0,
                'show_in_form' => 1,
                'show_in_list' => 1,
                'allow_search' => 1,
                'allow_create' => 1,
                'allow_update' => 1,
                'field_order' => 8,
                'text_rte' => 1,
            ]);

            (new \App\Vendor\Telenok\Core\Model\Object\Field())->storeOrUpdate([
                'title' => ['en' => 'Pictures', 'ru' => 'Изображения'],
                'title_list' => ['en' => 'Pictures', 'ru' => 'Изображения'],
                'key' => 'file-many-to-many',
                'code' => 'image',
                'active' => 1,
                'field_object_type' => 'news',
                'field_object_tab' => 'main',
                'multilanguage' => 0,
                'show_in_form' => 1,
                'show_in_list' => 1,
                'allow_search' => 0,
                'allow_create' => 1,
                'allow_update' => 1,
                'field_order' => 9,
            ]);

            try
            {
                (new \App\Vendor\Telenok\Core\Model\Object\Field())->storeOrUpdate([
                    'title' => ['en' => 'Language', 'ru' => 'Язык'],
                    'title_list' => ['en' => 'Language', 'ru' => 'Язык'],
                    'key' => 'relation-one-to-many',
                    'code' => 'news_language',
                    'active' => 1,
                    'field_object_type' => 'language',
                    'field_object_tab' => 'main',
                    'relation_one_to_many_has' => 'news',
                    'multilanguage' => 0,
                    'show_in_form' => 1,
                    'show_in_list' => 0,
                    'allow_search' => 1,
                    'allow_create' => 1,
                    'allow_update' => 1,
                    'field_order' => 8,
                ]);
            }
            catch (\Exception $e) {}

            
            // Type NewsCategory
            (new \App\Vendor\Telenok\Core\Model\Object\Field())->storeOrUpdate([
                'title' => ['en' => 'Description', 'ru' => 'Описание'],
                'title_list' => ['en' => 'Description', 'ru' => 'Описание'],
                'key' => 'text',
                'code' => 'description',
                'active' => 1,
                'field_object_type' => 'news_category',
                'field_object_tab' => 'main',
                'multilanguage' => 1,
                'show_in_form' => 1,
                'show_in_list' => 1,
                'allow_search' => 1,
                'allow_create' => 1,
                'allow_update' => 1,
                'field_order' => 8,
                'text_rte' => 1,
            ]);

            (new \App\Vendor\Telenok\Core\Model\Object\Field())->storeOrUpdate([
                'title' => ['en' => 'Url', 'ru' => 'Url'],
                'title_list' => ['en' => 'Url', 'ru' => 'Url'],
                'key' => 'string',
                'code' => 'url_pattern',
                'active' => 1,
                'field_object_type' => 'news_category',
                'field_object_tab' => 'main',
                'multilanguage' => 0,
                'show_in_form' => 1,
                'show_in_list' => 1,
                'allow_search' => 1,
                'allow_create' => 1,
                'allow_update' => 1,
                'field_order' => 9,
                'string_unique' => 1,
            ]);

            (new \App\Vendor\Telenok\Core\Model\Object\Field())->storeOrUpdate([
                'title' => ['en' => 'News', 'ru' => 'Новости'],
                'title_list' => ['en' => 'News', 'ru' => 'Новости'],
                'key' => 'relation-many-to-many',
                'code' => 'news',
                'active' => 1,
                'field_object_type' => 'news_category',
                'field_object_tab' => 'main',
                'relation_many_to_many_has' => 'news',
                'multilanguage' => 0,
                'show_in_form' => 1,
                'show_in_list' => 0,
                'allow_search' => 1,
                'allow_create' => 1,
                'allow_update' => 1,
                'field_order' => 10,
            ]);
            
            (new \App\Vendor\Telenok\Core\Model\Object\Field())->storeOrUpdate([
                'title' => ['en' => 'Category to show in', 'ru' => 'Показывать в категории'],
                'title_list' => ['en' => 'Category to show in', 'ru' => 'Показывать в категории'],
                'key' => 'relation-one-to-many',
                'code' => 'news_show_in',
                'active' => 1,
                'field_object_type' => 'news_category',
                'field_object_tab' => 'main',
                'relation_one_to_many_has' => 'news',
                'multilanguage' => 0,
                'show_in_form' => 1,
                'show_in_list' => 0,
                'allow_search' => 1,
                'allow_create' => 1,
                'allow_update' => 1,
                'field_order' => 11,
            ]);
            
            // Widget group
            (new \App\Vendor\Telenok\Core\Model\Web\WidgetGroup())->storeOrUpdate([
                'title' => ['en' => 'News', 'ru' => 'Новости'],
                'active' => 1,
                'controller_class' => '\App\Vendor\Telenok\News\WidgetGroup\News\Controller',
            ]);

            // Widget
            (new \App\Vendor\Telenok\Core\Model\Web\Widget())->storeOrUpdate([
                'title' => ['en' => 'Category', 'ru' => 'Категория'],
                'active' => 1,
                'controller_class' => '\App\Vendor\Telenok\News\Widget\NewsCategory\Controller',
            ]);

            (new \App\Vendor\Telenok\Core\Model\Web\Widget())->storeOrUpdate([
                'title' => ['en' => 'News', 'ru' => 'Новости'],
                'active' => 1,
                'controller_class' => '\App\Vendor\Telenok\News\Widget\News\Controller',
            ]);

            (new \App\Vendor\Telenok\Core\Model\Web\Widget())->storeOrUpdate([
                'title' => ['en' => 'News List', 'ru' => 'Список новостей'],
                'active' => 1,
                'controller_class' => '\App\Vendor\Telenok\News\Widget\NewsList\Controller',
            ]);
        }
        finally
        {
            // On permission validator
            \App\Vendor\Telenok\Core\Model\System\Setting::where('code', 'app.acl.enabled')
                    ->update(['value' => 1]);
        }
    }
}