<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Enrico
 * Date: 10/06/14
 * Time: 0.17
 * To change this template use File | Settings | File Templates.
 */
class AjaxController extends  AbstractController
{

    private static $HOME_FORWARD = "home";
    public function __construct()
    {
        $this -> className = get_class($this);

        if($this->isAdminLogged(self::$LIVELLO_MOD))
        {
            $this->livelloPagina = self::$LIVELLO_ADM;
        }
        else
        {
            $this->livelloPagina = self::$LIVELLO_PUB;
        }
    }
    function razzeAction(Request $request)
    {

        if($request->is_set("group") && $request->get("group") != "")
        {
            $group = $request->get("group");
            Logger::log(Logger::$INFO, "[AjaxController] razzeAction -  Parameter: group = ".$group);
            $razzeDAO = new razzeDAO($this->connection);

            if($group == "all"){
                $razzeVal = $razzeDAO->getAllRazze();
            }
            else
            {
                $razzeVal= $razzeDAO->getRazzeByGroup($group);
            }
            if($razzeVal)
            {
                $razzeValue = array('status'=>0,'errorMessage' => '' ,'value'=> $razzeVal);
                Logger::log(Logger::$DEBUG, "[Ajax call] case:'razze' -   Response JSON:".json_encode($razzeValue));
                $decodedRazze = json_decode(json_encode($razzeValue));
                $arrayTemp = (array)$decodedRazze;
                foreach($arrayTemp['value'] as $valueTemp)
                {
                    $values = (array)$valueTemp;
                    if($values['razza']==null)
                    {
                        Logger::log(Logger::$ERROR, "[Ajax call] case:'razze' -   Encode JSON: errore codifica razza =".$values['razza']." con id_razza = ".$values['numero_razza']." la razza non sara' visualizzata");
                        $arrayTemp['errorMessage'] = "Alcune razze potrebbero non essere visualizzate";
                    }
                }
                $this->response->addContent(json_encode($razzeValue));
            }
            else
            {
                $error = array('status' => -1,'errorMessage' => 'Nessun risultato per il gruppo selezionato' ,'value'=>'');
                $this->response->addContent( json_encode($error));
                Logger::log(Logger::$ERROR, "[AjaxController] razzeAction  -  Query not produced result");
            }
        }
        else
        {
            $error = array('status' => -1,'errorMessage' => 'Gruppo razza non inserito' ,'value'=>'');
            Logger::log(Logger::$ERROR, "[AjaxController] razzeAction -  Gruppo razza non inserito");
            $this->response->addContent( json_encode($error));
        }
    }

    function gruppiAction(Request $request)
    {

        $razzeDAO = new razzeDAO($this->connection);

        $gruppiValue = $razzeDAO->getAllGruppi();

        if($gruppiValue)
        {
            $gruppi = array('status' => 0,'errorMessage' => '' ,'value'=>$gruppiValue);
            //Logger::log(Logger::$DEBUG, "[AjaxController] gruppiAction -  Response JSON:".json_encode($gruppi));
            $this->response->addContent(json_encode($gruppi));
        }
        else
        {
            $error = array('status' => -1,'errorMessage' => 'Errore recupero gruppi' ,'value'=>'');
            $this->response->addContent(json_encode($error));
            Logger::log(Logger::$ERROR, "[AjaxController] gruppiAction -  Query not produced result");
        }
    }

    function totprezzoAction(Request $request)
    {

        if($request->is_set('id') && $request->is_set('classe')
            && $request->is_set('is_socio')&& $request->is_set('is_coppia')
            && $request->is_set('n_group'))
        {
            $idConcorso = $request->get("id");
            $classe = $request->get("classe");
            $isSocio = $request->get("is_socio");
            $isCoppia = $request->get("is_coppia");
            $nGroup = $request->get("n_group");

            $prezzo =  Utils::calcolaPrezzo($idConcorso,$classe,$isSocio,$isCoppia,$nGroup);

            if($prezzo)
            {

                $prezziValue = array('status'=>0,'errorMessage' => '' ,'value'=> $prezzo);
                Logger::log(Logger::$INFO, "[AjaxController] totprezzoAction - Response JSON:".json_encode($prezziValue));
                $this->response->addContent(json_encode($prezziValue));
            }
            else
            {
                $error = array('status'=>-1,'errorMessage' => 'Errore recupero Prezzi' ,'value'=> '');
                Logger::log(Logger::$ERROR, "[AjaxController] totprezzoAction - calcolaPrezzo ha resistutito FALSE");
                $this->response->addContent(json_encode($error));
            }
        }
        else
        {
            $error = array('status'=>-1,'errorMessage' => 'Parametri mancanti in recupero prezzi ajax!' ,'value'=>'');
            Logger::log(Logger::$ERROR, "[AjaxController] totprezzoAction - Some parameters is missing");
            $this->response->addContent(json_encode($error));
        }
    }

