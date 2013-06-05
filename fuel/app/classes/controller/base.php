<?php
/**
 * Klase, kas ir bāze visām citām klasēm (globalizē mainīgos utml.)
 *
 * Autors: Dana Kukaine
 * Izveidots: 4.03.2013.
 * Pēdējo reizi mainīts: 01.06.2013.
 */
class Controller_Base extends Controller_Template {

    protected $_settings;

    /**
     * Funkcija tiek izpildīta pirms visām citām funkcijām, kas iekļautas šajā klasē
     * mērķis ir globalizēt datus, kas nepieciešami viscaur lapai
     */
    public function before()
	{
		parent::before();

		// Piesaista esošo lietotāju mainīgajam, lai citas klases/funkcijas to var izmantot
		$this->current_user = Auth::check() ? Model_User::find_by_username(Auth::get_screen_name()) : null;

		// Globalizē esošā lietotāja mainīgo, lai to var izmantot skatos
		View::set_global('current_user', $this->current_user);

        // Saglabā iesatījumus
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

        //Globalizē iestatījumus gan skatiem, gan citiem "controllers"
        $this->_settings = $settings;
        View::set_global('settings', $settings);

        //Iestat valodu, ko izmantos visos "controllers" un failu ar izmantotajām frāzēm viscaur lapai.
        Config::set('language', $this->_settings['language']->value);
        Lang::load('app_phrases');

	}

}