@foreach (array_filter([$p->email, $p->phone, $p->address]) as $c)<span>{{ $c }}</span>@endforeach
