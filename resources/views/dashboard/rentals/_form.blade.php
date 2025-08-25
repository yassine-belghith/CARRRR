@csrf


<div class="row">
    <div class="col-md-4">
        <div class="form-group">
            <label for="user_id">Client <span class="text-danger">*</span></label>
            <select name="user_id" id="user_id" class="form-control @error('user_id') is-invalid @enderror" required>
                <option value="">Sélectionner un client</option>
                @foreach($users as $user)
                    <option value="{{ $user->id }}" {{ (old('user_id', $rental->user_id ?? '') == $user->id) ? 'selected' : '' }}>
                        {{ $user->name }} ({{ $user->email }})
                    </option>
                @endforeach
            </select>
            @error('user_id')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>
    
    
    
    <div class="col-md-4">
        <div class="form-group">
            <label for="location_id">Lieu de prise en charge</label>
            <select name="location_id" id="location_id" class="form-control @error('location_id') is-invalid @enderror">
                <option value="">Sélectionner un lieu</option>
                @foreach($locations as $location)
                    <option value="{{ $location->id }}" {{ (old('location_id', $rental->location_id ?? '') == $location->id) ? 'selected' : '' }}>
                        {{ $location->name }}
                    </option>
                @endforeach
            </select>
            @error('location_id')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>

    <div class="col-md-4">
        <div class="form-group">
            <label for="car_id">Véhicule <span class="text-danger">*</span></label>
            <select name="car_id" id="car_id" class="form-control @error('car_id') is-invalid @enderror" required>
                <option value="">Sélectionner un véhicule</option>
                @foreach($cars as $car)
                    <option 
                        value="{{ $car->id }}" 
                        data-price="{{ $car->price_per_day }}"
                        {{ (old('car_id', $rental->car_id ?? '') == $car->id) ? 'selected' : '' }}
                    >
                        {{ $car->brand }} {{ $car->model }} ({{ $car->license_plate }}) - {{ number_format($car->price_per_day, 2, ',', ' ') }} €/jour
                    </option>
                @endforeach
            </select>
            @error('car_id')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>
</div>

 

<div class="row mt-3">
    <div class="col-md-4">
        <div class="form-group">
            <label for="rental_date">Date de début <span class="text-danger">*</span></label>
            <input type="date" 
                   name="rental_date" 
                   id="rental_date" 
                   class="form-control @error('rental_date') is-invalid @enderror" 
                   value="{{ old('rental_date', isset($rental->rental_date) ? $rental->rental_date->format('Y-m-d') : '') }}" 
                   required
                   min="{{ date('Y-m-d') }}">
            @error('rental_date')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="form-group">
            <label for="return_date">Date de fin <span class="text-danger">*</span></label>
            <input type="date" 
                   name="return_date" 
                   id="return_date" 
                   class="form-control @error('return_date') is-invalid @enderror" 
                   value="{{ old('return_date', isset($rental->return_date) ? $rental->return_date->format('Y-m-d') : '') }}" 
                   required
                   min="{{ date('Y-m-d') }}">
            @error('return_date')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="form-group mb-3">
            <label for="status">Statut <span class="text-danger">*</span></label>
            <select name="status" id="status" class="form-control @error('status') is-invalid @enderror" required>
                <option value="pending" {{ old('status', $rental->status ?? '') == 'pending' ? 'selected' : '' }}>En attente</option>
                <option value="approved" {{ old('status', $rental->status ?? '') == 'approved' ? 'selected' : '' }}>Confirmée</option>
                <option value="completed" {{ old('status', $rental->status ?? '') == 'completed' ? 'selected' : '' }}>Terminée</option>
                <option value="cancelled" {{ old('status', $rental->status ?? '') == 'cancelled' ? 'selected' : '' }}>Annulée</option>
            </select>
            @error('status')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="form-group">
            <label for="driver_id">Chauffeur</label>
            <select name="driver_id" id="driver_id" class="form-control @error('driver_id') is-invalid @enderror">
                <option value="">-- Sélectionner un chauffeur --</option>
                @foreach($drivers as $driver)
                    <option value="{{ $driver->id }}" {{ old('driver_id', $rental->driver_id ?? '') == $driver->id ? 'selected' : '' }}>
                        {{ $driver->name }}
                    </option>
                @endforeach
            </select>
            @error('driver_id')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
            <small class="text-muted">Seuls les chauffeurs disponibles seront listés après sélection des dates.</small>
        </div>
    </div>
