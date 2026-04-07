<?php

namespace App\Traits;

use App\Models\AuditLog;

trait Auditable
{
    protected static function bootAuditable(): void
    {
        static::created(function ($model) {
            self::logAudit($model, 'created', null, $model->toArray());
        });

        static::updated(function ($model) {
            self::logAudit(
                $model,
                'updated',
                $model->getOriginal(),
                $model->getChanges()
            );
        });

        static::deleted(function ($model) {
            self::logAudit($model, 'deleted', $model->toArray(), null);
        });
    }

    protected static function logAudit($model, string $action, ?array $oldValues, ?array $newValues): void
    {
        // Éviter la récursion si AuditLog utilise aussi ce trait
        if ($model instanceof AuditLog) {
            return;
        }

        try {
            AuditLog::create([
                'user_id'    => auth()->id(),
                'model_type' => get_class($model),
                'model_id'   => $model->getKey(),
                'action'     => $action,
                'old_values' => $oldValues ? json_encode($oldValues) : null,
                'new_values' => $newValues ? json_encode($newValues) : null,
                'ip_address' => request()?->ip(),
                'user_agent' => request()?->userAgent(),
            ]);
        } catch (\Throwable $e) {
            // Log silencieusement — l'audit ne doit jamais bloquer l'opération
            logger()->warning('Audit log failed: ' . $e->getMessage());
        }
    }
}