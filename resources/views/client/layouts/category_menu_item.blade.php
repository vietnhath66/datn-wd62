@php
    $publishedChildren = $category->children->where('publish', 1);
@endphp

@if ($publishedChildren->isNotEmpty())
    <li class="has-dropdown">
        <a href="{{ route('client.product.index', ['category' => $category->id]) }}">
            {{ $category->name }}
            <i class="fa fa-angle-right"></i>
        </a>
        <ul class="sub-menu level{{ ($category->level ?? 1) + 1 }}">
            @foreach ($publishedChildren as $childCategory)
                @include('client.layouts.category_menu_item', ['category' => $childCategory])
            @endforeach
        </ul>
    </li>
@else
    <li>
        <a href="{{ route('client.product.index', ['category' => $category->id]) }}">
            {{ $category->name }}
        </a>
    </li>
@endif
