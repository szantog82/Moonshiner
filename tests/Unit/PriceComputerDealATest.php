<?php
namespace Tests\Unit;

use Tests\TestCase;
use App\Models\HoodiePriceComputer;
use App\Models\Item;

class PriceComputerDealATest extends TestCase
{

    protected $rules;

    public function setUp(): void
    {
        parent::setUp();
        $this->rules = json_decode(file_get_contents(storage_path("special_deals.json")), true);
    }

    private function test($products)
    {
        $expected_price = (count($products) > 4) ? Item::select("price")->whereIn("id", $products)->sum("price") - $this->rules["A"]["reduction"] : Item::select("price")->whereIn("id", $products)->sum("price");
        $this->assertEquals($expected_price, HoodiePriceComputer::calculatePrice($products)["reduced_price"]);
    }

    public function test_with_three_different_products_where_limit_is_4()
    {
        $products = [
            2,
            3,
            4
        ];
        $this->test($products);
    }

    public function test_with_four_different_products_where_limit_is_4()
    {
        $products = [
            2,
            3,
            4,
            5
        ];
        $this->test($products);
    }
    
    public function test_with_five_different_products_where_limit_is_4()
    {
        $products = [
            2,
            3,
            4,
            5,
            6
        ];
        $this->test($products);
    }
}
