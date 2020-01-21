<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

use App\Entity\Traits\Accessor;

/**
 * The Indicator entity.
 *
 * @ApiResource(
 *     normalizationContext={
 *         "groups"={"indicator:output"}
 *     },
 *     denormalizationContext={
 *         "groups"={"indicator:input"}
 *     }
 * )
 * @ORM\Entity
 * @package App\Entity
 */
class Indicator {

    use Accessor\Id;
    use Accessor\Name;

    /**
     * @var int The entity Id
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string
     * @ApiProperty(
     *     description="The indicator's name."
     * )
     * @Groups({"indicator:output", "indicator:input"})
     * @ORM\Column
     * @Assert\NotBlank
     */
    private $name;

    /**
     * @var string
     * @ApiProperty(
     *     description="The source organization."
     * )
     * @Groups({"indicator:output", "indicator:input"})
     * @ORM\Column
     * @Assert\NotBlank
     */
    private $organization;

    /**
     * @var array
     * @ApiProperty(
     *     description="One or more values of the indicator."
     * )
     * @Groups({"indicator:output", "indicator:input"})
     * @ORM\OneToMany(targetEntity="IndicatorValue", mappedBy="indicator")
     */
    private $values;

    /**
     * @var Country
     * @ApiProperty(
     *     description="The target country."
     * )
     * @Groups({"indicator:output", "indicator:input"})
     * @ORM\ManyToOne(targetEntity="Country", inversedBy="indicators")
     * @Assert\NotBlank
     */
    private $country;

    /**
     * Indicator constructor.
     */
    public function __construct() {
        $this->values = [];
    }

    /**
     * @return string
     */
    public function getOrganization(): string {
        return $this->organization;
    }

    /**
     * @param string $organization
     * @return self
     */
    public function setOrganization(string $organization): self {
        $this->organization = $organization;
        return $this;
    }

    /**
     * @return array
     */
    public function getValues() {
        return $this->values;
    }

    /**
     * @param array $values
     * @return self
     */
    public function setValues(array $values): self {
        $this->values = $values;
        return $this;
    }

    /**
     * @return Country
     */
    public function getCountry(): ?Country {
        return $this->country;
    }

    /**
     * @param Country $country
     * @return self
     */
    public function setCountry(Country $country): self {
        $this->country = $country;
        return $this;
    }
}
