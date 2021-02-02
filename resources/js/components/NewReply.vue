<template>
    <div>
        <div v-if="signedIn">
            <div class="form-group">
        <textarea
                name="body"
                id="body"
                rows="5"
                placeholder="Something to say?"
                class="form-control"
                required
                v-model="body"></textarea>
            </div>



            <button
                type="submit"
                class="btn btn-primary"
                @click="addReply">Post</button>
        </div>


        <!--<p class="text-center">Please-->
        <!--<a href="{{ route('login') }}">Sign in</a>-->
        <!--to participate in this discussion-->
        <!--</p>-->

    </div>
</template>

<script>
    export default{
        data(){
            return {
                body: '',
                endpoint: '/threads/et/1/replies'
            };
        },

        computed:{
            signedIn(){
                return window.App.signedIn;
            }
        },

        methods: {
            addReply(){
                axios.post(this.endpoint, {body: this.body})
                    .then(({data}) =>{
                        this.body = '';

                        flash('Your reply has been posted');
                        this.$emit('created', data);
                    });
            }
        }
    }
</script>