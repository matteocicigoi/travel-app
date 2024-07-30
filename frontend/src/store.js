import { reactive } from "vue";

export const store = reactive({
    url: 'http://localhost/backend/index.php',
    profileID: null,
    tripID: null,
    profile: null,
    dayID: null
});