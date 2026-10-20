@foreach ($p->education ?? [] as $e)
  <div class="item"><b>{{ $e['degree'] ?? '' }}</b><span>{{ $e['school'] ?? '' }}</span><em>{{ $e['years'] ?? '' }}</em></div>
@endforeach
