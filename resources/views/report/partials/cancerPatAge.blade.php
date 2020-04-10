
<div class="table-responsive">
    <table class="table table-striped table-bordered table-hover patho " >
        <thead>
        <tr>
            <th>#</th>
            <th>Age</th>
            <th>Total</th>
        </tr>
        </thead>
        <tbody>
        @php $i = 1;@endphp
        @foreach($pathologies as $pathology)
            <tr>
                <td class="text-center">{{ $i++ }}</td>
                <td class="text-capitalize">{{ $pathology->age ?? '' }}</td>
                <td class="text-capitalize">{{ $pathology->total ?? '' }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
