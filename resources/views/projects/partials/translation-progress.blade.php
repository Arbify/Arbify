<span class="@if($statistics['percent'] == 100) text-success @elseif($statistics['percent'] == 0) text-danger @else text-info @endif">
    {{ $statistics['translated'] }}/{{ $statistics['all'] }}
    ({{ $statistics['percent'] }}%)
</span>
