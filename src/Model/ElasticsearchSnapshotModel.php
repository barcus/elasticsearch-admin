<?php

namespace App\Model;

use App\Model\AbstractAppModel;

class ElasticsearchSnapshotModel extends AbstractAppModel
{
    private $name;

    private $repository;

    private $indices;

    private $ignoreUnavailable;

    private $partial;

    private $includeGlobalState;

    private $version;

    private $failures;

    private $state;

    private $startTime;

    private $endTime;

    private $duration;

    public function __construct()
    {
        $this->includeGlobalState = true;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getRepository(): ?string
    {
        return $this->repository;
    }

    public function setRepository(?string $repository): self
    {
        $this->repository = $repository;

        return $this;
    }

    public function getIndices(): ?array
    {
        return $this->indices;
    }

    public function setIndices(?array $indices): self
    {
        $this->indices = $indices;

        return $this;
    }

    public function getIgnoreUnavailable(): ?bool
    {
        return $this->ignoreUnavailable;
    }

    public function setIgnoreUnavailable(?bool $ignoreUnavailable): self
    {
        $this->ignoreUnavailable = $ignoreUnavailable;

        return $this;
    }

    public function getPartial(): ?bool
    {
        return $this->partial;
    }

    public function setPartial(?bool $partial): self
    {
        $this->partial = $partial;

        return $this;
    }

    public function getIncludeGlobalState(): ?bool
    {
        return $this->includeGlobalState;
    }

    public function setIncludeGlobalState(?bool $includeGlobalState): self
    {
        $this->includeGlobalState = $includeGlobalState;

        return $this;
    }

    public function getVersion(): ?string
    {
        return $this->version;
    }

    public function setVersion(?string $version): self
    {
        $this->version = $version;

        return $this;
    }

    public function getFailures(): ?array
    {
        return $this->failures;
    }

    public function setFailures(?array $failures): self
    {
        $this->failures = $failures;

        return $this;
    }

    public function getState(): ?string
    {
        return $this->state;
    }

    public function setState(?string $state): self
    {
        $this->state = $state;

        return $this;
    }

    public function getStartTime(): ?string
    {
        return $this->startTime;
    }

    public function setStartTime(?string $startTime): self
    {
        $this->startTime = $startTime;

        return $this;
    }

    public function getEndTime(): ?string
    {
        return $this->endTime;
    }

    public function setEndTime(?string $endTime): self
    {
        $this->endTime = $endTime;

        return $this;
    }

    public function getDuration(): ?string
    {
        return $this->duration;
    }

    public function setDuration(?string $duration): self
    {
        $this->duration = $duration;

        return $this;
    }

    public function convert(?array $snapshot): self
    {
        $this->setName($snapshot['snapshot']);
        $this->setRepository($snapshot['repository']);

        if (true == isset($snapshot['version'])) {
            $this->setVersion($snapshot['version']);
        }

        if (true == isset($snapshot['state'])) {
            $this->setState($snapshot['state']);
        }

        if (true == isset($snapshot['start_time'])) {
            $this->setStartTime($snapshot['start_time']);
        }

        if (true == isset($snapshot['end_time'])) {
            $this->setEndTime($snapshot['end_time']);
        }

        if (true == isset($snapshot['duration_in_millis'])) {
            $this->setDuration($snapshot['duration_in_millis']);
        }

        if (true == isset($snapshot['failures'])) {
            $this->setFailures($snapshot['failures']);
        }

        return $this;
    }

    public function getJson(): array
    {
        $json = [
            'ignore_unavailable' => $this->getIgnoreUnavailable(),
            'partial' => $this->getPartial(),
            'include_global_state' => $this->getIncludeGlobalState(),
        ];

        if ($this->getIndices()) {
            $json['indices'] = implode(',', $this->getIndices());
        }

        return $json;
    }
}
