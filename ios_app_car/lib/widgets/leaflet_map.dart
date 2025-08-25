import 'package:flutter/material.dart';
import 'package:webview_flutter/webview_flutter.dart';

class LeafletMap extends StatefulWidget {
  final double? pickupLat;
  final double? pickupLng;
  final double? dropoffLat;
  final double? dropoffLng;
  final String? pickupAddress;
  final String? dropoffAddress;
  final double height;

  const LeafletMap({
    super.key,
    this.pickupLat,
    this.pickupLng,
    this.dropoffLat,
    this.dropoffLng,
    this.pickupAddress,
    this.dropoffAddress,
    this.height = 300,
  });

  @override
  State<LeafletMap> createState() => _LeafletMapState();
}

class _LeafletMapState extends State<LeafletMap> {
  late final WebViewController controller;

  @override
  void initState() {
    super.initState();
    controller = WebViewController()
      ..setJavaScriptMode(JavaScriptMode.unrestricted)
      ..loadHtmlString(_generateMapHtml());
  }

  String _generateMapHtml() {
    // Default coordinates (center of map if no coordinates provided)
    final double centerLat = widget.pickupLat ?? widget.dropoffLat ?? 48.8566; // Paris default
    final double centerLng = widget.pickupLng ?? widget.dropoffLng ?? 2.3522;
    
    // Generate markers JavaScript
    String markersJs = '';
    
    if (widget.pickupLat != null && widget.pickupLng != null) {
      markersJs += '''
        var pickupMarker = L.marker([${widget.pickupLat}, ${widget.pickupLng}])
          .addTo(map)
          .bindPopup('${widget.pickupAddress ?? "Pickup Location"}')
          .openPopup();
      ''';
    }
    
    if (widget.dropoffLat != null && widget.dropoffLng != null) {
      markersJs += '''
        var dropoffMarker = L.marker([${widget.dropoffLat}, ${widget.dropoffLng}])
          .addTo(map)
          .bindPopup('${widget.dropoffAddress ?? "Dropoff Location"}');
      ''';
      
      
      if (widget.pickupLat != null && widget.pickupLng != null) {
        markersJs += '''
          var routeControl = L.Routing.control({
            waypoints: [
              L.latLng(${widget.pickupLat}, ${widget.pickupLng}),
              L.latLng(${widget.dropoffLat}, ${widget.dropoffLng})
            ],
            routeWhileDragging: false,
            addWaypoints: false,
            createMarker: function() { return null; }
          }).addTo(map);
        ''';
      }
    }

    return '''
    <!DOCTYPE html>
    <html>
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Leaflet Map</title>
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
        <link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine@3.2.12/dist/leaflet-routing-machine.css" />
        <style>
            body { margin: 0; padding: 0; }
            #map { height: 100vh; width: 100%; }
        </style>
    </head>
    <body>
        <div id="map"></div>
        <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
        <script src="https://unpkg.com/leaflet-routing-machine@3.2.12/dist/leaflet-routing-machine.js"></script>
        <script>
            var map = L.map('map').setView([$centerLat, $centerLng], 13);
            
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© OpenStreetMap contributors'
            }).addTo(map);
            
            $markersJs
            
            // Fit map to show all markers
            if (typeof pickupMarker !== 'undefined' && typeof dropoffMarker !== 'undefined') {
                var group = new L.featureGroup([pickupMarker, dropoffMarker]);
                map.fitBounds(group.getBounds().pad(0.1));
            } else if (typeof pickupMarker !== 'undefined') {
                map.setView([${widget.pickupLat}, ${widget.pickupLng}], 15);
            } else {
                // If no coordinates available, show default location
                map.setView([$centerLat, $centerLng], 10);
            }
        </script>
    </body>
    </html>
    ''';
  }

  @override
  Widget build(BuildContext context) {
    return Container(
      height: widget.height,
      decoration: BoxDecoration(
        borderRadius: BorderRadius.circular(12),
        border: Border.all(color: Colors.grey.shade300),
      ),
      child: ClipRRect(
        borderRadius: BorderRadius.circular(12),
        child: WebViewWidget(controller: controller),
      ),
    );
  }
}
