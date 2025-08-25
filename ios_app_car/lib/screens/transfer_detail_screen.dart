import 'package:flutter/material.dart';
import '../services/api_service.dart';
import '../models/transfer.dart';
import '../widgets/leaflet_map.dart';

class TransferDetailScreen extends StatefulWidget {
  final int transferId;

  const TransferDetailScreen({super.key, required this.transferId});

  @override
  State<TransferDetailScreen> createState() => _TransferDetailScreenState();
}

class _TransferDetailScreenState extends State<TransferDetailScreen> {
  bool isLoading = true;
  Transfer? transfer;
  String? error;
  bool showMap = false;

  @override
  void initState() {
    super.initState();
    loadTransferDetail();
  }

  Future<void> loadTransferDetail() async {
    try {
      setState(() {
        isLoading = true;
        error = null;
      });
      
      final data = await ApiService.getTransferDetail(widget.transferId);
      setState(() {
        transfer = Transfer.fromJson(data);
        isLoading = false;
      });
    } catch (e) {
      setState(() {
        error = e.toString();
        isLoading = false;
      });
    }
  }

  Future<void> confirmTransfer() async {
    try {
      await ApiService.confirmTransfer(widget.transferId);
      ScaffoldMessenger.of(context).showSnackBar(
        const SnackBar(content: Text('Transfer confirmed successfully')),
      );
      loadTransferDetail();
    } catch (e) {
      ScaffoldMessenger.of(context).showSnackBar(
        SnackBar(content: Text('Failed to confirm transfer: $e')),
      );
    }
  }

  Future<void> declineTransfer() async {
    try {
      await ApiService.declineTransfer(widget.transferId);
      ScaffoldMessenger.of(context).showSnackBar(
        const SnackBar(content: Text('Transfer declined')),
      );
      loadTransferDetail();
    } catch (e) {
      ScaffoldMessenger.of(context).showSnackBar(
        SnackBar(content: Text('Failed to decline transfer: $e')),
      );
    }
  }

  Future<void> startJob() async {
    try {
      await ApiService.startJob(widget.transferId);
      ScaffoldMessenger.of(context).showSnackBar(
        const SnackBar(content: Text('Job started successfully')),
      );
      loadTransferDetail();
    } catch (e) {
      ScaffoldMessenger.of(context).showSnackBar(
        SnackBar(content: Text('Failed to start job: $e')),
      );
    }
  }

