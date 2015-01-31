<?php
class Routing
{
    public function getAction(Request $request)
    {
        switch ($request->get('action'))
        {
            case 'home' : return new HomeAction();
            default     : return new NotAviableAction();
        }
    }
}
