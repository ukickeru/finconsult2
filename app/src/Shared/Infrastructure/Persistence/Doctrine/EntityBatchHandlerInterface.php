<?php

namespace Finconsult\Documentor\Shared\Infrastructure\Persistence\Doctrine;

interface EntityBatchHandlerInterface
{
    /**
     * Помечает сущности для последующего сохранения.
     */
    public function markToBatchSave(object ...$entities): void;

    /**
     * Сохраняет сущности одной транзакцией.
     */
    public function batchSave(object ...$entities): void;

    /**
     * Помечает сущности для последующего удаления.
     */
    public function markToBatchDelete(object ...$entities): void;

    /**
     * Удаляет сущности одной транзакцией.
     */
    public function batchDelete(object ...$entities): void;
}
