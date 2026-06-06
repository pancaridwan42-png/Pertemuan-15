<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class ArticleController extends Controller
{
    public function index(Request $request): View
    {
        $query = Article::with(['category', 'user']);
        if ($request->has('search')) {
            $query->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('content', 'like', '%' . $request->search . '%');
        }
        $articles = $query->paginate(10);
        return view('admin.articles.index', compact('articles'));
    }

    public function create(): View
    {
        $categories = Category::all();
        return view('admin.articles.create', compact('categories'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'title' => [
                'required',
                'string',
                'min:10',
                'max:255',
                Rule::unique('articles'),
            ],
            'category_id' => 'required|exists:categories,id',
            'content' => 'required',
            'image' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:2048',
        ], [
            'title.required' => 'Judul artikel wajib diisi.',
            'title.min' => 'Judul artikel minimal 10 karakter.',
            'title.unique' => 'Judul artikel ini sudah ada.',
            'category_id.required' => 'Kategori wajib dipilih.',
            'content.required' => 'Konten artikel wajib diisi.',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('articles', 'public');
        }

        Article::create([
            'user_id' => auth()->id(),
            'category_id' => $request->category_id,
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'content' => $request->content,
            'image' => $imagePath,
        ]);

        return redirect()->route('articles.index')->with('success', 'Artikel berhasil ditambahkan!');
    }

    public function edit(Article $article): View
    {
        $categories = Category::all();
        return view('admin.articles.edit', compact('article', 'categories'));
    }

    public function update(Request $request, Article $article): RedirectResponse
    {
        $request->validate([
            'title' => [
                'required',
                'string',
                'min:10',
                'max:255',
                Rule::unique('articles')->ignore($article->id),
            ],
            'category_id' => 'required|exists:categories,id',
            'content' => 'required',
            'image' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:2048',
        ], [
            'title.required' => 'Judul artikel wajib diisi.',
            'title.min' => 'Judul artikel minimal 10 karakter.',
            'title.unique' => 'Judul artikel ini sudah ada.',
            'category_id.required' => 'Kategori wajib dipilih.',
            'content.required' => 'Konten artikel wajib diisi.',
        ]);

        $data = [
            'category_id' => $request->category_id,
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'content' => $request->content,
        ];

        if ($request->hasFile('image')) {
            if ($article->image) {
                Storage::disk('public')->delete($article->image);
            }
            $data['image'] = $request->file('image')->store('articles', 'public');
        }

        $article->update($data);

        return redirect()->route('articles.index')->with('success', 'Artikel berhasil diperbarui!');
    }

    public function destroy(Article $article): RedirectResponse
    {
        if ($article->image) {
            Storage::disk('public')->delete($article->image);
        }
        $article->delete();
        return redirect()->route('articles.index')->with('success', 'Artikel berhasil dihapus!');
    }
}
