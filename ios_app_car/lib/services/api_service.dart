import 'dart:convert';
import 'package:http/http.dart' as http;
import 'package:shared_preferences/shared_preferences.dart';
import '../models/user.dart';
import '../models/transfer.dart';
import '../models/rental.dart';

class ApiService {
  static const String baseUrl = 'http://127.0.0.1:8001/api'; 
  
  static Future<String?> getToken() async {
    final prefs = await SharedPreferences.getInstance();
    return prefs.getString('auth_token');
  }
  
  static Future<void> saveToken(String token) async {
    final prefs = await SharedPreferences.getInstance();
    await prefs.setString('auth_token', token);
  }
  
  static Future<void> removeToken() async {
    final prefs = await SharedPreferences.getInstance();
    await prefs.remove('auth_token');
  }
  
  static Future<Map<String, dynamic>> login(String email, String password) async {
    final response = await http.post(
      Uri.parse('$baseUrl/driver/login'),
      headers: {'Content-Type': 'application/json'},
      body: jsonEncode({
        'email': email,
        'password': password,
      }),
    );
    
    if (response.statusCode == 200) {
      final data = jsonDecode(response.body);
      await saveToken(data['token']);
      return data;
    } else {
      throw Exception('Login failed: ${response.body}');
    }
  }
  
  static Future<void> logout() async {
    final token = await getToken();
    if (token != null) {
      await http.post(
        Uri.parse('$baseUrl/driver/logout'),
        headers: {
          'Content-Type': 'application/json',
          'Authorization': 'Bearer $token',
        },
      );
    }
    await removeToken();
  }
  
  static Future<Map<String, dynamic>> getDashboardData() async {
    final token = await getToken();
    if (token == null) {
      throw Exception('No authentication token found');
    }
    
    final response = await http.get(
      Uri.parse('$baseUrl/driver/dashboard'),
      headers: {
        'Content-Type': 'application/json',
        'Authorization': 'Bearer $token',
      },
    );
    
    if (response.statusCode == 200) {
      return jsonDecode(response.body);
    } else {
      throw Exception('Failed to load dashboard data: ${response.body}');
    }
  }
  
  static Future<Map<String, dynamic>> getTransfers() async {
    final token = await getToken();
    if (token == null) {
      throw Exception('No authentication token found');
    }
    
    final response = await http.get(
      Uri.parse('$baseUrl/driver/transfers'),
      headers: {
        'Content-Type': 'application/json',
        'Authorization': 'Bearer $token',
      },
    );
    
    if (response.statusCode == 200) {
      return jsonDecode(response.body);
    } else {
      throw Exception('Failed to load transfers: ${response.body}');
    }
  }
  
  static Future<Map<String, dynamic>> getRentals() async {
    final token = await getToken();
    if (token == null) {
      throw Exception('No authentication token found');
    }
    
    final response = await http.get(
      Uri.parse('$baseUrl/driver/rentals'),
      headers: {
        'Content-Type': 'application/json',
        'Authorization': 'Bearer $token',
      },
    );
    
    if (response.statusCode == 200) {
      return jsonDecode(response.body);
    } else {
      throw Exception('Failed to load rentals: ${response.body}');
    }
  }
  
  static Future<Map<String, dynamic>> getTransferDetail(int transferId) async {
    final token = await getToken();
    if (token == null) {
      throw Exception('No authentication token found');
    }
    
    final response = await http.get(
      Uri.parse('$baseUrl/driver/transfers/$transferId'),
      headers: {
        'Content-Type': 'application/json',
        'Authorization': 'Bearer $token',
      },
    );
    
    if (response.statusCode == 200) {
      return jsonDecode(response.body);
    } else {
      throw Exception('Failed to load transfer details: ${response.body}');
    }
  }
  
  static Future<Map<String, dynamic>> getRentalDetail(int rentalId) async {
    final token = await getToken();
    if (token == null) {
      throw Exception('No authentication token found');
    }
    
    final response = await http.get(
      Uri.parse('$baseUrl/driver/rentals/$rentalId'),
      headers: {
        'Content-Type': 'application/json',
        'Authorization': 'Bearer $token',
      },
    );
    
    if (response.statusCode == 200) {
      return jsonDecode(response.body);
    } else {
      throw Exception('Failed to load rental details: ${response.body}');
    }
  }
  
  static Future<Map<String, dynamic>> confirmTransfer(int transferId) async {
    final token = await getToken();
    if (token == null) {
      throw Exception('No authentication token found');
    }
    
    final response = await http.post(
      Uri.parse('$baseUrl/driver/transfers/$transferId/confirm'),
      headers: {
        'Content-Type': 'application/json',
        'Authorization': 'Bearer $token',
      },
    );
    
    if (response.statusCode == 200) {
      return jsonDecode(response.body);
    } else {
      throw Exception('Failed to confirm transfer: ${response.body}');
    }
  }
  
  static Future<Map<String, dynamic>> declineTransfer(int transferId) async {
    final token = await getToken();
    if (token == null) {
      throw Exception('No authentication token found');
    }
    
    final response = await http.post(
      Uri.parse('$baseUrl/driver/transfers/$transferId/decline'),
      headers: {
        'Content-Type': 'application/json',
        'Authorization': 'Bearer $token',
      },
    );
    
    if (response.statusCode == 200) {
      return jsonDecode(response.body);
    } else {
      throw Exception('Failed to decline transfer: ${response.body}');
    }
  }
  
  static Future<Map<String, dynamic>> startJob(int transferId) async {
    final token = await getToken();
    if (token == null) {
      throw Exception('No authentication token found');
    }
    
    final response = await http.post(
      Uri.parse('$baseUrl/driver/transfers/$transferId/start'),
      headers: {
        'Content-Type': 'application/json',
        'Authorization': 'Bearer $token',
      },
    );
    
    if (response.statusCode == 200) {
      return jsonDecode(response.body);
    } else {
      throw Exception('Failed to start job: ${response.body}');
    }
  }
  
  static Future<Map<String, dynamic>> endJob(int transferId) async {
    final token = await getToken();
    if (token == null) {
      throw Exception('No authentication token found');
    }
    
    final response = await http.post(
      Uri.parse('$baseUrl/driver/transfers/$transferId/end'),
      headers: {
        'Content-Type': 'application/json',
        'Authorization': 'Bearer $token',
      },
    );
    
    if (response.statusCode == 200) {
      return jsonDecode(response.body);
    } else {
      throw Exception('Failed to end job: ${response.body}');
    }
  }
  
  static Future<Map<String, dynamic>> getProfile() async {
    final token = await getToken();
    if (token == null) {
      throw Exception('No authentication token found');
    }
    
    final response = await http.get(
      Uri.parse('$baseUrl/driver/profile'),
      headers: {
        'Content-Type': 'application/json',
        'Authorization': 'Bearer $token',
      },
    );
    
    if (response.statusCode == 200) {
      return jsonDecode(response.body);
    } else {
      throw Exception('Failed to load profile: ${response.body}');
    }
  }
}
