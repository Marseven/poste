<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

define('STATUT_TODO', 0);     // Largeur max de l'image en pixels
define('STATUT_PENDING', 1);
define('STATUT_DO', 2);
define('STATUT_PAID', 3);
define('STATUT_PAID_DELIVERY', 4);

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    static function month($month)
    {
        switch ($month) {
            case 1:
                $message = "Jan";
                return $message;
                break;
            case 2:
                $message = "Fev";
                return $message;
                break;
            case 3:
                $message = "Mar";
                return $message;
                break;
            case 4:
                $message = "Avr";
                return $message;
                break;
            case 5:
                $message = "Mai";
                return $message;
                break;
            case 6:
                $message = "Jui";
                return $message;
                break;
            case 7:
                $message = "Juil";
                return $message;
                break;
            case 8:
                $message = "Aou";
                return $message;
                break;
            case 9:
                $message = "Sept";
                return $message;
                break;
            case 10:
                $message = "Oct";
                return $message;
                break;
            case 11:
                $message = "Nov";
                return $message;
                break;
            case 12:
                $message = "Dec";
                return $message;
                break;
        }
    }
}
