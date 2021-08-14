<?php

use Illuminate\Database\Seeder;

class CategoriesSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Category::query()->insert([
            [
                'title'=> 'Игры',
                'slug'=> 'games',
                'description' => 'Сообщество, где мы публикуем новости и статьи о видеоиграх.',
                'icon' => 'https://leonardo.osnova.io/e5348320-b11a-9419-fb85-f7b63e2de194/-/scale_crop/108x108/center/',
                'is_public' => 1
            ],
            [
                'title'=> 'Индустрия',
                'slug'=> 'gameindustry',
                'description' => 'Новости и статьи для тех, кто хочет знать, как устроена игровая индустрия. Тут публикуются чарты, аналитика, финансовые отчёты, анонсы мероприятий и мнения известных персон, а также любые другие материалы, касающиеся стриминга, игрового бизнеса, пиара, платформ, проблем пиратства, экосистем и стратегических решений больших и маленьких компаний.',
                'icon' => 'https://leonardo.osnova.io/f488fca4-88d6-c978-d052-4d49a3a62a44/-/scale_crop/108x108/center/',
                'is_public' => 1
            ],
            [
                'title'=> 'Gamedev',
                'slug'=> 'gamedev',
                'description' => 'Разработка игр и всё, что с ней связано. Новости из сферы геймдева, включая анонсы и выход новых версий движков.',
                'icon' => 'https://leonardo.osnova.io/9e71f64c-f452-321b-e24b-901bd6b01757/-/scale_crop/108x108/center/',
                'is_public' => 1
            ],
            [
                'title'=> 'Кино и сериалы',
                'slug'=> 'cinema',
                'description' => 'Кино, сериалы и всё, что с ними связано. Включая скандалы в индустрии, так уж вышло.',
                'icon' => 'https://leonardo.osnova.io/5d198df0-3ba4-6837-b9c3-ac8c04fb9181/-/scale_crop/108x108/center/',
                'is_public' => 1
            ],
            [
                'title'=> 'Жизнь',
                'slug'=> 'life',
                'description' => 'Жизнь — это подсайт о том, что касается массовой культуры косвенно и не попадает в основную тематику DTF. Фото Кодзимы с друзьями, новости о том, как PlayStation спас кому-то жизнь, интервью Джонни Деппа, где он рассказывает, как страшно пил на съёмках, необычная рекламная кампания Pornhub или очередная интересная нейросеть. Всё это сюда.',
                'icon' => 'https://leonardo.osnova.io/8b2698a2-9f62-e5b8-d9bb-a4ea8e529059/-/scale_crop/108x108/center/',
                'is_public' => 1
            ],
            [
                'title'=> 'Почитать',
                'slug'=> 'read',
                'description' => 'Сообщество любителей книг и комиксов — DTF читающий собирается здесь. Место, где мы обсуждаем, что стоит почитать, а что не стоит.',
                'icon' => 'https://leonardo.osnova.io/0a4ffbce-37d2-0ad8-0326-5802e773262b/-/scale_crop/108x108/center/',
                'is_public' => 1
            ],
            [
                'title'=> 'Железо',
                'slug'=> 'hard',
                'description' => 'Вопросы, статьи, новости и обсуждения железа. Здесь можно обсуждать консоли, телевизоры, смартфоны, моддинг, а также спрашивать, на какую видеокарту стоит поменять свою почку.',
                'icon' => 'https://leonardo.osnova.io/2556f43c-9828-69ec-6072-931fe2417175/-/scale_crop/108x108/center/',
                'is_public' => 1
            ],
            [
                'title'=> 'Инди',
                'slug'=> 'indie',
                'description' => 'Истории из жизни инди-разработчиков. Если вы вдруг делаете свою игру, то это лучшее место, где о ней можно рассказать всему DTF.',
                'icon' => 'https://leonardo.osnova.io/044c3d8c-3200-4bdc-c4e3-40e99fec6777/-/scale_crop/108x108/center/',
                'is_public' => 1
            ],
            [
                'title'=> 'Видео и гифки',
                'slug'=> 'avi',
                'description' => 'Гифки и видео — наконец-то всё в одном месте. Это тот подсайт, куда можно постить ролики и гифки без длинных описаний.',
                'icon' => 'https://leonardo.osnova.io/fac10315-1c6f-4dd0-1f7c-8fdd394acdad/-/scale_crop/108x108/center/',
                'is_public' => 1
            ],
            [
                'title'=> 'Офтоп',
                'slug'=> 'flood',
                'description' => 'Здесь можно писать о чём угодно, что касается основных тематик DTF и соответствует интересам пользователей сайта, но по каким то причинам для этого сейчас нет подсайта.',
                'icon' => 'https://leonardo.osnova.io/097c16c9-4459-5f8d-9da6-ce8e76831f3e/-/scale_crop/108x108/center/',
                'is_public' => 1
            ],
            [
                'title'=> 'Подкасты',
                'slug'=> 'podcasts',
                'description' => 'При поддержке компании Pixonic собираем в одном месте лучшие подкасты про игры, кино и технологии.',
                'icon' => 'https://leonardo.osnova.io/5926fef6-af40-fa34-b5a8-676da7d70ab1/-/scale_crop/108x108/center/',
                'is_public' => 1
            ],
            [
                'title'=> 'Киберспорт',
                'slug'=> 'esport',
                'description' => 'Важные события из мира киберспорта, всё в одном месте.',
                'icon' => 'https://leonardo.osnova.io/91e8f437-76c2-ffc6-c494-87f2b1681ddf/-/scale_crop/108x108/center/',
                'is_public' => 1
            ],
            [
                'title'=> 'Аниме',
                'slug'=> 'anime',
                'description' => 'Аниме, манга и всё, что с этим связано. ᕕ( ᐛ )ᕗ Визуальные новеллы в аниме-стилистике тоже лучше сюда.',
                'icon' => 'https://leonardo.osnova.io/aa5053ce-9177-92ee-7f55-c6c0cdb6f2cd/-/scale_crop/108x108/center/',
                'is_public' => 1
            ],
            [
                'title'=> 'Вопросы',
                'slug'=> 'ask',
                'description' => 'Место, где вы можете задать вопрос всему DTF. И вам даже ответят! Возможно.',
                'icon' => 'https://leonardo.osnova.io/b5463920-7d83-df60-e73e-52d547bf5ae0/-/scale_crop/108x108/center/',
                'is_public' => 1
            ],
            [
                'title'=> 'Мемы',
                'slug'=> 'kek',
                'description' => 'Мемы на DTF. На тему игр и не только. ¯\_(ツ)_/¯',
                'icon' => 'https://leonardo.osnova.io/b52df651-017c-a716-e2ff-16080fdac6d0/-/scale_crop/108x108/center/',
                'is_public' => 1
            ],
            [
                'title'=> 'Наука',
                'slug'=> 'science',
                'description' => 'Научное сообщество на DTF. Доступно — о сложном. // Развернутые правила общения, связь с командой подсайта, гайдлайны - в нашем Дискорде https://discord.gg/4Wdbtzp',
                'icon' => 'https://leonardo.osnova.io/a72ef408-415d-bd32-7f4c-c9dcc92a21a4/-/scale_crop/108x108/center/',
                'is_public' => 1
            ],
            [
                'title'=> 'Музыка',
                'slug'=> 'music',
                'description' => 'Здесь мы собираем музыку, вопросы связанные с ней и различные истории о музыке. А еще — это отличное место поделиться вашими находками.',
                'icon' => 'https://leonardo.osnova.io/facf7f98-57a7-7d7f-b698-3d1477f3eea7/-/scale_crop/108x108/center/',
                'is_public' => 1
            ],
            [
                'title'=> 'Мобайл',
                'slug'=> 'mobile',
                'description' => 'Всё о мобильных играх, телефонах и софте.',
                'icon' => 'https://leonardo.osnova.io/0f0d1408-4641-6836-14e5-cfe9aa627df5/-/scale_crop/108x108/center/',
                'is_public' => 1
            ],
        ]);
    }
}
