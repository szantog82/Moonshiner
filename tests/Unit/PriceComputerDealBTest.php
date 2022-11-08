<?php
namespace Tests\Unit;

use Tests\TestCase;
use App\Models\HoodiePriceComputer;
use App\Models\Item;

class PriceComputerDealBTest extends TestCase
{

    protected $rules;
    protected $item_price;

    public function setUp(): void
    {
        parent::setUp();
        $this->rules = json_decode(file_get_contents(storage_path("special_deals.json")), true);
        $items = Item::select("id", "price")->get()->toArray();
        $this->item_price = Item::find(1)->price;
    }

    public function test_with_one_product_no_1_where_limit_is_1()
    {
        $products = [
            1
        ];
        $this->assertEquals($this->item_price, HoodiePriceComputer::calculatePrice($products)["reduced_price"]);
    }

    public function test_with_two_same_products_no_1_where_limit_is_1()
    {
        $products = [
            1,
            1
        ];
        $this->assertEquals(2 * $this->item_price - $this->item_price, HoodiePriceComputer::calculatePrice($products)["reduced_price"]);
    }

    public function test_with_three_same_products_no_1_where_limit_is_1()
    {
        $products = [
            1,
            1,
            1
        ];
        $this->assertEquals(3 * $this->item_price - $this->item_price, HoodiePriceComputer::calculatePrice($products)["reduced_price"]);
    }

    public function test_with_four_same_products_no_1_where_limit_is_1()
    {
        $products = [
            1,
            1,
            1,
            1
        ];
        $this->assertEquals(4 * $this->item_price - $this->item_price, HoodiePriceComputer::calculatePrice($products)["reduced_price"]);
    }
}
