<?php

namespace App\Policies;

use App\Models\Transaction;
use App\Models\User;

class TransactionPolicy
{
    /**
     * Tentukan apakah user boleh melihat transaksi ini.
     */
    public function view(User $user, Transaction $transaction): bool
    {
        return $transaction->user_id === $user->id;
    }

    /**
     * Tentukan apakah user boleh update transaksi ini.
     */
    public function update(User $user, Transaction $transaction): bool
    {
        return $transaction->user_id === $user->id;
    }

    /**
     * Tentukan apakah user boleh menghapus transaksi ini.
     */
    public function delete(User $user, Transaction $transaction): bool
    {
        return $transaction->user_id === $user->id;
    }

    /**
     * (opsional) kalau mau membatasi siapa yang boleh create
     */
    public function create(User $user): bool
    {
        return true;
    }
}