    function prezziAction(Request $request)
    {
        if($request->is_set('id') && $request->is_set('classe'))
        {
            $idConcorso = $request->get("id");
            $classe = $request->get("classe");
            $prezziDAO = new prezziDAO($this->connection);

            $prezziVal = $prezziDAO->getPrezzo($idConcorso, $classe);

            if($prezziVal)
            {
                $prezziValue = array('status'=>0,'errorMessage' => '' ,'value'=> $prezziVal);
                Logger::log(Logger::$DEBUG, "[AjaxController] prezziAction - Response JSON:".json_encode($prezziValue));
                $this->response->addContent(json_encode($prezziValue));
            }
            else
            {
                $error = array('status'=>-1,'errorMessage' => 'Errore recupero Prezzi' ,'value'=> '');
                Logger::log(Logger::$ERROR, "[AjaxController] prezziAction -  Query not produced result");
                $this->response->addContent(json_encode($error));
            }
        }
        else
        {
            $error = array('status'=>-1,'errorMessage' => 'Parametri mancanti in recupero prezzi ajax!' ,'value'=>'');
            Logger::log(Logger::$ERROR, "[AjaxController] prezziAction' - Some parameters is missing");
            $this->response->addContent(json_encode($error));
        }
    }
    function statistichemaschiligooglechartAction(Request $request)
    {
        if($request->is_set('id'))
        {
            $idConcorso = $request->get("id");

            $DAOconcorsi = new concorsiDAO($this->connection);
            $statistiche = $DAOconcorsi ->getStatisticsByIdConcorso($idConcorso);


            if($statistiche)
            {
                $statTot = array();
                $TEMP = ['Task', 'Totali'];
                $statTot[] = $TEMP;
                foreach($statistiche as $statistic)
                {
                    if($statistic['sesso'] == 'M')
                    {
                        $TEMP = array();
                        $TEMP[] = $statistic['razza'];
                        $TEMP[] =intval($statistic['tot']);
                        $statTot[] = $TEMP;
                    }
                }
                $tatisticheValue = array('status'=>0,'errorMessage' => '' ,'value'=> $statTot);
                Logger::log(Logger::$DEBUG, "[Ajax call]  case:'statistiche' - Response JSON:".json_encode($tatisticheValue));
                $this->response->addContent(json_encode($tatisticheValue));
            }
            else
            {
                $error = array('status'=>-1,'errorMessage' => 'Errore recupero Statistiche' ,'value'=> '');
                Logger::log(Logger::$ERROR, "[Ajax call] case:'statistiche' -  Query not produced result");
                $this->response->addContent(json_encode($error));
            }
        }
        else
        {
            $error = array('status'=>-1,'errorMessage' => 'Parametri mancanti in recupero Statistiche ajax!' ,'value'=>'');
            Logger::log(Logger::$ERROR, "[Ajax call] case:'statistiche' - Some parameters is missing");
            $this->response->addContent(json_encode($error));
        }

    }
    function statistichetotaligooglechartAction(Request $request)
    {

        if($request->is_set('id'))
        {
            $idConcorso = $request->get("id");

            $DAOconcorsi = new concorsiDAO($this->connection);
            $statisticheTotali = $DAOconcorsi -> getStatisticsTotaliByIdConcorso ($idConcorso);
            if($statisticheTotali)
            {
                $statTot = array();
                $TEMP = ['Task', 'Totali'];
                $statTot[] = $TEMP;

                foreach($statisticheTotali as $statistic)
                {
                    $TEMP = array();
                    $TEMP[] = $statistic['razza'];
                    $TEMP[] =intval($statistic['tot']);
                    $statTot[] = $TEMP;
                }
                $tatisticheValue = array('status'=>0,'errorMessage' => '' ,'value'=> $statTot);
                Logger::log(Logger::$DEBUG, "[Ajax call]  case:'statistiche-totali' - Response JSON:".json_encode($tatisticheValue));
                $this->response->addContent(json_encode($tatisticheValue));
            }
            else
            {
                $error = array('status'=>-1,'errorMessage' => 'Errore recupero Statistiche totali' ,'value'=> '');
                Logger::log(Logger::$ERROR, "[Ajax call] case:'statistiche-totali' -  Query not produced result");
                $this->response->addContent(json_encode($error));
            }
        }
        else
        {
            $error = array('status'=>-1,'errorMessage' => 'Parametri mancanti in recupero Statistiche totali ajax!' ,'value'=>'');
            Logger::log(Logger::$ERROR, "[Ajax call] case:'statistiche-totali' - Some parameters is missing");
            $this->response->addContent(json_encode($error));
        }
    }

