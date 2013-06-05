<?php
/**
 * Klase, kas kontrolē administrācijas paneļa "Preces" sadaļu
 *
 * Autors: Dana Kukaine
 * Pēdejo reizi mainīts: 01.06.2013.
 */
class Controller_Admin_Items extends Controller_Admin
{
    /**
     * Darbojas ar loģiku, kas veido sākuma lapu sadaļai "Preces" administrācijas panelī,
     * kā arī izsauc pašu skatu.
     *
     * @param int $page - lapas numurs, pirmajai lapa automātiski null, pārējām ņem no URL pēdējā segmenta.
     */
    public function action_index($page = null)
	{
        // Iestata parametrus preču sadalei pa lapām, lai gadījumā, kad preču ir daudz, lapa nebūtu ilgi jāielādē,
        // bet tā būtu sadalīta pa daļām - lapām.
        $pagination = \Pagination::forge('pagination', array(
                            'pagination_url' => \Uri::base(false) . 'admin/items/index',
                            'total_items' => Model_Item::find()->count(),
                            'per_page' => 10,
                            'uri_segment' => 6,
                            'num_links' => 5,
                            'current_page' => $page,
                       ));
		$data['items'] = Model_Item::find()
                            ->order_by('created_at', 'desc')
                            ->offset($pagination->offset)
                            ->limit($pagination->per_page)
                            ->get();

        // Izsauc nepieciešamo skatu.
		$this->template->title = Lang::get("Items");
		$this->template->content = View::forge('admin\items/index', $data);

	}

    /**
     * Darbojas ar loģiku, kas izveido jaunu preci, kā arī izsauc skatu jaunas preces izveidei.
     */
    public function action_create()
	{
		if (Input::method() == 'POST')
		{
			$val = Model_Item::validate('create');

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
                $slug = iconv("UTF-8", "ISO-8859-1//TRANSLIT", $slug);
                $slug = urlencode($slug);
                $slug = str_replace("%", "", $slug);

                // Ja cena nac norādīta, tad ievieto tai vērtību '0',
                //  priekš sekmīgām darbībām ar cenu citās vietās (piem., skatos)
                if (Input::post('price')=='') {
                    $price = 0;
                }
                else {
                    $price = Input::post('price');
                }
                $categories = array();
                $images = array();
                if (Input::post('categories')=="") {
                    // Ja lietotājs nav pievienojis nevienu kategoriju, tad pievieno noklusēto kategoriju, jo
                    //  precei jābūt kādā kategorijā.
                    $settings = Model_Setting::find_by_name('default_category');
                    $category = Model_Category::find($settings->value);
                    $categories = array($category);
                }
                else {
                    foreach (Input::post('categories') as $cat_id) {
                        $category = Model_Category::find($cat_id);
                        $categories = array_merge_recursive($categories, array($category));
                    }
                }
                // Galerijas attēli ievades laukā tiek glabāti virknē, atdalīti ar komatiem,
                //  tāpēc šeit tiek atdalīti ievadītie rezultāti, lai katru attēlu var pievienot precei
                $gallery = explode(",", Input::post('gallery'));
                foreach ($gallery as $image_id) {
                    if (isset($image_id) && $image_id!=0) {
                        $image = Model_Image::find($image_id);
                        $images = array_merge_recursive($images, array($image));
                    }
                }
				$item = Model_Item::forge(array(
					'title' => Input::post('title'),
					'slug' => $slug,
					'summary' => Input::post('summary'),
					'content' => Input::post('content'),
					'price' => $price,
					'user_id' => Input::post('user_id'),
					'status' => Input::post('status'),
                    'image_id' => Input::post('image_id')
				));
                foreach ( $categories as $category) {
                    $item->categories[] = $category;
                }
                foreach ( $images as $image) {
                    $item->gallery[] = $image;
                }

				if ($item and $item->save())
				{
					Session::set_flash('success', e(Lang::get('Added item #').$item->id.'.'));

					Response::redirect('admin/items');
				}

				else
				{
					Session::set_flash('error', e(Lang::get('Could not save item.')));
				}
			}
			else
			{
				Session::set_flash('error', $val->error());
			}
		}

