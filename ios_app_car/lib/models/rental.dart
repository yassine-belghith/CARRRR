import 'transfer.dart';

class Rental {
  final int id;
  final String rentalDate;
  final String status;
  final double? latitude;
  final double? longitude;
  final String? locationName;
  final User? user;
  final Car? car;

  Rental({
    required this.id,
    required this.rentalDate,
    required this.status,
    this.latitude,
    this.longitude,
    this.locationName,
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

  factory Rental.fromJson(Map<String, dynamic> json) {
    return Rental(
      id: _parseInt(json['id']),
      rentalDate: json['rental_date']?.toString() ?? '',
      status: json['status']?.toString() ?? '',
      latitude: _parseCoordinate(json['location']?['latitude']),
      longitude: _parseCoordinate(json['location']?['longitude']),
      locationName: json['location']?['name']?.toString() ?? 'Rental Location',
      user: json['user'] != null ? User.fromJson(json['user']) : null,
      car: json['car'] != null ? Car.fromJson(json['car']) : null,
    );
  }
}