    function statistichefemminiligooglechartAction(Request $request)
    {

        if($request->is_set('id'))
        {
            $idConcorso = $request->get("id");

            $DAOconcorsi = new concorsiDAO($this->connection);
            $statisticheTotali = $DAOconcorsi -> getStatisticsTotaliByIdConcorso ($idConcorso);
            if($statisticheTotali)
            {
                $statTot = array();
                $TEMP = ['Task', 'Totali'];
                $statTot[] = $TEMP;

                foreach($statisticheTotali as $statistic)
                {
                    if($statistic['sesso'] == 'F')
                    {
                        $TEMP = array();
                        $TEMP[] = $statistic['razza'];
                        $TEMP[] =intval($statistic['tot']);
                        $statTot[] = $TEMP;
                    }
                }
                $tatisticheValue = array('status'=>0,'errorMessage' => '' ,'value'=> $statTot);
                Logger::log(Logger::$DEBUG, "[Ajax call]  case:'statistiche-totali' - Response JSON:".json_encode($tatisticheValue));
                $this->response->addContent(json_encode($tatisticheValue));
            }
            else
            {
                $error = array('status'=>-1,'errorMessage' => 'Errore recupero Statistiche totali' ,'value'=> '');
                Logger::log(Logger::$ERROR, "[Ajax call] case:'statistiche-totali' -  Query not produced result");
                $this->response->addContent(json_encode($error));
            }
        }
        else
        {
            $error = array('status'=>-1,'errorMessage' => 'Parametri mancanti in recupero Statistiche totali ajax!' ,'value'=>'');
            Logger::log(Logger::$ERROR, "[Ajax call] case:'statistiche-totali' - Some parameters is missing");
            $this->response->addContent(json_encode($error));
        }
    }

    function loggerAction(Request $request)
    {
        $logMex = "";
        if($request -> is_set('log'))
        {

            $logMex =$request -> get('log');

            $dayDirName = './log/frontend/'.date("Ymd");
            if(!file_exists($dayDirName))
            {
                //create day directory
                mkdir($dayDirName, 0777, true);
            }

            $contenuto = session_id()." - ".date("d/n/Y H:i:s")." - $logMex \n";
            $this -> writeLog($dayDirName."/", $contenuto);
        }
    }


    function writeLog($path, $contenuto)
    {
        $ip = $_SERVER['REMOTE_ADDR'];
        $filename = $path.'/LOG_'.$ip.".txt";


        // Let's make sure the file exists and is writable first.
        if(!file_exists($filename))
        {
            $fp = fopen($filename, 'w');
            fputs($fp, '');
            fclose($fp);
        }
        if (is_writable($filename))
        {

            // In our example we're opening $filename in append mode.
            // The file pointer is at the bottom of the file hence
            // that's where $somecontent will go when we fwrite() it.
            if (!$handle = fopen($filename, 'a'))
            {
                echo "Cannot open file ($filename)";
                exit;
            }

            // Write $somecontent to our opened file.
            if (fwrite($handle, mb_convert_encoding($contenuto,'iso-8859-2')) === FALSE)
            {
                echo "Cannot write to file ($filename)";
                exit;
            }

            //echo "Success, wrote to file ($filename)";
            fclose($handle);

        }
        else
        {
            echo "The file $filename is not writable";
        }
    }


}
