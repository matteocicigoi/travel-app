<script>
import Api from './Api.vue';
import { store } from './../store';
export default {
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
        }
    }
};
</script>

<template>
    <Api ref="api"></Api>
    <header>
        <nav class="navbar navbar-expand-lg bg-body-tertiary">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">Travel App</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                Viaggi
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#">1</a></li>
                                <li><a class="dropdown-item" href="#">2</a></li>
                            </ul>
                        </li>
                    </ul>
                    <form class="d-flex" role="search" v-if="store.profileID == null">
                        <input class="form-control me-2" type="search" placeholder="id" aria-label="id" v-model="id">
                        <button class="btn btn-outline-success" type="submit" @click.prevent="getProfile">Carica</button>
                    </form>
                    <li class="profile-id" :class="{blur: blur}" @click="showBlur">{{ store.profileID }}</li>
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