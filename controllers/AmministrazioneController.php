<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Enrico
 * Date: 03/06/14
 * Time: 17.16
 * To change this template use File | Settings | File Templates.
 */
class AmministrazioneController extends  AbstractController
{

    private static $LOGIN_PAGE_FORWARD = "login";
    private static $ADMIN_HOME_FORWARD = "admin_home";
    private static $HOME_FORWARD = "home";

    public function __construct()
    {
        $this->className = get_class($this);
        $this->livelloPagina = self::$LIVELLO_MOD;
    }

    public function loginpageAction(Request $request)
    {
        if($this -> isAdminLogged(self::$LIVELLO_ADM))
        {
            $this->includer->includePage(self::$ADMIN_HOME_FORWARD);
        }
        else
        {
            $this->includer->includePage(self::$LOGIN_PAGE_FORWARD);
        }
    }
    public function logoutAction(Request $request)
    {
        $this->AdminLogout();
        global $response;
        $response->setProperty("url",Utils::getURLPath());
        $response->setProperty("host",Utils::getHost());
        $this->includer->includePage(self::$HOME_FORWARD);
    }
    public function loginAction(Request $request)
    {
        if($request -> is_set('username') && $request-> is_set('password'))
        {
            $clear= function ($value) { return Utils::clearUserValue($value);};

            $user = $clear($request -> get('username'));
            $pass = $clear($request -> get('password'));

            if($this->AdminLogin($user,$pass))
            {
                Logger::log(Logger::$DEBUG,"Login ok!");
                $LavoriController = new LavoriController();
                $LavoriController->setContext($this);
                $LavoriController->listAction($request);
                return;
            }
            else
            {
                $this -> response -> setError("login_error","Errore autenticazione! Riprovare! ");
                Logger::log(Logger::$DEBUG,"Errore di autenticazione");
                $this->includer->includePage(self::$LOGIN_PAGE_FORWARD);
                return;
            }
        }
        else
        {
            if($this->isAdministration) $this->livelloPagina = self::$LIVELLO_MOD;
            Logger::log(Logger::$DEBUG, "loginAction() - isAdminLogged(".$this->livelloPagina.") = ".$this->isAdminLogged($this->livelloPagina));
            if($this->isAdminLogged($this->livelloPagina))
            {
                $this->includer->includePage(self::$ADMIN_HOME_FORWARD);
                return;
            }
            else
            {
                $this->includer->includePage(self::$LOGIN_PAGE_FORWARD);
                return;
            }
        }
    }

}
