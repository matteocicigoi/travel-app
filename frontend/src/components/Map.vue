<script>
import { store } from './../store';
export default {
    emits: ['changeStopInfo'],
    data() {
        return {
            store,
            map: null,
            routingControl: null,
            waypoints: []
        };
    },
    created() {
        // set waypoints
        if(this.store.profile != null && this.store.tripID != null && this.store.dayID != null){
            let x = this.store.profile[this.store.tripID].days[this.store.dayID].stops.length;
            for(let i = 0; i < x; i++){
                if(this.store.profile[this.store.tripID].days[this.store.dayID].stops[i].coordinates.length == 2){
                    const w = this.store.profile[this.store.tripID].days[this.store.dayID].stops[i].coordinates;
                    this.addWaypoint(w[0], w[1]);
                }
            }
        }
    },
    methods: {
        initializeMap() {
            this.map = L.map('map').setView([45.468, 9.186], 13);
            L.tileLayer('https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(this.map);

            // make route
            this.routingControl = L.Routing.control({
                waypoints: this.waypoints,
                routeWhileDragging: true,
                addWaypoints: false
            }).addTo(this.map);

            // change of position
            this.routingControl.on('routesfound', (e) => {
                const newWaypoints = e.waypoints.map(waypoint => waypoint.latLng);
                this.waypoints = newWaypoints;
                const x = this.waypoints.length;
                for(let i = 0; i < x; i++){
                    this.store.profile[this.store.tripID].days[this.store.dayID].stops[i].coordinates = [this.waypoints[i].lat, this.waypoints[i].lng];
                    this.$emit('changeStopInfo', i);
                }
            });
        },

        addWaypoint(x, y) {
            const newWaypoint = L.latLng(x, y);
            this.waypoints.push(newWaypoint);

            // copy existing waypoints and update routing control waypoints
            if (this.routingControl) {
                this.routingControl.setWaypoints(this.waypoints.slice());
            }
            //store
            const stopID = this.waypoints.length - 1;
            this.store.profile[this.store.tripID].days[this.store.dayID].stops[stopID].coordinates = [this.waypoints[stopID].lat, this.waypoints[stopID].lng];
            return stopID;

        },
        removeWaypoint(index) {
            if (index >= 0 && index < this.waypoints.length) {
                this.waypoints.splice(index, 1);
                if (this.routingControl) {
                    this.routingControl.setWaypoints(this.waypoints.slice());
                }
            }
        }
    },
    mounted() {
        this.initializeMap();
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