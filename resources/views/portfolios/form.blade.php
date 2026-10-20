@extends('layouts.app')
@section('title', $portfolio ? 'Edit portfolio' : 'Create portfolio')
@section('content')
@php
  $photo = old('photo_data', $portfolio->photo_url ?? '');
  $skillsVal = old('skills', $portfolio ? implode(', ', $portfolio->skills ?? []) : '');
  $init = [];
  foreach (['education', 'projects', 'experience', 'links'] as $g) {
      $init[$g] = array_values((array) old($g, $portfolio->$g ?? []));
  }
@endphp
  <section class="wrap">
    <h1>{{ $portfolio ? 'Edit portfolio' : 'Create portfolio' }}</h1>
    <p class="sub">Fill in what you want to show. Only your name is required.</p>

    @if ($errors->any())
      <div class="alert">
        Please fix these problems:
        <ul>@foreach ($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
      </div>
    @endif

    <form id="f" method="POST" action="{{ $portfolio ? route('portfolios.update', $portfolio) : route('portfolios.store') }}">
      @csrf
      @if ($portfolio) @method('PUT') @endif

      <h3>Personal information</h3>
      <div class="pic">
        <img id="pv" class="ph" src="{{ $photo }}" @if (!$photo) hidden @endif alt="Profile preview">
        <div>
          <label for="photo">Profile picture</label>
          <input type="file" id="photo" accept="image/*">
          <input type="hidden" name="photo_data" id="photo_data" value="{{ $photo }}">
        </div>
      </div>

      <label for="full_name">Full name</label>
      <input id="full_name" name="full_name" required value="{{ old('full_name', $portfolio->full_name ?? '') }}">

      <div class="two">
        <div><label for="email">Email</label><input type="email" id="email" name="email" value="{{ old('email', $portfolio->email ?? '') }}"></div>
        <div><label for="phone">Contact number</label><input id="phone" name="phone" value="{{ old('phone', $portfolio->phone ?? '') }}"></div>
      </div>

      <label for="address">Address</label>
      <input id="address" name="address" value="{{ old('address', $portfolio->address ?? '') }}">

      <label for="about">About me</label>
      <textarea id="about" name="about" rows="4">{{ old('about', $portfolio->about ?? '') }}</textarea>

      <label for="skills">Skills (separate with commas)</label>
      <input id="skills" name="skills" value="{{ $skillsVal }}">

      <h3>Educational background</h3>
      <div id="g-education"></div>
      <button type="button" class="btn ghost sm" data-add="education">Add another</button>

      <h3>Projects</h3>
      <div id="g-projects"></div>
      <button type="button" class="btn ghost sm" data-add="projects">Add another</button>

      <h3>Work experience</h3>
      <div id="g-experience"></div>
      <button type="button" class="btn ghost sm" data-add="experience">Add another</button>

      <h3>Social media and website links</h3>
      <div id="g-links"></div>
      <button type="button" class="btn ghost sm" data-add="links">Add another</button>

      <div class="end">
        <a class="btn ghost" href="{{ route('portfolios.index') }}">Cancel</a>
        <button class="btn">Save and choose template</button>
      </div>
    </form>
  </section>

  <script>
    var G = {
      education: [["school", "School"], ["degree", "Degree or course"], ["years", "Years"]],
      projects: [["title", "Project title"], ["description", "Short description"], ["link", "Link (optional)"]],
      experience: [["role", "Role"], ["company", "Company"], ["years", "Years"], ["description", "What you did"]],
      links: [["label", "Label (e.g. GitHub)"], ["url", "URL"]]
    };
    var INIT = @json($init);
    var counts = {};
    function esc(s) {
      return String(s == null ? "" : s).replace(/[&<>"']/g, function (c) {
        return { "&": "&amp;", "<": "&lt;", ">": "&gt;", '"': "&quot;", "'": "&#39;" }[c];
      });
    }
    function row(g, v) {
      v = v || {};
      counts[g] = (counts[g] === undefined ? -1 : counts[g]) + 1;
      var i = counts[g];
      var inputs = G[g].map(function (f) {
        return '<input name="' + g + '[' + i + '][' + f[0] + ']" placeholder="' + f[1] + '" aria-label="' + f[1] + '" value="' + esc(v[f[0]]) + '">';
      }).join("");
      return '<div class="row">' + inputs + '<button type="button" class="x" aria-label="Remove" onclick="this.parentElement.remove()">&times;</button></div>';
    }
    Object.keys(G).forEach(function (g) {
      var items = (INIT[g] && INIT[g].length) ? INIT[g] : [{}];
      document.getElementById("g-" + g).innerHTML = items.map(function (v) { return row(g, v); }).join("");
    });
    document.querySelectorAll("[data-add]").forEach(function (b) {
      b.onclick = function () {
        document.getElementById("g-" + b.dataset.add).insertAdjacentHTML("beforeend", row(b.dataset.add));
      };
    });

    // Shrink the chosen picture in the browser, then keep it in a hidden field
    document.getElementById("photo").onchange = function (e) {
      var file = e.target.files[0];
      if (!file) return;
      var img = new Image();
      img.onload = function () {
        var s = Math.min(1, 320 / Math.max(img.width, img.height));
        var c = document.createElement("canvas");
        c.width = Math.round(img.width * s);
        c.height = Math.round(img.height * s);
        c.getContext("2d").drawImage(img, 0, 0, c.width, c.height);
        var data = c.toDataURL("image/jpeg", 0.8);
        document.getElementById("photo_data").value = data;
        var pv = document.getElementById("pv");
        pv.src = data;
        pv.hidden = false;
        URL.revokeObjectURL(img.src);
      };
      img.src = URL.createObjectURL(file);
    };
  </script>
@endsection
