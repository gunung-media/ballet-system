<nav aria-label="breadcrumb">
    <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
        @foreach ($stacks as $key => $stack)
            @if ($key === count($stacks) - 1)
                <li class="breadcrumb-item text-sm text-dark active" aria-current="page">
                    {{ $stack }}
                </li>
            @else
                <li class="breadcrumb-item text-sm">
                    <a class="opacity-5 text-dark" href="javascript:;">{{ $stack }}</a>
                </li>
            @endif
        @endforeach
    </ol>
    <h6 class="font-weight-bolder mb-0">{{ $lastItem }}</h6>
</nav>
