<?php
class Controller_Admin_Users extends Controller_Admin
{
	public function action_index()
	{
		$data['users'] = Model_User::find('all');
		$this->template->title = "Users";
		$this->template->content = View::forge('admin\users/index', $data);

	}

	public function action_view($id = null)
	{
		is_null($id) and Response::redirect('admin\Users');

		if ( ! $data['user'] = Model_User::find($id))
		{
			Session::set_flash('error', 'Could not find user #'.$id);
			Response::redirect('Users');
		}
        $data['user']->password = null;
        $data['user']->login_hash = null;
        if ($data['user']->group==100) $data['user']->group = 'Administrator';
        else if ($data['user']->group==50) $data['user']->group = 'Moderator';
        else if ($data['user']->group==-1) $data['user']->group = 'Banned';
        $data['user']->last_login = Date::forge($data['user']->last_login)->set_timezone('Europe/Riga')->format("%d.%m.%Y %H:%M");
		$this->template->title = "User";
		$this->template->content = View::forge('admin\users/view', $data);

	}

	public function action_create()
	{
        if (!Auth::has_access('users.write')) {
            Response::redirect('admin/users');
        }
        if (Input::method() == 'POST')
        {
            $val = Model_User::validate('register');
            $val->add('password-repeat', 'password-repeat')->add_rule('required')
                ->add_rule('match_field', 'password');
            if ($val->run())
            {
                if (Auth::create_user(Input::post('username'), Input::post('password'),
                    Input::post('email'), Input::post('group') ))
                {
                    Session::set_flash('success', 'The user has been created.');
                    //go back to the homepage
                    Response::redirect('admin/users');
                }
                else
                {
                    Session::set_flash('error', 'Error');
                    //go back to the homepage
                    Response::redirect('admin/users');
                }
            }
            else
            {
                Session::set_flash('error', $val->error());
            }
        }
		$this->template->title = "Users";
		$this->template->content = View::forge('admin/users/create');
	}

	public function action_edit($id = null)
	{
        if (!Auth::has_access('users.write')) {
            Response::redirect('admin/users');
        }
		if ( ! $user = Model_User::find($id))
		{
			Session::set_flash('error', 'Could not find user #'.$id);
			Response::redirect('admin\Users');
		}

		$val = Validation::forge();
        $val->add_field('email', 'Email', 'required|valid_email');
        $val->add_field('group', 'Group', 'required');

		if ($val->run())
		{
			$username = Input::post('username');
			$group = Input::post('group');
			$email = Input::post('email');

			if (Auth::update_user(array('group'=>$group, 'email'=>$email), $username))
			{
				Session::set_flash('success', 'Updated user #' . $id);

				Response::redirect('admin/users');
			}

			else
			{
				Session::set_flash('error', 'Could not update user #' . $id);
			}
		}

		else
		{
			if (Input::method() == 'POST')
			{
				$user->username = $val->validated('username');
				$user->group = $val->validated('group');
				$user->email = $val->validated('email');

				Session::set_flash('error', $val->error());
			}

			$this->template->set_global('user', $user, false);
		}

		$this->template->title = "Users";
		$this->template->content = View::forge('admin\users/edit');

	}

	public function action_delete($id = null)
	{
        if (!Auth::has_access('users.write')) {
            Response::redirect('admin/users');
        }
		if ($user = Model_User::find($id))
		{
			$user->delete();

			Session::set_flash('success', 'Deleted user #'.$id);
		}

		else
		{
			Session::set_flash('error', 'Could not delete user #'.$id);
		}

		Response::redirect('admin\users');

	}


}