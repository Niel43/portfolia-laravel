<article class="t-modern">
  <div class="mhero">
    @include('templates._photo')
    <div>
      <h1>{{ $p->full_name }}</h1>
      <div class="meta">@include('templates._contact')</div>
      @if ($p->email)<a class="btn" href="mailto:{{ $p->email }}">Contact me</a>@endif
    </div>
  </div>
  <div class="mgrid">
    @if ($p->about)<div class="card wide"><h2>About me</h2><p>{{ $p->about }}</p></div>@endif
    @if ($p->skills)
      <div class="card"><h2>Skills</h2>@foreach ($p->skills as $s)<span class="tag">{{ $s }}</span>@endforeach</div>
    @endif
    @if ($p->education)<div class="card tl"><h2>Education</h2>@include('templates._edu')</div>@endif
    @if ($p->experience)<div class="card tl"><h2>Experience</h2>@include('templates._exp')</div>@endif
    @foreach ($p->projects ?? [] as $x)
      <div class="card">@include('templates._project', ['x' => $x])</div>
    @endforeach
    @if ($p->links)<div class="card wide"><h2>Find me online</h2>@include('templates._links')</div>@endif
  </div>
</article>
