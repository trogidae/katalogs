<?php
/**
 * Klase, kas kontrolē administrācijas paneļa "Attēlu" sadaļu
 *
 * Autors: Dana Kukaine
 * Pēdejo reizi mainīts: 01.06.2013.
 */
class Controller_Admin_Images extends Controller_Admin
{
    /**
     * Darbojas ar loģiku, kas veido sākuma lapu administrācijas paneļa sadaļai "Attēli",
     * kā arī izsauc pašu skatu.
     *
     * @param int $page - lapas numurs, pirmajai lapais automātiski null, pārējām ņem no URL pēdējā segmenta.
     */
    public function action_index($page = null)
	{
        // Iestata parametrus attēlu sadalei pa lapām, lai gadījumā, kad attēlu ir daudz, lapa nebūtu ilgi jāielādē,
        // bet tā būtu sadalīta pa daļām - lapām.
        $pagination = \Pagination::forge('pagination', array(
                            'pagination_url' => \Uri::base(false) . 'admin/images/index',
                            'total_items' => Model_Image::find()->where('id', '<>', 1)->count(),
                            'per_page' => 10,
                            'uri_segment' => 6,
                            'num_links' => 5,
                            'current_page' => $page,
        ));

		$data['images']['images'] = Model_Image::find()
                                        ->where('id', '<>', 1)
                                        ->order_by('created_at', 'desc')
                                        ->offset($pagination->offset)
                                        ->limit($pagination->per_page)
                                        ->get();

        // Izsauc nepieciešamo skatu.
        $this->template->title = Lang::Get("Images");
		$this->template->content = View::forge('admin\images/index', $data, false);
	}

    /**
     * Darbojas ar loģiku, kas izveido jaunu attēlu, tas ir saglabā to datubāzē, mapē,
     * kā arī no oriģinālā attēla izveido trīs mazāka izmēra attēlus, ko vēlāk izmanto kā attēlu priekšsatus.
     *
     * @return string - json atbilde, vai fails augšupielādējās veiksmīgi vai ne.
     */
    public function action_create()
	{
		if (Input::method() == 'POST') {

            Upload::process();

            if (Upload::is_valid()) {
                // Konkrētās dienas gadu un mēnesi izmanto attēlu saglabāšanai attiecīgajā mapē, tas ir, lai visi
                //  attēlu nebūtu vienā mapē tie tiek sadalīti pa gadiem un mēnešiem, kuros tika pievienoti.
                $date = array( 'year' => date("Y"),
                               'month' => date("n"));
                $arr = Upload::get_files();
                Upload::save(DOCROOT . 'media' . DS . 'uploads' . DS . $date['year'] . DS . $date['month'] , array_keys($arr));
                foreach (Upload::get_files() as $file) {
                    $sizes = Image::sizes($file['saved_to'] . $file['saved_as']);
                    $filename = str_replace(".", "", $file['name']);
                    Image::load($file['saved_to'] . $file['saved_as'])
                        ->preset('150x200') // "preset" izmanto iepriekš izveidoto profilu attēlu manipulācijai (nokonfigurēti pie config/image.php)
                                            // šeit tiek nokopēts attēls, bet ar izmainītu izmēru
                        ->save(DOCROOT . 'media' . DS . 'thumbs' . DS . $filename . '_150x200');
                    Image::load($file['saved_to'] . $file['saved_as'])
                        ->preset('100x100')
                        ->save(DOCROOT . 'media' . DS . 'thumbs' . DS . $filename . '_100x100');
                    Image::load($file['saved_to'] . $file['saved_as'])
                        ->preset('medium')
                        ->save(DOCROOT . 'media' . DS . 'thumbs' . DS . $filename . '_medium');

                    // Datus par attēlu saglabā datubāzē beigās, lai gadījumā,
                    //  ja neaugšupielādējas attēli, tie arī nav atrodami datubāzē
                    $image = Model_Image::forge(array(
                                                     'name' => $file['saved_as'],
                                                     'thumb' => 'media/' . 'thumbs/' . $filename,
                                                     'extension' => $file['extension'],
                                                     'path' => 'media/' . 'uploads/' . $date['year'] . '/' . $date['month'] . '/',
                                                     'width' => $sizes->width,
                                                     'height' => $sizes->height,
                    ));
                    $image->save();
                }
                return json_encode($arr);
            }

		}

        //Ja dati netika ievadīti, tad izsauc sadaļas "Attēli" sākumlapas skatu
        $this->template->title = Lang::get("Images");
        $this->template->content = View::forge('admin/images/index');
	}

    /**
     * Izdzēš attēlu ar identifikatoru $id.
     *
     * @param int $id - tā attēla identifikators, kuru jāzidzēš
     */
    public function action_delete($id = null)
	{
        $items = Model_Item::find('all');
		if ($image = Model_Image::find($id))
		{
            // Vispirms izdzēš attēlu - preču saistību, lai dzēšot attēlu nerastos kļūdas
            // un lai izdzēšot attēlu nerādītos kļūdas pie precēm, kurām tas attēls bija piesaistīts.
            foreach ($items as $item) {
                if ($item->image_id==$id) {
                    $item->image_id = '1';
                    $item->save();
                }
            }
            $pathToImage['orig'] = DOCROOT . $image->path . $image->name;
            $pathToImage['medium'] = DOCROOT . $image->thumb . '_medium' . '.' . $image->extension;
            $pathToImage['small'] = DOCROOT . $image->thumb . '_150x200' . '.' . $image->extension;
            $pathToImage['smallest'] = DOCROOT . $image->thumb . '_100x100' . '.' . $image->extension;
            $image->delete();
            File::delete($pathToImage['orig']);
            File::delete($pathToImage['medium']);
            File::delete($pathToImage['small']);
            File::delete($pathToImage['smallest']);

			Session::set_flash('success', e(Lang::get('Deleted image #').$id));
		}

		else
		{
			Session::set_flash('error', e(Lang::get('Could not delete img').$id)); //"Could not delete image #"
		}

		Response::redirect('admin/images');

	}

    /*
     * Izdzēš vairākus attelus, ko saņem no lietotāja iesniegtas formas
     */
    public function action_deleteSelected ()
    {
        $items = Model_Item::find('all');
        foreach (Input::post('delete') as $id) {

            if ($image = Model_Image::find($id))
            {
                // Vispirms izdzēš attēlu <-> preču saistību, lai dzēšot attēlu nerastos kļūdas
                // un lai izdzēšot attēlu nerādītos kļūdas pie precēm, kurām tas attēls bija piesaistīts.
                foreach ($items as $item) {
                    if ($item->image_id==$id) {
                        $item->image_id = '1';
                        $item->save();
                    }
                }
                $image->delete();

                Session::set_flash('success', e(Lang::get('Deleted images')));
            }

            else
            {
                Session::set_flash('error', e(Lang::get('Could not delete imgs'))); //"Could not delete some images
            }
        }

        Response::redirect('admin/images');
    }


}