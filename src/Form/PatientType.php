<?php

namespace App\Form;

use App\Entity\Patient;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\ChoiceList\ChoiceList;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PatientType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstName', TextType::class, [
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('lastName', TextType::class, [
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('contactPhone', TelType::class, [
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('email', EmailType::class, [
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('monitoringStartDate', DateType::class,
                [
                    'label' => 'Monitoring Start Date',
                    'widget' => 'single_text',
                    'html5' => true,
                    'input' => 'datetime',
                    'attr' => [
                        'class' => 'form-control datepicker',
                    ]
                ]
            ) ->add('monitoringEndDate', DateType::class,
                [
                    'label' => 'Monitoring End Date',
                    'widget' => 'single_text',
                    'html5' => true,
                    'input' => 'datetime',
                    'attr' => [
                        'class' => 'form-control datepicker',
                    ]
                ]
            )
            ->add('reminderInterval',IntegerType::class,
                [
                    'label' => 'Reminder Frequency',
                    'attr' => [
                        'class' => 'form-control',
                    ]

                ]
            )
            ->add('intervalType',ChoiceType::class,
                [
                    'label' => 'Period',
                    'attr' => [
                        'class' => 'form-control',
                    ],
                    'choices' => [
                        'Day' => 'day',
                        'Weekly' => 'weekly'
                    ],
                    'mapped' => false
                ]
            )
            ->add('prescribedMedication', TextareaType::class, [
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('painBaseline', ChoiceType::class, [
                'choices' => array_combine(range(0,10), range(0,10)),
                'attr' => [
                    'class' => 'form-control'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Patient::class,
        ]);
    }
}
