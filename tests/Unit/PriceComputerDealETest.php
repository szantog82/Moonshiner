<?php
namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Item;
use App\Models\HoodiePriceComputer;

class PriceComputerDealETest extends TestCase
{

    protected $item_price;

    protected $productA_id;

    protected $productB_id;

    protected $productA_price;

    protected $productB_price;

    public function setUp(): void
    {
        parent::setUp();
        $rules = json_decode(file_get_contents(storage_path("special_deals.json")), true);
        $this->productA_id = $rules["E"]["productA"];
        $this->productB_id = $rules["E"]["productB"];
        $this->productA_price = Item::find($this->productA_id)->price;
        $this->productB_price = Item::find($this->productB_id)->price;
    }

    public function test_only_productA_is_present()
    {
        $this->assertEquals($this->productA_price,  HoodiePriceComputer::calculatePrice([$this->productA_id])["reduced_price"]);
    }

    public function test_only_productB_is_present()
    {
        $this->assertEquals($this->productB_price,  HoodiePriceComputer::calculatePrice([$this->productB_id])["reduced_price"]);
    }

    public function test_both_productA_and_productB_are_present()
    {
        $this->assertEquals($this->productB_price,  HoodiePriceComputer::calculatePrice([$this->productA_id, $this->productB_id])["reduced_price"]);
    }
}
