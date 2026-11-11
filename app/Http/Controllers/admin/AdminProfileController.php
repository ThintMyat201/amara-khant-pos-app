<?php

namespace App\Http\Controllers\admin;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;

class AdminProfileController extends Controller
{
   public function adminProfile(){

       $profileData=User::where('id',Auth::user()->id)->first();
       return view('admin.profile.accountprofile',compact('profileData'));
   }

   public function changePasswordView(){
      return view('admin.profile.changepassword');
   }

   public function changePassword(Request $request){
      $password=Auth::user()->password;
      $this->checkValidation($request);
      if( Hash::check($request->oldPassword,$password)){

        User::where('id',Auth::user()->id)->update([
          'password'=>Hash::make($request->newPassword)
        ]);
        Alert::success('Success Title', 'Success Message');
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');

      }
      else{
        Alert::error('Error Title', 'Error Message');
        return back();
      }
   }

   public function profileEditView(){
      $oldData=User::where('id',Auth::user()->id)->first();
      return view('admin.profile.profileedit',compact('oldData'));
   }

   public function profileEdit(Request $request){
         $data=['name' => $request->name,
                'phone' => $request->phone,
                'address' => $request->address,
              ];

        // Get old image name from DB
        $oldImageName = User::where('id', Auth::user()->id)->value('image');

        if ($request->hasFile('image')) {
            $destinationPath = $this->resolveWritableImageDirectory();
            // Delete old image if exists
            if ($oldImageName && file_exists($destinationPath . '/' . $oldImageName)) {
                @unlink($destinationPath . '/' . $oldImageName);
            }
            $fileName = uniqid() . $request->file('image')->getClientOriginalName();
            $request->file('image')->move($destinationPath, $fileName);
            $data['image'] = $fileName;
        } else {
            $data['image'] = $oldImageName;
        }

        User::where('id',Auth::user()->id)->update($data);
        Alert::success('Success Title', 'User updated successfully!');


        return redirect()->route('adminProfile');
   }

   private function resolveWritableImageDirectory(): string
   {
       $candidates = [
           public_path('images'),
           storage_path('app/public/images'),
           sys_get_temp_dir() . '/amara_images',
       ];

       foreach ($candidates as $path) {
           if (!File::exists($path)) {
               @File::makeDirectory($path, 0777, true, true);
           }
           @chmod($path, 0777);
           if (is_dir($path) && is_writable($path)) {
               return $path;
           }
       }

       return sys_get_temp_dir();
   }

   public function deleteProfile(Request $request)
   {
       $user = Auth::user();
       
       if (!$user) {
           return redirect('/');
       }

       // Check if user is an admin first, before any other operations
       if (strtolower($user->role) === 'admin') {
           Alert::error('Error', 'Admin accounts cannot be deleted!');
           return redirect()->route('adminProfile');
       }

       // Only proceed with deletion if not an admin
       $oldImageName = $user->image;
       if ($oldImageName && file_exists(public_path('images/' . $oldImageName))) {
           unlink(public_path('images/' . $oldImageName));
       }

       Auth::logout();
       $request->session()->invalidate();
       $request->session()->regenerateToken();

       $user->delete();
       return redirect('/');
   }

   private function checkValidation($request){
       $request->validate([
          'oldPassword'=>'required',
          'newPassword'=>'required|min:8',
          'confirmPassword'=>'required|min:8|same:newPassword'
       ]);
   }

}
