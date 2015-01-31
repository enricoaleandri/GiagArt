<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Enrico
 * Date: 09/06/14
 * Time: 19.04
 * To change this template use File | Settings | File Templates.
 */
abstract class AbstractBean
{
    protected $settings;
    protected function initBean()
    {
        $this->settings = initConfig::getInstance()->getSettings();
    }

}
