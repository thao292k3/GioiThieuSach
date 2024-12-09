@extends('site.master')

@section('title', 'Trang Bai Viet')

@section('body')

<!-- Breadcrumb Section Begin -->
<section class="breadcrumb-section set-bg" data-setbg="img/breadcrumb.jpg">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <div class="breadcrumb__text">
                    <h2>Blog</h2>
                    <div class="breadcrumb__option">
                        <a href="./index.html">Home</a>
                        <span>Blog</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Breadcrumb Section End -->

<!-- Blog Section Begin -->
<section class="blog spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-md-5">
                <div class="blog__sidebar">
                    <div class="blog__sidebar__search">
                        <form action="#">
                            <input type="text" placeholder="Search...">
                            <button type="submit"><span class="icon_search"></span></button>
                        </form>
                    </div>
                    <div class="blog__sidebar__item">
                        <h4>Categories</h4>
                        <ul id="category-list">
                            @foreach($limitedCategories as $item)
                                <li><a href="#">{{ $item->name }}</a></li>
                            @endforeach
                        </ul>
                        @if($data->count() > 7)
                            <a href="javascript:void(0);" id="see-more-btn" style="color: blue; text-decoration: underline;">See more</a>
                        @endif
                        <a href="javascript:void(0);" id="go-back-btn" style="color: red; text-decoration: underline; display: none;">Go back</a>
                    </div>

                    <script>
                        document.addEventListener('DOMContentLoaded', function () {
                            const data = @json($data); // Tất cả thể loại từ server
                            const categoryList = document.getElementById('category-list');
                            const seeMoreBtn = document.getElementById('see-more-btn');
                            const goBackBtn = document.getElementById('go-back-btn');
                    
                            // Lưu trạng thái danh sách ban đầu
                            const initialCategories = data.slice(0, 7);
                    
                            if (seeMoreBtn) {
                                seeMoreBtn.addEventListener('click', function () {
                                    // Hiển thị danh sách đầy đủ
                                    data.slice(7).forEach(item => {
                                        const li = document.createElement('li');
                                        li.innerHTML = `<a href="#">${item.name}</a>`;
                                        categoryList.appendChild(li);
                                    });
                    
                                    // Ẩn "See more" và hiện "Go back"
                                    this.style.display = 'none';
                                    goBackBtn.style.display = 'inline';
                                });
                            }
                    
                            if (goBackBtn) {
                                goBackBtn.addEventListener('click', function () {
                                    // Xóa danh sách hiện tại và phục hồi danh sách ban đầu
                                    categoryList.innerHTML = '';
                                    initialCategories.forEach(item => {
                                        const li = document.createElement('li');
                                        li.innerHTML = `<a href="#">${item.name}</a>`;
                                        categoryList.appendChild(li);
                                    });
                    
                                    // Hiện "See more" và ẩn "Go back"
                                    seeMoreBtn.style.display = 'inline';
                                    this.style.display = 'none';
                                });
                            }
                        });
                    </script>

                    <div class="blog__sidebar__item">
                        <h4>Recent News</h4>
                        <div class="blog__sidebar__recent">
                            @foreach($recentBlogs as $blog)
                                <a href="{{ route('blogdetail', ['id' => $blog->id]) }}" class="blog__sidebar__recent__item">
                                    <div class="blog__sidebar__recent__item__pic">
                                        <img src="{{ asset($blog->image_path) }}" alt="{{ $blog->title }}">
                                    </div>
                                    <div class="blog__sidebar__recent__item__text">
                                        <h6>{{ Str::limit($blog->title, 40) }}</h6>
                                        <span>{{ $blog->created_at->format('M d, Y') }}</span>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>

                    <div class="blog__sidebar__item">
                        <h4>Search By</h4>
                        <div class="blog__sidebar__item__tags">
                            @foreach($limitedCategories as $item)
                                <a href="#">{{ $item->name }}</a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-8 col-md-7">
                <div class="row">
                    @foreach($blogs as $item)
                        <div class="col-lg-6 col-md-6 col-sm-6">
                            <div class="blog__item">
                                <div class="blog__item__pic">
                                    <img src="{{ asset($item->image_path) }}" alt="{{ $item->title }}">
                                </div>
                                <div class="blog__item__text">
                                    <h3>{{ $item->title }}</h3>
                                    <p>{{ Str::limit($item->content, 100, '...') }}</p>
                                    <a href="{{ route('blogs.show', $item->blog_id) }}" class="btn btn-primary">Read More</a>

                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                {{ $blogs->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>
</section>
<!-- Blog Section End -->

@stop
