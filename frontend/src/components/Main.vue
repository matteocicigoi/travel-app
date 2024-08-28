<script>
import Api from './Api.vue';
import Start from './Start.vue';
import TripInfo from './TripInfo.vue';
import Map from './Map.vue';
import StopInfo from './StopInfo.vue';
import { store } from './../store';
import cities from './../cities';
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
            cities,
            riRender: 0,
            searchValue: '',
            viewlistSearch: false,
            selectedCityInfo: null
        }
    },
    methods: {
        createWaypoint() {
            this.$refs.api.createStop(this.store.profileID, this.store.tripID, this.store.dayID);
        },
        removeWaypoint(i) {
            //this.$refs.map.removeWaypoint(i);
        },
        renameDayTitle() {
            this.$refs.api.renameDayTitle(this.store.profileID, this.store.tripID, this.store.dayID, this.store.profile[this.store.tripID].days[this.store.dayID].title);
        },
        deleteDay() {
            this.$refs.api.deleteDay(this.store.profileID, this.store.tripID, this.store.dayID);
            //this.store.dayID = null;
            this.store.stopID = null;
        },
        createTrip() {
            this.$refs.api.createTrip(this.store.profileID);
        },
        selectStop(i) {
            this.store.stopID = i;
        },
        changeStopInfo(i = null) {
            let stopID = i;
            if (i != null) {
                this.$refs.api.changeStopInfo(this.store.profileID, this.store.tripID, this.store.dayID, stopID, null, null, null, this.store.profile[this.store.tripID].days[this.store.dayID].stops[stopID].coordinates.join('b'));
            } else {
                this.$refs.api.changeStopInfo(this.store.profileID, this.store.tripID, this.store.dayID, this.store.profile[store.tripID].days[this.store.dayID].stops.length - 1, null, this.selectedCityInfo.city, null, [this.selectedCityInfo.lat, this.selectedCityInfo.lng].join('b'));
                this.$refs.api.getProfile(this.store.profileID, null);
                this.selectedCityInfo = null;
                this.searchValue = '';
            }
        },
        riRenderFn() {
            this.riRender++;
        },
        searchCity() {
            const citFilt = this.cities.filter((city) => {
                if (this.searchValue != '' && city.city.toLowerCase().includes(this.searchValue.toLowerCase())) {
                    return city;
                }
            });
            citFilt.sort((a, b) => {
                const first = a.city.toLowerCase() === this.searchValue;
                const second = b.city.toLowerCase() === this.searchValue;
                if (first && !second) {
                    return -1;
                } else if (!first && second) {
                    return 1;
                } else {
                    return 0;
                }
            });
            if (citFilt.length >= 5) {
                return citFilt.slice(0, 5);
            }
            return citFilt;
        },
        selectedCity(city) {
            this.searchValue = city.city;
            this.viewlistSearch = false;
            this.selectedCityInfo = city;
        },
        setColor(city) {
            const regex = new RegExp(`(${this.searchValue})`, 'gi'); // Case-insensitive search
            return city.city.replace(regex, (match) => `<span class="imp" style="color:red">${match}</span>`) + ` - ${city.admin_name} - ${city.country}`;
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
                <div class="col-5 bg-light-subtle p-2 position-relative overflow-auto">
                    <TripInfo v-if="store.profile != null && store.tripID != null" @riRenderFn="riRenderFn"></TripInfo>
                    <div v-else-if="store.profile != null && store.profile.length == 0">
                        <button @click="createTrip" class="btn btn-primary">Crea un viaggio</button>
                    </div>
                    <div v-if="store.profile != null && store.tripID == null && store.profile.length > 0"
                        class="alert alert-info" role="alert">
                        Seleziona un viaggio dal menu
                    </div>
                </div>
                <!-- End Box Left -->
                <!-- Box Right -->
                <div class="col-7 bg-secondary overflow-auto">
                    <!-- Map + Info -->
                    <div class="map bg-success ">
                        <div v-if="store.dayID != null"
                            class="current-day position-absolute top-0 start-0 ps-5 pe-1 d-flex justify-content-between align-items-center w-100">
                            <input @blur="renameDayTitle" type="text"
                                class="form-control border-0 fs-4 fw-bold bg-transparent shadow-none w-auto text-dark"
                                aria-describedby="name" placeholder="Nome"
                                v-model="store.profile[store.tripID].days[store.dayID].title">
                            <button @click="deleteDay" class="btn btn-danger btn px-3">x</button>
                        </div>
                        <Map ref="map" v-if="!store.stopView" @changeStopInfo="changeStopInfo" :key="riRender"></Map>
                        <div class="stop-info" v-if="store.stopView">
                            <StopInfo @removeWaypoint="removeWaypoint"></StopInfo>
                        </div>
                    </div>
                    <!-- End Map + Info -->
                    <!-- Stops + Buttons -->
                    <div v-if="store.dayID != null">
                        <button class="btn btn-info" @click="store.stopView = !store.stopView">!</button>
                        <div v-if="store.stopView == false" class="addwaypoint d-flex flex-wrap">
                            <input @focus="viewlistSearch = true" type="search"
                                class="form-control border-0 fs-5 fw-bold shadow-none w-auto text-white"
                                aria-describedby="cerca" placeholder="cerca" v-model="searchValue">
                            <button class="btn btn-primary" @click="createWaypoint" :disabled="selectedCityInfo == null">+</button>
                            <ul @focus="viewlistSearch = true" @blur="viewlistSearch = false" class="col-12 list-unstyled"
                                v-if="viewlistSearch">
                                <li v-for="city in searchCity()" @click="selectedCity(city)" v-html="setColor(city)" role="button" class=" text-dark w-50" style="background-color: rgba(255,255,255,0.7)">
                                </li>
                            </ul>
                        </div>
                        <ul>
                            <li v-for="(stop, key) in store.profile[store.tripID].days[store.dayID].stops"
                                @click="selectStop(key)" role="button">{{ stop.title }}</li>
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
    .box-mc {
        position: relative;
        margin-top: 50px;
        height: calc(100vh - 156px);

        .map,
        .stop-info {
            height: 75%;
            position: relative;

            .current-day {
                z-index: 9998;
            }
        }
    }
}
</style>