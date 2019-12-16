<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <h2>All Questions</h2>
                            <div class="ml-auto">
                                <a href="#" class="btn btn-outline-secondary">Ask Question</a>
                            </div>
                        </div>

                    </div>

                    <questions></questions>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    //import QuestionExcerpt from '../components/QuestionExcerpt.vue'
    import Questions from '../components/Questions.vue'


    export default {
        //components: { QuestionExcerpt },
        components: { Questions }

        data () {
            return {
                questions: []
            }
        },

        mounted() {
            this.fetchQuestions();
        },

        methods: {
            fetchQuestions() {
                axios.get('/questions')
                    .then(({ data }) => {
                        this.questions = data.data
                    })
            }
        }
    }
</script>
