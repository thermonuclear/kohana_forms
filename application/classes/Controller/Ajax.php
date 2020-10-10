<?php


class Controller_Ajax extends Controller
{
    public function before()
    {
        // if (!$this->request->is_ajax())
        // {
        //     $this->redirect('/');
        // }
        $this->response->headers('Content-Type', 'application/json; charset=utf-8');
    }

    /**
     * список новостей с главной страницы http://meduza.io
     */
    public function action_content()
    {
        $cache = Cache::instance();
        $news = $cache->get('meduza_news');
        if ($news) {
            $news = json_decode($news, true);
        } else {
            $news = (new Service_Meduza())->getNews();
            $cache->set('meduza_news', json_encode($news));
        }

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

        $this->response->body(json_encode($result));
    }

    public function action_registration()
    {
        $data = json_decode($this->request->body(), true);
        $validation = (new Validation_Ajax())->registrationValidate($data);

        if ($validation->check()) {
            Model::factory('User')->registerUser($data);
            $this->response->body(json_encode(['success' => 1]));
        } else {
            $errors = [];
            foreach ($validation->errors() as $k => $v) {
                $errors[] = $v[0];
            }

            $this->response->body(json_encode(['errors' => $errors, 'success' => 0]));
        }
    }

    public function action_login()
    {
        $data = json_decode($this->request->body(), true);
        $success = Auth::instance()->login($data['login'], $data['password']);

        $this->response->body(json_encode(['success' => $success]));
    }

    public function action_logout()
    {
        $success = Auth::instance()->logout();

        $this->response->body(json_encode(['success' => $success]));
    }

    public function action_forgot()
    {
        $data = json_decode($this->request->body(), true);
        $email = Model::factory('User')->getEmailByLogin($data['login']);

        if ($email) {
            $hash = hash_hmac('sha256', 'восстановление забытого пароля'.time(), '_se*c@r$et9'.time());
            $link = URL::base('http').'verify/changepassword/'.$hash;
            Model::factory('User')->setVerifyLink($hash, $data['login']);
            //     $config = Kohana::$config->load('email');
            //     Email::connect($config);
            //
            //     $to = $email;
            //     $subject = 'Восстановление пароля';
            //     $from = 'kohanaframework@test.ru';
            //     $message = 'Пройдите по ссылке для подтверждения смены пароля ' . $link;
            //
            //     Email::send($to, $from, $subject, $message, $html = false);
        }

        $this->response->body(json_encode(['link' => $link ?? '']));
    }

    public function action_exchangerate()
    {
        $data = json_decode($this->request->body(), true);
        $cache = Cache::instance();
        $rate = $cache->get('exchange_rate');
        if ($rate) {
            $rate = json_decode($rate, true);
        } else {
            $rate = (new Service_ExchangeRate())->getRate();
            $cache->set('exchange_rate', json_encode($rate));
        }

        $this->response->body(
            json_encode(
                [
                    'value' => $rate[$data['valute']]['Value'],
                ]
            )
        );
    }

    public function action_word()
    {
        $data = json_decode($this->request->body(), true);
        $success = Model::factory('Word')->saveWord($data['word']);

        $this->response->body(json_encode(['success' => $success]));
    }

    public function action_words()
    {
        $onPage = 3;
        $showPages = 5;
        $data = json_decode($this->request->body(), true);
        $numWords = Model::factory('Word')->countWords();
        $numPages = ceil($numWords / $onPage);

        $page = ($data['page'] ?? 1);
        $page = $page > $numPages ? $numPages : $page;
        $paginator = (new Service_Paginator())->getPaginator($page, $showPages, $numPages);

        $words = Model::factory('Word')->getPageWords($page, $onPage);

        $this->response->body(
            json_encode(
                [
                    'paginator' => $paginator['paginator'],
                    'prev' => $paginator['prev'],
                    'next' => $paginator['next'],
                    'words' => $words
                ]
            )
        );
    }

    public function action_wordstat()
    {
        $words = Model::factory('Word')->getWordstat();

        $this->response->body(json_encode(['wordstat' => $words]));
    }

}
