<template>
    <div class="alert alert-warning alert-flash">
      <strong>Success!</strong>
        {{ body}}
    </div>
</template>

<script>
    export default {
        data() {
            return {
                body: 'Temp for now'
            }
        }
    }
</script>

<style>
    .alert-flash{
        position:fixed;
        right:25px;
        bottom:25px;
    }
</style>