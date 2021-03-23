
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-sm-flex no-block justify-content-between align-items-center">
                <h4 class="page-title">{{ $breadcrumb['title'] }}</h4>
				<nav aria-label="breadcrumb">
					<ol class="breadcrumb">
						<li class="breadcrumb-item"><a href="/admin">Home</a></li>
                        @foreach($breadcrumb['items'] as $key=>$item)
                            @if($key == (count($breadcrumb['items']) - 1))
                            <li class="breadcrumb-item active" aria-current="page">{{ $item['text'] }}</li>
                            @else
                            <li class="breadcrumb-item"><a href="{{ $item['url'] }}">{{ $item['text'] }}</a></li>
                            @endif
                        @endforeach
					</ol>
				</nav>
            </div>
        </div>
    </div>