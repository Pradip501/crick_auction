@extends('backend.partials.master')
@section('title')
Players
@endsection
@section('maincontent')
<main id="main" class="main">

    <div class="pagetitle">
        <h1>Players Tables</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashborad</a></li>
                <li class="breadcrumb-item">Tables</li>
                <li class="breadcrumb-item active">Players</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <!-- Success Message Alert -->
                @if (session('success'))
                <div id="success-alert" class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }} <!-- Display success message -->
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @elseif (session('failed'))
                <div id="danger-alert" class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('failed') }} <!-- Display failed message -->
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif

                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <h5 class="card-title">Players Table</h5>
                            </div>
                            <div class="col text-end">
                                <a class="btn btn-primary" href="{{route('player.create')}}">
                                    <i class="bi bi-plus"></i> Add
                                </a>
                                <!-- Export PDF button -->
                                <!-- <button class="btn btn-secondary export-pdf" data-team-id="players">
                                    <i class="bi bi-file-earmark-pdf"></i> Export to PDF
                                </button> -->
                            </div>
                        </div>
                        <!-- <p>Add lightweight datatables to your project with using the <a href="https://github.com/fiduswriter/Simple-DataTables" target="_blank">Simple DataTables</a> library. Just add <code>.datatable</code> class name to any table you wish to conver to a datatable. Check for <a href="https://fiduswriter.github.io/simple-datatables/demos/" target="_blank">more examples</a>.</p> -->

                        <!-- Table with stripped rows -->
                        <table class="table table-borderless" id="playerTable">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>
                                        Player Name
                                    </th>
                                    <th>Playing Role</th>
                                    <th>Image</th>
                                    @if (auth()->user()->id == 1)
                                    <th>Action</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @php $i=1; @endphp
                                @foreach($players as $play)
                                <tr>
                                    <td>{{$i++}}</td>
                                    <td>{{$play->name}}</td>
                                    <td>{{$play->role}}</td>
                                    <!-- <td>{{$play->image}}</td> -->
                                    <td>
                                        @if($play->image && file_exists(public_path('backend/player-images/' . $play->image)))
                                        <img src="{{ asset('backend/player-images/' . $play->image) }}" alt="{{ $play->name }}" width="50" height="50">
                                        @else
                                        <img src="{{ asset('backend/player-images/bcc.jpeg') }}" alt="Default Image" width="50" height="50">
                                        @endif
                                    </td>
                                    @if (auth()->user()->id == 1)
                                    <td>
                                        <!-- view -->
                                        <a href="{{route('player.view',$play->id)}}"><i class="bi bi-eye"></i></a>
                                        <!-- edit -->
                                        <a href="{{route('player.edit',$play->id)}}"><i class="bi bi-pencil-square"></i></a>
                                        <!-- delete -->
                                        <a href="#" data-bs-toggle="modal" data-bs-target="#deleteModal-{{ $play->id }}">
                                            <i class="bi bi-trash" style="color: red;"></i>
                                        </a>

                                        <!-- Modal -->
                                        <div class="modal fade" id="deleteModal-{{ $play->id }}" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="deleteModalLabel">Confirm Delete</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        Are you sure you want to delete this player?
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>

                                                        <!-- Delete form -->
                                                        <form action="{{ route('player.delete', $play->id) }}" method="POST">
                                                            @method('DELETE')
                                                            @csrf
                                                            <button type="submit" class="btn btn-danger">Delete</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    @endif
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <!-- End Table with stripped rows -->

                    </div>
                </div>

            </div>
        </div>
    </section>

</main><!-- End #main -->
@endsection
@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.13/jspdf.plugin.autotable.min.js"></script>

<script>
    // document.addEventListener('DOMContentLoaded', function() {
    //     // Add event listener to export PDF button
    //     document.querySelectorAll('.export-pdf').forEach(button => {
    //         button.addEventListener('click', function() {
    //             const {
    //                 jsPDF
    //             } = window.jspdf;
    //             const doc = new jsPDF();

    //             const table = document.querySelector('.datatable'); // Select the players table
    //             const teamName = "Players"; // Set the title of the PDF

    //             // Add the table title to the PDF
    //             doc.setFontSize(18);
    //             // doc.text(teamName + ' List', 14, 22);
    //             doc.setFontSize(12); // Reset font size for table data

    //             // Prepare table data for PDF (only ID and Name)
    //             const bodyData = [];
    //             const rows = table.querySelectorAll('tbody tr');
    //             rows.forEach(row => {
    //                 const rowData = [];
    //                 // Get the first two cells (ID and Name)
    //                 row.querySelectorAll('td').forEach((cell, index) => {
    //                     if (index === 0 || index === 1) { // Only include ID and Name
    //                         rowData.push(cell.innerText.trim());
    //                     }
    //                 });
    //                 bodyData.push(rowData); // Add row data to bodyData
    //             });

    //             // Define table headers (ID and Name)
    //             const head = [
    //                 ['ID', 'Player Name']
    //             ];

    //             // Add the table data to the PDF
    //             doc.autoTable({
    //                 startY: 30, // Start after the title
    //                 head: head, // Table headers (ID and Name)
    //                 body: bodyData,
    //             });

    //             // Save the generated PDF
    //             doc.save('players-list.pdf');
    //         });
    //     });
    // });
</script>

<!-- DataTables and Buttons Scripts -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.4/css/buttons.dataTables.min.css">

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.4/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.4/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.4/js/buttons.print.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>

<script>
    $(document).ready(function() {
        $('#playerTable').DataTable({
            "paging": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "lengthMenu": [10, 25, 50],
            dom: 'Bfrtip',
            buttons: [{
                    extend: 'excelHtml5',
                    exportOptions: {
                        columns: [1, 2] // Export only the 1st (Player Name) and 2nd (Playing Role) columns
                    }
                },
                {
                    extend: 'pdfHtml5',
                    exportOptions: {
                        columns: [1, 2] // Export only the 1st and 2nd columns
                    }
                },
                {
                    extend: 'print',
                    exportOptions: {
                        columns: [1, 2] // Export only the 1st and 2nd columns
                    }
                }
            ]
        });
    });
</script>


@endpush

@stack('scripts')