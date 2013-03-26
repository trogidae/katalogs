<?php
class Controller_Homepage extends Controller_GlobalBase
{
    public function action_index()
    {
        $items = Model_Item::find('all', array( 'order_by' => array('created_at' => 'desc')));
        $data['items'] = $items;
        $this->template->title = "Sākumlapa";
        $this->template->content = View::forge('homepage', $data);
    }
}
