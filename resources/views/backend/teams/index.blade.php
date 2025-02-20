@extends('backend.partials.master')
@section('title')
Teams
@endsection
@section('maincontent')
<main id="main" class="main">

    <div class="pagetitle">
        <h1>Teams Tables</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashborad</a></li>
                <li class="breadcrumb-item">Tables</li>
                <li class="breadcrumb-item active">Teams</li>
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
                @endif

                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <h5 class="card-title">Teams Table</h5>
                            </div>
                            @if (auth()->user()->id == 1)
                            <div class="col text-end">
                                <a class="btn btn-primary" href="{{route('team.create')}}">
                                    <i class="bi bi-plus"></i> Add
                                </a>
                            </div>
                            @endif
                        </div>
                        <!-- <p>Add lightweight datatables to your project with using the <a href="https://github.com/fiduswriter/Simple-DataTables" target="_blank">Simple DataTables</a> library. Just add <code>.datatable</code> class name to any table you wish to conver to a datatable. Check for <a href="https://fiduswriter.github.io/simple-datatables/demos/" target="_blank">more examples</a>.</p> -->

                        <!-- Table with stripped rows -->
                        <table class="table datatable">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>
                                        Team Name
                                    </th>
                                    <th>Image</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $i=1; @endphp
                                @foreach($teams as $team)
                                <tr>
                                    <td>{{$i++}}</td>
                                    <td>{{$team->name}}</td>
                                    <td>
                                        @if($team->image && file_exists(public_path('backend/team-images/' . $team->image)))
                                        <img src="{{ asset('backend/team-images/' . $team->image) }}" alt="{{ $team->name }}" width="50" height="50">
                                        @else
                                        <img src="{{ asset('backend/team-images/bcc.jpeg') }}" alt="Default Image" width="50" height="50">
                                        @endif
                                    </td>
                                    <td>
                                        @if (auth()->user()->id == 1)

                                        <!-- view -->
                                        <!-- <a href=""><i class="bi bi-eye"></i></a> -->
                                        <!-- edit -->
                                        <a href="{{route('team.edit',$team->id)}}"><i class="bi bi-pencil-square"></i></a>
                                        <!-- delete -->
                                        <a href="#" data-bs-toggle="modal" data-bs-target="#deleteModal-{{ $team->id }}">
                                            <i class="bi bi-trash" style="color: red;"></i>
                                        </a>

                                        <!-- Modal -->
                                        <div class="modal fade" id="deleteModal-{{ $team->id }}" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="deleteModalLabel">Confirm Delete</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        Are you sure you want to delete this team?
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>

                                                        <!-- Delete form -->
                                                        <form action="{{ route('team.delete', $team->id) }}" method="POST">
                                                            @method('DELETE')
                                                            @csrf
                                                            <button type="submit" class="btn btn-danger">Delete</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @endif
                                    </td>
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