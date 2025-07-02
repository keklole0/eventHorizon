<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
use App\Models\User;
use App\Models\Category;
use App\Models\Tag;
use App\Models\Address;
use App\Models\Event;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        $faker = Faker::create('ru_RU');

        // Отключаем проверку внешних ключей
        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        // Очищаем таблицы в правильном порядке (сначала зависимые)
        DB::table('event_tag')->truncate();
        DB::table('participations')->truncate();
        DB::table('reviews')->truncate();
        DB::table('comments')->truncate();
        DB::table('events')->truncate();
        DB::table('addresses')->truncate();
        DB::table('tags')->truncate();
        DB::table('categories')->truncate();
        DB::table('users')->truncate();

        // Включаем проверку внешних ключей
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        // Создаем пользователей
        for ($i = 0; $i < 20; $i++) {
            $firstName = $faker->firstName;
            $lastName = $faker->lastName;
            
            DB::table('users')->insert([
                'username' => $faker->userName,
                'first_name' => $firstName,
                'last_name' => $lastName,
                'phone' => $faker->phoneNumber,
                'role' => $faker->randomElement(['user', 'admin']),
                'email' => $faker->unique()->safeEmail,
                'email_verified_at' => $faker->optional(0.7)->dateTimeThisYear(), // 70% пользователей с подтвержденной почтой
                'password' => bcrypt('password'),
                'remember_token' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Создаем категории
        $categories = [
            'Концерты', 'Выставки', 'Фестивали', 'Спорт', 'Театр',
            'Кино', 'Образование', 'Бизнес', 'Дети', 'Другое'
        ];
        foreach ($categories as $category) {
            DB::table('categories')->insert([
                'title' => $category,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Создаем теги
        $tags = [
            'Концерт', 'Выставка', 'Фестиваль', 'Спорт', 'Театр',
            'Кино', 'Образование', 'Бизнес', 'Дети', 'Бесплатно',
            'Платно', 'Онлайн', 'Офлайн', 'Мастер-класс', 'Лекция'
        ];
        foreach ($tags as $tag) {
            DB::table('tags')->insert([
                'title' => $tag,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Создаем адреса
        for ($i = 0; $i < 30; $i++) {
            DB::table('addresses')->insert([
                'title' => $faker->streetAddress,
                'city' => $faker->city,
                'street' => $faker->streetName,
                'house_number' => $faker->buildingNumber,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Создаем мероприятия
        for ($i = 0; $i < 50; $i++) {
            $dateStart = $faker->dateTimeBetween('now', '+1 year');
            $dateEnd = $faker->dateTimeBetween($dateStart, '+1 year');
            
            DB::table('events')->insert([
                'title' => $faker->sentence(3),
                'description' => $faker->paragraph(3),
                'age_limit' => $faker->numberBetween(0, 18),
                'date_start' => $dateStart,
                'date_end' => $dateEnd,
                'price' => $faker->numberBetween(0, 5000),
                'max_participants' => $faker->numberBetween(10, 100),
                'category_id' => $faker->numberBetween(1, 10),
                'address_id' => $faker->numberBetween(1, 30),
                'user_id' => $faker->numberBetween(1, 20),
                'preview_image' => 'events/event1.jpg',
                'main_image' => 'events/event1.jpg',
                'status' => $faker->randomElement(['active', 'completed', 'cancelled']),
                'views' => $faker->numberBetween(0, 1000),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Создаем связи мероприятий с тегами
        for ($i = 1; $i <= 50; $i++) {
            $tagCount = $faker->numberBetween(1, 5);
            $tagIds = $faker->randomElements(range(1, 15), $tagCount);
            
            foreach ($tagIds as $tagId) {
                DB::table('event_tag')->insert([
                    'event_id' => $i,
                    'tag_id' => $tagId,
                ]);
            }
        }

        // Создаем комментарии
        for ($i = 0; $i < 100; $i++) {
            DB::table('comments')->insert([
                'text' => $faker->paragraph,
                'user_id' => $faker->numberBetween(1, 20),
                'event_id' => $faker->numberBetween(1, 50),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Создаем отзывы
        for ($i = 0; $i < 50; $i++) {
            $reviewerId = $faker->numberBetween(1, 20);
            $userId = $faker->numberBetween(1, 20);
            // Убедимся, что reviewer_id и user_id не совпадают
            while ($reviewerId === $userId) {
                $userId = $faker->numberBetween(1, 20);
            }
            
            DB::table('reviews')->insert([
                'comment' => $faker->paragraph,
                'user_id' => $userId,
                'reviewer_id' => $reviewerId,
                'event_id' => $faker->numberBetween(1, 50),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Создаем участия
        for ($i = 0; $i < 100; $i++) {
            DB::table('participations')->insert([
                'user_id' => $faker->numberBetween(1, 20),
                'event_id' => $faker->numberBetween(1, 50),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
