<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Announcement;
use App\Models\Certificate;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create(['name' => 'Aj Hoge', 'email' => 'Aj.Hoge@gmail.com', 'password' => 'AjHoge123', 'category' => 'teacher']);
        User::create(['name' => 'Mosh', 'email' => 'Mosh@gmail.com', 'password' => 'Mosh123', 'category' => 'teacher']);
        User::create(['name' => 'Terence Tao', 'email' => 'TerenceTao@gmail.com', 'password' => 'TerenceTao123', 'category' => 'teacher']);
        User::create(['name' => 'Jhon', 'email' => 'Jhon@gmail.com', 'password' => 'Jonn123', 'category' => 'teacher']);


        Profile::create(['user_id' => 1, 'birth_date' => '1977-12-05', 'avatar_url' => 'avatars/1.jpg', 'state' => 'LA', 'bio' => 'One day i will become the strogest teacher .']);
        Profile::create(['user_id' => 2, 'birth_date' => '1988-05-15', 'avatar_url' => 'avatars/2.jpg', 'state' => 'Miami', 'bio' => 'the best teacher in computer science field .']);
        Profile::create(['user_id' => 3, 'birth_date' => '1999-08-12', 'avatar_url' => 'avatars/3.jpeg', 'state' => 'berlin', 'bio' => 'If you wanna learn algebra Iam here .']);
        Profile::create(['user_id' => 4, 'birth_date' => '1986-08-12', 'state' => 'helsinki', 'bio' => 'Iam doctor  .']);

        Certificate::create(['user_id' => 1, 'title' => 'english teacher', 'university' => 'unversity of Chicago', 'graduation_date' => '2000-07-23']);
        Certificate::create(['user_id' => 2, 'title' => 'Software Engineer', 'university' => 'unversity of Miami', 'graduation_date' => '2008-07-23']);
        Certificate::create(['user_id' => 3, 'title' => 'Mathematics', 'university' => 'unversity of Berlin', 'graduation_date' => '2015-07-23']);
        Certificate::create(['user_id' => 4, 'title' => 'Doctor', 'university' => 'unversity of helsinki', 'graduation_date' => '2009-07-23']);

        Announcement::create([
            'user_id' => 1,
            'title' => 'Introduction to English Literature',
            'description' => 'An introductory course on English literature.',
            'field' => 'english',
            'module' => 'ENG 101',
            'type' => 'online',
            'location' => 'Via google meet',
            'price' => 1300,
            'status' => 'opened',
            'student_count' => 28,
        ]);
        Announcement::create(
            [
                'user_id' => 2,
                'title' => 'Advanced Software Engineering',
                'description' => 'In-depth study of software engineering principles.',
                'field' => 'computer science',
                'module' => 'Front-end devlopement',
                'type' => 'offline',
                'location' => 'setif,rue123,library Room 202',
                'price' => 1500,
                'status' => 'opened',
                'student_count' => 25,
            ]
        );

        Announcement::create([

            'user_id' => 3,
            'title' => 'Algebra and Its Applications',
            'description' => 'Comprehensive course on algebra.',
            'field' => 'mathematics',
            'module' => 'MATH 101',
            'type' => 'online',
            'location' => 'Room 303',
            'price' => 1200,
            'status' => 'opened',
            'student_count' => 20,

        ]);
    }
}
