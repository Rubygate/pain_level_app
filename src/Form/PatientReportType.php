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
        return range(1,11);
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder

            ->add('painLevel',ChoiceType::class,
                [
                    'label' => 'Rate your pain level between 1-10 below:',
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
