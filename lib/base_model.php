<?php

class BaseModel {

    protected $validators;
    protected $validator;
    public $validations;

    public function __construct($attributes = null) {
        // Käydään assosiaatiolistan avaimet läpi
        foreach ($attributes as $attribute => $value) {
            // Jos avaimen niminen attribuutti on olemassa...
            if (property_exists($this, $attribute)) {
                // ... lisätään avaimen nimiseen attribuuttin siihen liittyvä arvo
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
