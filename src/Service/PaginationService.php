<?php

namespace App\Service;

use Twig\Environment;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\RequestStack;

class PaginationService {
    private $entityClass;
    private $limit = 10;
    private $currentPage = 1;
    private $manager;
    private $twig;
    private $route;
    private $templatePath;

    public function __construct(ObjectManager $manager, Environment $twig, RequestStack $request, $templatePath ) {
        $this->route        = $request->getCurrentRequest()->attributes->get('_route');
        $this->manager      = $manager;
        $this->twig         = $twig;
        $this->templatePath = $templatePath;
    }

    public function setTemplatePath($templatePath) {
        $this->templatePath = $templatePath;

        return $this;
    }

    public function getTemplatePath() {
        return $this->templatePath;
    }

    public function setRoute($route) {
        $this->route = $route;

        return $this;
    }

    public function getRoute() {
        return $this->route;
    }

    public function display() {
        $this->twig->display($this->templatePath, [
            'page' => $this->currentPage,
            'pages' => $this->getPages(),
            'route' => $this->route
        ]);
    }

    public function getPages() {
        if(empty($this->entityClass)) {
            throw new \Exception("Vous n'avez pas spécifié l'entité sur laquelle nous devenons paginer ! Utilisez la méthode setEntityClass() de votre objet PaginationService.");
        }

        //Connaitre le total des enregistrements de la page
        $repo = $this->manager->getRepository($this->entityClass);
        $total = count($repo->findAll());

        //Faire la division, l'arrondi et le renvoyer
        $pages = ceil($total / $this->limit);

        return $pages;
    }

    public function getData() {
        if(empty($this->entityClass)) {
            throw new \Exception("Vous n'avez pas spécifié l'entité sur laquelle nous devenons paginer ! Utilisez la méthode setEntityClass() de votre objet PaginationService.");
        }
        // Calculer l'offset
        $offset = $this->currentPage * $this->limit - $this->limit;

        //Demander au repository de trouver les élements
        $repo = $this->manager->getRepository($this->entityClass);
        $data = $repo->findBy([], [], $this->limit, $offset);

        //Renvoyer les éléments en question
        return $data;
    }

    public function setPage($page) {
        $this->currentPage = $page;

        return $this;
    }

    public function getPage() {
        return $this->currentPage;
    }

    public function setLimit($limit) {
        $this->limit = $limit;

        return $this;
    }

    public function getLimit() {
        return $this->limit;
    }

    public function setEntityClass($entityClass) {
        $this->entityClass = $entityClass;

        return $this;
    }

    public function getEntityClass() {
        return $this->entityClass;
    }
}