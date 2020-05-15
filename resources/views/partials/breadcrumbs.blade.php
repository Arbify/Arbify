@if (count($breadcrumbs))
    <ol class="breadcrumb">
        @foreach($breadcrumbs as $breadcrumb)
            @if(!$loop->last)
                <li class="breadcrumb-item">
                    @if($breadcrumb->url)
                        <a href="{{ $breadcrumb->url }}">{{ $breadcrumb->title }}</a>
                    @else
                        {{ $breadcrumb->title }}
                    @endif
                </li>
            @else
                <li class="breadcrumb-item active">{{ $breadcrumb->title }}</li>
            @endif
        @endforeach
    </ol>
@endif
