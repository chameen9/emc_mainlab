@forelse($batches as $batch)
    <div class="card d-flex flex-row mb-3">
        <div class="d-flex flex-grow-1 min-width-zero">
            <div class="card-body d-flex flex-column flex-md-row justify-content-between align-items-md-center">
                <p class="list-item-heading mb-0 w-30">{{ $batch->batch_number }}</p>
                <p class="mb-0 text-muted w-15">{{ $batch->student_count }}</p>
                <p class="mb-0 text-muted w-15">{{ $batch->course_code }}</p>
                <p class="mb-0 text-muted w-15">{{ $batch->owner }}</p>

                <div class="w-15">
                    <span class="badge badge-pill
                        {{ $batch->status === 'Active' ? 'badge-success' :
                           ($batch->status === 'Scheduled' ? 'badge-primary' : 'badge-secondary') }}">
                        {{ ucwords(str_replace('_',' ', strtolower($batch->status))) }}
                    </span>
                </div>
                <label class="custom-control mb-0 align-self-center pr-4">
                    <a href="javascript:void(0)"
                    class="openBatchModal"
                    data-id="{{ $batch->id }}"
                    data-batch_number="{{ $batch->batch_number }}"
                    data-status="{{ $batch->status }}"
                    data-owner="{{ $batch->owner }}"
                    data-student_count="{{ $batch->student_count }}">
                        <span class="simple-icon-note"></span>
                    </a>
                </label>
            </div>
        </div>
    </div>
@empty
    <div class="alert alert-info text-center">
        No batches found
    </div>
@endforelse
