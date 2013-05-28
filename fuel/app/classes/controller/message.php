<?php

class Controller_Message extends Controller_GlobalBase
{
    public function action_create()
    {
        if (Input::method() == 'POST')
        {
            $val = Model_Message::validate('create');

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
                    $email_data['message'] = $message;
                    try {
                        //Send email
                        $email = Email::forge();
                        $email->from($this->_settings->contact_email, 'DrukasPasaule.lv');
                        $email->to( array(
                                         Input::post('email') => Input::post('name'),
                                         $this->_settings->contact_email => 'DrukasPasaule.lv'
                                    ));
                        $email->subject('Contact form DrukasPasaule.lv');
                        $email->html_body(\View::forge('admin/messages/template', $email_data));
                        $email->send();

                        Session::set_flash('success', e('Sent message!'));

                        Response::redirect('page/view/kontakti');
                    }

                    catch(\EmailSendingFailedException $e) {

                        Session::set_flash('error', e('Could not send message.'));
                    }

                }

                else
                {
                    Session::set_flash('error', e('Could not send message.'));
                }
            }
            else
            {
                Session::set_flash('error', $val->error());
            }
        }

        Response::redirect('page/view/kontakti');

    }
}