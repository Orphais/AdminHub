<?php

namespace App\Form\Product;

use App\Form\Product\Data\TypeData;
use App\Form\Product\Data\DetailsData;
use App\Form\Product\Data\LogisticsData;
use App\Form\Product\Data\LicenseData;
use Symfony\Component\Validator\Constraints as Assert;

class ProductFlowData
{
    public string $currentStep = 'type';

    #[Assert\Valid(groups: ['type'])]
    public TypeData $type;

    #[Assert\Valid(groups: ['details'])]
    public DetailsData $details;

    #[Assert\Valid(groups: ['logistics'])]
    public LogisticsData $logistics;

    #[Assert\Valid(groups: ['license'])]
    public LicenseData $license;

    public function __construct()
    {
        $this->type = new TypeData();
        $this->details = new DetailsData();
        $this->logistics = new LogisticsData();
        $this->license = new LicenseData();
    }
}
