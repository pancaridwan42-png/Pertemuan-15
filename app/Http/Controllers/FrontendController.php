<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\View\View;

class FrontendController extends Controller
{
    public function show($slug): View
    {
        $article = Article::with(['category', 'tags', 'user', 'user.profile'])->where('slug', $slug)->firstOrFail();
        return view('frontend.show', compact('article'));
    }
}
