<?php

namespace App\Form\Product;

use App\Form\Product\Step\ProductTypeStepType;
use App\Form\Product\Step\ProductDetailsStepType;
use App\Form\Product\Step\ProductLogisticsStepType;
use App\Form\Product\Step\ProductLicenseStepType;
use App\Form\Product\Step\ProductConfirmationStepType;
use Symfony\Component\Form\Flow\AbstractFlowType;
use Symfony\Component\Form\Flow\DataStorage\SessionDataStorage;
use Symfony\Component\Form\Flow\FormFlowBuilderInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductFlowType extends AbstractFlowType
{
    public function __construct(
        private readonly RequestStack $requestStack,
    ) {
    }

    public function buildFormFlow(FormFlowBuilderInterface $builder, array $options): void
    {
        $builder
            ->addStep('type', ProductTypeStepType::class)
            ->addStep('details', ProductDetailsStepType::class)
            ->addStep('logistics', ProductLogisticsStepType::class, skip: fn(ProductFlowData $data) => $data->type->type !== 'physical')
            ->addStep('license', ProductLicenseStepType::class, skip: fn(ProductFlowData $data) => $data->type->type !== 'digital')
            ->addStep('confirmation', ProductConfirmationStepType::class);

        $builder->add('navigator', ProductNavigatorType::class);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ProductFlowData::class,
            'step_property_path' => 'currentStep',
            'data_storage' => new SessionDataStorage('product_flow', $this->requestStack),
        ]);
    }
}
