<?php
declare(strict_types=1);

class ProfileController extends ControllerBase 
{

    public function indexAction()
    {
        $this->view->users = Users::find();
    }

    public function registerAction()
    {
        $user = new Users();

        $user->assign(
            $this->request->getPost(),
            [
                'name',
                'email'
            ]
        );

        $success = $user->save();

        if($success) {
            // echo "Thanks for registering";
            $this->flashSession->success('Thanks for registering!');

            return $this->response->redirect('index');

        } else {
            echo "Sorry the following problems were generated: ";

            $messages = $user->getMessage();

            foreach($messages as $message) {
                echo $message->getMessage(), "<br/>";
            }
        }

        $this->view->disable();
    }

}

