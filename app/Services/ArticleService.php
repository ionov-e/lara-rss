<?php

namespace App\Services;

use App\Models\Article;
use SimplePie_Item;
use Vedmant\FeedReader\Facades\FeedReader;

class ArticleService
{
    const NUMBERS_OF_NEWS_TO_SAVE = 3;
    const RSS_FEED_URL = 'http://static.feed.rbc.ru/rbc/logical/footer/news.rss';

    /**
     * Проверяет наличие новостей и записывает в БД
     *
     * @return void
     */
    static function check(): void
    {
        $f = FeedReader::read(self::RSS_FEED_URL);
        /** @var SimplePie_Item $rssArticle */
        for ($i = 0; $i < self::NUMBERS_OF_NEWS_TO_SAVE; $i++) {
            $rssArticle = $f->get_items()[$i];
            $article = new Article();
            $article->title = $rssArticle->get_title();
            $article->url = $rssArticle->get_link();
            $article->short = $rssArticle->get_content();
            $dateToTimestamp = strtotime($rssArticle->get_date());
            $article->published_date = date("Y-m-d h:i:s", $dateToTimestamp);
            if ($rssArticle->get_author()) {
                $article->author = $rssArticle->get_author()->get_email();
            }
            if ($enclosure = $rssArticle->get_enclosure()) {
                if (in_array($enclosure->get_type(), ['image/jpeg', 'image/png'])) {
                    $article->image_path = $enclosure->get_link();
                }
            }
            $article->save();
        }
    }
}
