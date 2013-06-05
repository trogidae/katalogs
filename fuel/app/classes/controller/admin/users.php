<?php
/**
 * Klase, kas kontrolē administrācijas paneļa Lietotāji sadaļu
 *
 * Autors: Dana Kukaine
 * Izveidots: 4.03.2013.
 * Pēdējo reizi mainīts: 01.06.2013.
 */
class Controller_Admin_Users extends Controller_Admin
{
    /**
     * Darbojas ar loģiku, kas izveido un izsauc administrācijas paneļa sadaļas "Lietotāji" sākuma lapas skatu.
     *
     * @param int $page - lapas nurmurs, null pie pirmās lapas, pārējām ņem no URL 6. segmenta
     */
    public function action_index($page = null)
	{
        //Iestata iestatījumus sadalījumam lapās
        $pagination = \Pagination::forge('pagination', array(
                            'pagination_url' => \Uri::base(false) . 'admin/users/index',
                            'total_items' => Model_User::find()->count(),
                            'per_page' => 10,
                            'uri_segment' => 6,
                            'num_links' => 5,
                            'current_page' => $page,
                       ));
		$data['users'] = Model_User::find()
                                ->order_by('created_at', 'desc')
                                ->offset($pagination->offset)
                                ->limit($pagination->per_page)
                                ->get();

        //Izsauc sākuma lapas skatu
		$this->template->title = Lang::get("Users");
		$this->template->content = View::forge('admin\users/index', $data);

	}

    /**
     * Darbojas ar loģiku, kas parāda informāciju par lietotāju
     *
     * @param int $id - identifikācijas numurs lietotājam, kurš tiek skatīts
     */
    public function action_view($id = null)
	{
        // Ja id nav ievadīts, tad pārsūta uz "Lietotāji" sākuma sadaļu
		is_null($id) and Response::redirect('admin/Users');

		if ( ! $data['user'] = Model_User::find($id))
		{
			Session::set_flash('error', Lang::get('Could not find user #').$id);
			Response::redirect('Users');
		}

        //Ja tomēr parole un pieteikšanās šifrs tiek atsūtīti, tad tie tiek nonuļļoti, drošības pēc
        $data['user']->password = null;
        $data['user']->login_hash = null;

        //Grupu numuru atšifrējums
        if ($data['user']->group==100) $data['user']->group = Lang::get('Administrator');
        else if ($data['user']->group==50) $data['user']->group = Lang::get('Moderator');
        else if ($data['user']->group==-1) $data['user']->group = Lang::get('Banned');

        //Atšifrē laiku
        $data['user']->last_login = Date::forge($data['user']->last_login)->set_timezone('Europe/Riga')->format("%d.%m.%Y %H:%M");

        //Izsauc skatu
        $this->template->title = Lang::get("User");
		$this->template->content = View::forge('admin\users/view', $data);

	}

    /**
     * Darbojas ar loģiku, kas izveido jaunu lietotāju un izsauc jauna lietotāja izveides skatu
     */
    public function action_create()
	{
        //Pārbauda vai konkrētajam lietotājam ir atļauja izveidot lietotājus
        if (!Auth::has_access('users.write')) {
            Response::redirect('admin/users');
        }
        if (Input::method() == 'POST')
        {
            $val = Model_User::validate('register');
            $val->add('password-repeat', Lang::get('password-repeat'))->add_rule('required')
                ->add_rule('match_field', 'password');
            if ($val->run())
            {
                try {
                    Auth::create_user(Input::post('username'), Input::post('password'),Input::post('email'), Input::post('group'), array());
                    Session::set_flash('success', Lang::get('User created'));
                    //atpakaļ uz sākuma lapu
                    Response::redirect('admin/users');
                }
                catch (Auth\SimpleUserUpdateException $e) {
                    Session::set_flash('error', Lang::Get('Could not create usr'));
                }
            }
            else
            {
                Session::set_flash('error', $val->error());
            }
        }

        //Izsauc skatu
		$this->template->title = Lang::get("Users");
		$this->template->content = View::forge('admin/users/create');
	}

