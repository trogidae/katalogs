<?php
/**
 * Klase, kas kontrolē administrācijas paneļa Kategorijas sadaļu
 *
 * Autors: Dana Kukaine
 * Izveidots: 6.03.2013.
 * Pēdējo reizi mainīts: 01.06.2013.
 */

class Controller_Admin_Categories extends Controller_Admin
{
    /**
     * Darbojas ar loģiku, kas veido sākuma lapu sadaļai "Kategorijas" administrācijas panelī,
     * kā arī izsauc pašu skatu.
     *
     * @param int $page - lapas numurs, pirmajai lapa automātiski null, pārējām ņem no URL pēdējā segmenta.
     */
    public function action_index($page = null)
	{
        // Iestata parametrus kategoriju sadalei pa lapām, lai gadījumā, kad kategoriju ir daudz, lapa nebūtu ilgi jāielādē,
        // bet tā būtu sadalīta pa daļām - lapām.
        $pagination = \Pagination::forge('pagination', array(
                            'pagination_url' => \Uri::base(false) . 'admin/categories/index',
                            'total_items' => Model_Category::find()->count(),
                            'per_page' => 10,
                            'uri_segment' => 6,
                            'num_links' => 5,
                            'current_page' => $page,
                       ));

        $data['categories'] = Model_Category::find()
                                    ->order_by('created_at', 'desc')
                                    ->offset($pagination->offset)
                                    ->limit($pagination->per_page)
                                    ->get();

        // Izsauc nepieciešamo skatu.
        $this->template->title = Lang::get("Categories");
		$this->template->content = View::forge('admin\categories/index', $data);
	}

    /**
     * Darbojas ar loģiku, kas izveido jaunu kategoriju, kā arī izsauc skatu jaunas kategorijas izveidei.
     */
    public function action_create()
	{
		if (Input::method() == 'POST')                  // Pārbauda vai ir ienākuši dati jaunas kategorijas izveidei.
		{
			$val = Model_Category::validate('create');

			if ($val->run())                            // Pārbauda vai ievadītie dati atbilst validācijas nosacījumiem,
			{                                           // kas norādīti pie attiecīgā modeļa Model_Category.

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
                $slug = iconv("UTF-8", "ISO-8859-1//TRANSLIT", $slug);
                $slug = urlencode($slug);
                $slug = str_replace("%", "", $slug);

                // Ja netika ievadīts kategorijas "vecāks", tad pārsauc tā vērtību uz "null",
                //  lai datubāze atpazītu to kā tukšumu, ne kā 0(int).
                if (!Input::post('parent_id')) {
                    $parent_id = null;
                }
                else {
                    $parent_id = Input::post('parent_id');
                }

                //Izveido jaunu kategoriju un saglabā, izmetot attiecīgos ziņojumus (success vai error).
				$category = Model_Category::forge(array(
					'title' => Input::post('title'),
					'slug' => $slug,
                    'status' => Input::post('status'),
                    'parent_id' => $parent_id
				));

				if ($category and $category->save())
				{
					Session::set_flash('success', e(Lang::get('Added category #').$category->id.'.'));

					Response::redirect('admin/categories'); // Veiksmīgas kategorijas izveides gadījumā lapa tiek pāradresēta uz
                                                            //  kategoriju sadaļas sākumlapu.
				}

				else
				{
					Session::set_flash('error', e('Could not save cat'));
				}
			}
			else
			{
				Session::set_flash('error', $val->error());
			}
		}

        //Ja dati netika ievadīti, tad izsauc jaunas kategorijas izveides skatu.
        $data['categories']['categories'] = Model_Category::find('all');
		$this->template->title = Lang::get("Categories");
		$this->template->content = View::forge('admin\categories/create', $data);

	}

