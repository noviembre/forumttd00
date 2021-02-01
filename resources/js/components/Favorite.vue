<template>
    <button type="submit" class="btn btn-secondary btn-sm" @click="toggle">
        <span class="fa fa-heart"></span>
        <span v-text="favoritesCount"></span>
    </button>
</template>

<script>
    export default{
        props: ['reply'],

        data(){
            return {
                favoritesCount: this.reply.favoritesCount,
            }
        },

        methods: {
            toggle(){
                if(this.isFavorited){
                    axios.delete('/replies/' + this.reply.id + '/favorites')
                } else {
                    axios.post('/replies/' + this.reply.id + '/favorites')
                }
            }
        }
    }


</script>