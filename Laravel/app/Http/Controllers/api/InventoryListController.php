<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\InventoryList;
use GuzzleHttp\Promise\Create;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

//changed name controller from InventoryList to ..
class InventoryListController extends Controller
{
    public function InventoryAdd(Request $request){
        $request->verify([
            
        ]);
    }

    public function addItem(Request $request){
        $item = InventoryList::create([
            'Supply' => $request->Supply,
            'Item_name' => $request->Item_Name,
            'created_at' => now(),
        ]);
        //$item -> save();

        return response()->json([
            'message' => $item->all(),
            ]);
    }

    public function showList(){
        return response()->json([
                            'items' => InventoryList::All(),
                            ]);
    }

    public function deleteItem($id){
        InventoryList::deleteItem($id);
        return response()->json([
            'message' => 'Success!',
            ]);
    }

    public function updateItem(Request $request){
        InventoryList::updateitem($request->id, $request->Supply, $request->Item_Name);
        return response()->json([
            'message' => 'Success',
            ]);
    }
}
