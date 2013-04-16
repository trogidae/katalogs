<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Dana
 * Date: 13.24.3
 * Time: 20:38
 * To change this template use File | Settings | File Templates.
 */
class Controller_Page extends Controller_GlobalBase
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
        $page = Model_Page::find_by_slug($slug);
        $data['info'] = $page;
        $this->template->title = $page->title;
        $this->template->content = View::forge('page/view', $data, false);
    }
}