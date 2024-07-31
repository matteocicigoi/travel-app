<script>
import Api from './Api.vue';
import { store } from './../store';
export default {
    emits: ['riRenderFn'],
    components: {
        Api
    },
    data() {
        return {
            store,
            tripName : store.profile[store.tripID].name,
            date: null
        }
    },
    methods: {
        renameTitle(){
            this.$refs.api.renameTripTitle(this.store.profileID, this.store.tripID, this.tripName);
        },
        addDay(){
            this.$refs.api.createDay(this.store.profileID, this.store.tripID, this.date);
        },
        changeDay(dayID){
            this.$refs.api.changeDay(this.store.profileID, this.store.tripID, dayID, this.store.profile[store.tripID].days[dayID].day);
        },
        setDay(dayID){
            this.store.dayID = dayID;
            this.store.stopID = null;
            this.$emit('riRenderFn');

        },
        deleteTrip(){
            this.$refs.api.deleteTrip(this.store.profileID, this.store.tripID);
        }
    }
};
</script>

<template>
    <Api ref="api"></Api>
    <input @blur="renameTitle" type="text" class="form-control border-0 fs-2 fw-bold p-0 bg-transparent shadow-none mb-2" aria-describedby="name" placeholder="Nome" v-model="tripName">
    <div class="days">
        <ul>
            <li v-for="(day, key) in store.profile[store.tripID].days" class="d-flex mb-1 align-items-center"><input @focus="setDay(key)" @blur="changeDay(key)" type="date" class="form-control border-0 fs-5 fw-bold p-0 bg-transparent shadow-none w-auto" aria-describedby="name" placeholder="Nome" v-model="day.day"></li>
        </ul>
        <div class="input-group">
            <input type="date" id="start" name="trip-start" class="border rounded px-2 bg-primary" v-model="date"/>
            <button class="btn btn-primary ms-1 rounded" @click="addDay">+</button>
        </div>
    </div>
    <div>
        <button @click="deleteTrip" class="btn btn-danger position-absolute top-0 end-0 m-2 px-3">x</button>
    </div>
</template>