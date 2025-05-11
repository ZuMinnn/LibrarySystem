<div class="main-banner">
    <div class="container">
      <div class="row">

        <!-- ***** Main Banner Area Start ***** -->
        @if(session()->has('message'))
            <div class="alert alert-success">
                {{session()->get('message')}}
                <button type="button" class="close" data-bs-dismiss="alert" aria-hidden="true">x</button>
            </div>
        @endif

        @if(session()->has('error'))
            <div class="alert alert-danger">
                {{session()->get('error')}}
                <button type="button" class="close" data-bs-dismiss="alert" aria-hidden="true">x</button>
            </div>
        @endif

        <div class="col-lg-6 align-self-center">
          <div class="header-text">
            <h6>Sách là Bạn</h6>
            <h2>Vì Sách là bạn nên hãy đọc sách</h2>
            <p>Nếu Cần Đọc Sách Thì Mượn Ở Đây Nè!!!</p>
            <div class="buttons">
              <div class="border-button">
                <a href="explore.html">Xem Sách Mới</a>
              </div>
              <div class="main-button">
                <a href="" target="_blank">Mượn Sách Ngay</a>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-5 offset-lg-1">
          <div class="">
            <div class="item">
              <img src="assets/images/banner.png" alt="">
            </div>
            <div class="item">
              <img src="assets/images/banner2.png" alt="">
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- ***** Main Banner Area End ***** -->