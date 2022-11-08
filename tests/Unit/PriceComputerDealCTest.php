<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Item;
use App\Models\HoodiePriceComputer;

class PriceComputerDealCTest extends TestCase
{
    protected $rules;
    protected $item_price;

    public function setUp(): void
    {
        parent::setUp();
        $rules = json_decode(file_get_contents(storage_path("special_deals.json")), true);
        $this->free_product_id = $rules["C"]["product"];
        $this->free_product_price =  Item::find($this->free_product_id)->price;
    }
    
    public function test_not_first_ordering_one_product_plus_highlighted_product() {
        $product_1_price = Item::find(1)->price;
        $this->assertEquals($product_1_price + $this->free_product_price, HoodiePriceComputer::calculatePrice([1, $this->free_product_id], 0)["reduced_price"]);
    }
    
    public function test_first_ordering_one_product_plus_highlighted_product() {
        $product_1_price = Item::find(1)->price;
        $this->assertEquals($product_1_price, HoodiePriceComputer::calculatePrice([1, $this->free_product_id], 1)["reduced_price"]);
    }
}
