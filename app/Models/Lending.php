<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Models\Item;
use App\Models\User;

class Lending extends Model
{
    use HasFactory;

    /*
    |--------------------------------------------------------------------------
    | TABLE
    |--------------------------------------------------------------------------
    */
    protected $table = 'lendings';

    /*
    |--------------------------------------------------------------------------
    | MASS ASSIGNMENT
    |--------------------------------------------------------------------------
    */
    protected $fillable = [
        'user_id',
        'item_id',
        'name',
        'total',
        'notes',
        'returned_at'
    ];

    /*
    |--------------------------------------------------------------------------
    | CAST DATE (WAJIB untuk filter tanggal jalan mulus)
    |--------------------------------------------------------------------------
    */
    protected $casts = [
        'created_at'  => 'datetime',
        'updated_at'  => 'datetime',
        'returned_at' => 'datetime',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELATION
    |--------------------------------------------------------------------------
    */
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
         * RULE 1 — CREATE PEMINJAMAN
         */
        static::creating(function ($lending) {

            DB::transaction(function () use ($lending) {

                $item = Item::lockForUpdate()->find($lending->item_id);

                if (!$item) {
                    throw new \Exception("Barang tidak ditemukan!");
                }

                // total barang yg masih dipinjam
                $borrowed = self::where('item_id', $item->id)
                    ->whereNull('returned_at')
                    ->sum('total');

                $available = $item->total - $borrowed;

                // 🚨 STOP jika stok kurang
                if ($lending->total > $available) {
                    throw new \Exception(
                        "Stok tidak cukup! Sisa stok hanya $available unit."
                    );
                }
            });
        });

        /**
         * RULE 2 — UPDATE JUMLAH PINJAM
         */
        static::updating(function ($lending) {

            // hanya cek jika jumlah berubah & belum return
            if ($lending->isDirty('total') && !$lending->returned_at) {

                DB::transaction(function () use ($lending) {

                    $item = Item::lockForUpdate()->find($lending->item_id);

                    if (!$item) {
                        throw new \Exception("Barang tidak ditemukan!");
                    }

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
