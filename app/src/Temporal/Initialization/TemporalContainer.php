<?php

namespace App\Temporal\Initialization;

use App\Temporal\ActivityInterface;

class TemporalContainer
{
    private array $workflowTypes = [];
    private array $activityImplementations = [];

    /**
     * @return string[]
     */
    public function getWorkflowTypes(): array
    {
        return $this->workflowTypes;
    }

    public function addWorkflowType(string $workflowClass): void
    {
        if (!in_array($workflowClass, $this->workflowTypes)) {
            $this->workflowTypes[] = $workflowClass;
        }
    }

    /**
     * @return ActivityInterface[]
     */
    public function getActivityImplementations(): array
    {
        return $this->activityImplementations;
    }

    public function addActivityImplementation(ActivityInterface $activity): void
    {
        if (!array_key_exists($activity::class, $this->activityImplementations)) {
            $this->activityImplementations[$activity::class] = $activity;
        }
    }
}
