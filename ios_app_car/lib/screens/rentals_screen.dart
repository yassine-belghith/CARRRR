import 'package:flutter/material.dart';
import '../services/api_service.dart';
import '../models/rental.dart';
import 'rental_detail_screen.dart';

class RentalsScreen extends StatefulWidget {
  const RentalsScreen({super.key});

  @override
  State<RentalsScreen> createState() => _RentalsScreenState();
}

class _RentalsScreenState extends State<RentalsScreen> {
  bool isLoading = true;
  List<Rental> rentals = [];
  String? error;

  @override
  void initState() {
    super.initState();
    loadRentals();
  }

  Future<void> loadRentals() async {
    try {
      setState(() {
        isLoading = true;
        error = null;
      });
      
      final data = await ApiService.getRentals();
      final rentalsList = (data['data'] as List)
          .map((item) => Rental.fromJson(item))
          .toList();
      
      setState(() {
        rentals = rentalsList;
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
        title: const Text('My Rentals'),
        backgroundColor: const Color(0xFF2196F3),
        foregroundColor: Colors.white,
        actions: [
          IconButton(
            icon: const Icon(Icons.refresh),
            onPressed: loadRentals,
          ),
        ],
      ),
      body: isLoading
          ? const Center(child: CircularProgressIndicator())
          : error != null
              ? Center(
                  child: Column(
                    mainAxisAlignment: MainAxisAlignment.center,
                    children: [
                      Icon(Icons.error_outline, size: 64, color: Colors.grey[400]),
                      const SizedBox(height: 16),
                      Text('Error: $error'),
                      const SizedBox(height: 16),
                      ElevatedButton(
                        onPressed: loadRentals,
                        child: const Text('Retry'),
                      ),
                    ],
                  ),
                )
              : RefreshIndicator(
                  onRefresh: loadRentals,
                  child: rentals.isEmpty
                      ? ListView(
                          children: [
                            SizedBox(height: MediaQuery.of(context).size.height * 0.3),
                            Center(
                              child: Column(
                                children: [
                                  Icon(Icons.car_rental, 
                                       size: 64, color: Colors.grey[400]),
                                  const SizedBox(height: 16),
                                  Text(
                                    'No rentals found',
                                    style: TextStyle(
                                      fontSize: 18,
                                      color: Colors.grey[600],
                                    ),
                                  ),
                                ],
                              ),
                            ),
                          ],
                        )
                      : ListView.builder(
                          padding: const EdgeInsets.all(16),
                          itemCount: rentals.length,
                          itemBuilder: (context, index) {
                            final rental = rentals[index];
                            return Card(
                              margin: const EdgeInsets.only(bottom: 12),
                              elevation: 2,
                              shape: RoundedRectangleBorder(
                                borderRadius: BorderRadius.circular(12),
                              ),
                              child: InkWell(
                                borderRadius: BorderRadius.circular(12),
                                onTap: () {
                                  Navigator.push(
                                    context,
                                    MaterialPageRoute(
                                      builder: (context) => RentalDetailScreen(
                                        rentalId: rental.id,
                                      ),
                                    ),
                                  );
                                },
                                child: Padding(
                                  padding: const EdgeInsets.all(16),
                                  child: Column(
                                    crossAxisAlignment: CrossAxisAlignment.start,
                                    children: [
                                      Row(
                                        children: [
                                          Container(
                                            padding: const EdgeInsets.all(8),
                                            decoration: BoxDecoration(
                                              color: const Color(0xFF2196F3).withOpacity(0.1),
                                              borderRadius: BorderRadius.circular(8),
                                            ),
                                            child: const Icon(
                                              Icons.car_rental,
                                              color: Color(0xFF2196F3),
                                              size: 24,
                                            ),
                                          ),
                                          const SizedBox(width: 12),
                                          Expanded(
                                            child: Column(
                                              crossAxisAlignment: CrossAxisAlignment.start,
                                              children: [
                                                Text(
                                                  '${rental.car?.brand ?? ''} ${rental.car?.model ?? ''}',
                                                  style: const TextStyle(
                                                    fontSize: 16,
                                                    fontWeight: FontWeight.bold,
                                                  ),
                                                ),
                                                Text(
                                                  rental.user?.name ?? 'Unknown Client',
                                                  style: TextStyle(
                                                    fontSize: 14,
                                                    color: Colors.grey[600],
                                                  ),
                                                ),
                                              ],
                                            ),
                                          ),
                                          _buildStatusChip(rental.status),
                                        ],
                                      ),
                                      const SizedBox(height: 12),
                                      Row(
                                        children: [
                                          const Icon(Icons.calendar_today, 
                                               size: 16, color: Colors.blue),
                                          const SizedBox(width: 4),
                                          Text(
                                            'Date: ${rental.rentalDate}',
                                            style: const TextStyle(fontSize: 14),
                                          ),
                                        ],
                                      ),
                                    ],
                                  ),
                                ),
                              ),
                            );
                          },
                        ),
                ),
    );
  }

  Widget _buildStatusChip(String status) {
    Color backgroundColor;
    Color textColor;
    IconData icon;

    switch (status.toLowerCase()) {
      case 'approved':
        backgroundColor = Colors.green.withOpacity(0.1);
        textColor = Colors.green;
        icon = Icons.check_circle;
        break;
      case 'rejected':
        backgroundColor = Colors.red.withOpacity(0.1);
        textColor = Colors.red;
        icon = Icons.cancel;
        break;
      case 'completed':
        backgroundColor = Colors.blue.withOpacity(0.1);
        textColor = Colors.blue;
        icon = Icons.done_all;
        break;
      default:
        backgroundColor = Colors.orange.withOpacity(0.1);
        textColor = Colors.orange;
        icon = Icons.pending;
    }

    return Container(
      padding: const EdgeInsets.symmetric(horizontal: 8, vertical: 4),
      decoration: BoxDecoration(
        color: backgroundColor,
        borderRadius: BorderRadius.circular(12),
      ),
      child: Row(
        mainAxisSize: MainAxisSize.min,
        children: [
          Icon(icon, size: 14, color: textColor),
          const SizedBox(width: 4),
          Text(
            status.toUpperCase(),
            style: TextStyle(
              fontSize: 12,
              fontWeight: FontWeight.bold,
              color: textColor,
            ),
          ),
        ],
      ),
    );
  }
}
