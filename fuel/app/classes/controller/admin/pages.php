<?php
class Controller_Admin_Pages extends Controller_Admin 
{

	public function action_index()
	{
		$data['pages'] = Model_Page::find('all');
		$this->template->title = "Pages";
		$this->template->content = View::forge('admin\pages/index', $data);

	}

	public function action_create()
	{
		if (Input::method() == 'POST')
		{
			$val = Model_Page::validate('create');

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
					Session::set_flash('success', e('Added page #'.$page->id.'.'));

					Response::redirect('admin/pages');
				}

				else
				{
					Session::set_flash('error', e('Could not save page.'));
				}
			}
			else
			{
				Session::set_flash('error', $val->error());
			}
		}

		$this->template->title = "Pages";
		$this->template->content = View::forge('admin\pages/create');

	}

	public function action_edit($id = null)
	{
		$page = Model_Page::find($id);
		$val = Model_Page::validate('edit');

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
			$page->title = Input::post('title');
			$page->slug = $slug;
			$page->summary = Input::post('summary');
			$page->content = Input::post('content');
			$page->status = Input::post('status');
			$page->user_id = Input::post('user_id');

			if ($page->save())
			{
				Session::set_flash('success', e('Updated page #' . $id));

				Response::redirect('admin/pages');
			}

			else
			{
				Session::set_flash('error', e('Could not update page #' . $id));
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

			$this->template->set_global('page', $page, false);
		}

		$this->template->title = "Pages";
		$this->template->content = View::forge('admin\pages/edit');

	}

	public function action_delete($id = null)
	{
		if ($page = Model_Page::find($id))
		{
			$page->delete();

			Session::set_flash('success', e('Deleted page #'.$id));
		}

		else
		{
			Session::set_flash('error', e('Could not delete page #'.$id));
		}

		Response::redirect('admin/pages');

	}


}