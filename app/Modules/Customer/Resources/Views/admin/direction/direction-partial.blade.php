<ul>
    @foreach($directions as $direction)
        <li>
            <a href="{{ route('admin.direction.edit',[$direction->id]) }}" target="_blank">
                {{ $direction->title }}
            </a>
            @if(count($direction->childrenRecursive))
                @include('customer::admin.direction.direction-partial ',['directions' => $direction->childrenRecursive])
            @endif
        </li>
    @endforeach
</ul>
