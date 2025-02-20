@extends('backend.partials.master')
@section('title')
All Team Players
@endsection
@section('maincontent')
<main id="main" class="main">

    <section class="section">
        <div class="row">
            @foreach($teams as $team)
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">{{ $team->name }}</h5> <!-- Display team name -->

                        <!-- Table for each team -->
                        <table class="table table-danger" id="team-table-{{ $team->id }}">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Position</th>
                                    <th scope="col">Points</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                $totalPoints = 0;
                                @endphp
                                @foreach($team->players as $player)
                                @php
                                $totalPoints += $player->point; // Calculate total points for the team
                                @endphp
                                <tr>
                                    <th scope="row">{{ $loop->iteration }}</th>
                                    <td>{{ $player->name }}</td>
                                    <td>{{ $player->role }}</td>
                                    <td>{{ $player->point }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="3" class="text-right"><strong>Total Purchase Points</strong></td>
                                    <td><strong>{{ $totalPoints }}</strong></td>
                                </tr>
                                <tr>
                                    <td colspan="3" class="text-right"><strong>Remaining Points</strong></td>
                                    <td><strong>{{ 3000 - $totalPoints }}</strong></td>
                                </tr>
                            </tfoot>
                        </table>
                        <!-- Export to PDF Button for each team -->
                        <button class="btn btn-primary export-pdf" data-team-id="{{ $team->id }}">Export {{ $team->name }} to PDF</button>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </section>

</main><!-- End #main -->
@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.13/jspdf.plugin.autotable.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Add event listener to all buttons with class "export-pdf"
        document.querySelectorAll('.export-pdf').forEach(button => {
            button.addEventListener('click', function () {
                const teamId = this.getAttribute('data-team-id');  // Get the team ID from data attribute
                const teamName = this.innerText.replace('Export ', '').replace(' to PDF', ''); // Extract team name from button text
                
                const { jsPDF } = window.jspdf;
                const doc = new jsPDF();

                // Add the team name as the title in the PDF
                doc.setFontSize(18);
                doc.text(teamName + ' Players', 14, 22); // Title with team name
                doc.setFontSize(12); // Reset font size for table data

                // Find the table by ID using the team ID
                const table = document.getElementById('team-table-' + teamId);
                
                // Prepare table data for PDF
                const bodyData = [];
                const rows = table.querySelectorAll('tbody tr');
                rows.forEach(row => {
                    const rowData = [];
                    row.querySelectorAll('td,th').forEach(cell => {
                        rowData.push(cell.innerText);
                    });
                    bodyData.push(rowData);
                });

                const footerRows = table.querySelectorAll('tfoot tr');
                const footerData = [];
                footerRows.forEach(footerRow => {
                    const rowFooterData = [];
                    footerRow.querySelectorAll('td').forEach(cell => {
                        rowFooterData.push(cell.innerText);
                    });
                    footerData.push(rowFooterData);
                });

                // Add the table data to the PDF
                doc.autoTable({
                    startY: 30, // Start after the title
                    head: [['#', 'Name', 'Position', 'Points']],  // Table headers
                    body: bodyData,
                    foot: footerData.map(row => [{ content: row[0], colSpan: 3, styles: { halign: 'right' }}, row[1]]), // Add footer
                });

                // Save the generated PDF with team name
                doc.save('team-players-' + teamName + '.pdf');
            });
        });
    });
</script>
@endpush

@stack('scripts')
