<template>
    <div>
        <div class="card-body">
            <div v-if="questions.length">
                <question-excerpt v-for="question in questions" :question="question" :key="question.id"></question-excerpt>
            </div>
            <div v-else class="alert alert-warning">
                <strong>Sorry</strong> There are no questions available.
            </div>

            <!-- pagination goes here -->
        </div>
    </div>
</template>

<script>
    import QuestionExcerpt from './QuestionExcerpt.vue'

    export default {
        components: { QuestionExcerpt },

        data () {
            return {
                questions: []
            }
        },

        mounted () {
            this.fetchQuestions();
        },

        methods: {
            fetchQuestions () {
                axios.get('/questions')
                    .then(({ data }) => {
                        this.questions = data.data
                    })
            }
        }
    }
</script>
