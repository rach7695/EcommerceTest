<?php

namespace App\Controller;  //App = src

// /!\ PENSEZ A TOUJOURS IMPORTER LES CLASSES UTILISEES DANS LE FICHIER
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;  //importation 
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FrontController extends AbstractController  //heritage de abstractContoller 
{
    /**
     * ici: commentaire
     * 
     * Les annotations s'écrivent dans des commentaires
     * les annotations commencent par un arobaz @ pour etre interprétées
     * les annotations utilisentent des doubles quotes"" et le signe egal=
     * il y a 2 arguments obligatoires:
     * 1er: Route (URL)
     *      en local: 127.0.0.1:8000       /route   cad /front
     *      en ligne: www.nomDeDomaine.fr   /route
     * 2E: Nom de la Route (lien/redirection)
     * @Route("/front", name="frontName")
     *
      *  les attribut ne s'ecrivent pas dans des commentaires
     *    les attributs utilisent des simples quotes (') et le signe deux point (:)
     * uniquement pour php8/symfony6
    */

//#[Route('/front', name:'frontName')]
public function index(): Response  //response c'est une class qui permet de typer
{
    /*
          la route appelle la fonction qui se trouve en desous.
          une route peut avoir une vue ( cad: fichier visible sur le navigateur soit HTML)
          Pour retrourner une vue, on utilise la methode render() provenenat la class abstracController

          cette methose a 2 arguments: 
          1er obligatoire: (str= chaine de caractere) c'est le nom fichier html.twig situé dans le dossier 'templete', il faut également
          définir son arborescence dans ce dossier
          (la methode render() nous positionne directement à la racine du dossier 'templete')

          2e facultatif: (array) c'est le tableau des donnees à vehiculer a la vue
    */
return $this->render('front/index.html.twig',[]);
}



/**
 * PAGE PRINCIPALE DU SITE
 * @Route("", name="homeName")
 * 
 */




public function home():Response
{
    $prenomController = 'rach';  //creer variable controller
    dump($prenomController);  //dump = c'est pour debugger. le dump s'affiche dans le symfony profiler (cible) on peut placer des variables, des tableax et des oblets
     
    $prenomComtroller = 'cedric';
    //dump ($prenomController);die; => die permet d'arreter la lecteur du code
    //dd('fin'); // dd() = dump die

    $array = ['kiwi', 'fraise', 'pomme'];
    dump($array);
    return $this->render('front/home.html.twig',
    [
         //key => value
         // key : nom de la variable en twig //denomination récupéré en twig
         // value: nom de la varibale php // denomination dans la fonction controller
     'prenomTwig' => $prenomController
    ]);
}

/*
        Exercice :

        Créer dans FrontController une nouvelle route

        1- Créer la route (annotation)
            -> Route           : /home
            -> Nom de la route : homeName

        2- Créer la fonction associée à cette route
            -> function home()

        3- Créer un template dans le dossier front
            -> home.html.twig 

        4- Retourner ce template dans la fonction home()

        ==> aller voir sur la navigateur 127.0.0.1:8000/home

        5- Dans le template : 
            - héritez de la base.html.twig 
            - intégrez le block h1 : Page d'accueil
            - intégrez le block body dans lequel vous allez afficher l'image 

    */





}
