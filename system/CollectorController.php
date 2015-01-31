<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Enrico
 * Date: 06/06/14
 * Time: 2.04
 * To change this template use File | Settings | File Templates.
 */
class CollectorController extends  AbstractController
{

    public function __construct()
    {

    }

    public function defaultAction(Request $request)
    {
        global $response;
        if($this->isAdministration)
        {
            $this->livelloPagina = self::$LIVELLO_MOD;
            if($this->isAdminLogged($this->livelloPagina))
            {
                $this->adminHomeActionDefault($request);
            }
            else
            {
                $this->loginpageActionDefault($request);
            }
        }
        else
        {
            $this -> homeActionDefault($request);
        }



    }


}
