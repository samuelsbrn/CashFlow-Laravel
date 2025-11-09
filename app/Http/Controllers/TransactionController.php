<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class TransactionController extends Controller
{
    // list transaksi
    public function index()
    {
        $transactions = Transaction::with('category')
            ->where('user_id', Auth::id())
            ->orderByDesc('occurred_at')
            ->orderByDesc('id')
            ->paginate(15);

        $categories = Category::where('user_id', Auth::id())
            ->orderBy('name')
            ->get();

        return view('transactions.index', compact('transactions', 'categories'));
    }

    // form create
    public function create()
    {
        $categories = Category::where('user_id', Auth::id())
            ->orderBy('name')
            ->get();

        return view('transactions.create', compact('categories'));
    }

    // simpan transaksi baru
    public function store(Request $request)
    {
        $data = $request->validate([
            'title'       => ['required', 'string', 'max:255'],
            'type'        => ['required', 'in:income,expense'],
            'amount'      => ['required', 'numeric', 'min:0'],
            'category_id' => ['nullable', 'exists:categories,id'],
            'description' => ['nullable', 'string', 'max:255'],
            'occurred_at' => ['nullable', 'date'],
            'cover'       => ['nullable', 'image', 'max:2048'],
        ]);

        $data['user_id']    = Auth::id();
        $data['occurred_at'] = $data['occurred_at'] ?? now();

        // simpan file kalau ada
        if ($request->hasFile('cover')) {
            $data['cover_path'] = $request->file('cover')->store('covers', 'public');
        }

        Transaction::create($data);

        return redirect()->route('transactions.index')
            ->with('success', 'Transaksi berhasil ditambahkan.');
    }

    // 👇 inilah yang tadi belum ada
    public function show(Transaction $transaction)
    {
        $this->ensureOwner($transaction);

        return view('transactions.show', [
            'transaction' => $transaction->load('category'),
        ]);
    }

    // form edit
    public function edit(Transaction $transaction)
    {
        $this->ensureOwner($transaction);

        $categories = Category::where('user_id', Auth::id())
            ->orderBy('name')
            ->get();

        return view('transactions.edit', [
            'transaction' => $transaction,
            'categories'  => $categories,
        ]);
    }

    // update
    public function update(Request $request, Transaction $transaction)
    {
        $this->ensureOwner($transaction);

        $data = $request->validate([
            'title'       => ['required', 'string', 'max:255'],
            'type'        => ['required', 'in:income,expense'],
            'amount'      => ['required', 'numeric', 'min:0'],
            'category_id' => ['nullable', 'exists:categories,id'],
            'note'        => ['nullable', 'string', 'max:1000'],
            'occurred_at' => ['nullable', 'date'],
            'cover'       => ['nullable', 'image', 'max:2048'],
        ]);

        $data['occurred_at'] = $data['occurred_at'] ?? now();

        if ($request->hasFile('cover')) {
            // hapus lama kalau ada
            if ($transaction->cover_path) {
                Storage::disk('public')->delete($transaction->cover_path);
            }
            $data['cover_path'] = $request->file('cover')->store('covers', 'public');
        }

        $transaction->update($data);

        return redirect()->route('transactions.index')
            ->with('success', 'Transaksi berhasil diperbarui.');
    }

    // hapus
    public function destroy(Transaction $transaction)
    {
        $this->ensureOwner($transaction);

        if ($transaction->cover_path) {
            Storage::disk('public')->delete($transaction->cover_path);
        }

        $transaction->delete();

        return redirect()->route('transactions.index')
            ->with('success', 'Transaksi berhasil dihapus.');
    }

    /**
     * Pastikan transaksi milik user yg login
     */
    private function ensureOwner(Transaction $transaction): void
    {
        if ($transaction->user_id !== Auth::id()) {
            abort(403);
        }
    }
}
