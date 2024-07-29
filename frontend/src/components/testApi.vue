<script>
import { store } from './../store';
export default {
    data() {
        return {
            store
        }
    }
};
</script>

<template>
    {{ store.test }}
</template>