    /**
     * Darbojas ar loģiku, kas izmaina jau esošu kategoriju, kā arī izsauz kategorijas labošanas skatu.
     *
     * @param int $id - tās kategorijas identifikators, kuru vēlas labot
     */
    public function action_edit($id = null)
	{
		$category = Model_Category::find($id);
		$val = Model_Category::validate('edit');

		if ($val->run())                                // Pārbauda vai ievadītie dati atbilst validācijas nosacījumiem,
        {                                               // kas norādīti pie attiecīgā modeļa Model_Category.

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
            $slug = iconv("UTF-8", "ISO-8859-1//TRANSLIT", $slug);
            $slug = urlencode($slug);
            $slug = str_replace("%", "", $slug);

            // Ja netika ievadīts kategorijas "vecāks", tad pārsauc tā vērtību uz "null",
            //  lai datubāze atpazītu to kā tukšumu, ne kā 0(int).
            if (!Input::post('parent_id')) {
                $parent_id = null;
            }
            else {
                $parent_id = Input::post('parent_id');
            }

            // Nomaina kategorijas vērtības uz jaunajām
			$category->title = Input::post('title');
			$category->slug = $slug;
            $category->parent_id = $parent_id;
            $category->status = Input::post('status');

			if ($category->save())
			{
				Session::set_flash('success', e(Lang::get('Updated category #') . $id));

				Response::redirect('admin/categories');
			}

			else
			{
				Session::set_flash('error', e(Lang::get('Could not update cat') . $id));
			}
		}

		else
		{
			if (Input::method() == 'POST')
			{
				$category->title = $val->validated('title');
				$category->slug = $val->validated('slug');
                $category->parent_id = $val->validated('parent_id');
                $category->status = $val->validated('status');

				Session::set_flash('error', $val->error());
			}

            // Globalizē datus par konkrēto kategoriju,
            //  lai varētu aizpildīt ievades laukus ar šī brīža vērtībām
			$this->template->set_global('category', $category, false);
		}

        // Izsauc kategorijas labošanas skatu
        $data['categories']['categories'] = Model_Category::find('all');
		$this->template->title = Lang::get("Categories");
		$this->template->content = View::forge('admin\categories/edit', $data);

	}

    /**
     * Izdzēš kategoriju ar identifikatoru $id
     *
     * @param int $id - tās kategorijas identifikators, kuru jāizdzēš
     */
    public function action_delete($id = null)
	{
		if ($category = Model_Category::find($id))
		{
			$category->delete();

			Session::set_flash('success', e(Lang::get('Deleted category #').$id));
		}

		else
		{
			Session::set_flash('error', e(Lang::get('Could not delete cat').$id));
		}

		Response::redirect('admin/categories');

	}

    /**
     * Apstrādā saņemto informāciju par to, kas jādara ar atķeksētajām kategorijām,
     * un nosūta tālāk uz attiecīgo funkciju.
     */
    public function action_selected()
    {
        if (Input::method() == 'POST') {

            // Pirms apstrādā datus sīkāk pārbauda, vai vispār kāda kategorija tikai atķeksēta
            //  (lai netiktu darīts lieks darbs pēc tam)
            if (Input::post('check')!="") {

                // Uzzin kādu darbību lietotājs izvēlējās pildīt un aizsūta datus tālāk uz attiecīgo funkciju
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
        Response::redirect('admin/categories');
    }

    /*
     * Izdzēš tās kategorijas, kuru identifikatori ir masīvā $categories.
     *
     * @param array $categories - masīvs ar to kategoriju identifikatoriem, kuras jāizdzēš
     */
    private function delete_selected($categories)
    {
        foreach ($categories as $id) {
            if ($category = Model_Category::find($id))
            {
                $category->delete();

                Session::set_flash('success', e(Lang::get('Deleted categories')));
            }

            else
            {
                Session::set_flash('error', e(Lang::get('Could not delete cat')));
            }
        }
    }

    /**
     * Paslēpj (jeb deaktivizē) tās kategorijas, kuru identifikators ir masīvā $categories
     *
     * @param array $categories - masīvs ar to kategoriju identifikatoriem, kuras vajag paslēpt (jeb deaktivizēt)
     */
    private function deactivate_selected($categories)
    {
        foreach ($categories as $id) {
            $category = Model_Category::find($id);
            $category->status = '0';
            $category->save();
        }
        Session::set_flash('success', e(Lang::get('Deactivated selected cat')));
    }

    /**
     * Publisko (jeb aktivizē) tās kategorijas, kuru identifikators ir masīvā $categories
     *
     * @param array $categories - masīvs ar to kategoriju identifikatoriem, kuras vajag publiskot (jeb aktivizēt)
     */
    private function activate_selected($categories)
    {
        foreach ($categories as $id) {
            $category = Model_Category::find($id);
            $category->status = '1';
            $category->save();
        }
        Session::set_flash('success', e(Lang::get('Activated selected cat')));
    }

}