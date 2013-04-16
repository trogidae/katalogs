<?php

class Controller_Item extends Controller_GlobalBase
{
    public function action_index()
    {
        Response::redirect("/homepage");
    }

    public function action_view($slug = null)
    {
        if (!$slug) {
            Response::redirect("/homepage");
        }
        $item = Model_Item::find_by_slug($slug);
        $data['info'] = $item;
        $this->template->title = $item->title;
        $this->template->content = View::forge('item/view', $data, false);
    }
}