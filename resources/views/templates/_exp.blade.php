@foreach ($p->experience ?? [] as $e)
  <div class="item"><b>{{ $e['role'] ?? '' }}</b><span>{{ $e['company'] ?? '' }}</span><em>{{ $e['years'] ?? '' }}</em><p>{{ $e['description'] ?? '' }}</p></div>
@endforeach
