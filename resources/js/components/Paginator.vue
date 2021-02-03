<template>

    <ul class="pagination" v-if="shouldPaginate">
        <li v-show="prevUrl" class="page-item">

            <!--<a href="#" aria-label="Previous" rel="prev" @click.prevent="page&#45;&#45;">-->
            <a href="#" aria-label="Previous" rel="prev" class="page-link">
                <span aria-hidden="true">&laquo; Previous</span>
            </a>
        </li>
        <li v-show="nextUrl" class="page-item">

            <!--<a href="#" aria-label="Next" rel="next" @click.prevent="page++">-->
            <a href="#" aria-label="Next" rel="next" class="page-link">
                <span aria-hidden="true">Next &raquo;</span>
            </a>
        </li>
    </ul>

</template>

<script>
    export default{
        props: ['dataSet'],

        data() {
            return {
                page: 1,
                prevUrl: false,
                nextUrl: false
            }
        },

        watch: {
            dataSet() {
                this.page = this.dataSet.current_page;
                this.prevUrl = this.dataSet.prev_page_url;
                this.nextUrl = this.dataSet.next_page_url;
            },

//            page() {
//                this.broadcast().updateUrl();
//            }
        },

        computed: {
            shouldPaginate() {
                return !! this.prevUrl || !! this.nextUrl;
            }
        },

    }
</script>