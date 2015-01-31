<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Enrico
 * Date: 05/06/14
 * Time: 23.10
 * To change this template use File | Settings | File Templates.
 */
 interface ControllerInterface
{
    public function Display();
    public function defaultAction(Request $request);
}
