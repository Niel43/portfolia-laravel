<article class="t-creative">
  <aside>
    @include('templates._photo')
    <h1>{{ $p->full_name }}</h1>
    <div class="meta">@include('templates._contact')</div>
    <div class="alinks">@include('templates._links')</div>
  </aside>
  <div class="cmain">
    @if ($p->about)<section><h2>Hello</h2><p class="big">{{ $p->about }}</p></section>@endif
    @if ($p->skills)
      <section><h2>What I use</h2><div class="cloud">@foreach ($p->skills as $s)<span class="tag">{{ $s }}</span>@endforeach</div></section>
    @endif
    @if ($p->projects)
      <section><h2>Things I've built</h2>
        @foreach ($p->projects as $x)@include('templates._project', ['x' => $x])@endforeach
      </section>
    @endif
    @if ($p->experience)<section><h2>Experience</h2>@include('templates._exp')</section>@endif
    @if ($p->education)<section><h2>Education</h2>@include('templates._edu')</section>@endif
  </div>
</article>
