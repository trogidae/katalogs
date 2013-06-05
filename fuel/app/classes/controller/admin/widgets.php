<?php
/**
 * Klase, kas kontrolē administrācijas paneļa Logrīki sadaļu
 *
 * Autors: Dana Kukaine
 * Pēdējo reizi mainīts: 01.06.2013.
 */
class Controller_Admin_Widgets extends Controller_Admin
{
    /**
     * Darbojas ar loģiku, kas izveidot un izsauc sadaļas Logrīki sākuma lapu
     *
     * @param int $page - lapas numurs, null pie pirmās lapas, pārējām ņem no URL 6. segmenta
     */
    public function action_index($page = null)
	{
        //Iestata iestatījumus logrīku sadalei pa lapām
        $pagination = \Pagination::forge('pagination', array(
                            'pagination_url' => \Uri::base(false) . 'admin/widgets/index',
                            'total_items' => Model_Widget::find()->count(),
                            'per_page' => 10,
                            'uri_segment' => 6,
                            'num_links' => 5,
                            'current_page' => $page,
                       ));
		$data['widgets'] = Model_Widget::find()
                            ->order_by('created_at', 'desc')
                            ->offset($pagination->offset)
                            ->limit($pagination->per_page)
                            ->get();
        //Izsauc skatu
		$this->template->title = Lang::get("Widgets");
		$this->template->content = View::forge('admin\widgets/index', $data);

	}

    /**
     * Darbojas ar loģiku, kas izveido jaunu logrīku, kā arī izsauc logrīka izveidošanas skatu
     */
    public function action_create()
	{
		if (Input::method() == 'POST')
		{
			$val = Model_Widget::validate('create');

			if ($val->run())
			{
				$widget = Model_Widget::forge(array(
					'type' => Input::post('type'),
					'title' => Input::post('title'),
					'content' => Input::post('content'),
                    'position' => Input::post('position'),
				));

				if ($widget and $widget->save())
				{
					Session::set_flash('success', e(Lang::get('Added widget #').$widget->id.'.'));

					Response::redirect('admin/widgets');
				}

				else
				{
					Session::set_flash('error', e(Lang::get('Could not save widget.')));
				}
			}
			else
			{
				Session::set_flash('error', $val->error());
			}
		}

        //Izsauc skatu, ja dati netika iesūtīti
		$this->template->title = Lang::get("Widgets");
		$this->template->content = View::forge('admin\widgets/create');

	}

    /**
     * Izlabo to logrīku, kuras identifikācijas nr. ir $id.
     *
     * @param int $id - identifikācijas numurs logrīkam, kas jālabo
     */
    public function action_edit($id = null)
	{
		$widget = Model_Widget::find($id);
		$val = Model_Widget::validate('edit');

		if ($val->run())
		{
			$widget->type = Input::post('type');
			$widget->title = Input::post('title');
			$widget->content = Input::post('content');
            $widget->position = Input::post('position');

			if ($widget->save())
			{
				Session::set_flash('success', e(Lang::get('Updated widget #') . $id));

				Response::redirect('admin/widgets');
			}

			else
			{
				Session::set_flash('error', e(Lang::get('Could not update wdgt') . $id));
			}
		}

		else
		{
			if (Input::method() == 'POST')
			{
				$widget->type = $val->validated('type');
				$widget->title = $val->validated('title');
				$widget->content = $val->validated('content');
                $widget->position = $val->validated('position');

				Session::set_flash('error', $val->error());
			}
            //Globalizē informāciju, par logrīku, lai tiktu aizpildīti ievades lauki ar jau esošajiem datiem
			$this->template->set_global('widget', $widget, false);
		}
        //Izsauc skatu
		$this->template->title = Lang::get("Widgets");
		$this->template->content = View::forge('admin\widgets/edit');

	}

    /**
     * Izdzēš logrīku ar id $id
     *
     * @param int $id - id tam logrīkam, kas jāizdzēš
     */
    public function action_delete($id = null)
	{
		if ($widget = Model_Widget::find($id))
		{
			$widget->delete();

			Session::set_flash('success', e(Lang::get('Deleted widget #').$id));
		}

		else
		{
			Session::set_flash('error', e(Lang::get('Could not delete wdgt').$id));
		}

		Response::redirect('admin/widgets');

	}


}