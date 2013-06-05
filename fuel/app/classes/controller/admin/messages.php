<?php
/**
 * Klase, kas kontrolē administrācijas paneļa Ziņas sadaļu
 *
 * Autors: Dana Kukaine
 * Pēdējo reizi mainīts: 01.06.2013.
 */
class Controller_Admin_Messages extends Controller_Admin
{
    /**
     * Darbojas ar loģiku, kas veido sākuma lapu administrācijas sadaļai "Ziņas", kā arī izsauc šo skatu
     *
     * @param int $page - lapas numurs, pirmajai lapa null, pārējām tiek ņemts no URL 6. segmenta
     */
    public function action_index($page = null)
	{
        $pagination = \Pagination::forge('pagination', array(
                            'pagination_url' => \Uri::base(false) . 'admin/messages/index',
                            'total_items' => Model_Message::find()->count(),
                            'per_page' => 10,
                            'uri_segment' => 6,
                            'num_links' => 5,
                            'current_page' => $page,
                       ));
		$data['messages'] = Model_Message::find()
                                ->order_by('created_at', 'desc')
                                ->offset($pagination->offset)
                                ->limit($pagination->per_page)
                                ->get();
		$this->template->title = Lang::get("Messages");
		$this->template->content = View::forge('admin\messages/index', $data);

	}

    /**
     * Darbojas ar loģiku, kas veido ziņas (ar id=$id) apskatīšanas skatu, kā arī izsauc šo skatu.
     *
     * @param int $id - ziņas identifikācijas numurs, kurš tiek skatīts
     */
    public function action_view($id = null)
	{
		$data['message'] = Model_Message::find($id);

		$this->template->title = Lang::get("Message");
		$this->template->content = View::forge('admin\messages/view', $data);

	}

    /**
     * Izdzēš ziņu ar identifikācijas numuru $id.
     *
     * @param int $id - ziņas identifikācijas numurs, kura jāizdzēš
     */
    public function action_delete($id = null)
	{
		if ($message = Model_Message::find($id))
		{
			$message->delete();

			Session::set_flash('success', e(Lang::get('Deleted message #').$id));
		}

		else
		{
			Session::set_flash('error', e(Lang::get('Could not delete msg').$id));
		}

		Response::redirect('admin/messages');

	}

    /**
     * Izdzēš ziņas, kuru identifikācijas numuri tika atsūtīti masīvā (atķeksēti formā)
     */
    public function action_selected()
    {
        if (Input::method() == 'POST') {
            if (Input::post('check')!="") {
                foreach (Input::post('check') as $id) {
                    if ($message = Model_Message::find($id))
                    {
                        $message->delete();

                        Session::set_flash('success', e(Lang::get('Deleted messages')));
                    }
                    else
                    {
                        Session::set_flash('error', e(Lang::get('Could not delete msgs')));
                    }
                }
            }
            else {
                Session::set_flash('error', e(Lang::get('You have not selected')));
            }
        }
        Response::redirect('admin/messages');
    }


}