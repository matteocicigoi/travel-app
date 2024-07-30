<script>
import Api from './Api.vue';
export default {
    components: {
        Api
    },
    methods: {
        createProfileAndTrip(){
            this.$refs.api.createProfile(true);
        }
    }
};
</script>

<template>
    <Api ref="api"></Api>
    <div class="start d-flex justify-content-center align-items-center">
        <button class="btn btn-primary btn-lg" @click="createProfileAndTrip">Crea un viaggio</button>
    </div>
</template>

<style scoped lang="scss">
.start {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(255,255,255, 0.5);
    z-index: 9999;
}
</style>