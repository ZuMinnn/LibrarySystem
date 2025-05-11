<!DOCTYPE html>
<html lang="en">

  <head>

    @include('home.css')

    <style type="text/css">
      
      .table_deg
      {

        border: 1px solid white;
        margin: auto;
        text-align: center;
        margin-top: 100px;
      }

      th
      {
        background-color: #0063EC ;
        color: white;
        font-weight: bold;
        font-size: 20px;
        padding: 10px;
      }

      td 
      {
        color: white;
        background-color: black;
        border: 1px solid white;
      }


      .book_img
      {
        height: 120px;
        width: 80px;
        margin: auto;
      }


    </style>
    
  </head>

<body>

 @include('home.header')

  
 <div class="currently-market">
    <div class="container">
      <div class="row">

          @if(session()->has('message'))


          <div style="margin-top: 100px;" class="alert alert-success">
            

              {{session()->get('message')}}

              <button type="button" class="close" aria-hidden="true" data-bs-dismiss="alert">x</button>

          </div>

          @endif

        <table class="table_deg">
          
          <tr>
            <th>Tên sách</th>
            <th>Tác giả</th>
            <th>Trạng thái</th>
            <th>Ảnh</th>
            <th>Hủy Đơn</th>
           
          </tr>

          @foreach($data as $data)

          <tr>
            <td>{{$data->book->title}}</td>
            <td>{{$data->book->auther_name}}</td>
            <td>
                @if($data->status == 'rejected')
                    Bị từ chối
                @elseif($data->status == 'approved')
                    Đã duyệt
                @elseif($data->status == 'returned')
                    Đã trả
                @elseif($data->status == 'Applied')
                    Đang chờ duyệt
                @else
                    {{$data->status}}
                @endif
            </td>
            <td>
              
              <img class="book_img" src="book/{{$data->book->book_img}}">

            </td>

            <td>

                @if($data->status == 'Applied')

              <a href="{{url('cancel_req',$data->id)}}" class="btn btn-warning">Hủy đơn</a>

              @else

                <p style="color: white; font-weight: bold;">Không được phép</p>

              @endif
            </td>
          </tr>


          @endforeach


        </table>


      </div>
    </div>
  </div>


 @include('home.footer')

  </body>
</html>