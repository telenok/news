<?php echo \Cache::remember(
        $controller->getCacheKey('content'), 
        $controller->getCacheTime(), 
        function() use ($news) { ?>

@foreach($news as $n)

    @if ($q = $n->newsShowInProductCategory)

    <?php

        $categoryShowIn = $q->first();

    ?>

    @foreach($n->image()->get() as $image)
        <a href="catalog/{!! $categoryShowIn->url_pattern !!}/news/{!! $n->url_pattern !!}">
            <img src="{!! $image->upload->downloadImageLink(
                    380, 630,
                    \App\Telenok\Core\Support\Image\Processing::TODO_RESIZE_PROPORTION) !!}" 
                    alt="{{ $image->translate('title') }}"
            />
        </a>
    @endforeach

    <a href="catalog/{!! $categoryShowIn->url_pattern !!}/news/{!! $n->url_pattern !!}">{{$n->translate('title')}}</a>

    @else
    
    {{$n->translate('title')}}
    
    @endif
    
@endforeach

<?php }); ?>