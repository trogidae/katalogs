<?php
/**
 * Klase, kas kontrolē sākuma lapas kategorijas
 *
 * Autors: Dana Kukaine
 * Pēdējo reizi mainīts: 01.06.2013.
 */
class Controller_Category extends Controller_GlobalBase
{
    /**
     * Index lapa kategorijām. Neeksistē, tiek pāradresēta uz sākumlapu
     */
    public function action_index()
    {
        Response::redirect("/homepage");
    }

    /**
     * Kategorijas skats
     *
     * @param string $slug - īsvārds pēc kura identificē kategoriju
     * @param int $page - lapas numurs, kura atrodas kategorijas skats
     */
    public function action_view($slug = null, $page = null)
    {
        if (!$slug) {
            Response::redirect("/homepage");
        }
        $category = Model_Category::find_by_slug($slug);
        $pagination = \Pagination::forge('pagination', array(
                            'pagination_url' => \Uri::base(false) . 'category/view/' . $slug,
                            'total_items' => Model_Item::query()->related('categories')
                                                ->where('categories.id', '=', $category->id)
                                                ->where('status', '=', 1)
                                                ->count(),
                            'per_page' => $this->_settings['items_per_page']->value,
                            'uri_segment' => 6,
                            'num_links' => 5,
                            'current_page' => $page,
                       ));
        $data['info'] = $category;
        $data['items'] = Model_Item::query()->related('categories')
                                ->where('categories.id', '=', $category->id)
                                ->where('status', '=', '1')
                                ->order_by('id', 'desc')
                                ->rows_offset($pagination->offset)
                                ->rows_limit($pagination->per_page)
                                ->get();

        //Izsauc skatu
        $this->template->title = $category->title;
        $this->template->content = View::forge('category/view', $data);
    }
}
