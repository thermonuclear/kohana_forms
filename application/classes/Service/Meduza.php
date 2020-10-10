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
}
