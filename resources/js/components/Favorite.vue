<template>
    <button type="submit" :class="classes" @click="toggle">
        <span class="fa fa-heart"></span>
        <span v-text="contador"></span>
    </button>
</template>

<script>
    export default{
        props: ['reply'],

        data(){
            return {
                contador: this.reply.favoritesCount,
                active: this.reply.isFavorited
            }
        },

        computed: {
            classes(){
                return ['btn', this.active ? 'btn-warning btn-sm' : 'btn-secondary btn-sm']
            },

            endpoint(){
                return '/replies/' + this.reply.id + '/favorites';
            }

        },

        methods: {
            toggle(){
                this.active ? this.destroy() : this.create();
            },

            create(){
                axios.post(this.endpoint);
                this.active = true;
                this.contador++;
            },

            destroy(){
                axios.delete(this.endpoint);
                this.active = false;
                this.contador--;
            }
        }
    }


</script>