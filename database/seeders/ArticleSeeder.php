<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::where('email', 'test@example.com')->first();
        
        // Buat profile untuk user
        Profile::updateOrCreate(
            ['user_id' => $user->id],
            [
                'phone' => '081234567890',
                'bio' => 'Penulis artikel berita yang suka membaca dan menulis.',
            ]
        );

        // Buat artikel contoh
        Article::updateOrCreate(
            ['slug' => 'artikel-pertama'],
            [
                'user_id' => $user->id,
                'category_id' => 1,
                'title' => 'Artikel Pertama',
                'slug' => 'artikel-pertama',
                'content' => 'Ini adalah konten artikel pertama yang menarik untuk dibaca. Artikel ini berisi informasi penting yang bermanfaat bagi pembaca.',
                'image' => null,
            ]
        );

        Article::updateOrCreate(
            ['slug' => 'artikel-kedua'],
            [
                'user_id' => $user->id,
                'category_id' => 2,
                'title' => 'Artikel Kedua',
                'slug' => 'artikel-kedua',
                'content' => 'Konten artikel kedua yang tidak kalah menarik. Artikel ini membahas topik yang berbeda dengan artikel pertama.',
                'image' => null,
            ]
        );
    }
}
