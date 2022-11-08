<?php
namespace Tests\Unit;

use Tests\TestCase;
use App\Models\HoodiePriceComputer;
use App\Models\Item;

class PriceComputerDealDTest extends TestCase
{

    protected $products;

    public function setUp(): void
    {
        parent::setUp();
        $this->products = [
            1,
            2,
            3,
            2,
            3,
            5
        ];
    }

    public function test_wrong_promo_code()
    {
        $this->assertNotEquals(0, HoodiePriceComputer::calculatePrice($this->products, 0, "Wellcomme11337")["reduced_price"]);
    }

    public function test_correct_promo_code()
    {
        $this->assertEquals(0, HoodiePriceComputer::calculatePrice($this->products, 0, "Welcome1337")["reduced_price"]);
    }
}
