<?php
/**
 * Klase, kas kontrolē ienākošās ziņas no kontaktu lapas
 *
 * Autors: Dana Kukaine
 * Pēdējo reizi mainīts: 01.06.2013.
 */
class Controller_Message extends Controller_GlobalBase
{
    /**
     * Saglabā un aizsūta uz e-pastu ziņu, kas nāk no kontaktu lapas
     */
    public function action_create()
    {
        if (Input::method() == 'POST')
        {
            //Validācijas nosacījumi ziņas formai
            $val = Validation::forge();
            $val->add('email', Lang::get('Email'))
                ->add_rule('required')
                ->add_rule('valid_email')
                ->add_rule('max_length[255]');
            $val->add('phone', Lang::get('Phone'))
                ->add_rule('max_length[255]');
            $val->add('name', Lang::get('Name'))
                ->add_rule('required')
                ->add_rule('max_length[255]');
            $val->add('message', Lang::get('Message'))
                ->add_rule('required');

            if ($val->run())
            {
                $message = Model_Message::forge(array(
                                                     'email' => Input::post('email'),
                                                     'phone' => Input::post('phone'),
                                                     'name' => Input::post('name'),
                                                     'message' => Input::post('message'),
                                                ));

                if ($message and $message->save())
                {
                    //Ja ziņa saglabājusies datu bāzē, tad to sūta uz e-pastiem
                    $email_data['message'] = $message;
                    try {
                        //Sūta e-pastus
                        $email = Email::forge();
                        $email->from($this->_settings['contact_email']->value, $this->_settings['site_title']->value);
                        $email->to( array(
                                         Input::post('email') => Input::post('name'),
                                         $this->_settings['contact_email']->value => $this->_settings['site_title']->value
                                    ));
                        $email->subject(Lang::get('Contact form') . ' ' . $this->_settings['site_title']->value);
                        $email->html_body(\View::forge('admin/messages/template', $email_data));
                        $email->send();

                        Session::set_flash('success', e(Lang::get('Message sent!')));

                        Response::redirect('page/view/kontakti');
                    }

                    catch(\EmailSendingFailedException $e) {

                        Session::set_flash('error', e(Lang::get('Could not send msg')));
                    }

                }

                else
                {
                    Session::set_flash('error', e(Lang::get('Could not send msg')));
                }
            }
            else
            {
                if (Input::method() == 'POST')
                {
                    Session::set_flash('error', Lang::get('Message validation'));
                }
            }
        }
        //Ja netika saņemti dati, tad pāradresē lapu uz kontaktu lapu
        Response::redirect('homepage');

    }
}