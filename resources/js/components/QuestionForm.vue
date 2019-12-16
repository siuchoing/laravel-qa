<template>
    <form action="{{ route('questions.store') }}" method="post">
        @include('questions._form', ['buttonText' => "Ask Question"])
    </form>
</template>

<script>
    export default {
        name: "QuestionForm.vue"
    }
</script>

<style scoped>

</style>
