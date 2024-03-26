<div class="blog-sidebar mt-50">
    <div class="blog-category">
        <div class="category-title">
            <h4 class="title"><i class="fas fa-list"></i> &nbsp; All Categories</h4>
        </div>
        <div class="category-list">
            @php
            use App\Models\CategoryBusiness;
            $category = CategoryBusiness::wheretype('post')->get();
            @endphp
            <ul>
                @foreach ($category as $item)
                <li><a href="{{  route('main.page.category_business',$item->slug)}} ">{{ $item->name }} </a></li>
                @endforeach


            </ul>
        </div>
        {{-- <div class="category-more">
            <a href="#"><i class="lni-plus"></i> More Categories</a>
        </div> --}}
    </div>

</div>
