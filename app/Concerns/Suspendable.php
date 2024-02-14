<?php

namespace App\Concerns;

use App\Notifications\AccountSuspended;
use App\Notifications\AccountUnsuspended;

trait Suspendable
{
    /**
     * Account is banned for lifetime.
     */
    public function isBanned(): bool
    {
        return $this->suspended_at && ! $this->suspension_ends_at;
    }

    /**
     * Account is suspended for some time.
     */
    public function isSuspended(): bool
    {
        return $this->suspended_at && $this->suspension_ends_at?->isFuture();
    }

    /**
     * Suspend account and notify them.
     */
    public function suspend(string $reason, $endDate = null): void
    {
        $this->update([
            'suspended_at' => now(),
            'suspension_reason' => $reason,
            'suspension_ends_at' => $endDate,
        ]);

        $this->notify(new AccountSuspended($this));
    }

    /**
     * Un-suspend account and notify them.
     */
    public function unsuspend(): void
    {
        if (! $this->suspended_at) {
            return;
        }

        $this->update([
            'suspended_at' => null,
            'suspension_reason' => null,
            'suspension_ends_at' => null,
        ]);

        $this->notify(new AccountUnsuspended($this));
    }
}
