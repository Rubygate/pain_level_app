<?php

namespace App\Form;

use App\Entity\Patient;
use App\Entity\PatientReport;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\ChoiceList\ChoiceList;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PatientReportType extends AbstractType
{
    public function getPainLevel(){
        return [
            "0 - No Pain" => 0,
            "1" => 1,
            "2" => 2,
            "3" => 3,
            "4" => 4,
            "5" => 5,
            "6" => 6,
            "7" => 7,
            "8" => 8,
            "9" => 9,
            "10 - Worst Pain Imaginable" => 10,
        ];
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder

            ->add('painLevel',ChoiceType::class,
                [
                    'label' => 'Rate your pain level between 0-10 below:',
                    'attr' => [
                        'class' => 'form-control',
                    ],
                    'choices' => $this->getPainLevel(),
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => PatientReport::class,
        ]);
    }
}
