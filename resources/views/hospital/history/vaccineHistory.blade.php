@extends('layouts.apex')

@section('title', 'Vaccination History - VacciTrack')

@section('content')
<div class="container-fluid px-0">

    <div class="apex-page-heading mb-4">
        <h1>Vaccination History Records</h1>
        <p>View and search all past vaccination records completed at your hospital.</p>
    </div>

    <!-- Stats Row (Optional but looks highly professional) -->
    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-3 p-4 bg-white">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-muted small text-uppercase d-block mb-1fw-bold">Total Vaccinations Done</span>
                        <h3 class="fw-bold text-success mb-0">{{ $history->count() }}</h3>
                    </div>
                    <div class="bg-success bg-opacity-10 text-success p-3 rounded-3">
                        <i class="bi bi-shield-check" style="font-size: 1.8rem;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- History Table Card -->
    <div class="row">
        <div class="col-md-12">
            <div class="card border-0 shadow-sm rounded-3 p-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="fw-bold text-secondary mb-0">Vaccinated Children List</h5>
                    
                    <!-- Quick Search Bar -->
                    <div class="search-box">
                        <input type="text" id="historySearch" class="form-control form-control-sm rounded-pill px-3" placeholder="Search child or vaccine..." style="width: 250px;">
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table align-middle table-hover" id="historyTable">
                        <thead class="table-light">
                            <tr>
                                <th style="width: 80px;">SR #</th>
                                <th>Child Name</th>
                                <th>Parent Name</th>
                                <th>Vaccine Given</th>
                                <th>Doctor Name</th>
                                <th>Vaccination Date</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($history as $key => $record)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td class="fw-bold text-dark">
                                    {{ $record->child->name ?? 'N/A' }}
                                </td>
                                <td class="text-muted">
                                    {{ $record->child->parent->name ?? 'N/A' }}
                                </td>
                                <td>
                                    {{ $record->doctor->name ?? 'N/A' }}
                                </td>
                                <td>
                                    <span class="badge bg-light text-primary border px-2.5 py-1.5 fw-medium">
                                        <i class="bi bi-droplet-fill me-1"></i> {{ $record->vaccine->name ?? 'N/A' }}
                                    </span>
                                </td>
                                <td class="text-secondary" style="font-size: 13px;">
                                    {{ $record->updated_at ? $record->updated_at->format('d M, Y - h:i A') : 'N/A' }}
                                </td>
                                <td>
                                    <span class="badge bg-success-subtle text-success border border-success border-opacity-25 px-2.5 py-1.5 rounded-pill fw-bold" style="font-size: 11px;">
                                        <i class="bi bi-check-circle-fill me-1"></i> Vaccinated
                                    </span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-5">
                                    <i class="bi bi-folder-x d-block mb-2" style="font-size: 2.5rem;"></i>
                                    No vaccination records found.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Quick Search Functionality (Vanilla JS) -->
<script>
document.getElementById('historySearch').addEventListener('keyup', function() {
    let filter = this.value.toUpperCase();
    let rows = document.querySelector("#historyTable tbody").rows;
    
    for (let i = 0; i < rows.length; i++) {
        let firstCol = rows[i].cells[1] ? rows[i].cells[1].textContent : "";
        let thirdCol = rows[i].cells[3] ? rows[i].cells[3].textContent : "";
        
        if (firstCol.toUpperCase().indexOf(filter) > -1 || thirdCol.toUpperCase().indexOf(filter) > -1) {
            rows[i].style.display = "";
        } else {
            rows[i].style.display = "none";
        }      
    }
});
</script>
@endsection