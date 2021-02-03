<template>

    <!--<ul class="pagination" v-if="shouldPaginate">-->
    <ul class="pagination">
        <!--<li v-show="prevUrl">-->
        <li class="page-item">
            <!--<a href="#" aria-label="Previous" rel="prev" @click.prevent="page&#45;&#45;">-->
            <a href="#" aria-label="Previous" rel="prev" class="page-link">
                <span aria-hidden="true">&laquo; Previous</span>
            </a>
        </li>
        <!--<li v-show="nextUrl">-->
        <li class="page-item">
            <!--<a href="#" aria-label="Next" rel="next" @click.prevent="page++">-->
            <a href="#" aria-label="Next" rel="next" class="page-link">
                <span aria-hidden="true">Next &raquo;</span>
            </a>
        </li>
    </ul>

</template>

<script>
    export default{

    }
</script>