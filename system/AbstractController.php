<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Enrico
 * Date: 05/06/14
 * Time: 23.10
 * To change this template use File | Settings | File Templates.
 */
class AbstractController extends AbstractTinaFramework implements ControllerInterface
{
    protected $className;
    protected $livelloPagina;


    private static $LOGIN_PAGE_FORWARD = "login";
    private static $HOME_FORWARD = "home";
    private static $ADMIN_HOME_FORWARD = "admin_home";

    public function initializeAbstractController($isAdministration)
    {
        $this -> isAdministration = $isAdministration;

        if($this -> isAdministration)
        {
            $this->livelloPagina = self::$LIVELLO_PUB;
        }
        else
        {
            $this->livelloPagina = self::$LIVELLO_MOD;
        }

    }

    public function Display()
    {
        echo $this->response->render();
    }

    public function loginpageActionDefault(Request $request)
    {
        global $response;
        Logger::log(Logger::$DEBUG,"Class : $this->className -  host : loginpageActionDefault");
        //$response->setProperty("url",Utils::getURLPathAdmin());
        //$response->setProperty("host",Utils::getHostAdmin());

        $ammiController = new AmministrazioneController();
        $ammiController->setContext($this);
        $ammiController->loginpageAction($request);
    }

    public function homeActionDefault(Request $request)
    {

        global $response;
        Logger::log(Logger::$DEBUG,"Class : $this->className -  host : homeActionDefault");
        //$response->setProperty("url",Utils::getURLPath());
        //$response->setProperty("host",Utils::getHost());
        $this->includer->includePage(self::$HOME_FORWARD);
    }

    public function adminHomeActionDefault(Request $request)
    {

        global $response;

        Logger::log(Logger::$DEBUG,"Class : $this->className -  host : adminHomeActionDefault");
        //$response->setProperty("url",Utils::getURLPathAdmin());
        //$response->setProperty("host",Utils::getHostAdmin());
        $lavoriController = new LavoriController();
        $lavoriController->setContext($this);
        $lavoriController->listAction($request);
    }
    public function defaultAction(Request $request)
    {
    }

    public function isActionAccessible()
    {
        if($this -> isAdminLogged($this->livelloPagina))
            return true;
        else
            return false;
    }
    //
    public function __call( $functionName, $args)
    {
        $functionName.="Action";
        // Pre callback
        $time_start = microtime(true);
        $result = call_user_func_array( array( $this, $functionName), $args);
        // Post callback
        $time_end =microtime(true);

        $time = $time_end - $time_start;
        Logger::log(Logger::$PROFILING,"Class : $this->className  Function : $functionName - execution time : $time s");
        return $result;
    }

    public function getLivelloPagina()
    {
        return $this->livelloPagina;
    }

    public function setContext($controller)
    {

        global $response;
        $this->livelloPagina = $controller -> getLivelloPagina();
        $this->properties = $controller -> getProperties();
        $this->includer = $controller -> getIncluder();
        $this->connection = $controller -> getConnection();
        $this->isAdministration = $controller -> IsAdministration();
        $this->response = $response;

    }
}