        //Ja dati netika ievadīti, tad izsauc jaunas preces izveides skatu.
        $data['data']['images']['images'] = Model_Image::find('all');
        $categories = Model_Category::find('all');
        $data['data']['categories'] = $categories;
		$this->template->title = Lang::get("Items");
		$this->template->content = View::forge('admin\items/create', $data);

	}

    /**
     * Darbojas ar loģiku, kas labo preci ar identifikācijas numuru $id, kā arī izsauc preces labošanas skatu.
     *
     * @param int $id - tās preces identifikācijas numurs, kura jālabo.
     */
    public function action_edit($id = null)
	{
		$item = Model_Item::find($id);
		$val = Model_Item::validate('edit');

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
            $slug = iconv("UTF-8", "ISO-8859-1//TRANSLIT", $slug);
            $slug = urlencode($slug);
            $slug = str_replace("%", "", $slug);
            // Ja cena nac norādīta, tad ievieto tai vērtību '0',
            //  priekš sekmīgām darbībām ar cenu citās vietās (piem., skatos)
            if (Input::post('price')=='') {
                $price = 0;
            }
            else {
                $price = Input::post('price');
            }
            // Izskata visas kategorijas, lai izdzēstu tās, kuras vairs nav un pievienotu jaunās
            if (Input::post('categories')=="") {
                foreach($item->categories as $category) {
                    unset($item->categories[$category->id]);
                }
                // Ja lietotājs nav pievienojis nevienu kategoriju, tad pievieno noklusēto kategoriju, jo
                //  precei jābūt kādā kategorijā.
                $settings = Model_Setting::find_by_name('default_category');
                $category = Model_Category::find($settings->value);
                $item->categories[] = $category;
            }
            else {
                foreach (Input::post('categories') as $cat_id) {
                    $category = Model_Category::find($cat_id);
                    $item->categories[] = $category;
                }

                foreach ($item->categories as $added_cat) {
                    $exists = 0;
                    foreach (Input::post('categories') as $cat_id) {
                        if ($added_cat->id == $cat_id) {
                            $exists=1;
                        }
                    }
                    if (!$exists) {
                        unset($item->categories[$added_cat->id]);
                    }
                }
            }

            // Izskata visus jaunos galerijas attēlus, lai izdzēstu nepievienotos un pievienotu jaunos, ja nepieciešams
            if (Input::post('gallery')!='') {
                $images = array();
                $gallery = explode(",", Input::post('gallery'));
                foreach ($gallery as $image_id) {
                    if (isset($image_id) && $image_id!=0) {
                        $image = Model_Image::find($image_id);
                        $images = array_merge_recursive($images, array($image));
                    }
                }
                foreach ( $images as $image) {
                    $item->gallery[] = $image;
                }
                foreach ($item->gallery as $added_img) {
                    $exists = 0;
                    foreach ($images as $img_id) {
                        if ($added_img->id == $img_id) {
                            $exists=1;
                        }
                    }
                    if (!$exists) {
                        unset($item->gallery[$added_img->id]);
                    }
                }
            }
            else {
                foreach ($item->gallery as $img) {
                    unset($item->gallery[$img->id]);
                }
            }

			$item->title = Input::post('title');
			$item->slug = $slug;
			$item->summary = Input::post('summary');
			$item->content = Input::post('content');
			$item->price = $price;
			$item->user_id = Input::post('user_id');
			$item->status = Input::post('status');
            $item->image_id = Input::post('image_id');

			if ($item->save())
			{
				Session::set_flash('success', e(Lang::get('Updated item #') . $id));

				Response::redirect('admin/items');
			}

			else
			{
				Session::set_flash('error', e(Lang::get('Could not update item') . $id));
			}
		}

		else
		{
			if (Input::method() == 'POST')
			{
				$item->title = $val->validated('title');
				$item->slug = $val->validated('slug');
				$item->summary = $val->validated('summary');
				$item->content = $val->validated('content');
				$item->price = $val->validated('price');
				$item->user_id = $val->validated('user_id');
				$item->status = $val->validated('status');

				Session::set_flash('error', $val->error());
			}

            // Informācija par konkrēto preci tiek globalizēta,
            // lai labošanas forma būtu aizpildīta ar esošajām vērtībām.
			$this->template->set_global('item', $item, false);
		}

        // Ja dati netiek iesūtīti, tad izsauc preces labošanas skatu.
        $data['data']['images']['images'] = Model_Image::find('all');
        $categories = Model_Category::find('all');
        $data['data']['categories'] = $categories;
		$this->template->title = Lang::get("Items");
		$this->template->content = View::forge('admin\items/edit', $data);
	}

    /**
     * Izdzēš preci ar identifikācijas numuru $id.
     *
     * @param int $id - preces identifikācijas numurs, kura jāizdzēš
     */
    public function action_delete($id = null)
	{
		if ($item = Model_Item::find($id))
		{
			$item->delete();

			Session::set_flash('success', e(Lang::get('Deleted item #').$id));
		}

		else
		{
			Session::set_flash('error', e(Lang::get('Could not del itm').$id));
		}

		Response::redirect('admin/items');

	}

    /**
     * Apstrādā saņemto informāciju, par to, kas jādara ar atķeksētajām precēm,
     * un aizsūta uz izvēlēto funkciju.
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
        Response::redirect('admin/items');
    }

    /**
     * Tiek izdzēstas preces, kuru identifikācijas numurs ir masīvā $items.
     *
     * @param array $items - masīvs ar preču identifikācijas numuriem, kuras jāizdzēš
     */
    private function delete_selected($items)
    {
        foreach ($items as $id) {
            if ($item = Model_Item::find($id))
            {
                $item->delete();

                Session::set_flash('success', e(Lang::get('Deleted items')));
            }

            else
            {
                Session::set_flash('error', e(Lang::get('Could not del itms')));
            }
        }
    }

    /**
     * Tiek paslēptas (deaktivizētas) preces, kuru identifikācijas numurs ir masīvā $items.
     *
     * @param array $items - masīvs ar preču identifikācijas numuriem, uz kuriem jāveic darbība (deaktivizēšana)
     */
    private function deactivate_selected($items)
    {
        foreach ($items as $id) {
            $item = Model_Item::find($id);
            $item->status = '0';
            $item->save();
        }
        Session::set_flash('success', e(Lang::get('Deactivated selected itms')));
    }

    /**
     * Tiek publiskotas (aktivizētas) preces, kuru identifikācijas numurs ir masīvā $items.
     *
     * @param array $items - masīvs ar preču identifikācijas numuriem, uz kuriem jāveic darbība (aktivizēšana)
     */
    private function activate_selected($items)
    {
        foreach ($items as $id) {
            $item = Model_Item::find($id);
            $item->status = '1';
            $item->save();
        }
        Session::set_flash('success', e(Lang::get('Activated selected itms')));
    }


}