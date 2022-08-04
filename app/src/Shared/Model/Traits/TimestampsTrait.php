<?php

namespace Finconsult\Documentor\Shared\Model\Traits;

use Doctrine\ORM\Mapping as ORM;

trait TimestampsTrait
{
    #[ORM\Column(
        type: 'datetime',
        insertable: false,
        updatable: false,
        columnDefinition: 'TIMESTAMP DEFAULT CURRENT_TIMESTAMP',
        generated: 'ALWAYS'
    )]
    private \DateTime $createdAt;

    #[ORM\Column(
        type: 'datetime',
        insertable: false,
        updatable: false,
        columnDefinition: 'TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP',
        generated: 'ALWAYS'
    )]
    private \DateTime $updatedAt;

    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): \DateTime
    {
        return $this->updatedAt;
    }

    /**
     * Инициализирует временные метки. ДОЛЖЕН быть использован в конструкторе!
     */
    private function initTimestamps(): void
    {
        $this->createdAt = new \DateTime();
        $this->updatedAt = new \DateTime();
    }
}
