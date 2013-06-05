<?php
/**
 * Klase, kas kontrolē administrācijas paneļa Lapas sadaļu
 *
 * Autors: Dana Kukaine
 * Pēdējo reizi mainīts: 01.06.2013.
 */
class Controller_Admin_Pages extends Controller_Admin
{
    /**
     * Darbojas ar loģiku, kas izveido un izsauc administrācijas paneļa "Lapas" sākuma lapu
     *
     * @param int $page - lapas numurs, ja pirmā, tad null, pārējām ņem no URL 6. segmenta
     */
    public function action_index($page = null)
	{
        //Iestatījumi par "Lapu" sadalījumu pa lapām
        $pagination = \Pagination::forge('pagination', array(
                            'pagination_url' => \Uri::base(false) . 'admin/pages/index',
                            'total_items' => Model_Page::find()->count(),
                            'per_page' => 10,
                            'uri_segment' => 6,
                            'num_links' => 5,
                            'current_page' => $page,
                       ));
		$data['pages'] = Model_Page::find()
                                ->order_by('created_at', 'desc')
                                ->offset($pagination->offset)
                                ->limit($pagination->per_page)
                                ->get();

        //Izsauc skatu
		$this->template->title = Lang::get("Pages");
		$this->template->content = View::forge('admin\pages/index', $data);

	}

    /**
     * Darbojas ar loģiku, kas izveido jaunu lapu un izsauc jaunas lapas izveidošanas skatu
     */
    public function action_create()
	{
		if (Input::method() == 'POST')
		{
			$val = Model_Page::validate('create');

			if ($val->run())
			{
                // Nomaina īsvārda simbolus uz mazajiem burtiem, atstarpes pārvērš "-",
                //  kā arī URL nedraudzīgus simbolus pārvērš to skaitliskajās vērtībās,
                //  lai varētu to izmantot URL izveidē.
                if (Input::post('slug')=='') {
                    $slug = mb_strtolower(Input::post('title'), 'UTF-8');
                }
                else {
                    $slug = mb_strtolower(Input::post('slug'), 'UTF-8');
                }
                $slug = str_replace(" ", "-", $slug);

                //Izveido lapu
				$page = Model_Page::forge(array(
					'title' => Input::post('title'),
					'slug' => $slug,
					'summary' => Input::post('summary'),
					'content' => Input::post('content'),
					'status' => Input::post('status'),
					'user_id' => Input::post('user_id'),
				));

				if ($page and $page->save())
				{
					Session::set_flash('success', e(Lang::get('Added page #').$page->id.'.'));

					Response::redirect('admin/pages');
				}

				else
				{
					Session::set_flash('error', e(Lang::get('Could not save page.')));
				}
			}
			else
			{
				Session::set_flash('error', $val->error());
			}
		}

        //Ja nekādi dati netiek iesūtīti, tad tiek izsaukts jaunas lapas izveides skats.
		$this->template->title = Lang::get("Pages");
		$this->template->content = View::forge('admin\pages/create');

	}

