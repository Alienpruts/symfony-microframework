<?php
/**
 * Created by PhpStorm.
 * User: bert
 * Date: 12/10/18
 * Time: 23:54
 */

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

class MicroController extends Controller
{
    /**
     * @Route("/random/{limit}", name="random-with-limit")
     */
    public function randomAction($limit)
    {
        $number = rand(0, $limit);

        return $this->render('micro/random.html.twig',[
            'number' => $number
        ]);
    }

}