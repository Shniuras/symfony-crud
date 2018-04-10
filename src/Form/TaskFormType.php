<?php

namespace App\Form;

use App\Entity\Task;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TaskFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class)
            ->add('priority', ChoiceType::class, [
                'choices' => [
                    'Low' => Task::PRIORITY_LOW,
                    'Medium' => Task::PRIORITY_MEDIUM,
                    'High' => Task::PRIORITY_HIGH
                ]
            ])
            ->add('status', ChoiceType::class, [
                'choices' => [
                    'Pending' => Task::STATUS_PENDING,
                    'In Progress' => Task::STATUS_IN_PROGRESS,
                    'Done' => Task::STATUS_DONE
                ]
            ])
            ->add('deadline', DateType::class)
            ->add('createdAt', DateTimeType::class)
            ->add('save', SubmitType::class, array('label' => 'Submit'));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Task::class,
        ]);
    }
}
