@extends('template/guest/main')

@section('title', 'Artikel | ')

@section('content')

<!-- Page top Section end -->
<section class="page-top-section set-bg bg-theme-1">
  <div class="container text-center">
    <h2>Artikel</h2>
  </div>
</section>
<div class="custom-shape-divider-top-1619270856">
    <svg data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none">
        <path d="M0,0V46.29c47.79,22.2,103.59,32.17,158,28,70.36-5.37,136.33-33.31,206.8-37.5C438.64,32.43,512.34,53.67,583,72.05c69.27,18,138.3,24.88,209.4,13.08,36.15-6,69.85-17.84,104.45-29.34C989.49,25,1113-14.29,1200,52.47V0Z" opacity=".25" class="shape-fill"></path>
        <path d="M0,0V15.81C13,36.92,27.64,56.86,47.69,72.05,99.41,111.27,165,111,224.58,91.58c31.15-10.15,60.09-26.07,89.67-39.8,40.92-19,84.73-46,130.83-49.67,36.26-2.85,70.9,9.42,98.6,31.56,31.77,25.39,62.32,62,103.63,73,40.44,10.79,81.35-6.69,119.13-24.28s75.16-39,116.92-43.05c59.73-5.85,113.28,22.88,168.9,38.84,30.2,8.66,59,6.17,87.09-7.5,22.43-10.89,48-26.93,60.65-49.24V0Z" opacity=".5" class="shape-fill"></path>
        <path d="M0,0V5.63C149.93,59,314.09,71.32,475.83,42.57c43-7.64,84.23-20.12,127.61-26.46,59-8.63,112.48,12.24,165.56,35.4C827.93,77.22,886,95.24,951.2,90c86.53-7,172.46-45.71,248.8-84.81V0Z" class="shape-fill"></path>
    </svg>
</div>
<!-- Page top Section end -->

<!-- Info Section -->
<div class="container my-5">
  <div class="kategori d-flex align-items-center" id="elem">
    <span class="badge bg-white px-3 shadow-sm mr-2"><p class="m-0">Artikel</p></span>
    <span class="badge bg-white px-3 shadow-sm mr-2"><p class="m-0">Tips & Trik</p></span>
    <span class="badge bg-white px-3 shadow-sm mr-2"><p class="m-0">Tak Berkategori</p></span>
  </div>
</div>
<section class="info-section spad pt-0">
  <div class="container">
    <div class="row">
      @foreach($blogs as $blog)
      <div class="col-lg-3 col-md-6 mb-3">
        <div class="card border-0 shadow-sm">
          <a href="/artikel/{{ $blog->blog_permalink }}{{ Session::get('ref') != null ? '?ref='.Session::get('ref') : '' }}">
          <img class="card-img-top" src="{{ $blog->blog_gambar != '' ? asset('assets/images/blog/'.$blog->blog_gambar) : asset('assets/images/default/artikel.jpg') }}" alt="Card image cap">
          </a>
          <div class="card-body">
            <h5 class="card-title"><a href="/artikel/{{ $blog->blog_permalink }}{{ Session::get('ref') != null ? '?ref='.Session::get('ref') : '' }}">{{ $blog->blog_title }}</a></h5>
          </div>
          <div class="card-footer d-flex justify-content-between align-items-center">
            <div>
              <p class="m-0"><small class="text-muted"><i class="fa fa-clock-o mr-1"></i>{{ time_elapsed_string($blog->blog_at) }}</small></p>
              <p class="m-0"><small class="text-muted"><i class="fa fa-user mr-1"></i><a class="text-link" href="{{ $blog->kontributor != '' ? '/kontributor/'.$blog->kontributor_slug : '/author/'.$blog->username }}{{ Session::get('ref') != null ? '?ref='.Session::get('ref') : '' }}">{{ $blog->kontributor != '' ? $blog->kontributor : $blog->nama_user }}</a></small></p>
            </div>
            <div>
              <i class="fa fa-share"></i>
            </div>
          </div>
        </div>
      </div>
      @endforeach
    </div>
    <div class="row mt-3" id="pagination">
      {!! $blogs->links() !!}
    </div>
  </div>
