<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Form\ProduitType;
use App\Repository\ProduitRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/** 
 * 
*/



class ProduitController extends AbstractController
{
//ce controller va contenir toutes les routes du CRUD produit

    /**
    * Cette route va recuperer tous les produits en base de données
    *=>REQUETE SQL SELECT
    * 
    * @Route("/produit/afficher", name="produit_afficher")
    */
    
    public function produit_affiche(ProduitRepository $produitRepository):Response 
    {
    /*
    Lorsqu'on cree une entity (=table), est genere en meme temps son repository,
    celui ci permet de faire des requetes dans cette table. 

    la fonction produit_afficher() a besoin d'un objet de la calss ProduitRepository
    c'est donc une DEPENDANCE

    Pour creer des dépendances, on les écrit dans les parentheses de la fonction syntaxe: class $objet
    */

    $produits= $produitRepository->findAll();  //SELECT * FROM produit RECUPERE TOUS LES PRODUITS DE LA TABLES PRODUITS
    //la méthode finAll retourne un tableau d'ibjet
    //dd($produits);
         return $this->render('produit/produit_afficher.html.twig',[
    'produits' =>$produits

    //'produit' va passer sur le fichier produit_afficher.twig
         ]);
    }

    /**
     * la route produit ajouter permet de crrer des produits en base de données
     * on utilise un formuliare
     * 
     * requete INSERT INTO
     * 
    * @Route("/produit/ajouter", name="produit_ajouter")
    */
    public function produit_ajouter(Request $request, EntityManagerInterface $em):response
    {
        $produit = new Produit(); //instancier de la class produit/il herite tout ce quil ya dans produitType.php
        dump($produit);
        //$produit->setTitre('bague en or');
        //dd($produit);

        /*
        pour creer un formulaire, on utilise la methose createFrom() provenant la class AbstractController
        1er argumet: le nom de la class contenant le $builder dans le fichier ProduitType.php
        2eme argument; l'objet issu de l'entity Produit

        la class ProduitType et l'objet $produit sont tous les 2 issu de la class (entity) produit
         */

        $form = $this->createForm(ProduitType::class, $produit); //creer un formulaire en ce basant sur produitttype.php
       //$from est un objet, il contient des propriétés et des méthodes


      //traitement du formulaire
       $form->handleRequest($request);

       //si le formuliare est soumis et s'il est valide (respect des contraintes)
       if ($form->isSubmitted() && $form->isValid()){
        //INSERTION EN BDD
        dump($produit);
       /*
       Pour inserer, modifier ou supprimer en base de données, on utilise un objet de la 
       class EntityManagerInterface
       */
        $em->persist($produit); //insertion de quel objet donc on veut inserer la table produit
        $em->flush(); //execution
        //dd($produit);
        //la methode redirectToRoute() permet de rediriger (equivalent à la fonction twig path())
        return $this->redirectToRoute('produit_afficher');
        

       }


        return $this->render('produit/produit_ajouter.html.twig',[
            'formProduit' => $form->createView() //creation du code html du formuliare en envoyer sur ma vue et aller sur le fichier produit_ajouter.html;twig pour afficher le formulaire
        ]);
    }

    /**
     * @Route ("/produit/fiche/{id}", name="produit_fiche")
     */

     public function produit_fiche(produit $produit): Response
    {
        dump($produit);
        return $this->render('produit/produit_fiche.html.twig',[
            'produit' => $produit
        ]);
    }

     /**
 * 
 * @Route("/produit/modifier/{id}",name="produit_modifier")
 * 
 */
public function produit_modifier(produit $produit, Request $request, EntityManagerInterface $em):Response

{
    /**on constacte que pour ajouter et modifier un produit, c'est le meme code à l'exception  de l'objet $produit
     * pour ajouter, on genere un nouvel objet
     * pour modifier, on recupere un objet en bdd, un objet deja existant(grace au parametre)
     * 
    */
    $form=$this->createForm(ProduitType::class,$produit);
    $form->handleRequest($request);

    if($form->isSubmitted() AND $form->isValid()){
        $em->flush();
        return $this->redirectToRoute('produit_afficher');
    }

    return $this->render('produit/produit_modifier.html.twig',['produit'=>$produit,
    'formProduit'=>$form->createView()
]);
}
/**
 * @Route("/produit/supprimer/{id}", name="produit_supprimer")
 */

 public function produit_supprimer(Produit $produit, EntityManagerInterface $em)
 {
    $em->remove($produit);
    $em->flush();
    return $this->redirectToRoute('produit_afficher');
    
 }

 /*
 Modem (M)
 Entity = table
 repository requete SELECT
 entityManagerinterface = requetes INSERT into / UPDATE DELETE

 */



}//fermeture de la class


/*Créer un nouveau controller
-> ProduitController    sur le terminal pour creer le contoller php bin/console make:contoller

(la route créée par défaut est à supprimer)  je supprime l'attribut route

- Créer la route sous annotation
	- Route /produit/afficher
    - Nom de la route produit_afficher
    
- Créer la fonction (associée à cette route) produit_afficher()

- Créer le fichier produit_afficher.html.twig à placer dans le dossier produit

- la fonction produit_afficher() doit retounée le template produit_afficher.html.twig

(aller sur le navigateur sur /produit/afficher)

- dans le template : héritage de la base.html.twig définir les block h1 (Gestion des produits) et le block body

- dans la nav, ajouter un nouvel onglet qui redirige sur cette nouvelle route*/



/* 2eme excercice
Dans ProduitController

Créer une nouvelle route 
	- Route : "/produit/ajouter"
    - Nom de la route : "produit_ajouter"
    
Template : produit/produit_ajouter.html.twig

h1 : Ajouter un produit

Pour accéder à cette nouvelle route c'est depuis le template de la route produit_afficher

<a class="btn btn-dark" href="">Ajouter</a>


Sur le template produit_ajouter.html.twig, ajouter également une redirection pour revenir sur la route produit_afficher
*/
