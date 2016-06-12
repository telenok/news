<?php

$controller->setCacheEnabled(false);

$controllerRequest->setPageMetaTitle($news->translate('title'));

?>

<?php echo \Cache::remember(
        $controller->getCacheKey('content'), 
        $controller->getCacheTime(), 
        function() use ($news) { ?>

{{$news->translate('title')}}

@foreach($news->image()->get() as $image)
    <img src="{!! $image->upload->downloadImageLink(
            380, 630,
            \App\Telenok\Core\Support\Image\Processing::TODO_RESIZE_PROPORTION) !!}" 
            title="{{ $image->translate('title') }}"
    />
@endforeach

<?php }); ?>