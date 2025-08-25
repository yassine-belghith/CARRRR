import 'package:flutter/material.dart';
import '../services/api_service.dart';
import '../models/rental.dart';
import '../widgets/leaflet_map.dart';

class RentalDetailScreen extends StatefulWidget {
  final int rentalId;

  const RentalDetailScreen({super.key, required this.rentalId});

  @override
  State<RentalDetailScreen> createState() => _RentalDetailScreenState();
}

class _RentalDetailScreenState extends State<RentalDetailScreen> {
  bool isLoading = true;
  Rental? rental;
  String? error;
  bool showMap = false;

  @override
  void initState() {
    super.initState();
    loadRentalDetail();
  }

  Future<void> loadRentalDetail() async {
    try {
      setState(() {
        isLoading = true;
        error = null;
      });
      
      final data = await ApiService.getRentalDetail(widget.rentalId);
      setState(() {
        rental = Rental.fromJson(data);
        isLoading = false;
      });
    } catch (e) {
      setState(() {
        error = e.toString();
        isLoading = false;
      });
    }
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: Text('Rental #${widget.rentalId}'),
        backgroundColor: const Color(0xFF2196F3),
        foregroundColor: Colors.white,
      ),
      body: isLoading
          ? const Center(child: CircularProgressIndicator())
          : error != null
              ? Center(
                  child: Column(
                    mainAxisAlignment: MainAxisAlignment.center,
                    children: [
                      Text('Error: $error'),
                      ElevatedButton(
                        onPressed: loadRentalDetail,
                        child: const Text('Retry'),
                      ),
                    ],
                  ),
                )
              : rental == null
                  ? const Center(child: Text('Rental not found'))
                  : Column(
                      children: [
                        Expanded(
                          child: SingleChildScrollView(
                            padding: const EdgeInsets.all(16),
                            child: Column(
                              crossAxisAlignment: CrossAxisAlignment.start,
                              children: [
                                _buildRentalInfo(),
                                const SizedBox(height: 16),
                                _buildClientInfo(),
                                const SizedBox(height: 16),
                                _buildCarInfo(),
                                if (showMap) ...[
                                  const SizedBox(height: 16),
                                  _buildMapView(),
                                ],
                              ],
                            ),
                          ),
                        ),
                        _buildActionButtons(),
                      ],
                    ),
    );
  }

  Widget _buildRentalInfo() {
    return Card(
      child: Padding(
        padding: const EdgeInsets.all(16),
        child: Column(
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            const Text(
              'Rental Details',
              style: TextStyle(fontSize: 18, fontWeight: FontWeight.bold),
            ),
            const SizedBox(height: 12),
            _buildInfoRow(Icons.calendar_today, 'Date', rental!.rentalDate),
            _buildInfoRow(Icons.info, 'Status', rental!.status),
          ],
        ),
      ),
    );
  }

  Widget _buildClientInfo() {
    return Card(
      child: Padding(
        padding: const EdgeInsets.all(16),
        child: Column(
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            const Text(
              'Client Information',
              style: TextStyle(fontSize: 18, fontWeight: FontWeight.bold),
            ),
            const SizedBox(height: 12),
            _buildInfoRow(Icons.person, 'Name', rental!.user?.name ?? 'Unknown'),
            _buildInfoRow(Icons.email, 'Email', rental!.user?.email ?? 'N/A'),
          ],
        ),
      ),
    );
  }

  Widget _buildCarInfo() {
    if (rental!.car == null) return const SizedBox.shrink();
    
    return Card(
      child: Padding(
        padding: const EdgeInsets.all(16),
        child: Column(
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            const Text(
              'Vehicle Information',
              style: TextStyle(fontSize: 18, fontWeight: FontWeight.bold),
            ),
            const SizedBox(height: 12),
            _buildInfoRow(Icons.directions_car, 'Vehicle', 
                '${rental!.car!.brand} ${rental!.car!.model}'),
          ],
        ),
      ),
    );
  }

  Widget _buildMapView() {
    return Card(
      child: Padding(
        padding: const EdgeInsets.all(8),
        child: LeafletMap(
          height: 300,
          pickupLat: rental?.latitude,
          pickupLng: rental?.longitude,
          pickupAddress: rental?.locationName ?? 'Rental Location',
        ),
      ),
    );
  }

  Widget _buildInfoRow(IconData icon, String label, String value) {
    return Padding(
      padding: const EdgeInsets.only(bottom: 8),
      child: Row(
        children: [
          Icon(icon, size: 20, color: const Color(0xFF2196F3)),
          const SizedBox(width: 8),
          Text(
            '$label: ',
            style: const TextStyle(fontWeight: FontWeight.bold),
          ),
          Expanded(child: Text(value)),
        ],
      ),
    );
  }

  Widget _buildActionButtons() {
    return Container(
      padding: const EdgeInsets.all(16),
      decoration: BoxDecoration(
        color: Colors.white,
        boxShadow: [
          BoxShadow(
            color: Colors.grey.withOpacity(0.3),
            spreadRadius: 1,
            blurRadius: 5,
            offset: const Offset(0, -2),
          ),
        ],
      ),
      child: Column(
        children: [
          if (rental!.status == 'approved') ...[
            SizedBox(
              width: double.infinity,
              child: ElevatedButton.icon(
                onPressed: () {
                  setState(() {
                    showMap = !showMap;
                  });
                },
                icon: const Icon(Icons.map),
                label: Text(showMap ? 'Hide Route' : 'Start Job'),
                style: ElevatedButton.styleFrom(
                  backgroundColor: Colors.green,
                  foregroundColor: Colors.white,
                  padding: const EdgeInsets.symmetric(vertical: 16),
                ),
              ),
            ),
          ],
        ],
      ),
    );
  }
}
