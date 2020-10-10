<?php


class Controller_Verify extends Controller_Template
{
    public function action_changepassword()
    {
        $link = $this->request->param('id');

        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $pass = '';
        for ($i = 0; $i < 10; $i++) {
            $pass .= $characters[rand(0, $charactersLength - 1)];
        }

        $result = Model::factory('User')->setNewPassword(Auth::instance()->hash($pass), $link);

        $this->template->content = View::factory('changepassword', ['password' => $pass, 'result' => $result]);
    }
}