</div>

<div class="row mt-3">
    <div class="col-md-6">
        <div class="form-group">
            <label for="total_price">Prix total (€)</label>
            <input type="number" 
                   name="total_price" 
                   id="total_price" 
                   class="form-control" 
                   value="{{ old('total_price', $rental->total_price ?? '0.00') }}" 
                   readonly>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="form-group">
            <label for="days">Nombre de jours</label>
            <input type="number" 
                   id="days" 
                   class="form-control" 
                   value="{{ isset($rental) && $rental->rental_date && $rental->return_date ? max(1, $rental->return_date->diffInDays($rental->rental_date)) : 0 }}" 
                   readonly>
        </div>
    </div>
</div>

<div class="form-group mt-3">
    <label for="notes">Notes</label>
    <textarea name="notes" 
              id="notes" 
              class="form-control @error('notes') is-invalid @enderror" 
              rows="3">{{ old('notes', $rental->notes ?? '') }}</textarea>
    @error('notes')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
</div>

<div class="form-group mt-4">
    <button type="submit" class="btn btn-primary">
        <i class="fas fa-save"></i> Enregistrer
    </button>
    <a href="{{ route('dashboard.rentals.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Retour
    </a>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const rentalDateInput = document.getElementById('rental_date');
        const returnDateInput = document.getElementById('return_date');
        const carSelect = document.getElementById('car_id');
        const driverSelect = document.getElementById('driver_id');
        const daysInput = document.getElementById('days');
        const totalPriceInput = document.getElementById('total_price');
        const rentalId = {{ isset($rental) ? (int)$rental->id : 'null' }};

        function computeDays() {
            const sd = rentalDateInput.value;
            const ed = returnDateInput.value;
            if (!sd || !ed) return 0;
            const start = new Date(sd);
            const end = new Date(ed);
            if (isNaN(start) || isNaN(end) || end < start) return 0;
            const ms = end - start;
            const diffDays = Math.max(1, Math.ceil(ms / (1000*60*60*24)));
            return diffDays;
        }

        function updateTotals() {
            const days = computeDays();
            daysInput.value = days;
            const selected = carSelect.options[carSelect.selectedIndex];
            const pricePerDay = selected ? parseFloat(selected.getAttribute('data-price')) : 0;
            const total = days > 0 ? (days * pricePerDay) : 0;
            totalPriceInput.value = total.toFixed(2);
        }

        async function refreshAvailableDrivers() {
            const sd = rentalDateInput.value;
            const ed = returnDateInput.value;
            const loc = document.getElementById('location_id');
            const locationId = loc ? loc.value : null;
            if (!sd || !ed) {
                driverSelect.innerHTML = '<option value="">-- Sélectionner un chauffeur --</option>';
                return;
            }
            try {
                const params = new URLSearchParams({ rental_date: sd, return_date: ed });
                if (locationId) params.append('location_id', locationId);
                if (rentalId) params.append('rental_id', rentalId);
                const res = await fetch(`{{ route('dashboard.rentals.availableDrivers') }}?${params.toString()}`);
                if (!res.ok) throw new Error('HTTP '+res.status);
                const json = await res.json();
                const current = driverSelect.value;
                driverSelect.innerHTML = '<option value="">-- Sélectionner un chauffeur --</option>';
                json.data.forEach(d => {
                    const opt = document.createElement('option');
                    opt.value = d.id;
                    opt.textContent = `${d.name} (${d.email})`;
                    driverSelect.appendChild(opt);
                });
                if (current) {
                    const stillExists = Array.from(driverSelect.options).some(o => o.value === current);
                    if (stillExists) driverSelect.value = current;
                }
            } catch (e) {
                console.error('Failed to load available drivers', e);
            }
        }

        function onDatesChanged() {
            updateTotals();
            refreshAvailableDrivers();
        }

        rentalDateInput.addEventListener('change', function() {
            returnDateInput.min = this.value;
            onDatesChanged();
        });
        returnDateInput.addEventListener('change', onDatesChanged);
        carSelect.addEventListener('change', updateTotals);

        // Initialize
        updateTotals();
        refreshAvailableDrivers();
    });
</script>
@endpush
