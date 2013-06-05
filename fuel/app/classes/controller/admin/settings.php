<?php
/**
 * Klase, kas kontrolē administrācijas paneļa Iestatījumi sadaļu
 *
 * Autors: Dana Kukaine
 * Pēdējo reizi mainīts: 01.06.2013.
 */
class Controller_Admin_Settings extends Controller_Admin
{

    /**
     * Darbojas ar loģiku, kas parāda un izlabo "Iestatījumus"
     */
    public function action_index()
	{
        // Dabū visu iestatījumu vērtības no datubāzes, lai ar tiem var darboties
        $settings = array ( 'frontpage_category' => Model_Setting::find_by_name('frontpage_category'),
                                   'default_category' => Model_Setting::find_by_name('default_category'),
                                   'show_empty_cat' => Model_Setting::find_by_name('show_empty_cat'),
                                   'currency' => Model_Setting::find_by_name('currency'),
                                   'contact_page' => Model_Setting::find_by_name('contact_page'),
                                   'contact_email' => Model_Setting::find_by_name('contact_email'),
                                   'site_title' => Model_Setting::find_by_name('site_title'),
                                   'site_description' => Model_Setting::find_by_name('site_description'),
                                   'items_per_page' => Model_Setting::find_by_name('items_per_page'),
                                   'language' => Model_Setting::find_by_name('language'),
        );

        //Izveido validācijas noteikumus, lai dato saglabātos pareizajās formās un nerastos kļūdas
        $val = Validation::forge();
        $val->add('currency', Lang::get('Currency'))->add_rule('required');
        $val->add('contact_email', Lang::get('Contact e-mail'))
            ->add_rule('required')
            ->add_rule('valid_email')
            ->add_rule('max_length[255]');
        $val->add('site_title', Lang::get('Site title'))
            ->add_rule('required')
            ->add_rule('max_length[255]');
        $val->add('site_description', Lang::get('Site description'))
            ->add_rule('required')
            ->add_rule('max_length[255]');

        if ($val->run())
        {
            //Jaunās vērtības tiek ievietotas
            $settings['frontpage_category']->value = Input::post('frontpage_category');
            $settings['default_category']->value = Input::post('default_category');
            $settings['show_empty_cat']->value = Input::post('show_empty_cat');
            $settings['currency']->value = Input::post('currency');
            $settings['contact_page']->value = Input::post('contact_page');
            $settings['contact_email']->value = Input::post('contact_email');
            $settings['site_title']->value = Input::post('site_title');
            $settings['site_description']->value = Input::post('site_description');
            $settings['items_per_page']->value = Input::post('items_per_page');
            $settings['language']->value = Input::post('language');

            $error=0;
            foreach ($settings as $setting) {
                if ($setting->save()) continue;
                else { $error=1; break; }
            }

            if ($error) {
                Session::set_flash('error', e(Lang::get('Could not update settings')));
            }
            else {
                Session::set_flash('success', e(Lang::get('Updated settings')));
                Response::redirect('admin/settings');
            }

        }

        else
        {
            if (Input::method() == 'POST')
            {
                Session::set_flash('error', $val->error());
            }

        }

        // Atrod visas pieejamās valodas, lai varētu tās parādīt "Iestatījumu" lapā
        $languages = array();
        $finder=Finder::instance('languages');
        $finder->remove_path(COREPATH);
        $paths=$finder->list_files('lang', '*');
        $finder->add_path(COREPATH);
        foreach ($paths as $path) {
            $temp = explode(DIRECTORY_SEPARATOR, $path);
            $languages[] = $temp[7];
        }
        $temp = array();
        foreach ($languages as $language) {
            $temp += array ($language => Lang::get($language));
        }
        $languages = $temp;

        // Saliek visus publicējamos datus un izsauc iestatījumu skatu
        $data['data']['languages'] = $languages;
		$data['data']['settings'] = $settings;
        $data['data']['categories'] = Model_Category::find('all');
        $data['data']['pages'] = Model_Page::find('all');
		$this->template->title = Lang::get("Settings");
		$this->template->content = View::forge('admin\settings/index', $data);
	}

}