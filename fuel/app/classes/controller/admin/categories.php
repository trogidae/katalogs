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
				$category = Model_Category::forge(array(
					'title' => Input::post('title'),
					'slug' => $slug,
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

		$this->template->title = "Categories";
		$this->template->content = View::forge('admin\categories/create');

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
			$category->title = Input::post('title');
			$category->slug = $slug;

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

				Session::set_flash('error', $val->error());
			}

			$this->template->set_global('category', $category, false);
		}

		$this->template->title = "Categories";
		$this->template->content = View::forge('admin\categories/edit');

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


}