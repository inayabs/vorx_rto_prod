<?php

namespace App\Http\Controllers\Menu;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\MenuResource;
use JavaScript;
use Validator;
use App\Models\Menu;
use App\Models\SubMenu;
use DB;
class MenuController extends Controller
{
    //
    public function __construct(){
        $this->middleware('auth');
    }

    public function index(){
        $menus = Menu::with('sub_menus')->orderBy('order','asc')->get();
        // dd($menus);
        \JavaScript::put([
            'menus'=>$menus
        ]);
        return view('menus.index');
        // return 'fuck df';
    }

    public function list(Request $request){
        $menus = Menu::with('sub_menus')->orderBy('order','asc')->get();
        return $menus;
    }

    public function update_order(Request $request){
        // return $request->all();
        $menus = $request->all();
        // dd($menus);
        foreach($menus as $menu){
            // dd($menu['id']);
            $menu_id = $menu['id'];
            try{
                $menuSql = Menu::where('id',$menu_id)->first();
                DB::beginTransaction();
                
                $menuSql->order = $menu['index'];
                $menuSql->update();

                DB::commit();
            }catch(Exception $e){
                DB::rollback();
                return response()->json(['status'=>'error','message'=>$e->getMessage()]);
            }
        }

        return response()->json(['status'=>'success']);
    }

    public function update_order_submenu(Request $request){
        $subMenu = $request->all();
        // dd($menus);
        // dd($subMenu);
        foreach($subMenu as $sub_menu){
            // dd($menu['id']);
            $sub_menu_id = $sub_menu['id'];
            // dd($sub_menu_id);
            try{
                $subMenuSql = SubMenu::where('id',$sub_menu_id)->first();
                DB::beginTransaction();
                
                $subMenuSql->order = $sub_menu['index'];
                $subMenuSql->update();
                
                DB::commit();
            }catch(Exception $e){
                DB::rollback();
                return response()->json(['status'=>'error','message'=>$e->getMessage()]);
            }
        }

        return response()->json(['status'=>'success']);
    }

    public function add_menu(Request $request){
        // dd($request->all());
        $validator = Validator::make($request->all(),[
            'menu_name'=>'required',
            'add_on_name'=>'required'
        ]);

        if($validator->fails()){
            return response()->json(['status' => 'error', 'errors' => $validator->messages()]);
        }
        $menu = Menu::orderBy('order','desc')->first();
        // dd($menu->order);
        $newOrderNo = $menu->order + 1;
        try{
            DB::beginTransaction();
            $new = new Menu;
            $new->order = $newOrderNo;
            $new->menu_name = $request->menu_name;
            $new->add_on_name = $request->add_on_name;
            $new->fa_icon = $request->fa_icon;
            $new->link = $request->link;
            $new->dropdown = $request->dropdown;
            $new->is_default = 0;
            $new->role_access = $request->role_access;
            $new->save();

            DB::commit();

            return response()->json(['status'=>'success']);
        }catch(Exception $e){
            DB::rollback();
            return response()->json(['status'=>'error','messages'=>$e->getMessage()]);
        }              
    }

    public function submenu_add(Request $request,$id){
        $validator = Validator::make($request->all(),[
            'menu_name'=>'required',
            'link'=>'required',
            'add_on_name'=>'required',
            'role_access'=>'required'
        ]);

        if($validator->fails()){
            return response()->json(['status' => 'error', 'errors' => $validator->messages()]);
        }
        
        $subMenu = SubMenu::where('menu_id',$id)->orderBy('order','desc')->first();
        $newOrderNo = isset($subMenu)?$subMenu->order + 1:0;
        
        try{
            DB::beginTransaction();
            $new = new SubMenu;
            $new->menu_id = $id;
            $new->order = $newOrderNo;
            $new->menu_name = $request->menu_name;
            $new->add_on_name = $request->add_on_name;
            $new->fa_icon = $request->fa_icon;
            $new->link = $request->link;
            $new->dropdown = 0;
            $new->is_default = 0;
            $new->role_access = $request->role_access;
            $new->save();

            DB::commit();

            return response()->json(['status'=>'success']);
        }catch(Exception $e){
            DB::rollback();
            return response()->json(['status'=>'error','messages'=>$e->getMessage()]);
        }     
    }

    public function remove_menu($id){
        // dd($id,$table);
        try{
            DB::beginTransaction();
            $menu = Menu::where('id',$id)->first();
            $menu->delete();

            DB::commit();
            return response()->json(['status'=>'success']);
        }catch(Exception $e){
            DB::rollback();
            return response()->json(['status'=>'error','messages'=>$e->getMessage()]);
        }
    }

    public function remove_submenu($id){
        // dd($id,$table);
        try{
            DB::beginTransaction();
            $menu = SubMenu::where('id',$id)->first();
            $menu->delete();

            DB::commit();
            return response()->json(['status'=>'success']);
        }catch(Exception $e){
            DB::rollback();
            return response()->json(['status'=>'error','messages'=>$e->getMessage()]);
        }
    }

    public function menu_edit($id){
        // dd($id);
        // $menu = Menu::where('id',$id)->first();
        \JavaScript::put([
            'menu_id'=>$id
        ]);
        return view('menus.edit');
    }

    public function menu_details($id){
        $menu = Menu::with('sub_menus')->where('id',$id)->first();
        $menu->new_dropdown = $menu->dropdown;

        return $menu;
    }

    public function menu_update(Request $request){
        $id = $request->id;
        
        $validator = Validator::make($request->all(),[
            'menu_name'=>'required',
            'add_on_name'=>'required'
        ]);

        if($validator->fails()){
            return response()->json(['status' => 'error', 'errors' => $validator->messages()]);
        }

        try{
            DB::beginTransaction();
            $menu = Menu::where('id',$id)->first();
            $menu->menu_name = $request->menu_name;
            $menu->add_on_name = $request->add_on_name;
            $menu->fa_icon = $request->fa_icon;
            $menu->link = $request->link;
            $menu->dropdown = $request->new_dropdown;
            $menu->is_default = $request->is_default;
            $menu->role_access = $request->role_access;
            $menu->update();
            DB::commit();

            return response()->json(['status'=>'success']);
        }catch(Exception $e){
            DB::rollback();
            return response()->json(['status'=>'error','errors'=>$e->getMessage()]);
        }
    }
    
    public function submenu_update(Request $request){
        $id = $request->id;
        
        $validator = Validator::make($request->all(),[
            'menu_name'=>'required',
            'link'=>'required',
            'add_on_name'=>'required',
            'role_access'=>'required'
        ]);

        if($validator->fails()){
            return response()->json(['status' => 'error', 'errors' => $validator->messages()]);
        }

        try{
            DB::beginTransaction();
            $menu = SubMenu::where('id',$id)->first();
            $menu->menu_name = $request->menu_name;
            $menu->add_on_name = $request->add_on_name;
            $menu->fa_icon = $request->fa_icon;
            $menu->link = $request->link;
            $menu->dropdown = 0;
            $menu->is_default = $request->is_default;
            $menu->role_access = $request->role_access;
            $menu->update();
            DB::commit();

            return response()->json(['status'=>'success']);
        }catch(Exception $e){
            DB::rollback();
            return response()->json(['status'=>'error','errors'=>$e->getMessage()]);
        }
    }

    // public function subMenu_list($id){
    //     Menu::
    // }
}
