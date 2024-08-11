<?php

namespace App\Models;

use App\Coupon\PercentageCoupon;
use App\Coupon\FixedAmountCoupon;
use Illuminate\Database\Eloquent\Model;
use RealRashid\Cart\Coupon\Coupon as CouponContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Coupon extends Model
{
    use HasFactory;

    protected $fillable = [
        'code', 'type', 'amount', 'expiry_date',
    ];

    protected $dates = [
        'expiry_date',
    ];

    /**
     * Check if the coupon is valid.
     *
     * @return bool
     */
    public function isValid(): bool
    {
        return $this->expiry_date >= now();
        // Additional validation logic can be added if required
    }

    /**
     * Check if the coupon is a fixed amount type.
     *
     * @return bool
     */
    public function isFixedAmount(): bool
    {
        return $this->type === 'fixed_amount';
    }

    /**
     * Check if the coupon is a percentage type.
     *
     * @return bool
     */
    public function isPercentage(): bool
    {
        return $this->type === 'percentage';
    }

    /**
     * Create a coupon object based on its type.
     *
     * @return \RealRashid\Cart\Coupon\Coupon
     * @throws \Exception
     */
    public function createCoupon(): CouponContract
    {
        if ($this->isFixedAmount()) {
            return new FixedAmountCoupon($this);
        } elseif ($this->isPercentage()) {
            return new PercentageCoupon($this);
        }

        throw new \Exception('Unsupported coupon type.');
    }
}
