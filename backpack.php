<?php

class Item {
    public $name;
    public $weight;
    public $value;

    public function __construct($name, $weight, $value) {
        $this->name = $name;
        $this->weight = $weight;
        $this->value = $value;
    }
}
/**
 * Item - polozka v batohu, zde jsou jeji promenne.
 */

// Batoh/ Backpack
class Backpack {
    protected $items = [];
    protected $capacity;

    public function __construct($capacity) {
        $this->capacity = $capacity;
    }
    /**
     * Kapacita batohu urcuje kolik polozek muze obsahovat
     */

    public function addItem(Item $item) {
        if ($this->getRemainingCapacity() >= $item->weight) {
            $this->items[] = $item;
        }
    }
    /**
     * Kontroluje zdali je v batohu dostatek mista pro pridani dalsi polozky a poku je tak ji prida do batohu
     */

    public function getRemainingCapacity() {
        $usedCapacity = 0;
        foreach ($this->items as $item) {
            $usedCapacity += $item->weight;
        }
        return $this->capacity - $usedCapacity;
    }
    /**
     * Vypocitava jestli je v batohu jeste misto, odecita pouzitou kapacitu od celkove kapacity pro zbyvajici kapacitu
     */

    public function getTotalValue() {
        $totalValue = 0;
        foreach ($this->items as $item) {
            $totalValue += $item->value;
        }
        return $totalValue;
    }
    /**
     * Scita polozky v batohu aby ziskal celkovou hodnotu 
     */

    public function displayItems() {
        echo "Items in the backpack:\n";
        foreach ($this->items as $item) {
            echo "- {$item->name} (Weight: {$item->weight}, Value: {$item->value})\n";
        }
    }
    /**
     * Vraci polozky co se nachazeji v batohu
     */

     // Rozdel a panuj/Divide and Conquer algoritmus  
    public function fillBackpackDvdCqr($availableItems, $capacity) {
        if ($capacity <= 0 || empty($availableItems)) {
            return 0;
        }
        $includedItem = $availableItems[0];
        $remainingItems = array_slice($availableItems, 1);

        // include
        $valueWithItem = $includedItem->value + $this->fillBackpackDvdCqr($remainingItems, $capacity - $includedItem->weight);

        // exclude
        $valueWithoutItem = $this->fillBackpackDvdCqr($remainingItems, $capacity);

        // vyber max hodnotu
        if ($includedItem->weight <= $capacity && $valueWithItem > $valueWithoutItem) {
            $this->addItem($includedItem);
            return $valueWithItem;
        } else {
            return $valueWithoutItem;
        }
    }
}

$backpack = new Backpack(15);

$items = [
    new Item("Laptop", 3, 700),
    new Item("Kamera", 2, 500),
    new Item("Ramen", 1, 100),
    new Item("Kniha", 2, 300),
    new Item("Penize", 1, 200),
];

foreach ($items as $item) {
    $backpack->addItem($item);
}

echo "Batoh zaplneny hladovym algoritmem:\n";
$backpack->displayItems();
echo "Celkova hodnota: " . $backpack->getTotalValue() . "\n";
/**
 * vyplnuje a nasledne vypysuje obsah batohu zaplneny hladovym algoritmem
 * algoritmus bere vsechny polozky, dokud je misto
 */

$backpackDC = new Backpack(15);

$itemsDC = [
    new Item("Laptop", 3, 700),
    new Item("Kamera", 2, 500),
    new Item("Ramen", 1, 100),
    new Item("Kniha", 2, 300),
    new Item("Penize", 1, 200),
];

$totalValueDC = $backpackDC->fillBackpackDvdCqr($itemsDC, 15);

echo "Batoh zaplneny rozdel a panuj algoritmem:\n";
$backpackDC->displayItems();
echo "Celkova hodnota: " . $totalValueDC . "\n";
/**
 * vyplnuje a nasledne vypysuje obsah batohu zaplneny algoritmem rozdel a panuj 
 * algoritmus upresnostnuje polozky s nejmensi vahou a nejvyssi cenou
 */
