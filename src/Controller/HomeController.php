<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController {

    /**
     * @Route("/salut/{prenom}/{age}", name="hello")
     * Montre la page qui dit bonjour
     * 
     * @return void;
     */
    public function hello($prenom = 'Inconnu', $age = 0) {
        return $this->render(
            'hello.html.twig',
            [
                'prenom' => $prenom,
                'age' => $age
            ]
        );
    }

    /**
     * @Route("/", name="homepage")
     */
    public function home() {
        $prenoms = ['Lionel' => 12, 'Jey' => 15, 'Quentih' => 25];

        return $this->render(
            'home.html.twig', 
            [
                'title' => "Aurevoir tout le monde !",
                'age' => 12,
                'tableau' => $prenoms
                ]

        );
    }
}

?>