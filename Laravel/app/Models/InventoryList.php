<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class InventoryList extends Model
{
    use HasFactory;

    /**
     * Table Associated with this Model
     */
    protected $table = 'inventorylist';

    /**
     *  Table Fillable Columns
     */
    protected $fillable = [
        'Supply',
        'Item_name',
        'created_at',
    ];

    /**
     * this DB does not require timestamps
     */
    public $timestamps = false;
    


    public static function deleteitem(int $id){
       DB::table('inventorylist')->where('id', '=', $id)->delete();

       return 'success';
    }

    public static function updateItem(int $id,int $supply, string $item_name){
        DB::table('inventorylist')
            ->where('id', '=', $id)
            ->update(['Supply'=> $supply,
                    'Item_Name' => $item_name]);
 
        return 'success';
     }

     public static function AddItem(int $supply, string $item_name){
        DB::table('inventorylist')
            ->Add(['Supply'=> $supply,
                    'Item_Name' => $item_name]);
 
        return 'success';
     }
}
