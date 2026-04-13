<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Models\Item;

class Lending extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'item_id',
        'name',
        'total',
        'notes',
        'returned_at'
    ];

    protected function casts(): array
    {
        return [
            'returned_at' => 'datetime',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    /*
    |--------------------------------------------------------------------------
    | 🔒 HARD BUSINESS RULE (ANTI STOK MINUS)
    |--------------------------------------------------------------------------
    */

    protected static function booted()
    {
        /**
         * RULE 1 — Saat CREATE peminjaman
         */
        static::creating(function ($lending) {

            DB::transaction(function () use ($lending) {

                $item = Item::lockForUpdate()->find($lending->item_id);

                // total barang yang sedang dipinjam (belum return)
                $borrowed = self::where('item_id', $item->id)
                    ->whereNull('returned_at')
                    ->sum('total');

                $available = $item->total - $borrowed;

                // 🚨 HARD STOP
                if ($lending->total > $available) {
                    throw new \Exception(
                        "Stok tidak cukup! Sisa stok hanya $available unit."
                    );
                }
            });
        });

        /**
         * RULE 2 — Saat UPDATE jumlah pinjam
         */
        static::updating(function ($lending) {

            // cek hanya jika total berubah & belum dikembalikan
            if ($lending->isDirty('total') && !$lending->returned_at) {

                DB::transaction(function () use ($lending) {

                    $item = Item::lockForUpdate()->find($lending->item_id);

                    $borrowed = self::where('item_id', $item->id)
                        ->whereNull('returned_at')
                        ->where('id', '!=', $lending->id)
                        ->sum('total');

                    $available = $item->total - $borrowed;

                    if ($lending->total > $available) {
                        throw new \Exception(
                            "Update ditolak! Stok tersisa $available unit."
                        );
                    }
                });
            }
        });
    }
}
