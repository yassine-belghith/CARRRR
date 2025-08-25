import 'package:flutter/material.dart';
import '../services/api_service.dart';
import '../models/transfer.dart';
import '../models/rental.dart';
import '../login_screen.dart';

class DashboardScreen extends StatefulWidget {
  const DashboardScreen({super.key});

  @override
  State<DashboardScreen> createState() => _DashboardScreenState();
}

class _DashboardScreenState extends State<DashboardScreen> {
  bool isLoading = true;
  Map<String, dynamic>? dashboardData;
  String? error;

  @override
  void initState() {
    super.initState();
    loadDashboardData();
  }

  Future<void> loadDashboardData() async {
    try {
      setState(() {
        isLoading = true;
        error = null;
      });
      
      final data = await ApiService.getDashboardData();
      setState(() {
        dashboardData = data;
        isLoading = false;
      });
    } catch (e) {
      setState(() {
        error = e.toString();
        isLoading = false;
      });
    }
  }

  Future<void> logout() async {
    try {
      await ApiService.logout();
      if (mounted) {
        Navigator.of(context).pushAndRemoveUntil(
          MaterialPageRoute(builder: (context) => const LoginScreen()),
          (route) => false,
        );
      }
    } catch (e) {
      ScaffoldMessenger.of(context).showSnackBar(
        SnackBar(content: Text('Logout failed: $e')),
      );
    }
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: const Text('Driver Dashboard'),
        backgroundColor: const Color(0xFF2196F3),
        foregroundColor: Colors.white,
        automaticallyImplyLeading: false,
        actions: [
          IconButton(
            icon: const Icon(Icons.refresh),
            onPressed: loadDashboardData,
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
                      Text('Error: $error'),
                      ElevatedButton(
                        onPressed: loadDashboardData,
                        child: const Text('Retry'),
                      ),
                    ],
                  ),
                )
              : RefreshIndicator(
                  onRefresh: loadDashboardData,
                  child: SingleChildScrollView(
                    physics: const AlwaysScrollableScrollPhysics(),
                    padding: const EdgeInsets.all(16),
                    child: Column(
                      crossAxisAlignment: CrossAxisAlignment.start,
                      children: [
                        _buildStatsCards(),
                        const SizedBox(height: 20),
                        _buildTransfersSection(),
                        const SizedBox(height: 20),
                        _buildRentalsSection(),
                      ],
                    ),
                  ),
                ),
    );
  }

  Widget _buildStatsCards() {
    final stats = dashboardData?['stats'] ?? {};
    return Row(
      children: [
        Expanded(
          child: Card(
            child: Padding(
              padding: const EdgeInsets.all(16),
              child: Column(
                children: [
                  const Icon(Icons.pending_actions, size: 40, color: Colors.orange),
                  const SizedBox(height: 8),
                  Text(
                    '${stats['pending_transfers'] ?? 0}',
                    style: const TextStyle(fontSize: 24, fontWeight: FontWeight.bold),
                  ),
                  const Text('Pending Transfers'),
                ],
              ),
            ),
          ),
        ),
        const SizedBox(width: 16),
        Expanded(
          child: Card(
            child: Padding(
              padding: const EdgeInsets.all(16),
              child: Column(
                children: [
                  const Icon(Icons.car_rental, size: 40, color: Colors.blue),
                  const SizedBox(height: 8),
                  Text(
                    '${stats['upcoming_rentals'] ?? 0}',
                    style: const TextStyle(fontSize: 24, fontWeight: FontWeight.bold),
                  ),
                  const Text('Upcoming Rentals'),
                ],
              ),
            ),
          ),
        ),
      ],
    );
  }

  Widget _buildTransfersSection() {
    final transfersData = dashboardData?['transfers'];
    final transfers = transfersData is Map<String, dynamic> 
        ? (transfersData['data'] as List?) ?? []
        : transfersData is List 
            ? transfersData 
            : [];
    
    return Column(
      crossAxisAlignment: CrossAxisAlignment.start,
      children: [
        const Text(
          'Recent Transfers',
          style: TextStyle(fontSize: 20, fontWeight: FontWeight.bold),
        ),
        const SizedBox(height: 10),
        if (transfers.isEmpty)
          const Card(
            child: Padding(
              padding: EdgeInsets.all(16),
              child: Text('No transfers found'),
            ),
          )
        else
          ...transfers.where((item) => item is Map<String, dynamic>).map<Widget>((transferData) {
            try {
              final transfer = Transfer.fromJson(transferData as Map<String, dynamic>);
              return Card(
                child: ListTile(
                  leading: const Icon(Icons.transfer_within_a_station),
                  title: Text('${transfer.pickupLocation} → ${transfer.dropoffLocation}'),
                  subtitle: Text('Status: ${transfer.driverConfirmationStatus}'),
                  trailing: transfer.driverConfirmationStatus == 'pending'
                      ? const Icon(Icons.pending, color: Colors.orange)
                      : transfer.driverConfirmationStatus == 'confirmed'
                          ? const Icon(Icons.check_circle, color: Colors.green)
                          : const Icon(Icons.cancel, color: Colors.red),
                ),
              );
            } catch (e) {
              return Card(
                child: ListTile(
                  leading: const Icon(Icons.error),
                  title: const Text('Error loading transfer'),
                  subtitle: Text('Error: $e'),
                ),
              );
            }
          }).toList(),
      ],
    );
  }

  Widget _buildRentalsSection() {
    final rentalsData = dashboardData?['rentals'];
    final rentals = rentalsData is Map<String, dynamic> 
        ? (rentalsData['data'] as List?) ?? []
        : rentalsData is List 
            ? rentalsData 
            : [];
    
    return Column(
      crossAxisAlignment: CrossAxisAlignment.start,
      children: [
        const Text(
          'Recent Rentals',
          style: TextStyle(fontSize: 20, fontWeight: FontWeight.bold),
        ),
        const SizedBox(height: 10),
        if (rentals.isEmpty)
          const Card(
            child: Padding(
              padding: EdgeInsets.all(16),
              child: Text('No rentals found'),
            ),
          )
        else
          ...rentals.where((item) => item is Map<String, dynamic>).map<Widget>((rentalData) {
            try {
              final rental = Rental.fromJson(rentalData as Map<String, dynamic>);
              return Card(
                child: ListTile(
                  leading: const Icon(Icons.car_rental),
                  title: Text('${rental.car?.brand ?? ''} ${rental.car?.model ?? ''}'),
                  subtitle: Text('Date: ${rental.rentalDate}\nStatus: ${rental.status}'),
                  trailing: rental.status == 'approved'
                      ? const Icon(Icons.check_circle, color: Colors.green)
                      : rental.status == 'pending'
                          ? const Icon(Icons.pending, color: Colors.orange)
                          : const Icon(Icons.info, color: Colors.blue),
                ),
              );
            } catch (e) {
              return Card(
                child: ListTile(
                  leading: const Icon(Icons.error),
                  title: const Text('Error loading rental'),
                  subtitle: Text('Error: $e'),
                ),
              );
            }
          }).toList(),
      ],
    );
  }
}
