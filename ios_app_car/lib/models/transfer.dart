class Transfer {
  final int id;
  final String pickupLocation;
  final String dropoffLocation;
  final String pickupTime;
  final String status;
  final String driverConfirmationStatus;
  final String jobStatus;
  final String? jobStartedAt;
  final String? jobCompletedAt;
  final double? pickupLatitude;
  final double? pickupLongitude;
  final double? dropoffLatitude;
  final double? dropoffLongitude;
  final User? user;
  final Car? car;

  Transfer({
    required this.id,
    required this.pickupLocation,
    required this.dropoffLocation,
    required this.pickupTime,
    required this.status,
    required this.driverConfirmationStatus,
    required this.jobStatus,
    this.jobStartedAt,
    this.jobCompletedAt,
    this.pickupLatitude,
    this.pickupLongitude,
    this.dropoffLatitude,
    this.dropoffLongitude,
    this.user,
    this.car,
  });

  static double? _parseCoordinate(dynamic value) {
    if (value == null) return null;
    if (value is double) return value;
    if (value is int) return value.toDouble();
    if (value is String) {
      try {
        return double.parse(value);
      } catch (e) {
        return null;
      }
    }
    return null;
  }

  static int _parseInt(dynamic value) {
    if (value == null) return 0;
    if (value is int) return value;
    if (value is String) {
      try {
        return int.parse(value);
      } catch (e) {
        return 0;
      }
    }
    return 0;
  }

  factory Transfer.fromJson(Map<String, dynamic> json) {
    // Get location names from database fields or fallback
    String pickupLocationName = json['pickup_location_name'] ?? 
                               json['pickup_destination']?['name'] ?? 
                               'Pickup Location';
    
    String dropoffLocationName = json['dropoff_location_name'] ?? 
                                json['dropoff_destination']?['name'] ?? 
                                'Dropoff Location';

    return Transfer(
      id: _parseInt(json['id']),
      pickupLocation: pickupLocationName,
      dropoffLocation: dropoffLocationName,
      pickupTime: json['pickup_datetime']?.toString() ?? json['pickup_time']?.toString() ?? '',
      status: json['status']?.toString() ?? '',
      driverConfirmationStatus: json['driver_confirmation_status']?.toString() ?? 'pending',
      jobStatus: json['job_status']?.toString() ?? 'pending',
      jobStartedAt: json['job_started_at']?.toString(),
      jobCompletedAt: json['job_completed_at']?.toString(),
      pickupLatitude: _parseCoordinate(json['pickup_latitude']),
      pickupLongitude: _parseCoordinate(json['pickup_longitude']),
      dropoffLatitude: _parseCoordinate(json['dropoff_latitude']),
      dropoffLongitude: _parseCoordinate(json['dropoff_longitude']),
      user: json['user'] != null ? User.fromJson(json['user']) : null,
      car: json['car'] != null ? Car.fromJson(json['car']) : null,
    );
  }
}

class User {
  final int id;
  final String name;
  final String email;

  User({
    required this.id,
    required this.name,
    required this.email,
  });

  factory User.fromJson(Map<String, dynamic> json) {
    return User(
      id: Transfer._parseInt(json['id']),
      name: json['name']?.toString() ?? '',
      email: json['email']?.toString() ?? '',
    );
  }
}

class Car {
  final int id;
  final String brand;
  final String model;
  final String? image;

  Car({
    required this.id,
    required this.brand,
    required this.model,
    this.image,
  });

  factory Car.fromJson(Map<String, dynamic> json) {
    return Car(
      id: Transfer._parseInt(json['id']),
      brand: json['brand']?.toString() ?? '',
      model: json['model']?.toString() ?? '',
      image: json['image']?.toString(),
    );
  }
}
