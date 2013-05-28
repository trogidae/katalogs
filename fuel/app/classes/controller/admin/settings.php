<?php
class Controller_Admin_Settings extends Controller_Admin
{

	public function action_index()
	{
        $id = 1;
        $setting = Model_Setting::find($id);
        $val = Model_Setting::validate('edit');

        if ($val->run())
        {
            $setting->frontpage_category = Input::post('frontpage_category');
            $setting->show_empty_cat = Input::post('show_empty_cat');
            $setting->currency = Input::post('currency');
            $setting->language = Input::post('language');
            $setting->contact_page = Input::post('contact_page');
            $setting->contact_email = Input::post('contact_email');

            if ($setting->save())
            {
                Session::set_flash('success', e('Updated settings'));

                Response::redirect('admin/settings');
            }

            else
            {
                Session::set_flash('error', e('Could not update settings'));
            }
        }

        else
        {
            if (Input::method() == 'POST')
            {
                $setting->frontpage_category = $val->validated('frontpage_category');
                $setting->show_empty_cat = $val->validated('show_empty_cat');
                $setting->currency = $val->validated('currency');
                $setting->language = $val->validated('language');
                $setting->contact_page = $val->validated('contact_page');
                $setting->contact_email = $val->validated('contact_email');

                Session::set_flash('error', $val->error());
            }

            $this->template->set_global('setting', $setting, false);
        }

        $data['data']['categories'] = Model_Category::find('all');
        $data['data']['pages'] = Model_Page::find('all');
		$this->template->title = "Settings";
		$this->template->content = View::forge('admin\settings/index', $data);

	}

}