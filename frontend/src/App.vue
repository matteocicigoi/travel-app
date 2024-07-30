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
    }
}
</script>

<template>
    <Header></Header>
    <Main></Main>
</template>