    /**
     * Darbojas ar loģiku, kas labo lapu, ar identifikācijas numuru $id, kā arī izsauc lapas labošanas skatu.
     *
     * @param int $id - identifikācijas numurs tai lapai, kas jālabo
     */
    public function action_edit($id = null)
	{
		$page = Model_Page::find($id);
		$val = Model_Page::validate('edit');

		if ($val->run())
		{
            // Nomaina īsvārda simbolus uz mazajiem burtiem, atstarpes pārvērš "-",
            //  kā arī URL nedraudzīgus simbolus pārvērš to skaitliskajās vērtībās,
            //  lai varētu to izmantot URL izveidē.
            if (Input::post('slug')=='') {
                $slug = mb_strtolower(Input::post('title'), 'UTF-8');
            }
            else {
                $slug = mb_strtolower(Input::post('slug'), 'UTF-8');
            }
            $slug = str_replace(" ", "-", $slug);

            //Ievieto jaunās vērtības
			$page->title = Input::post('title');
			$page->slug = $slug;
			$page->summary = Input::post('summary');
			$page->content = Input::post('content');
			$page->status = Input::post('status');
			$page->user_id = Input::post('user_id');

			if ($page->save())
			{
				Session::set_flash('success', e(Lang::get('Updated page #') . $id));

				Response::redirect('admin/pages');
			}

			else
			{
				Session::set_flash('error', e(Lang::get('Could not update pg') . $id));
			}
		}

		else
		{
			if (Input::method() == 'POST')
			{
				$page->title = $val->validated('title');
				$page->slug = $val->validated('slug');
				$page->summary = $val->validated('summary');
				$page->content = $val->validated('content');
				$page->status = $val->validated('status');
				$page->user_id = $val->validated('user_id');

				Session::set_flash('error', $val->error());
			}

            // Globalizē informāciju, par konkrēto lapu,
            // lai ievades lauki aizpildītos ar jau iepriekš ieliktajām vērtībām
			$this->template->set_global('page', $page, false);
		}

        // Izsauc lapas labošanas skatu
		$this->template->title = Lang::get("Pages");
		$this->template->content = View::forge('admin\pages/edit');
	}

    /**
     * Izdzēš lapu ar identifikācijas numuru $id
     *
     * @param int $id - identifikācijas numurs tai lapai, kas jāizdzēš
     */
    public function action_delete($id = null)
	{
		if ($page = Model_Page::find($id))
		{
			$page->delete();

			Session::set_flash('success', e(Lang::get('Deleted page #').$id));
		}

		else
		{
			Session::set_flash('error', e(Lang::get('Could not delete pg').$id));
		}

		Response::redirect('admin/pages');

	}

    /**
     * Apstrādā saņēmtos datus (par atķeksētajām lapām) un pārsūta tos uz attiecīgo darbību.
     */
    public function action_selected()
    {
        if (Input::method() == 'POST') {
            if (Input::post('check')!="") {
                if (Input::post('action') == "delete") {
                    $this->delete_selected(Input::post('check'));
                }
                else if (Input::post('action') == "deactivate"){
                    $this->deactivate_selected(Input::post('check'));
                }
                else {
                    $this->activate_selected(Input::post('check'));
                }
            }
            else {
                Session::set_flash('error', e(Lang::get('You have not selected')));
            }
        }
        Response::redirect('admin/pages');
    }

    /**
     * Izdzēš lapas, kuru id ir masīvā $pages
     *
     * @param array $pages - masīvs ar lapu id, kuras jāizdzēš
     */
    private function delete_selected($pages)
    {
        foreach ($pages as $id) {
            if ($page = Model_Page::find($id))
            {
                $page->delete();

                Session::set_flash('success', e(Lang::get('Deleted pages')));
            }

            else
            {
                Session::set_flash('error', e(Lang::get('Could not delete pgs')));
            }
        }
    }

    /**
     * Paslāpej (deaktivizē) lapas, kuru id ir masīvā $pages
     *
     * @param array $pages - masīvs ar lapu id, kuras vajag paslēpt (deaktivizēt)
     */
    private function deactivate_selected($pages)
    {
        foreach ($pages as $id) {
            $page = Model_Page::find($id);
            $page->status = '0';
            $page->save();
        }
        Session::set_flash('success', e(Lang::get('Deactivated selected pgs')));
    }

    /**
     * Publicē (aktivizē) lapas, kuru id ir masīvā $pages.
     *
     * @param array $pages - masīvs ar lapu id, kuras vajag publicēt (aktivizēt)
     */
    private function activate_selected($pages)
    {
        foreach ($pages as $id) {
            $page = Model_Page::find($id);
            $page->status = '1';
            $page->save();
        }
        Session::set_flash('success', e(Lang::get('Activated selected pgs')));
    }


}