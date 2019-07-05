<?php

namespace AppBundle\Form;

use AppBundle\Entity\Category;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;






class PostsType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', TextType::class, ['attr'=> array('class'=>'form-control')])

        ->add('category', EntityType::class,
            [
                'class' => Category::class,
                'choice_label' => 'name',
                'attr'=> array('class'=>'form-control')
            ]
        )

        ->add('content', TextareaType::class, ['attr'=> array('class'=>'form-control')])

        ->add('file', FileType::class, array('data_class' => null,'attr' => array(
            'required'=>'false'
        )));
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Posts'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_posts';
    }


}
