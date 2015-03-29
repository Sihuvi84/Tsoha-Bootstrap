<?php

require 'app/models/askare.php';

/**
 * Description of AskareController
 *
 * @author suvialat
 */
class AskareController extends BaseController {

    public static function index() {

        $askareet = Askare::all();
        View::make('askare/index.html', array('askareet' => $askareet));
    }

}