  Future<void> endJob() async {
    try {
      await ApiService.endJob(widget.transferId);
      ScaffoldMessenger.of(context).showSnackBar(
        const SnackBar(content: Text('Job completed successfully')),
      );
      loadTransferDetail();
    } catch (e) {
      ScaffoldMessenger.of(context).showSnackBar(
        SnackBar(content: Text('Failed to end job: $e')),
      );
    }
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: Text('Transfer #${widget.transferId}'),
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
                        onPressed: loadTransferDetail,
                        child: const Text('Retry'),
                      ),
                    ],
                  ),
                )
              : transfer == null
                  ? const Center(child: Text('Transfer not found'))
                  : Column(
                      children: [
                        Expanded(
                          child: SingleChildScrollView(
                            padding: const EdgeInsets.all(16),
                            child: Column(
                              crossAxisAlignment: CrossAxisAlignment.start,
                              children: [
                                _buildTransferInfo(),
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

  Widget _buildTransferInfo() {
    return Card(
      child: Padding(
        padding: const EdgeInsets.all(16),
        child: Column(
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            const Text(
              'Transfer Details',
              style: TextStyle(fontSize: 18, fontWeight: FontWeight.bold),
            ),
            const SizedBox(height: 12),
            _buildInfoRow(Icons.location_on, 'Pickup', transfer!.pickupLocation),
            _buildInfoRow(Icons.flag, 'Dropoff', transfer!.dropoffLocation),
            if (transfer!.pickupTime.isNotEmpty)
              _buildInfoRow(Icons.access_time, 'Time', transfer!.pickupTime),
            _buildInfoRow(Icons.info, 'Status', transfer!.driverConfirmationStatus),
            _buildInfoRow(Icons.work, 'Job Status', transfer!.jobStatus.toUpperCase()),
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
            _buildInfoRow(Icons.person, 'Name', transfer!.user?.name ?? 'Unknown'),
            _buildInfoRow(Icons.email, 'Email', transfer!.user?.email ?? 'N/A'),
          ],
        ),
      ),
    );
  }

  Widget _buildCarInfo() {
    if (transfer!.car == null) return const SizedBox.shrink();
    
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
                '${transfer!.car!.brand} ${transfer!.car!.model}'),
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
          pickupLat: transfer?.pickupLatitude,
          pickupLng: transfer?.pickupLongitude,
          dropoffLat: transfer?.dropoffLatitude,
          dropoffLng: transfer?.dropoffLongitude,
          pickupAddress: transfer?.pickupLocation,
          dropoffAddress: transfer?.dropoffLocation,
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
          if (transfer!.driverConfirmationStatus == 'confirmed') ...[
            if (transfer!.jobStatus == 'pending') ...[
              SizedBox(
                width: double.infinity,
                child: ElevatedButton.icon(
                  onPressed: startJob,
                  icon: const Icon(Icons.play_arrow),
                  label: const Text('Start Job'),
                  style: ElevatedButton.styleFrom(
                    backgroundColor: Colors.green,
                    foregroundColor: Colors.white,
                    padding: const EdgeInsets.symmetric(vertical: 16),
                  ),
                ),
              ),
            ] else if (transfer!.jobStatus == 'started') ...[
              Column(
                children: [
                  SizedBox(
                    width: double.infinity,
                    child: ElevatedButton.icon(
                      onPressed: () {
                        setState(() {
                          showMap = !showMap;
                        });
                      },
                      icon: const Icon(Icons.map),
                      label: Text(showMap ? 'Hide Route' : 'Show Route'),
                      style: ElevatedButton.styleFrom(
                        backgroundColor: Colors.blue,
                        foregroundColor: Colors.white,
                        padding: const EdgeInsets.symmetric(vertical: 16),
                      ),
                    ),
                  ),
                  const SizedBox(height: 12),
                  SizedBox(
                    width: double.infinity,
                    child: ElevatedButton.icon(
                      onPressed: endJob,
                      icon: const Icon(Icons.stop),
                      label: const Text('End Job'),
                      style: ElevatedButton.styleFrom(
                        backgroundColor: Colors.orange,
                        foregroundColor: Colors.white,
                        padding: const EdgeInsets.symmetric(vertical: 16),
                      ),
                    ),
                  ),
                ],
              ),
            ] else if (transfer!.jobStatus == 'completed') ...[
              SizedBox(
                width: double.infinity,
                child: Container(
                  padding: const EdgeInsets.symmetric(vertical: 16),
                  decoration: BoxDecoration(
                    color: Colors.green.withOpacity(0.1),
                    borderRadius: BorderRadius.circular(8),
                    border: Border.all(color: Colors.green),
                  ),
                  child: const Row(
                    mainAxisAlignment: MainAxisAlignment.center,
                    children: [
                      Icon(Icons.check_circle, color: Colors.green),
                      SizedBox(width: 8),
                      Text(
                        'Job Completed',
                        style: TextStyle(
                          color: Colors.green,
                          fontWeight: FontWeight.bold,
                          fontSize: 16,
                        ),
                      ),
                    ],
                  ),
                ),
              ),
            ],
          ] else if (transfer!.driverConfirmationStatus == 'pending') ...[
            Row(
              children: [
                Expanded(
                  child: ElevatedButton(
                    onPressed: confirmTransfer,
                    style: ElevatedButton.styleFrom(
                      backgroundColor: Colors.green,
                      foregroundColor: Colors.white,
                      padding: const EdgeInsets.symmetric(vertical: 16),
                    ),
                    child: const Text('Confirm'),
                  ),
                ),
                const SizedBox(width: 12),
                Expanded(
                  child: ElevatedButton(
                    onPressed: declineTransfer,
                    style: ElevatedButton.styleFrom(
                      backgroundColor: Colors.red,
                      foregroundColor: Colors.white,
                      padding: const EdgeInsets.symmetric(vertical: 16),
                    ),
                    child: const Text('Decline'),
                  ),
                ),
              ],
            ),
          ],
        ],
      ),
    );
  }
}
