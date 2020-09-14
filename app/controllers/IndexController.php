<?php
declare(strict_types=1);

use Phalcon\Http\Request;

use App\Forms\CreateUserForm;

class IndexController extends ControllerBase
{
    public $createUserForm;

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
            $this->flashSession->success('Thanks for registering!');

            return $this->response->redirect('index/index');

        } else {
            echo "Sorry the following problems were generated: ";

            $messages = $user->getMessage();

            foreach($messages as $message) {
                echo $message->getMessage(), "<br/>";
            }
        }

        $this->view->disable();
    }

    public function editAction($userID = null)
    {
        $this->tag->setTitle('Phalcon :: Edit User');

        $user = Users::findFirstById($userID);

        echo $userID;

        if (!$user) {
            $this->flashSession->error('Not found');
            return $this->response->redirect('index/index');
        }

        $this->view->form = new CreateUserForm($user, [
            "edit" => true,
        ]);
    }

    public function editSubmitAction()
    {
        $userID = $this->request->getPost("id");

        $user = Users::findFirstById($userID);

        if (!$user) {
            $this->flashSession->error('Not found');
            return $this->response->redirect('index/index');
        }

        $form = new CreateUserForm();

        $data = $this->request->getPost();

        foreach ($data as $d) {
            echo $d;
        }

        if (!$form->isValid($data, $user)) {
            $messages = $form->getMessages();
            foreach ($messages as $message) {
                $this->flashSession->error($message);
                return $this->response->redirect('index/index');
            }
        }

        $success = $user->save();

        if ($user->save() === false) {
            $messages = $user-getMessage();
            foreach ($messages as $m) {
                $this->flashSession->error($m);
            }

            return $this->response->redirect('index/index');
        }

        $form->clear();

        $this->flashSession->success('Updated successfully.');
        return $this->response->redirect('index/index');

        $this->view->disable();
    }

    public function deleteAction($userID)
    {
            $user = Users::findFirst([
                'conditions' => 'id = :1:',
                'bind' => [
                    '1' => $userID
                ]
            ]);

            if (!$user) {
                $this->flashSession->error('Not found');
                return $this->response->redirect('index/index');
            }    

            if (!$user->delete()) {
                foreach ($user->getMessages() as $msg) {
                    $this->flashSession->error((string) $msg);
                }
                return $this->response->redirect("index/index");
            } else {
                $this->flashSession->success("Users was deleted");
                return $this->response->redirect("index/index");
            }

        $this->view->disable();
    }

}

