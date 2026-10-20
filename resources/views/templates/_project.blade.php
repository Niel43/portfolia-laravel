<div class="item pj">
  <b>{{ $x['title'] ?? '' }}</b>
  <p>{{ $x['description'] ?? '' }}</p>
  @if (!empty($x['link']))
    <a class="lnk" href="{{ \App\Models\Portfolio::safeUrl($x['link']) }}" target="_blank" rel="noopener">View project</a>
  @endif
</div>
