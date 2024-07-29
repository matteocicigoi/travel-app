<script>
import testApi from './components/testApi.vue';
import { store } from './store';
export default {
  components: {
    testApi
  },
  data() {
        return {
            store
        }
    }
}
</script>

<template>
    <testApi></testApi>
</template>