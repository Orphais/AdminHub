<?php

namespace App\Form\Product\Data;

use Symfony\Component\Validator\Constraints as Assert;

class LicenseData
{
    #[Assert\NotBlank(groups: ['Default', 'license'])]
    public ?string $licenseKey = null;

    #[Assert\Url(groups: ['Default', 'license'])]
    public ?string $downloadUrl = null;
}
