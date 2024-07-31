<script>
import Api from './Api.vue';
import Start from './Start.vue';
import TripInfo from './TripInfo.vue';
import Map from './Map.vue';
import StopInfo from './StopInfo.vue';
import { store } from './../store';
export default {
    components: {
        Api,
        Start,
        TripInfo,
        Map,
        StopInfo
    },
    data() {
        return {
            store,
            riRender: 0
        }
    },
    methods: {
        createWaypoint(){
            this.$refs.api.createStop(this.store.profileID, this.store.tripID, this.store.dayID);
        },
        removeWaypoint(i){
            this.$refs.map.removeWaypoint(i);
        },
        renameDayTitle(){
            this.$refs.api.renameDayTitle(this.store.profileID, this.store.tripID, this.store.dayID, this.store.profile[this.store.tripID].days[this.store.dayID].title);
        },
        deleteDay(){
            this.$refs.api.deleteDay(this.store.profileID, this.store.tripID, this.store.dayID);
            //this.store.dayID = null;
            this.store.stopID = null;
        },
        createTrip(){
            this.$refs.api.createTrip(this.store.profileID);
        },
        selectStop(i){
            this.store.stopID = i;
        },
        changeStopInfo(i = null){
            console.log(i);  
            let stopID = i;
            if(i != null){
               this.$refs.api.changeStopInfo(this.store.profileID, this.store.tripID, this.store.dayID, stopID, null, null, null, this.store.profile[this.store.tripID].days[this.store.dayID].stops[stopID].coordinates.join('b'));
            }
        },
        riRenderFn(){
            this.riRender++;
        }
    }
};
</script>

<template>
    <Api ref="api" @addWaypoint="changeStopInfo"></Api>
    <div class="container">
        <main>
            <div class="box-mc d-flex">
                <!-- new profile -->
                <Start v-if="store.profileID == null"></Start>
                <!-- End new profile -->
                <!-- Box Left -->
                <div class="col-5 bg-light-subtle p-2 position-relative">
                    <TripInfo v-if="store.profile != null && store.tripID != null" @riRenderFn="riRenderFn"></TripInfo>
                    <div v-else-if="store.profile != null && store.profile.length == 0">
                        <button @click="createTrip" class="btn btn-primary">Crea un viaggio</button>
                    </div>
                </div>
                <!-- End Box Left -->
                <!-- Box Right -->
                <div class="col-7 bg-secondary">
                    <!-- Map + Info -->
                    <div class="map bg-success ">
                        <div v-if="store.dayID != null" class="current-day position-absolute top-0 start-0 ps-5 pe-1 d-flex justify-content-between align-items-center w-100">
                            <input @blur="renameDayTitle" type="text" class="form-control border-0 fs-4 fw-bold bg-transparent shadow-none w-auto text-dark" aria-describedby="name" placeholder="Nome" v-model="store.profile[store.tripID].days[store.dayID].title">
                            <button @click="deleteDay" class="btn btn-danger btn px-3">x</button>
                        </div>
                        <Map ref="map" v-if="!store.stopView" @changeStopInfo="changeStopInfo" :key="riRender"></Map>
                        <div class="stop-info" v-if="store.stopView"><StopInfo @removeWaypoint="removeWaypoint"></StopInfo></div>
                    </div>
                    <!-- End Map + Info -->
                    <!-- Stops + Buttons -->
                    <div v-if="store.dayID != null">
                        <button class="btn btn-info"  @click="store.stopView = !store.stopView">!</button>
                        <button class="btn btn-primary"  @click="createWaypoint">+</button>
                        <button class="btn btn-primary"  @click="removeWaypoint(1)">-</button>
                        <ul>
                            <li v-for="(stop, key) in store.profile[store.tripID].days[store.dayID].stops" @click="selectStop(key)" role="button">{{ stop.title }}</li>
                        </ul>
                    </div>
                    <!-- Stops + Buttons -->
                </div>
                <!-- End Box Right -->
            </div>
        </main>
    </div>
</template>
<style scoped lang="scss">
main {
    .box-mc{
        position: relative;
        margin-top: 50px;
        height: calc(100vh - 156px);
        .map,
        .stop-info{
            height: 75%;
            position: relative;
            .current-day{
                z-index: 9998;
            }
        }
    }
}
</style>