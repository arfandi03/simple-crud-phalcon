<?php

namespace App\Forms;

use Phalcon\Forms\Form;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Element\Hidden;
use Phalcon\Forms\Element\Submit;
// Validation
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\Email;

class CreateUserForm extends Form
{
    public function initialize($entity = null, $options = [])
    {
        if (isset($options["edit"])) {
            $id = new hidden('id', [
                "required" => true,
            ]);

            $this->add($id);
        }

        $name = new Text('name', [
            "class" => "form-control",
            "placeholder" => "Enter Fullname "
        ]);

        $name->addValidators([
            new PresenceOf(['message' => 'The name is required']),
        ]);

        $email = new Text('email', [
            "class" => "form-control",
            "placeholder" => "Enter Email"
        ]);

        $email->addValidators([
            new PresenceOf(['message' => 'The email is required']),
            new Email(['message' => 'The e-mail is not valid']),
        ]);

        $this->add($name);
        $this->add($email);
    }
}