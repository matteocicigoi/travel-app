<script>
import { store } from './../store';
import axios from 'axios';
export default {
    emits: ['addWaypoint'],
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
                if (trip) {
                    this.createTrip(response.data.profileID);
                }
            });
        },
        createTrip(profileID) {
            axios.get(this.store.url, {
                params: {
                    method: 'createTrip',
                    profileID: profileID
                }
            }).then((response) => {
                this.getProfile(profileID, 'max');
            });
        },
        getProfile(profileID, trip = true, emit = false) {
            axios.get(this.store.url, {
                params: {
                    method: 'getProfile',
                    profileID: profileID
                }
            }).then((response) => {
                if (response.data.error) {
                    if (response.data.error == 'true') {
                        localStorage.removeItem('profileID');
                        this.store.profileID = null;
                        return;
                    }
                }
                this.store.profile = response.data.profile;
                if (this.store.profileID == null) {
                    this.store.profileID = profileID;
                }
                localStorage.setItem('profileID', profileID);
                if (trip) {
                    if (trip == 'max'){
                        this.store.tripID = this.store.profile.length - 1;
                    }else{
                        if (this.store.profile.length == 0) {
                            this.createTrip(profileID);
                        } else {
                            this.store.tripID = 0;
                        }
                    }
                }
                if (emit) {
                    this.$emit('addWaypoint');
                }
            });
        },
        renameTripTitle(profileID, tripID, newName) {
            axios.get(this.store.url, {
                params: {
                    method: 'renameTripTitle',
                    profileID: profileID,
                    tripID: tripID,
                    newName: newName
                }
            }).then((response) => {
            });
        },
        createDay(profileID, tripID, day) {
            axios.get(this.store.url, {
                params: {
                    method: 'createDay',
                    profileID: profileID,
                    tripID: tripID,
                    day: day
                }
            }).then((response) => {
                this.getProfile(profileID, false);
            });
        },
        changeDay(profileID, tripID, dayID, newDay) {
            axios.get(this.store.url, {
                params: {
                    method: 'changeDay',
                    profileID: profileID,
                    tripID: tripID,
                    dayID: dayID,
                    newDay: newDay
                }
            }).then((response) => {
            });
        },
        renameDayTitle(profileID, tripID, dayID, newTitle) {
            axios.get(this.store.url, {
                params: {
                    method: 'renameDayTitle',
                    profileID: profileID,
                    tripID: tripID,
                    dayID: dayID,
                    newTitle: newTitle
                }
            }).then((response) => {
            });
        },
        createStop(profileID, tripID, dayID) {
            axios.get(this.store.url, {
                params: {
                    method: 'createStop',
                    profileID: profileID,
                    tripID: tripID,
                    dayID: dayID
                }
            }).then((response) => {
                this.getProfile(profileID, null, true);
            });
        },
        changeStopInfo(profileID, tripID, dayID, stopID, newTitle = null, newDescription = null, newRating = null, newCoordinates = null) {
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
            });
        },
        deleteDay(profileID, tripID, dayID) {
            axios.get(this.store.url, {
                params: {
                    method: 'deleteDay',
                    profileID: profileID,
                    tripID: tripID,
                    dayID: dayID
                }
            }).then((response) => {
                this.store.dayID = null;
                this.getProfile(profileID, null);
            });
        },
        deleteTrip(profileID, tripID) {
            axios.get(this.store.url, {
                params: {
                    method: 'deleteTrip',
                    profileID: profileID,
                    tripID: tripID
                }
            }).then((response) => {
                this.store.tripID = null;
                this.store.dayID = null;
                this.getProfile(profileID, null);
            });
        },
        deleteStop(profileID, tripID, dayID, stopID) {
            axios.get(this.store.url, {
                params: {
                    method: 'deleteStop',
                    profileID: profileID,
                    tripID: tripID,
                    dayID: dayID,
                    stopID: stopID
                }
            }).then((response) => {
                this.store.stopID = null;
                this.store.stopView = false;
                this.getProfile(profileID, null);
            });
        }
    }
};
</script>

<template>
</template>