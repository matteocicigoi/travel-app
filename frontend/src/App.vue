<script>
import Header from './components/Header.vue';
import Main from './components/Main.vue';

import { store } from './store';
export default {
    components: {
        Header,
        Main
    },
    data() {
        return {
            store
        }
    },
    methods: {
        riRenderFn(){
            this.$refs.main.riRenderFn();
        }
    }
}
</script>

<template>
    <Header @riRenderFn="riRenderFn"></Header>
    <Main ref="main"></Main>
</template>