<?php

namespace App\Coupon;

use RealRashid\Cart\Coupon\Coupon as CouponContract;
use App\Models\Coupon as CouponModel;

class FixedAmountCoupon implements CouponContract
{
    protected $coupon;

    public function __construct(CouponModel $coupon)
    {
        $this->coupon = $coupon;
    }

    public function getCode(): string
    {
        return $this->coupon->code;
    }

    public function isValid(): bool
    {
        return $this->coupon->isValid();
    }

    public function getDiscountType(): string
    {
        return 'fixed_amount';
    }

    public function getExpiryDate(): string
    {
        return $this->coupon->expiry_date;
    }

    public function getDiscountAmount(): float
    {
        return $this->coupon->amount;
    }
}
