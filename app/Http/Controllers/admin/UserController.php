<?php

namespace App\Http\Controllers\admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;

class UserController extends Controller
{
    public function userCreateView(){
        return view('admin.management.usercreate');
     }

    public function userListView(){
        $userData = User::orderBy('created_at', 'desc')->get();
        return view('admin.management.userlist',compact('userData'));
    }

    public function userDetailView($id){
        $userData=User::where('id',$id)->first();
        return view('admin.management.userdetail',compact('userData'));
    }

    public function deleteAccount($id)
    {
        $user = User::where('id', $id)->first();
        
        if (!$user) {
            return redirect()->route('userListView');
        }
        
        // Check if user is an admin first, before any other operations
        if (strtolower($user->role) === 'admin') {
            Alert::error('Error', 'Admin accounts cannot be deleted!');
            return redirect()->route('userListView');
        }

        // Only proceed with deletion if not an admin
        $oldImageName = $user->image;
        if ($oldImageName && file_exists(public_path('images/' . $oldImageName))) {
            unlink(public_path('images/' . $oldImageName));
        }
        
        $user->delete();
        Alert::success('Success', 'Account deleted successfully!');
        return redirect()->route('userListView');
    }


    public function userCreate(Request $request){
         $this->checkValidation($request);

         User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'phone' => $request->phone,
                'address' => $request->address,
                'role' => $request->role,
            ]);

            Alert::success('Success', 'User created successfully!');
            return redirect()->route('userListView');

    }

    public function userEditView($id){
        $oldData=User::where('id',$id)->first();
        return view('admin.management.useredit',compact('oldData'));

    }

    public function userEdit(Request $request){
       $validationRules = [
            'name' => 'required|min:1|max:199|unique:users,name,' . $request->id,
            'email' => 'required|email|unique:users,email,' . $request->id,
            'phone' => 'nullable|numeric',
            'address' => 'nullable|string|max:255',
            'image' => 'file|mimes:jpg,jpeg,png,webp,svg',
        ];

        // Only admins can change roles
        if (auth()->user()->role == 'Admin' && $request->has('role')) {
            $validationRules['role'] = 'required|in:Admin,User';
        }

       $request->validate($validationRules, [
            'name.required' => 'ဖြည့်စွက်ရန် လိုအပ်ပါသည်',
            'email.required' => 'ဖြည့်စွက်ရန် လိုအပ်ပါသည်',
            'image.file' => 'ဓာတ်ပုံဖိုင်တစ်ခုသာ ရွေးချယ်ပါ',
        ]);
       $data=['name' => $request->name,
                'phone' => $request->phone,
                'address' => $request->address,
              ];

        // Only admins can update roles
        if (auth()->user()->role == 'Admin' && $request->has('role')) {
            $data['role'] = $request->role;
        }

        // Get old image name from DB
        $oldImageName = User::where('id', $request->id)->value('image');

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($oldImageName && file_exists(public_path('images/' . $oldImageName))) {
                unlink(public_path('images/' . $oldImageName));
            }
            $fileName = uniqid() . $request->file('image')->getClientOriginalName();
            $request->file('image')->move(public_path('images'), $fileName);
            $data['image'] = $fileName;
        } else {
            $data['image'] = $oldImageName;
        }

        User::where('id', $request->id)->update($data);
        $userData=User::where('id',$request->id)->first();
        Alert::success('Success Title', 'User updated successfully!');


        return view('admin.management.userdetail',compact('userData'));
    }


    private function checkValidation($request)
    {
        $rules = [
            'name' => 'required|min:1|max:199|unique:users,name,'. $request->id, 
            'email' => 'required|email|unique:users,email,' . $request->id,
            'password'=>'required|min:8|max:16',
            'confirmPassword'=>'required|same:password|min:8|max:16',
            'image' => 'file|mimes:jpg,jpeg,png,webp,svg',
            'role' => 'required|in:Admin,User',
            // 'phone'=>'numeric',
        ];

        $message = [
            'name.required' => 'ဖြည့်စွက်ရန် လိုအပ်ပါသည်',
            'email.required' => 'ဖြည့်စွက်ရန် လိုအပ်ပါသည်',
            'password.required' => 'ဖြည့်စွက်ရန် လိုအပ်ပါသည်',
            'confirmPassword.required' => 'ဖြည့်စွက်ရန် လိုအပ်ပါသည်',
            'image.file' => 'ဓာတ်ပုံဖိုင်တစ်ခုသာ ရွေးချယ်ပါ',
        ];

        $request->validate($rules, $message);
    }


}
