@extends('backend.layouts.app')

@section('title', 'Trash User List')

@section('styles')
<style>
    .avatar-img {
        width: 50px;
        height: auto;
    }
</style>
@endsection

@section('content')
<div class="container-fluid card">
    <table class="table table-bordered data-table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Avatar</th>
                <th width="100px">Action</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        $('.data-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('trash.user') }}",
            columns: [
                { data: 'name', name: 'name' },
                { data: 'email', name: 'email' },
                { data: 'avatar', name: 'avatar', orderable: false, searchable: false },
                { data: 'action', name: 'action', orderable: false, searchable: false },
            ]
        });

        $(document).on('click', '.delete-btn-permanent', function(e) {
            e.preventDefault();
            var form = $(this).closest('form');
            var name = $(this).data('name');
            if (confirm('Are you sure you want to permanent delete ' + name + '?')) {
                form.submit();
            }
        });
     });
</script>
@endsection