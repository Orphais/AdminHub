<?php

namespace App\Form\Product\Step;

use App\Form\Product\Data\LicenseData;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class ProductLicenseStepType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('licenseKey', TextType::class, [
                'label' => 'Clé de licence',
            ])
            ->add('downloadUrl', UrlType::class, [
                'label' => 'URL de téléchargement',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => LicenseData::class,
        ]);
    }
}
