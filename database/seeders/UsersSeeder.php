<?php
namespace Database\Seeders;

use App\Models\Category;
use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    use \Illuminate\Foundation\Testing\WithFaker;

    public function run()
    {
        $this->setUpFaker();

        $user = User::all();

        /** @var User $user */
        $user->each(function (User $user) {
            $categories = Category::all();
            $users = User::all()->random(rand(50, 100));

            $user->followMany($categories);
            $user->followMany($users);

            Post::all()->random(rand(50, 100))->each(function (Post $post) use ($user) {
                $comment = new Comment;
                $comment->comment = $this->faker->sentence(3);
                $comment->user()->associate($user);
                $post->comments()->save($comment);

                $post->views()->create([
                    'viewable_id' => $post->id,
                    'ip'          => $this->faker->ipv4,
                    'user_id'     => $user->id,
                    'count'       => 1
                ]);

                $user->addBookmark($post);

                $user->addLike($post);
            });

//            Comment::all()->random(500)->each(function (Comment $comment) use ($user) {
//                $user->addLike($comment);
//            });
        });
    }
}
