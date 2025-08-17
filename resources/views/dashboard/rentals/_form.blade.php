@csrf

<div class="row">
    <div class="col-md-6">
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
    
    <div class="col-md-6">
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
    <div class="col-md-6">
        <div class="form-group">
            <label for="driver_id">Chauffeur</label>
            <select name="driver_id" id="driver_id" class="form-control @error('driver_id') is-invalid @enderror">
                <option value="">Aucun chauffeur assigné</option>
                @foreach($drivers as $driver)
                    <option value="{{ $driver->id }}" {{ (old('driver_id', $rental->driver_id ?? '') == $driver->id) ? 'selected' : '' }}>
                        {{ $driver->name }} ({{ $driver->email }})
                    </option>
                @endforeach
            </select>
            @error('driver_id')
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
                   value="0" 
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
        
        function calculateTotalPrice() {
            const rentalDate = new Date(rentalDateInput.value);
            const returnDate = new Date(returnDateInput.value);
            const selectedOption = carSelect.options[carSelect.selectedIndex];
            const pricePerDay = selectedOption ? parseFloat(selectedOption.getAttribute('data-price')) : 0;
            
            if (rentalDate && returnDate && !isNaN(pricePerDay) && rentalDate <= returnDate) {
                const diffTime = Math.abs(returnDate - rentalDate);
                const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)) + 1;
                const totalPrice = diffDays * pricePerDay;
                document.getElementById('total_price').value = totalPrice.toFixed(2);
            } else {
                document.getElementById('total_price').value = '0.00';
            }
        }
        
        // Update return date min date when rental date changes
        rentalDateInput.addEventListener('change', function() {
            returnDateInput.min = this.value;
            calculateTotalPrice();
        });
        
        // Recalculate when return date changes
        returnDateInput.addEventListener('change', calculateTotalPrice);
        
        // Recalculate when car selection changes
        carSelect.addEventListener('change', calculateTotalPrice);
        
        // Initialize calculation on page load
        calculateTotalPrice();
    });
</script>
@endpush
