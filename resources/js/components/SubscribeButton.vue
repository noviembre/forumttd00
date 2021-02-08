<template>
    <button class="btn btn-secondary" @click="subscribe">Subscribe</button>
</template>

<script>
    export default {

        methods: {
            subscribe() {

                axios.post(location.pathname + '/subscriptions');
                flash('subscribed');
            }
        }
    }
</script>
