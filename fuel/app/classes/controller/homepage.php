<?php
/**
 * Klase, kas kontrolē sākuma lapu
 *
 * Autors: Dana Kukaine
 * Izveidots: 4.03.2013.
 * Pēdējo reizi mainīts: 01.06.2013.
 */
class Controller_Homepage extends Controller_GlobalBase
{
    /**
     * Izveido un izsauc sākuma lapu (homepage)
     *
     * @param int $page - lapas numurs, kurā atrodas sākuma lapa
     */
    public function action_index($page = null)
    {
        //Izmanto lietotāja iestatīto sākuma lapas kategoriju kā bāzi, no kuras ņemt preces
        $category = Model_Category::find($this->_settings['frontpage_category']->value);
        $pagination = \Pagination::forge('pagination', array(
                            'pagination_url' => \Uri::base(false) . 'homepage/index',
                            'total_items' => Model_Item::query()->related('categories')
                                ->where('categories.id', $category->id)
                                ->where('status', 1)
                                ->count(),
                            'per_page' => $this->_settings['items_per_page']->value,
                            'uri_segment' => 5,
                            'num_links' => 5,
                            'current_page' => $page,
                       ));
        //Pieprasa preces
        $data['items'] = Model_Item::query()->related('categories')
            ->where('categories.id', $category->id)
            ->where('status', 1)
            ->order_by('created_at', 'desc')
            ->rows_offset($pagination->offset)
            ->rows_limit($pagination->per_page)
            ->get();
        //Izsauc skatu
        $this->template->title = Lang::get("Homepage");
        $this->template->content = View::forge('homepage', $data);
    }
}
