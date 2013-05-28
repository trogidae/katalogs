<?php

class Controller_GlobalBase extends Controller_Base {

    protected $_settings;

    public function before()
    {
        parent::before();
        //Find all active pages to show in the menu
        $pages = Model_Page::find('all');
        $activePages = array();
        foreach ($pages as $page) {
            if ($page->status) {
                $activePages[] = array ( "id" => $page->id,
                                         "title" => $page->title,
                                         "slug" => $page->slug);
            }
        }

        //Find all categories
        $categories = Model_Category::find('all');
        View::set_global('pages', $activePages);
        View::set_global('categories', $categories);

        //Settings
        $settings = Model_Setting::find(1);
        $this->_settings = $settings;
        View::set_global('settings', $settings);
    }

}