<?php

namespace BlogBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\ORM\EntityRepository;

class BlogPostType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('content')
            ->add('createdAt')
            ->add('categories', EntityType::class, array(
                'class' => 'BlogBundle:Category',
                'expanded' => true,
                'multiple' => true,
                'choice_value' => 'id', // Opsiyoneldir. Selectbox,
                // Checkboxta vb.de value'nın hangi property olmasını istiyorsanız onu yazmalısınız.
                'choice_label' => 'name',
                
            ))
            ->add('save', SubmitType::class, array('label' => 'Save Post'));
    }
}