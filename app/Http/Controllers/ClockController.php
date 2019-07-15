<?php

namespace App\Http\Controllers;

use App\Cart;
use App\Clock;
use App\Http\Requests\ClockRequest;
use App\Http\Requests\ImageRequest;
use Illuminate\Http\Request;
use App\ClockImage;
use Illuminate\Support\Facades\App;
use Image;

class ClockController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Clock::all();
        return view('admin.clocksTable')->with('data', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.addOrUpdateClock');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  ClockRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(ClockRequest $request)
    {
        $clock = Clock::create([
            "name" => $request->input("name"),
            "gender" => $request->input("gender"),
            "type_of_indexation" => $request->input("typeOfIndexation"),
            "type_of_mechanism" => $request->input("typeOfMechanism"),
            "producer" => $request->input("producer"),
            "price" => $request->input("price"),
            "old_price" => $request->input("oldPrice"),
            "availability" => $request->input("availability"),
            "hide" => $request->input("hide"),
            ]);
        return redirect('admin/clocks/'.$clock->clock_id.'/edit');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = $this->getClockData($id);
        return view('item')->with("data", $data);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = $this->getClockData($id);
        return view('admin.addOrUpdateClock')->with("data", $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  ClockRequest $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ClockRequest $request, $id)
    {
        $clock = Clock::find($id);
        $clock->update([
            'name' => $request->input('name'),
            'gender' => $request->input('gender'),
            "type_of_indexation" => $request->input("typeOfIndexation"),
            "type_of_mechanism" => $request->input("typeOfMechanism"),
            "producer" => $request->input("producer"),
            "price" => $request->input("price"),
            "old_price" => $request->input("oldPrice"),
            "availability" => $request->input("availability"),
            "hide" => $request->input("hide"),
        ]);
        $data = Clock::find($id)->toArray();
        return $data;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $imagesFiles = Clock::find($id)->clockImages()->get()->toArray();
        foreach ($imagesFiles as $image){
            $imageUUID = $image['uuid'];
            unlink('images/small/'.$imageUUID);
            unlink('images/medium/'.$imageUUID);
            unlink('images/large/'.$imageUUID);
        }
        $clock = Clock::find($id);
        $clock->clockImages()->forceDelete();
        $clock->characteristics()->forceDelete();
        $clock->functions()->forceDelete();
        $clock->descriptions()->forceDelete();
        $clock->forceDelete();
        return "true";
    }

    public function updateFromTable(ClockRequest $request, $id)
    {
        $clock = Clock::find($id);
        $clock->update([
            'name' => $request->input('name'),
            'gender' => $request->input('gender'),
            "type_of_indexation" => $request->input("typeOfIndexation"),
            "type_of_mechanism" => $request->input("typeOfMechanism"),
            "producer" => $request->input("producer"),
            "price" => $request->input("price"),
            "old_price" => $request->input("oldPrice"),
            "availability" => $request->input("availability"),
            "hide" => $request->input("hide"),
        ]);
        $data = Clock::all();
        return $data;
    }

    public function destroyFromTable($id)
    {
        $this->destroy($id);
        $data = Clock::all();
        return $data;
    }

    public function getClockData($id){
        $clock = Clock::find($id);
        if ($clock == null) return abort(404);
        $data = $clock->toArray();
        $data["characteristics"] = $this->getCharacteristics($clock);
        $data["functions"] = $this->getFunctions($clock);
        $data["descriptions"] = $this->getDescriptions($clock);
        $data["images"] = $this->getImages($clock);
        $data["language"] = App::getLocale();
        return $data;
    }

    public function setDescriptions(Request $request, $id){
        $clock = Clock::find($id);
        $descriptionsUk = $request->input('descriptionsUk');
        $descriptionsRu = $request->input('descriptionsRu');
        $data['uk'] = [];
        $data['ru'] = [];
        foreach ($descriptionsUk as $key => $value) {
            $des = $clock->descriptions()->updateOrCreate(["description_name" => $key], ["value_uk" => $descriptionsUk[$key], "value_ru" => $descriptionsRu[$key]]);
            $data['uk'][$key] = $des["value_uk"];
            $data['ru'][$key] = $des["value_ru"];
        };
        return $data;
    }

    public function getDescriptions(Clock $clock){
        $descriptions = $clock->descriptions()->get();
        $data['uk'] = [];
        $data['ru'] = [];
        foreach ($descriptions as $description) {
            $data['uk'][$description['description_name']] = $description["value_uk"];
            $data['ru'][$description['description_name']] = $description["value_ru"];
        };
        return $data;
    }

    public function setCharacteristics(Request $request, $id){
        $clock = Clock::find($id);
        $characteristics = $request->input('characteristics');
        foreach ($characteristics as $key => $value) {
            $clock->characteristics()->updateOrCreate(["characteristic_name" => $key], ["value" => $value]);
        };
        $functions = $request->input('functions');
        $clock->functions()->updateOrCreate(["clock_id" => $id],["value_uk" => $functions["value_uk"], "value_ru" => $functions["value_ru"]]);
        $data['characteristics'] = $this->getCharacteristics($clock);
        $data['functions'] = $this->getFunctions($clock);
        return $data;
    }

    public function getCharacteristics(Clock $clock){
        $characteristics = $clock->characteristics()->get();
        $data = [];
        foreach ($characteristics as $characteristic) {
            $data[$characteristic['characteristic_name']] = $characteristic["value"];
        };
        return $data;
    }

    public function getFunctions(Clock $clock){
        $functions = $clock->functions()->select("value_uk", "value_ru")->first();
        if (isset($functions)) $functions = $functions->toArray();
        return $functions;
    }
    // Додати або редагути Cart
    public function addToCart(Request $request) {
        $clockId = $request->input('clockId');
        $oldCart = $request->session()->has('cart') ? $request->session()->get('cart') : null;
        $cart = Cart::get($oldCart);
        $clock = Clock::find($clockId);
        $qty = isset($cart->items[$clockId]) ? ++$cart->items[$clockId]['qty'] : 1;
        $cart->update($clock, $qty);
        $request->session()->put('cart', $cart);
        return json_encode($cart);
    }
    public function updateCart(Request $request) {
        $oldCart = $request->session()->has('cart') ? $request->session()->get('cart') : null;
        $cart = Cart::get($oldCart);
        if (isset($cart)){
            $clockId = $request->input("clockId");
            $clock = Clock::find($clockId);
            $qty = $request->input('qty');
            $cart->update($clock, $qty);
        }
        $request->session()->put('cart', $cart);
        return json_encode($cart);
    }
    public function removeFromCart(Request $request){
        $oldCart = $request->session()->has('cart') ? $request->session()->get('cart') : null;
        $cart = Cart::get($oldCart);
        if (isset($cart)){
            $clockId = $request->input("clockId");
            $cart->remove($clockId);
        }
        $request->session()->put('cart', $cart);
        return json_encode($cart);
    }
    public function getCart(Request $request) {
        $oldCart = $request->session()->has('cart') ? $request->session()->get('cart') : null;
        return json_encode($oldCart);
    }

    public function loadImages(Request $request, $id){
        if($request->post('image'))
        {
            $file = $request->post('image');
            $image = Image::make($file);
            $height = $image->height();
            $width = $image->width();
            if ($height < 400 || $width < 400){
                return response()->json(['error' => 'Недостатній розмір зображення. Мінімальна ширина і висота повинна бути більшою 400px.'], 415);
            } elseif ($height > 10000 || $width > 10000) {
                return response()->json(['error' => 'Перевищено максимальний розмір зображення. Максимальна ширина або висота повинна бути меншою 10000px.'], 415);
            }
            $name = $id.str_random(5).".jpg";
            $sizes = [
                "small" => 100,
                "medium" => 260,
                "large" => 800
            ];
            foreach ($sizes as $sizeName => $size) {
                    Image::make($file)->resize($size, $size)->encode('jpg', 75)->save(public_path('images/'.$sizeName."/").$name)->save();
            }
            $clockImage = ClockImage::create([
                "clock_id" => $id,
                "uuid" => $name,
            ]);
            return $clockImage->toArray();
        }
        return response()->json(['error' => 'Відсутнє зображення'], 422);
    }

    public function getImages(Clock $clock){
        $clockImages= $clock->clockImages()->get()->toArray();
        return $clockImages;
    }

    public function deleteImage(Request $request, $id){
        $imageId = $request->input("imageId");
        $image = ClockImage::find($imageId);
        $imageUUID = $image->uuid;
        $clock = Clock::find($id);
        $logoUUID = $clock->logo_uuid;
        if ($imageUUID == $logoUUID){
            $clock->logo_uuid = null;
            $clock->save();
        }
        unlink('images/small/'.$imageUUID);
        unlink('images/medium/'.$imageUUID);
        unlink('images/large/'.$imageUUID);
        $image->delete();
        return $this->getImages($clock);
    }

    public function setLogo(Request $request, $id){
        $uuid = $request->input('uuid');
        if (strlen($uuid) == 13) {
            $logo = Clock::find($id);
            $logo->logo_uuid = $uuid;
            $logo->save();
            return $logo;
        } else {
            return response()->json(["error" => "Невірний UUID зображення"], 422);
        }

    }

    public function mainPage(){
        $model = Clock::all();
        $data['clocks'] = $model->toArray();
        $data['filter'] = [
            "minPrice" => $model->min('price'),
            "maxPrice" => $model->max('price'),
        ];
        return view('main')->with('data', $data);
    }
    public function shopPage(){
        $model = Clock::all();
        $data['clocks'] = $model->toArray();
        $data['filter'] = [
            "minPrice" => $model->min('price'),
            "maxPrice" => $model->max('price'),
        ];
        return view('main')->with('data', $data);
    }

    public function filter (Request $request){
        if ($request->input() !== []){
            foreach ($request->input() as $key => $string){
                $values = explode(',', $string);
                $query[$key] = $values;
                $model = Clock::filter($query)->get();
            }
        }else{
            $model = Clock::all();
        }
        $data['clocks'] = $model->toArray();
        $data['filter'] = [
            "minPrice" => $model->min('price'),
            "maxPrice" => $model->max('price'),
        ];
         return $data;
    }
}
