
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
                <td class="text-capitalize">{{ $pathology['age'] ?? '' }}</td>
                <td class="text-capitalize">{{ $pathology['total'] ?? '' }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>

<script>
    $(document).ready(function (){
        $('.pathos').DataTable({
            "scrollY": "400px",
            "scrollCollapse": true
        });
    });
</script>
<script>
    $(document).ready(function(){
        $('.patho').DataTable({
            pageLength: 10,
            responsive: true,
            dom: '<"html5buttons"B>lTfgitp',
            buttons: [
                { extend: 'copy'},
                {extend: 'csv'},
                {extend: 'excel', title: 'ExampleFile'},
                {extend: 'pdf', title: 'ExampleFile'},

                {extend: 'print',
                    customize: function (win){
                        $(win.document.body).addClass('white-bg');
                        $(win.document.body).css('font-size', '10px');

                        $(win.document.body).find('table')
                            .addClass('compact')
                            .css('font-size', 'inherit');
                    }
                }
            ]

        });

    });

</script>
