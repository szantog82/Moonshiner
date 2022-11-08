<?php
namespace App\Models;

class HoodiePriceComputer
{

    private static $product_prices;

    private static $rules;

    private static function fetchProductPrices()
    {
        $items = Item::select("id", "price")->get()->toArray();
        self::$product_prices = array_combine(array_column($items, "id"), array_column($items, "price"));
    }

    private static function fetchRules()
    {
        self::$rules = json_decode(file_get_contents(storage_path("special_deals.json")), true);
    }

    public static function getActivePromoCode()
    {
        self::fetchRules();
        if (self::$rules["D"]["is_active"] == 1) {
            return self::$rules["D"]["code"];
        } else {
            return -1;
        }
    }

    public static function convertProductListToArray($products)
    {
        self::fetchProductPrices();
        $product_arr = [];
        foreach ($products as $product) {
            if (in_array($product, array_keys(self::$product_prices))) {
                if (in_array($product, array_keys($product_arr))) {
                    $product_arr[$product] = $product_arr[$product] + 1;
                } else {
                    $product_arr[$product] = 1;
                }
            }
        }
        return $product_arr;
    }

    public static function calculatePrice($products, $first_ordering = 0, $code = "")
    {
        self::fetchProductPrices();
        self::fetchRules();

        $product_arr = self::convertProductListToArray($products);
        $reductions = [];

        // price sum without any discount
        $full_price = 0;
        foreach ($product_arr as $key => $value) {
            $full_price = $full_price + self::$product_prices[$key] * $value;
        }
        $reduced_price = $full_price;

        // if cart is empty
        if (count($product_arr) < 1) {
            return array(
                "full_price" => 0,
                "reduced_price" => 0,
                "reductions" => [],
                "products" => []
            );
        }

        // A rule check
        if (count($product_arr) > self::$rules["A"]["limit"] && self::$rules["A"]["is_active"] == 1) {
            $reductions[] = array(
                "message" => "More than " . self::$rules["A"]["limit"] . " different items",
                "value" => self::$rules["A"]["reduction"]
            );
            $reduced_price = $reduced_price - self::$rules["A"]["reduction"];
        }

        // B rule check
        foreach (array_keys($product_arr) as $p) {
            if (in_array($p, self::$rules["B"]["product"]) && $product_arr[$p] > self::$rules["B"]["limit"] && self::$rules["B"]["is_active"] == 1) {
                $productName = Item::find($p)->name;
                $reductions[] = array(
                    "message" => "More than " . self::$rules["B"]["limit"] . " from $productName; one is free",
                    "value" => self::$product_prices[$p]
                );
                $reduced_price = $reduced_price - self::$product_prices[$p];
            }
        }

        // C rule check
        $extra_message = "";
        $productName = Item::find(self::$rules["C"]["product"])->name;
        if ($first_ordering) {
            if (in_array(self::$rules["C"]["product"], array_keys($product_arr)) && self::$rules["C"]["is_active"] == 1) {
                // Promo product already added to cart; one is for free
                $reduced_price = $reduced_price - self::$product_prices[self::$rules["C"]["product"]];
            } else {
                // Promo product not in cart; one will be added, its price will be added to total_price but not to reduced price
                $product_arr[self::$rules["C"]["product"]] = 1;
                $full_price = $full_price + self::$product_prices[self::$rules["C"]["product"]];
                $extra_message = " +1 $productName is free because of first order";
            }
            $reductions[] = array(
                "message" => "First ordering: one $productName is for free",
                "value" => self::$product_prices[self::$rules["C"]["product"]]
            );
        }

        // E rule check
        if (in_array(self::$rules["E"]["productA"], array_keys($product_arr)) && in_array(self::$rules["E"]["productB"], array_keys($product_arr)) && self::$rules["E"]["is_active"] == 1) {
            $productAName = Item::find(self::$rules["E"]["productA"])->name;
            $productBName = Item::find(self::$rules["E"]["productB"])->name;
            $reductions[] = array(
                "message" => "$productAName and $productBName bought together; one from $productAName is free",
                "value" => self::$product_prices[self::$rules["E"]["productA"]]
            );
            $reduced_price = $reduced_price - self::$product_prices[self::$rules["E"]["productA"]];
        }

        // D rule check
        if ($code === self::$rules["D"]["code"] && self::$rules["D"]["is_active"] == 1) {
            $reductions = [];
            if (self::$rules["D"]["free"] === 1) {
                $reduced_price = 0;
                $reductions[] = array(
                    "message" => "Promo code applied: whole order is free$extra_message",
                    "value" => $full_price
                );
            } else {
                $reduced_price = 0;
                $reductions[] = array(
                    "message" => "Promo code applied",
                    "value" => self::$rules["D"]["reduction"]
                );
                $reduced_price = $reduced_price - self::$rules["D"]["reduction"];
            }
        }
        if ($reduced_price < 0) {
            $reduced_price = 0;
        }
        $product_arr_output = [];
        foreach ($product_arr as $key => $value) {
            $product_arr_output[] = array(
                "id" => $key,
                "name" => Item::find($key)->name,
                "count" => $value,
                "unit_price" => self::$product_prices[$key]
            );
        }

        usort($product_arr_output, fn ($a, $b) => $a["id"] <=> $b["id"]);

        return array(
            "full_price" => $full_price,
            "reduced_price" => $reduced_price,
            "reductions" => $reductions,
            "products" => $product_arr_output
        );
    }
}

?>