<?php

class BaseModel {

    protected $validators;
    protected $validator;
    public $validations;

    public function __construct($attributes = null) {

        foreach ($attributes as $attribute => $value) {
            if (property_exists($this, $attribute)) {
                $this->{$attribute} = $value;
            }
        }

    }

    public function errors() {
        return $this->validator->errors();
    }

    public function validate($params) {

        $validator = new Valitron\Validator($params);
        $validator->rules($this->validations);
        $this->validator = $validator;
        return $validator->validate();
    }

}
