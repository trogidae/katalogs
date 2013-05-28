<?php
class Controller_Admin_Items extends Controller_Admin
{

	public function action_index()
	{
		$data['items'] = Model_Item::find('all');
		$this->template->title = "Items";
		$this->template->content = View::forge('admin\items/index', $data);

	}

	public function action_create()
	{
		if (Input::method() == 'POST')
		{
			$val = Model_Item::validate('create');

			if ($val->run())
			{
                //Change the slug to lowercase letters and spaces to -
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
                //If price not set change it to 0
                if (Input::post('price')=='') {
                    $price = 0;
                }
                else {
                    $price = Input::post('price');
                }
                $categories = array();
                $images = array();
                if (Input::post('categories')=="") {
                    $category = Model_Category::find(1);
                    $categories = array($category);
                }
                else {
                    foreach (Input::post('categories') as $cat_id) {
                        $category = Model_Category::find($cat_id);
                        $categories = array_merge_recursive($categories, array($category));
                    }
                }
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
					Session::set_flash('success', e('Added item #'.$item->id.'.'));

					Response::redirect('admin/items');
				}

				else
				{
					Session::set_flash('error', e('Could not save item.'));
				}
			}
			else
			{
				Session::set_flash('error', $val->error());
			}
		}
        $data['data']['images']['images'] = Model_Image::find('all');
        $categories = Model_Category::find('all');
        $data['data']['categories'] = $categories;
		$this->template->title = "Items";
		$this->template->content = View::forge('admin\items/create', $data);

	}

	public function action_edit($id = null)
	{
		$item = Model_Item::find($id);
		$val = Model_Item::validate('edit');

		if ($val->run())
		{
            //Change the slug to lowercase letters and spaces to -
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
            //If price not set change it to 0
            if (Input::post('price')=='') {
                $price = 0;
            }
            else {
                $price = Input::post('price');
            }
            // Work through all the new/deleted categories
            if (Input::post('categories')=="" && empty($item->categories)) {
                $category = Model_Category::find(1);
                $item->categories[] = $category;
            }
            else {
                foreach (Input::post('categories') as $cat_id) {
                    $category = Model_Category::find($cat_id);
                    $item->categories[] = $category;
                }
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
            // Work through all the new/deleted gallery images
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
				Session::set_flash('success', e('Updated item #' . $id));

				Response::redirect('admin/items');
			}

			else
			{
				Session::set_flash('error', e('Could not update item #' . $id));
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

			$this->template->set_global('item', $item, false);
		}
        $data['data']['images']['images'] = Model_Image::find('all');
        $categories = Model_Category::find('all');
        $data['data']['categories'] = $categories;
		$this->template->title = "Items";
		$this->template->content = View::forge('admin\items/edit', $data);
	}

	public function action_delete($id = null)
	{
		if ($item = Model_Item::find($id))
		{
			$item->delete();

			Session::set_flash('success', e('Deleted item #'.$id));
		}

		else
		{
			Session::set_flash('error', e('Could not delete item #'.$id));
		}

		Response::redirect('admin/items');

	}

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
                Session::set_flash('error', e('You have not selected anything.'));
            }
        }
        Response::redirect('admin/items');
    }

    private function delete_selected($items)
    {
        foreach ($items as $id) {
            if ($item = Model_Item::find($id))
            {
                $item->delete();

                Session::set_flash('success', e('Deleted items'));
            }

            else
            {
                Session::set_flash('error', e('Could not delete items'));
            }
        }
    }

    private function deactivate_selected($items)
    {
        foreach ($items as $id) {
            $item = Model_Item::find($id);
            $item->status = '0';
            $item->save();
        }
        Session::set_flash('success', e('Deactivated selected items.'));
    }

    private function activate_selected($items)
    {
        foreach ($items as $id) {
            $item = Model_Item::find($id);
            $item->status = '1';
            $item->save();
        }
        Session::set_flash('success', e('Activated selected items.'));
    }


}