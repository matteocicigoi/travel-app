<script>
export default {
  name: 'MapComponent',
  data() {
    return {
      map: null, // Referenza alla mappa
      routingControl: null, // Referenza al controllo del routing
      waypoints: [ // Array iniziale di waypoints
        L.latLng(45.46,  9.18),
        L.latLng(45.47,  9.15),
        L.latLng(45.46,  9.17)
      ]
    };
  },
  methods: {
    initializeMap() {
      // Crea la mappa e aggiungi il layer iniziale
      this.map = L.map('map').setView([45.468, 9.186], 13);
      L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
      }).addTo(this.map);

      // Crea il controllo di routing e aggiungi i waypoints
      this.routingControl = L.Routing.control({
        waypoints: this.waypoints,
        routeWhileDragging: true,
        addWaypoints: false // Disabilita l'aggiunta di waypoint al clic sulla mappa
      }).addTo(this.map);

      // Aggiungi un evento per aggiornare i waypoints quando vengono mossi
      this.routingControl.on('routesfound', (e) => {
        const newWaypoints = e.waypoints.map(waypoint => waypoint.latLng);
        this.waypoints = newWaypoints;
      });
    },
    addWaypoint() {
      // Aggiungi un nuovo waypoint alla lista
      const newWaypoint = L.latLng(51.51 + Math.random() * 0.01, -0.09 + Math.random() * 0.01);
      this.waypoints.push(newWaypoint);

      // Copia i waypoint esistenti e aggiorna i waypoints del controllo di routing
      if (this.routingControl) {
        this.routingControl.setWaypoints(this.waypoints.slice());
      }
    },
    removeWaypoint(index) {
      // Rimuovi il waypoint dall'array
      if (index >= 0 && index < this.waypoints.length) {
        this.waypoints.splice(index, 1);
        // Aggiorna i waypoints del controllo di routing
        if (this.routingControl) {
          this.routingControl.setWaypoints(this.waypoints.slice());
        }
      }
    }
  },
  mounted() {
    this.initializeMap(); // Inizializza la mappa quando il componente è montato
  }
};
</script>

<template>
    <div id="map" class="h-100">aaa</div>
</template>
<style>
.leaflet-routing-container {
    display: none;
}
</style>