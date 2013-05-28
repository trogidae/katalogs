<?php
class Controller_Homepage extends Controller_GlobalBase
{
    public function action_index()
    {
        $homeCategory = Model_Category::find($this->_settings->frontpage_category);
        $items = $homeCategory->items;
        $data['items'] = $items;
        $this->template->title = "Sākumlapa";
        $this->template->content = View::forge('homepage', $data);
    }
}
