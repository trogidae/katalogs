<?php
class Controller_Admin_Messages extends Controller_Admin
{

	public function action_index()
	{
		$data['messages'] = Model_Message::find('all');
		$this->template->title = "Messages";
		$this->template->content = View::forge('admin\messages/index', $data);

	}

	public function action_view($id = null)
	{
		$data['message'] = Model_Message::find($id);

		$this->template->title = "Message";
		$this->template->content = View::forge('admin\messages/view', $data);

	}

	public function action_delete($id = null)
	{
		if ($message = Model_Message::find($id))
		{
			$message->delete();

			Session::set_flash('success', e('Deleted message #'.$id));
		}

		else
		{
			Session::set_flash('error', e('Could not delete message #'.$id));
		}

		Response::redirect('admin/messages');

	}

    public function action_selected()
    {
        if (Input::method() == 'POST') {
            if (Input::post('check')!="") {
                foreach (Input::post('check') as $id) {
                    if ($message = Model_Message::find($id))
                    {
                        $message->delete();

                        Session::set_flash('success', e('Deleted messages'));
                    }
                    else
                    {
                        Session::set_flash('error', e('Could not delete messages'));
                    }
                }
            }
            else {
                Session::set_flash('error', e('You have not selected anything.'));
            }
        }
        Response::redirect('admin/messages');
    }


}