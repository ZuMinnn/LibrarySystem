<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Book;

 use App\Models\Borrow;

 use App\Models\Category;

 use Illuminate\Support\Facades\Auth;

 use App\Models\User;

use Exception;
use Illuminate\Database\QueryException;

class HomeController extends Controller
{
    public function index()
    {   

        $data= Book::all();

        return view('home.index',compact('data'));
    }


    public function book_details($id)
    {
        $data = Book::find($id);

        return view('home.book_details',compact('data'));


    }



    public function borrow_books($id)
    {
        $data = Book::find($id);
        $book_id = $id;
        $quantity = $data->quantity;

        if($quantity >= '1')
        {
            if (Auth::id()) 
            {
                try {
                    $user_id = Auth::user()->id;
                    $borrow = new Borrow;
                    $borrow->book_id = $book_id;
                    $borrow->user_id = $user_id;
                    $borrow->status = 'Applied';
                    $borrow->save();
                    
                    return redirect()->back()->with('message', 'Đã gửi yêu cầu mượn sách đến quản trị viên');
                } catch (QueryException $e) {
                    // Kiểm tra nếu là lỗi từ trigger unique constraint
                    if ($e->errorInfo[1] == 1644 && str_contains($e->getMessage(), 'already borrowed')) {
                        return redirect()->back()->with('error', 'Bạn đã mượn cuốn sách này và chưa trả');
                    }
                    // Các lỗi khác
                    return redirect()->back()->with('error', 'Có lỗi xảy ra khi mượn sách');
                }
            }
            else
            {
                return redirect('/login');
            }
        }
        else 
        {
            return redirect()->back()->with('error', 'Sách này hiện không có sẵn');
        }
    }


    public function book_history()
    {

        if(Auth::id())
        {

            $userid = Auth::user()->id;

            $data = Borrow::where('user_id','=',$userid)->get();


            return view('home.book_history',compact('data'));


        }


        

    }


    public function cancel_req($id)
    {

        $data = Borrow::find($id);

        $data->delete();

        return redirect()->back()->with('message','Đã hủy yêu cầu mượn sách thành công');

    }


    public function explore()
    {
         $category = Category::all();

        $data = Book::all();

        return view('home.explore',compact('data','category'));


    }


    public function search(Request $request)
    {

        $category = Category::all();

        $search = $request->search;

        $data = Book::where('title','LIKE','%'.$search.'%')->orWhere('auther_name','LIKE','%'.$search.'%')->get();

        return view('home.explore',compact('data','category'));

    }


    public function cat_search($id)
    {   
        $category = Category::all();

        $data = Book::where('category_id',$id)->get();

        return view('home.explore',compact('data','category'));


    }
}
