import 'package:flutter/material.dart';
import '../services/api_service.dart';
import '../models/transfer.dart';
import 'transfer_detail_screen.dart';

class TransfersScreen extends StatefulWidget {
  const TransfersScreen({super.key});

  @override
  State<TransfersScreen> createState() => _TransfersScreenState();
}

class _TransfersScreenState extends State<TransfersScreen> {
  bool isLoading = true;
  List<Transfer> transfers = [];
  String? error;

  @override
  void initState() {
    super.initState();
    loadTransfers();
  }

  Future<void> loadTransfers() async {
    try {
      if (mounted) {
        setState(() {
          isLoading = true;
          error = null;
        });
      }
      
      final data = await ApiService.getTransfers();
      final transfersList = (data['data'] as List)
          .map((item) => Transfer.fromJson(item))
          .toList();
      
      if (mounted) {
        setState(() {
          transfers = transfersList;
          isLoading = false;
        });
      }
    } catch (e) {
      if (mounted) {
        setState(() {
          error = e.toString();
          isLoading = false;
        });
      }
    }
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: const Text('My Transfers'),
        backgroundColor: const Color(0xFF2196F3),
        foregroundColor: Colors.white,
        actions: [
          IconButton(
            icon: const Icon(Icons.refresh),
            onPressed: loadTransfers,
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
                        onPressed: loadTransfers,
                        child: const Text('Retry'),
                      ),
                    ],
                  ),
                )
              : RefreshIndicator(
                  onRefresh: loadTransfers,
                  child: transfers.isEmpty
                      ? ListView(
                          children: [
                            SizedBox(height: MediaQuery.of(context).size.height * 0.3),
                            Center(
                              child: Column(
                                children: [
                                  Icon(Icons.transfer_within_a_station, 
                                       size: 64, color: Colors.grey[400]),
                                  const SizedBox(height: 16),
                                  Text(
                                    'No transfers found',
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
                          itemCount: transfers.length,
                          itemBuilder: (context, index) {
                            final transfer = transfers[index];
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
                                      builder: (context) => TransferDetailScreen(
                                        transferId: transfer.id,
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
                                              Icons.transfer_within_a_station,
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
                                                  'Transfer #${transfer.id}',
                                                  style: const TextStyle(
                                                    fontSize: 16,
                                                    fontWeight: FontWeight.bold,
                                                  ),
                                                ),
                                                Text(
                                                  transfer.user?.name ?? 'Unknown Client',
                                                  style: TextStyle(
                                                    fontSize: 14,
                                                    color: Colors.grey[600],
                                                  ),
                                                ),
                                              ],
                                            ),
                                          ),
                                          _buildStatusChip(transfer.driverConfirmationStatus),
                                        ],
                                      ),
                                      const SizedBox(height: 12),
                                      Row(
                                        children: [
                                          const Icon(Icons.location_on, 
                                               size: 16, color: Colors.green),
                                          const SizedBox(width: 4),
                                          Expanded(
                                            child: Text(
                                              transfer.pickupLocation,
                                              style: const TextStyle(fontSize: 14),
                                            ),
                                          ),
                                        ],
                                      ),
                                      const SizedBox(height: 4),
                                      Row(
                                        children: [
                                          const Icon(Icons.flag, 
                                               size: 16, color: Colors.red),
                                          const SizedBox(width: 4),
                                          Expanded(
                                            child: Text(
                                              transfer.dropoffLocation,
                                              style: const TextStyle(fontSize: 14),
                                            ),
                                          ),
                                        ],
                                      ),
                                      if (transfer.pickupTime.isNotEmpty) ...[
                                        const SizedBox(height: 8),
                                        Row(
                                          children: [
                                            const Icon(Icons.access_time, 
                                                 size: 16, color: Colors.blue),
                                            const SizedBox(width: 4),
                                            Text(
                                              transfer.pickupTime,
                                              style: const TextStyle(fontSize: 14),
                                            ),
                                          ],
                                        ),
                                      ],
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
      case 'confirmed':
        backgroundColor = Colors.green.withOpacity(0.1);
        textColor = Colors.green;
        icon = Icons.check_circle;
        break;
      case 'declined':
        backgroundColor = Colors.red.withOpacity(0.1);
        textColor = Colors.red;
        icon = Icons.cancel;
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
