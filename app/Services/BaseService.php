<?php
namespace App\Services;

use Illuminate\Database\DatabaseManager;
use Illuminate\Log\Logger;
use Prettus\Repository\Eloquent\BaseRepository;
use Throwable;

abstract class BaseService
{
    /**
     * @var DatabaseManager
     */
    protected DatabaseManager $databaseManager;

    /**
     * @var Logger
     */
    protected Logger $logger;

    /**
     * @var BaseRepository
     */
    protected BaseRepository $repository;

    public function __construct(DatabaseManager $databaseManager, Logger $logger, BaseRepository $repository)
    {
        $this->databaseManager = $databaseManager;
        $this->logger = $logger;
        $this->repository = $repository;
    }

    /**
     * Начать транзакцию.
     * @throws Throwable
     */
    protected function beginTransaction(): void
    {
        $this->databaseManager->beginTransaction();
    }

    /**
     * Откат транзакции.
     * @throws Throwable
     */

    protected function rollback(Throwable $e, string $message = '', array $context = []): bool
    {
        $this->databaseManager->rollBack();
        $this->handleException($e, $message, $context);

        return false;
    }

    /**
     * Обработчик исключений.
     */
    protected function handleException(Throwable $e, string $message = '', array $context = []): void
    {
        $this->logger->error($message, $context);
        $this->logger->error($e->getMessage(), ['exception' => $e]);
    }

    /**
     * Коммит транзакции.
     * @throws Throwable
     */
    protected function commit(): void
    {
        $this->databaseManager->commit();
    }

    /**
     * @param callable $callback
     * @return mixed
     * @throws Throwable
     */
    protected function runInTransaction(callable $callback): mixed
    {
        try {
            $this->beginTransaction();

            $result = $callback();

            $this->commit();
            return $result;
        } catch (Throwable $e) {
            $this->rollback($e);
            throw $e; // или можно вернуть ошибку, если нужно
        }
    }

    /**
     * Форматирование данных.
     */
    protected function formatData(array $data, string $key = 'data'): array
    {

        if (isset($data['data'])) {
            $data[$key] = $data['data'];
            unset($data['data']);
        }

        return $data;
    }

}
