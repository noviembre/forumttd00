<template>
    <button type="submit" :class="classes" @click="toggle">
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
                isFavorited:false
            }
        },

        computed: {
            classes(){
                return ['btn', this.isFavorited ? 'btn-warning btn-sm' : 'btn-secondary btn-sm']
            }
        },

        methods: {
            toggle(){
                if (this.isFavorited) {
                    axios.delete('/replies/' + this.reply.id + '/favorites')
                } else {
                    axios.post('/replies/' + this.reply.id + '/favorites');
                    this.isFavorited = true;
                    this.favoritesCount++;
                }
            }
        }
    }


</script>