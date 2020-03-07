<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Core\Serializer\Filter\GroupFilter;
use App\Entity\Traits\Accessor;
use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Contract\Entity as BehaviorEntity;
use Knp\DoctrineBehaviors\Model as BehaviorModel;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * The IndicatorValue entity.
 *
 * @ApiResource(
 *     shortName="Value",
 *     normalizationContext={
 *         "groups"={"indicator_value:output"}
 *     },
 *     denormalizationContext={
 *         "groups"={"indicator_value:input"}
 *     }
 * )
 * @ApiFilter(
 *     GroupFilter::class,
 *     arguments={
 *         "parameterName"="with",
 *         "overrideDefaultGroups"=false,
 *         "whitelist"={"indicators"}
 *     }
 * )
 * @ORM\Entity
 */
class IndicatorValue implements BehaviorEntity\TimestampableInterface
{
    use Accessor\Id;
    use Accessor\Date;
    use BehaviorModel\Timestampable\TimestampableTrait;

    /** Types of Indicator/Values presets */
    const PRESET_LATEST = 'latest';

    /**
     * @var int The entity Id
     * @Groups({"indicator_value:output"})
     * @ORM\Id
     * @ORM\GeneratedValue
     * @Groups({"values", "indicator_value:output"})
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var
     * @ApiProperty(
     *     description="The date on which the value is recorded."
     * )
     * @Groups({"values", "indicator_value:output", "indicator_value:input"})
     * @ORM\Column(type="date")
     * @Assert\NotBlank
     * @Assert\Date
     */
    private $date;

    /**
     * @var float
     * @ApiProperty(
     *     description="A numeric value of an indicator."
     * )
     * @Groups({"values", "indicator_value:output", "indicator_value:input"})
     * @ORM\Column(type="float")
     */
    private $value;

    /**
     * @var string
     * @ApiProperty(
     *     description="The source URL of the value."
     * )
     * @Groups({"values", "indicator_value:output", "indicator_value:input"})
     * @ORM\Column(type="text")
     */
    private $sourceUrl;

    /**
     * @var Indicator
     * @ApiProperty(
     *     description="The related indicator"
     * )
     * @ApiFilter(SearchFilter::class, properties={"indicator": "exact", "indicator.id": "exact"})
     * @Groups({"indicators", "indicator_value:input"})
     * @ORM\ManyToOne(targetEntity="Indicator", inversedBy="values")
     * @ORM\JoinColumn(onDelete="CASCADE")
     * @Assert\NotBlank
     */
    private $indicator;

    /**
     * @return string
     */
    public function getSourceUrl(): string
    {
        return $this->sourceUrl;
    }

    public function getValue(): float
    {
        return $this->value;
    }

    public function setValue(float $value): self
    {
        $this->value = $value;

        return $this;
    }

    public function setSourceUrl(string $sourceUrl): self
    {
        $this->sourceUrl = $sourceUrl;

        return $this;
    }

    /**
     * @return Indicator
     */
    public function getIndicator(): ?Indicator
    {
        return $this->indicator;
    }

    public function setIndicator(Indicator $indicator): self
    {
        $this->indicator = $indicator;

        return $this;
    }
}
