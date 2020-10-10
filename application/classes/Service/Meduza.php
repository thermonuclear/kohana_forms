<?php

/**
 * service for work with https://meduza.io
 */
class Service_Meduza
{
    /**
     * get news from man page
     */
    public function getNews(): array
    {
        $url = 'https://meduza.io/api/w5/screens/news';

        $request = Request::factory($url);
        $response = gzdecode($request->execute());

        $fullNews = json_decode($response, true)['documents'];
        $news = [];
        foreach ($fullNews as $k => $v) {
            if (empty($v['title'])) {
                continue;
            }
            $news[$k] = [
                'title' => $v['title'],
                'second_title' => $v['second_title'] ?? '',
                'image' => ($v['image']['wh_405_270_url'] ?? '') ? 'https://meduza.io'.$v['image']['wh_405_270_url'] : '',
            ];
        }

        return $news;
    }

    /**
     * get cached news from man page
     */
    public function getCacheNews($lifetime = 3600): array
    {
        $cache = Cache::instance();
        $news = $cache->get('meduza_news');
        if ($news) {
            $news = json_decode($news, true);
        } else {
            $news = $this->getNews();
            $cache->set('meduza_news', json_encode($news), $lifetime);
        }

        return $news;
    }

    /**
     * get one randon news from man page
     */
    public function getOneRandomNews(array $news): array
    {
        $session = Session::instance('database');
        $showedNews = $session->get('showedNews', []);
        $notShowedNews = array_diff_key($news, $showedNews);

        if ($notShowedNews) {
            $newsKey = array_rand($notShowedNews);
            $result = $news[$newsKey];
            $showedNews[$newsKey] = 1;
            $session->set('showedNews', $showedNews);
        } else {
            $result = ['title' => '', 'second_title' => '', 'image' => ''];
            $session->set('showedNews', []);
        }

        return $result;
    }
}
