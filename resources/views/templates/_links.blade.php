@foreach ($p->links ?? [] as $l)
  @if (!empty($l['url']))
    <a class="lnk" href="{{ \App\Models\Portfolio::safeUrl($l['url']) }}" target="_blank" rel="noopener">{{ !empty($l['label']) ? $l['label'] : $l['url'] }}</a>
  @endif
@endforeach
