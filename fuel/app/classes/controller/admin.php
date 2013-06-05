<?php
/**
 * Klase, kas kontrolē administrācijas paneli
 *
 * Autors: Dana Kukaine
 * Izveidots: 4.03.2013.
 * Pēdējo reizi mainīts: 01.06.2013.
 */
class Controller_Admin extends Controller_Base
{
	public $template = 'admin/template';

    /**
     * Funkcija, kas izpildās pirms citām funkcijām, kas pieder klasei Controller_Admin
     * pārbauda, vai lietotājam ir pieeja administracijas panelī
     */
    public function before()
	{
		parent::before();

		if (Request::active()->controller !== 'Controller_Admin' or ! in_array(Request::active()->action, array('login', 'logout')))
		{
            //Pārbauda vai lietotājam ir pieeja admin panelim
			if (Auth::check())
			{
				if ( ! Auth::member(100) && ! Auth::member(50) )
				{
					Session::set_flash('error', e(Lang::get('No access')));
					Response::redirect('/');
				}
			}
            //Ja nav pieeja, tad aizsūta atpakaļ uz pieteikšanās lapu
			else
			{
				Response::redirect('admin/login');
			}
		}
	}

    /**
     * Veido administrācijas paneļa pieteikšanās lapu, apstrādā ievadītos datus
     */
    public function action_login()
	{
		// Ja lietotājs jau ielogojies, tad pārsūta uz admin paneļa sākumlapu
		Auth::check() and Response::redirect('admin');

		$val = Validation::forge();

		if (Input::method() == 'POST')
		{
            //Izveido vaildācijas noteikumus
			$val->add('email', Lang::get('Email or Username'))
			    ->add_rule('required');
			$val->add('password', Lang::get('Password'))
			    ->add_rule('required');

			if ($val->run())
			{
				$auth = Auth::instance();

				// Pārbauda pieteikšanās datus
				if (Auth::check() or $auth->login(Input::post('email'), Input::post('password')))
				{
					// Ja pieteikšanās dati pareizi, tad lietotājs ir pieteicies sistēmā
					$current_user = Model_User::find_by_username(Auth::get_screen_name());
					Session::set_flash('success', e(Lang::get('Welcome, ').$current_user->username));
					Response::redirect('admin');
				}
				else
				{
                    Session::set_flash('error', e(Lang::get('Wrong log in')));
                    Response::redirect('admin/login');
				}
			}
            else {
                if (Input::method() == 'POST')
                {
                    Session::set_flash('error', $val->error());
                }
            }
		}
        //Izsauc skatu, ja dati netika iesūtīti
		$this->template->title = Lang::get('Log in');
		$this->template->content = View::forge('admin/login', false);
	}

	/**
	 * Atteikšanās funkcija
	 */
	public function action_logout()
	{
		Auth::logout();
		Response::redirect('admin');
	}

	/**
	 * Izveido un izsauc administrācijas paneļa sākuma lapu "Darbgalds"
	 */
	public function action_index()
	{
        $data['items'] = Model_Item::find('all', array('order_by' => array('created_at' => 'desc'), 'limit' => 5));
        $data['messages'] = Model_Message::find('all', array('order_by' => array('created_at' => 'desc'), 'limit' => 5));
		$this->template->title = Lang::get('Dashboard');
		$this->template->content = View::forge('admin/dashboard', $data);
	}

}
