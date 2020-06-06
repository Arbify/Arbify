@extends('layout')

@section('content')
    <div class="container mt-5">
        <div class="list-group w-50 mx-auto">
            @forelse($values as $value)
                <div class="list-group-item">
                    <div class="d-flex align-items-center">
                        <h4 class="mb-0">{{ $value->author->username ?? 'Removed' }}</h4>
                        <small class="ml-auto">{{ $value->updated_at->format('d-m-Y H:i') }}</small>
                    </div>
                    <pre class="mb-0 mt-3 diff">{!! $diff->render($values[$loop->index + 1]->value ?? '', $value->value) !!}</pre>
                </div>
            @empty
            @endforelse
        </div>
    </div>
@endsection
