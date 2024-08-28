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
            blur: true,
            id: null
        }
    },
    methods: {
        showBlur() {
            this.blur = !this.blur;
        },
        getProfile(){
            this.$refs.api.getProfile(this.id);
        },
        closeProfile(){
            this.$emit('riRenderFn');
            this.store.stopView = false;
            this.store.stopID = null;
            this.store.dayID = null;
            this.store.tripID = null;
            this.store.profileID = null;
            this.store.profile = null;
            localStorage.removeItem('profileID');
        },
        createTrip(){
            this.$refs.api.createTrip(this.store.profileID);
        },
        selectTrip(tripID){
            this.store.tripID = tripID;
            this.store.dayID = null;
            this.store.stopView = false;
            this.store.stopID = null;
        }
    },
    mounted(){
        if(localStorage.getItem("profileID") != null){
            this.$refs.api.getProfile(localStorage.getItem('profileID'));
        }
    }
};
</script>

<template>
    <Api ref="api"></Api>
    <header>
        <nav class="navbar navbar-expand-lg bg-body-tertiary">
            <div class="container-fluid">
                <!-- Title -->
                <a class="navbar-brand" href="#">Travel App</a>
                <!-- End Title -->
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Trips -->
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0" v-if="store.profile != null">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                Viaggi
                            </a>
                            <ul class="dropdown-menu">
                                <li v-for="trip, key in store.profile"><a class="dropdown-item" href="#" @click="selectTrip(key)">{{ trip.name }}</a></li>
                                <li><hr class="dropdown-divider" store.></li>
                                <li><a class="dropdown-item" href="#" @click="createTrip">Aggiungi Viaggo</a></li>
                            </ul>
                        </li>
                    </ul>
                    <!-- End Trips -->
                    <form class="d-flex" role="search" v-if="store.profileID == null">
                        <input class="form-control me-2" type="search" placeholder="id" aria-label="id" v-model="id">
                        <button class="btn btn-outline-success" type="submit" @click.prevent="getProfile">Carica</button>
                    </form>
                    <!-- ID -->
                    <li class="profile-id" :class="{blur: blur}" @click="showBlur">{{ store.profileID }}</li>
                    <button class="btn btn-warning ms-3" @click="closeProfile" v-if="store.profile != null">x</button>
                    <!-- End ID -->
                </div>
            </div>
        </nav>
    </header>
</template>

<style scoped lang="scss">
.profile-id {
    list-style-type: none;
}
.blur {
    filter: blur(3px);
}
</style>