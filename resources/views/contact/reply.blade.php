@extends('admin.master')
@section('title', 'Reply Contact')
@section('body')
<div class="main-container">
    <form action="{{ route('contact.sendReply', $contact->contact_id) }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="response">Nội dung phản hồi</label>
            <textarea name="response" id="response" class="form-control" rows="5" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Gửi phản hồi</button>
    </form>
</div>
@endsection
