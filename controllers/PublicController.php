<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Enrico
 * Date: 03/06/14
 * Time: 17.16
 * To change this template use File | Settings | File Templates.
 */
class PublicController extends  AbstractController
{

    private static $HOME_FORWARD = "home";
    private static $ABOUT_FORWARD = "about";
    private static $CONTACT_FORWARD = "contact";
    private static $PORTFOLIO_FORWARD = "portfolio";

    public function __construct()
    {
        $this->className = get_class($this);
        $this->livelloPagina = self::$LIVELLO_PUB;
    }

    public function homeAction(Request $request)
    {
        $this->response->setProperty("selectedPage", "home");
        $this->includer->includePage(self::$HOME_FORWARD);
    }
    public function aboutAction(Request $request)
    {
        $this->response->setProperty("selectedPage", "about");
        $this->includer->includePage(self::$ABOUT_FORWARD);
    }
    public function contactAction(Request $request)
    {
        $this->response->setProperty("selectedPage", "contact");
        $this->includer->includePage(self::$CONTACT_FORWARD);
    }
    public function portfolioAction(Request $request)
    {
        $this->response->setProperty("selectedPage", "portfolio");
        $lavoriDAO = new lavoriDAO($this->connection);

        $this -> response -> setProperty("lavori",$lavoriDAO->getAllLavori());

        $this->includer->includePage(self::$PORTFOLIO_FORWARD);
    }

}
