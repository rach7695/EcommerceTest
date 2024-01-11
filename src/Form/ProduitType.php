<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Produit;
use Doctrine\DBAL\Types\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ColorType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Positive;

class ProduitType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder  //plan de contruction du formulaire
            ->add('titre', TextareaType::class, [ //si textType use Symfony\Component\Form\Extension\Core\Type\TextType;
                     'help' => 'le titre du produit doit etre compris entre 5 et 20',
                     'help_attr' =>[
                        'class' => 'text-info fst-italic'
                     ],

                     'label_attr' => [
                        'class' => 'text-success'
                     ],

                     'row_attr' => [
                        'class' => 'shadow p-3 bg-white'
                     ],
                    'required' => false,
                     'constraints' => [
                        new NotBlank([
                            'message' => 'veuillez saissir le titre du produit'
                        ]),
                        new Length([
                           'min' => 5,
                           'max' => 20,
                           'minMessage' => 'Veuillez saisir au moins 5 caractères',
                           'maxMessage' => 'Veuillez saisir au moins 20 caractères',
                        ])
                     ]
            ]) 
                        
            
                    

                
            ->add('prix', MoneyType::class, [
                 //k => v
                'label' => 'prix du produit',  //pour les allez dans la doc de symfony.com/doc/current/reference/forms/type
                'attr' => [
                    'placeholder' => 'saisir le prix du produit',
                    'class' => 'inputCyan border  border-danger'
                ],
                'required' => false,

                     'constraints' => [
                        new NotBlank([
                            'message' => 'veuillez saisir le prix du produit'
                        ]),
                        new Positive([
                            'message' => 'Veuillez saisir un prix supérieur à zéro'
                        ])
                     ]   

            ])
            

            ->add('description', null, [//->add('ajouter', submitType::class)
                  'label' => 'Description (Falcultative)',
                  'constraints' => [
                    new Length([
                        'max' => 200,
                        'maxMessage' => 'Veuillez saisir moins de 200 caratères'
                    ])
                    
                  ]

            ])  

            ->add('category', EntityType::class, [
                'class' => Category::class, // Nom de la class en relation (à importer)
                'choice_label' => 'nom',     // Nom de la propriété à afficher dans le formulaire

                
                'placeholder' => 'Saisir une catégorie',
                'required' => false,
                // 'multiple' => true; pour ManyToMany uniquement
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez saisir la catégorie du produit'
                    ]),
                ]

            ])

            // pour le relation ManyToMany, il faut rajouter l'option:
            // 'multiple' => true

            // ->add('ajouter'), submitType::class)
        ;

        /*l'objet $builder permet de construire le formulaire
        chaque methode add() va correspondre à un element du formulaire

        3 argument dans la methode add()
            1-(string) nom de la propriété dans l'entity (si le formuliare est lié à une entity)
            2-(class ou null)  definir le type de l'element cela veut qu est ce qu'ont veut ( date text chexbox...)
            3- (array) tableau des option 
                    il y a 2 genre d 'option:
                       -options communes a ttes les class (2eme argument)
                       -options propre à une class



            ------------------------
            en html, il y a 3 types de balises pour le formuliare:
                - select
                - textarea
                _ input type: text, password, files, hidden, date, color, number, checkbox, radio...
        */
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Produit::class,
        ]);
    }
}
