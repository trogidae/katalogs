<?php
/**
 * Klase, kas kontrolē kataloga lapas
 *
 * Autors: Dana Kukaine
 * Pēdējo reizi mainīts: 01.06.2013.
 */
class Controller_Page extends Controller_GlobalBase
{
    /**
     * Index lapa neeksistē, tiek pāradresēta uz sakuma lapu
     */
    public function action_index()
    {
        Response::redirect("/homepage");
    }

    /**
     * Izveido un izsauc lapas skatu
     *
     * @param string $slug - īsvārds pēc kā identificē lapu
     */
    public function action_view($slug = null)
    {
        if (!$slug) {
            Response::redirect("/homepage");
        }
        $page = Model_Page::find_by_slug($slug);
        $data['info'] = $page;
        //Izsauc skatu
        $this->template->title = $page->title;
        $this->template->content = View::forge('page/view', $data, false);
    }
}