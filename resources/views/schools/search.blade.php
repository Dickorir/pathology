
<div class="ibox-content table-responsive">

    <table class="table table-striped">
        <thead>
        <tr>
            <th>#</th>
            <th>Name</th>
            <th>Phone</th>
            <th>Email</th>
            <th>Status</th>
            <th>Role</th>
            <th>Date</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        @php $i = ($admins->currentpage()-1)* $admins->perpage() + 1;@endphp
        @foreach($admins as $admin)
            <tr>
                <td class="text-center">{{ $i++ }}</td>
                <td class="text-capitalize">{{ $admin->fullname ?? '' }}</td>
                <td class="text-capitalize">{{ $admin->phone ?? '' }}</td>
                <td class="text-capitalize">{{ $admin->email ?? '' }}</td>
                <td class="text-capitalize">{{ $admin->status == 1 ? 'Active' : 'Inactive' }}</td>
                <td class="text-capitalize">{{ $admin->role ?? '' }}</td>
                <td class="text-capitalize">{{ $admin->created_at ?? '' }}</td>
                <td>
                    <a href='{{ url('admin',$admin->id.'/edit') }}'><i class="fa fa-pencil-square-o text-info" title="edit admin"></i></a>
                    <a href='{{ url('admin',$admin->id.'/delete') }}' class="toa" id="{{ $admin->id }}"><i class="fa fa-trash-o text-danger" title="delete admin"></i></a>
                    {{--<a data-toggle="modal" class="btn btn-primary" href="#modal-form">Form in simple modal box</a>--}}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <div class="pull-right">
        {{ $admins->links() }}
    </div>

</div>
