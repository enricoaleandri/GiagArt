<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Enrico
 * Date: 10/12/12
 * Time: 18.30
 * To change this template use File | Settings | File Templates.
 */
class QueryBuilder
{
    private $query;
    private $listPoint;
    private $index;
    function __construct($query)
    {
        $this -> query = $query;
        $this-> index = 0;
        //creo un array che conterra tutte le posizioni dei punti esclamativi, cosi
        //da poterli usare nei metodi setString e setInt
        $this-> listPoint = array();

        //Scorro tutta la query memorizzando ogni volta la prima occorrenza del !
        //e sostituendolo successivamente con una @ ( carattere a scopo riempitivo )
        //che serve, 1 a mantenere inaltera
        for($i = 0 ; strpos($this -> query, "!") !== false; $i++)
        {
            $ind = strpos($this -> query, "!");
            $this-> listPoint[$i]=$ind;

            $str_1 = substr($this -> query, 0, $ind);
            $str_2 = substr($this -> query , $ind +1 , strlen($this->query) - $ind +1);

            $this->query =$str_1."@".$str_2;

        }
    }


    function setString($parameter)
    {
        if($this->index < count($this->listPoint))
        {
            $indice = $this->listPoint[$this->index];
            $this->index++;

            $str_1 = substr($this -> query, 0, $indice);
            $str_2 = substr($this -> query , $indice +1 , strlen($this->query) - $indice +1);

            if(strtolower($parameter) == "null")
            {
                $this -> query = $str_1.' '.$parameter.' '.$str_2;
            }
            else
            {
                $this -> query = $str_1.'"'.$parameter.'"'.$str_2;
            }

            for($i = $this->index; $i < count($this->listPoint);$i++)
            {
                $this->listPoint[$i]+=strlen($parameter)+1;
            }
            //echo "$parameter<br>SetString() = ".$this->toQuery()." --- ".$this->index."<br><br><br>";

        }

    }

    function setInt($parameter)
    {
        if($this->index < count($this->listPoint))
        {
            $indice = $this->listPoint[$this->index];
            $this->index++;

            $str_1 = substr($this -> query, 0, $indice);

            $str_2 = substr($this -> query , $indice +1 , strlen($this->query) - $indice +1);


            $this -> query = $str_1.$parameter.$str_2;


            for($i = $this->index; $i < count($this->listPoint);$i++)
            {
                $this->listPoint[$i]+=strlen($parameter)-1;
            }

            //echo "$parameter<br>SetString() = ".$this->toQuery()." --- ".$this->index."<br><br><br>";
        }

    }

    function setNULL()
    {
        if($this->index < count($this->listPoint))
        {
            $indice = $this->listPoint[$this->index];
            $this->index++;

            $str_1 = substr($this -> query, 0, $indice);

            $str_2 = substr($this -> query , $indice +1 , strlen($this->query) - $indice +1);


            $this -> query = $str_1."NULL".$str_2;


            for($i = $this->index; $i < count($this->listPoint);$i++)
            {
                $this->listPoint[$i]+=strlen("NULL")-1;
            }

            //echo "$parameter<br>SetString() = ".$this->toQuery()." --- ".$this->index."<br><br><br>";
        }

    }

    function setTable($tableName)
    {
        if($this->index < count($this->listPoint))
        {
            $indice = $this->listPoint[$this->index];
            $this->index++;
            $str_1 = substr($this -> query, 0, $indice);

            $str_2 = substr($this -> query , $indice +1 , strlen($this->query) - $indice +1);


            $this -> query = $str_1.$tableName.$str_2;
            for($i = $this->index; $i < count($this->listPoint);$i++)
            {
                $this->listPoint[$i]+=strlen($tableName)-1;
            }

            //echo "$parameter<br>SetString() = ".$this->toQuery()." --- ".$this->index."<br><br><br>";
        }

    }

    function toQuery()
    {
        return $this -> query;
    }
}

?>