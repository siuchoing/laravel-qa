<template>
    <div>
        <div class="card-body">
            <div v-if="questions.length">
                <question-excerpt
                    @deleted="remove(index)"
                    v-for="(question, index) in questions"
                    :question="question"
                    :key="question.id"></question-excerpt>
            </div>
            <div v-else class="alert alert-warning">
                <strong>Sorry</strong> There are no questions available.
            </div>

            <div class="card-footer">
                <pagination :meta="meta" :links="links"></pagination>
            </div>
        </div>
    </div>
</template>

<script>
    import QuestionExcerpt from './QuestionExcerpt.vue'
    import Pagination from './Pagination.vue'

    export default {
        components: {
            QuestionExcerpt,
            Pagination
        },

        data () {
            return {
                questions: [],
                meta: {},
                links: {}
            }
        },

        mounted () {
            this.fetchQuestions();
        },

        methods: {
            // Watch the route change
            fetchQuestions () {
                axios.get('/questions', { params: this.$route.query })
                    .then(({ data }) => {
                        this.questions = data.data;
                        this.links = data.links;
                        this.meta = data.meta;
                    })
            },

            remove (index) {
                this.questions.splice(index, 1)
                this.count--
            }
        },

        watch: {
            "$route": 'fetchQuestions'
        }
    }
</script>
