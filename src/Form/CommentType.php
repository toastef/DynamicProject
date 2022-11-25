<?php

namespace App\Form;

use App\Entity\Comment;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CommentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' =>'titre',
                'attr' => [
                    'placeholder' => 'Titre',
                ],
            ])
            ->add('rating' , IntegerType::class, [
                'label' => 'Votre note',
                'attr' => [
                    'placeholder' => ' votre note de 0 à 5',
                ],
            ] )
            ->add('comment', TextareaType::class,
            [
                'label'=> 'comment',
                'attr' => ['placeholder' => 'Commentaire',],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Comment::class,
        ]);
    }
}
