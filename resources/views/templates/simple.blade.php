<article class="t-simple">
  <header>
    @include('templates._photo')
    <h1>{{ $p->full_name }}</h1>
    <div class="meta">@include('templates._contact')</div>
  </header>
  @if ($p->about)<section><h2>About</h2><p>{{ $p->about }}</p></section>@endif
  @if ($p->education)<section><h2>Education</h2>@include('templates._edu')</section>@endif
  @if ($p->experience)<section><h2>Experience</h2>@include('templates._exp')</section>@endif
  @if ($p->skills)<section><h2>Skills</h2><p>{{ implode(', ', $p->skills) }}</p></section>@endif
  @if ($p->projects)
    <section><h2>Projects</h2>
      @foreach ($p->projects as $x)@include('templates._project', ['x' => $x])@endforeach
    </section>
  @endif
  @if ($p->links)<section><h2>Links</h2>@include('templates._links')</section>@endif
</article>
