<script>
import Api from './Api.vue';
import { store } from './../store';
export default {
    emits: ['removeWaypoint'],
    components: {
        Api
    },
    data() {
        return {
            store
        }
    },
    methods: {
        changeStopInfo() {
            this.$refs.api.changeStopInfo(this.store.profileID, this.store.tripID, this.store.dayID, this.store.stopID, this.store.profile[this.store.tripID].days[this.store.dayID].stops[this.store.stopID].title, this.store.profile[this.store.tripID].days[this.store.dayID].stops[this.store.stopID].description, this.store.profile[this.store.tripID].days[this.store.dayID].stops[this.store.stopID].rating, this.store.profile[this.store.tripID].days[this.store.dayID].stops[this.store.stopID].coordinates.join('b'));
        },
        deleteStop() {
            this.$refs.api.deleteStop(this.store.profileID, this.store.tripID, this.store.dayID, this.store.stopID);
            this.$emit('removeWaypoint', this.store.stopID);
            this.store.stopID = null; 
        },
        getRating(i){
            if(i <= this.store.profile[this.store.tripID].days[this.store.dayID].stops[this.store.stopID].rating){
                return '★';
            }else{
                return '☆';
            }
        },
        setRating(i){
            this.store.profile[this.store.tripID].days[this.store.dayID].stops[this.store.stopID].rating = i;
            this.$refs.api.changeStopInfo(this.store.profileID, this.store.tripID, this.store.dayID, this.store.stopID, null, null, this.store.profile[this.store.tripID].days[this.store.dayID].stops[this.store.stopID].rating);
        }
    }
};
</script>
<template>
    <Api ref="api"></Api>
    <div class="pt-5 ps-4" v-if="store.stopID != null &&  this.store.profile[this.store.tripID].days[this.store.dayID].stops.length > 0">
        <input @blur="changeStopInfo" type="text"
            class="form-control border-0 fs-5 fw-bold p-0 bg-transparent shadow-none mb-2 w-auto"
            aria-describedby="stop" placeholder="titolo"
            v-model="store.profile[store.tripID].days[store.dayID].stops[store.stopID].title">
        <button @click="deleteStop" class="btn btn-danger">x</button>
        <input @blur="changeStopInfo" type="text"
            class="form-control border-0 fs-5 fw-bold p-0 bg-transparent shadow-none mb-2 w-auto"
            aria-describedby="stop" placeholder="descrizione"
            v-model="store.profile[store.tripID].days[store.dayID].stops[store.stopID].description">
        <input @blur="changeStopInfo" type="text"
            class="form-control border-0 fs-5 fw-bold p-0 bg-transparent shadow-none mb-2 w-auto"
            aria-describedby="stop" placeholder="latitudine"
            v-model="store.profile[store.tripID].days[store.dayID].stops[store.stopID].coordinates[0]">
        <input @blur="changeStopInfo" type="text"
            class="form-control border-0 fs-5 fw-bold p-0 bg-transparent shadow-none mb-2 w-auto"
            aria-describedby="stop" placeholder="longitudine"
            v-model="store.profile[store.tripID].days[store.dayID].stops[store.stopID].coordinates[1]">
        <ul class="ps-0">
            <li v-for="i in 5" @click="setRating(i)" role="button" class="list-unstyled d-inline h3">{{ getRating(i) }}</li>
        </ul>
    </div>
</template>