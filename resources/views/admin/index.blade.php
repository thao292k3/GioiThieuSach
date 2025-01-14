@extends('admin.master')
@section('body')
<div class="main-container">
    <div class="pd-ltr-20">
        <div class="card-box pd-20 height-100-p mb-30">
            <div class="row align-items-center">
                <div class="col-md-4">
                    <img src="vendors/images/banner-img.png" alt="" class="img-fluid rounded">
                </div>
                <div class="col-md-8">
                    <h4 class="font-20 weight-500 mb-10 text-capitalize">
                        Chào mừng bạn đến với trang quản trị viên
                    </h4>
                </div>
            </div>
        </div>

        <div class="container">
            <h1 class="mb-4 text-center text-primary">Thống kê</h1>
            <div class="row">
                <div class="col-md-4">
                    <div class="card shadow-sm rounded">
                        <div class="card-body text-center">
                            <h5>Sách</h5>
                            <p class="font-weight-bold">{{ $bookCount }} cuốn</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card shadow-sm rounded">
                        <div class="card-body text-center">
                            <h5>Bài viết</h5>
                            <p class="font-weight-bold">{{ $blogCount }} bài</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card shadow-sm rounded">
                        <div class="card-body text-center">
                            <h5>Người dùng</h5>
                            <p class="font-weight-bold">{{ $userCount }} người</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-md-6">
                    <div class="card shadow-sm rounded">
                        <div class="card-body text-center">
                            <h5>Liên hệ</h5>
                            <p class="font-weight-bold">{{ $contactCount }} liên hệ</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card shadow-sm rounded">
                        <div class="card-body text-center">
                            <h5>Bình luận</h5>
                            <p class="font-weight-bold">{{ $commentCount }} bình luận</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Biểu đồ thống kê -->
            <div class="mt-5">
                <h3 class="text-center">Biểu đồ thống kê</h3>
                <canvas id="myChart"></canvas>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            var ctx = document.getElementById('myChart').getContext('2d');
            var myChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ['Sách', 'Bài viết', 'Người dùng', 'Liên hệ', 'Bình luận'],
                    datasets: [{
                        label: '# of Entries',
                        data: [{{ $bookCount }}, {{ $blogCount }}, {{ $userCount }}, {{ $contactCount }}, {{ $commentCount }}],
                        backgroundColor: 'rgba(54, 162, 235, 0.2)',  // Sử dụng màu sắc nhẹ cho background
                        borderColor: 'rgba(54, 162, 235, 1)',  // Đổi màu đường viền của cột
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    },
                    plugins: {
                        tooltip: {
                            callbacks: {
                                label: function(tooltipItem) {
                                    return tooltipItem.raw + " entries";
                                }
                            }
                        }
                    }
                }
            });
        </script>
    </div>
</div>
@endsection