</section>
<!-- Info Section end -->

@endsection

@section('js-extra')

<script src="http://code.jquery.com/ui/1.9.2/jquery-ui.js"></script>
<script type="text/javascript">
     $(function() {
       var print = function(msg) {
         alert(msg);
       };

       var setInvisible = function(elem) {
         elem.css('visibility', 'hidden');
       };
       var setVisible = function(elem) {
         elem.css('visibility', 'visible');
       };

       var elem = $("#elem");
       var items = elem.children();

       // Inserting Buttons
       elem.prepend('<a href="#"><div class="shadow-sm" id="right-button" style="visibility: hidden;"><i class="fa fa-chevron-left"></i></div></a>');
       elem.append('<a href="#"><div class="shadow-sm" id="left-button"><i class="fa fa-chevron-right"></i></div></a>');

       // Inserting Inner
       items.wrapAll('<div id="inner" />');

       // Inserting Outer
       debugger;
       elem.find('#inner').wrap('<div id="outer"/>');

       var outer = $('#outer');

       var updateUI = function() {
         var maxWidth = outer.outerWidth(true);
         var actualWidth = 0;
         $.each($('#inner >'), function(i, item) {
           actualWidth += $(item).outerWidth(true);
         });

         if (actualWidth <= maxWidth) {
           setVisible($('#left-button'));
         }
       };
       updateUI();



       $('#right-button').click(function() {
         var leftPos = outer.scrollLeft();
         outer.animate({
           scrollLeft: leftPos - 200
         }, 800, function() {
           debugger;
           if ($('#outer').scrollLeft() <= 0) {
             setInvisible($('#right-button'));
           }
         });
       });

       $('#left-button').click(function() {
         setVisible($('#right-button'));
         var leftPos = outer.scrollLeft();
         outer.animate({
           scrollLeft: leftPos + 200
         }, 800);
       });

       $(window).resize(function() {
         updateUI();
       });
     });

</script>

@endsection

@section('css-extra')

<style type="text/css">
body{background-color: var(--light)}
.info-text {padding-top: 0;}
.info-text p {margin-bottom: 1rem!important;}
p{line-height: 1.5}
#pagination nav {margin-right: auto; margin-left: auto;}

.ql-align-left {text-align: left!important;}
.ql-align-right {text-align: right!important;}
.ql-align-center {text-align: center!important;}
.ql-align-justify {text-align: justify!important;}
.page-item.active .page-link {
  color: #fff;
  background-color: #46157a;
  border-color: #46157a;}
.page-link{color: #46157a}
.page-link:hover{color: #46157a}

.card-body {padding-top: 1rem; padding-bottom: 1rem;}
.card-title {margin-bottom: 0; line-height: 22px; height: 44px; display: -webkit-box !important; -webkit-line-clamp: 2; -moz-line-clamp: 2; -ms-line-clamp: 2; -o-line-clamp: 2; line-clamp: 2; -webkit-box-orient: vertical; -ms-box-orient: vertical; -o-box-orient: vertical; box-orient: vertical; overflow: hidden; text-overflow: ellipsis;}
#outer {float: left; width: 100%; overflow: hidden; white-space: nowrap; display: inline-block; padding: .5em;}
.hide {display: none;}
#left-button, #right-button {
    display: flex;
    width: 30px;
    text-align: center;
    background-color: var(--white);
    border-radius: 100%;
    width: 40px;
    height: 40px;
    justify-content: center;
    align-items: center;
}
.custom-shape-divider-top-1619270856 {
    top: 0;
    left: 0;
    width: 100%;
    overflow: hidden;
    line-height: 0;
}

.custom-shape-divider-top-1619270856 svg {
    position: relative;
    display: block;
    width: calc(100% + 1.3px);
    height: 150px;
}

.custom-shape-divider-top-1619270856 .shape-fill {
    fill: #46157A;
}
</style>

@endsection
