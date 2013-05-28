<?php
class Controller_Admin_Images extends Controller_Admin
{

	public function action_index()
	{
		$data['images']['images'] = Model_Image::find('all');
		$this->template->title = "Images";
		$this->template->content = View::forge('admin\images/index', $data, false);
	}

	public function action_view($id = null)
	{
		$data['image'] = Model_Image::find($id);

		$this->template->title = "Image";
		$this->template->content = View::forge('admin\images/view', $data);

	}

	public function action_create()
	{
		if (Input::method() == 'POST') {

            Upload::process();

            if (Upload::is_valid()) {
                $date = array( 'year' => date("Y"),
                               'month' => date("n"));
                $arr = Upload::get_files();
                Upload::save(DOCROOT . 'media' . DS . 'uploads' . DS . $date['year'] . DS . $date['month'] , array_keys($arr));
                foreach (Upload::get_files() as $file) {
                    $sizes = Image::sizes($file['saved_to'] . $file['saved_as']);
                    $filename = str_replace(".", "", $file['name']);
                    Image::load($file['saved_to'] . $file['saved_as'])
                        ->preset('150x200')
                        ->save(DOCROOT . 'media' . DS . 'thumbs' . DS . $filename . '_150x200');
                    Image::load($file['saved_to'] . $file['saved_as'])
                        ->preset('100x100')
                        ->save(DOCROOT . 'media' . DS . 'thumbs' . DS . $filename . '_100x100');
                    Image::load($file['saved_to'] . $file['saved_as'])
                        ->preset('medium')
                        ->save(DOCROOT . 'media' . DS . 'thumbs' . DS . $filename . '_medium');
                    $image = Model_Image::forge(array(
                                                     'name' => $file['saved_as'],
                                                     'thumb' => 'media/' . 'thumbs/' . $filename,
                                                     'extension' => $file['extension'],
                                                     'path' => 'media/' . 'uploads/' . $date['year'] . '/' . $date['month'] . '/',
                                                     'width' => $sizes->width,
                                                     'height' => $sizes->height,
                                                     'alt_text' => '',
                    ));
                    if ($image and $image->save())
                    {
                        //Session::set_flash('success', e('Added image #'.$image->id.'.'));
                        //Response::redirect('admin/images');
                    }
                    else
                    {
                        //Session::set_flash('error', e('Could not save image.'));
                    }
                }
                return json_encode($arr);
            }

		}
        $this->template->title = "Image";
        $this->template->content = View::forge('admin\images/create');
	}

	public function action_edit($id = null)
	{
		$image = Model_Image::find($id);
		$val = Model_Image::validate('edit');

		if ($val->run())
		{
			$image->name = Input::post('name');
			$image->path = Input::post('path');
			$image->width = Input::post('width');
			$image->height = Input::post('height');
			$image->alt_text = Input::post('alt_text');

			if ($image->save())
			{
				Session::set_flash('success', e('Updated image #' . $id));

				Response::redirect('admin/images');
			}

			else
			{
				Session::set_flash('error', e('Could not update image #' . $id));
			}
		}

		else
		{
			if (Input::method() == 'POST')
			{
				$image->name = $val->validated('name');
				$image->path = $val->validated('path');
				$image->width = $val->validated('width');
				$image->height = $val->validated('height');
				$image->alt_text = $val->validated('alt_text');

				Session::set_flash('error', $val->error());
			}

			$this->template->set_global('image', $image, false);
		}

		$this->template->title = "Images";
		$this->template->content = View::forge('admin\images/edit');

	}

	public function action_delete($id = null)
	{
        $items = Model_Item::find('all');
		if ($image = Model_Image::find($id))
		{
            foreach ($items as $item) {
                if ($item->image_id==$id) {
                    $item->image_id = '1';
                    $item->save();
                }
            }
            $image->delete();


			Session::set_flash('success', e('Deleted image #'.$id));
		}

		else
		{
			Session::set_flash('error', e('Could not delete image #'.$id));
		}

		Response::redirect('admin/images');

	}

    public function action_deleteSelected ()
    {
        $items = Model_Item::find('all');
        foreach (Input::post('delete') as $id) {

            if ($image = Model_Image::find($id))
            {
                foreach ($items as $item) {
                    if ($item->image_id==$id) {
                        $item->image_id = '1';
                        $item->save();
                    }
                }
                $image->delete();

                Session::set_flash('success', e('Deleted images'));
            }

            else
            {
                Session::set_flash('error', e('Could not delete some images'));
            }
        }

        Response::redirect('admin/images');
    }


}