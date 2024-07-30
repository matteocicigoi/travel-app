<script>
import { store } from './../store';
import axios from 'axios';
export default {
    data() {
        return {
            store
        }
    },
    methods: {
        createProfile(trip = false) {
            axios.get(this.store.url, {
                params: {
                    method: 'createProfile'
                }
            }).then((response) => {
                this.store.profileID = response.data.profileID;
                if(trip){
                    this.createTrip(response.data.profileID);
                }else{
                    console.log(response.data.profileID);
                }
            });
        },
        createTrip(profileID){
            axios.get(this.store.url, {
                params: {
                    method: 'createTrip',
                    profileID: profileID
                }
            }).then((response) => {
                this.getProfile(profileID);
            });
        },
        getProfile(profileID, trip = true){
            axios.get(this.store.url, {
                params: {
                    method: 'getProfile',
                    profileID: profileID
                }
            }).then((response) => {
                this.store.profile = response.data.profile;
                if(this.store.profileID == null){
                    this.store.profileID = profileID;
                }
                if(trip){
                    if(this.store.profile.length == 0){
                        this.createTrip(profileID);
                    }else{
                        this.store.tripID = 0;
                    }
                }
            });
        },
        renameTripTitle(profileID, tripID, newName){
            axios.get(this.store.url, {
                params: {
                    method: 'renameTripTitle',
                    profileID: profileID,
                    tripID: tripID,
                    newName: newName
                }
            }).then((response) => {
                console.log(response);
            });
        },
        createDay(profileID, tripID, day){
            axios.get(this.store.url, {
                params: {
                    method: 'createDay',
                    profileID: profileID,
                    tripID: tripID,
                    day: day
                }
            }).then((response) => {
                this.getProfile(profileID);
            });
        },
        changeDay(profileID, tripID, dayID, newDay){
            axios.get(this.store.url, {
                params: {
                    method: 'changeDay',
                    profileID: profileID,
                    tripID: tripID,
                    dayID: dayID,
                    newDay: newDay
                }
            }).then((response) => {
                console.log(response);
            });
        },
        renameDayTitle(profileID, tripID, dayID, newTitle){
            axios.get(this.store.url, {
                params: {
                    method: 'renameDayTitle',
                    profileID: profileID,
                    tripID: tripID,
                    dayID: dayID,
                    newTitle: newTitle
                }
            }).then((response) => {
                console.log(response);
            });
        },
        createStop(profileID, tripID, dayID){
            axios.get(this.store.url, {
                params: {
                    method: 'createStop',
                    profileID: profileID,
                    tripID: tripID,
                    dayID: dayID
                }
            }).then((response) => {
                console.log(response);
                this.getProfile(profileID);
            });
        },
        changeStopInfo(profileID, tripID, dayID, stopID, newTitle = null, newDescription = null, newRating = null, newCoordinates = null){
            axios.get(this.store.url, {
                params: {
                    method: 'changeStopInfo',
                    profileID: profileID,
                    tripID: tripID,
                    dayID: dayID,
                    stopID: stopID,
                    newTitle: newTitle,
                    newDescription: newDescription,
                    newRating: newRating,
                    newCoordinates: newCoordinates
                }
            }).then((response) => {
                console.log(response);
            });
        },
        deleteDay(profileID, tripID, dayID){
            axios.get(this.store.url, {
                params: {
                    method: 'deleteDay',
                    profileID: profileID,
                    tripID: tripID,
                    dayID: dayID
                }
            }).then((response) => {
                console.log(response);
                this.store.dayID = null;
                this.getProfile(profileID);
            });
        },
        deleteTrip(profileID, tripID){
            console.log(21);
            axios.get(this.store.url, {
                params: {
                    method: 'deleteTrip',
                    profileID: profileID,
                    tripID: tripID
                }
            }).then((response) => {
                console.log(response);
                this.store.tripID = null;
                this.store.dayID = null;
                this.getProfile(profileID, false);
            });
        }
    }
};
</script>

<template>
</template>