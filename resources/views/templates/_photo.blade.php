@if ($p->photo_url)
  <img class="ph" src="{{ $p->photo_url }}" alt="{{ $p->full_name }}">
@else
  <div class="ph ph0">{{ mb_strtoupper(mb_substr($p->full_name, 0, 1)) }}</div>
@endif