    /**
     * Izlabo lietotāju, kura id ir $id.
     *
     * @param int $id - identifikācijas numurs lietotājam, kas jālabo
     */
    public function action_edit($id = null)
	{
        //Pārbauda, vai lietotājam ir atļauja labot lietotājus
        if (!Auth::has_access('users.write')) {
            Response::redirect('admin/users');
        }
		if ( ! $user = Model_User::find($id))
		{
			Session::set_flash('error', Lang::get('Could not find user #').$id);
			Response::redirect('admin\Users');
		}

        //Pievieno validācijas nosacījumus
		$val = Validation::forge();
        $val->add_field('email', Lang::get('Email'), 'required')
            ->add_rule('valid_email');
        $val->add_field('group', Lang::get('Group'), 'required');

		if ($val->run())
		{
			$username = Input::post('username');
			$group = Input::post('group');
			$email = Input::post('email');

			if (Auth::update_user(array('group'=>$group, 'email'=>$email), $username))
			{
				Session::set_flash('success', Lang::get('Updated user #') . $id);

				Response::redirect('admin/users');
			}

			else
			{
				Session::set_flash('error', Lang::get('Could not update usr') . $id);
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
            //Lietotāja dati tiek globalizēti, lai var aizpildīt ievades laukus ar esošajām vērtībām
			$this->template->set_global('user', $user, false);
		}

        //Izsauc skatu
		$this->template->title = Lang::get("Users");
		$this->template->content = View::forge('admin\users/edit');

	}

    /**
     * Izdzēš lietotāju ar identifikācijas numuru $id
     *
     * @param int $id - identifikācijas numurs lietotājam, ka jāizdzēš
     */
    public function action_delete($id = null)
	{
        //Pārbauda, vai lietotājam ir atļauja dzēst citu lietotāju
        if (!Auth::has_access('users.write')) {
            Response::redirect('admin/users');
        }
		if ($user = Model_User::find($id))
		{
			$user->delete();

			Session::set_flash('success', Lang::get('Deleted user #').$id);
		}

		else
		{
			Session::set_flash('error', Lang::get('Could not delete usr').$id);
		}

		Response::redirect('admin/users');

	}

    /**
     * Darbojas ar loģiku, kas izmaina ielogojušā lietotāja profilu
     */
    public function action_profile()
    {
        $user = $this->current_user;
        //Izveido validācijas noteikumus, lai iesniedzot formu nerastos kļūdas
        $val = Validation::forge();
        $val->add_field('email', Lang::get('Email'), 'required')
            ->add_rule('valid_email');
        if (Input::post('change_password')=='yes'){
            $val->add_field('old_password', Lang::get('Old password'), 'required');
            $val->add_field('new_password', Lang::get('New password'), 'required|max_length[255]|min_length[6]');
            $val->add('new_password_repeat', Lang::get('New password (repeat)'))->add_rule('required')
                ->add_rule('match_field', 'new_password');
        }

        if ($val->run())
        {
            $email = Input::post('email');

            // Ja tiek mainīta arī parole, tad izpildās citi noteikumi
            if (Input::post('change_password')){
                try {
                    Auth::update_user(array('email'=>$email,'password'=>Input::post('new_password'), 'old_password'=>Input::post('old_password')), $user->username);
                    Session::set_flash('success', Lang::get('Updated profile'));
                    Response::redirect('admin/users');
                }
                catch (Auth\SimpleUserWrongPassword $e) {
                    Session::set_flash('error', Lang::get('Could not update prf'));
                }
            }
            else {
                if (Auth::update_user(array('email'=>$email), $user->username))
                {
                    Session::set_flash('success', Lang::get('Updated profile'));

                    Response::redirect('admin/users');
                }
                else
                {
                    Session::set_flash('error', Lang::get('Could not update prf'));
                }
            }
        }

        else
        {
            if (Input::method() == 'POST')
            {
                $user->email = $val->validated('email');

                Session::set_flash('error', $val->error());
            }
            //Konkrētā lietotāja dati tiek globalizēti, lai iepriekš ievadīties lauki tiek automātiski aizpildīti
            $this->template->set_global('user', $user, false);
        }
        //Izsauc skatu
        $this->template->title = Lang::get('My Profile');
        $this->template->content = View::forge('admin/users/profile');
    }


}