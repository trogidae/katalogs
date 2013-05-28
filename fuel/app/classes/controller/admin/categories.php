<?php
class Controller_Admin_Categories extends Controller_Admin
{

	public function action_index()
	{
        $data['categories'] = Model_Category::find('all');
        $this->template->title = "Categories";
		$this->template->content = View::forge('admin\categories/index', $data);
	}

	public function action_create()
	{
		if (Input::method() == 'POST')
		{
			$val = Model_Category::validate('create');

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
                if (!Input::post('parent_id')) {
                    $parent_id = null;
                }
                else {
                    $parent_id = Input::post('parent_id');
                }
				$category = Model_Category::forge(array(
					'title' => Input::post('title'),
					'slug' => $slug,
                    'status' => Input::post('status'),
                    'parent_id' => $parent_id
				));

				if ($category and $category->save())
				{
					Session::set_flash('success', e('Added category #'.$category->id.'.'));

					Response::redirect('admin/categories');
				}

				else
				{
					Session::set_flash('error', e('Could not save category.'));
				}
			}
			else
			{
				Session::set_flash('error', $val->error());
			}
		}
        $data['categories']['categories'] = Model_Category::find('all');
		$this->template->title = "Categories";
		$this->template->content = View::forge('admin\categories/create', $data);

	}

	public function action_edit($id = null)
	{
		$category = Model_Category::find($id);
		$val = Model_Category::validate('edit');

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
            if (!Input::post('parent_id')) {
                $parent_id = null;
            }
            else {
                $parent_id = Input::post('parent_id');
            }
			$category->title = Input::post('title');
			$category->slug = $slug;
            $category->parent_id = $parent_id;
            $category->status = Input::post('status');

			if ($category->save())
			{
				Session::set_flash('success', e('Updated category #' . $id));

				Response::redirect('admin/categories');
			}

			else
			{
				Session::set_flash('error', e('Could not update category #' . $id));
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

			$this->template->set_global('category', $category, false);
		}

        $data['categories']['categories'] = Model_Category::find('all');
		$this->template->title = "Categories";
		$this->template->content = View::forge('admin\categories/edit', $data);

	}

	public function action_delete($id = null)
	{
		if ($category = Model_Category::find($id))
		{
			$category->delete();

			Session::set_flash('success', e('Deleted category #'.$id));
		}

		else
		{
			Session::set_flash('error', e('Could not delete category #'.$id));
		}

		Response::redirect('admin/categories');

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
        Response::redirect('admin/categories');
    }

    private function delete_selected($categories)
    {
        foreach ($categories as $id) {
            if ($category = Model_Category::find($id))
            {
                $category->delete();

                Session::set_flash('success', e('Deleted categories'));
            }

            else
            {
                Session::set_flash('error', e('Could not delete categories'));
            }
        }
    }

    private function deactivate_selected($categories)
    {
        foreach ($categories as $id) {
            $category = Model_Category::find($id);
            $category->status = '0';
            $category->save();
        }
        Session::set_flash('success', e('Deactivated selected categories.'));
    }

    private function activate_selected($categories)
    {
        foreach ($categories as $id) {
            $category = Model_Category::find($id);
            $category->status = '1';
            $category->save();
        }
        Session::set_flash('success', e('Activated selected categories.'));
    }

}