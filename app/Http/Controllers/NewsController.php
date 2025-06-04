<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\News;
use Illuminate\Support\Facades\Storage;

class NewsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show']);
    }

    public function index()
    {
        $news = News::with('user')->latest()->get();
        // Добавляем отладочную информацию
        foreach ($news as $item) {
            \Log::info('News ID: ' . $item->id);
            \Log::info('News image path in DB: ' . $item->image);
            \Log::info('Full storage path: ' . storage_path('app/public/' . $item->image));
            \Log::info('Public path: ' . public_path('storage/' . $item->image));
            \Log::info('Asset path: ' . asset('storage/' . $item->image));
        }
        return view('news.index', compact('news'));
    }

    public function create()
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }
        return view('news.create');
    }

    public function store(Request $request)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if ($request->hasFile('image')) {
            // Сохраняем изображение в папку news
            $imagePath = $request->file('image')->store('news', 'public');
            
            // Логируем информацию о сохранении
            \Log::info('Saving image:');
            \Log::info('Original name: ' . $request->file('image')->getClientOriginalName());
            \Log::info('Stored path: ' . $imagePath);
            \Log::info('Full storage path: ' . storage_path('app/public/' . $imagePath));
            \Log::info('Public path: ' . public_path('storage/' . $imagePath));
            
            $validated['image'] = $imagePath;
        }

        $validated['user_id'] = auth()->id();

        $news = News::create($validated);
        
        // Логируем информацию о созданной новости
        \Log::info('Created news:');
        \Log::info('ID: ' . $news->id);
        \Log::info('Image path in DB: ' . $news->image);

        return redirect()->route('news.index')->with('success', 'Новость успешно создана');
    }

    public function show(News $news)
    {
        return view('news.show', compact('news'));
    }

    public function edit(News $news)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }
        return view('news.edit', compact('news'));
    }

    public function update(Request $request, News $news)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($news->image) {
                Storage::disk('public')->delete($news->image);
            }
            $imagePath = $request->file('image')->store('news', 'public');
            $validated['image'] = $imagePath;
        }

        $news->update($validated);

        return redirect()->route('news.show', $news)->with('success', 'Новость успешно обновлена');
    }

    public function destroy(News $news)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }
        if ($news->image) {
            Storage::disk('public')->delete($news->image);
        }
        
        $news->delete();

        return redirect()->route('news.index')->with('success', 'Новость успешно удалена');
    }
} 