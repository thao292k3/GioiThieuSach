@extends('admin.master')
@section('title', 'Contact Manager')
@section('body')
<div class="main-container">
    <div class="pd-ltr-20 xs-pd-20-10">
        <div class="min-height-100px">

            <!-- Contact Manager Table -->
            <div class="card-box mb-30">
                <div class="d-flex justify-content-between align-items-center pd-20">
                    <h4 class="text-blue h4">Contact Manager</h4>
                </div>

                <div class="pb-20">
                    <form class="form-inline ">
                        <div class="form-group">
                            <input class="form-control" placeholder="Enter name..." style="width: 300px; margin-right: 5px;">
                        </div>
                        <button class="btn btn-success btn-sm">
                            <i class="fa fa-search"></i>
                        </button>
                    </form>

                    <table class="data-table table stripe hover nowrap">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Tên sách </th>
                                <th>Giá sách</th>
                                <th>Ngày yêu thích </th>
                                <th>Hình ảnh sách </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($favorites as $item)
                            <tr>
                                <td scope="row">{{ $loop->index + 1 }}</td>
                                <td>{{ $item->prod->title }}</td>
                                <td>{{ $item->prod->price }} / {{ $item->prod->sale_price }}</td>
                                <td>{{ $item->created_at->format('d/m/Y') }}</td>
                                <td>
                                    <img src="{{ asset("storage/uploads/". $item->prod->cover_image) }}" width="60" alt="{{ $item->prod->title }}">
                                </td>
                                <td>
                                    <form action="{{ route('favorites.destroy', $item->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc muốn xóa yêu thích này?')">Xóa</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach                            
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Reply -->
<div class="modal fade" id="replyModal" tabindex="-1" aria-labelledby="replyModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="replyModalLabel">Reply to Contact</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="replyForm" method="POST" action="{{ route('contact.reply') }}">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="contact_id" id="contact_id">
                    <div class="mb-3">
                        <label for="contact_name" class="form-label">Contact Name</label>
                        <input type="text" class="form-control" id="contact_name" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="response" class="form-label">Response</label>
                        <textarea name="response" id="response" class="form-control" rows="4" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Send Reply</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Lấy tất cả các nút Reply
    const replyButtons = document.querySelectorAll('.btn-reply');

    // Gắn sự kiện click cho mỗi nút
    replyButtons.forEach(button => {
        button.addEventListener('click', function () {
            // Lấy thông tin từ nút
            const contactId = this.getAttribute('data-id');
            const contactName = this.getAttribute('data-name');

            // Gán thông tin vào form trong modal
            document.getElementById('contact_id').value = contactId;
            document.getElementById('contact_name').value = contactName;

            // Hiển thị modal
            const replyModal = new bootstrap.Modal(document.getElementById('replyModal'));
            replyModal.show();
        });
    });
});

</script>    