<?php

class Controller_Category extends Controller_GlobalBase
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
        $category = Model_Category::find_by_slug($slug);
        $data['info'] = $category;
        $this->template->title = $category->title;
        $this->template->content = View::forge('category/view', $data);
    }
}
