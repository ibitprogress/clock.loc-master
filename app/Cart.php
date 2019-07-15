<?php
namespace App;
class Cart
{
    public $items = null;
    public $totalPrice = 0;
    public $totalQty = 0;
    private static $instance;
    public function __construct($oldCart)
    {
        if ($oldCart) {
            $this->items = $oldCart->items;
            $this->totalPrice = $oldCart->totalPrice;
        }
    }
    public function update($clock, $qty) {
        $storedItem = ['qty' => $qty,
            'price' => $clock->price,
            'clockId' => $clock->clock_id,
            'total' => $clock->price * $qty,
            'name' => $clock->name,
            'logo_uuid' => $clock->logo_uuid,
        ];
        $this->items[$clock->clock_id] = $storedItem;
        $this->getTotal();
    }
    public function remove($id){
        unset($this->items[$id]);
        $this->getTotal();

    }
    public function getTotal(){
        $totalPrice = 0;
        $totalQty = 0;
        foreach ($this->items as $item){
            $totalPrice += $item['total'];
            $totalQty += $item['qty'];
        }
        $this->totalPrice = $totalPrice;
        $this->totalQty = $totalQty;
    }
    public static function get($oldCart)
    {
        if (null === static::$instance) {
            static::$instance = new static($oldCart);
        }

        return static::$instance;
    }
}