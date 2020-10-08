<?php


class Controller_Forms extends Controller_Template
{
    public function action_index()
    {
        $this->template->content = View::factory('forms', []);
    }
}
