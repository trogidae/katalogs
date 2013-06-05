<?php
/**
 * Klase, kas kontrolē sākuma lapas preces
 *
 * Autors: Dana Kukaine
 * Pēdējo reizi mainīts: 01.06.2013.
 */
class Controller_Item extends Controller_GlobalBase
{
    /**
     * Index lapa precēm neeksistē. Tiek pāradresēta uz sākuma lapu
     */
    public function action_index()
    {
        Response::redirect("/homepage");
    }

    /**
     * Darbojas ar loģiku, kas izveidot un izsauc preces skatu.
     *
     * @param string $slug - īsvārds pēc kā identificēt preci.
     */
    public function action_view($slug = null)
    {
        if (!$slug) {
            Response::redirect("/homepage");
        }
        $item = Model_Item::find_by_slug($slug);
        $data['info'] = $item;

        //Pieprasa kontaktu lapu, lai varētu izveidot pogu "Pasūtīt" ar pareizo adresi
        $contact_page = Model_Page::find($this->_settings['contact_page']->value)->slug;
        $data['contact_page'] = $contact_page;

        //Izsauc skatu
        $this->template->title = $item->title;
        $this->template->content = View::forge('item/view', $data, false);
    }

    /**
     * Meklēšanas funkcija - meklē preces pēc lietotāja ievadītās frāzes
     */
    public function action_search()
    {
         if (Input::method() == 'POST'){
             $query = Input::post('search-query');
             //Ja meklejamā frāze ir īsāka par 3 simboliem, tiek izmests kļūdas paziņojums
             if (strlen($query)<3) {
                 Session::set_flash('error', e(Lang::get('Search query min')));
                 Response::redirect('/homepage');
             }
             //Meklē preci ar ievadīto frāzi
             $results = Model_Item::query()
                 ->where('status', 1)
                 ->and_where_open()
                     ->where('title', 'LIKE', '%' . $query .'%')
                     ->or_where('content', 'LIKE', '%' . $query .'%')
                     ->or_where('summary', 'LIKE', '%' . $query .'%')
                 ->and_where_close()
                 ->get();

             $data['items'] = $results;
             $data['title'] = Lang::get('Search results for ') . '"' . $query . '"';
             //Izsauc skatu
             $this->template->title = Lang::get('Search results for ') . '"' . $query . '"';
             $this->template->content = View::forge('item/search', $data, false);
         }
         //Ja dati netika iesūtīti, tad lapu pārsūta uz sākuma lapu
        else {
            Response::redirect('/homepage');
        }
    }
}