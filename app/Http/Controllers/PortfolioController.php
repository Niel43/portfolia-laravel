<?php

namespace App\Http\Controllers;

use App\Models\Portfolio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class PortfolioController extends Controller
{
    private const TEMPLATES = ['simple', 'modern', 'creative'];

    /** Users can only open their own portfolios. */
    private function own(Portfolio $portfolio): Portfolio
    {
        abort_unless($portfolio->user_id === Auth::id(), 403);
        return $portfolio;
    }

    /** Manage page: list, view, edit, delete. */
    public function index()
    {
        $portfolios = Portfolio::where('user_id', Auth::id())->latest()->get();
        return view('portfolios.index', compact('portfolios'));
    }

    public function create()
    {
        return view('portfolios.form', ['portfolio' => null]);
    }

    public function store(Request $request)
    {
        $portfolio = Portfolio::create($this->data($request) + [
            'user_id' => Auth::id(),
            'public_id' => Str::random(32),
        ]);

        return redirect()->route('portfolios.templates', $portfolio)
            ->with('status', 'Portfolio saved successfully! Choose a template to finish it.');
    }

    public function edit(Portfolio $portfolio)
    {
        return view('portfolios.form', ['portfolio' => $this->own($portfolio)]);
    }

    public function update(Request $request, Portfolio $portfolio)
    {
        $this->own($portfolio)->update($this->data($request));
        return redirect()->route('portfolios.templates', $portfolio)->with('status', 'Portfolio updated successfully.');
    }

    public function destroy(Portfolio $portfolio)
    {
        $this->own($portfolio)->delete();
        return redirect()->route('portfolios.index')->with('status', 'Portfolio deleted.');
    }

    public function templates(Portfolio $portfolio)
    {
        return view('portfolios.templates', ['portfolio' => $this->own($portfolio)]);
    }

    public function setTemplate(Request $request, Portfolio $portfolio)
    {
        $validated = $request->validate(['template' => 'required|in:' . implode(',', self::TEMPLATES)]);
        $this->own($portfolio)->update($validated);
        return redirect()->route('portfolios.preview', $portfolio)
            ->with('status', 'Your portfolio is ready to view and share.');
    }

    /** Private preview for the owner. */
    public function preview(Portfolio $portfolio)
    {
        $this->own($portfolio);
        $tpl = in_array($portfolio->template, self::TEMPLATES, true) ? $portfolio->template : 'simple';
        return view('portfolios.preview', compact('portfolio', 'tpl'));
    }

    /** Public read-only page identified by a random, unguessable ID. */
    public function publicView(string $publicId)
    {
        $portfolio = Portfolio::where('public_id', $publicId)->firstOrFail();
        $tpl = in_array($portfolio->template, self::TEMPLATES, true) ? $portfolio->template : 'simple';
        return view('portfolios.public', compact('portfolio', 'tpl'));
    }

    /** Validates the form and shapes it for the database. */
    private function data(Request $request): array
    {
        $v = $request->validate([
            'full_name' => 'required|string|max:120',
            'email' => 'nullable|email|max:150',
            'phone' => 'nullable|string|max:40',
            'address' => 'nullable|string|max:255',
            'about' => 'nullable|string|max:3000',
            'skills' => 'nullable|string|max:1000',
            'photo_data' => ['nullable', 'string', 'max:700000', function ($attr, $value, $fail) {
                if ($value && !preg_match('#^data:image/(jpeg|png|webp);base64,#', $value)) {
                    $fail('The profile picture is not a valid image.');
                }
            }],
            'education' => 'nullable|array',
            'projects' => 'nullable|array',
            'experience' => 'nullable|array',
            'links' => 'nullable|array',
        ]);

        return [
            'full_name' => $v['full_name'],
            'email' => $v['email'] ?? null,
            'phone' => $v['phone'] ?? null,
            'address' => $v['address'] ?? null,
            'about' => $v['about'] ?? null,
            'photo_url' => $v['photo_data'] ?? null,
            'skills' => collect(explode(',', $v['skills'] ?? ''))->map(fn ($s) => trim($s))->filter()->values()->all(),
            'education' => $this->rows($request->input('education'), ['school', 'degree', 'years']),
            'projects' => $this->rows($request->input('projects'), ['title', 'description', 'link']),
            'experience' => $this->rows($request->input('experience'), ['role', 'company', 'years', 'description']),
            'links' => $this->rows($request->input('links'), ['label', 'url']),
        ];
    }

    /** Keeps only the expected fields and drops empty rows. */
    private function rows($rows, array $keys): array
    {
        if (!is_array($rows)) return [];
        $out = [];
        foreach ($rows as $row) {
            if (!is_array($row)) continue;
            $clean = [];
            foreach ($keys as $k) {
                $val = $row[$k] ?? '';
                $clean[$k] = is_scalar($val) ? mb_substr(trim((string) $val), 0, 500) : '';
            }
            if (array_filter($clean)) $out[] = $clean;
        }
        return array_slice($out, 0, 20);
    }
}
