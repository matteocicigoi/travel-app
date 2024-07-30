<script>
import Api from './Api.vue';
import Start from './Start.vue';
import TripInfo from './TripInfo.vue';
import Map from './Map.vue';
import { store } from './../store';
export default {
    components: {
        Api,
        Start,
        TripInfo,
        Map
    },
    data() {
        return {
            store
        }
    },
    methods: {
        addWaypoint(){
            this.$refs.api.createStop(this.store.profileID, this.store.tripID, this.store.dayID);
            //this.$refs.map.addWaypoint();
        },
        removeWaypoint(i){
            this.$refs.map.removeWaypoint(i);
        },
        renameDayTitle(){
            this.$refs.api.renameDayTitle(this.store.profileID, this.store.tripID, this.store.dayID, this.store.profile[this.store.tripID].days[this.store.dayID].title);
        },
        changeStopInfo(stopID){
            this.$refs.api.changeStopInfo(this.store.profileID, this.store.tripID, this.store.dayID, stopID, this.store.profile[this.store.tripID].days[this.store.dayID].stops[stopID].title);
        },
        deleteDay(){
            this.$refs.api.deleteDay(this.store.profileID, this.store.tripID, this.store.dayID);
        },
        createTrip(){
            this.$refs.api.createTrip(this.store.profileID);
        }
    }
};
</script>

<template>
    <Api ref="api"></Api>
    <div class="container">
        <main>
            <div class="box-mc d-flex">
                <Start v-if="store.profileID == null"></Start>
                <div class="col-5 bg-light-subtle p-2 position-relative">
                    <TripInfo v-if="store.profile != null && store.tripID != null"></TripInfo>
                    <div v-else-if="store.profile != null && store.profile.length == 0">
                        <button @click="createTrip" class="btn btn-primary">Crea un viaggio</button>
                    </div>
                </div>
                <div class="col-7 bg-secondary">
                    <div class="map bg-success ">
                        <div v-if="store.dayID != null" class="current-day position-absolute top-0 start-0 ps-5 pe-1 d-flex justify-content-between align-items-center w-100">
                            <input @blur="renameDayTitle" type="text" class="form-control border-0 fs-4 fw-bold bg-transparent shadow-none w-auto text-dark" aria-describedby="name" placeholder="Nome" v-model="store.profile[store.tripID].days[store.dayID].title">
                            <button @click="deleteDay" class="btn btn-danger btn px-3">x</button>
                        </div>
                        <Map ref="map"></Map>
                    </div>
                    <div v-if="store.dayID != null">
                        <button class="btn btn-primary"  @click="addWaypoint">+</button>
                        <button class="btn btn-primary"  @click="removeWaypoint(1)">-</button>
                        <ul>
                            <li v-for="(stop, key) in store.profile[store.tripID].days[store.dayID].stops"><input @blur="changeStopInfo(key)" type="text" class="form-control border-0 fs-5 fw-bold p-0 bg-transparent shadow-none mb-2 w-auto" aria-describedby="stop" placeholder="stop" v-model="stop.title"></li>
                        </ul>
                    </div>
                </div>
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
        .map{
            height: 75%;
            position: relative;
            .current-day{
                z-index: 9998;
            }
        }
    }
}
</style>