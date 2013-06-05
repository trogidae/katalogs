<?php
/**
 * Bazes klase sākuma lapām
 *
 * Autors: Dana Kukaine
 * Pēdējo reizi mainīts: 01.06.2013.
 */
class Controller_GlobalBase extends Controller_Base {

    /**
     * Funkcija, kas izpildās pirms jebkuras citas funkcijas, kas pieder šai klasei
     * galvenais mērķis - globalizēt vajadzīgos datus - lapas, kategorijas, iestatījumus, logrīkus
     */
    public function before()
    {
        parent::before();
        //Atrod visas aktīvās lapas
        $pages = Model_Page::find('all');
        $activePages = array();
        foreach ($pages as $page) {
            if ($page->status) {
                $activePages[] = array ( "id" => $page->id,
                                         "title" => $page->title,
                                         "slug" => $page->slug);
            }
        }

        //Atrod visas kategorijas, kas ir aktīvas
        $categories = Model_Category::query()
                                ->where('status', 1)
                                ->get();
        //Izveido tādu masīvu, lai skatā ir vienkārši realizēt izkrītošo izvēlni
        $withChildren = array();
        foreach ($categories as $category) {
            if (isset($category->parent_id)) {
                if (isset($withChildren[$category->parent_id])) {
                    $withChildren[$category->parent_id] += array ($category->id => $category);
                }
                else {
                    $withChildren += array ($category->parent_id => array($category->id => $category));
                }
            }
        }
        View::set_global('pages', $activePages);
        View::set_global('categories', $categories);
        View::set_global('withChildren', $withChildren);

        //Logrīki
        $widgets['sidebar'] = Model_Widget::find('all', array(
                                             'where' => array(
                                                 array('type', 1),
                                             ),
                                             'order_by' => array('position' => 'asc'),
        ));
        $widgets['footer'] = Model_Widget::find('all', array(
                                            'where' => array(
                                                array('type', 2),
                                            ),
                                            'order_by' => array('position' => 'asc'),
        ));
        View::set_global('widgets', $widgets, false);
    }

}