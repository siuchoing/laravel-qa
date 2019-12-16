<template>
    <div class="row align-items-center">
        <div class="col">
            <button class="btn btn-outline-secondary">Newer</button>
        </div>
        <!-- 1st column -->

        <div class="col text-center">
            Page 1 of 5
        </div>
        <!-- 2nd column -->

        <div class="col text-right">
            <button class="btn btn-outline-secondary">Older</button>
        </div>
        <!-- 3rd column -->
    </div>
</template>

<script>
    export default {
        props: ['meta', 'links']
    }
</script>
